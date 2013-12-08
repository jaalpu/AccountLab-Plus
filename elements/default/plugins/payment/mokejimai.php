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

    $name       = "Mokejimai";
    $mokejimai  = array (
        array ("Mokejimai Merchant ID"  , "mokejimai_MerchantID"),
        array ("Mokejimai Password"     , "mokejimai_Password"),
        array ("Mokejimai Language"     , "mokejimai_Lang", "ENG", "ESP", "EST", "FIN", "FRE", "GEO", "GER", "ITA", "LAV", "LIT", "NOR", "POL", "ROU", "RUS", "SPA", "SWE"),
        array ("Mokejimai Currency"     , "mokejimai_Currency", "LTL","USD","EUR"),
        array ("Active"                 , "active", "No", "Yes"),
        array ("Title"                  , "title"),
        array ("Submit label"           , "submit_label")
    );
    $send_method= "POST";
    $pay        = new mokejimai($demo_mode);
    /*
    * Class to do all Mokejimai
    * Mokejimai Version 1.0
    */
    class mokejimai
    {
        /*
        * Constructor
        */
        function mokejimai($demo_mode= 0)
        {
            $this->demo_mode  = $demo_mode;
            $this->pay_url    = "https://www.mokejimai.lt/pay/";
        }
        /*
        * Function to send variables
        */
        function sendVariables($path_url, $pp_vals)
        {
            $this->_POST1                 = array ();
            $this->_POST1['MerchantID']   = $pp_vals['mokejimai_MerchantID'];
            $this->_POST1['Lang']         = $pp_vals['mokejimai_Lang'];
            $this->_POST1['Currency']     = $pp_vals['mokejimai_Currency'];
            $this->_POST1['Amount']       = number_format(($_POST['gross_amount']*100),2);

            $this->_POST1['item_number']  = time().rand(0, 1000);
            if (isset ($_POST['force_inv_no']))
            {
                $this->_POST1['item_number']= $_POST['force_inv_no'];
            }
            $this->_POST1['OrderID']      = $this->_POST1['item_number'];

            $this->_POST1['AcceptURL']    = $path_url."/OK.php";
            $this->_POST1['CancelURL']    = $path_url."/NOK.php";
            $this->_POST1['CallbackURL']  = $path_url."/ipn.php";

            $this->_POST1['item_name']    = $_POST['friendly_desc'];
            if(empty($this->_POST1['item_name']))
            {
                $this->_POST1['item_name']= $_POST['desc'];
            }

            $this->_POST1['PayText']      = $this->_POST1['item_name'];

            if ($this->demo_mode)
            {
                $this->_POST1['Test']= "1";
            }
        }
        /*
        * IPN=Internet Payment Notifier
        */
        function ipn(& $BL)
        {
            $this->item_number    = $_GET['orderid'];
            $this->transaction_id = $_GET['transaction'];
            $this->payment_status = $_GET['status'];


            $sqlSELECT = "SELECT  * FROM {$BL->props->tbl_payment_processors} WHERE `pp_name` ='mokejimai'";
            $temp      = $BL->dbL->executeSELECT($sqlSELECT);
            $pp_vals   = $temp[0];
            $your_mokejimai_pass  = $pp_vals['mokejimai_pass'];

            if (!empty ($this->item_number) && !empty ($this->transaction_id) && $this->payment_status == "1" && $this->TestTransaction( $_GET['transaction'], $your_mokejimai_pass, $_GET['orderid'], $this->demo_mode, $this->payment_status ) )
            {
                $BL->invoices->processTransaction($this->item_number, $this->transaction_id);
                return true;
            }
            return false;
        }
        function TestTransaction( $transaction, $userPassword, $ordeID, $test = 0, $status = 1 ){
            return ( $transaction == md5("{$userPassword}|{$_SERVER['REMOTE_ADDR']}|{$ordeID}|{$test}|{$status}") );
        }
    }
?>
