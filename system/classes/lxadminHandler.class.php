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
    * A class to do all lxadmin handling
    * lxadminHandler Version 2.0
    */
    class lxadminHandler
    {
        /*
        * Constructor
        */
        function lxadminHandler()
        {
            $this->initFields();
        }
        /*
        * Instantiate fields
        */
        function initFields()
        {
            $this->error= false;
            $this->result= null;
            $this->limits= array ();
            $this->permissions= array ();
            $this->order_data= array ();
        }
        function suspend($host, $user, $password, $usessl, $suspenduser)
        {
            if ($user == "admin")
                $result= $this->lxreq("login-class=client&action=update&subaction=disble&class=client&name=${suspenduser}", $host, $user, $password, $usessl);
            else
                $result= $this->lxreq("login-class=client&action=update&subaction=disble&class=client&name=${suspenduser}&parent-class=client&parent-name=${user}", $host, $user, $password, $usessl);
            $return['result'] = 0;
            $return['response'] = $result;
            if(preg_match("/__success_/i",$result))
            {
                $return['result'] = 1;
            }
            $return['response']=str_replace("__error_","<b>Error:</b> ",$return['response']);
            $return['response']=str_replace("__success_","<b>Success:</b> ",$return['response']);
            return $return;
        }
        function unsuspend($host, $user, $password, $usessl, $suspenduser)
        {
            if ($user == "admin")
                $result= $this->lxreq("login-class=client&action=update&subaction=enable&class=client&name=${suspenduser}", $host, $user, $password, $usessl);
            else
                $result= $this->lxreq("login-class=client&action=update&subaction=enable&class=client&name=${suspenduser}&parent-class=client&parent-name=${user}", $host, $user, $password, $usessl);
            $return['result'] = 0;
            $return['response'] = $result;
            if(preg_match("/__success_/i",$result))
            {
                $return['result'] = 1;
            }
            $return['response']=str_replace("__error_","<b>Error:</b> ",$return['response']);
            $return['response']=str_replace("__success_","<b>Success:</b> ",$return['response']);
            return $return;
        }
        function killacct($host, $user, $password, $usessl, $killuser)
        {
            if ($user == "admin")
                $result= $this->lxreq("login-class=client&action=delete&class=client&name=${killuser}", $host, $user, $password, $usessl);
            else
                $result= $this->lxreq("login-class=client&action=delete&class=client&name=${killuser}&parent-class=client&parent-name=${user}", $host, $user, $password, $usessl);
            $return['result'] = 0;
            $return['response'] = $result;
            if(preg_match("/__success_/i",$result))
            {
                $return['result'] = 1;
            }
            $return['response']=str_replace("__error_","<b>Error:</b> ",$return['response']);
            $return['response']=str_replace("__success_","<b>Success:</b> ",$return['response']);
            return $return;
        }
        function createacct($host, $user, $password, $usessl, $acctdomain, $acctuser, $acctpass, $acctplan)
        {
            $return['result']=0;
            $result= $this->createclient($host, $user, $password, $usessl, $acctdomain, $acctuser, $acctpass, $acctplan);
            $return['response']=str_replace("+"," ",$result);
            if(preg_match("/__error_/i",$result))
            {
                $return['response']=str_replace("__error_","<b>Error:</b> ",$return['response']);
                return $return;
            }
            $result = $this->lxreq("login-class=client&action=add&class=domain&name=${acctdomain}&v-template_name=${acctplan}&v-password=${acctpass}&parent-class=client&parent-name=${acctuser}", $host, $user, $password, $usessl);
            $return['response'] .= "<br />".str_replace("+"," ",$result);
            if(preg_match("/__success_/i",$result))
            {
                $return['response']=str_replace("__success_","<b>Success:</b> ",$return['response']);
                $return['result'] = 1;
                return $return;
            }
            $return['response']=str_replace("__error_","<b>Error:</b> ",$return['response']);
            $return['response']=str_replace("__success_","<b>Success:</b> ",$return['response']);
            return $return;
        }
        function createclient($host, $user, $password, $usessl, $acctdomain, $acctuser, $acctpass, $acctplan)
        {
            if ($user == "admin")
                $result= $this->lxreq("login-class=client&action=add&class=client&name=${acctuser}&v-template_name=${acctplan}&v-type=reseller&v-password=${acctpass}", $host, $user, $password, $usessl);
            else
                $result= $this->lxreq("login-class=client&action=add&class=client&name=${acctuser}&v-template_name=${acctplan}&v-type=reseller&v-password=${acctpass}&parent-class=client&parent-name=${user}", $host, $user, $password, $usessl);
            return $result;
        }
        function listdomains($host, $user, $password, $usessl)
        {
            if ($user == "admin")
                $result= $this->lxreq("login-class=client&action=simplelist&class=domain", $host, $user, $password, $usessl);
            else
                $result= $this->lxreq("login-class=client&action=simplelist&class=domain&parent-class=client&parent-name=${user}", $host, $user, $password, $usessl);
            $output= explode("&", $result);
            $return= array ();
            foreach ($output as $v)
                if (!empty ($v))
                {
                    $t= explode("=", $v);
                    $return[$t[1]]= $t[1];
                }
                return $return;
        }
        function listaccts($host, $user, $password, $usessl)
        {
            if ($user == "admin")
                $result= $this->lxreq("login-class=client&action=simplelist&class=client", $host, $user, $password, $usessl);
            else
                $result= $this->lxreq("login-class=client&action=simplelist&class=client&parent-class=client&parent-name=${user}", $host, $user, $password, $usessl);
            $output= explode("&", $result);
            $return= array ();
            foreach ($output as $v)
                if (!empty ($v))
                {
                    $t= explode("=", $v);
                    $return[$t[1]]= $t[1];
                }
                //print_r($return);
                return $return;
        }
        function listpkgs($host, $user, $password, $usessl)
        {
            if ($user == "admin")
                $result= $this->lxreq("login-class=client&action=simplelist&class=domaintemplate", $host, $user, $password, $usessl);
            else
                $result= $this->lxreq("login-class=client&action=simplelist&class=domaintemplate&parent-class=client&parent-name=${user}", $host, $user, $password, $usessl);
            $output= explode("&", $result);
            $return1= array ();
            foreach ($output as $v)
                if (!empty ($v))
                {
                    $t= explode("=", $v);
                    $return1[$t[1]]= $t[1];
                }
                $return2= $this->listcpkgs($host, $user, $password, $usessl);
            $return= array_intersect($return1, $return2);
            //print_r($return);
            return $return;
        }
        function listcpkgs($host, $user, $password, $usessl)
        {
            if ($user == "admin")
                $result= $this->lxreq("login-class=client&action=simplelist&class=clienttemplate", $host, $user, $password, $usessl);
            else
                $result= $this->lxreq("login-class=client&action=simplelist&class=clienttemplate&parent-class=client&parent-name=${user}", $host, $user, $password, $usessl);
            $output= explode("&", $result);
            $return= array ();
            foreach ($output as $v)
                if (!empty ($v))
                {
                    $t= explode("=", $v);
                    $return[$t[1]]= $t[1];
                }
                return $return;
        }
        function lxreq($request, $host, $user, $password, $usessl)
        {
            $ch= curl_init();
            if ($usessl)
            {
                $u= "https://${host}:7777/bin/webcommand.php?login-name=${user}&login-password=${password}&" . $request;
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_URL, $u);
            }
            else
            {
                $u= "http://${host}:7778/bin/webcommand.php?login-name=${user}&login-password=${password}&" . $request;
                curl_setopt($ch, CURLOPT_URL, $u);
            }
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $data= curl_exec($ch);
            curl_close($ch);
            return $data;
        }
    }
?>
