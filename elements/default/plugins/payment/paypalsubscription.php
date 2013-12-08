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

    $name               = "PayPal Subscriptions";
    $paypalsubscription = array (
        array ("Email"      , "paypal_s_email"),
        array ("Currency"   , "paypal_s_currency", "USD", "GBP", "EUR", "CAD", "JPY", "AUD"),
        array ("Active"     , "active", "No", "Yes"),
        array ("Title"      , "title"),
        array ("Submit label", "submit_label")
    );
    $send_method        = "POST";
    $pay                = new paypalsubscription($demo_mode);
    /*
    * Class to do all paypal
    * paypal Version
    */
    class paypalsubscription
    {
        /*
        * Constructor
        */
        function paypalsubscription($demo_mode= 0)
        {
            $this->demo_mode = $demo_mode;
            $this->pay_url   = "https://www.paypal.com/cgi-bin/webscr";
            if ($this->demo_mode)
            {
                $this->pay_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
            }
        }
        /*
        * Function to send variables
        */
        function sendVariables($path_url, $pp_vals)
        {
            global $BL;
            $tax_data                     = $BL->invoices->calculateTax($_POST['total_recurring_fee'],$_POST['country'],$_POST['state']);
            $this->_POST1                 = array ();
            $this->_POST1['cmd']          = "_xclick-subscriptions";
            $this->_POST1['redirect_cmd'] = "_xclick";
            $this->_POST1['business']     = $pp_vals['paypal_s_email'];
            $this->_POST1['currency_code']= $pp_vals['paypal_s_currency'];
            $this->_POST1['notify_url']   = $path_url."/ipn.php";
            $this->_POST1['return']       = $path_url."/OK.php";
            $this->_POST1['cancel_return']= $path_url."/NOK.php";
            $this->_POST1['no_shipping']  = 1;
            $this->_POST1['no_note']      = 1;
            $this->_POST1['rm']           = 2;
            $this->_POST1['item_name']    = $_POST['friendly_desc'];
            if(empty($this->_POST1['item_name']))
            {
                $this->_POST1['item_name'] = $_POST['desc'];
            }
            $next_bill_date = $BL->utils->getDateArray($_POST['next_bill_date']);
            $initial_days   = $BL->utils->dateDiff(date('d'),date('m'),date('Y'),$next_bill_date['mday'],$next_bill_date['mon'],$next_bill_date['year']);
            if(!empty($_POST['total_recurring_fee']) && !empty($_POST['bill_cycle']) && $_POST['bill_cycle']!='none')
            {
                $this->_POST1['a1'] = number_format($_POST['gross_amount'],2);
                if ($BL->conf['en_prorate'])
                {
                    $this->_POST1['p1'] = $_POST['bill_cycle'];
                    $this->_POST1['t1'] = "M";
                }
                else
                {
                    $this->_POST1['p1'] = $_POST['bill_cycle'];
                    $this->_POST1['t1'] = "M";
                }
                $this->_POST1['a3'] = number_format($_POST['total_recurring_fee'] + $tax_data['total_tax_amount'],2);
                $this->_POST1['p3'] = $_POST['bill_cycle'];
                $this->_POST1['t3'] = "M";
            }
            elseif($_POST['gross_amount']>0 && !empty($_POST['dom_reg_year']))
            {
                $this->_POST1['a1'] = number_format($_POST['gross_amount'],2);
                if ($BL->conf['en_prorate'])
                {
                    $this->_POST1['p1'] = $_POST['dom_reg_year'];
                    $this->_POST1['t1'] = "Y";
                }
                else
                {
                    $this->_POST1['p1'] = $_POST['dom_reg_year'];
                    $this->_POST1['t1'] = "Y";
                }

                $this->_POST1['a3'] = number_format($_POST['gross_amount'],2);
                $this->_POST1['p3'] = $_POST['dom_reg_year'];
                $this->_POST1['t3'] = "Y";
            }

            $this->_POST1['src'] = 1;
            $this->_POST1['item_number'] = time().rand(0, 1000);
            if (isset ($_POST['force_inv_no']))
            {
                $this->_POST1['item_number'] = $_POST['force_inv_no'];
            }

            $array_name                = array ();
            $array_name                = explode(' ', $_POST['name'], 2);
            $this->_POST1['first_name']= $array_name[0];
            $this->_POST1['last_name'] = $array_name[1];
            $this->_POST1['address1']  = $_POST['address'];
            $this->_POST1['city']      = $_POST['city'];
            $this->_POST1['state']     = $_POST['state'];
            $this->_POST1['zip']       = $_POST['zip'];
            $this->_POST1['country']   = $_POST['country'];
        }
        /*
        * Function to post back
        */
        function postBack()
        {
            $POSTString   = "cmd=_notify-validate";
            foreach ($_POST as $key => $val)
            {
                if ($key != "cmd")
                {
                    $POSTString .= "&".$key."=".urlencode($val);
                }
            }
            $Connection = curl_init();
            curl_setopt($Connection, CURLOPT_URL, $this->pay_url);
            curl_setopt($Connection, CURLOPT_POST, 1);
            curl_setopt($Connection, CURLOPT_POSTFIELDS, $POSTString);
            curl_setopt($Connection, CURLOPT_RETURNTRANSFER, 1);
            $Response   = curl_exec($Connection);
            curl_close($Connection);
            if (preg_match("/VERIFIED/i", $Response))
            {
                return 1;
            }
            else
            {
                return 0;
            }
        }
        /*
        * IPN=Internet Payment Notifier
        */
        function ipn(& $BL)
        {
            $this->item_number    = $_POST['item_number'];
            $this->transaction_id = $_POST['txn_id'];
            $this->payment_status   =$_POST['payment_status'];
            if ($this->postBack() && !empty ($this->item_number) && !empty ($this->transaction_id) && $this->payment_status=="Completed")
            {
                $BL->invoices->processTransaction($this->item_number, $this->transaction_id);
                return true;
            }
            return false;
        }
    }
?>
