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

    $name       = "clickbank";
    $clickbank  = array (
        array ("ClickBank ID"  , "cb_id"),
        array ("Secret Key"    , "cb_sk"),
        array ("Active"        , "active", "No", "Yes"),
        array ("Title"         , "title"),
        array ("Submit label"  , "submit_label")
    );
    $send_method= "GET";
    $pay        = new clickbank($demo_mode);
    /*
    * Class to do all clickbank
    * clickbank Version 1.0
    */
    class clickbank
    {
        /*
        * Constructor
        */
        function clickbank($demo_mode= 0)
        {
            $this->demo_mode  = $demo_mode;
            $this->pay_url    = "pay.clickbank.net";
        }
        /*
        * Function to send variables
        */
        function sendVariables($path_url, $pp_vals)
        {
            $this->pay_url    = "http://" . $_POST['product_id'] .".". $pp_vals['cb_id'] . "." . $this->pay_url;
            $this->_POST1     = array ();
            $this->_POST1['item_number'] = time() . rand(0, 1000);
            if (isset ($_POST['force_inv_no']))
            {
                $this->_POST1['item_number'] = $_POST['force_inv_no'];
            }
            $this->_POST1['name']     = $_POST['name'];
            $this->_POST1['amount']   = number_format($_POST['gross_amount'],2);
            $this->_POST1['email']    = $_POST['email'];
            $this->_POST1['country']  = $_POST['country'];
            $this->_POST1['zipcode']  = $_POST['zip'];
            $this->_POST1['detail']   = $_POST['desc'];
            $this->_POST1['gateway']  = 'clickbank';
            $this->_POST1['seed']     = $pp_vals['cb_id'] . $this->_POST1['item_number'] . "ALP";
        }
        /*
        * IPN=Internet Payment Notifier
        */
        function ipn(& $BL)
        {
            $sqlSELECT  = "SELECT  * FROM {$BL->props->tbl_payment_processors} WHERE `pp_name` ='proxypay'";
            $temp       = $BL->dbL->executeSELECT($sqlSELECT);
            $pp_vals    = $temp[0];

            $this->item_number      = $_POST['item_number'];
            $this->transaction_id   = $_POST['item_number'];
            $this->payment_status   = "OK";

            $seed         = $pp_vals['cb_sk'] . $this->item_number . "ALP";
            $cbpop        = $_POST['cbpop'];
            $secret_key   = $pp_vals['cb_sk'];
            if ($_POST['gateway'] == "clickbank" && !empty ($this->item_number) && !empty ($this->transaction_id) && $this->cbValid($seed, $cbpop, $secret_key))
            {
                $BL->invoices->processTransaction($this->item_number, $this->transaction_id);
                return true;
            }
            return false;
        }
        /*
        * Function CB Valid
        */
        function cbValid($seed, $cbpop, $secret_key)
        {
            if (!$seed)
                return 0;
            if (!$cbpop)
                return 0;
            $hh= 0x8000;
            $lh= 0x0000;
            $hl= 0x7fff;
            $ll= 0xffff;
            $charsmask= array (
                "0",
                "1",
                "2",
                "3",
                "4",
                "5",
                "6",
                "7",
                "8",
                "9",
                "B",
                "C",
                "D",
                "E",
                "F",
                "G",
                "H",
                "J",
                "K",
                "L",
                "M",
                "N",
                "P",
                "Q",
                "R",
                "S",
                "T",
                "V",
                "W",
                "X",
                "Y",
                "Z"
            );
            for ($i= 0; $i < 10; $i++)
                $q[$i]= "";
            $w= sprintf("%s  %s", $secret_key, $seed);
            $w= strtoupper($w);
            $v= unpack("C*", $w);
            $hx= 0;
            $lx= 17;
            $hy= 0;
            $ly= 17;
            $z= 17;
            $n= strlen($w);
            for ($i= 0; $i < 10; $i++)
                $s[$i]= 0;
            for ($i= 0; $i < 256; $i++)
            {
                $tmp1l= $lx & $ll;
                $tmp1h= $hx & $hl;
                $tmp2l= $ly & $ll;
                $tmp2h= $hy & $hl;
                $tmp3l= $tmp1l + $tmp2l;
                $correction= $tmp3l;
                $tmp3l= $tmp3l & 0x0000ffff;
                $correction= $correction - $tmp3l;
                $correction= $correction / pow(2, 16);
                $tmp3h= $tmp1h + $tmp2h;
                $tmp3h += $correction;
                $tmp3h= $tmp3h & 0x0000ffff;
                $tmp4l= $lx ^ $ly;
                $tmp4h= $hx ^ $hy;
                $tmp4l= $tmp4l & $lh;
                $tmp4h= $tmp4h & $hh;
                $wil= $tmp3l ^ $tmp4l;
                $wih= $tmp3h ^ $tmp4h;
                $tmp1l= $wil;
                $tmp1h= $wih;
                if ($z == 32)
                {
                    $tmpl1= 0;
                    $tmp1h= 0;
                }
                elseif ($z == 16)
                {
                    $tmp1h= $tmp1l;
                    $tmp1l= 0;
                }
                elseif ($z > 16)
                {
                    $shiftleft= $z -16;
                    $tmp1h= $tmp1l * pow(2, $shiftleft);
                    $tmp1h= $tmp1h & 0x0000ffff;
                    $tmp1l= 0;
                }
                else
                {
                    $tmp1l= $tmp1l * pow(2, $z);
                    $correction= $tmp1l;
                    $tmp1l= $tmp1l & 0x0000ffff;
                    $correction= $correction - $tmp1l;
                    $correction= $correction / pow(2, 16);
                    $tmp1h= $tmp1h * pow(2, $z);
                    $tmp1h += $correction;
                    $tmp1h= $tmp1h & 0x0000ffff;
                }
                $tmp2l= $wil;
                $tmp2h= $wih;
                $shiftvalue= 32 - $z;
                if ($shiftvalue == 32)
                {
                    $tmp2l= 0;
                    $tmp2h= 0;
                }
                elseif ($shiftvalue == 16)
                {
                    $tmp2l= $tmp2h;
                    $tmp2h= 0;
                }
                elseif ($shiftvalue > 16)
                {
                    $shiftright= $shiftvalue -16;
                    $tmp2l= $tmp2h >> $shiftright;
                    $tmp2h= 0;
                }
                else
                {
                    $tmp2l= ($tmp2l >> $shiftvalue);
                    $shiftright= $shiftvalue;
                    $bitmask= 1;
                    for ($j= 1; $j < $shiftright; $j++)
                        $bitmask= $bitmask * 2 + 1;
                    $correction= ($tmp2h & $bitmask) * pow(2, 16 - $shiftvalue);
                    $tmp2l += $correction;
                    $tmp2h= $tmp2h >> $shiftvalue;
                }
                $wil= ($tmp1l | $tmp2l);
                $wih= ($tmp1h | $tmp2h);
                $tmp1l= $wil & $ll;
                $tmp1h= $wih & $hl;
                $tmp1l= $tmp1l + $v[$i % $n +1];
                $correction= $tmp1l & 0x7fff0000;
                $correction= ($correction >> 16);
                $tmp1h += $correction;
                $tmp1l= $tmp1l & 0x0000ffff;
                $tmp2l= $wil & $lh;
                $tmp2h= $wih & $hh;
                $wil= $tmp1l ^ $tmp2l;
                $wih= $tmp1h ^ $tmp2h;
                $s[$i & 7] += $wil & 31;
                $z= $ly & 31;
                $ly= $lx;
                $hy= $hx;
                $lx= $wil;
                $hx= $wih;
            }
            for ($i= 0; $i < 8; $i++)
                $q[$i]= $charsmask[$s[$i] & 31];
            $q[8]= "\0";
            $finalstring= "";
            for ($i= 0; $i < 8; $i++)
                $finalstring .= $q[$i];
            if (!strcmp($cbpop, $finalstring))
                return 1;
            else
                return 0;
        }
    }
?>
