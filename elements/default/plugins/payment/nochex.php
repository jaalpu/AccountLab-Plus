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

    $name       = "NOCHEX";
    $nochex     = array (
        array ("Email"  , "nc_email"),
        array ("Active" , "active", "No", "Yes"),
        array ("Title"  , "title"),
        array ("Submit label", "submit_label")
    );
    $send_method= "GET";
    $pay        = new nochex($demo_mode);
    /*
    * Class to do all nochex
    * nochex Version 1.0
    */
    class nochex
    {
        /*
        * Constructor
        */
        function nochex($demo_mode= 0)
        {
            $this->demo_mode  = $demo_mode;
            $this->pay_url    = "https://www.nochex.com/nochex.dll/checkout";
        }
        /*
        * Function to send variables
        */
        function sendVariables($path_url, $pp_vals)
        {
            $this->_POST1                         = array ();
            $this->_POST1['email']                = $pp_vals['nc_email'];
            $this->_POST1['amount']               = number_format($_POST['gross_amount'],2);
            $this->_POST1['email_address_sender'] = $_POST['email'];
            $this->_POST1['description']          = $_POST['desc'];
            $this->_POST1['responderurl']         = $path_url."/ipn.php";
            $this->_POST1['returnurl']            = $path_url."/OK.php";
            $this->_POST1['item_number']          = time().rand(0, 1000);
            if (isset ($_POST['force_inv_no']))
            {
                $this->_POST1['item_number'] = $_POST['force_inv_no'];
            }
            $this->_POST1['ordernumber']          = $this->_POST1['item_number'];
        }
        /*
        * Function to post back
        */
        function postBack()
        {
            foreach ($_POST as $key => $value)
            {
                $value= urlencode(stripslashes($value));
                $req .= "&$key=$value";
            }
            $errno   = "";
            $errstr  = "";
            $header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
            $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
            $header .= "Content-Length: ".strlen($req)."\r\n\r\n";
            $fp      = fsockopen('https://www.nochex.com/nochex.dll/apc/apc', 80, $errno, $errstr, 30);
            if (!$fp)
            {
                // HTTP ERROR
            }
            else
            {
                fputs($fp, $header.$req);
                while (!feof($fp))
                {
                    $res = fgets($fp, 1024);
                    if (strcmp($res, "AUTHORISED") == 0)
                    {
                        return true;
                    }
                    else
                    {
                        if (strcmp($res, "DECLINED") == 0)
                        {
                            return false;
                        }
                    }
                }
                fclose($fp);
            }
        }
        /*
        * IPN=Internet Payment Notifier
        */
        function ipn(& $BL)
        {
            $this->item_number    = $_POST['ordernumber'];
            $this->transaction_id = $_POST['transaction_id'];
            $this->payment_status = "OK";
            if (!empty ($this->item_number) && $this->postBack())
            {
                $BL->invoices->processTransaction($this->item_number, $this->transaction_id);
                return true;
            }
            return false;
        }
    }
?>
