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
    if(isset($BL->REQUEST['force_theme']) || isset($BL->REQUEST['force_lang']))
    {
        if(isset($BL->REQUEST['force_theme']))$_SESSION['force_theme'] = $BL->REQUEST['force_theme'];
        if(isset($BL->REQUEST['force_lang'])) $_SESSION['force_lang']  = $BL->REQUEST['force_lang'];
        $BL->Redirect($cmd,"");
    }
    $page            = "customer.php";
    $general_section = true;
    $announcements   = $BL->announcements->find();
    $faqs            = $BL->faqs->find();
    $faqgroups       = $BL->faqgroups->find();
    $conf            = $BL->conf;
    $skiplogin       = false;
    if($cmd=='custompage'){
        $BL->REQUEST['id'] = isset($BL->REQUEST['id'])?$BL->REQUEST['id']:$_SESSION['custompage_id'];
        $_SESSION['custompage_id'] = $BL->REQUEST['id'];
        $Custompage_Data = $BL->custompages->getByKey($BL->REQUEST['id']);
        if(isset($Custompage_Data['id'])){
            $cmd = "custompage";
            if($Custompage_Data['require_customer_login']!='1'){
                $skiplogin = true;
            }
            if($Custompage_Data['display_side_links']!=1){
                $general_section = false;
            }
        }else{
            $cmd="";
        }
    }
    if ($cmd=='quickpay' && isset($BL->REQUEST['email']) && isset($BL->REQUEST['invoice_no']) && $BL->conf['en_quickpay'])
    {
        $skiplogin = true;
        $cmd='pay';
    }
    elseif($cmd=='quickpay' && $BL->conf['en_quickpay'])
    {
        include_once $BL->props->get_page("templates/".THEMEDIR."/html/user/quickpay.php");
        $BL->Disconnect();
    }
    elseif($cmd=='pay' && isset($_SESSION['quickpay']) && $_SESSION['quickpay'] == $BL->REQUEST['invoice_no'] && $BL->conf['en_quickpay'])
    {
        $skiplogin = true;
    }

    if (isset($BL->REQUEST['email']) && isset($BL->REQUEST['password']))
    {
        foreach ($BL->REQUEST as $k => $v)
        {
            if ($k != "submit" && $k != "email" && $k != "password" && $k != "captcha_value")
            {
                $_GET[$k]= $v;
            }
        }
        if (!$BL->conf['image_verification_customer'])
        {
            if(!$BL->auth->login("user"))
            {
                $msg = $BL->props->lang['err_user_pass'];
                $BL->auth->logout("user");
                $cmd = "";
            }
        }
        elseif(!isset($BL->REQUEST['captcha_value']))
        {
            include_once $BL->props->get_page("templates/".THEMEDIR."/html/user/captcha.php");
            $BL->Disconnect();
        }
        else
        {
            if(md5($BL->REQUEST['captcha_value'])==$_SESSION['captcha_key'] && $BL->auth->login("user"))
            {
                $_SESSION['captcha_key'] = '';
            }
            else
            {
                $msg = $BL->props->lang['err_user_pass'];
                $BL->auth->logout("user");
                $cmd = "";
            }
        }
    }
    elseif (isset ($BL->REQUEST['get_pass']) && $BL->REQUEST['get_pass'])
    {
        $msg = ($BL->get_pass($BL->REQUEST['email']))?$BL->props->lang['pass_send']:$BL->props->lang['err_improper_email'];
    }
    unset($_SESSION['captcha_key']);
    if (!$skiplogin && !$BL->auth->IsAuth("user"))
    {
        $BL->auth->logout();
        include_once $BL->props->get_page("templates/".THEMEDIR."/html/user/login.php");
        $BL->Disconnect();
    }

    //Decide where to go
    switch ($cmd)
    {
        case "custompage" :
        {
            include_once $BL->props->get_page("templates/".THEMEDIR."/html/user/custompage.php");
            break;
        }
        case "pay" :
        {
            $ACTIVE_PAYMENT_METHODS = array();
            foreach ($BL->pg as $value)
            {
                if ($BL->pp_active[$value] == "Yes")
                {
                    $ACTIVE_PAYMENT_METHODS[] = $value;
                }
            }
            $invoice_no     = $BL->REQUEST['invoice_no'];
            $payment_method = isset($BL->REQUEST['payment_method'])?$BL->REQUEST['payment_method']:$ACTIVE_PAYMENT_METHODS[0];
            $BL->invoices->update(array("payment_method"=>$payment_method,"invoice_no"=>$invoice_no));
            //CHANGE PAYMENT METHOD
            if (isset ($BL->REQUEST['pp']))
            {
                $BL->invoices->update(array("payment_method"=>$BL->REQUEST['pp'],"invoice_no"=>$BL->REQUEST['invoice_no']));
            }
            //PREPARE PAYMENT VARIABLES TO PAY
            if(isset($BL->REQUEST['alp_pay_now']))
            {
                if(!empty($BL->REQUEST['pay_curr_id']))
                {
                    $add_cur         = $BL->currencies->getByKey($BL->REQUEST['pay_curr_id']);
                    $pay_curr_name   = $add_cur['curr_name'];
                    $pay_curr_symbol = $add_cur['curr_symbol'];
                    $pay_curr_factor = $add_cur['curr_factor'];
                }
                else
                {
                    $pay_curr_name    = $conf['curr_name'];
                    $pay_curr_symbol  = $conf['symbol'];
                    $pay_curr_factor  = 1;
                }
                $BL->invoices->update(array("pay_curr_name"=>$pay_curr_name, "pay_curr_symbol"=>$pay_curr_symbol, "pay_curr_factor"=>$pay_curr_factor,"invoice_no"=>$BL->REQUEST['invoice_no']));
                $add_fields = $BL->pp_ext_fields[$payment_method];
                $temp       = $BL->invoices->get("WHERE `invoices`.invoice_no=".intval($invoice_no));
                $invoice    = $temp[0];
                if(count($add_fields))
                {
                    if(!$BL->extraFields($invoice['id'],$invoice['sub_id'],$invoice_no,$add_fields,"UPDATE"))
                    {
                        $BL->extraFields($invoice['id'],$invoice['sub_id'],$invoice_no,$add_fields,"INSERT");
                    }
                }
            }
            $temp    = $BL->invoices->get("WHERE `invoices`.invoice_no=".intval($invoice_no));
            if (empty($temp))
            {
                $BL->Redirect($cmd,"");
            }
            $invoice = $temp[0];
            $temp    = $BL->orders->get("WHERE `customers`.id=".intval($invoice['id']));
            $order   = $temp[0];
            if (!empty($invoice['payment_method']))
            {
                $payment_method = $invoice['payment_method'];
            }
            if(!isset($BL->REQUEST['pp']) || empty($BL->REQUEST['pp']))
            {
                $BL->REQUEST['pp'] = $payment_method;
            }
            foreach ($invoice as $k => $v)
            {
                $BL->REQUEST[$k]= $v;
            }
            $BL->REQUEST['total_recurring_fee'] = $invoice['cycle_fee'];
            if ($invoice['dom_reg_type'] == 1 && $invoice['dom_reg_year'] == ($invoice['bill_cycle'] / 12))
            {
                $BL->REQUEST['total_recurring_fee']= $BL->REQUEST['total_recurring_fee'] + $invoice['tld_fee'];
            }
            elseif ($invoice['dom_reg_type'] != 1)
            {
                $BL->REQUEST['total_recurring_fee']= $BL->REQUEST['total_recurring_fee'] + $invoice['tld_fee'];
            }
            $addons = $BL->addons->getInvoiceAddonStringData($invoice['addon_fee']);
            foreach ($addons as $addon_name => $data)
            {
                $BL->REQUEST['total_recurring_fee'] = $BL->REQUEST['total_recurring_fee'] + $data['CYCLE'];
            }
            $BL->REQUEST['force_inv_no']  = $BL->REQUEST['invoice_no'];
            $BL->REQUEST['friendly_desc'] = $BL->getFriendlyDesc($invoice['desc'],0,$invoice['domain_name']);
            $BL->REQUEST['next_bill_date']= $order['rec_next_date'];
            $BL->customfields->setOrder("customfields_index");
            foreach($BL->customfields->find() as $customfield)
            {
                $BL->REQUEST[$customfield['field_name']]= $BL->getCustomerFieldValue($customfield['field_name'],$invoice['customer_id']);
            }
            $_POST         = $BL->REQUEST;
            $add_cur       = $BL->currencies->find();
            $add_fields    = $BL->pp_ext_fields[$payment_method];
            $disp_msg      = $BL->pp_disp_msg[$payment_method];
            $show_add_curr = $BL->pp_add_curr[$payment_method];
            $pay           = $BL->pp_objs[$payment_method];

            $pay->sendVariables($BL->conf['path_url'], $BL->pp_vals->getByKey($payment_method));
            $post_url      = isset($pay->pay_url)?$pay->pay_url:($BL->conf['path_url']."/customer.php");
            $send_method   = isset($BL->pp_send_method[$payment_method])?$BL->pp_send_method[$payment_method]:"POST";
            $ext_fields    = $BL->extraFields($invoice['customer_id'],$invoice['sub_id'],$invoice['invoice_no'],$add_fields,"SELECT");
            if (isset($pay->_POST1))
            {
                $post_vars = "";
                foreach ($pay->_POST1 as $key => $value)
                {
                    $post_vars .= "<input type=\"hidden\" name=\"".$key."\" id=\"".$key."\" value=\"".$value."\">\n\r";
                }
            }

            //update currency values
            if ($BL->conf['auto_update_curr'] && $show_add_curr == "Yes")
            {
                for ($i= 0; $i < count($add_cur); $i++)
                {
                    $from   = $BL->conf['curr_name'];
                    $to     = $add_cur[$i]['curr_name'];
                    $factor = $BL->utils->parse_google_currency($to, $from);
                    if ($factor)
                    {
                        $add_cur[$i]['curr_factor'] = $factor;
                        $BL->configurations->update($add_cur[$i]);
                    }
                }
            }
            $add_cur = $BL->currencies->find();

            if (isset($invoice['customer_id']) && isset($_SESSION['user_id']) &&
                $_SESSION['user_id'] == $invoice['customer_id'])
            {
                $html_buffer = $BL->invoices->mailInvoice($BL->REQUEST['invoice_no'],true);
                include_once $BL->include_page("invoice_view.php", "user");
                break;
            }
            elseif (isset($invoice['customer_id']) && $BL->REQUEST['email'] == $invoice['email'] && $BL->conf['en_quickpay'])
            {
                $_SESSION['quickpay'] = $BL->REQUEST['invoice_no'];
                $html_buffer = $BL->invoices->mailInvoice($BL->REQUEST['invoice_no'],true);
                include_once $BL->props->get_page("templates/".THEMEDIR."/html/user/invoice_view.php");
                break;
            }
            elseif (isset($invoice['customer_id']) && $_SESSION['quickpay'] == $BL->REQUEST['invoice_no'])
            {
                $html_buffer = $BL->invoices->mailInvoice($BL->REQUEST['invoice_no'],true);
                include_once $BL->props->get_page("templates/".THEMEDIR."/html/user/invoice_view.php");
                break;
            }
            else
            {
                // $BL->Redirect("invoices","user");
            }
        }
        case "viewInvoice" :
        {
            $temp    = $BL->invoices->get("WHERE `invoices`.invoice_no=".intval($BL->REQUEST['invoice_no']));
            $invoice = $temp[0];
            if (isset($temp[0]['id']) &&
                ($_SESSION['user_id'] == $invoice['id']) || ($_SESSION['quickpay'] == $invoice['invoice_no']))
            {
                $html_buffer = $BL->invoices->mailInvoice($BL->REQUEST['invoice_no'],true);
                include_once $BL->include_page("invoice_view.php", "user");
                break;
            }
            else
            {
                $BL->Redirect("invoices","user");
            }
        }
        case "viewOrder" :
        {
            $order     = $BL->orders->get("WHERE `orders`.sub_id=".intval($BL->REQUEST['sub_id']));
            $addon_ids = $BL->orders->getAddons($BL->REQUEST['sub_id']);
            $server    = $BL->servers->getByKey($order[0]['server_id']);
            $ip        = $BL->ips->getByKey($order[0]['ip_id']);
            if ($_SESSION['user_id'] == $order[0]['id'])
            {
                include_once $BL->include_page("view.php", "user");
                break;
            }
            else
            {
                $BL->Redirect("orders","user");
            }
        }
        case "openTicket" :
        {
            $BL->REQUEST['ticket_status'] = 0;
            $BL->support_tickets->update($BL->REQUEST);
            $BL->mailTicket($BL->REQUEST['ticket_id'], false);
            $BL->Redirect("viewTicket&ticket_id=".$BL->REQUEST['ticket_id'],"user");
        }
        case "closeTicket" :
        {
            $BL->REQUEST['ticket_status'] = 3;
            $BL->support_tickets->update($BL->REQUEST);
            $BL->mailTicket($BL->REQUEST['ticket_id'], false);
            $BL->Redirect("viewTicket&ticket_id=".$BL->REQUEST['ticket_id'],"user");
        }
        case "viewTicket" :
        {
            if(isset($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['submit'])
            {
                $BL->REQUEST['ticket_status'] = 1;
                $BL->REQUEST['reply_by']   = $_SESSION['email'];
                $BL->REQUEST['reply_date'] = date('Y-m-d H:i:s');
                if($BL->support_replies->insert($BL->REQUEST))
                {
                    $BL->support_tickets->update($BL->REQUEST);
                    $BL->mailTicket($BL->REQUEST['ticket_id'], false);
                    $BL->Redirect("tickets","user");
                }
            }
            $ticket  = $BL->support_tickets->getByKey($BL->REQUEST['ticket_id']);
            $topic   = $BL->support_topics->getByKey($ticket['topic_id']);
            $replies = $BL->support_replies->find(array("WHERE `ticket_id`=".intval($BL->REQUEST['ticket_id'])));
            if (isset($ticket['cust_id']) && $ticket['cust_id'] == $_SESSION['user_id'])
            {
                include $BL->include_page("ticket.php", "user");
                break;
            }
            else
            {
                $BL->Redirect("tickets","user");
            }
        }
        case "faq" :
        {
            $Faqgroups = $BL->faqgroups->find();
            foreach($Faqgroups as $faqgroup)
            {
                if(!isset($BL->REQUEST['faqgroup_id']) || $BL->REQUEST['faqgroup_id']==$faqgroup['faqgroup_id'])
                {
                    $BL->REQUEST['faqgroup_id']   = $faqgroup['faqgroup_id'];
                    $BL->REQUEST['faqgroup_name'] = $faqgroup['faqgroup_name'];
                    $BL->REQUEST['faqgroup_desc'] = $faqgroup['faqgroup_desc'];
                }
            }
            if(!count($Faqgroups))
            {
                $Faqs = $BL->faqs->find();
            }
            else
            {
                $Faqs = $BL->faqs->find(array("WHERE `faqgroup_id`=".intval($BL->REQUEST['faqgroup_id'])));
            }
            $page = "customer.php";
            include_once $BL->include_page("faq.php", "user");
            break;
        }
        case "tickets" :
        {
            if(isset($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['submit'])
            {
                $BL->REQUEST['ticket_status'] = 1;
                $BL->REQUEST['ticket_date']= date('Y-m-d H:i:s');
                $BL->REQUEST['ticket_id']  = $BL->support_tickets->insert($BL->REQUEST);
                $BL->mailTicket($BL->REQUEST['ticket_id']);
            }
            $topics = $BL->support_topics->find();
            include_once $BL->include_page("support.php", "user");
            break;
        }
        case "invoices":
        {
            include_once $BL->include_page("invoices_overview.php", "user");
            break;
        }
        case "orders":
        {
            include_once $BL->include_page("orders_overview.php", "user");
            break;
        }
        case "edit" :
        {
            $BL->customfields->setOrder("customfields_index");
            $custom_fields = $BL->customfields->getAvailable();
            if(isset($BL->REQUEST['submit']) && $BL->REQUEST['submit']==$BL->props->lang['submit'])
            {
                $msg = $BL->customers->validate($BL->REQUEST,$custom_fields,true);
                if(empty($msg))
                {
                    $BL->customers->edit($custom_fields);
                }
            }
            $customer = $BL->customers->getByKey($_SESSION['user_id']);
            foreach($custom_fields as $field)
            {
                $customer[$field['field_name']] = $BL->customers->getFieldValue($field['field_id'],$customer['id']);
            }
            include_once $BL->include_page("edit.php", "user");
            break;
        }
        default :
        {
            $BL->customfields->setOrder("customfields_index");
            $custom_fields = $BL->customfields->getAvailable();
            $customer = $BL->customers->getByKey($_SESSION['user_id']);
            $activeorders = $BL->orders->get("WHERE `customers`.id=".intval($_SESSION['user_id'])." AND `orders`.order_deleted != '1' AND `cust_status`='".$BL->props->order_status[1]."' ");
            $suspendedorders = $BL->orders->get("WHERE `customers`.id=".intval($_SESSION['user_id'])." AND `orders`.order_deleted != '1' AND `cust_status`='".$BL->props->order_status[2]."' ");
            $pendingorders   = $BL->orders->get("WHERE `customers`.id=".intval($_SESSION['user_id'])." AND `orders`.order_deleted != '1' AND `cust_status`='".$BL->props->order_status[0]."' ");
            $pendinginvoices = $BL->invoices->get("WHERE `customers_orders`.customer_id=".intval($_SESSION['user_id'])." AND `invoices`.status='".$BL->utils->quoteSmart($BL->props->invoice_status[0])."'");
            $upcominginvoices = $BL->invoices->get("WHERE `customers_orders`.customer_id=".intval($_SESSION['user_id'])." AND `invoices`.status='".$BL->utils->quoteSmart($BL->props->invoice_status[5])."'");
            $tickets  = $BL->support_tickets->find(array("WHERE `cust_id`=".intval($_SESSION['user_id'])." AND `ticket_status`!=3"));
            include_once $BL->include_page("index.php", "user");
            break;
        }
    }
    if(ALP_DEBUG)
    {
        $errorHandler->getErrorLog();
    }
    $BL->Disconnect();
?>
