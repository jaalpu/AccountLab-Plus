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
    * A class to do all da handling
    * daHandler Version 2.0
    */
    class daHandler
    {
        /*
        * Constructor
        */
        function daHandler()
        {
            $this->initFields();
        }
        /*
        * Instantiate fields
        */
        function initFields()
        {
            $this->error = false;
            $this->result= null;
            $this->limits        = array();
            $this->permissions   = array();
            $this->order_data    = array();
        }
        function suspend($host, $user, $accesshash, $usessl, $suspenduser)
        {
            $request= "/CMD_SELECT_USERS?suspend=Suspend&select0=".$suspenduser;
            $method= 'GET'; // GET or POST
            $post_content= "";
            $port= 2222;
            $retval= $this->DA_SSL_Request($user, $accesshash, $request, $method, $post_content, $host, $port, $usessl);
            if(!$this->error && !preg_match("/error/",$retval))
            {
                $result['result']   = 1;
                $result['response'] = "Suspended";
            }
            else
            {
                $result['result']   = 0;
                $result['response'] = "ERROR OCCURRED!";
            }
            if($this->error)
                $result['response'] = $retval;
            $this->result = $result;
            return $result;
        }
        function unsuspend($host, $user, $accesshash, $usessl, $suspenduser)
        {
            $request= "/CMD_SELECT_USERS?suspend=Unsuspend&select0=".$suspenduser;
            $method= 'GET'; // GET or POST
            $post_content= "";
            $port= 2222;
            $retval= $this->DA_SSL_Request($user, $accesshash, $request, $method, $post_content, $host, $port,$usessl);
            if(!$this->error && !preg_match("/error/i",$retval))
            {
                $result['result']   = 1;
                $result['response'] = "Activated";
            }
            else
            {
                $result['result']   = 0;
                $result['response'] = "ERROR OCCURRED!";
            }
            if($this->error)
                $result['response'] = $retval;
            $this->result = $result;
            return $result;
        }
        function killacct($host, $user, $accesshash, $usessl, $killuser)
        {
            $request= "/CMD_SELECT_USERS?confirmed=Confirm&delete=yes&select0=".$killuser;
            $method= 'GET'; // GET or POST
            $post_content= "";
            $port= 2222;
            $retval= $this->DA_SSL_Request($user, $accesshash, $request, $method, $post_content, $host, $port,$usessl);
            if(!$this->error && preg_match("/Remove/i",$retval))
            {
                $result['result']   = 1;
            }
            else
            {
                $result['result']   = 0;
            }
            $result['response'] = $this->parseResult($retval);
            if($this->error)
                $result['response'] = $retval;
            $this->result = $result;
            return $result;
        }
        function createacct($host, $user, $accesshash, $usessl, $acctdomain, $acctuser, $acctpass, $acctplan)
        {
            $email      = $this->order_data['email'];
            $method     = 'POST'; // GET or POST
            $port       = 2222;
            $ips        = $this->getIP($host, $user, $accesshash, $usessl);
            $ip         = $ips[0];
            if(empty($ip))
                $ip     = $host;
            if($user=="admin" && $this->limits['da_reseller']==3)
            {
                $request    = "/CMD_ACCOUNT_ADMIN";
                $post_content= "username=$acctuser&email=$email&passwd=$acctpass&passwd2=$acctpass&notify=yes&add=Submit&action=create";
            }
            elseif($this->limits['da_reseller']==2)
            {
                $request    = "/CMD_ACCOUNT_RESELLER";
                $post_content= "username=$acctuser&email=$email&passwd=$acctpass&passwd2=$acctpass&domain=$acctdomain&package=$acctplan&ip=$ip&notify=yes&add=Submit&action=create";
            }
            elseif($this->limits['da_reseller']==1)
            {
                $request    = "/CMD_ACCOUNT_USER";
                $post_content= "username=$acctuser&email=$email&passwd=$acctpass&passwd2=$acctpass&domain=$acctdomain&package=$acctplan&ip=$ip&notify=yes&add=Submit&action=create";
            }
            $retval     = $this->DA_SSL_Request($user, $accesshash, $request, $method, $post_content, $host, $port, $usessl);
            if($this->error || preg_match("/cannot/i",$retval) || preg_match("/unable/i",$retval))
            {
                $result['result']   = 0;
            }
            else
            {
                $result['result']   = 1;
            }
            $result['response'] = $this->parseResult($retval);
            if($this->error)
                $result['response'] = $retval;
            $result['ip_address'] = $ip;
            $this->result = $result;
            return $result;
        }
        function getIP($host, $user, $accesshash, $usessl)
        {
            $output     = "";
            $request    = "/CMD_API_SHOW_RESELLER_IPS";
            $method     = 'GET'; // GET or POST
            $post_content= "";
            $port       = 2222;
            $answer     = $this->DA_SSL_Request($user, $accesshash, $request, $method, $post_content, $host, $port, $usessl);
            parse_str($answer, $output);
            if(is_array($output['list']) && count($output['list']))
                return $output['list'];
            return array();
        }
        function listpkgs($host, $user, $accesshash, $usessl)
        {
            $output     = "";
            $request    = "/CMD_API_PACKAGES_USER";
            $method     = 'GET'; // GET or POST
            $post_content= "";
            $port       = 2222;
            $answer     = $this->DA_SSL_Request($user, $accesshash, $request, $method, $post_content, $host, $port, $usessl);
            parse_str($answer, $output);
            if(is_array($output['list']) && count($output['list']))
                return $output['list'];
            return array();
        }
        function listaccts($host, $user, $accesshash, $usessl)
        {
            $output     = "";
            $request    = "/CMD_API_SHOW_USERS";
            if($user=="admin")
                $request= "/CMD_API_SHOW_ALL_USERS";
            $method     = 'GET'; // GET or POST
            $post_content= "reseller=".$user;
            $port       = 2222;
            $answer     = $this->DA_SSL_Request($user, $accesshash, $request, $method, $post_content, $host, $port, $usessl);
            parse_str($answer, $output);
            if(is_array($output['list']) && count($output['list']))
                return $output['list'];
            return array();
        }
        function DA_SSL_Request($user, $password, $request, $method= 'GET', $post_content= '', $host= 'localhost', $port= 2222,$usessl=1)
        {
            $authstr = base64_encode("$user:$password");
            $ch = curl_init();
            if ($usessl)
            {
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,0);
                curl_setopt($ch, CURLOPT_URL, "https://$host:$port".$request);
            }
            else
            {
                curl_setopt($ch, CURLOPT_URL, "http://$host:$port".$request);
            }
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_content);
            $curlheaders[0] = "Authorization: Basic $authstr";
            curl_setopt($ch,CURLOPT_HTTPHEADER,$curlheaders);
            $data=curl_exec ($ch);
            curl_close ($ch);
            $answer=$data;
            $this->error = false;
            if (empty($answer))
            {
                $this->error = true;
                $answer= "CONNECTION ERROR ".curl_errno($ch).": ".curl_error($ch);
            }
            return $answer;
        }
        function parseResult($str)
        {
            $str    = strip_tags($str,"<p>");
            $str    = str_replace("Details</p>","Details\n",$str);
            $s1     = strpos($str, "Details")+strlen("Details");
            $s2     = strpos($str, "</p>");
            $str    = substr($str, $s1, $s2-$s1);
            $s1     = strstr($str,"</p>");
            $str    = str_replace($s1,"</p>",$str);
            $s1     = stristr($str, "<p");
            $s2     = stristr($str, "</p>");
            $l      = strlen($s1) - strlen($s2);
            $result = "<p".substr($s1, strlen("<p"), $l)."</p>";
            return strip_tags($result);
        }
    }
?>
