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
    * whois Version 2.0
    */
    class whois_controller extends controller
    {
        function checkDomain($name, $ext)
        {
            $name = $this->utils->quoteSmart($name);
            $ext = $this->utils->quoteSmart($ext);
            $serverArray  = $this->getServerArray($ext, 0);
            $SERVER       = $serverArray['server'];
            $NOMATCH      = $serverArray['nomatch'];
            $Response     = "";
            if (!$this->utils->chkDomainFormat($name.".".$ext) || !is_array($serverArray))
            {
                return $this->props->parseLang('err_domain');
            }
            if (stristr($SERVER, '%') === FALSE && stristr($SERVER, '[') === FALSE)
            {
                if (($sc= fsockopen($SERVER, 43)) == TRUE)
                {
                    fputs($sc, $name.".".$ext."\r\n");
                }
                else
                {
                    $Response= "error";
                }
                while (!feof($sc))
                {
                    $Response .= fgets($sc, 1024);
                }
                fclose ($sc) ;
            }
            elseif(stristr($SERVER, '%') === FALSE)
            {
                $SERVER  = str_replace("[domain]", urlencode($name.'.'.$ext), $SERVER);
                $SERVER  = str_replace("[domainName]", urlencode($name), $SERVER);
                $SERVER  = str_replace("[domainExt]", urlencode($ext), $SERVER);
                $handle = fopen($SERVER, "rb");
                if($handle===FALSE)
                {
                    $Response = "error";
                }
                else
                {
                    $Response = '';
                    while (!feof($handle)) {
                        $Response .= fread($handle, 8192);
                    }
                }
                fclose($handle);
            }
            else
            {
                $SERVER  = str_replace("%domain%", urlencode($name.'.'.$ext), $SERVER);
                $SERVER  = str_replace("%domainName%", urlencode($name), $SERVER);
                $SERVER  = str_replace("%domainExt%", urlencode($ext), $SERVER);
                $temp    =array();
                $temp    = explode("?", $SERVER);
                $POSTString= $temp[1];
                $url     = $temp[0];
                if (!$Connection= curl_init($url))
                {
                    $Response= "error";
                }
                curl_setopt($Connection, CURLOPT_URL, $url);
                curl_setopt($Connection, CURLOPT_USERAGENT, 'AccountLab Plus');
                curl_setopt($Connection, CURLOPT_POST, 1);
                curl_setopt($Connection, CURLOPT_POSTFIELDS, $POSTString);
                curl_setopt($Connection, CURLOPT_RETURNTRANSFER, 1);
                $Response    = curl_exec($Connection);
                curl_close($Connection);
            }
            if ($Response == "error")
            {
                return $this->props->parseLang('err_whois');
            }
            if(preg_match('"/[!]/"',$NOMATCH))
            {
                $NOMATCH = str_replace("[!]","",$NOMATCH);
                return preg_match("/$NOMATCH/", $Response)?1:0;
            }
            return preg_match("/$NOMATCH/", $Response)?0:1;
        }
        function getServerArray($ext, $from_list= 1)
        {
            if ($from_list == 1)
            {
                $temp                    = $this->props->tld_array[$ext];
                $serverArray['server']   = $temp['server'];
                $serverArray['nomatch']  = $temp['nomatch'];
            }
            else
            {
                $sqlSELECT               = "SELECT * FROM `tlds` WHERE `dom_ext` = '$ext'";
                $temp                    = $this->dbL->executeSELECT($sqlSELECT);
                $serverArray['server']   = $temp[0]['tld_server'];
                $serverArray['nomatch']  = $temp[0]['tld_match'];
            }
            if (count($temp))
            {
                return $serverArray;
            }
            return false;
        }
    }
?>
