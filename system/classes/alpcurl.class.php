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

    class alpcurl
    {
        var $getHeaders= true; //headers will be added to output
        var $getContent= true; //contens will be added to output
        var $followRedirects= true; //should the class go to another URL, if the current is "HTTP/1.1 302 Moved Temporarily"
        var $fCookieFile;
        var $fSocket;
        function alpcurl()
        {
            $this->fCookieFile= tempnam("/tmp", "g_");
        }
        function init()
        {
            return $this->fSocket= curl_init();
        }
        function setopt($opt, $value)
        {
            return curl_setopt($this->fSocket, $opt, $value);
        }
        function load_defaults()
        {
            $this->setopt(CURLOPT_RETURNTRANSFER, 1);
            $this->setopt(CURLOPT_FOLLOWLOCATION, $this->followRedirects);
            $this->setopt(CURLOPT_REFERER, "http://google.com");
            $this->setopt(CURLOPT_VERBOSE, false);
            $this->setopt(CURLOPT_SSL_VERIFYPEER, false);
            $this->setopt(CURLOPT_SSL_VERIFYHOST, false);
            $this->setopt(CURLOPT_HEADER, $this->getHeaders);
            $this->setopt(CURLOPT_NOBODY, !$this->getContent);
            $this->setopt(CURLOPT_COOKIEJAR, $this->fCookieFile);
            $this->setopt(CURLOPT_COOKIEFILE, $this->fCookieFile);
            $this->setopt(CURLOPT_USERAGENT, "AccountLab Plus");
            $this->setopt(CURLOPT_POST, 1);
            $this->setopt(CURLOPT_CUSTOMREQUEST, 'POST');
            $fp= fopen(LOGS."error_log.txt", "a");
            if ($fp)
                $this->setopt(CURLOPT_STDERR, $fp);
        }
        function destroy()
        {
            return curl_close($this->fSocket);
        }
        function head($url)
        {
            $this->init();
            if ($this->fSocket)
            {
                $this->getHeaders= true;
                $this->getContent= false;
                $this->load_defaults();
                $this->setopt(CURLOPT_POST, 0);
                $this->setopt(CURLOPT_CUSTOMREQUEST, 'HEAD');
                $this->setopt(CURLOPT_URL, $url);
                $result= curl_exec($this->fSocket);
                $this->destroy();
                return $result;
            }
            return 0;
        }
        function get($url)
        {
            $this->init();
            if ($this->fSocket)
            {
                $this->load_defaults();
                $this->setopt(CURLOPT_POST, 0);
                $this->setopt(CURLOPT_CUSTOMREQUEST, 'GET');
                $this->setopt(CURLOPT_URL, $url);
                $result= curl_exec($this->fSocket);
                $this->destroy();
                return $result;
            }
            return 0;
        }
        function post($url, $post_data, $arr_headers= array (), & $http_code)
        {
            $this->init();
            if ($this->fSocket)
            {
                $post_data= $this->compile_post_data($post_data);
                $this->load_defaults();
                if (!empty ($post_data))
                    $this->setopt(CURLOPT_POSTFIELDS, $post_data);
                if (!empty ($arr_headers))
                    $this->setopt(CURLOPT_HTTPHEADER, $arr_headers);
                $this->setopt(CURLOPT_URL, $url);
                $result= curl_exec($this->fSocket);
                $http_code= curl_getinfo($this->fSocket, CURLINFO_HTTP_CODE);
                $this->destroy();
                return $result;
            }
            return 0;
        }
        function compile_post_data($post_data)
        {
            $o= "";
            if (!empty ($post_data))
                foreach ($post_data as $k => $v)
                    $o .= $k . "=" . urlencode($v) . "&";
            return substr($o, 0, -1);
        }
        function get_parsed($result, $bef, $aft= "")
        {
            $line= 1;
            $len= strlen($bef);
            $pos_bef= strpos($result, $bef);
            if ($pos_bef === false)
                return "";
            $pos_bef += $len;
            if (empty ($aft))
            { //try to search up to the end of line
                $pos_aft= strpos($result, "\n", $pos_bef);
                if ($pos_aft === false)
                    $pos_aft= strpos($result, "\r\n", $pos_bef);
            }
            else
                $pos_aft= strpos($result, $aft, $pos_bef);
            if ($pos_aft !== false)
                $rez= substr($result, $pos_bef, $pos_aft - $pos_bef);
            else
                $rez= substr($result, $pos_bef);
            return $rez;
        }
    }
?>
