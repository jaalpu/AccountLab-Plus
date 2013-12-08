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
    $conf   = $BL->conf;
    $result = false;
    if($BL->REQUEST['ipn_type']=='2')
    {
        foreach ($BL->pg as $key => $value)
        {
            $result = false;
            $pay    = $BL->pp_objs[$value];
            if(isset($pay->ipn_type) && $pay->ipn_type==2)
            {
                $result = $pay->ipn($BL);
                if($result)
                {
                    include_once "OK.php";
                    break;
                }
            }
        }
    }
    else
    {
        $posted_vars = "";
        foreach ($BL->REQUEST as $key => $val)
        {
            $val = ($val == "")?"none":$val;
            if (is_array($val))
            {
                foreach ($val as $k => $v)
                {
                    $posted_vars .= $key."[".$k."]=>".$v."<&&>";
                }
            }
            else
            {
                $posted_vars .= $key."=>".$val."<&&>";
            }
        }
        foreach ($BL->pg as $key => $value)
        {
            if (($BL->pp_active[$value] == "Yes") && !$result)
            {
                // Skip auto creation if payment is "DIRECT"
                $BL->REQUEST['skip_auto_creation'] = ($BL->pp_send_method[$value] == "DIRECT");
                $result = false;
                $pay    = $BL->pp_objs[$value];
                $result = $pay->ipn($BL);
                if($result)
                {
                    $log_id = $BL->payment_logs->insert(array("posted_vars"=>$posted_vars));
                    if(!empty($log_id))
                    {
                        $BL->payment_logs->update(array("payment_id"=>$log_id,"invoice_no"=>$pay->item_number,"txn_id"=>$pay->transaction_id,"status"=>$pay->payment_status,"payment_method"=>$value));
                    }
                    include_once "OK.php";
                    break;
                }
            }
        }
    }
    if(!$result)include_once "NOK.php";
    $BL->Disconnect();
?>
