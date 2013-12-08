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
    * A class to do all plesk handling
    * pleskHandler Version 2.0
    */
    class pleskHandler
    {
        /*
        * Constructor
        */
        function pleskHandler()
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

            $this->plesk_server     = "";
            $this->plesk_port       = 8443;
            $this->plesk_user       = "";
            $this->plesk_password   = "";
            $this->plesk_hash       = "";
            $this->proto            = "http://";
            $this->usessl           = 0;

            $this->limits           = array();

            $this->permissions      = array();
            $this->permissions['create_domains'] = "";
            $this->permissions['manage_phosting'] = "";
            $this->permissions['manage_quota'] = "";
            $this->permissions['manage_subdomains'] = "";
            $this->permissions['manage_not_chroot_shell'] = "";
            $this->permissions['change_limits'] = "";
            $this->permissions['manage_dns'] = "";
            $this->permissions['manage_log'] = "";
            $this->permissions['manage_crontab'] = "";
            $this->permissions['manage_anonftp'] = "";
            $this->permissions['manage_webapps'] = "";
            $this->permissions['manage_sh_access'] = "";
            $this->permissions['manage_maillists'] = "";
            $this->permissions['manage_drweb'] = "";
            $this->permissions['make_dumps'] = "";
            $this->permissions['site_builder'] = "";

            $this->order_data    = array();
        }
        /*
        * Kill plesk Account
        */
        function kill_plesk_account()
        {
            $login  = $this->order_data['dom_user'];
            $data=<<<EOF
<packet version="1.3.4.0">
<client>
<del>
<filter>
<login>$login</login>
</filter>
</del>
</client>
</packet>
EOF;
            $contents     = $this->plesk_request($data);
            $return       = $this->anaRes($contents);
            if($this->error)
            {
                $result['response'] = $this->error;
                $result['result']   = 0;
            }
            else
            {
                $result['response'] = "OK";
                $result['result']   = 1;
                $this->error  = false;
            }
            $this->result = $result;
            return $this->result;
        }
        /*
        * Suspend plesk Account
        */
        function suspend_plesk_account()
        {
            $id  = $this->order_data['plesk_id'];
            $data=<<<EOF
<packet version="1.3.4.0">
<client>
<set>
<filter>
<id>$id</id>
</filter>
<values>
<gen_info>
<status>16</status>
</gen_info>
</values>
</set>
</client>
</packet>
EOF;
            $contents     = $this->plesk_request($data);
            $return       = $this->anaRes($contents);
            if($this->error)
            {
                $result['response'] = $this->error;
                $result['result']   = 0;
            }
            else
            {
                $result['response'] = "OK";
                $result['result']   = 1;
                $this->error  = false;
            }
            $this->result = $result;
            return $this->result;
        }
        /*
        * Un-Suspend plesk Account
        */
        function unsuspend_plesk_account()
        {
            $id  = $this->order_data['plesk_id'];
            $data=<<<EOF
<packet version="1.3.4.0">
<client>
<set>
<filter>
<id>$id</id>
</filter>
<values>
<gen_info>
<status>0</status>
</gen_info>
</values>
</set>
</client>
</packet>
EOF;
            $contents     = $this->plesk_request($data);
            $return       = $this->anaRes($contents);
            if($this->error)
            {
                $result['response'] = $this->error;
                $result['result']   = 0;
            }
            else
            {
                $result['response'] = "OK";
                $result['result']   = 1;
                $this->error  = false;
            }
            $this->result = $result;
            return $this->result;
        }
        /*
        * Analize response
        */
        function anaRes($contents,$ext_tag="")
        {
            preg_match_all("|<[^>]+>(.*)</[^>]+>|U", $contents, $out, PREG_PATTERN_ORDER);
            $return['status']      = null;
            $return['id']          = null;
            $return['error_code'] = null;
            $return['error_text'] = null;
            $ext                    = array();
            foreach ($out[0] as $k => $v)
            {
                //echo strip_tags($v)."\n\r";
                if (preg_match("/status/", $v))
                {
                    $v1= str_replace("<status>", "", $v);
                    $v1= str_replace("</status>", "", $v1);
                    $return['status'] = strip_tags($v1);
                }
                if (preg_match("/id/", $v))
                {
                    $v1= str_replace("<id>", "", $v);
                    $v1= str_replace("</id>", "", $v1);
                    $return['id'] = strip_tags($v1);
                }
                if (preg_match("/errcode/", $v))
                {
                    $v1= str_replace("<errcode>", "", $v);
                    $v1= str_replace("</errcode>", "", $v1);
                    $return['error_code'] = strip_tags($v1);
                }
                if (preg_match("/errtext/", $v))
                {
                    $v1= str_replace("<errtext>", "", $v);
                    $v1= str_replace("</errtext>", "", $v1);
                    $return['error_text'] = strip_tags($v1);
                }
                if(!empty($ext_tag) && preg_match("|$ext_tag|", $v))
                {
                    $v1= str_replace("<".$ext_tag.">", "", $v);
                    $v1= str_replace("</".$ext_tag.">", "", $v1);
                    $ext[strip_tags($v1)] = strip_tags($v1);
                }
            }
            if(!empty($return['error_code']))
                $this->error = $return['error_text'];
            $return[$ext_tag] = $ext;
            return $return;
        }
        /*
        * Create plesk Account
        */
        function create_plesk_account()
        {
            $name   = $this->order_data['name'];
            $login  = $this->order_data['dom_user'];
            $passwd = $this->order_data['dom_pass'];
            $phone  = $this->order_data['telephone'];
            $email  = $this->order_data['email'];
            $address= $this->order_data['address'];
            $city   = $this->order_data['city'];
            $zip    = $this->order_data['zip'];
            $country= $this->order_data['country'];
            $domain = $this->order_data['domain_name'];

            foreach($this->permissions as $k=>$v)
            {
                $t="false";
                if($v=="1")$t="true";
                ${$k} = $t;
            }
            $expiration     = "";
            $max_webapps    = "";
            $max_maillists  = $this->limits['maxlst'];
            $max_resp       = "";
            $max_mg         = "";
            $max_redir      = "";
            $mbox_quota     = "";
            $max_box        = $this->limits['maxpop'];
            $max_db         = $this->limits['maxsql'];
            $max_wu         = "";
            $max_traffic    = ($this->limits['bwlimit']*1024)*1024;
            $disk_space     = ($this->limits['quota']*1024)*1024;
            $max_subdom     = $this->limits['maxsub'];
            $max_dom        = $this->limits['maxftp'];
            $fp             = $this->limits['frontpage'];
            $shell          = $this->limits['hasshell'];
            $cgi            = $this->limits['cgi'];

            $data=<<<EOF
<packet version="1.3.4.0">
<client>
<add>
<gen_info>
<cname>$name ($login)</cname>
<pname>$name ($domain)</pname>
<login>$login</login>
<passwd>$passwd</passwd>
<status>0</status>
<phone>$phone</phone>
<fax></fax>
<email>$email</email>
<address>$address</address>
<city>$city</city>
<state>$state</state>
<pcode>$zip</pcode>
<country>$country</country>
<locale></locale>
</gen_info>
</add>
</client>
</packet>
EOF;
            $contents = $this->plesk_request($data);
            $return   = $this->anaRes($contents);
            $plesk_id = $return['id'];
            if(!empty($plesk_id))
            {
                //set limits
                $data=<<<EOF
<packet version="1.3.4.0">
<client>
<set>
<filter><id>$plesk_id</id></filter>
<values>
<limits>
<expiration>$expiration</expiration>
<max_webapps>$max_webapps</max_webapps>
<max_maillists>$max_maillists</max_maillists>
<max_resp>$max_resp</max_resp>
<max_mg>$max_mg</max_mg>
<max_redir>$max_redir</max_redir>
<mbox_quota>$mbox_quota</mbox_quota>
<max_box>$max_box</max_box>
<max_db>$max_db</max_db>
<max_wu>$max_wu</max_wu>
<max_traffic>$max_traffic</max_traffic>
<disk_space>$disk_space</disk_space>
<max_subdom>$max_subdom</max_subdom>
<max_dom>$max_dom</max_dom>
</limits>
</values>
</set>
</client>
</packet>
EOF;
                $contents = $this->plesk_request($data);
                $return   = $this->anaRes($contents);
                //set permissions
                $data=<<<EOF
<packet version="1.3.4.0">
<client>
<set>
<filter><id>$plesk_id</id></filter>
<values>
<permissions>
<create_domains>$create_domains</create_domains>
<manage_phosting>$manage_phosting</manage_phosting>
<manage_quota>$manage_quota</manage_quota>
<manage_subdomains>$manage_subdomains</manage_subdomains>
<manage_not_chroot_shell>$manage_not_chroot_shell</manage_not_chroot_shell>
<change_limits>$change_limits</change_limits>
<manage_dns>$manage_dns</manage_dns>
<manage_log>$manage_log</manage_log>
<manage_crontab>$manage_crontab</manage_crontab>
<manage_anonftp>$manage_anonftp</manage_anonftp>
<manage_webapps>$manage_webapps</manage_webapps>
<manage_sh_access>$manage_sh_access</manage_sh_access>
<manage_maillists>$manage_maillists</manage_maillists>
<manage_drweb>$manage_drweb</manage_drweb>
<make_dumps>$make_dumps</make_dumps>
<site_builder>$site_builder</site_builder>
</permissions>
</values>
</set>
</client>
</packet>
EOF;
                $contents = $this->plesk_request($data);
                $return   = $this->anaRes($contents);
                //get ips
                $data=<<<EOF
<packet version="1.3.4.0">
<ip>
<get/>
</ip>
</packet>
EOF;
                $contents = $this->plesk_request($data);
                $return   = $this->anaRes($contents,'ip_address');
                $ips      = array();
                foreach($return['ip_address'] as $v)
                    $ips[]=$v;
                $continue = true;
                foreach($ips as $ip)   {
                    if($continue){
                        //add ip to pool
                        $data=<<<EOF
<packet version="1.3.4.0">
<client>
<ippool_add_ip>
<client_id>$plesk_id</client_id>
<ip_address>$ip</ip_address>
</ippool_add_ip>
</client>
</packet>
EOF;
                        $contents = $this->plesk_request($data);
                        $temp   = $this->anaRes($contents);
                        if($temp['status']=="error")  {
                            $continue = true;
                        }else{
                            $this->error = false;
                            $return = $temp;
                            $ip_address = $ip;
                            $continue = false;
                        }
                    }
                }

                //set domain
                $data=<<<EOF
<packet version="1.3.4.0">
<domain>
<add>
<gen_setup>
<name>$domain</name>
<client_id>$plesk_id</client_id>
<ip_address>$ip_address</ip_address>
<status>0</status>
<htype>vrt_hst</htype>
</gen_setup>
<hosting>
<vrt_hst>
<ftp_login>$login</ftp_login>
<ftp_password>$passwd</ftp_password>
<fp>$fp</fp>
<fp_ssl></fp_ssl>
<fp_auth></fp_auth>
<fp_admin_login>$login</fp_admin_login>
<fp_admin_password>$passwd</fp_admin_password>
<ssl></ssl>
<shell>$shell</shell>
<php></php>
<ssi></ssi>
<cgi>$cgi</cgi>
<mod_perl></mod_perl>
<mod_python></mod_python>
<asp></asp>
<asp_dot_net></asp_dot_net>
<coldfusion></coldfusion>
<webstat></webstat>
<errdocs></errdocs>
<at_domains></at_domains>
<ip_address>$ip_address</ip_address>
</vrt_hst>
</hosting>
</add>
</domain>
</packet>
EOF;
                $contents = $this->plesk_request($data);
                $return   = $this->anaRes($contents);
                $result['ip_address'] = $ip_address;
            }
            $result['ip_address'] = $ip_address;
            if($this->error || !$plesk_id)
            {
                $result['response'] = $this->error;
                $result['result']   = 0;
            }
            else
            {
                $result['response'] = "OK";
                $result['result']   = 1;
                $result['plesk_id'] = $plesk_id;
                $this->error  = false;
            }
            $this->result = $result;
            return $result;
        }
        /*
        * List plesk accounts
        */
        function list_plesk_accounts()
        {
            $data=<<<EOF
<packet version="1.3.4.0">
<client>
<get>
<filter/>
<dataset>
<gen_info/>
</dataset>
</get>
</client>
</packet>
EOF;
            $contents     = $this->plesk_request($data);
            $return       = $this->anaRes($contents,"login");
            $accounts     = $return['login'];
            $this->result = $accounts;
            return $this->result;
        }
        /*
        * Create plesk Package
        */
        function create_plesk_package($submit="Create")
        {
            $this->error  = "not supported by plesk";
            $this->result = "not supported by plesk";
            return $this->result;
        }
        /*
        * List plesk Packages
        */
        function list_plesk_packages()
        {
            $this->error  = "not supported by plesk";
            $this->result = "not supported by plesk";
            return $this->result;
        }
        /*
        * Make request
        */
        function plesk_request($request)
        {
            //echo $request."<br />\n\r";
            $Temporary  = '<?'.'xml version="1.0" encoding="UTF-8" standalone="no" '.'?>';
            $data       = $Temporary.$request;
            $HOST       = $this->plesk_server;
            $PORT       = $this->plesk_port;
            $PATH       = "enterprise/control/agent.php";
            $LOGIN      = $this->plesk_user;
            $PASSWD     = $this->plesk_password;
            $url        = "https://".$HOST.":".$PORT."/".$PATH;
            $headers    = array ("HTTP_AUTH_LOGIN: ".$LOGIN, "HTTP_AUTH_PASSWD: ".$PASSWD, "HTTP_PRETTY_PRINT: TRUE", "Content-Type: text/xml",);
            if (function_exists("curl_init"))
            {
                $ch     = curl_init();
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_URL, $url);
                $cb     = $this->write_callback($ch, $data);
                curl_setopt($ch, CURLOPT_WRITEFUNCTION, $cb);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_VERBOSE, 1);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $this->result = curl_exec($ch);
            }
            else
            {
                $this->error  = "php not compiled with curl";
            }
            return $this->result;
        }
        /*
        * Call back
        */
        function write_callback($ch, $data)
        {
            return strlen($data);
        }
    }
?>
