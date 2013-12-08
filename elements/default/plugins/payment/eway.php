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

    $name    = "eWAY";
    $eway = array (
        array ("Customer ID", "eway_CustomerID"),
        array ("Site Title" , "eway_SiteTitle"),
        array ("Active"     , "active", "No", "Yes"),
        array ("Title"      , "title"),
        array ("Submit label", "submit_label")
    );
    $send_method = "POST";
    $pay         = new eway($demo_mode);
    /*
    * Class to do all eway
    * eway Version
    */
    class eway
    {
        /*
        * Constructor
        */
        function eway($demo_mode= 0)
        {
            $this->demo_mode = $demo_mode;
            $this->pay_url   = "https://www.eway.com.au/gateway/payment.asp";
        }
        /*
        * Function to send variables
        */
        function sendVariables($path_url, $pp_vals)
        {
            $this->_POST1 = array ();
            $this->_POST1['ewayCustomerID'] = $pp_vals['eway_CustomerID'];
            $this->_POST1['ewaySiteTitle'] = $pp_vals['eway_SiteTitle'];
            $this->_POST1['ewayTotalAmount'] = ($_POST['gross_amount']*100);
            $this->_POST1['item_name'] = $_POST['friendly_desc'];
            if(empty($this->_POST1['item_name']))
            {
                $this->_POST1['item_name'] = $_POST['desc'];
            }
            $this->_POST1['ewayCustomerInvoiceDescription'] = $this->_POST1['item_name'];

            $this->_POST1['item_number'] = time().rand(0, 1000);
            if (isset ($_POST['force_inv_no']))
            {
                $this->_POST1['item_number'] = $_POST['force_inv_no'];
            }
            $this->_POST1['ewayCustomerInvoiceRef'] = $this->_POST1['item_number'];
            $this->_POST1['ewayTrxnNumber'] = $this->_POST1['item_number'];

            $this->_POST1['ewayURL'] = $path_url."/ipn.php";
            $this->_POST1['ewayAutoRedirect']= 1;
            $this->_POST1['btnProcessPayment']= "Process Payment";

            $array_name = array ();
            $array_name = explode(' ', $_POST['name'], 2);
            $this->_POST1['ewayCustomerFirstName']= $array_name[0];
            $this->_POST1['ewayCustomerLastName'] = $array_name[1];
            $this->_POST1['ewayCustomerEmail'] = $_POST['email'];
            $this->_POST1['ewayCustomerAddress']  = $_POST['address'].", ".$_POST['city'].", ".$_POST['state'].", ".$_POST['country'];
            $this->_POST1['ewayCustomerPostcode'] = $_POST['zip'];
        }
        /*
        * IPN=Internet Payment Notifier
        */
        function ipn(& $BL)
        {
            $this->item_number    = $_POST['ewayTrxnNumber'];
            $this->transaction_id = $_POST['ewayTrxnReference'];
            $this->payment_status = $_POST['ewayTrxnStatus'];
            if (!empty ($this->item_number) && !empty ($this->transaction_id) && $this->payment_status=="True")
            {
                $BL->invoices->processTransaction($this->item_number, $this->transaction_id);
                return true;
            }
            return false;
        }
    }
?>
