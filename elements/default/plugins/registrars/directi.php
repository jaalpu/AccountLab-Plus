<?php

    /*
    * Copyright © 2005-2009 Cosmopoly Europe EOOD (http://netenberg.com).
    * All Rights Reserved.
    *
    * This Cosmopoly Europe EOOD work (including software, documents, or
    * other related items) is being provided by the copyright holder under
    * the following license. By obtaining, using and/or copying this work,
    * you (the licensee) agree that you have read, understood, and will
    * comply with the following terms and conditions:
    *
    * Permission to use, copy, modify, and distribute this software and its
    * documentation, with or without modification, for any purpose and
    * without fee or royalty is hereby granted, provided that you include
    * the following on ALL copies of the software and documentation or
    * portions thereof, including modifications, that you make:
    *
    * 1. The full text of this NOTICE in a location viewable to users of the
    * redistributed or derivative work.
    *
    * 2. A short notice of the following form (hypertext is preferred, text
    * is permitted) should be used within the body of any redistributed or
    * derivative code: "Copyright © 2005-2009 Cosmopoly Europe EOOD
    * (http://netenberg.com). All Rights Reserved."
    *
    * 3. Notice of any changes or modifications to the W3C files, including
    * the date changes were made. (We recommend you provide URIs to the
    * location from which the code is derived.)
    *
    * THIS SOFTWARE AND DOCUMENTATION IS PROVIDED "AS IS," AND COPYRIGHT
    * HOLDERS MAKE NO REPRESENTATIONS OR WARRANTIES, EXPRESS OR IMPLIED,
    * INCLUDING BUT NOT LIMITED TO, WARRANTIES OF MERCHANTABILITY OR FITNESS
    * FOR ANY PARTICULAR PURPOSE OR THAT THE USE OF THE SOFTWARE OR
    * DOCUMENTATION WILL NOT INFRINGE ANY THIRD PARTY PATENTS, COPYRIGHTS,
    * TRADEMARKS OR OTHER RIGHTS.
    * COPYRIGHT HOLDERS WILL NOT BE LIABLE FOR ANY DIRECT, INDIRECT, SPECIAL
    * OR CONSEQUENTIAL DAMAGES ARISING OUT OF ANY USE OF THE SOFTWARE OR
    * DOCUMENTATION.
    *
    * The name and trademarks of copyright holders may NOT be used in
    * advertising or publicity pertaining to the software without specific,
    * written prior permission. Title to copyright in this software and any
    * associated documentation will at all times remain with copyright
    * holders.
    */

    $directi_fields = array (
        array ("login"    , "0",""),
        array ("password" , "1",""),
        array ("parent_id", "0",""),
        array ("mode"     , "0",array("test_http"=>"TEST MODE (HTTP)","test_https"=>"TEST MODE (HTTPS)","live_http"=>"LIVE MODE (HTTP)","live_https"=>"LIVE MODE (HTTPS)")),
        array ("active"   , "0",array("no"=>"No","yes"=>"Yes"))
    );
    if(isset($process_domain) && $process_domain == true){
        ob_start();
        $_GET          = $this->REQUEST;
        $_POST         = $this->REQUEST;
        $sub_id        = $this->REQUEST['sub_id'];
        $diH           = new directiHandler();
        $diH->USERNAME = $this->dr_vals['directi']['login'];
        $diH->PASSWORD = $this->dr_vals['directi']['password'];
        $diH->PARENTID = $this->dr_vals['directi']['parent_id'];
        $diH->MODE     = $this->dr_vals['directi']['mode'];
        $diH->ROLE     = "reseller";
        $diH->LANGPREF = "en";
        $diH->data     = $this->REQUEST;
        $diH->chkCon();

        if($diH->iserror)
        {
            //echo "1".$diH->error_str;
            $registration_result   = $diH->error_str;
        }
        else
        {
            //Add customer start
            $existing_customer_id = "";
            $existing_contact_id  = "";
            $email                = $this->REQUEST['email'];
            $orders_for_customer  = $this->orders->get("WHERE `customers`.id=".intval($this->REQUEST['id']));
            foreach ($orders_for_customer as $order_for_customer)
            {
                if (!empty($order_for_customer['di_cust_id']))
                {
                    $existing_customer_id = $order_for_customer['di_cust_id'];
                    $existing_contact_id  = $order_for_customer['di_cont_id'];
                    break;
                }
            }

            if (empty($existing_customer_id))
            {
                $diH->data['telephone']=str_replace(",","",$this->REQUEST['telephone']);
                $diH->data['telephone']=str_replace(".","",$this->REQUEST['telephone']);
                $diH->data['telephone']=str_replace("-","",$this->REQUEST['telephone']);
                $diH->data['telephone']=str_replace("+","",$this->REQUEST['telephone']);
                $diH->data['country_code']=$this->props->phone_codes[$this->REQUEST['country']];
                if(empty($diH->data['country_code']))
                {
                    $diH->data['country_code'] = "1";
                }
                $diH->createCustomer();
            }
            else
            {
                $diH->account = $existing_customer_id;
            }
            if($diH->iserror)
            {
                //echo "2".$diH->error_str;
                $registration_result   = $diH->error_str;
            }
            else
            {
                $this->orders->update(array("sub_id"=>$sub_id,"dom_registrar"=>"directi","di_cust_id"=>$diH->account));
                //Add customer end

                //Add domain contact start
                if(empty($existing_contact_id))
                {
                    $diH->addDomContact();
                }
                else
                {
                    $diH->contact= $existing_contact_id;
                }
                if($diH->iserror)
                {
                    //echo "3".$diH->error_str;
                    $registration_result   = $diH->error_str;
                }
                else
                {
                    $this->orders->update(array("sub_id"=>$sub_id,"di_cont_id"=>$diH->contact));
                    //Add domain contact end

                    //Add domain start
                    $diH->regDomain();
                    if($diH->iserror)
                    {
                        //echo "4".$diH->error_str;
                        $registration_result   = $diH->error_str;
                    }
                    else
                    {
                        if (is_numeric($diH->entityid))
                        {
                            $output = $diH->data_array['actiontypedesc']."<br>".$diH->data_array['actionstatusdesc'];
                            $this->orders->update(array("sub_id"=>$sub_id,"dom_reg_result"=>$diH->entityid,"dom_reg_comp"=>1));
                            //Add domain end
                            //Add log start
                            $time  = date('Y-m-d H:i:s');
                            $dom   = $this->REQUEST['domain'];
                            $this->dom_reg_logs->insert(array("log_time"=>$time,"sub_id"=>$sub_id,"domain"=>$dom,"log_result"=>$output));
                            //Add log end

                            $dom         = $this->REQUEST['domain'];
                            $order       = $this->orders->getByKey($sub_id);
                            $last_result = $this->dom_reg_logs->hasAnyOne(array("WHERE `domain`='".$this->utils->quoteSmart($dom)."' ORDER BY `log_time` DESC"));
                            $registration_result = $this->props->lang['dom_reg_success'].$order['dom_reg_result']."\n".$last_result['log_result'];
                        }
                        else
                        {
                            $last_result         = $this->dom_reg_logs->hasAnyOne(array("WHERE `domain`='".$this->utils->quoteSmart($dom)."' ORDER BY `log_time` DESC"));
                            $registration_result = $this->props->lang['dom_reg_fail'].$last_result['log_result'];
                        }
                    }
                }
            }
        }
        ob_end_clean();
    }
?>
