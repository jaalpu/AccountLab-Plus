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
    * A class to do all cpanel handling
    * cpanelHandler Version 2.0
    */
    class cpanelHandler
    {
        /*
        * Constructor
        */
        function cpanelHandler()
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

            $this->whm_server   = "";
            $this->whm_port     = "";
            $this->whm_user     = "";
            $this->whm_password = "";
            $this->whm_hash     = "";
            $this->proto        = "http://";
            $this->usessl       = 0;

            $this->package_data = array();
            $this->package_data['name'] = "";
            $this->package_data['quota'] = 0;
            $this->package_data['hasshell'] = 0;
            $this->package_data['maxftp'] = "unlimited";
            $this->package_data['maxpop'] = "unlimited";
            $this->package_data['maxlst'] = "unlimited";
            $this->package_data['maxsql'] = "unlimited";
            $this->package_data['maxsub'] = "unlimited";
            $this->package_data['maxpark'] = "unlimited";
            $this->package_data['maxaddon'] = "unlimited";
            $this->package_data['ip'] = 0;
            $this->package_data['cgi'] = 0;
            $this->package_data['frontpage'] = 0;
            $this->package_data['bwlimit'] = "unlimited";
            $this->package_data['cpmod'] = "x";
            $this->package_data['featurelist'] = "default";

            $this->order_data['username'] = "";
            $this->order_data['password'] = "";
            $this->order_data['domain'] = "";
            $this->order_data['contactemail'] = "";
            $this->order_data['reseller'] = "";
            $this->order_data['ownerself'] = "";

            $this->limits_fields = array ();
            $this->limits_fields['limit_type'] = "";
            $this->limits_fields['resnumlimitamt'] = "";
            $this->limits_fields['rslimit_disk'] = "";
            $this->limits_fields['rsolimit_disk'] = "";
            $this->limits_fields['rslimit_bw'] = "";
            $this->limits_fields['rsolimit_bw'] = "";
            $this->limits_fields['edit_ns'] = "";

            $this->acl_fields = array ();
            $this->acl_fields['acl_allow_unlimited_disk_pkgs'] = "";
            $this->acl_fields['acl_allow_unlimited_pkgs'] = "";
            $this->acl_fields['acl_edit_pkg'] = "";
            $this->acl_fields['acl_create_acct'] = "";
            $this->acl_fields['acl_edit_account'] = "";
            $this->acl_fields['acl_suspend_acct'] = "";
            $this->acl_fields['acl_kill_acct'] = "";
            $this->acl_fields['acl_upgrade_account'] = "";
            $this->acl_fields['acl_create_dns'] = "";
            $this->acl_fields['acl_add_pkg'] = "";
            $this->acl_fields['acl_all'] = "";
            $this->acl_fields['acl_add_pkg_shell'] = "";
            $this->acl_fields['acl_add_pkg_ip'] = "";
            $this->acl_fields['acl_allow_addoncreate'] = "";
            $this->acl_fields['acl_allow_parkedcreate'] = "";
            $this->acl_fields['acl_limit_bandwidth'] = "";
            $this->acl_fields['acl_clustering'] = "";
            $this->acl_fields['acl_kill_dns'] = "";
            $this->acl_fields['acl_onlyselfandglobalpkgs'] = "";
            $this->acl_fields['acl_edit_dns'] = "";
            $this->acl_fields['acl_edit_mx'] = "";
            $this->acl_fields['acl_frontpage'] = "";
            $this->acl_fields['acl_ssl'] = "";
            $this->acl_fields['acl_mod_subdomains'] = "";
            $this->acl_fields['acl_list_accts'] = "";
            $this->acl_fields['acl_mailcheck'] = "";
            $this->acl_fields['acl_disallow_shell'] = "";
            $this->acl_fields['acl_news'] = "";
            $this->acl_fields['acl_park_dns'] = "";
            $this->acl_fields['acl_passwd'] = "";
            $this->acl_fields['acl_quota'] = "";
            $this->acl_fields['acl_rearrange_accts'] = "";
            $this->acl_fields['acl_res_cart'] = "";
            $this->acl_fields['acl_restart'] = "";
            $this->acl_fields['acl_resftp'] = "";
            $this->acl_fields['acl_demo_setup'] = "";
            $this->acl_fields['acl_show_bandwidth'] = "";
            $this->acl_fields['acl_stats'] = "";
            $this->acl_fields['acl_status'] = "";
        }
        /*
        * Kill WHM Account
        */
        function kill_whm_account()
        {
            $string  = "";
            $string .= "domain=" . urlencode($this->order_data['username']) . "&";
            $string .= "user=" . urlencode($this->order_data['username']) . "&";
            $string .= "Terminate=submit-user";

            if (!empty ($this->whm_password))
            {
                $whm_url  = $this->proto . $this->whm_user . ":" . $this->whm_password . "@" . $this->whm_server . ":" . $this->whm_port . "/scripts/killacct?" . $string;
                ob_start();
                $response = file_get_contents($whm_url,FALSE,NULL,0,99999);
                ob_end_clean();
            }
            elseif (!empty ($whm_hash))
            {
                $response = $this->whm_request("/scripts/killacct?" . $string);
            }

            $nnpos                    = strpos($response, "<pre>");
            $this->result['response'] = strip_tags(substr($response, $nnpos));

            $this->result['result'] = 0;
            if (strpos($this->result['response'], "Removing") !== false && strpos($this->result['response'], "Cleaning") !== false)
            {
                $this->result['result'] = 1;
            }
            else
            {
                $nnpos                    = strpos($response, $this->order_data['username']);
                $this->result['response'] = strip_tags(substr($response, $nnpos));
            }
            return $this->result;
        }
        /*
        * Suspend WHM Account
        */
        function suspend_whm_account()
        {
            $string  = "";
            $string .= "domain=" . $this->order_data['username'] . "&";
            $string .= "user=" . $this->order_data['username'] . "&";
            $string .= "disallowun=1&suspend-domain=Suspend&suspend-user=Suspend&reason=Suspended From AccountLab Plus";
            if (!empty ($this->whm_password))
            {
                $whm_url  = $this->proto . $this->whm_user . ":" . $this->whm_password . "@" . $this->whm_server . ":" . $this->whm_port . "/scripts2/suspendacct?" . $string;
                ob_start();
                $response = file_get_contents($whm_url,FALSE,NULL,0,99999);
                ob_end_clean();
            }
            elseif (!empty ($whm_hash))
            {
                $response = $this->whm_request("/scripts/remote_suspend?" . $string);
            }

            $nnpos                    = strpos($response, "<pre>");
            $this->result['response'] = strip_tags(substr($response, $nnpos));

            $this->result['result'] = 0;
            if (strpos($this->result['response'], "suspended") !== false && strpos($this->result['response'], "Locking") !== false)
            {
                $this->result['result'] = 1;
            }
            else
            {
                $nnpos                    = strpos($response, $this->order_data['username']);
                $this->result['response'] = strip_tags(substr($response, $nnpos));
            }
            return $this->result;
        }
        /*
        * Un-Suspend WHM Account
        */
        function unsuspend_whm_account()
        {
            $string  = "";
            $string .= "domain=" . $this->order_data['username'] . "&";
            $string .= "user=" . $this->order_data['username'] . "&";
            $string .= "unsuspend-domain=UnSuspend&unsuspend-user=UnSuspend";
            if (!empty ($this->whm_password))
            {
                $whm_url  = $this->proto . $this->whm_user . ":" . $this->whm_password . "@" . $this->whm_server . ":" . $this->whm_port . "/scripts2/suspendacct?" . $string;
                ob_start();
                $response = file_get_contents($whm_url,FALSE,NULL,0,99999);
                ob_end_clean();
            }
            elseif (!empty ($whm_hash))
            {
                $response = $this->whm_request("/scripts/remote_unsuspend?" . $string);
            }

            $nnpos                    = strpos($response, "<pre>");
            $this->result['response'] = strip_tags(substr($response, $nnpos));

            $this->result['result'] = 0;
            if (strpos($this->result['response'], "active") !== false && strpos($this->result['response'], "Unlocking") !== false)
            {
                $this->result['result'] = 1;
            }
            else
            {
                $nnpos                    = strpos($response, $this->order_data['username']);
                $this->result['response'] = strip_tags(substr($response, $nnpos));
            }
            return $this->result;
        }
        /*
        * Create WHM Account
        */
        function create_whm_account()
        {
            $string  = "nohtml=1&";
            foreach($this->package_data as $k=>$v)
                $string .= $k . "=" . $v . "&";
            foreach($this->order_data as $k=>$v)
                $string .= $k . "=" . $v . "&";
            // ip,cgi,quota,frontpage,cp,maxftp,maxsql,maxpop,maxlst,maxsub,bwlimit,hasshell,maxpark,maxaddon,plan
            /*$pack = $this->package_data['ip'].",".$this->package_data['cgi'].",".$this->package_data['quota'].",".$this->package_data['frontpage'].",".$this->package_data['cpmod'].",".$this->package_data['maxftp'].",".$this->package_data['maxsql'].",".$this->package_data['maxpop'].",".$this->package_data['maxlst'].",".$this->package_data['maxsub'].",".$this->package_data['bwlimit'].",".$this->package_data['hasshell'].",".$this->package_data['maxpark'].",".$this->package_data['maxaddon'].",".$this->package_data['name'];
            $string .= "msel=" . $pack;*/
            $string .= "plan=" . $this->package_data['name'];
            if (!empty ($this->whm_password))
            {
                $whm_url  = $this->proto . $this->whm_user . ":" . $this->whm_password . "@" . $this->whm_server . ":" . $this->whm_port . "/scripts/wwwacct?" . $string;
                ob_start();
                $response = file_get_contents($whm_url,FALSE,NULL,0,99999);
                ob_end_clean();
            }
            elseif (!empty ($whm_hash))
            {
                $response = $this->whm_request("/scripts/wwwacct?" . $string);
            }
            $nnpos                  = strpos($response, "\n\n");
            $creation_result_string = strip_tags(substr($response, $nnpos));
            $creation_result        = 0;

            if(trim($creation_result_string)==''){
                $creation_result_string = $response;
            }

            if (strpos($creation_result_string, "New Account Info") !== false && strpos($creation_result_string, "Sorry") === false)
                $creation_result = 1;

            $whm_result['response']   = $creation_result_string;
            $whm_result['result']     = $creation_result;

            $num="(25[0-5]|2[0-4]\d|[01]?\d\d|\d)";
            preg_match_all("/$num\\.$num\\.$num\\.$num/",$whm_result['response'],$ip_match);
            $whm_result['ip_address'] = isset($ip_match[0][0])?$ip_match[0][0]:"";

            if($creation_result==1 && $this->order_data['reseller']==1)
            {
                //change ownership
                $string  = "nohtml=1&user=" . $this->order_data['username'] . "&";
                $string .= "owner=" . $this->whm_user;
                if (!empty ($this->whm_password))
                {
                    $whm_url  = $this->proto . $this->whm_user . ":" . $this->whm_password . "@" . $this->whm_server . ":" . $this->whm_port . "/scripts/dochangeowner?" . $string;
                    ob_start();
                    $response = file_get_contents($whm_url,FALSE,NULL,0,99999);
                    ob_end_clean();
                }
                elseif (!empty ($whm_hash))
                {
                    $response = $this->whm_request("/scripts/dochangeowner?remote=1&" . $string);
                }

                $nnpos                  = strpos($response, "\n\n");
                $whm_result['response'].= strip_tags(substr($response, $nnpos));

                //assign reseller permission
                $string  = "nohtml=1&res=" . $this->order_data['username'] . "&";
                $string .= "submit=ok";
                if (!empty ($this->whm_password))
                {
                    $whm_url  = $this->proto . $this->whm_user . ":" . $this->whm_password . "@" . $this->whm_server . ":" . $this->whm_port . "/scripts/addres?" . $string;
                    ob_start();
                    $response = file_get_contents($whm_url,FALSE,NULL,0,99999);
                    ob_end_clean();
                }
                elseif (!empty ($whm_hash))
                {
                    $response = $this->whm_request("/scripts/addres?remote=1&" . $string);
                }

                $nnpos                  = strpos($response, "\n\n");
                $whm_result['response'].= strip_tags(substr($response, $nnpos));

                //change reseller priviledges
                $limit_type = "";
                if($this->limits_fields['limit_type']==1)
                {
                    $limit_type = "resnumlimit=1&";
                    $this->limits_fields['resreslimit'] = "";
                    $this->limits_fields['rslimit_disk'] = "";
                    $this->limits_fields['rsolimit_disk'] = "";
                    $this->limits_fields['rslimit_bw'] = "";
                    $this->limits_fields['rsolimit_bw'] = "";
                }
                elseif($this->limits_fields['limit_type']==2)
                {
                    $this->limits_fields['resnumlimit'] = "";
                    $this->limits_fields['resnumlimitamt'] = "";
                    $limit_type = "resreslimit=1&";
                }
                $limits = "";
                foreach($this->limits_fields as $k=>$v)
                    if($v!="" && $k!="limit_type")
                        $limits .= str_replace("_","-",$k) . "=" .$v . "&";
                    $priviledges = "";
                foreach($this->acl_fields as $k=>$v)
                    if($v!="")
                        $priviledges .= str_replace("_","-",$k) . "=" .$v . "&";

                    $string = "nohtml=1&".$limit_type . $limits . $priviledges . "res=" . $this->order_data['username'] . "&submit=Save";
                $string .= "&ns1=" . $this->order_data['ns1'];
                $string .= "&ns2=" . $this->order_data['ns2'];
                if (!empty ($this->whm_password))
                {
                    $whm_url  = $this->proto . $this->whm_user . ":" . $this->whm_password . "@" . $this->whm_server . ":" . $this->whm_port . "/scripts2/editressv?" . $string;
                    ob_start();
                    $response = file_get_contents($whm_url,FALSE,NULL,0,99999);
                    ob_end_clean();
                }
                elseif (!empty ($whm_hash))
                {
                    $response = $this->whm_request("/scripts2/editressv?" . $string);
                }

                $nnpos                  = strpos($response, "\n\n");
                $whm_result['response'].= strip_tags(substr($response, $nnpos));


                //delegate ip
                $string  = "nohtml=1&user=" . $this->order_data['username'] . "&";
                $string  = "mainip=" . $whm_result['ip_address'] . "&";
                $string .= "submit=Save";
                if (!empty ($this->whm_password))
                {
                    $whm_url  = $this->proto . $this->whm_user . ":" . $this->whm_password . "@" . $this->whm_server . ":" . $this->whm_port . "/scripts2/dodelegatemainip?" . $string;
                    ob_start();
                    $response = file_get_contents($whm_url,FALSE,NULL,0,99999);
                    ob_end_clean();
                }
                elseif (!empty ($whm_hash))
                {
                    $response = $this->whm_request("/scripts2/dodelegatemainip?remote=1&nohtml=1&" . $string);
                }

                $nnpos                  = strpos($response, "\n\n");
                $whm_result['response'].= strip_tags(substr($response, $nnpos));


            }
            $this->result = $whm_result;
            return $whm_result;
        }
        /*
        * List WHM accounts
        */
        function list_whm_accounts()
        {
            if (!empty ($this->whm_password))
            {
                $whm_url  = $this->proto . $this->whm_user . ":" . $this->whm_password . "@" . $this->whm_server . ":" . $this->whm_port . "/scripts2/listaccts?nohtml=1&viewall=1";
                ob_start();
                $response = file_get_contents($whm_url,FALSE,NULL,0,99999);
                ob_end_clean();
            }
            elseif (!empty ($whm_hash))
            {
                $response = $this->whm_request("/scripts2/listaccts?nohtml=1&viewall=1");
            }
            //echo $whm_url."<br />".$response;
            $page = split("\n",strip_tags($response));
            foreach ($page as $line)
            {
                @list($acct,$contents) = @split("=", $line);
                if ($acct != "")
                {
                    $allc = split(",", $contents);
                    $accts[$acct] = $allc;
                }
            }
            $this->result = $accts;
            return $this->result;
        }
        /*
        * Create WHM Package
        */
        function create_whm_package($submit="Create")
        {
            $string  = "nohtml=1&";
            foreach($this->package_data as $k=>$v)
                $string .= $k . "=" . $v . "&";
            if (!empty ($this->whm_password))
            {
                $whm_url  = $this->proto . $this->whm_user . ":" . $this->whm_password . "@" . $this->whm_server . ":" . $this->whm_port . "/scripts2/addpkg?submit=" . $submit . "&" . $string;
                ob_start();
                $response = file_get_contents($whm_url,FALSE,NULL,0,99999);
                ob_end_clean();
            }
            elseif (!empty ($whm_hash))
            {
                $response = $this->whm_request("/scripts2/addpkg?submit=" . $submit . "&" . $string);
            }

            $nnpos        = strpos($response, "\n\n");
            $this->result = strip_tags(substr($response, $nnpos));

            return $this->result;
        }
        /*
        * List WHM Packages
        */
        function list_whm_packages()
        {
            if (!empty ($this->whm_password))
            {
                $whm_url  = $this->proto . $this->whm_user . ":" . $this->whm_password . "@" . $this->whm_server . ":" . $this->whm_port . "/scripts/listeditpkgs?nohtml=1";
                ob_start();
                $response = file_get_contents($whm_url,FALSE,NULL,0,99999);
                ob_end_clean();
            }
            elseif (!empty ($whm_hash))
            {
                $response = $this->whm_request("/scripts/listeditpkgs?nohtml=1");
            }
            $html_array     = explode("\n", $response);
            $option_array   = '';
            for ($i= 0; $i < sizeof($html_array); $i++)
            {
                if (strpos($html_array[$i], "<option") !== false)
                    $option_array[] = strip_tags($html_array[$i]);
            }
            $this->result = $option_array;
            return $this->result;
        }
        /*
        * Make request
        */
        function whm_request($request)
        {
            $cpanelaccterr    = false;
            $cleanaccesshash  = preg_replace("'(\r|\n)'", "", $this->whm_hash);
            $authstr          = $this->whm_user . ":" . $cleanaccesshash;
            $url              = $this->proto . $this->whm_server . ":" . $this->whm_port . $request;

            if (function_exists("curl_init"))
            {
                $curlheaders[0] = "Authorization: WHM $authstr";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $curlheaders);
                $data = curl_exec($ch);
                curl_close($ch);
            }
            elseif (function_exists("socket_create"))
            {
                if ($this->usessl == 1)
                {
                    $cpanelaccterr  = "SSL Support requires curl";
                    $this->error    = $cpanelaccterr;
                    return null;
                }
                $service_port    = $this->whm_port;
                $address         = gethostbyname($this->whm_server);
                $socket          = socket_create(AF_INET, SOCK_STREAM, 0);
                if ($socket < 0)
                {
                    $cpanelaccterr  = "socket_create() failed";
                    $this->error    = $cpanelaccterr;
                    return null;
                }
                $result  = socket_connect($socket, $address, $service_port);
                if ($result < 0)
                {
                    $cpanelaccterr  = "socket_connect() failed";
                    $this->error    = $cpanelaccterr;
                    return null;
                }
                $in      = "GET $request HTTP/1.0\n";
                socket_write($socket, $in, strlen($in));
                $in      = "Connection: close\n";
                socket_write($socket, $in, strlen($in));
                $in      = "Authorization: WHM $authstr\n\n\n";
                socket_write($socket, $in, strlen($in));
                $inheader= 1;

                while (($buf= socket_read($socket, 512)) != false)
                {
                    if (!$inheader)
                    {
                        $data    .= $buf;
                    }
                    if (preg_match("'\r\n\r\n$'s", $buf))
                    {
                        $inheader = 0;
                    }
                    if (preg_match("'\n\n$'s", $buf))
                    {
                        $inheader = 0;
                    }
                }
            }
            else
            {
                $cpanelaccterr  = "php not compiled with --enable-sockets OR curl";
                $this->error    = $cpanelaccterr;
                return null;
            }
            $this->error  = $cpanelaccterr;
            $this->result = $data;
            return $data;
        }
    }
?>
