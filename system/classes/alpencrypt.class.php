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

    /*
    * Class to do 2way encryption of any string
    * alpencrypt.php Version 2.0
    */
    class alpencrypt
    {
        /*
        * Constructor of the class
        */
        function alpencrypt()
        {
            //Do nothing just create an object
        }
        /*
        * Function to encrypt
        */
        function encrypt($string, $key)
        {
            $ch="";
            $chx="";
            $key= md5($key);
            $string= base64_encode($string);
            $x= 0;
            for ($i= 0; $i < strlen($string); $i ++)
            {
                if ($x == strlen($key))
                {
                    $x= 0;
                }
                $ch .= substr($key, $x, 1);
                $x ++;
            }
            for ($i= 0; $i < strlen($string); $i ++)
            {
                $chx .= chr(ord(substr($string, $i, 1)) + (ord(substr($ch, $i, 1))) % 256);
            }
            return $chx;
        }
        /*
        * Function to de-crypt
        */
        function decrypt($string, $key)
        {
            $ch="";
            $chx="";
            $key= md5($key);
            $x= 0;
            for ($i= 0; $i < strlen($string); $i ++)
            {
                if ($x == strlen($key))
                {
                    $x= 0;
                }
                $ch .= substr($key, $x, 1);
                $x ++;
            }
            for ($i= 0; $i < strlen($string); $i ++)
            {
                if (ord(substr($string, $i, 1)) < ord(substr($ch, $i, 1)))
                {
                    $chx .= chr((ord(substr($string, $i, 1)) + 256) - ord(substr($ch, $i, 1)));
                }
                else
                {
                    $chx .= chr(ord(substr($string, $i, 1)) - ord(substr($ch, $i, 1)));
                }
            }
            return base64_decode($chx);
        }
    }
?>
