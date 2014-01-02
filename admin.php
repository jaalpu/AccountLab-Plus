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

    require_once "init.php";
    $BL->installer->checkandupgrade();
    ########################################################AUTHORIZATION START##################################################################
    $just_login = false;
    if (!empty ($BL->REQUEST['username']) && !empty ($BL->REQUEST['password']))
    {
        foreach ($BL->REQUEST as $k => $v)
        {
            if ($k != "submit" && $k != "username" && $k != "password" && $k != "passwd" && $k != "captcha_value")
            {
                $_GET[$k]= $v;
            }
        }
        if(!$BL->conf['image_verification_admin'])
        {
            if (!$BL->auth->login("admin"))
            {
                $BL->utils->alert($BL->props->lang['err_bad_login']);
                $BL->auth->logout("admin");
                include_once $BL->include_page("login.php");
                exit;
            }
            else
            {
                $just_login = true;
                $BL->runCS('W_L');
            }
        }
        elseif(empty($BL->REQUEST['captcha_value']))
        {
            include_once $BL->include_page("captcha.php","admin_captcha");
            exit;
        }
        else
        {
            if(md5($BL->REQUEST['captcha_value'])==$_SESSION['captcha_key'] && $BL->auth->login("admin"))
            {
                $just_login = true;
                $BL->runCS('W_L');
            }
            else
            {
                $BL->utils->alert($BL->props->lang['err_bad_login']);
                $BL->auth->logout("admin");
                include_once $BL->include_page("login.php");
                exit;
            }
        }
    }
    $check_ip           = false;
    $ip_is_licensed_for = 0;
    if(!empty($BL->conf['security_degree']) && count($BL->access_ips->find()))
    {
        $adm_id     = $BL->accessIPCheck();
        $check_ip   = true;
        if(!$adm_id)
        {
            $detected_ip            = $BL->utils->realip();
            $BL->ALPmail->AddAddress($BL->getAdminEmail(1), $BL->conf['company_name']);
            $BL->ALPmail->Subject   = $BL->props->lang['unauthorize_login_attempt'];
            $BL->ALPmail->Body      = $BL->props->lang['attemt_to_login'].$detected_ip."<br />".$BL->props->lang['Dated']." : ".date('H:i:s d-M-Y');
            $BL->ALPmail->sendMail();
            echo $BL->props->lang['detected_ip'].$detected_ip."<br />". $BL->props->lang['err_invalid_ip'];
            exit;
        }
        elseif($BL->conf['security_degree']==1 && !$BL->auth->IsAuth("admin"))
        {
            $BL->auth->ipBasedAuth($adm_id);
        }
        $ip_is_licensed_for = $adm_id;
    }
    if (!$BL->auth->IsAuth("admin", $ip_is_licensed_for, $check_ip))
    {
        if($just_login)//incase only IP do not match
        {
            $detected_ip = $BL->utils->realip();
            $msg         = $BL->props->lang['detected_ip'].$detected_ip."<br />". $BL->props->lang['err_invalid_ip'];
            $BL->utils->alert($msg);
            $BL->ALPmail->AddAddress($BL->getAdminEmail(1), $BL->conf['company_name']);
            $BL->ALPmail->Subject = $BL->props->lang['unauthorize_login_attempt'];
            $BL->ALPmail->Body    = $BL->props->lang['attemt_to_login'].$detected_ip."<br />".$BL->props->lang['Dated']." : ".date('H:i:s d-M-Y');
            $BL->ALPmail->sendMail();
        }
        $BL->auth->logout("admin");
        include_once $BL->include_page("login.php");
        exit;
    }
    if (!$BL->getCmd($cmd)){$BL->utils->alert($BL->props->lang['command_not_allowed']);$cmd = "";}
    ########################################################AUTHORIZATION END#####################################################################

    switch ($cmd)
    {
        #####################################################INVOICE START#################################################
        case "addinvoice" :
        {
            if(isset($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['add'])
            {
                $BL->REQUEST['due_date'] = $BL->REQUEST['year_field']."-".$BL->REQUEST['month_field']."-".$BL->REQUEST['date_field'];
                $BL->invoices->add($BL->REQUEST['sub_id']);
                $BL->Redirect("viewinvoice");
                break;
            }
            $Order = $BL->orders->get("WHERE orders.`sub_id`=".intval($BL->REQUEST['sub_id']));
            include_once $BL->include_page("invoice.php");
            break;
        }
        case "editinvoice" :
        {
            if (isset($BL->REQUEST['action']) && $BL->REQUEST['action'] == "sendinvoice")
            {
                if($BL->invoices->mailInvoice($BL->REQUEST['invoice_no']))
                {
                    $BL->utils->alert($BL->props->lang['Invoice_Send']);
                }
            }
            if (isset($BL->REQUEST['action']) && $BL->REQUEST['action'] == "sendpaymentnotice")
            {
                if($BL->invoices->mailPaymentReceipt($BL->REQUEST['invoice_no']))
                {
                    $BL->utils->alert($BL->props->lang['Reciept_Send']);
                }
            }
            if(isset($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['Update'])
            {
                $BL->REQUEST['due_date'] = $BL->REQUEST['year_field']."-".$BL->REQUEST['month_field']."-".$BL->REQUEST['date_field'];
                $BL->REQUEST['addon_fee'] = "";
                if(isset($BL->REQUEST['addon_setups']))
                {
                    foreach($BL->REQUEST['addon_setups'] as $Addon_Name=>$Addon_Setup)
                    {
                        $BL->REQUEST['addon_fee'] .= $Addon_Name.">".$BL->utils->toFloat($Addon_Setup).">".$BL->utils->toFloat($BL->REQUEST['addon_cycles'][$Addon_Name])."<&>";
                    }
                }
                $BL->REQUEST['tax_percent'] = "";
                if(isset($BL->REQUEST['tax0']))
                {
                    $tax_string = "|";
                    $t0_array   = $BL->REQUEST['tax0'];
                    $t1_array   = $BL->REQUEST['tax1'];
                    $t2_array   = $BL->REQUEST['tax2'];
                    $t3_array   = $BL->REQUEST['tax3'];
                    foreach($t2_array as $k=>$v)
                    {
                        if(!empty($v))
                        {
                            $tax_string.= $t0_array[$k]."<&>".$t1_array[$k]."<&>".$t2_array[$k]."<&>".$t3_array[$k]."|";
                        }
                    }
                    $BL->REQUEST['tax_percent'] = $tax_string;
                }
                $BL->invoices->update($BL->REQUEST);
                $BL->Redirect("viewinvoice");
                break;
            }

            $Invoice            = $BL->invoices->get("WHERE `invoices`.invoice_no = ".intval($BL->REQUEST['invoice_no']));
            $Extra_Fields       = isset($BL->pp_ext_fields[$Invoice[0]['payment_method']])?$BL->pp_ext_fields[$Invoice[0]['payment_method']]:array();
            $Extra_Field_Values = $BL->extraFields($Invoice[0]['id'],$Invoice[0]['sub_id'],$Invoice[0]['invoice_no'],$Extra_Fields,"SELECT");

            $Addons = $BL->addons->getInvoiceAddonStringData($Invoice[0]['addon_fee']);

            $Taxes = array();
            $temp1 = explode("|",$Invoice[0]['tax_percent']);
            $BL->utils->Remove_Empty_Elements($temp1);
            foreach($temp1 as $string)
            {
                $Taxes[] = explode("<&>",$BL->utils->htmlspecialchars_decode($string));
            }
            include_once $BL->include_page("invoice.php");
            break;
        }
        case "delinvoice" :
        {
            $BL->invoices->del($BL->REQUEST['invoice_no']);
            $BL->Redirect("viewinvoice");
            break;
        }
        case "viewinvoice" :
        {
            $conf      = $BL->conf;
            $status    = isset($BL->REQUEST['status'])?$BL->REQUEST['status']:"";
            $BL->REQUEST['orderby1']  = isset($BL->REQUEST['orderby1'])?$BL->REQUEST['orderby1']:"invoice_no";
            $BL->REQUEST['orderby2']  = isset($BL->REQUEST['orderby2'])?$BL->REQUEST['orderby2']:"DESC";
            $filter    = '';
            if(isset($BL->REQUEST['markas']) && isset($BL->REQUEST['invoice_no']))
            {
                $BL->invoices->update(array("status"=>$BL->REQUEST['markas'], "invoice_no"=>$BL->REQUEST['invoice_no']), 'invoice_no');
            }
            if(isset($BL->REQUEST['id']) && !empty($BL->REQUEST['id']))
            {
                $filter .= " AND `customers`.id=".intval($BL->REQUEST['id'])." ";
            }
            if(isset($BL->REQUEST['search_term']) && !empty($BL->REQUEST['search_term']))
            {
                $filter .= " AND (`invoices`.desc  LIKE '%".$BL->utils->quoteSmart($BL->REQUEST['search_term'])."%' OR" .
                "     `customers`.email LIKE '%".$BL->utils->quoteSmart($BL->REQUEST['search_term'])."%'   " .
                "     )";
            }
            $BL->invoices->setOrder($BL->REQUEST['orderby1'],$BL->REQUEST['orderby2']);
            $BL->invoices->setLimit(false);
            if(!empty($BL->conf['records_per_page']))
            {
                $pagination = $BL->doPagination(count($BL->invoices->getByStatus($BL->utils->quoteSmart($status), $filter)));
                $BL->invoices->setLimit(true);
            }
            $pInvoices  = $BL->invoices->getByStatus($BL->utils->quoteSmart($status), $filter);
            $Invoices   = $pInvoices;
            include_once $BL->include_page("invoice_list.php");
            break;
        }
        case "manual_payments" :
        {
            $conf      = $BL->conf;
            $pInvoices = $BL->invoices->getByStatus($BL->props->invoice_status[0]);
            $mInvoices = array();
            foreach($pInvoices as $Invoice)
            {
                if(!empty($Invoice['payment_method']) && isset($BL->pp_send_method[$Invoice['payment_method']]) && $BL->pp_send_method[$Invoice['payment_method']]=="DIRECT")
                {
                    $mInvoices[] = $Invoice;
                }
            }
            $Invoices = $mInvoices;
            include_once $BL->include_page("manual_payments.php");
            break;
        }
        #####################################################INVOICE END###################################################
        #####################################################ORDER START###################################################
        case "orphan_orders" :
        {
            if (isset($BL->REQUEST['action']) && $BL->REQUEST['action'] == "del")
            {
                $BL->orphan_orders->del($BL->REQUEST['orphanorder_id']);
            }
            if (isset($BL->REQUEST['action']) && $BL->REQUEST['action'] == "add")
            {
                $transaction = $BL->invoices->processTransaction($BL->REQUEST['item_number'], 0);
                if(!empty($transaction))
                {
                    $BL->utils->alert($transaction,false,true,true);
                }
            }
            $oOrders = $BL->orphan_orders->get();
            if (isset($BL->REQUEST['action']) && $BL->REQUEST['action'] == "view")
            {
                $oOrder = $oOrders[$BL->REQUEST['orphanorder_id']];
                $str  = "<table border='0' cellpadding='0' cellspacing='0'>";
                $BL->customfields->setOrder("customfields_index");
                foreach($BL->customfields->find() as $customfield)
                {
                    if($customfield['field_name']!="country")
                    {
                        $str .= "<tr><td align='left'>".$BL->props->parseLang($customfield['field_name'])." : </td><td align='left'>".(isset($oOrder[$customfield['field_name']])?$oOrder[$customfield['field_name']]:"")."</td></tr>";
                    }
                }
                $str .= "<tr><td align='left'>".$BL->props->lang['Country']." : </td><td align='left'>".$BL->props->country[$oOrder['country']]."</td></tr>";
                $str .= "<tr><td align='left'>".$BL->props->lang['Email']." : </td><td align='left'>".$oOrder['email']."</td></tr>";
                if(isset($oOrder['product_id']) && !empty($oOrder['product_id']))
                {
                    $str .= "<tr><td align='left'>".$BL->props->lang['Plan']." : </td><td align='left'>".$BL->getFriendlyName($oOrder['product_id'])."</td></tr>";
                }
                if(isset($oOrder['sld']) && !empty($oOrder['product_id']))
                {
                    $str .= "<tr><td align='left'>".$BL->props->lang['Domain']." : </td><td align='left'>".$oOrder['sld'].".".$oOrder['tld']."</td></tr>";
                }
                $str .= "</table>";
                $BL->utils->alert($str,false,false,true);
            }
            include_once $BL->include_page("orphan_orders.php");
            break;
        }

        case "editorder" :
        {
            if(isset($BL->REQUEST['action']) && $BL->REQUEST['action']=="change_next_bill_date")
            {
                $BL->REQUEST['rec_next_date'] = $BL->REQUEST['year_field']."-".$BL->REQUEST['month_field']."-".$BL->REQUEST['date_field'];
                $BL->change_next_bill_date($BL->REQUEST['sub_id'],$BL->REQUEST['rec_next_date']);
            }
            if(isset($BL->REQUEST['action']) && $BL->REQUEST['action']=="register_domain")
            {
                $registration_result = $BL->registerDomain($BL->REQUEST['domain_name'], $BL->REQUEST['sub_id'], "false", $BL->REQUEST['registrar']);
                $BL->utils->alert($registration_result,false,true,true);
            }
            if(isset($BL->REQUEST['action']) && $BL->REQUEST['action']=="change_status")
            {
                if(substr($BL->REQUEST['status_action'],0,1)=="_")
                {
                    $BL->markAccounts($BL->REQUEST['sub_id'], $BL->REQUEST['status_action']);
                }
                else
                {
                    $server_response = $BL->changeStatus($BL->REQUEST['sub_id'], $BL->REQUEST['status_action']);
                    $BL->utils->alert($server_response,false,true,true);
                }
            }

            if(isset($BL->REQUEST['action']) && $BL->REQUEST['action']=="welcomemail")
            {
                if($BL->mailWelcome($BL->REQUEST['sub_id']))
                {
                    $BL->utils->alert($BL->props->lang['Welcome_Mail_Send']);
                }
            }
            if(isset($BL->REQUEST['action']) && $BL->REQUEST['action']=="activationmail")
            {
                if($BL->mailNotice($BL->REQUEST['sub_id'],"ACTIVE"))
                {
                    $BL->utils->alert($BL->props->lang['Activation_Mail_Send']);
                }
            }
            if(isset($BL->REQUEST['action']) && $BL->REQUEST['action']=="suspensionmail")
            {
                if($BL->mailNotice($BL->REQUEST['sub_id'],"SUSPEND"))
                {
                    $BL->utils->alert($BL->props->lang['Suspension_Mail_Send']);
                }
            }
            if(isset($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['Update'])
            {
                $BL->REQUEST['sld'] = $BL->REQUEST['sld_'.$BL->REQUEST['dom_reg_type']];
                $BL->REQUEST['tld'] = $BL->REQUEST['tld_'.$BL->REQUEST['dom_reg_type']];
                $BL->REQUEST['sign_date'] = $BL->REQUEST['year_field']."-".$BL->REQUEST['month_field']."-".$BL->REQUEST['date_field'];
                $BL->REQUEST['addon_dates'] = array();
                $BL->REQUEST['addon_ids'] = isset($BL->REQUEST['addon_ids'])?$BL->REQUEST['addon_ids']:array();
                foreach($BL->REQUEST['addon_ids'] as $addon_id)
                {
                    $BL->REQUEST['addon_dates'][$addon_id] = $BL->REQUEST['year_field_'][$addon_id]."-".$BL->REQUEST['month_field_'][$addon_id]."-".$BL->REQUEST['date_field_'][$addon_id];
                }
                $BL->orders->edit($BL->REQUEST['sub_id']);
                $BL->Redirect("vieworders");
                break;
            }

            $order = $BL->orders->get("WHERE `orders`.sub_id=".intval($BL->REQUEST['sub_id']));
            $addon_ids = array();
            $addon_activation_dates = array();
            foreach($BL->orders->getAddons($BL->REQUEST['sub_id']) as $temp)
            {
                $addon_ids[] = $temp['addon_id'];
                $addon_activation_dates[$temp['addon_id']] = $temp['activation_date'];
            }
            $domain_array = explode(".",$order[0]['domain_name'],2);
            foreach($order[0] as $key=>$value)
            {
                $BL->REQUEST[$key] = $value;
            }
            foreach($_GET as $key=>$value)
            {
                $BL->REQUEST[$key] = $value;
            }
            $date = date('d'); $month = date('m'); $year = date('Y');
            $Customers = $BL->customers->get("WHERE `cust_deleted`='0'");

            //Check global configuration
            $tlds            = $BL->tlds->getAvailable();
            $subdomains      = $BL->subdomains->getAvailable();
            $show_tlds       = ($BL->conf['en_whois']     && count($tlds)      )?true:false;
            $show_subdomains = ($BL->conf['en_subdomain'] && count($subdomains))?true:false;
            $show_owndomain  = ($BL->conf['en_owndomain']                      )?true:false;

            //Check group configuration
            $group_data = $BL->groups->find(array("WHERE `group_id`=".(isset($BL->REQUEST['group_id'])?intval($BL->REQUEST['group_id']):0)));
            if(isset($group_data[0]['group_require_domain']) && empty($group_data[0]['group_require_domain']))
            {
                $show_tlds       = false;
                $show_subdomains = false;
                $show_owndomain  = false;
            }

            //Check product configuration
            $product_data = $BL->products->find(array("WHERE `plan_price_id`=".(isset($BL->REQUEST['product_id'])?intval($BL->REQUEST['product_id']):0)));
            if(isset($product_data[0]['domain']) && empty($product_data[0]['domain']))
            {
                $show_tlds       = false;
            }
            if(isset($product_data[0]['subdomain']) && empty($product_data[0]['subdomain']))
            {
                $show_subdomains = false;
            }
            if(isset($product_data[0]['force_domain_subdomain']) && $product_data[0]['force_domain_subdomain'])
            {
                $show_owndomain = false;
            }
            if($REQUEST['dom_reg_type']==0)
            {
                $show_owndomain = true;
            }
            elseif($REQUEST['dom_reg_type']==1)
            {
                $show_tlds      = true;
            }
            elseif($REQUEST['dom_reg_type']==3)
            {
                $show_subdomains= true;
            }

            $Products    = $BL->products->getAvailable((isset($BL->REQUEST['group_id'])?$BL->REQUEST['group_id']:0));
            $Bill_Cycles = $BL->products->getCycles((isset($BL->REQUEST['product_id'])?$BL->REQUEST['product_id']:0));
            $Addons      = $BL->addons->getAvailable((isset($BL->REQUEST['product_id'])?$BL->REQUEST['product_id']:0));
            $Servers     = $BL->servers->find();
            $Ips         = $BL->servers->additionalIPs(isset($BL->REQUEST['server_id'])?$BL->REQUEST['server_id']:0);

            $order_product = $BL->products->getByKey($REQUEST['product_id']);
            $txt_color     = "lightgrey";
            if ($BL->REQUEST['acct_status'] == 0) //pending
            {
                $txt_color   = "red";
                $action      = "create";
                $action_txt  = $BL->props->lang['Active'];
            }
            elseif ($BL->REQUEST['acct_status'] == 1) //active
            {
                $txt_color   = "skyblue";
                $action      = "suspend";
                $action_txt  = $BL->props->lang['Suspended'];
            }
            elseif ($BL->REQUEST['acct_status'] == 2) //suspended
            {
                $txt_color   = "grey";
                $action      = "unsuspend";
                $action_txt  = $BL->props->lang['Active'];
            }

            $title = $BL->props->lang['edit_order'];
            include_once $BL->include_page("orders.php");
            break;
        }
        case "addorder" :
        {
            if(isset($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['add'])
            {
                //PREPARE ORDER DATA START
                $BL->REQUEST['product_id']  = (!isset($BL->REQUEST['product_id']) || !is_numeric($BL->REQUEST['product_id']))?0:$BL->REQUEST['product_id'];
                $BL->REQUEST['bill_cycle']  = isset($BL->REQUEST['bill_cycle'])?$BL->REQUEST['bill_cycle']:12;
                $BL->REQUEST['sld']         = $BL->REQUEST['sld_'.$BL->REQUEST['dom_reg_type']];
                $BL->REQUEST['tld']         = $BL->REQUEST['tld_'.$BL->REQUEST['dom_reg_type']];
                $BL->REQUEST['type']        = (!isset($BL->REQUEST['dom_reg_type']) || empty($BL->REQUEST['dom_reg_type']))?3:(($BL->REQUEST['dom_reg_type']==1)?1:2);
                $BL->REQUEST['year']        = $BL->REQUEST['dom_reg_year'];
                $BL->REQUEST['sign_date']   = $BL->REQUEST['year_field']."-".$BL->REQUEST['month_field']."-".$BL->REQUEST['date_field'];
                $BL->REQUEST['addon_dates'] = array();
                $BL->REQUEST['addon_ids']   = isset($BL->REQUEST['addon_ids'])?$BL->REQUEST['addon_ids']:array();
                foreach($BL->REQUEST['addon_ids'] as $addon_id)
                {
                    $BL->REQUEST['addon_dates'][$addon_id] = $BL->REQUEST['year_field_'][$addon_id]."-".$BL->REQUEST['month_field_'][$addon_id]."-".$BL->REQUEST['date_field_'][$addon_id];
                }
                $BL->REQUEST['customer']['member']   = 1;
                $BL->REQUEST['customer']['id']       = $BL->REQUEST['customer_id'];
                $BL->REQUEST['customer']['dom_user'] = $BL->REQUEST['dom_user'];
                $BL->REQUEST['customer']['dom_pass'] = $BL->REQUEST['dom_pass'];
                $BL->REQUEST['due_date']             = $BL->REQUEST['sign_date'];
                $BL->REQUEST['customer']['disc_token_code'] = "";
                //PREPARE ORDER DATA END

                $INVOICE_DATA = $BL->invoices->calcuateAll(false,false, $BL->REQUEST);

                foreach($INVOICE_DATA as $key=>$value)
                {
                    if(!is_array($value))
                    {
                        $BL->REQUEST[$key]=$value;
                    }
                }
                foreach($INVOICE_DATA['CUSTOMER_DATA'] as $key=>$value)
                {
                    $BL->REQUEST[$key]=$value;
                }
                foreach($INVOICE_DATA['ORDER_DATA'] as $key=>$value)
                {
                    $BL->REQUEST[$key]=$value;
                }
                $BL->REQUEST['skip_auto_creation'] = 1;
                $BL->processOrder(0);

                if(isset($BL->REQUEST['gen_intermediate']) && $BL->REQUEST['gen_intermediate']==1 && isset($BL->REQUEST['mark_as']))
                {
                    $BL->REQUEST['invoice_status'] = $BL->REQUEST['mark_as'];
                    $temp = $BL->recurring_data($BL->REQUEST['order_id'],0,"SELECT");
                    $BL->invoices->genIntermediateInvoices($BL->REQUEST['order_id']);
                }
                $BL->Redirect("viewinvoice");
                break;
            }
            $date = date('d'); $month = date('m'); $year = date('Y');
            $Customers = $BL->customers->get("WHERE `cust_deleted`='0'");

            //Check global configuration
            $tlds            = $BL->tlds->getAvailable();
            $subdomains      = $BL->subdomains->getAvailable();
            $show_tlds       = ($BL->conf['en_whois']     && count($tlds)      )?true:false;
            $show_subdomains = ($BL->conf['en_subdomain'] && count($subdomains))?true:false;
            $show_owndomain  = ($BL->conf['en_owndomain']                      )?true:false;

            //Check group configuration
            $group_data = $BL->groups->find(array("WHERE `group_id`=".(isset($BL->REQUEST['group_id'])?intval($BL->REQUEST['group_id']):0)));
            if(isset($group_data[0]['group_require_domain']) && empty($group_data[0]['group_require_domain']))
            {
                $show_tlds       = false;
                $show_subdomains = false;
                $show_owndomain  = false;
            }

            //Check product configuration
            $product_data = $BL->products->find(array("WHERE `plan_price_id`=".(isset($BL->REQUEST['product_id'])?intval($BL->REQUEST['product_id']):0)));
            if(isset($product_data[0]['domain']) && empty($product_data[0]['domain']))
            {
                $show_tlds       = false;
            }
            if(isset($product_data[0]['subdomain']) && empty($product_data[0]['subdomain']))
            {
                $show_subdomains = false;
            }
            if(isset($product_data[0]['force_domain_subdomain']) && $product_data[0]['force_domain_subdomain'])
            {
                $show_owndomain = false;
            }

            $Products    = $BL->products->getAvailable((isset($BL->REQUEST['group_id'])?$BL->REQUEST['group_id']:0));
            $Bill_Cycles = $BL->products->getCycles((isset($BL->REQUEST['product_id'])?$BL->REQUEST['product_id']:0));
            $Addons      = $BL->addons->getAvailable((isset($BL->REQUEST['product_id'])?$BL->REQUEST['product_id']:0));
            $Servers     = $BL->servers->find();
            $Ips         = $BL->servers->additionalIPs(isset($BL->REQUEST['server_id'])?$BL->REQUEST['server_id']:0);

            $REQUEST['dom_user'] = strtolower($BL->utils->random_password());
            $REQUEST['dom_pass'] = $BL->utils->random_password();
            $title = $BL->props->lang['Add_New_Order'];
            include_once $BL->include_page("orders.php");
            break;
        }
        case "vieworders" :
        {
            $conf   = $BL->conf;
            if(isset($BL->REQUEST['gen_invoice']) && $BL->REQUEST['gen_invoice']==1)
            {
                $date = '';
                if($BL->utils->checkDateFormat($BL->REQUEST['date']))
                {
                    $date = date('Y-m-d',strtotime($BL->REQUEST['date']));
                    $temp = $BL->utils->getDateArray($date);
                    if($BL->utils->compareDates(date('d'),date('m'),date('Y'),$temp['mday'],$temp['mon'],$temp['year'])!=-1)
                    {
                        $return = $BL->invoices->genInvoicesForDay($BL->REQUEST['sub_id'],$date,true);
                        $BL->utils->alert($BL->getFriendlyDesc($return,$BL->REQUEST['sub_id']));
                    }
                }
            }
            $BL->REQUEST['orderby1']  = isset($BL->REQUEST['orderby1'])?$BL->REQUEST['orderby1']:"sub_id";
            $BL->REQUEST['orderby2']  = isset($BL->REQUEST['orderby2'])?$BL->REQUEST['orderby2']:"DESC";
            $filter    = '';
            if(isset($BL->REQUEST['id']) && !empty($BL->REQUEST['id']))
            {
                $filter .= "AND `customers`.id='".$BL->REQUEST['id']."' ";
            }
            if(isset($BL->REQUEST['search_term']) && !empty($BL->REQUEST['search_term']))
            {
                $filter .= " AND (`orders`.domain_name  LIKE '%".$BL->utils->quoteSmart($BL->REQUEST['search_term'])."%' OR" .
                "     `customers`.email      LIKE '%".$BL->utils->quoteSmart($BL->REQUEST['search_term'])."%'   " .
                "     )";
            }
            $BL->orders->setOrder($BL->REQUEST['orderby1'],$BL->REQUEST['orderby2'],'orders');

            $BL->orders->setLimit(false);
            if(!empty($BL->conf['records_per_page']))
            {
                $pagination = $BL->doPagination(count($BL->orders->get("WHERE `order_deleted`='0' ".$filter)));
                $BL->orders->setLimit(true);
            }
            $Orders = $BL->orders->get("WHERE `order_deleted`='0' ".$filter);
            include_once $BL->include_page("orders_list.php");
            break;
        }
        case "delorder" :
        {
            $BL->orders->del($BL->REQUEST['sub_id']);
            $BL->Redirect("vieworders");
            break;
        }
        #####################################################ORDER END###################################################
        ################################################Customer START###################################################
        case "delcustomers" :
        {
            $BL->customers->del($BL->REQUEST['id']);
            $BL->Redirect("viewcustomers");
            break;
        }
        case "editcustomers" :
        {
            $BL->customfields->setOrder("customfields_index");
            $custom_fields = $BL->customfields->find();
            if(isset($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['Update'])
            {
                $BL->REQUEST['creation_date'] = $BL->REQUEST['year_field']."-".$BL->REQUEST['month_field']."-".$BL->REQUEST['date_field'];
                $err = $BL->customers->validate($BL->REQUEST,$custom_fields,true);
                if(empty($err))
                {
                    $BL->customers->edit($custom_fields);
                    $BL->Redirect("viewcustomers");
                }
            }
            $data = $BL->customers->getByKey($BL->REQUEST['id']);
            foreach($data as $key=>$value)
            {
                $BL->REQUEST[$key] = $value;
            }
            foreach($custom_fields as $field)
            {
                $BL->REQUEST[$field['field_name']] = $BL->customers->getFieldValue($field['field_id'],$BL->REQUEST['id']);
            }
            $date_array = $BL->utils->getDateArray($BL->REQUEST['creation_date']);
            $date  = $date_array['mday']; $month = $date_array['mon']; $year = $date_array['year'];
            $title = $BL->props->lang['edit_customer'];
            include_once $BL->include_page("customers.php");
            break;
        }
        case "addcustomer" :
        {
            $BL->customfields->setOrder("customfields_index");
            $custom_fields = $BL->customfields->find();
            if(isset($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['add'])
            {
                $BL->REQUEST['creation_date'] = $BL->REQUEST['year_field']."-".$BL->REQUEST['month_field']."-".$BL->REQUEST['date_field'];
                $err = $BL->customers->validate($BL->REQUEST,$custom_fields);
                if(empty($err) && $BL->customers->add($custom_fields))
                {
                    $BL->Redirect("viewcustomers");
                }
            }
            $date  = date('d'); $month = date('m'); $year = date('Y');
            $title = $BL->props->lang['Add_New_Customer'];
            include_once $BL->include_page("customers.php");
            break;
        }
        case "viewcustomers" :
        {
            $BL->REQUEST['orderby1']  = isset($BL->REQUEST['orderby1'])?$BL->REQUEST['orderby1']:"sub_id";
            $BL->REQUEST['orderby2']  = isset($BL->REQUEST['orderby2'])?$BL->REQUEST['orderby2']:"DESC";
            $filter    = '';
            if(isset($BL->REQUEST['search_term']) && !empty($BL->REQUEST['search_term']))
            {
                $filter .= " AND `customers`.email LIKE '%".$BL->utils->quoteSmart($BL->REQUEST['search_term'])."%'   ";
            }
            $BL->orders->setOrder($BL->REQUEST['orderby1'], $BL->REQUEST['orderby2']);

            $BL->customers->setLimit(false);
            if(!empty($BL->conf['records_per_page']))
            {
                $pagination = $BL->doPagination(count($BL->customers->get(" WHERE `cust_deleted`='0' ".$filter)));
                $BL->customers->setLimit(true);
            }
            $Customers = $BL->customers->get(" WHERE `cust_deleted`='0' ".$filter);
            include_once $BL->include_page("customers_list.php");
            break;
        }
        ################################################Customer END###################################################
        #######################################################PRODUCT START#######################################################################
        case "edit_addon" :
        {
            if (isset($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['Update'])
            {
                $BL->addons->update($BL->REQUEST);
                $BL->addons->updateBillingCycles($BL->REQUEST['addon_id'], $BL->REQUEST);
                $BL->Redirect("addons");
                break;
            }
            $conf  = $BL->conf;
            $title = $BL->props->lang['Edit_addon'];
            $addon = $BL->addons->getByKey($BL->REQUEST['addon_id']);
            $addon_cycles = $BL->addons->getCycles($BL->REQUEST['addon_id']);
            include_once $BL->include_page("addons.php");
            break;
        }
        case "add_addon" :
        {
            if (isset($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['add'])
            {
                $BL->REQUEST['addon_index'] = count($BL->addons->find())+1;
                $insert_id = $BL->addons->insert($BL->REQUEST);
                if($insert_id)
                {
                    $BL->addons->updateBillingCycles($insert_id, $BL->REQUEST);
                    $BL->Redirect("addons");
                    break;
                }
            }
            $conf = $BL->conf;
            $title = $BL->props->lang['Add_addon'];
            include_once $BL->include_page("addons.php");
            break;
        }
        case "addons" :
        {
            if(isset($BL->REQUEST['action']) && $BL->REQUEST['action']=="up")
            {
                $BL->addons->moveUp($BL->REQUEST['addon_id'],$BL->REQUEST['addon_index']);
            }
            if(isset($BL->REQUEST['action']) && $BL->REQUEST['action']=="down")
            {
                $BL->addons->moveDown($BL->REQUEST['addon_id'],$BL->REQUEST['addon_index']);
            }
            $BL->addons->setOrder((isset($BL->REQUEST['orderby'])?$BL->REQUEST['orderby']:"addon_index"));
            $addons= $BL->addons->find();
            include_once $BL->include_page("addons_list.php");
            break;
        }
        case "del_addon" :
        {
            $BL->addons->delete(array("WHERE `addon_id`=".intval($BL->REQUEST['addon_id'])));
            $BL->Redirect("addons");
            break;
        }
        case "editmaindomain" :
        {
            if (isset($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['Update'])
            {
                $BL->subdomains->update($BL->REQUEST);
                $BL->subdomains->updateBillingCycles($BL->REQUEST['main_id'], $BL->REQUEST);
                $BL->Redirect("subdomains");
                break;
            }
            $conf = $BL->conf;
            $maindomain = $BL->subdomains->getByKey($BL->REQUEST['main_id']);
            $maindomain_cycles = $BL->subdomains->getCycles($BL->REQUEST['main_id']);
            $title = $BL->props->lang['Edit_Domain'];
            include_once $BL->include_page("maindomain.php");
            break;
        }
        case "add_maindomain" :
        {
            if (isset($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['add'])
            {
                $insert_id = $BL->subdomains->insert($BL->REQUEST);
                if($insert_id)
                {
                    $BL->subdomains->updateBillingCycles($insert_id, $BL->REQUEST);
                    $BL->Redirect("subdomains");
                    break;
                }
            }
            $conf  = $BL->conf;
            $title = $BL->props->lang['Add_Domain'];
            include_once $BL->include_page("maindomain.php");
            break;
        }
        case "subdomains" :
        {
            $subdomains= $BL->subdomains->find();
            include_once $BL->include_page("subdomains_list.php");
            break;
        }
        case "delmaindomain" :
        {
            $BL->subdomains->delete(array("WHERE `main_id`=".intval($BL->REQUEST['main_id'])));
            $BL->Redirect("subdomains");
            break;
        }
        case "editplan" :
        {
            if (isset($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['Update'])
            {
                $BL->cpanel_reseller_profiles->delete(array("WHERE `cpr_profile_id`=".intval($BL->REQUEST['cpr_profile_id'])));
                $BL->plesk_profiles->delete(array("WHERE `plesk_profile_id`=".intval($BL->REQUEST['plesk_profile_id'])));

                $BL->REQUEST['cpr_profile_id']  = (isset($BL->REQUEST['cpanel_plan']) && $BL->REQUEST['cpanel_plan'])?$BL->cpanel_reseller_profiles->insert($BL->REQUEST):0;
                $BL->REQUEST['plesk_profile_id']= (isset($BL->REQUEST['plesk_plan']) && $BL->REQUEST['plesk_plan'])?$BL->plesk_profiles->insert($BL->REQUEST):0;
                $BL->REQUEST['da_reseller']     = (isset($BL->REQUEST['da_plan']) && $BL->REQUEST['da_plan'])?$BL->REQUEST['da_reseller']:0;

                $BL->products->update($BL->REQUEST);

                $BL->products->updateBillingCycles($BL->REQUEST['plan_price_id'],$BL->REQUEST);
                $BL->products->updateAssociatedGroups($BL->REQUEST['plan_price_id'],isset($BL->REQUEST['group_ids'])?$BL->REQUEST['group_ids']:array());
                $BL->products->updateAssociatedAddons($BL->REQUEST['plan_price_id'],isset($BL->REQUEST['addon_ids'])?$BL->REQUEST['addon_ids']:array());
                $BL->products->updateAssociatedServers($BL->REQUEST['plan_price_id'],isset($BL->REQUEST['server_ids'])?$BL->REQUEST['server_ids']:array());

                $BL->Redirect("plans");
                break;
            }
            $conf    = $BL->conf;
            $title   = $BL->props->lang['edit_plan'];
            $servers = $BL->servers->find();
            $BL->addons->setOrder("addon_index");
            $addons  = $BL->addons->find();
            $BL->groups->setOrder("group_index");
            $groups  = $BL->groups->find();
            $plan    = $BL->products->getByKey($BL->REQUEST['plan_price_id']);
            $plan_cycles = $BL->products->getCycles($BL->REQUEST['plan_price_id']);
            $addon_ids   = $BL->addons->getAvailable($BL->REQUEST['plan_price_id']);
            $group_ids   = $BL->products->getAssociatedGroups($BL->REQUEST['plan_price_id']);
            $server_ids  = $BL->products->getAdditionalServers($BL->REQUEST['plan_price_id']);
            $plan_cpanel_reseller_profile = $BL->cpanel_reseller_profiles->getByKey($plan['cpr_profile_id']);
            $plan_plesk_profile = $BL->plesk_profiles->getByKey($plan['plesk_profile_id']);
            include_once $BL->include_page("plans.php");
            break;
        }
        case "addplan" :
        {
            if (isset($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['add'])
            {
                $BL->REQUEST['cpr_profile_id']  = (isset($BL->REQUEST['cpanel_plan']) && $BL->REQUEST['cpanel_plan'])?$BL->cpanel_reseller_profiles->insert($BL->REQUEST):0;
                $BL->REQUEST['plesk_profile_id']= (isset($BL->REQUEST['plesk_plan']) && $BL->REQUEST['plesk_plan'])?$BL->plesk_profiles->insert($BL->REQUEST):0;
                $BL->REQUEST['da_reseller']     = (isset($BL->REQUEST['da_plan']) && $BL->REQUEST['da_plan'])?$BL->REQUEST['da_reseller']:0;

                $BL->REQUEST['plan_index']      = count($BL->products->find())+1;
                $BL->REQUEST['plan_price_id']   = $BL->products->insert($BL->REQUEST);

                if($BL->REQUEST['plan_price_id'])
                {
                    $BL->products->updateBillingCycles($BL->REQUEST['plan_price_id'],$BL->REQUEST);
                    $BL->products->updateAssociatedGroups($BL->REQUEST['plan_price_id'],isset($BL->REQUEST['group_ids'])?$BL->REQUEST['group_ids']:array());
                    $BL->products->updateAssociatedAddons($BL->REQUEST['plan_price_id'],isset($BL->REQUEST['addon_ids'])?$BL->REQUEST['addon_ids']:array());
                    $BL->products->updateAssociatedServers($BL->REQUEST['plan_price_id'],isset($BL->REQUEST['server_ids'])?$BL->REQUEST['server_ids']:array());
                }

                $BL->Redirect("plans");
                break;
            }
            $conf    = $BL->conf;
            $title   = $BL->props->lang['add_plan'];
            $servers = $BL->servers->find();
            $BL->addons->setOrder("addon_index");
            $addons  = $BL->addons->find();
            $BL->groups->setOrder("group_index");
            $groups  = $BL->groups->find();
            include_once $BL->include_page("plans.php");
            break;
        }
        case "plans" :
        {
            if(isset($BL->REQUEST['action']) && $BL->REQUEST['action']=="en_domain_only")
            {
                $BL->REQUEST['en_domain_only'] = isset($BL->REQUEST['en_domain_only'])?$BL->REQUEST['en_domain_only']:0;
                $BL->configurations->update($BL->REQUEST);
            }
            if(isset($BL->REQUEST['action']) && $BL->REQUEST['action']=="sync")
            {
                $msg = $BL->syncPackage($BL->REQUEST['plan_price_id']);
                $BL->utils->alert($msg,0,0);
            }
            if(isset($BL->REQUEST['action']) && $BL->REQUEST['action']=="up")
            {
                $BL->products->moveUp($BL->REQUEST['plan_price_id'],$BL->REQUEST['plan_index']);
            }
            if(isset($BL->REQUEST['action']) && $BL->REQUEST['action']=="down")
            {
                $BL->products->moveDown($BL->REQUEST['plan_price_id'],$BL->REQUEST['plan_index']);
            }
            $BL->loadConf();
            $conf  = $BL->conf;
            $BL->products->setOrder((isset($BL->REQUEST['orderby'])?$BL->REQUEST['orderby']:"plan_index"));
            $plans = $BL->products->find();
            include_once $BL->include_page("plans_list.php");
            break;
        }
        case "delplan" :
        {
            $product = $BL->products->getByKey($BL->REQUEST['plan_price_id']);
            if(count($product))
            {
                $BL->products->updateAssociatedGroups($BL->REQUEST['plan_price_id']);
                $BL->products->updateAssociatedAddons($BL->REQUEST['plan_price_id']);
                $BL->products->updateAssociatedServers($BL->REQUEST['plan_price_id']);
                $BL->cpanel_reseller_profiles->delete(array("WHERE `cpr_profile_id`=".intval($product['cpr_profile_id'])));
                $BL->plesk_profiles->delete(array("WHERE `plesk_profile_id`=".intval($product['plesk_profile_id'])));
                $BL->products->delete(array("WHERE `plan_price_id`=".intval($BL->REQUEST['plan_price_id'])));
            }
            $BL->Redirect("plans");
            break;
        }
        case "edit_group" :
        {
            if (isset($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['Update'])
            {
                $BL->groups->update($BL->REQUEST);
                $BL->groups->updateAvailableProducts($BL->REQUEST['group_id'],$BL->utils->Get_Uniques_Array($BL->utils->Get_Trimmed_Array($BL->REQUEST['products'])));
                $BL->Redirect("groups");
                break;
            }
            $products = $BL->products->find();
            $group    = $BL->groups->getByKey($BL->REQUEST['group_id']);
            $available_products = $BL->products->getAvailable($BL->REQUEST['group_id']);
            $title    = $BL->props->lang['+edit_group'];
            include_once $BL->include_page("group.php");
            break;
        }
        case "add_group" :
        {
            if (isset($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['add'])
            {
                $BL->REQUEST['group_url'] = count($BL->groups->find())+1;
                $BL->REQUEST['group_index'] = count($BL->groups->find())+1;
                $insert_id            = $BL->groups->insert($BL->REQUEST);
                if($insert_id)
                {
                    $BL->groups->updateAvailableProducts($insert_id,$BL->utils->Get_Uniques_Array($BL->utils->Get_Trimmed_Array(isset($BL->REQUEST['products'])?$BL->REQUEST['products']:array())));
                    $BL->Redirect("groups");
                    break;
                }
            }
            $products = $BL->products->find();
            $title    = $BL->props->lang['+add_group'];
            include_once $BL->include_page("group.php");
            break;
        }
        case "del_group" :
        {
            $BL->groups->delete(array("WHERE `group_id`=".intval($BL->REQUEST['group_id'])));
            $BL->groups->updateAvailableProducts($BL->REQUEST['group_id']);
            $BL->Redirect("groups");
            break;
        }
        case "groups" :
        {
            if(isset($BL->REQUEST['action']) && $BL->REQUEST['action']=="up")
            {
                $BL->groups->moveUp($BL->REQUEST['group_id'],$BL->REQUEST['group_index']);
            }
            if(isset($BL->REQUEST['action']) && $BL->REQUEST['action']=="down")
            {
                $BL->groups->moveDown($BL->REQUEST['group_id'],$BL->REQUEST['group_index']);
            }
            $BL->groups->setOrder((isset($BL->REQUEST['orderby'])?$BL->REQUEST['orderby']:"group_index"));
            $groups = $BL->groups->find();
            include_once $BL->include_page("group_list.php");
            break;
        }
        #######################################################PRODUCT END#######################################################################
        #######################################################EXTRA END#########################################################################
        case "credits" :
        {
            $conf = $BL->conf;
            if (isset($BL->REQUEST['update']) && $BL->REQUEST['update']==$BL->props->lang['Update'])
            {
                $credit_array      = $BL->REQUEST['credit'];
                $credit_type_array = $BL->REQUEST['credit_type'];
                $credit_desc_array = $BL->REQUEST['credit_desc'];
                foreach ($credit_array as $id => $credit)
                {
                    $data                = array();
                    $data['id']          = $id;
                    $data['credit']      = $credit_array[$id];
                    $data['credit_type'] = $credit_type_array[$id];
                    $data['credit_desc'] = $credit_desc_array[$id];
                    $BL->customers->update($data);
                }
            }
            $allCustomers = $BL->customers->get("WHERE `cust_deleted`='0'");
            include_once $BL->include_page("credits_list.php");
            break;
        }
        case "discounts" :
        {
            if (isset($BL->REQUEST['update']) && $BL->REQUEST['update']==$BL->props->lang['Update'])
            {
                $discont_array    = $BL->REQUEST['discount'];
                $disposable_array = $BL->REQUEST['disposable'];
                $cumulative_array = $BL->REQUEST['cumulative'];
                foreach ($discont_array as $id => $discount)
                {
                    $data               = array();
                    $data['id']         = $id;
                    $data['discount']   = $discont_array[$id];
                    $data['disposable'] = $disposable_array[$id];
                    $data['cumulative'] = $cumulative_array[$id];
                    $BL->customers->update($data);
                }
            }
            $allCustomers = $BL->customers->get("WHERE `cust_deleted`='0'");
            include_once $BL->include_page("discounts_list.php");
            break;
        }
        case "send_disc_token" :
        {
            $conf = $BL->conf;
            if (isset ($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['send_disc_token'])
            {
                $msg    = $BL->props->lang['disc_token_send_to']."<br>";
                $subject= $BL->props->lang['dt_sub'].$conf['company_name'];
                $message= $BL->REQUEST['message'];
                foreach ($BL->REQUEST['cust_email'] as $email)
                {
                    $DCODE = $BL->disc_token_codes->createUniqueCode();
                    $BL->disc_token_codes->insert(array("disc_token_code"=>$DCODE,"disc_token_id"=>$BL->REQUEST['disc_token_id'],"disposable"=>$BL->REQUEST['disposable']));
                    $BL->ALPmail->AddAddress($email);
                    $BL->ALPmail->Subject  = $subject;
                    $BL->ALPmail->Body     = $message.$DCODE;
                    $BL->ALPmail->AltBody  = strip_tags($message).$DCODE;
                    $BL->ALPmail->IsHTML(true);
                    if($BL->ALPmail->sendMail())
                    {
                        $msg .= $email."<br>";
                    }
                }
                $BL->utils->alert($msg);
            }
            $disc_tokens  = $BL->disc_tokens->find();
            $allCustomers = $BL->customers->get("WHERE `cust_deleted`='0'");
            include_once $BL->include_page("send_disc_token.php");
            break;
        }
        case "edit_disc_token" :
        {
            if(isset($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['Update'])
            {
                $BL->REQUEST['disc_token_valid'] = $BL->REQUEST['year_field']."-".$BL->REQUEST['month_field']."-".$BL->REQUEST['date_field'];
                if($BL->disc_tokens->update($BL->REQUEST))
                {
                    $BL->Redirect("disc_tokens");
                    break;
                }
            }
            $title         = $BL->props->lang['Edit_disc_token'];
            $disc_token_id = $BL->REQUEST['disc_token_id'];
            $disc_token    = $BL->disc_tokens->getByKey($disc_token_id);
            include_once $BL->include_page("disc_tokens.php");
            break;
        }
        case "add_disc_token" :
        {
            if(isset($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['add'])
            {
                $BL->REQUEST['disc_token_valid'] = $BL->REQUEST['year_field']."-".$BL->REQUEST['month_field']."-".$BL->REQUEST['date_field'];
                if($BL->disc_tokens->insert($BL->REQUEST))
                {
                    $BL->Redirect("disc_tokens");
                    break;
                }
            }
            $title = $BL->props->lang['Add_disc_token'];
            include_once $BL->include_page("disc_tokens.php");
            break;
        }
        case "del_disc_token" :
        {
            $BL->disc_tokens->delete(array("WHERE `disc_token_id`=".intval($BL->REQUEST['disc_token_id'])));
            $BL->Redirect("disc_tokens");
            break;
        }
        case "act_disc_token" :
        {
            $BL->configurations->update($BL->REQUEST);
            $BL->Redirect("disc_tokens");
            break;
        }
        case "disc_tokens" :
        {
            $conf        = $BL->conf;
            $disc_tokens = $BL->disc_tokens->find();
            include_once $BL->include_page("disc_tokens_list.php");
            break;
        }
        case "edit_coupon" :
        {
            if(isset($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['Update'])
            {
                $BL->REQUEST['coupon_valid'] = $BL->REQUEST['year_field']."-".$BL->REQUEST['month_field']."-".$BL->REQUEST['date_field'];
                if($BL->coupons->update($BL->REQUEST))
                {
                    $BL->Redirect("coupons");
                    break;
                }
            }
            $title     = $BL->props->lang['Edit_coupon'];
            $coupon_id = $BL->REQUEST['coupon_id'];
            $coupon    = $BL->coupons->getByKey($coupon_id);
            include_once $BL->include_page("coupons.php");
            break;
        }
        case "add_coupon" :
        {
            if(isset($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['add'])
            {
                $BL->REQUEST['coupon_valid'] = $BL->REQUEST['year_field']."-".$BL->REQUEST['month_field']."-".$BL->REQUEST['date_field'];
                if($BL->coupons->insert($BL->REQUEST))
                {
                    $BL->Redirect("coupons");
                    break;
                }
            }
            $title = $BL->props->lang['Add_coupon'];
            include_once $BL->include_page("coupons.php");
            break;
        }
        case "del_coupon" :
        {
            $coupons = $BL->coupons->delete(array("WHERE `coupon_id`=".intval($BL->REQUEST['coupon_id'])));
            $BL->Redirect("coupons");
            break;
        }
        case "act_coupon" :
        {
            $BL->configurations->update($BL->REQUEST);
            $BL->Redirect("coupons");
            break;
        }
        case "coupons" :
        {
            $conf    = $BL->conf;
            $coupons = $BL->coupons->find();
            include_once $BL->include_page("coupons_list.php");
            break;
        }
        case "edit_special" :
        {
            if(isset($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['Update'])
            {
                $BL->REQUEST['special_valid_from'] = $BL->REQUEST['year_field1']."-".$BL->REQUEST['month_field1']."-".$BL->REQUEST['date_field1'];
                $BL->REQUEST['special_valid']      = $BL->REQUEST['year_field']."-".$BL->REQUEST['month_field']."-".$BL->REQUEST['date_field'];
                if($BL->specials->update($BL->REQUEST))
                {
                    $BL->Redirect("specials");
                    break;
                }
            }
            $special_id = $BL->REQUEST['special_id'];
            $special    = $BL->specials->getByKey($special_id);
            $conf       = $BL->conf;
            $tlds       = $BL->tlds->find();
            $BL->addons->setOrder("addon_index");
            $addons     = $BL->addons->find();
            $subdomains = $BL->subdomains->find();
            $BL->products->setOrder("plan_index");
            $plans      = $BL->products->find();
            $title      = $BL->props->lang['Edit_special'];
            include_once $BL->include_page("specials.php");
            break;
        }
        case "add_special" :
        {
            if(isset($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['add'])
            {
                $BL->REQUEST['special_valid_form'] = $BL->REQUEST['year_field1']."-".$BL->REQUEST['month_field1']."-".$BL->REQUEST['date_field1'];
                $BL->REQUEST['special_valid']      = $BL->REQUEST['year_field']."-".$BL->REQUEST['month_field']."-".$BL->REQUEST['date_field'];
                if($BL->specials->insert($BL->REQUEST))
                {
                    $BL->Redirect("specials");
                    break;
                }
            }
            $conf       = $BL->conf;
            $tlds       = $BL->tlds->find();
            $BL->addons->setOrder("addon_index");
            $addons     = $BL->addons->find();
            $subdomains = $BL->subdomains->find();
            $BL->products->setOrder("plan_index");
            $plans      = $BL->products->find();
            $title      = $BL->props->lang['Add_Special'];
            include_once $BL->include_page("specials.php");
            break;
        }
        case "del_special" :
        {
            $BL->specials->delete(array("WHERE `special_id`=".intval($BL->REQUEST['special_id'])));
            $BL->Redirect("specials");
            break;
        }
        case "specials" :
        {
            if (isset($BL->REQUEST['action']) && $BL->REQUEST['action']=="changestatus")
            {
                $BL->specials->update($BL->REQUEST);
            }
            $specials = $BL->specials->find();
            include_once $BL->include_page("specials_list.php");
            break;
        }
        #######################################################EXTRA END#########################################################################
        #######################################################SUPPORT START#####################################################################
        case "openTicket" :
        {
            $BL->REQUEST['ticket_status']  = 1;
            $BL->support_tickets->update($BL->REQUEST);
            $BL->mailTicket($BL->REQUEST['ticket_id'],false);
            $BL->Redirect("ticket");
            break;
        }
        case "closeTicket" :
        {
            $BL->REQUEST['ticket_status']  = 3;
            $BL->support_tickets->update($BL->REQUEST);
            $BL->mailTicket($BL->REQUEST['ticket_id'],false);
            $BL->Redirect("ticket");
            break;
        }
        case "viewTicket" :
        {
            if($cmd=="viewTicket")
            {
                $ticket_id = $BL->REQUEST['ticket_id'];
                if (isset ($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['submit'])
                {
                    $BL->support_replies->insert($BL->REQUEST);
                    $BL->support_tickets->update($BL->REQUEST);
                    $BL->mailTicket($BL->REQUEST['ticket_id'],false);
                    $BL->Redirect("ticket");
                }
                $ticket     = $BL->support_tickets->getByKey($ticket_id);
                $replies    = $BL->support_replies->find(array("WHERE `ticket_id`=".intval($ticket_id)));
                $topic      = $BL->support_topics->getByKey($ticket['topic_id']);
                if (count($ticket))
                {
                    include_once $BL->include_page("ticket.php");
                    break;
                }
                else
                {
                    $BL->Redirect("ticket");
                    break;
                }
            }
        }
        case "ticket" :
        {
            $conf    = $BL->conf;
            $topics  = array();
            $dept_ids= explode("<&&>", $_SESSION['dept_id']);
            $BL->utils->Remove_Empty_Elements($dept_ids);
            if(!count($dept_ids) || array_search('0',$dept_ids)!==false)
            {
                $topics = $BL->support_topics->find();
            }
            else
            {
                foreach ($dept_ids as $topic_id)
                {
                    $topics[] = $BL->support_topics->getByKey($topic_id);
                }
            }
            $tickets = array();
            foreach ($topics as $val)
            {
                $tickets[$val['topic_id']]['open']   = $BL->support_tickets->find(array("WHERE `topic_id`=".intval($val['topic_id'])." AND `ticket_status`!='3'"));
                $tickets[$val['topic_id']]['closed'] = $BL->support_tickets->find(array("WHERE `topic_id`=".intval($val['topic_id'])." AND `ticket_status`='3'"));
            }
            $ticket_status = "all";
            if (isset($BL->REQUEST['ticket_status']) && is_numeric($BL->REQUEST['ticket_status']))
            {
                $ticket_status = $BL->REQUEST['ticket_status'];
            }
            include_once $BL->include_page("ticket_list.php");
            break;
        }
        case "topics" :
        {
            $conf   = $BL->conf;
            $topics = $BL->support_topics->find();
            $ticket = array();
            $count_close = array();
            $count_open  = array();
            foreach ($topics as $val)
            {
                $count_close[$val['topic_id']] = 0;;
                $count_open[$val['topic_id']]  = 0;
                $ticket[$val['topic_id']]      = array();
                $temp                          = $BL->support_tickets->find(array("WHERE `topic_id`=".intval($val['topic_id'])));
                foreach ($temp as $v)
                {
                    $count_open[$val['topic_id']] = ($v['ticket_status'] != 3)?$count_open[$val['topic_id']] + 1:$count_open[$val['topic_id']];
                    $count_close[$val['topic_id']]= ($v['ticket_status'] == 3)?$count_close[$val['topic_id']] + 1:$count_close[$val['topic_id']];
                }
                $ticket[$val['topic_id']]= $BL->support_topics->getByKey($val['topic_id']);
            }
            $topic_id_array  = array();
            $temp            = explode("<&&>", $_SESSION['dept_id']);
            foreach ($temp as $v)
            {
                if (!empty($v))
                {
                    $topic_id_array[]= $v;
                }
            }
            include_once $BL->include_page("topic_list.php");
            break;
        }
        case "edit_topic" :
        {
            if(isset($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['Update'])
            {
                if($BL->support_topics->update($BL->REQUEST))
                {
                    $BL->Redirect("topics");
                    break;
                }
            }
            $topic = $BL->support_topics->getByKey($BL->REQUEST['topic_id']);
            $title = $BL->props->lang['Edit_Topic'];
            include_once $BL->include_page("topics.php");
            break;
        }
        case "add_topic" :
        {
            if(isset($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['add'])
            {
                if($BL->support_topics->insert($BL->REQUEST))
                {
                    $BL->Redirect("topics");
                    break;
                }
            }
            $title= $BL->props->lang['Add_Topic'];
            include_once $BL->include_page("topics.php");
            break;
        }
        case "del_topic" :
        {
            $BL->support_topics->delete(array("WHERE `topic_id`=".intval($BL->REQUEST['topic_id'])));
            $BL->Redirect("topics");
            break;
        }
        case "act_support" :
        {
            if(isset($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['submit'])
            {
                $BL->configurations->update($BL->REQUEST);
            }
            $BL->Redirect("topics");
            break;
        }
        #######################################################SUPPORT END#######################################################################
        ########################################################NEWSLETTER START#################################################################
        case "emailannounce" :
        {
            $conf     = $BL->conf;
            $products = $BL->products->find();
            $subdomains = $BL->subdomains->find();
            $tlds     = $BL->tlds->find();

            if (isset ($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['send_announce'])
            {
                $BL->REQUEST['FromDate']  = $BL->REQUEST['year_fieldfromD']."-".$BL->REQUEST['month_fieldfromD']."-".$BL->REQUEST['date_fieldfromD'];
                $BL->REQUEST['ToDate']    = $BL->REQUEST['year_fieldtoD']."-".$BL->REQUEST['month_fieldtoD']."-".$BL->REQUEST['date_fieldtoD'];
                $BL->REQUEST['newsletter_body'] = !empty($BL->REQUEST['send_as_html'])?$BL->REQUEST['newsletter_body1']:$BL->REQUEST['newsletter_body2'];
                if($BL->REQUEST['save_before_send']==1)
                {
                    $return_id = $BL->newsletters->save($BL->REQUEST);
                    if(!isset($BL->REQUEST['newsletter_id']) || empty($BL->REQUEST['newsletter_id']))
                    {
                        $BL->REQUEST['newsletter_id'] = $return_id;
                    }
                }

                $customers = array();
                if($BL->REQUEST['customer_1']==0)
                {
                    $customers = $BL->customers->get("WHERE `cust_deleted`='0'");
                }
                elseif($BL->REQUEST['customer_1']==1)
                {
                    $customers = $BL->customers->get("WHERE `trusted`='1' AND `cust_deleted`='0'");
                }
                elseif($BL->REQUEST['customer_1']==2)
                {
                    $customers = $BL->customers->get("WHERE `trusted`!='1' AND `cust_deleted`='0'");
                }
                elseif($BL->REQUEST['customer_1']==3)
                {
                    $condition = " `orders`.dom_reg_type='1' ";
                    if($BL->REQUEST['tld_1'])
                    {
                        if($BL->REQUEST['tld_2'])
                        {
                            $condition .= " AND `orders`.domain_name LIKE '%".$BL->utils->quoteSmart($BL->REQUEST['tld_2'])."' ";
                        }
                    }
                    else
                    {
                        if($BL->REQUEST['tld_2'])
                        {
                            $condition .= " AND `orders`.domain_name NOT LIKE '%".$BL->utils->quoteSmart($BL->REQUEST['tld_2'])."' ";
                        }
                        else
                        {
                            $condition = " `orders`.dom_reg_type!='1' ";
                        }
                    }
                    $orders = $BL->orders->get("WHERE ".$condition." AND `customers`.cust_deleted='0'");
                    foreach($orders as $order)
                    {
                        $customers[$order['id']] = $BL->customers->getByKey($order['id']);
                    }
                }
                elseif($BL->REQUEST['customer_1']==4)
                {
                    $condition = " `orders`.dom_reg_type='2' ";
                    if($BL->REQUEST['sd_1'])
                    {
                        if($BL->REQUEST['sd_2'])
                        {
                            $condition .= " AND `orders`.domain_name LIKE '%".$BL->utils->quoteSmart($BL->REQUEST['sd_2'])."' ";
                        }
                    }
                    else
                    {
                        if($BL->REQUEST['sd_2'])
                        {
                            $condition .= " AND `orders`.domain_name NOT LIKE '%".$BL->utils->quoteSmart($BL->REQUEST['sd_2'])."' ";
                        }
                        else
                        {
                            $condition = " `orders`.dom_reg_type!='2' ";
                        }
                    }
                    $orders = $BL->orders->get("WHERE ".$condition." AND `customers`.cust_deleted='0'");
                    foreach($orders as $order)
                    {
                        $customers[$order['id']] = $BL->customers->getByKey($order['id']);
                    }
                }
                elseif($BL->REQUEST['customer_1']==5)
                {
                    $condition = " `orders`.product_id!='0' ";
                    if($BL->REQUEST['product_1'])
                    {
                        if($BL->REQUEST['product_2'])
                        {
                            $condition .= " AND `orders`.product_id = ".intval($BL->REQUEST['product_2'])." ";
                        }
                    }
                    else
                    {
                        if($BL->REQUEST['product_2'])
                        {
                            $condition .= " AND `orders`.product_id != ".intval($BL->REQUEST['product_2'])." ";
                        }
                        else
                        {
                            $condition = " `orders`.product_id='0' ";
                        }
                    }
                    $orders = $BL->orders->get("WHERE ".$condition." AND `customers`.cust_deleted='0'");
                    foreach($orders as $order)
                    {
                        $customers[$order['id']] = $BL->customers->getByKey($order['id']);
                    }
                }
                elseif($BL->REQUEST['customer_1']==6)
                {
                    foreach($BL->customers->get("WHERE `cust_deleted`='0'") as $customer)
                    {
                        $accounts = $BL->getAccounts($customer['id']);
                        if(
                            ( $BL->REQUEST['total_1'] && ($accounts[$BL->props->invoice_status[0]]+$accounts[$BL->props->invoice_status[1]])>$BL->REQUEST['total_2']) ||
                            (!$BL->REQUEST['total_1'] && ($accounts[$BL->props->invoice_status[0]]+$accounts[$BL->props->invoice_status[1]])<$BL->REQUEST['total_2'])
                        )
                        {
                            $customers[$customer['id']] = $BL->customers->getByKey($customer['id']);
                        }
                    }
                }
                elseif($BL->REQUEST['customer_1']==7)
                {
                    foreach($BL->customers->get("WHERE `cust_deleted`='0'") as $customer)
                    {
                        $accounts = $BL->getAccounts($customer['id']);
                        if(
                            ( $BL->REQUEST['paid_1'] && ($accounts[$BL->props->invoice_status[1]])>$BL->REQUEST['paid_2']) ||
                            (!$BL->REQUEST['paid_1'] && ($accounts[$BL->props->invoice_status[1]])<$BL->REQUEST['paid_2'])
                        )
                        {
                            $customers[$customer['id']] = $BL->customers->getByKey($customer['id']);
                        }
                    }
                }
                elseif($BL->REQUEST['customer_1']==8)
                {
                    foreach($BL->customers->get("WHERE `cust_deleted`='0'") as $customer)
                    {
                        $accounts = $BL->getAccounts($customer['id']);
                        if(
                            ( $BL->REQUEST['due_1'] && ($accounts[$BL->props->invoice_status[0]])>$BL->REQUEST['due_2']) ||
                            (!$BL->REQUEST['due_1'] && ($accounts[$BL->props->invoice_status[0]])<$BL->REQUEST['due_2'])
                        )
                        {
                            $customers[$customer['id']] = $BL->customers->getByKey($customer['id']);
                        }
                    }
                }
                elseif($BL->REQUEST['customer_1']==9)
                {
                    foreach($BL->customers->get("WHERE `cust_deleted`='0'") as $customer)
                    {
                        $country = $BL->getCustomerFieldValue("country", $customer['id']);
                        $state   = $BL->getCustomerFieldValue("state", $customer['id']);
                        if($BL->REQUEST['country_1'])
                        {
                            if($BL->REQUEST['country_2'] == $country || !$BL->REQUEST['country_2'])
                            {
                                if($BL->REQUEST['country_3'] == $state || !$BL->REQUEST['country_3'])
                                {
                                    $customers[$customer['id']] = $BL->customers->getByKey($customer['id']);
                                }
                            }
                        }
                        else
                        {
                            if($BL->REQUEST['country_2'] != $country && $BL->REQUEST['country_2'])
                            {
                                if($BL->REQUEST['country_3'] != $state && !$BL->REQUEST['country_3'])
                                {
                                    $customers[$customer['id']] = $BL->customers->getByKey($customer['id']);
                                }
                            }
                        }

                    }
                }
                elseif($BL->REQUEST['customer_1']==10)
                {
                    foreach($BL->customers->get("WHERE `cust_deleted`='0'") as $customer)
                    {
                        if($BL->REQUEST['discount_1']==2)
                        {
                            if($BL->REQUEST['discount_2']<$customer['discount'])
                            {
                                $customers[$customer['id']] = $BL->customers->getByKey($customer['id']);
                            }
                        }
                        elseif($BL->REQUEST['discount_1']==1)
                        {
                            if($BL->REQUEST['discount_2']==$customer['discount'])
                            {
                                $customers[$customer['id']] = $BL->customers->getByKey($customer['id']);
                            }
                        }
                        else
                        {
                            if($BL->REQUEST['discount_2']>$customer['discount'])
                            {
                                $customers[$customer['id']] = $BL->customers->getByKey($customer['id']);
                            }
                        }
                    }
                }

                $BL->REQUEST['cust_email'] = array();
                foreach($customers as $customer)
                {
                    if($BL->REQUEST['all_dates']==true)
                    {
                        $BL->REQUEST['cust_email'][] = $customer['email'];
                    }
                    elseif($customer['creation_date']>$BL->REQUEST['FromDate'] && $customer['creation_date']<$BL->REQUEST['ToDate'])
                    {
                        $BL->REQUEST['cust_email'][$customer['id']] = $customer['email'];
                    }
                }

                $msg    = $BL->props->lang['newsletter_to']."<br />";
                $subject= $BL->REQUEST['newsletter_subject'];
                $message= $BL->REQUEST['newsletter_body'];
                if(!empty($subject)  && !empty($message) && count($BL->REQUEST['cust_email']))
                {
                    foreach ($BL->REQUEST['cust_email'] as $id=>$email)
                    {
                        $BL->ALPmail->AddAddress($email);
                        $BL->ALPmail->Subject  = $subject;
                        $BL->ALPmail->Body     = $message;
                        $BL->ALPmail->AltBody  = strip_tags($message);
                        $BL->ALPmail->IsHTML(true);
                        if($BL->ALPmail->sendMail())
                        {
                            $msg .= "<b>".$BL->getCustomerFieldValue("name",$id)."</b> {".$email."}<br>";
                        }
                    }
                    $BL->utils->alert($msg);
                    $newsletters = $BL->newsletters->find();
                    include_once $BL->include_page("savedannouncement.php");
                    break;
                }
                elseif(!count($BL->REQUEST['cust_email']))
                {
                    $err= $BL->props->lang['no_customers_found_in_this_criteria'];
                }
                else
                {
                    $err= $BL->props->lang['empty_message'];
                }
                if(isset($err))
                {
                    $BL->utils->alert($err);
                }
            }
            if(isset($BL->REQUEST['newsletter_id']) && $BL->REQUEST['newsletter_id'])
            {
                $BL->REQUEST = $BL->newsletters->getByKey($BL->REQUEST['newsletter_id']);
            }
            $title = $BL->props->lang['~emailannounce'];
            include_once $BL->include_page("emailannouncement.php");
            break;
        }
        case "savedannounce" :
        {
            $newsletters = $BL->newsletters->find();
            include_once $BL->include_page("savedannouncement.php");
            break;
        }
        case "delsavedannounce" :
        {
            $BL->newsletters->delete(array("WHERE `newsletter_id`=".intval($BL->REQUEST['newsletter_id'])));
            $BL->Redirect("savedannounce");
            break;
        }
        ########################################################NEWSLETTER END###################################################################
        ########################################################REPORT START#####################################################################
        case "assets" :
        {
            $conf = $BL->conf;
            $curr_array = $BL->curr_conf;
            $curr_array['str2'] = '';//remove the thousand separator //bug fix
            $BL->report->setParam();
            $BL->report->rAllDate = true;
            if(isset($BL->REQUEST['all_dates']) && $BL->REQUEST['all_dates']==true)
            {
                $BL->report->rAllDate   = true;
            }
            elseif(isset($BL->REQUEST['year_fieldfromD']))
            {
                $BL->report->rAllDate   = false;
                $BL->report->rFromDate  = $BL->REQUEST['year_fieldfromD']."-".$BL->REQUEST['month_fieldfromD']."-".$BL->REQUEST['date_fieldfromD'];
                $BL->report->rToDate    = $BL->REQUEST['year_fieldtoD']."-".$BL->REQUEST['month_fieldtoD']."-".$BL->REQUEST['date_fieldtoD'];
            }
            //Data for income_all
            if((isset($BL->REQUEST['submit']) && $BL->REQUEST['r_type']=="income_all") || (!isset($BL->REQUEST['r_type']) && !isset($BL->REQUEST['submit'])))
            {
                $Amounts              = array();
                $BL->report->rColumns = array('gross_amount','due_date','status');
                $Datas                = $BL->report->invoiceReport();
                foreach($Datas as $Data)
                {
                    foreach($BL->props->invoice_status as $index=>$status)
                    {
                        if($Data['status']==$status && $index!=3 && $index!=4)
                        {
                            $Amounts[$index] = !isset($Amounts[$index])?$Data['gross_amount']:($Amounts[$index] + $Data['gross_amount']);
                        }
                    }
                }
                $report_image_data = "title=".$BL->props->lang['income_all']."&type=vbar&";
                foreach($BL->props->invoice_status as $index=>$status)
                {
                    if($index!=3 && $index!=4)
                    {
                        $amt = isset($Amounts[$index])?$Amounts[$index]:0;
                        $report_image_data .= "datas[".$index."][0]=".$BL->props->lang[$status]."(".$BL->toCurrency($amt,array(),1).")&";
                        $report_image_data .= "datas[".$index."][1]=".$BL->toCurrency($amt,$curr_array,1,0)."&";
                    }
                }
            }
            //Data for income_country
            if(isset($BL->REQUEST['submit']) && $BL->REQUEST['r_type']=="income_country")
            {
                $Amounts              = array();
                $BL->report->rColumns = array('gross_amount','due_date','customer_id');
                $Datas                = $BL->report->invoiceReport($BL->props->invoice_status[1]);
                foreach($Datas as $Data)
                {
                    $country_code = $BL->getCustomerFieldValue("country",$Data['customer_id']);
                    $Amounts[$country_code] = !isset($Amounts[$country_code])?$Data['gross_amount']:($Amounts[$country_code] + $Data['gross_amount']);
                }
                $report_image_data = "title=".$BL->props->lang['income_country']."&type=pie&";
                $index = 0;
                foreach($Amounts as $country_code=>$amt)
                {
                    $report_image_data .= "datas[".$index."][0]=".$BL->props->country[$country_code]."(".$BL->toCurrency($amt,array(),1).")&";
                    $report_image_data .= "datas[".$index."][1]=".$BL->toCurrency($amt,$curr_array,1,0)."&";
                    $index++;
                }
            }
            //Data for income_yearly
            if(isset($BL->REQUEST['submit']) && $BL->REQUEST['r_type']=="income_yearly")
            {
                $Amounts              = array();
                $BL->report->rColumns = array('gross_amount','due_date');
                $Datas                = $BL->report->invoiceReport($BL->props->invoice_status[1]);
                foreach($Datas as $Data)
                {
                    $date = $BL->utils->getDateArray($Data['due_date']);
                    $year = $date['year'];
                    $Amounts[$year] = !isset($Amounts[$year])?$Data['gross_amount']:($Amounts[$year] + $Data['gross_amount']);
                }
                ksort($Amounts);
                $report_image_data = "title=".$BL->props->lang['income_yearly']."&type=vbar&";
                $index = 0;
                foreach($Amounts as $year=>$amt)
                {
                    $report_image_data .= "datas[".$index."][0]=".$year."(".$BL->toCurrency($amt,array(),1).")&";
                    $report_image_data .= "datas[".$index."][1]=".$BL->toCurrency($amt,$curr_array,1,0)."&";
                    $index++;
                }
            }
            //Data for income_monthly
            if(isset($BL->REQUEST['submit']) && $BL->REQUEST['r_type']=="income_monthly")
            {
                $Amounts              = array();
                $BL->report->rColumns = array('gross_amount','due_date');
                $Datas                = $BL->report->invoiceReport($BL->props->invoice_status[1]);
                foreach($Datas as $Data)
                {
                    $date = $BL->utils->getDateArray($Data['due_date']);
                    $Amounts[$date['year']][$date['mon']] = !isset($Amounts[$date['year']][$date['mon']])?$Data['gross_amount']:($Amounts[$date['year']][$date['mon']] + $Data['gross_amount']);
                }
                foreach($Amounts as $year=>$Amount)
                {
                    ksort($Amounts[$year]);
                }
                ksort($Amounts);
                $report_image_data = "title=".$BL->props->lang['income_monthly']."&type=vbar&";
                $index = 0;
                foreach($Amounts as $year=>$data)
                {
                    foreach($data as $month=>$amt)
                    {
                        $report_image_data .= "datas[".$index."][0]=".date('M-Y',strtotime($year."-".$month."-1"))."(".$BL->toCurrency($amt,array(),1).")&";
                        $report_image_data .= "datas[".$index."][1]=".$BL->toCurrency($amt,$curr_array,1,0)."&";
                        $index++;
                    }
                }
            }
            //Data for sales_product
            if(isset($BL->REQUEST['submit']) && $BL->REQUEST['r_type']=="sales_product")
            {
                $Amounts              = array();
                $Counts               = array();
                $BL->report->rColumns = array('amt','product_id');
                $Datas                = $BL->report->salesReport();
                foreach($Datas as $Data)
                {
                    if(!empty($Data['product_id']))
                    {
                        $Amounts[$Data['product_id']] = !isset($Amounts[$Data['product_id']])?$Data['amt']:($Amounts[$Data['product_id']] + $Data['amt']);
                        $Counts[$Data['product_id']] = !isset($Counts[$Data['product_id']])?1:($Counts[$Data['product_id']] + 1);
                    }
                }
                ksort($Amounts);
                $report_image_data = "title=".$BL->props->lang['sales_product']."(".$BL->props->lang['Total_invoiced_amounts'].")&type=pie&";
                $report_image_data_2 = "title=".$BL->props->lang['sales_product']."(".$BL->props->lang['Total_number_of_orders'].")&type=pie&";
                $index = 0;
                foreach($Amounts as $product_id=>$amt)
                {
                    $report_image_data .= "datas[".$index."][0]=".$BL->getFriendlyName($product_id)."(".$BL->toCurrency($amt,array(),1).")&";
                    $report_image_data .= "datas[".$index."][1]=".$BL->toCurrency($amt,$curr_array,1,0)."&";
                    $report_image_data_2 .= "datas[".$index."][0]=".$BL->getFriendlyName($product_id)."(".$Counts[$product_id].")&";
                    $report_image_data_2 .= "datas[".$index."][1]=".$Counts[$product_id]."&";
                    $index++;
                }
            }
            //Data for ord_domain
            if(isset($BL->REQUEST['submit']) && $BL->REQUEST['r_type']=="ord_domain")
            {
                $Amounts              = array();
                $Counts               = array();
                $BL->report->rColumns = array('amt','dom_reg_type','domain_name');
                $Datas                = $BL->report->salesReport();
                foreach($Datas as $Data)
                {
                    $key = ($Data['dom_reg_type']==0)?'Owndomain':(($Data['dom_reg_type']==1)?'Newdomain':'Subdomain');
                    if(strlen($Data['domain_name'])<3)$key = 'No_Domain';
                    $Amounts[$key] = !isset($Amounts[$key])?$Data['amt']:($Amounts[$key] + $Data['amt']);
                    $Counts[$key] = !isset($Counts[$key])?1:($Counts[$key] + 1);
                }
                ksort($Amounts);
                $report_image_data = "title=".$BL->props->lang['ord_domain']."(".$BL->props->lang['Total_invoiced_amounts'].")&type=pie&";
                $report_image_data_2 = "title=".$BL->props->lang['ord_domain']."(".$BL->props->lang['Total_number_of_orders'].")&type=pie&";
                $index = 0;
                foreach($Amounts as $key=>$amt)
                {
                    $report_image_data .= "datas[".$index."][0]=".$BL->props->lang[$key]."(".$BL->toCurrency($amt,array(),1).")&";
                    $report_image_data .= "datas[".$index."][1]=".$BL->toCurrency($amt,$curr_array,1,0)."&";
                    $report_image_data_2 .= "datas[".$index."][0]=".$BL->props->lang[$key]."(".$Counts[$key].")&";
                    $report_image_data_2 .= "datas[".$index."][1]=".$Counts[$key]."&";
                    $index++;
                }
            }
            include_once $BL->include_page("reports.php");
            break;
        }
        case "growth" :
        {
            $conf = $BL->conf;
            $curr_array = $BL->curr_conf;
            $curr_array['str2'] = '';//remove the thousand separator //bug fix
            $BL->report->setParam();
            //Data for 2_years
            if((isset($BL->REQUEST['submit']) && $BL->REQUEST['r_type']=="2_years")  || (!isset($BL->REQUEST['r_type']) && !isset($BL->REQUEST['submit'])))
            {
                $BL->report->rAllDate   = false;
                $BL->report->rFromDate  = (date('Y')-2)."-01-01";
                $BL->report->rToDate    = (date('Y')-1)."-12-31";
                $Amounts              = array();
                $BL->report->rColumns = array('gross_amount','due_date');
                $Datas                = $BL->report->invoiceReport($BL->props->invoice_status[1]);
                $year = date('Y'); // default
                foreach($Datas as $Data)
                {
                    $date = $BL->utils->getDateArray($Data['due_date']);
                    $year = $date['year'];
                    $Amounts[$year] = !isset($Amounts[$year])?$Data['gross_amount']:($Amounts[$year] + $Data['gross_amount']);
                }
                ksort($Amounts);
                $Amounts[date('Y')]   = isset($Amounts[date('Y')])?$Amounts[date('Y')]:0;
                $Amounts[date('Y')-1] = isset($Amounts[date('Y')-1])?$Amounts[date('Y')-1]:0;
                $Amounts[date('Y')-2] = isset($Amounts[date('Y')-2])?$Amounts[date('Y')-2]:0;
                //growth rate
                if (!empty($Amounts[(date('Y')-2)]))
                    $growth_rate = 100*(($Amounts[(date('Y')-1)]- $Amounts[(date('Y')-2)])/$Amounts[(date('Y')-2)]);//%
                else
                    $growth_rate = 0;
                //this year projected
                $Amounts[date('Y')]     = $Amounts[(date('Y')-1)]+($Amounts[(date('Y')-1)]*($growth_rate/100));
                //next year projected
                $Amounts[(date('Y')+1)] = $Amounts[date('Y')]+($Amounts[date('Y')]*($growth_rate/100));
                //next to next year projected
                $Amounts[(date('Y')+2)] = $Amounts[(date('Y')+1)]+($Amounts[(date('Y')+1)]*($growth_rate/100));
                $report_image_data = "title=".$BL->props->lang['Projected_income']." ".$BL->props->lang['Based_on_last_2_years']." (".$BL->props->lang['current_growth_rate'].$BL->utils->toFloat($growth_rate)."%)"."&type=line&";
                $report_image_data .= "datas[0][0]=".$year."(".$BL->toCurrency($Amounts[date('Y')-1],$curr_array,1).")&";
                $report_image_data .= "datas[0][1]=".$BL->toCurrency($Amounts[date('Y')-1],$curr_array,1,0)."&";
                $report_image_data .= "datas[1][0]=".$year."(".$BL->toCurrency($Amounts[date('Y')],$curr_array,1).")&";
                $report_image_data .= "datas[1][1]=".$BL->toCurrency($Amounts[date('Y')],$curr_array,1,0)."&";
                $report_image_data .= "datas[2][0]=".$year."(".$BL->toCurrency($Amounts[date('Y')+1],$curr_array,1).")&";
                $report_image_data .= "datas[2][1]=".$BL->toCurrency($Amounts[date('Y')+1],$curr_array,1,0)."&";
                $report_image_data .= "datas[3][0]=".$year."(".$BL->toCurrency($Amounts[date('Y')+2],$curr_array,1).")&";
                $report_image_data .= "datas[3][1]=".$BL->toCurrency($Amounts[date('Y')+2],$curr_array,1,0)."&";
            }
            //Data for 12_months
            if(isset($BL->REQUEST['submit']) && $BL->REQUEST['r_type']=="12_months")
            {
                $num = cal_days_in_month(CAL_GREGORIAN, (date('m')-1), date('Y'));
                $BL->report->rAllDate   = false;
                $BL->report->rFromDate  = (date('Y')-2)."-01-01";
                $BL->report->rToDate    = (date('Y')-1)."-12-31";
                $Amounts              = array();
                $BL->report->rColumns = array('gross_amount','due_date');
                $Datas                = $BL->report->invoiceReport($BL->props->invoice_status[1]);
                foreach($Datas as $Data)
                {
                    $date = $BL->utils->getDateArray($Data['due_date']);
                    $year = $date['year'];
                    $month= $date['mon'];
                    $Amounts[$year][$month] = !isset($Amounts[$year][$month])?$Data['gross_amount']:($Amounts[$year][$month] + $Data['gross_amount']);
                }
                foreach($Amounts as $year=>$Amount)
                {
                    ksort($Amounts[$year]);
                }
                ksort($Amounts);
                //calulate growth
                $prev_v = 0;
                $i      = 0;
                $growth = array();
                foreach($Amounts as $year=>$year_data)
                {
                    ksort($year_data);
                    foreach($year_data as $month=>$month_data)
                    {
                        $month1 = $month;
                        if($i==0)
                        {
                            $prev_v = $month_data;
                            $i++;
                        }
                        else
                        {
                            $growth[$year.":".$month] = 100*(($month_data-$prev_v)/$month_data);
                            $prev_v = $month_data;
                        }
                    }
                }
                $month_duration = $BL->report->rFromDate."->".$BL->report->rToDate;
                //average growth
                if (count($growth) > 0)
                    $avg_growth = array_sum($growth)/count($growth);
                else
                    $avg_growth = 0;
                //calculate this year income
                $currentyearincome = 0;
                $Amounts[date('Y')] = isset($Amounts[date('Y')])?$Amounts[date('Y')]:array();
                foreach($Amounts[date('Y')] as $month=>$month_data)
                {
                    if($month<date('m'))
                    {
                        $currentyearincome = $currentyearincome + $month_data;
                    }
                }
                //calculate last year income
                $lastyearincome= 0;
                $Amounts[(date('Y')-1)] = isset($Amounts[(date('Y')-1)])?$Amounts[(date('Y')-1)]:array();
                foreach($Amounts[(date('Y')-1)] as $month=>$month_data)
                {
                    if($month>=date('m'))
                    {
                        $lastyearincome = $lastyearincome + $month_data;
                    }
                }
                $report_data = array();
                //last 12 months income
                $report_data[$month_duration] = $currentyearincome + $lastyearincome;
                //next 3 year projected income
                $report_data[date('Y')] = $currentyearincome;

                $prev_m = isset($Amounts[date('Y')][date('m',strtotime(date('Y')."-".(date('m')-1)."-01"))])?$Amounts[date('Y')][date('m',strtotime(date('Y')."-".(date('m')-1)."-01"))]:0;
                $k=date('m');
                for($j=0;$j<3;$j++)
                {
                    for($i=$k;$i<13;$i++)
                    {
                        $report_data[(date('Y')+$j)] = isset($report_data[(date('Y')+$j)])?$report_data[(date('Y')+$j)]:0;
                        $report_data[(date('Y')+$j)] = $report_data[(date('Y')+$j)] + $prev_m + ($prev_m*($avg_growth/100));
                        $prev_m = $prev_m + ($prev_m*($avg_growth/100));
                    }
                    $k=1;
                }
                $report_image_data = "title=".$BL->props->lang['Projected_income']." ".$BL->props->lang['Based_on_last_12_months']."&type=line&";
                $index = 0;
                foreach($report_data as $key=>$amt)
                {
                    $report_image_data .= "datas[".$index."][0]=".$key."(".$BL->toCurrency($amt,array(),1).")&";
                    $report_image_data .= "datas[".$index."][1]=".$BL->toCurrency($amt,$curr_array,1,0)."&";
                    $index++;
                }

            }
            include_once $BL->include_page("reports.php");
            break;
        }
        ########################################################REPORT END#####################################################################
        ################################################Settings START#################################################
        case "editfaqgroup" :
        {
            if(isset($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['Update'])
            {
                if($BL->faqgroups->update($BL->REQUEST))
                {
                    $BL->Redirect("faqgroup");
                    break;
                }
            }
            $title = $BL->props->lang['+editfaqgroup'];
            $faqgroup   = $BL->faqgroups->getByKey($BL->REQUEST['faqgroup_id']);
            include_once $BL->include_page("faqgroups.php");
            break;
        }
        case "editfaq" :
        {
            if(isset($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['Update'])
            {
                if($BL->faqs->update($BL->REQUEST))
                {
                    $BL->Redirect("faq");
                    break;
                }
            }
            $faqgroups = $BL->faqgroups->find();
            $title = $BL->props->lang['+editfaq'];
            $faq   = $BL->faqs->getByKey($BL->REQUEST['faq_id']);
            include_once $BL->include_page("faqs.php");
            break;
        }
        case "addfaqgroup" :
        {
            if(isset($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['add'])
            {
                if($BL->faqgroups->insert($BL->REQUEST))
                {
                    $BL->Redirect("faqgroup");
                    break;
                }
            }
            $title = $BL->props->lang['+addfaqgroup'];
            include_once $BL->include_page("faqgroups.php");
            break;
        }
        case "addfaq" :
        {
            if(isset($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['add'])
            {
                if($BL->faqs->insert($BL->REQUEST))
                {
                    $BL->Redirect("faq");
                    break;
                }
            }
            $faqgroups = $BL->faqgroups->find();
            $title = $BL->props->lang['+addfaq'];
            include_once $BL->include_page("faqs.php");
            break;
        }
        case "faqgroup" :
        {
            $faqgroups = $BL->faqgroups->find();
            include_once $BL->include_page("faqgroup_list.php");
            break;
        }
        case "faq" :
        {
            $BL->faqs->setOrder("faqgroup_id");
            $faqs = $BL->faqs->find();
            include_once $BL->include_page("faq_list.php");
            break;
        }
        case "delfaqgroup" :
        {
            $BL->faqgroups->delete(array("WHERE `faqgroup_id`=".intval($BL->REQUEST['faqgroup_id'])));
            $BL->Redirect("faqgroup");
            break;
        }
        case "delfaq" :
        {
            $BL->faqs->delete(array("WHERE `faq_id`=".intval($BL->REQUEST['faq_id'])));
            $BL->Redirect("faq");
            break;
        }
        case "editannounce" :
        {
            if(isset($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['Update'])
            {
                if($BL->announcements->update($BL->REQUEST))
                {
                    $BL->Redirect("announce");
                    break;
                }
            }
            $announce = $BL->announcements->getByKey($BL->REQUEST['ann_id']);
            $title    = $BL->props->lang['+editannounce'];
            include_once $BL->include_page("announcement.php");
            break;
        }
        case "addannounce" :
        {
            if(isset($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['add'])
            {
                if($BL->announcements->insert($BL->REQUEST))
                {
                    $BL->Redirect("announce");
                    break;
                }
            }
            $title = $BL->props->lang['+addannounce'];
            include_once $BL->include_page("announcement.php");
            break;
        }
        case "announce" :
        {
            $announces = $BL->announcements->find();
            include_once $BL->include_page("announce_list.php");
            break;
        }
        case "delannounce" :
        {
            $BL->announcements->delete(array("WHERE `ann_id`=".intval($BL->REQUEST['ann_id'])));
            $BL->Redirect("announce");
            break;
        }
        case "e_templates" :
        {
            if(isset($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['Update'])
            {
                $BL->emails->update($BL->REQUEST);
            }
            $e_templates= $BL->emails->find();
            include_once $BL->include_page("e_templates.php");
            break;
        }
        case "edittax" :
        {
            if(isset($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['Update'])
            {
                $tc_array    = isset($BL->REQUEST['tax_country'])?$BL->REQUEST['tax_country']:array("ALL");
                $ts_array    = isset($BL->REQUEST['tax_state'])?$BL->REQUEST['tax_state']:array("ALL");
                $tax_country = (!count($tc_array) || $tc_array[0] == "ALL")?"ALL":"|";
                $tax_state   = (!count($tc_array) || count($tc_array)>1 || $ts_array[0] == "ALL")?"ALL":"|";
                if($tax_country=="|")
                {
                    foreach ($tc_array as $k => $v)
                    {
                        $tax_country .= trim($v) . "|";
                    }
                }
                if($tax_state=="|")
                {
                    foreach ($ts_array as $k => $v)
                    {
                        $tax_state .= trim($v) . "|";
                    }
                }
                $BL->REQUEST['tax_country'] = $tax_country;
                $BL->REQUEST['tax_state']   = $tax_state;
                if($BL->taxes->update($BL->REQUEST))
                {
                    $BL->Redirect("tax");
                    break;
                }
            }

            $tax_id     = $BL->REQUEST['tax_id'];
            $tax        = $BL->taxes->getByKey($tax_id);
            $tc_array   = array();
            $temp       = explode("|",$tax['tax_country']);
            foreach($temp as $country)
            {
                $country= trim($country);
                if(!empty($country))
                {
                    $tc_array[] = $country;
                }
            }
            $tc_array   = $BL->utils->Get_Uniques_Array($tc_array);

            if($tax['tax_country'] == "ALL")
            {
                $tc_array = "ALL";
            }
            $ts_array   = array();
            $temp       = explode("|",$tax['tax_state']);
            foreach($temp as $state)
            {
                $state  = trim($state);
                if(!empty($state))
                {
                    $ts_array[] = $state;
                }
            }
            $ts_array   = $BL->utils->Get_Uniques_Array($ts_array);
            if($tax['tax_state'] == "ALL" || $tax['tax_state'] == "|" || empty($tax['tax_state']))
            {
                $ts_array = "ALL";
            }
            $title = $BL->props->lang['+edittax'];
            include_once $BL->include_page("tax.php");
            break;
        }
        case "addtax" :
        {
            if(isset($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['add'])
            {
                $index       = count($BL->taxes->find()) + 1;
                $tc_array    = isset($BL->REQUEST['tax_country'])?$BL->REQUEST['tax_country']:array("ALL");
                $ts_array    = isset($BL->REQUEST['tax_state'])?$BL->REQUEST['tax_state']:array("ALL");
                $tax_country = (!count($tc_array) || $tc_array[0] == "ALL")?"ALL":"|";
                $tax_state   = (!count($tc_array) || count($tc_array)>1 || $ts_array[0] == "ALL")?"ALL":"|";
                if($tax_country=="|")
                {
                    foreach ($tc_array as $k => $v)
                    {
                        $tax_country .= trim($v) . "|";
                    }
                }
                if($tax_state=="|")
                {
                    foreach ($ts_array as $k => $v)
                    {
                        $tax_state .= trim($v) . "|";
                    }
                }
                $BL->REQUEST['tax_index']   = $index;
                $BL->REQUEST['tax_country'] = $tax_country;
                $BL->REQUEST['tax_state']   = $tax_state;
                if($BL->taxes->insert($BL->REQUEST))
                {
                    $BL->Redirect("tax");
                    break;
                }
            }
            $title = $BL->props->lang['+addtax'];
            include_once $BL->include_page("tax.php");
            break;
        }
        case "tax" :
        {
            if (isset($BL->REQUEST['action']) && $BL->REQUEST['action']=="changestatus")
            {
                $BL->taxes->update($BL->REQUEST);
            }
            if (isset($BL->REQUEST['action']) && $BL->REQUEST['action']=="up")
            {
                $BL->taxes->moveUp($BL->REQUEST['tax_id'],$BL->REQUEST['tax_index']);
            }
            if (isset($BL->REQUEST['action']) && $BL->REQUEST['action']=="down")
            {
                $BL->taxes->moveDown($BL->REQUEST['tax_id'],$BL->REQUEST['tax_index']);
            }
            if (isset($BL->REQUEST['action']) && $BL->REQUEST['action']=="tax_display")
            {
                $BL->configurations->update(array("tax_calculation"=>$BL->REQUEST['tax_calculation']));
            }
            if (isset ($BL->REQUEST['action']) && $BL->REQUEST['action']=="togglevat")
            {
                $BL->configurations->update(array("en_vat"=>$BL->REQUEST['en_vat']));
            }
            $BL->loadConf();
            $conf  = $BL->conf;
            $BL->taxes->setOrder("tax_index");
            $taxes = $BL->taxes->find();
            include_once $BL->include_page("tax_list.php");
            break;
        }
        case "deltax" :
        {
            $BL->taxes->delete(array("WHERE `tax_id`=".intval($BL->REQUEST['tax_id'])));
            $BL->Redirect("tax");
        }
        case "edittld" :
        {
            if(isset($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['Update'])
            {
                if (!empty($BL->REQUEST['dom_ext1']))
                {
                    $BL->REQUEST['dom_ext'] = $BL->REQUEST['dom_ext1'];
                }
                $server_array = $BL->props->tld_array[$BL->REQUEST['dom_ext']];
                if (empty($BL->REQUEST['tld_server']))
                {
                    $BL->REQUEST['tld_server'] = $server_array['server'];
                }
                if (empty($BL->REQUEST['tld_match']))
                {
                    $BL->REQUEST['tld_match']  = $server_array['nomatch'];
                }
                if (!empty($BL->REQUEST['tld_server']) && !empty($BL->REQUEST['tld_match']))
                {
                    if($BL->tlds->update($BL->REQUEST))
                    {
                        $BL->Redirect("tld");
                        break;
                    }
                }
            }
            $tld = $BL->tlds->getByKey($BL->REQUEST['price_id']);
            if (!empty ($BL->REQUEST['dom_ext']))
            {
                $new_server_array = $BL->props->tld_array[$BL->REQUEST['dom_ext']];
            }
            else
            {
                $BL->REQUEST['dom_ext'] = $tld['dom_ext'];
            }
            $title = $BL->props->lang['edit_tld'];
            include_once $BL->include_page("tld.php");
            break;
        }
        case "addtld" :
        {
            if(isset($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['add'])
            {
                if (!empty($BL->REQUEST['dom_ext1']))
                {
                    $BL->REQUEST['dom_ext'] = $BL->REQUEST['dom_ext1'];
                }
                $server_array = $BL->props->tld_array[$BL->REQUEST['dom_ext']];
                if (empty($BL->REQUEST['tld_server']))
                {
                    $BL->REQUEST['tld_server'] = $server_array['server'];
                }
                if (empty($BL->REQUEST['tld_match']))
                {
                    $BL->REQUEST['tld_match']  = $server_array['nomatch'];
                }
                if (!empty($BL->REQUEST['tld_server']) && !empty($BL->REQUEST['tld_match']))
                {
                    if($BL->tlds->insert($BL->REQUEST))
                    {
                        $BL->Redirect("tld");
                        break;
                    }
                }
            }
            if (!empty ($BL->REQUEST['dom_ext']))
            {
                $new_server_array   = $BL->props->tld_array[$BL->REQUEST['dom_ext']];
            }
            $title = $BL->props->lang['TLD_Add'];
            include_once $BL->include_page("tld.php");
            break;
        }
        case "deltld" :
        {
            $BL->tlds->delete(array("WHERE `price_id`=".intval($BL->REQUEST['price_id'])));
            $BL->Redirect("tld");
        }
        case "tld" :
        {
            $tlds = $BL->tlds->find();
            include_once $BL->include_page("tld_list.php");
            break;
        }
        case "registrar" :
        {
            if(isset($BL->REQUEST['update']) && $BL->REQUEST['update']==$BL->props->lang['Update'])
            {
                $BL->registrars->query("TRUNCATE TABLE `registrars`");
                foreach($BL->dr as $registrar){
                    foreach($BL->REQUEST[$registrar] as $field=>$value){
                        $data = array('name'=>$registrar,'field'=>$field);
                        foreach($BL->dr_fields[$registrar] as $F){
                            if($F[0]==$field && $F[1]==1){
                                $data['value'] = $BL->utils->alpencrypt->encrypt($value, $BL->props->encryptionKey);
                            }elseif($F[0]==$field){
                                $data['value'] = $value;
                            }
                        }
                        $BL->registrars->insert($data);
                    }
                }
                $BL->Redirect("registrar");
            }
            include_once $BL->include_page("registrar.php");
            break;
        }
        case "payment" :
        {
            if(isset($BL->REQUEST['update']) && $BL->REQUEST['update']==$BL->props->lang['Update'])
            {
                foreach($BL->REQUEST as $key=>$item)
                {
                    if(is_array($item))
                    {
                        $item['pp_name']=$key;
                        $BL->pp_vals->update($item);
                    }
                }
                $BL->Redirect("payment");
            }
            $BL->pp_vals->syncTableStructure($BL->pg, $BL->arrays);
            $pp_vals = array();
            foreach ($BL->pp_vals->find() as $data)
            {
                $pp_vals[$data['pp_name']] = $data;
            }
            include_once $BL->include_page("payment.php");
            break;
        }
        case "editserver" :
        {
            if (isset ($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['Update'])
            {
                $additional_ips = array();
                if(!empty($BL->REQUEST['additional_ips']))
                {
                    $additional_ips = $BL->utils->extractIps($BL->REQUEST['additional_ips']);
                }
                $BL->REQUEST['server_pass'] = $BL->utils->alpencrypt->encrypt($BL->REQUEST['server_pass'], $BL->props->encryptionKey);
                $BL->REQUEST['server_hash'] = $BL->utils->alpencrypt->encrypt($BL->REQUEST['server_hash'], $BL->props->encryptionKey);
                $BL->servers->update($BL->REQUEST);
                $BL->ips->delete(array("WHERE `server_id`=".intval($BL->REQUEST['server_id'])));
                foreach ($additional_ips as $ip)
                {
                    $BL->ips->insert(array("server_id"=>$BL->REQUEST['server_id'],"ip"=>$ip));
                }
                $BL->Redirect("servers");
            }
            $additional_ips = "";
            foreach($BL->ips->find(array("WHERE `server_id`=".intval($BL->REQUEST['server_id']))) as $ip_data)
            {
                $additional_ips .=  $ip_data['ip']." \n";
            }
            $server= $BL->servers->getByKey($BL->REQUEST['server_id']);
            $title = $BL->props->lang['add_server'];
            include_once $BL->include_page("servers.php");
            break;
        }
        case "addservers" :
        {
            if (isset ($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['add'])
            {
                $additional_ips = array();
                if(!empty($BL->REQUEST['additional_ips']))
                {
                    $additional_ips = $BL->utils->extractIps($BL->REQUEST['additional_ips']);
                }
                $BL->REQUEST['server_pass'] = $BL->utils->alpencrypt->encrypt($BL->REQUEST['server_pass'], $BL->props->encryptionKey);
                $BL->REQUEST['server_hash'] = $BL->utils->alpencrypt->encrypt($BL->REQUEST['server_hash'], $BL->props->encryptionKey);
                $insert_id = $BL->servers->insert($BL->REQUEST);
                if($insert_id)
                {
                    foreach ($additional_ips as $ip)
                    {
                        $BL->ips->insert(array("server_id"=>$insert_id,"ip"=>$ip));
                    }
                    $BL->Redirect("servers");
                }
            }
            $title = $BL->props->lang['add_server'];
            include_once $BL->include_page("servers.php");
            break;
        }
        case "delserver" :
        {
            $BL->servers->delete(array("WHERE `server_id`=".intval($BL->REQUEST['server_id'])));
            $BL->ips->delete(array("WHERE `server_id`=".intval($BL->REQUEST['server_id'])));
            $BL->Redirect("servers");
            break;
        }
        case "servers" :
        {
            if(isset($BL->REQUEST['action']) && $BL->REQUEST['action']=="sync" && is_numeric($BL->REQUEST['server_id']))
            {
                $count     = count($BL->listAccount($BL->REQUEST['server_id']));
                $BL->servers->update(array("server_id"=>$BL->REQUEST['server_id'],"current_accounts"=>$count));
            }
            if(isset($BL->REQUEST['action']) && $BL->REQUEST['action']=="default" && is_numeric($BL->REQUEST['server_id']))
            {
                $BL->servers->update(array("server_default"=>"no"));
                $BL->servers->update(array("server_id"=>$BL->REQUEST['server_id'],"server_default"=>"default"));
            }
            $servers = $BL->servers->find();
            $default_server = $BL->props->lang['none'];
            foreach ($servers as $temp)
            {
                if ($temp['server_default'] == "default")
                {
                    $default_server = $temp['server_name'];
                }
            }
            include_once $BL->include_page("servers_list.php");
            break;
        }
        case "edit_user" :
        {
            if (isset ($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['Update'])
            {
                $BL->REQUEST['topic_id'] = "";
                foreach ($BL->REQUEST['topic_id_array'] as $val)
                {
                    $BL->REQUEST['topic_id'] .= "<&&>".$val;
                }
                $BL->REQUEST['permissions'] = "|";
                foreach ($BL->REQUEST['commands'] as $c)
                {
                    $BL->REQUEST['permissions'] .= $c . "|";
                }
                if(isset($BL->REQUEST['change_pass']) && $BL->props->alp_demo_mode!=1)
                {
                    $BL->REQUEST['password'] = md5($BL->REQUEST['change_pass']);
                }
                if ($BL->admin_users->update($BL->REQUEST))
                {
                    $BL->Redirect("users");
                    break;
                }
            }

            $id          = $BL->REQUEST['id'];
            $User        = $BL->admin_users->getByKey($id);
            $listed_cmds = explode("|", $User['permissions']);
            $title       = $BL->props->lang['edit_user'];
            $topics      = $BL->support_topics->find();
            $topic_id_array = explode("<&&>", $User['topic_id']);
            $BL->utils->Remove_Empty_Elements($topic_id_array);
            include_once $BL->include_page("user.php");
            break;
        }
        case "add_user" :
        {
            if (isset ($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['add'])
            {
                $BL->REQUEST['topic_id'] = "";
                foreach ($BL->REQUEST['topic_id_array'] as $val)
                {
                    $BL->REQUEST['topic_id'] .= "<&&>".$val;
                }
                $BL->REQUEST['permissions'] = "|";
                foreach ($BL->REQUEST['commands'] as $c)
                {
                    $BL->REQUEST['permissions'] .= $c . "|";
                }
                $BL->REQUEST['password'] = md5($BL->REQUEST['pass']);
                if ($BL->admin_users->insert($BL->REQUEST))
                {
                    $BL->Redirect("users");
                    break;
                }
            }
            $title   = $BL->props->lang['add_user'];
            $topics  = $BL->support_topics->find();
            include_once $BL->include_page("user.php");
            break;
        }
        case "del_user" :
        {
            $BL->admin_users->delete(array("WHERE `id`=".intval($BL->REQUEST['id'])));
            $BL->Redirect("users");
            break;
        }
        case "users" :
        {
            $Users = $BL->admin_users->find();
            include_once $BL->include_page("users_list.php");
            break;
        }
        case "edit_ip" :
        {
            if (isset ($BL->REQUEST['submit'])  && $BL->REQUEST['submit']==$BL->props->lang['Update'])
            {
                $admin_id = $BL->REQUEST['admin_id'];
                $BL->REQUEST['ip_address'] = $BL->utils->Get_Trimmed_Array($BL->REQUEST['ip_address']);
                $ip_address  = $BL->REQUEST['ip_address'][0].".".
                $BL->REQUEST['ip_address'][1].".".
                $BL->REQUEST['ip_address'][2].".".
                $BL->REQUEST['ip_address'][3];
                if(!empty($BL->REQUEST['ip_address'][4]) && $BL->REQUEST['ip_address'][3]<$BL->REQUEST['ip_address'][4])
                    $ip_address  = $BL->REQUEST['ip_address'][0].".".
                    $BL->REQUEST['ip_address'][1].".".
                    $BL->REQUEST['ip_address'][2].".".
                    $BL->REQUEST['ip_address'][3]."-".
                    $BL->REQUEST['ip_address'][4];
                if($BL->access_ips->update(array("admin_id"=>$admin_id,"ip_address"=>$ip_address)))
                {
                    $BL->Redirect("ips");
                }
            }
            $title = $BL->props->lang['+edit_ip'];
            $users = array();
            foreach($BL->admin_users->find() as $user)
            {
                $users[$user['id']] = $user;
            }
            $access_ip = $BL->access_ips->hasAnyOne(array("WHERE `id`=".intval($BL->REQUEST['id'])));
            include_once $BL->include_page("ip.php");
            break;
        }
        case "add_ip" :
        {
            if (isset ($BL->REQUEST['submit'])  && $BL->REQUEST['submit']==$BL->props->lang['add'])
            {
                $admin_id = $BL->REQUEST['admin_id'];
                $BL->REQUEST['ip_address'] = $BL->utils->Get_Trimmed_Array($BL->REQUEST['ip_address']);
                $ip_address  = $BL->REQUEST['ip_address'][0].".".
                $BL->REQUEST['ip_address'][1].".".
                $BL->REQUEST['ip_address'][2].".".
                $BL->REQUEST['ip_address'][3];
                if(!empty($BL->REQUEST['ip_address'][4]) && $BL->REQUEST['ip_address'][3]<$BL->REQUEST['ip_address'][4])
                    $ip_address  = $BL->REQUEST['ip_address'][0].".".
                    $BL->REQUEST['ip_address'][1].".".
                    $BL->REQUEST['ip_address'][2].".".
                    $BL->REQUEST['ip_address'][3]."-".
                    $BL->REQUEST['ip_address'][4];
                if($BL->access_ips->insert(array("admin_id"=>$admin_id,"ip_address"=>$ip_address)))
                {
                    $BL->Redirect("ips");
                }
            }
            $title = $BL->props->lang['+add_ip'];
            $users = array();
            foreach($BL->admin_users->find() as $user)
            {
                $users[$user['id']] = $user;
            }
            include_once $BL->include_page("ip.php");
            break;
        }
        case "del_ip" :
        {
            $BL->access_ips->delete(array("WHERE `id`=".intval($BL->REQUEST['id'])));
            $access_ips = $BL->access_ips->find();
            if(!count($access_ips))
            {
                $BL->REQUEST['security_degree'] = 0;
                $BL->configurations->update(array("security_degree"=>$BL->REQUEST['security_degree']));
            }
            $BL->Redirect("ips");
            break;
        }
        case "ips" :
        {
            if(isset($BL->REQUEST['submit']) && isset($BL->REQUEST['action']) && $BL->REQUEST['action']=="change_security_level")
            {
                if($BL->REQUEST['security_degree']>0 && !count($BL->access_ips->find()))
                {
                    $BL->utils->alert($BL->props->lang['No_IP_defined']);
                }
                else
                {
                    $BL->configurations->update(array("security_degree"=>$BL->REQUEST['security_degree']));
                }
            }
            if(isset($BL->REQUEST['submit']) && isset($BL->REQUEST['action']) && $BL->REQUEST['action']=="image_verification")
            {
                $BL->configurations->update(array("image_verification_admin"=>isset($BL->REQUEST['image_verification_admin'])?$BL->REQUEST['image_verification_admin']:0,"image_verification_customer"=>isset($BL->REQUEST['image_verification_customer'])?$BL->REQUEST['image_verification_customer']:0));
            }
            $users = array();
            foreach($BL->admin_users->find() as $user)
            {
                $users[$user['id']] = $user;
            }
            $access_ips = $BL->access_ips->find();
            if(!count($access_ips))
            {
                $BL->configurations->update(array("security_degree"=>0));
            }
            $BL->loadConf();
            $conf = $BL->conf;
            include_once $BL->include_page("ip_list.php");
            break;
        }
        case "geoip" :
        {
            if (isset ($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['Update'])
            {
                if ($BL->REQUEST['feed'] != "1" && isset($BL->REQUEST['csv_file']) && is_file($BL->REQUEST['csv_file']) && is_readable($BL->REQUEST['csv_file']))
                {
                    $BL->geoip_db->delete();
                    $filename   = $BL->REQUEST['csv_file'];
                    $fd         = fopen($filename, "r");
                    while (!feof($fd))
                    {
                        $entry  = fgets($fd, 512);
                        if (strlen($entry) > 9)
                        {
                            $entry = str_replace('"', '', $entry);
                            $entry = explode(",", $entry);
                            if ($BL->REQUEST['feed'] == "3")
                            {
                                while (strlen($entry[0]) < 10)
                                {
                                    $entry[0] = '0'.$entry[0];
                                }
                                while (strlen($entry[1]) < 10)
                                {
                                    $entry[1] = '0'.$entry[1];
                                }
                                $BL->geoip_db->insert(array("IP_FROM"=>$entry[0], "IP_TO"=>$entry[1], "COUNTRY_CODE2"=>$entry[2]));
                            }
                            if ($BL->REQUEST['feed'] == "2")
                            {
                                while (strlen($entry[2]) < 10)
                                {
                                    $entry[2]= '0'.$entry[2];
                                }
                                while (strlen($entry[3]) < 10)
                                {
                                    $entry[3]= '0'.$entry[3];
                                }
                                $BL->geoip_db->insert(array("IP_FROM"=>$entry[2], "IP_TO"=>$entry[3], "COUNTRY_CODE2"=>$entry[4]));
                            }
                        }
                    }
                    fclose($fd);
                    //index the table to do faster search
                    $BL->geoip_db->index("IP_FROM");
                    $BL->geoip_db->index("IP_TO");
                    $inst= $BL->props->lang['edited_success'];
                    $BL->geoip->save(array("feed"=>$BL->REQUEST['feed'],"csv_file"=>$BL->REQUEST['csv_file'],"updated_on"=>date('Y-m-d H:i:s')));
                }
                elseif ($BL->REQUEST['feed'] == "1")
                {
                    $BL->geoip_db->delete();
                    $inst = $BL->props->lang['edited_success'];
                    $BL->geoip->save(array("feed"=>$BL->REQUEST['feed'],"csv_file"=>"","updated_on"=>date('Y-m-d H:i:s')));
                }
                else
                {
                    $inst  = $BL->props->lang['file_doesnot_exist']."<br>";
                    $inst .= $BL->props->lang['edited_success'];
                    $BL->geoip->save(array("feed"=>$BL->REQUEST['feed'],"csv_file"=>"","updated_on"=>date('Y-m-d H:i:s')));
                }
                $BL->utils->alert($inst);
            }
            $conf = $BL->conf;
            $geoip = $BL->geoip->hasAnyOne();
            if (isset($geoip['csv_file']) && empty ($geoip['csv_file']))
            {
                $feeds = $BL->utils->dirlist("elements".PATH_SEP."default".PATH_SEP."sysvar");
                foreach ($feeds['ext'] as $key=>$ext)
                {
                    if ($ext == "csv")
                    {
                        $csv_file= $conf['path_abs'].PATH_SEP."elements".PATH_SEP."default".PATH_SEP."sysvar".PATH_SEP.$feeds['name'][$key].".".$ext;
                    }
                }
                $feeds = $BL->utils->dirlist("elements".PATH_SEP."custom".PATH_SEP."sysvar");
                foreach ($feeds['ext'] as $key=>$ext)
                {
                    if ($ext == "csv")
                    {
                        $csv_file= $conf['path_abs'].PATH_SEP."elements".PATH_SEP."default".PATH_SEP."sysvar".PATH_SEP.$feeds['name'][$key].".".$ext;
                    }
                }
            }
            else
            {
                $csv_file= $geoip['csv_file'];
            }
            include_once $BL->include_page("geoip.php");
            break;
        }
        case "editcurrency" :
        {
            if (isset($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['Update'])
            {
                if($BL->currencies->update($BL->REQUEST))
                {
                    $BL->Redirect("currency");
                }
            }
            $currency = $BL->currencies->getByKey($BL->REQUEST['curr_id']);
            $conf= $BL->conf;
            $title = $BL->props->lang['+editcurrency'];
            include_once $BL->include_page("currency.php");
            break;
        }
        case "addcurrency" :
        {
            if (isset($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['add'])
            {
                if($BL->currencies->insert($BL->REQUEST))
                {
                    $BL->Redirect("currency");
                }
            }
            $conf= $BL->conf;
            $title = $BL->props->lang['+addcurrency'];
            include_once $BL->include_page("currency.php");
            break;
        }
        case "delcurrency" :
        {
            $BL->currencies->delete(array("WHERE `curr_id`=".intval($BL->REQUEST['curr_id'])));
            $BL->Redirect("currency");
            break;
        }
        case "currency" :
        {
            if (isset($BL->REQUEST['action']) && $BL->REQUEST['action']=="default_curr")
            {
                $msg    = $BL->props->lang['nothing_changed'];
                if ($BL->configurations->update($BL->REQUEST))
                {
                    $msg= $BL->props->lang['edited_success'];
                }
                $BL->utils->alert($msg);
            }
            if (isset($BL->REQUEST['action']) && $BL->REQUEST['action']=="auto_update_curr")
            {
                $msg = $BL->props->lang['nothing_changed'];
                if ($BL->configurations->update($BL->REQUEST))
                {
                    $msg= $BL->props->lang['edited_success'];
                }
                $BL->utils->alert($msg);
            }
            $BL->loadConf();
            $conf= $BL->conf;
            if($conf['auto_update_curr']==1)
            {
                $currencies = $BL->currencies->find();
                foreach ($currencies as $temp)
                {
                    $BL->REQUEST['curr_factor'] = $BL->utils->parse_google_currency($temp['curr_name'], $conf['curr_name']);
                    if($BL->REQUEST['curr_factor']>0)
                    {
                        $BL->currencies->update(array("curr_id"=>$temp['curr_id'],"curr_factor"=>$BL->REQUEST['curr_factor']));
                    }
                }
            }
            $currencies = $BL->currencies->find();
            include_once $BL->include_page("currency_list.php");
            break;
        }

        case "edit_cycle" :
        {
            if (isset($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['Update'])
            {
                $BL->REQUEST['cycle_name'] = str_replace(" ","_",$BL->REQUEST['cycle_name']);
                if($BL->billing_cycles->update($BL->REQUEST))
                {
                    $BL->Redirect("billing_cycles");
                }
            }
            $title = $BL->props->lang['+edit_cycle'];
            $cycles = array();
            foreach($BL->billing_cycles->find() as $temp)
            {
                if($BL->REQUEST['id']!=$temp['id'])
                {
                    $cycles[] = $temp['cycle_month'];
                }
            }
            $cycle = $BL->billing_cycles->getByKey($BL->REQUEST['id']);
            include_once $BL->include_page("cycle.php");
            break;
        }
        case "add_cycle" :
        {
            if (isset($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['add'])
            {
                $BL->REQUEST['cycle_name'] = str_replace(" ","_",$BL->REQUEST['cycle_name']);
                if($BL->billing_cycles->insert($BL->REQUEST))
                {
                    $BL->Redirect("billing_cycles");
                }
            }
            $title = $BL->props->lang['+add_cycle'];
            $cycles = array();
            foreach($BL->billing_cycles->find() as $temp)
            {
                $cycles[] = $temp['cycle_month'];
            }
            include_once $BL->include_page("cycle.php");
            break;
        }
        case "del_cycle" :
        {
            $BL->billing_cycles->delete(array("WHERE `id`=".intval($BL->REQUEST['id'])));
            $BL->Redirect("billing_cycles");
            break;
        }
        case "billing_cycles" :
        {
            $cycles = $BL->billing_cycles->find();
            include_once $BL->include_page("cycle_list.php");
            break;
        }
        case "edit_customfield" :
        {
            if (isset($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['Update'])
            {
                $BL->REQUEST['field_name'] = str_replace(" ","_",$BL->REQUEST['field_name']);
                if($BL->customfields->update($BL->REQUEST))
                {
                    $BL->Redirect("customfields");
                }
            }
            $title = $BL->props->lang['+edit_customfield'];
            $customfield = $BL->customfields->getByKey($BL->REQUEST['field_id']);
            include_once $BL->include_page("customfield.php");
            break;
        }
        case "add_customfield" :
        {
            if (isset($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['add'])
            {
                $BL->REQUEST['field_name'] = str_replace(" ","_",$BL->REQUEST['field_name']);
                $BL->REQUEST['customfields_index'] = count($BL->customfields->find())+1;
                if($BL->customfields->insert($BL->REQUEST))
                {
                    $BL->Redirect("customfields");
                }
            }
            $title = $BL->props->lang['+add_customfield'];
            include_once $BL->include_page("customfield.php");
            break;
        }
        case "del_customfield" :
        {
            $BL->customfields->delete(array("WHERE `field_id`=".intval($BL->REQUEST['field_id'])));
            $BL->Redirect("customfields");
            break;
        }
        case "customfields" :
        {
            if(isset($BL->REQUEST['action']) && $BL->REQUEST['action']=="up")
            {
                $BL->customfields->moveUp($BL->REQUEST['field_id'],$BL->REQUEST['field_index']);
            }
            if(isset($BL->REQUEST['action']) && $BL->REQUEST['action']=="down")
            {
                $BL->customfields->moveDown($BL->REQUEST['field_id'],$BL->REQUEST['field_index']);
            }
            $BL->customfields->setOrder("customfields_index");
            $customfields = $BL->customfields->find();
            include_once $BL->include_page("customfield_list.php");
            break;
        }
        case "custom_scripts" :
        {
            if (isset($BL->REQUEST['update']) && !empty ($BL->REQUEST['update']))
            {
                foreach($BL->REQUEST['file_name'] as $k=>$f)
                {
                    $data['id']             = $k;
                    $data['file_name']      = $f;
                    $data['post_variables'] = $BL->REQUEST['post_variables'][$k];
                    $data['run_schedule']   = $BL->REQUEST['run_schedule'][$k];
                    $msg                    = $BL->props->lang['nothing_changed'];
                    if($BL->custom_scripts->update($data))
                    {
                        $msg = $BL->props->lang['edited_success'];
                    }
                    $BL->utils->alert($msg);
                }
            }
            if(isset($BL->REQUEST['manual']) && $BL->REQUEST['manual']==true)
            {
                $BL->runCS($BL->REQUEST['id']);
            }
            $existing_scripts = array();
            foreach($BL->custom_scripts->find() as $custom_script)
            {
                if(array_search($custom_script['file_name'], $BL->props->cs_array)===false)
                {
                    $BL->custom_scripts->delete(array("WHERE `id`=".intval($custom_script['id'])));
                }
                else
                {
                    $existing_scripts[] = $custom_script['file_name'];
                }
            }
            foreach($BL->props->cs_array as $custom_script)
            {
                if(array_search($custom_script, $existing_scripts)===false)
                {
                    $data['file_name']    = $custom_script;
                    $data['run_schedule'] = "INACTIVE";
                    $BL->custom_scripts->insert($data);
                }
            }
            $custom_scripts = $BL->custom_scripts->find();
            include_once $BL->include_page("custom_scripts.php");
            break;
        }
        case "edit_custompage" :
        {
            if (isset($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['Update'])
            {
                if($BL->custompages->update($BL->REQUEST))
                {
                    $BL->Redirect("custompages");
                }
            }
            $title = $BL->props->lang['+edit_custompage'];
            $custompage = $BL->custompages->getByKey($BL->REQUEST['id']);
            include_once $BL->include_page("custompage.php");
            break;
        }
        case "add_custompage" :
        {
            if (isset($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['add'])
            {
                if($BL->custompages->insert($BL->REQUEST))
                {
                    $BL->Redirect("custompages");
                }
            }
            $title = $BL->props->lang['+add_custompage'];
            include_once $BL->include_page("custompage.php");
            break;
        }
        case "del_custompage" :
        {
            $BL->custompages->delete(array("WHERE `id`=".intval($BL->REQUEST['id'])));
            $BL->Redirect("custompages");
            break;
        }
        case "custompages" :
        {
            $custompages = $BL->custompages->find();
            include_once $BL->include_page("custompage_list.php");
            break;
        }
        case "conf" :
        {
            if (isset($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['Update'])
            {
                if ($BL->REQUEST['inv_start_no'] !== '')
                {
                    $sql = "ALTER TABLE `invoices` AUTO_INCREMENT =".intval($BL->REQUEST['inv_start_no']);
                    $BL->dbL->executeALTER($sql);
                }
                if ($BL->REQUEST['order_start_no'] !== '')
                {
                    $sql = "ALTER TABLE `orders` AUTO_INCREMENT =".intval($BL->REQUEST['order_start_no']);
                    $BL->dbL->executeALTER($sql);
                }

                $msg = $BL->props->lang['nothing_changed'];
                $BL->REQUEST['email_charset']= (isset($BL->REQUEST['email_charset']) && !empty($BL->REQUEST['email_charset']))?$BL->REQUEST['email_charset']:$BL->props->lang['charset'];
                $BL->REQUEST['email_content_type'] = (isset($BL->REQUEST['email_content_type']) && !empty($BL->REQUEST['email_content_type']))?$BL->REQUEST['email_content_type']:"text/html";
                if ($BL->configurations->update($BL->REQUEST))
                {
                    $msg = $BL->props->lang['edited_success'];
                }
                $BL->utils->alert($msg);
                $BL->Redirect("conf");
            }
            $conf = $BL->configurations->find();
            include_once $BL->include_page("conf.php");
            break;
        }
        case "import_packages" :
        {
            $Servers = $BL->servers->find();
            $Packages= array();
            if (isset ($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['import'])
            {
                $Packages = $BL->utils->Get_Trimmed_Array($BL->impPackages($BL->REQUEST['server_id']));
                if(!count($Packages))
                {
                    $BL->utils->alert($BL->props->lang['no_packages']);
                }
                else
                {
                    $Linked_Package = array();
                    foreach ($Packages as $Package)
                    {
                        $Products = $BL->products->find();
                        if (!count($BL->products->find(array("WHERE `plan_name`='".$BL->utils->quoteSmart($Package)."'"))))
                        {
                            $data = array();
                            $data['plan_name'] = $Package;
                            $data['plan_friendly_name'] = $Package;
                            $data['server_id'] = $BL->REQUEST['server_id'];
                            $data['acc_method'] = 2;
                            $data['plan_index'] = count($Products)+1;
                            if ($BL->products->insert($data))
                            {
                                $Linked_Package[$Package] = "<font color='green'><b>".$BL->props->lang['plan_added']."</b></font>";
                            }
                        }
                        else
                        {
                            $Linked_Package[$Package] = "<font color='red'><b>".$BL->props->lang['plan_already_exists']."</b></font>";
                        }
                    }
                }
            }
            include_once $BL->include_page("import_packages.php");
            break;
        }
        case "import_clientexec" :
        {
            if (isset ($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['import'] && isset($BL->REQUEST['clientexec_host']))
            {
                $clientexecHandler= new clientexecHandler();
                $clientexecHandler->db_host = $BL->REQUEST['clientexec_host'];
                $clientexecHandler->db_user = $BL->REQUEST['clientexec_user'];
                $clientexecHandler->db_name = $BL->REQUEST['clientexec_db'];
                $clientexecHandler->db_pass = $BL->REQUEST['clientexec_pass'];
            }
            include_once $BL->include_page("import_clientexec.php");
            break;
        }
        case "reset_alp" :
        {
            $BL->ResetALP();
        }
        ################################################Settings END#################################################
        ################################################Default START#################################################
        default :
        {
            if(isset($BL->REQUEST['sec']) && !empty($BL->REQUEST['sec']))
            {
                $BL->configurations->update(array("whoisonline_sec"=>$BL->REQUEST['sec']));
                $BL->loadConf();
                $conf = $BL->conf;
            }
            if(isset($BL->REQUEST['change_refresh_rate']) && $BL->REQUEST['change_refresh_rate']==1)
            {
                if(!isset($BL->REQUEST['refr']) || $BL->REQUEST['refr']!=1)
                {
                    $BL->REQUEST['s_status_refresh'] = 0;
                }
                $BL->configurations->update(array("s_status_refresh"=>$BL->REQUEST['s_status_refresh']));
                $BL->loadConf();

            }
            $conf      = $BL->conf;
            $Servers   = $BL->servers->find();
            $sInvoices = $BL->invoices->getByStatus($BL->props->invoice_status[6]);
            $pInvoices = $BL->invoices->getByStatus($BL->props->invoice_status[0]);
            $mInvoices = array();
            foreach($pInvoices as $Invoice)
            {
                if(!empty($Invoice['payment_method']) && isset($BL->pp_send_method[$Invoice['payment_method']]) && $BL->pp_send_method[$Invoice['payment_method']]=="DIRECT")
                {
                    $mInvoices[] = $Invoice;
                }
            }
            $pOrders = $BL->orders->getByStatus($BL->props->order_status[0]);
            $oOrders = $BL->orphan_orders->get();
            $Sec     = isset($conf['whoisonline_sec'])?$conf['whoisonline_sec']:600;
            $Whoisonline = $BL->whoisonline($Sec);

            $topics = array();
            $dept_ids= explode("<&&>", $_SESSION['dept_id']);
            $BL->utils->Remove_Empty_Elements($dept_ids);
            if(!count($dept_ids) || array_search('0',$dept_ids)!==false)
            {
                $topics = $BL->support_topics->find();
            }
            else
            {
                foreach ($dept_ids as $topic_id)
                {
                    $topics[] = $BL->support_topics->getByKey($topic_id);
                }
            }
            $open_ticket_count = 0;
            $close_ticket_count= 0;
            $tickets = array();
            foreach ($topics as $val)
            {
                $open_tickets                        = $BL->support_tickets->find(array("WHERE `topic_id`=".intval($val['topic_id'])." AND `ticket_status`!='3'"));
                $close_tickets                       = $BL->support_tickets->find(array("WHERE `topic_id`=".intval($val['topic_id'])." AND `ticket_status`='3'"));
                $open_ticket_count                   = $open_ticket_count + count($open_tickets);
                $close_ticket_count                  = $close_ticket_count + count($close_tickets);
                $tickets[$val['topic_id']]['open']   = $open_tickets;
                $tickets[$val['topic_id']]['closed'] = $close_tickets;
            }
            $ticket_status = "all";
            if (isset($BL->REQUEST['ticket_status']) && is_numeric($BL->REQUEST['ticket_status']))
            {
                $ticket_status = $BL->REQUEST['ticket_status'];
            }

            $str1 = "\"tab1\"";
            $str2 = "\"t1\"";
            if($BL->getCmd("viewinvoice") && count($sInvoices)){
                $str1 .= ", \"tab2\"";
                $str2 .= ", \"t2\"";
            }
            if($BL->getCmd("manual_payments") && count($mInvoices)){
                $str1 .= ",\"tab3\"";
                $str2 .= ",\"t3\"";
            }
            if($BL->getCmd("viewinvoice") && count($pInvoices)){
                $str1 .= ", \"tab4\"";
                $str2 .= ", \"t4\"";
            }
            if($BL->getCmd("orphan_orders") && count($oOrders)){
                $str1 .= ", \"tab5\"";
                $str2 .= ", \"t5\"";
            }
            if($BL->getCmd("vieworders") && count($pOrders)){
                $str1 .= ", \"tab6\"";
                $str2 .= ", \"t6\"";
            }
            if($BL->getCmd("viewTicket") && $open_ticket_count){
                $str1 .= ", \"tab7\"";
                $str2 .= ", \"t7\"";
            }
            include_once $BL->include_page("index.php");
            break;
        }
        ################################################Default START#################################################
    }
    if(ALP_DEBUG)
    {
        $errorHandler->getErrorLog();
    }
?>
