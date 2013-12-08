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

    $name       = "ChronoPay";
    $chronopay  = array (
        array ("Product Id"     , "chronopay_product_id"),
        array ("Currency"       , "chronopay_currency", "USD"),
        array ("Active"         , "active", "No", "Yes"),
        array ("Title"          , "title"),
        array ("Submit label"   , "submit_label")
    );
    $send_method= "POST";
    $pay        = new chronopay($demo_mode);
    /*
    * Class to do all chronopay
    * chronopay Version
    */
    class chronopay
    {
        /*
        * Constructor
        */
        function choronopay($demo_mode= 0)
        {
            $this->demo_mode  = $demo_mode;
            $this->pay_url    = "https://secure.chronopay.com/index_shop.cgi";
        }
        /*
        * Function to send variables
        */
        function sendVariables($path_url, $pp_vals)
        {
            $this->_POST1                             = array ();
            $this->_POST1['product_id']               = $pp_vals['chronopay_product_id'];
            $this->_POST1['product_price_currency']   = $pp_vals['chronopay_currency'];
            $this->_POST1['product_price']            = number_format($_POST['gross_amount'],2);
            $this->_POST1['product_name']             = $_POST['friendly_desc'];
            if(empty($this->_POST1['product_name']))
            {
                $this->_POST1['product_name'] = $_POST['desc'];
            }

            $this->_POST1['item_number']              = time().rand(0, 1000);
            if (isset ($_POST['force_inv_no']))
            {
                $this->_POST1['item_number'] = $_POST['force_inv_no'];
            }

            $this->_POST1['cb_url']       = $path_url."/ipn.php";
            $this->_POST1['decline_url']  = $path_url."/NOK.php";

            $this->_POST1['name']       = $_POST['name'];
            $this->_POST1['street']     = $_POST['address'];
            $this->_POST1['city']       = $_POST['city'];
            $this->_POST1['state']      = $_POST['state'];
            $this->_POST1['zip']        = $_POST['zip'];
            $this->_POST1['country']    = $_POST['country'];
            $this->_POST1['phone']      = $_POST['telephone'];
            $this->_POST1['email']      = $_POST['email'];

            $this->_POST1['cs1']        = $this->_POST1['item_number'];
            $this->_POST1['cs2']        = "Chronopay";
            $this->_POST1['cb_type']    = "P";

        }
        /*
        * IPN=Internet Payment Notifier
        */
        function ipn(& $BL)
        {
            $this->item_number    = $_POST['cs1'];
            $this->transaction_id = $_POST['transaction_id'];
            $this->payment_status = $_POST['transaction_type'];
            if (!empty ($this->item_number) && !empty ($this->transaction_id) && $_POST['cs2']=="Chronopay" && $BL->verifyAmount($this->item_number,$_POST['total']))
            {
                $BL->invoices->processTransaction($this->item_number, $this->transaction_id);
                return true;
            }
            return false;
        }
    }
?>
