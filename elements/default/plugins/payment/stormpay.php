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

    $name       = "Stormpay";
    $stormpay   = array (
        array ("Stormpay email" , "payee_email"),
        array ("Secret Code"    , "sp_secret_code"),
        array ("Active"         , "active", "No", "Yes"),
        array ("Title"          , "title"),
        array ("Submit label"   , "submit_label")
    );
    $send_method= "POST";
    $pay        = new stormpay($demo_mode);
    /*
    * Class to do all stormpay
    * stormpay Version 1.0
    */
    class stormpay
    {
        /*
        * Constructor
        */
        function stormpay($demo_mode= 0)
        {
            $this->demo_mode  = $demo_mode;
            $this->pay_url    = "https://www.stormpay.com/stormpay/handle_gen.php";
        }
        /*
        * Function to send variables
        */
        function sendVariables($path_url, $pp_vals)
        {
            $this->_POST1                 = array ();
            $this->_POST1['payee_email']  = $pp_vals['payee_email'];
            $this->_POST1['amount']       = number_format($_POST['gross_amount'],2);
            $this->_POST1['generic']      = 1;
            $this->_POST1['product_name'] = $_POST['desc'];
            $this->_POST1['require_IPN']  = 1;
            $this->_POST1['notify_URL']   = $path_url."/ipn.php";
            $this->_POST1['return_URL']   = $path_url."/OK.php";
            $this->_POST1['cancel_URL']   = $path_url."/NOK.php";
            //switch demo mode
            if ($this->demo_mode)
            {
                $this->_POST1['test_mode']= 1;
            }
            $this->_POST1['item_number']  = time().rand(0, 1000);
            if (isset ($_POST['force_inv_no']))
            {
                $this->_POST1['item_number']= $_POST['force_inv_no'];
            }
            $this->_POST1['transaction_ref']= $this->_POST1['item_number'];
            $this->_POST1['user1']        = $this->_POST1['item_number'];
            $this->_POST1['user2']        = 'strompay';
        }
        /*
        * IPN=Internet Payment Notifier
        */
        function ipn(& $BL)
        {
            $this->item_number    = $_POST['transaction_ref'];
            $this->transaction_id = $_POST['transaction_id'];
            $this->payment_status = $_POST['status'];

            $sqlSELECT = "SELECT  * FROM {$BL->props->tbl_payment_processors} WHERE `pp_name` ='stormpay'";
            $temp      = $BL->dbL->executeSELECT($sqlSELECT);
            $pp_vals   = $temp[0];

            if (!empty ($_POST['user1']) && ($this->payment_status == "SUCCESS" || $this->payment_status == "TEST") && is_int($this->transaction_id) && !empty ($_POST['user1']) && !empty ($this->item_number) && $_POST['user1'] == $this->item_number && $_POST['user2'] == "stormpay" && $pp_vals['sp_secret_code']==$_POST['secret_code'])
            {
                $BL->invoices->processTransaction($this->item_number, $this->transaction_id);
                return true;
            }
            return false;
        }
    }
?>
