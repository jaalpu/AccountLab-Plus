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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title><?php echo $BL->props->lang['accountlabplus']; ?></title>
    </head>
    <body>
        <font face='sans-serif' color='black' size='2'>
            <?php
                $conf   = $BL->conf;
                $orders = $BL->orders->get("WHERE `order_deleted`='0' AND (`cust_status`='".$BL->props->order_status[0]."' OR `cust_status`='".$BL->props->order_status[1]."' OR `cust_status`='".$BL->props->order_status[2]."')");
                $date   = '';
                if(isset($BL->REQUEST['date']) && $BL->utils->checkDateFormat($BL->REQUEST['date']))
                {
                    $date = date('Y-m-d',strtotime($BL->REQUEST['date']));
                    $temp = $BL->utils->getDateArray($date);
                    if($BL->utils->compareDates(date('d'),date('m'),date('Y'),$temp['mday'],$temp['mon'],$temp['year'])==-1)
                    {
                        echo "Can not accept future dates";
                        exit;
                    }
                    elseif($BL->utils->compareDates(date('d'),date('m'),date('Y'),$temp['mday'],$temp['mon'],$temp['year'])==0)
                    {
                        $date = '';
                    }
                }

                echo "<font color='blue'><b>Running AccountLab Plus's automated billing utility</b></font><br />";
                echo "<font color='black'><b>Current Server Time : ".date("d-M-Y H:i:s")."</b></font><br />";

                /*
                * Generate regular invoices
                */
                if(!isset($BL->REQUEST['action']) || empty($BL->REQUEST['action']))
                {
                    $BL->runCS('W_B');
                    foreach($orders as $order)
                    {
                        echo "<hr/>Processing order #".$order['sub_id']." for ".$BL->getCustomerFieldValue("name",$order['id'])
                            ." (".$order['domain_name']." -> ".$BL->getFriendlyName($order['product_id']).")<br />";
                        $desc = $BL->getCustomerFieldValue("name",$order['id'])." (".$order['domain_name']."->".$BL->getFriendlyName($order['product_id']).")";
                        if(empty($date))
                        {
                            $echo = $BL->invoices->genNewInvoices($order['sub_id']);
                        }
                        else
                        {
                            $echo = $BL->invoices->genInvoicesForDay($order['sub_id'],$date,true);
                        }
                        if(!empty($echo))
                        {
                            echo "<hr />\n".nl2br($echo);
                        } else {
                            echo "<hr/>Nothing to do for order #" . $order['sub_id'] . "\n";
                        }
                    }
                    $BL->runCS('A_B');
                }
                /*
                * Generate upcoming invoices
                */
                if($conf['u_invoice_date']>0 && isset($BL->REQUEST['action']) && $BL->REQUEST['action']=="gen_upcoming")
                {
                    foreach($orders as $order)
                    {
                        echo "<hr/>Processing order #".$order['sub_id']." for ".$BL->getCustomerFieldValue("name",$order['id'])
                            ." (".$order['domain_name']." -> ".$BL->getFriendlyName($order['product_id']).")<br />";
                        $echo = $BL->invoices->genUpcomingInvoices($order['sub_id']);
                        if(!empty($echo))
                        {
                            echo "<br />".nl2br($echo)."<br />";
                        } else {
                            echo "Nothing to do for order #" . $order['sub_id'] . "\n";
                        }
                    }
                }
                /*
                * Repeated Invoice
                */
                if(isset($BL->REQUEST['action']) && $BL->REQUEST['action']=="send_pending" && $conf['send_pending_invoice_everyday']>0)
                {
                    $pending_invoices = $BL->invoices->getByStatus($BL->props->invoice_status[0]);
                    foreach($pending_invoices as $inv)
                    {
                        $v_due_date_array = $BL->utils->getDateArray($inv['due_date']);
                        $date_compare     = $BL->utils->compareDates(date('d'),date('m'),date('Y'),$v_due_date_array['mday'],$v_due_date_array['mon'],$v_due_date_array['year']);
                        if($date_compare==1)
                        {
                            echo "Sending Invoice: Description : ".$inv['desc']."<br />";
                            $BL->invoices->mailInvoice($inv['invoice_no']);
                            echo "<br />\n";
                        }
                    }
                }
                /*
                * Auto-suspend
                */
                if(isset($BL->REQUEST['action']) && $conf['suspend_after_due']>0 && $BL->REQUEST['action']=="autosuspend")
                {
                    if (ob_get_level() == 0) ob_start();
                    $pending_invoices = $BL->invoices->getByStatus($BL->props->invoice_status[0]);
                    $suspended_ids    = array();
                    foreach($pending_invoices as $inv)
                    {
                        if($inv['cust_status']==$BL->props->order_status[1])
                        {
                            $v_due_date_array = $BL->utils->getXdayAfter($conf['suspend_after_due'],$BL->utils->getDateArray($inv['due_date']));
                            $date_compare     = $BL->utils->compareDates(date('d'),date('m'),date('Y'),$v_due_date_array['mday'],$v_due_date_array['mon'],$v_due_date_array['year']);
                            if($date_compare==1 && array_search($inv['sub_id'],$suspended_ids)===false)
                            {
                                echo "<font color='red'><b>*** Suspending account, Description : ".$inv['desc']."</b></font><br />\n";
                                flush();
                                ob_flush();
                                sleep(1);
                                $echo = $BL->changeStatus($inv['sub_id'],"suspend");
                                echo nl2br($echo);
                                $suspended_ids[] = $inv['sub_id'];
                            }
                        }
                    }
                    ob_end_flush();
                }
            ?>
        </font>
    </body>
</html>
