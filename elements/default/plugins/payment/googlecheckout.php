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

    $name = "Google checkout";
    $googlecheckout = array (
        array ("Merchant ID", "googlecheckout_id"),
        array ("Merchant Key", "googlecheckout_key"),
        array ("Active", "active", "No", "Yes"),
        array ("Title", "title"),
        array ("Submit label", "submit_label")
    );
    $send_method = "POST";
    $pay = new googlecheckout($demo_mode);
    /*
    * Class to do all google
    * Google Version
    */
    class googlecheckout
    {
        /*
        * Constructor
        */
        function googlecheckout($demo_mode = 0)
        {
            $this->demo_mode = $demo_mode;
            $this->pay_url = "ipn.php";
        }
        /*
        * Function to send variables
        */
        function sendVariables($path_url, $pp_vals)
        {
            $this->pay_url= "https://checkout.google.com/cws/v2/Merchant/".$pp_vals['googlecheckout_id']."/checkout";
            if ($this->demo_mode == 1)
                $this->pay_url= "https://checkout.google.com/cws/v2/Merchant/".$pp_vals['googlecheckout_id']."/checkout/diagnose";

            $this->_POST1 = array ();
            $this->_POST1['item_number'] = time().rand(0, 1000);
            if (isset ($_POST['force_inv_no']))
            {
                $this->_POST1['item_number'] = $_POST['force_inv_no'];
            }
            $str = '<?xml version="1.0" encoding="UTF-8" ?>
            <checkout-shopping-cart xmlns="http://checkout.google.com/schema/2">
            <shopping-cart>
            <items>
            <item>
            <item-name>'.$_POST['desc'].'</item-name>
            <item-description />
            <quantity>1</quantity>
            <unit-price currency="USD">'.number_format($_POST['gross_amount'],2).'</unit-price>
            </item>
            </items>
            <merchant-private-data>
            <merchant-note>'.$this->_POST1['item_number'].'</merchant-note>
            </merchant-private-data>
            </shopping-cart>
            <checkout-flow-support>
            <merchant-checkout-flow-support />
            </checkout-flow-support>
            </checkout-shopping-cart>';

            $this->_POST1['cart'] = base64_encode($str);
            $hashhmac = hash_hmac('sha1', $str, $pp_vals['googlecheckout_key'], TRUE);
            $this->_POST1['signature']= base64_encode($hashhmac);
        }
        /*
        * IPN=Internet Payment Notifier
        */
        function ipn(& $BL)
        {
            return false;
        }
    }
?>
