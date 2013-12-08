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

    $name           = "Authorize.net";
    $authorizenet   = array (
        array ("Login ID"       , "auth_id"),
        array ("Transaction Key", "auth_tid"),
        array ("Currency"       , "auth_currency"),
        array ("Active"         , "active", "No", "Yes"),
        array ("Title"          , "title"),
        array ("Submit label"   , "submit_label")
    );
    $send_method    = "POST";
    $pay            = new authorizenet($demo_mode);
    /*
    * Class to do all authorizenet
    * authorizenet Version 1.0
    */
    class authorizenet
    {
        /*
        * Constructor
        */
        function authorizenet($demo_mode= 0)
        {
            $this->demo_mode = $demo_mode;
            $this->pay_url   = "https://secure.authorize.net/gateway/transact.dll";
            if ($this->demo_mode)
            {
                $this->pay_url = "https://certification.authorize.net/gateway/transact.dll";
            }
        }
        /*
        * Function to send variables
        */
        function sendVariables($path_url, $pp_vals)
        {
            $this->_POST1             = array ();
            $this->auth_id            = $pp_vals['auth_id'];
            $this->auth_tid           = $pp_vals['auth_tid'];
            $this->auth_currency      = $pp_vals['auth_currency'];
            $this->_POST1['x_amount'] = number_format($_POST['gross_amount'],2);
            $this->_POST1['x_currency_code'] = $this->auth_currency;
            if ($this->demo_mode)
            {
                $this->_POST1['x_test_request'] = TRUE;
            }
            $this->_POST1['item_number'] = time().rand(0, 1000);
            if (!empty ($_POST['force_inv_no']))
            {
                $this->_POST1['item_number'] = $_POST['force_inv_no'];
            }
            $this->_POST1['x_login']          = $this->auth_id;
            $this->_POST1['x_fp_sequence']    = $this->_POST1['item_number'];
            $this->_POST1['x_fp_timestamp']   = time();
            $this->fingerprint                = $this->hmac($this->auth_tid, $this->auth_id."^".$this->_POST1['x_fp_sequence']."^".$this->_POST1['x_fp_timestamp']."^".$this->_POST1['x_amount']."^".$this->_POST1['x_currency_code']);
            $this->_POST1['x_fp_hash']        = $this->fingerprint;
            $this->_POST1['x_show_form']      = "PAYMENT_FORM";
            $this->_POST1['x_version']        = "3.1";
            //$this->_POST1['x_relay_response']= TRUE;
            //$this->_POST1['x_relay_url']    = $path_url."/ipn.php";
            $array_name                       = array ();
            $array_name                       = explode(' ', $_POST['name'], 2);
            $this->_POST1['x_first_name']     = $array_name[0];
            $this->_POST1['x_last_name']      = $array_name[1];
            $this->_POST1['x_phone']          = $_POST['telephone'];
            $this->_POST1['x_email']          = $_POST['email'];
            $this->_POST1['x_address']        = $_POST['address'];
            $this->_POST1['x_city']           = $_POST['city'];
            $this->_POST1['x_state']          = $_POST['state'];
            $this->_POST1['x_zip']            = $_POST['zip'];
            $this->_POST1['x_country']        = $_POST['country'];
            $this->_POST1['x_invoice_num']    = $this->_POST1['item_number'];
            $this->_POST1['gateway']          = "Authorizenet";
        }
        /*
        * hmac
        */
        function hmac($key, $data)
        {
            return (bin2hex(mhash(MHASH_MD5, $data, $key)));
        }
        /*
        * CalculateFP
        */
        function CalculateFP($loginid, $x_tran_key, $amount, $sequence, $tstamp, $currency= "")
        {
            return ($this->hmac($x_tran_key, $loginid."^".$sequence."^".$tstamp."^".$amount."^".$currency));
        }
        /*
        * IPN=Internet Payment Notifier
        */
        function ipn(& $BL)
        {
            $this->item_number    = $_POST['x_invoice_num'];
            $this->transaction_id = $_POST['x_trans_id'];
            $this->payment_status = $_POST['x_response_code'];
            $verifyamount         = $BL->verifyAmount($this->item_number,$_POST["x_amount"]);
            if (!empty ($this->item_number) && !empty ($this->transaction_id) && $this->payment_status == 1 && $verifyamount && $_POST['gateway'] == "Authorizenet")
            {
                $BL->invoices->processTransaction($this->item_number, $this->transaction_id);
                return true;
            }
            return false;
        }
    }
?>
