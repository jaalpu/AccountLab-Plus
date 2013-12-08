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

    $name       = "e-gold";
    $egold      = array (
        array ("Account"            , "eg_payee_account"),
        array ("Your company name"  , "eg_payee_account_name"),
        array ("Metal for Payment"  , "eg_metal", "Any", "Gold", "Silver", "Platinum", "Palladium"),
        array ("Currency"           , "eg_currency", "USD", "CAD", "FRF", "CHF", "GBP", "DEM", "AUD", "JPY", "EUR", "BEF", "ATS", "GRD", "ESP", "IEP", "ITL", "LUF", "NLG", "PTE", "FIM", "EEK", "LTL", "g", "oz"),
        array ("Active"             , "active", "No", "Yes"),
        array ("Title"              , "title"),
        array ("Submit label"       , "submit_label")
    );
    $send_method= "POST";
    $pay        = new egold($demo_mode);
    /*
    * Class to do all egold
    * egold Version 1.0
    */
    class egold
    {
        /*
        * Constructor
        */
        function egold()
        {
            $this->pay_url = "https://www.e-gold.com/sci_asp/payments.asp";
        }
        /*
        * Function to send variables
        */
        function sendVariables($path_url, $pp_vals)
        {
            $curr_array   = array ("1" => "USD", "2" => "CAD", "33" => "FRF", "41" => "CHF", "44" => "GBP", "49" => "DEM", "61" => "AUD", "81" => "JPY", "85" => "EUR", "86" => "BEF", "87" => "ATS", "88" => "GRD", "89" => "ESP", "90" => "IEP", "91" => "ITL", "92" => "LUF", "93" => "NLG", "94" => "PTE", "95" => "FIM", "96" => "EEK", "97" => "LTL", "8888" => "g", "9999" => "oz");
            $metals       = array ("Any" => 0, "Gold" => 1, "Silver" => 2, "Platinum" => 3, "Palladium" => 4);

            $this->eg_metal= $metals[$pp_vals['eg_metal']];

            foreach ($curr_array as $k => $v)
            {
                if ($v == $pp_vals['eg_currency'])
                {
                    $this->eg_currency = $k;
                }
            }

            $this->eg_payee_account       = $pp_vals['eg_payee_account'];
            $this->eg_payee_account_name  = $pp_vals['eg_payee_account_name'];

            $this->_POST1                 = array ();

            $this->_POST1['item_number']  = time().rand(0, 1000);
            if (isset ($_POST['force_inv_no']))
            {
                $this->_POST1['item_number']= $_POST['force_inv_no'];
            }

            $this->_POST1['PAYEE_ACCOUNT']    = $this->eg_payee_account;
            $this->_POST1['PAYEE_NAME']       = $this->eg_payee_account_name;
            $this->_POST1['STATUS_URL']       = $path_url."/ipn.php";
            $this->_POST1['PAYMENT_URL']      = $path_url."/OK.php";
            $this->_POST1['NOPAYMENT_URL']    = $path_url."NOK.php";
            $this->_POST1['PAYMENT_AMOUNT']   = number_format($_POST['gross_amount'],2);
            $this->_POST1['PAYMENT_UNITS']    = $this->eg_currency;
            $this->_POST1['PAYMENT_METAL_ID'] = $this->eg_metal;
            $this->_POST1['PAYMENT_ID']       = $this->_POST1['item_number'];
            $this->_POST1['BAGGAGE_FIELDS']   = "DESCRIPTION ITEM PAYMENTPROCESSOR";
            $this->_POST1['DESCRIPTION']      = $_POST['desc'];
            $this->_POST1['ITEM']             = $this->_POST1['item_number'];
            $this->_POST1['PAYMENTPROCESSOR'] = "EGOLD";
        }
        /*
        * IPN=Internet Payment Notifier
        */
        function ipn(& $BL)
        {
            $this->item_number    = $_POST['ITEM'];
            $this->transaction_id = $_POST['PAYMENT_BATCH_NUM'];
            $this->payment_status ="OK";
            if ($_POST['PAYMENTPROCESSOR'] == "EGOLD" && !empty ($this->item_number) && !empty ($this->transaction_id))
            {
                $BL->invoices->processTransaction($this->item_number, $this->transaction_id);
                return true;
            }
            return false;
        }
    }
?>
