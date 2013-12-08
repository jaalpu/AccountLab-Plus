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

    $name       = "ProxyPay";
    $proxypay   = array (
        array ("ProxyPay Server Url"    , "server_url"),
        array ("Merchant ID"            , "merchant_id"),
        array ("Confirmation Password"  , "pp3_conf_pass"),
        array ("Currency"               , "pp3_currency", "ATS", "BEF", "FRF", "GRD", "DEM", "ITL", "LUF", "NLG", "ESP", "CHF", "GBP", "USD", "EUR", "JPY"),
        array ("Active"                 , "active", "No", "Yes"),
        array ("Title"                  , "title"),
        array ("Submit label"           , "submit_label")
    );
    $send_method= "POST";
    $pay        = new proxypay($proxy_url);
    /*
    * Class to do all proxypay
    * proxypay Version 1.0
    */
    class proxypay
    {
        /*
        * Constructor
        */
        function proxypay($url)
        {
            $this->pay_url    = $url;
            $this->curr       = array ();
            $currency_array1  = array ("ATS", "BEF", "FRF", "GRD", "DEM", "ITL", "LUF", "NLG", "ESP", "CHF", "GBP", "USD", "EUR", "JPY");
            $currency_array2  = array ("0040", "0056", "0250", "0300", "0280", "0380", "0442", "0528", "0724", "0756", "0826", "0840", "0978", "0392");
            for ($i= 0; $i < count($currency_array1); $i ++)
            {
                $this->curr[$currency_array1[$i]]= $currency_array2[$i];
            }
        }
        /*
        * Function to send variables
        */
        function sendVariables($path_url, $pp_vals)
        {
            $this->merchant_id    = $pp_vals['merchant_id'];
            $this->_POST1         = array ();
            $this->_POST1['item_number'] = time().rand(0, 1000);
            if (isset ($_POST['force_inv_no']))
            {
                $this->_POST1['item_number'] = $_POST['force_inv_no'];
            }
            $this->_POST1['amount']          = number_format($_POST['gross_amount'],2) * 100;
            $this->_POST1['APACScommand']    = "NewPayment";
            $this->_POST1['merchantID']      = $this->merchant_id;
            $this->_POST1['merchantRef']     = $this->_POST1['item_number'];
            $this->_POST1['merchantDesc']    = $_POST['desc'];
            $this->_POST1['CustomerEmail']   = $_POST['email'];
            $this->_POST1['currency']        = $this->curr[$pp_vals['pp3_currency']];
            $this->_POST1['lang']            = "EN";
            $this->_POST1['var1']            = "ProxyPay3";
        }
        /*
        * IPN=Internet Payment Notifier
        */
        function ipn(& $BL)
        {
            $this->item_number    = trim($_POST['Ref']);
            $this->transaction_id = trim($_POST['Transid']);
            $this->payment_status = "OK";
            $sqlSELECT    = "SELECT  * FROM {$BL->props->tbl_payment_processors} WHERE `pp_name` ='proxypay'";
            $temp         = $BL->dbL->executeSELECT($sqlSELECT);
            $pp_vals      = $temp[0];
            if (!empty ($this->item_number) && !empty ($this->transaction_id) && trim($_POST['var1']) == "ProxyPay3" && trim($_POST["Password"]) == $pp_vals['pp_conf_pass'])
            {
                $BL->invoices->processTransaction($this->item_number, $this->transaction_id);
                return true;
            }
            return false;
        }
        /*
        * Validate function
        */
        function validate(& $BL)
        {
            $sqlSELECT  = "SELECT  * FROM {$BL->props->tbl_payment_processors} WHERE `pp_name` ='proxypay'";
            $temp       = $BL->dbL->executeSELECT($sqlSELECT);
            $pp_vals    = $temp[0];

            if ((trim($_POST["Shop"]) == $pp_vals['merchant_id']) && ("0".trim($_POST["Currency"]) == $this->curr[$pp_vals['pp3_currency']] || "00".trim($_POST["Currency"]) == $this->curr[$pp_vals['pp3_currency']]))
            {
                if($BL->verifyAmount(trim($_POST['Ref']),trim($_POST['Amount'])))
                {
                    return "[OK]";
                }
                else
                {
                    return "[NOTOK]";
                }
            }
        }
    }
?>
