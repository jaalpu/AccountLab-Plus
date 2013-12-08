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

    $name           = "2 Checkout";
    $twocheckout    = array (
        array ("ID"             , "tco_id"),
        array ("Secret Word"    , "tco_secret_word"),
        array ("Parameters"     ,"tco_params", "Own", "Authorize.net"),
        array ("Active"         , "active", "No", "Yes"),
        array ("Title"          , "title"),
        array ("Submit label"   , "submit_label")
    );
    $send_method    = "POST";
    $pay            = new twocheckout($demo_mode);
    /*
    * Class to do all twocheckout
    * twocheckout Version 1.0
    */
    class twocheckout
    {
        /*
        * Constructor
        */
        function twocheckout($demo_mode= 0)
        {
            $this->demo_mode  = $demo_mode;
            $this->pay_url    = "https://www.2checkout.com/2co/buyer/purchase";
        }
        /*
        * Function to send variables
        */
        function sendVariables($path_url, $pp_vals)
        {
            $this->_POST1                = array ();
            $this->_POST1['item_number'] = time().rand(0, 1000);
            if (isset ($_POST['force_inv_no']))
            {
                $this->_POST1['item_number']= $_POST['force_inv_no'];
            }
            $this->_POST1['gateway']     = "twocheckout";
            if ($this->demo_mode)
            {
                $this->_POST1['demo'] = "Y";
            }
            $this->_POST1['fixed']  = "Y";
            $this->_POST1['lang']   = "en";
            if($pp_vals['tco_params'] != "Authorize.net")
            {
                $this->_POST1['sid']            = $pp_vals['tco_id'];
                $this->_POST1['total']          = number_format($_POST['gross_amount'],2);
                $this->_POST1['cart_order_id']  = $this->_POST1['item_number'];
                $this->_POST1['return_url']     = $path_url."/ipn.php";
                $this->_POST1['card_holder_name']= $_POST['name'];
                $this->_POST1['street_address'] = $_POST['address'];
                $this->_POST1['city']           = $_POST['city'];
                $this->_POST1['state']          = $_POST['state'];
                $this->_POST1['zip']            = $_POST['zip'];
                $this->_POST1['country']        = $_POST['country'];
                $this->_POST1['email']          = $_POST['email'];
                $this->_POST1['phone']          = $_POST['telephone'];
            }
            else
            {
                $this->_POST1['x_login']            = $pp_vals['tco_id'];
                $this->_POST1['x_amount']           = number_format($_POST['gross_amount'],2);
                $this->_POST1['x_invoice_num']      = $this->_POST1['item_number'];
                $this->_POST1['x_Receipt_Link_URL'] = $path_url."/ipn.php";
                $array_name                         = array ();
                $array_name                         = explode(' ', $_POST['name'], 2);
                $this->_POST1['x_First_Name']       = $array_name[0];
                $this->_POST1['x_Last_Name']        = $array_name[1];
                $this->_POST1['x_Phone']            = $_POST['telephone'];
                $this->_POST1['x_Email']            = $_POST['email'];
                $this->_POST1['x_Address']          = $_POST['address'];
                $this->_POST1['x_City']             = $_POST['city'];
                $this->_POST1['x_State']            = $_POST['state'];
                $this->_POST1['x_Zip']              = $_POST['zip'];
                $this->_POST1['x_Country']          = $_POST['country'];
                $this->_POST1['x_email_merchant']   = TRUE;
            }
            $this->_POST1['c_prod']         = $this->_POST1['item_number'];
            $this->_POST1['c_name']         = $_POST['desc'];
            $this->_POST1['c_description']  = $_POST['friendly_desc'];
            $this->_POST1['c_price']        = number_format($_POST['gross_amount'],2);
            $this->_POST1['c_tangible']     = 'N';
        }
        /*
        * IPN=Internet Payment Notifier
        */
        function ipn(& $BL)
        {
            $sqlSELECT = "SELECT  * FROM {$BL->props->tbl_payment_processors} WHERE `pp_name` ='twocheckout'";
            $temp      = $BL->dbL->executeSELECT($sqlSELECT);
            $pp_vals   = $temp[0];

            if($pp_vals['tco_params'] != "Authorize.net")
            {
                $this->transaction_id   = $_POST['order_number'];
                $this->item_number      = $_POST['cart_order_id'];
                $this->payment_status   = $_POST['credit_card_processed'];
                $ref                    = $_POST["Ref"];
                $key                    = $_POST['key'];
                $amount                 = $_POST["total"];
            }
            else
            {
                $this->transaction_id   = $_POST['x_trans_id'];
                $this->item_number      = $_POST['x_invoice_num'];
                $this->payment_status   = $_POST['x_2checked'];
                $ref                    = $_POST['x_invoice_num'];
                $key                    = $_POST['x_MD5_Hash'];
                $amount                 = $_POST["x_amount"];
            }

            $md5hash = md5($pp_vals['tco_secret_word'].$pp_vals['tco_id'].$this->item_number.number_format($amount,2));
            if($this->demo_mode)
            {
                $md5hash = md5($pp_vals['tco_secret_word'].$pp_vals['tco_id']."1".number_format($amount,2));
            }

            if ((empty($pp_vals['tco_secret_word']) || strtoupper($key)==strtoupper($md5hash)) && $_POST['gateway'] == "twocheckout" && !empty ($this->item_number) && !empty ($this->transaction_id) && ($this->payment_status == "Y" || $this->payment_status == "K"))
            {
                if ($this->payment_status == "K")
                {
                    $_POST['skip_auto_creation'] = 1;
                }
                $BL->invoices->processTransaction($this->item_number, $this->transaction_id);
                return true;
            }
            return false;
        }
    }
?>
