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

    $name       = "WebMoney Transfer";
    $wmtransfer = array (
        array ("Merchant's purse"   , "purse_id"),
        array ("Active"             , "active", "No", "Yes"),
        array ("Title"              , "title"),
        array ("Submit label"       , "submit_label")
    );
    $send_method= "POST";
    $pay        = new wmtransfer($demo_mode);
    /*
    * Class to do all wmtransfer
    * wmtransfer Version 1.0
    */
    class wmtransfer
    {
        /*
        * Constructor
        */
        function wmtransfer($demo_mode)
        {
            $this->demo_mode  = $demo_mode;
            $this->pay_url    = "https://merchant.wmtransfer.com/lmi/payment.asp";
        }
        /*
        * Function to send variables
        */
        function sendVariables($path_url, $pp_vals)
        {
            $this->_POST1                         = array ();
            $this->_POST1['LMI_PAYEE_PURSE']      = $pp_vals['purse_id'];
            $this->_POST1['LMI_PAYMENT_DESC']     = $_POST['desc'];
            $this->_POST1['LMI_PAYMENT_AMOUNT']   = number_format($_POST['gross_amount'],2);
            $this->_POST1['LMI_RESULT_URL']       = $path_url."/ipn.php";
            $this->_POST1['LMI_SUCCESS_URL']      = $path_url."/OK.php";
            $this->_POST1['LMI_FAIL_URL']         = $path_url."/NOK.php";
            $this->_POST1['LMI_SUCCESS_METHOD']   = 1;
            if ($this->demo_mode)
            {
                $this->_POST1['LMI_SIM_MODE'] = 1;
            }
            $this->_POST1['P_METHOD']     = "WMT";
            $this->_POST1['item_number']  = time().rand(0, 1000);
            if (isset ($_POST['force_inv_no']))
            {
                $this->_POST1['item_number'] = $_POST['force_inv_no'];
            }
            $this->_POST1['PP']   = "wmtransfer";
        }
        /*
        * IPN=Internet Payment Notifier
        */
        function ipn(& $BL)
        {
            $this->item_number    = $_POST['item_number'];
            $this->transaction_id = $_POST['LMI_SYS_TRANS_NO'];
            $this->payment_status = "OK";
            if (!empty ($this->item_number) && !empty ($this->transaction_id) && $_POST['PP'] == "wmtransfer")
            {
                $BL->invoices->processTransaction($this->item_number, $this->transaction_id);
                return true;
            }
            return false;
        }
    }
?>
