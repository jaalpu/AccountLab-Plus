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

    class geoip extends model
    {
        var $tableName= "geoip";
        function getRemoteCountry($IP)
        {
            $geoip = $this->hasAnyOne();
            if ($geoip['feed'] == 2 || $geoip['feed'] == 3)
            {
                $IP_Number = sprintf("%u", ip2long($IP));
                $sqlSELECT = "SELECT * FROM `geoip_db` WHERE `IP_FROM` <= '$IP_Number' and `IP_TO` >=  '$IP_Number'";
                $return    = $this->dbL->executeSELECT($sqlSELECT);
                if (count($return))
                {
                    return $return;
                }
            }
            elseif ($geoip['feed'] == 1)
            {
                $contents = "";
                $url = "http://api.hostip.info/?ip=" . $IP;
                foreach (file($url) as $k)
                {
                    $contents .= $k;
                }
                $temp1 = $this->utils->strInTag("HOSTIP", strtoupper($contents));
                $temp1 = $this->utils->htmlspecialchars_decode($temp1);
                $temp2 = $temp1;
                $temp1 = $this->utils->strInTag("COUNTRYABBREV", strtoupper($temp1));
                $temp3 = $this->utils->strInTag("GML:NAME", strtoupper($temp2));
                if (!empty ($temp1))
                {
                    $temp1         = str_replace("COUNTRYABBREV", "", strtoupper($temp1));
                    $COUNTRY_CODE2 = $temp1;
                }
                //if(!empty($temp3) && !ereg(")",$temp3))
                if (!empty ($temp3))
                {
                    $temp3 = str_replace("GML:NAME", "", strtoupper($temp3));
                    $CITY  = ucwords(strtolower($temp3));
                }
                $COUNTRY_CODE2 = str_replace("&gt;", "", $COUNTRY_CODE2);
                $COUNTRY_CODE2 = str_replace("&lt;", "", $COUNTRY_CODE2);
                $COUNTRY_CODE2 = str_replace("<", "", $COUNTRY_CODE2);
                $COUNTRY_CODE2 = str_replace(">", "", $COUNTRY_CODE2);
                $COUNTRY_CODE2 = str_replace("/", "", $COUNTRY_CODE2);
                $CITY = str_replace("&gt;", "", $CITY);
                $CITY = str_replace("&lt;", "", $CITY);
                $CITY = str_replace("<", "", $CITY);
                $CITY = str_replace(">", "", $CITY);
                $CITY = str_replace("/", "", $CITY);
                $return1 = array (
                    "COUNTRY_CODE2" => $COUNTRY_CODE2
                );
                $return2 = array (
                    "CITY" => $CITY
                );
                $return[0] = $return1;
                $return[1] = $return2;
                return $return;
            }
            else
            {
                $return1 = array (
                    "COUNTRY_CODE2" => "XX"
                );
                $return2 = array (
                    "CITY" => "(Unknown City)"
                );
                $return[0] = $return1;
                $return[1] = $return2;
                return $return;
            }
        }
    }
?>
