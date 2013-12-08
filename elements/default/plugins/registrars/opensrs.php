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

    $opensrs_fields = array (
        array ("login"    , "0",""),
        array ("password" , "1",""),
        array ("lock_domain"   , "0",array("1"=>"Yes","0"=>"No")),
        array ("whois_privacy" , "0",array("1"=>"Yes","0"=>"No")),
        array ("mode"     , "0",array("test"=>"TEST MODE","live"=>"LIVE MODE")),
        array ("active"   , "0",array("no"=>"No","yes"=>"Yes"))
    );
    if(isset($process_domain) && $process_domain == true){
        $_GET   = $this->REQUEST;
        $_POST  = $this->REQUEST;
        $name   = $this->REQUEST['name'];
        $address= $this->REQUEST['address'];
        $city   = $this->REQUEST['city'];
        $zip    = $this->REQUEST['zip'];
        $state  = $this->REQUEST['state'];
        $country= $this->REQUEST['country'];
        $email  = $this->REQUEST['email'];
        $fax    = $this->REQUEST['telephone'];
        $phone  = $this->REQUEST['telephone'];
        $domain = $this->REQUEST['domain'];
        $NS1    = $this->REQUEST['ns1'];
        $NS2    = $this->REQUEST['ns2'];
        $sub_id = $this->REQUEST['sub_id'];
        $dom_user=$this->REQUEST['dom_user'];
        $dom_pass=$this->REQUEST['dom_pass'];
        $r_ip   = $this->REQUEST['r_ip'];
        $years  = 1;
        if (!empty($this->REQUEST['dom_period']))
        {
            $years= $this->REQUEST['dom_period'];
        }
        if (empty($this->REQUEST['country']))
        {
            $country = 'US';
        }
        if (empty($this->REQUEST['dom_pass']))
        {
            $dom_pass = substr(md5(uniqid(rand())), 0, 10);
        }

        //split data\
        $name_array = explode(" ",$name,2);
        $first_name = $name_array[0];
        $last_name  = $name_array[1];
        if(empty($last_name))
        {
            $last_name = $first_name;
        }
        $phone   = preg_replace("/^\+1\./","",$phone);
        $phone   = preg_replace("/\D/","",$phone);
        $country_code=isset($this->props->phone_codes[$this->REQUEST['country']])?$this->props->phone_codes[$this->REQUEST['country']]:"1";
        if(empty($country_code))
        {
            $country_code = "1";
        }
        $phone      = "+".$country_code.".".$phone;
        if(empty($r_ip))
        {
            $r_ip   = $this->utils->realip();
        }
        //get open srs params
        $username     = $this->dr_vals['opensrs']['login'];
        $private_key  = $this->dr_vals['opensrs']['password'];
        $f_lock_domain = isset($this->dr_vals['opensrs']['lock_domain'])?$this->dr_vals['opensrs']['lock_domain']:1;
        $f_whois_privacy = isset($this->dr_vals['opensrs']['whois_privacy'])?$this->dr_vals['opensrs']['whois_privacy']:1;
        //construct xml
        $xml = '<?xml version=\'1.0\' encoding=\'UTF-8\' standalone=\'no\' ?>
        <!DOCTYPE OPS_envelope SYSTEM \'ops.dtd\'>
        <OPS_envelope>
        <header>
        <version>0.9</version>
        </header>
        <body>
        <data_block>
        <dt_assoc>
        <item key=\'object\'>DOMAIN</item>
        <item key=\'attributes\'>
        <dt_assoc>
        <item key=\'auto_renew\'>N</item>
        <item key=\'link_domains\'>0</item>
        <item key=\'reg_domain\'></item>
        <item key=\'f_lock_domain\'>'.$f_lock_domain.'</item>
        <item key=\'f_whois_privacy\'>'.$f_whois_privacy.'</item>
        <item key=\'f_parkp\'>N</item>
        <item key=\'domain\'>'.$domain.'</item>
        <item key=\'affiliate_id\'></item>
        <item key=\'period\'>'.$years.'</item>
        <item key=\'reg_type\'>new</item>
        <item key=\'reg_username\'>'.$dom_user.'</item>
        <item key=\'custom_tech_contact\'>0</item>
        <item key=\'contact_set\'>
        <dt_assoc>
        <item key=\'admin\'>
        <dt_assoc>
        <item key=\'state\'>'.$state.'</item>
        <item key=\'first_name\'>'.$first_name.'</item>
        <item key=\'country\'>'.$country.'</item>
        <item key=\'address1\'>'.$address.'</item>
        <item key=\'last_name\'>'.$last_name.'</item>
        <item key=\'address2\'></item>
        <item key=\'address3\'></item>
        <item key=\'postal_code\'>'.$zip.'</item>
        <item key=\'fax\'></item>
        <item key=\'city\'>'.$city.'</item>
        <item key=\'phone\'>'.$phone.'</item>
        <item key=\'email\'>'.$email.'</item>
        <item key=\'org_name\'>'.$domain.'</item>
        </dt_assoc>
        </item>
        <item key=\'billing\'>
        <dt_assoc>
        <item key=\'state\'>'.$state.'</item>
        <item key=\'first_name\'>'.$first_name.'</item>
        <item key=\'country\'>'.$country.'</item>
        <item key=\'address1\'>'.$address.'</item>
        <item key=\'last_name\'>'.$last_name.'</item>
        <item key=\'address2\'></item>
        <item key=\'address3\'></item>
        <item key=\'postal_code\'>'.$zip.'</item>
        <item key=\'fax\'></item>
        <item key=\'city\'>'.$city.'</item>
        <item key=\'phone\'>'.$phone.'</item>
        <item key=\'email\'>'.$email.'</item>
        <item key=\'org_name\'>'.$domain.'</item>
        </dt_assoc>
        </item>
        <item key=\'owner\'>
        <dt_assoc>
        <item key=\'state\'>'.$state.'</item>
        <item key=\'first_name\'>'.$first_name.'</item>
        <item key=\'country\'>'.$country.'</item>
        <item key=\'address1\'>'.$address.'</item>
        <item key=\'last_name\'>'.$last_name.'</item>
        <item key=\'address2\'></item>
        <item key=\'address3\'></item>
        <item key=\'postal_code\'>'.$zip.'</item>
        <item key=\'fax\'></item>
        <item key=\'city\'>'.$city.'</item>
        <item key=\'phone\'>'.$phone.'</item>
        <item key=\'email\'>'.$email.'</item>
        <item key=\'org_name\'>'.$domain.'</item>
        </dt_assoc>
        </item>
        </dt_assoc>
        </item>
        <item key=\'nameserver_list\'>
        <dt_array>
        <item key=\'0\'>
        <dt_assoc>
        <item key=\'sortorder\'>1</item>
        <item key=\'name\'>'.$NS1.'</item>
        </dt_assoc>
        </item>
        <item key=\'1\'>
        <dt_assoc>
        <item key=\'sortorder\'>2</item>
        <item key=\'name\'>'.$NS2.'</item>
        </dt_assoc>
        </item>
        </dt_array>
        </item>
        <item key=\'reg_password\'>'.$dom_pass.'</item>
        <item key=\'encoding_type\'></item>
        <item key=\'custom_nameservers\'>1</item>
        </dt_assoc>
        </item>
        <item key=\'registrant_ip\'>'.$r_ip.'</item>
        <item key=\'protocol\'>XCP</item>
        <item key=\'action\'>SW_REGISTER</item>
        </dt_assoc>
        </data_block>
        </body>
        </OPS_envelope>';

        //send xml
        $signature  = md5(md5($xml.$private_key).$private_key);
        $host       = ($this->dr_vals['opensrs']['mode']=="live")?"rr-n1-tor.opensrs.net":"horizon.opensrs.net";
        $port       = 55443;
        $url        = "/";
        $header     = "";
        $header    .= "POST $url HTTP/1.0\r\n";
        $header    .= "Content-Type: text/xml\r\n";
        $header    .= "X-Username: " . $username . "\r\n";
        $header    .= "X-Signature: " . $signature . "\r\n";
        $header    .= "Content-Length: " . strlen($xml) . "\r\n\r\n";
        # ssl:// requires OpenSSL to be installed
        $fp         = fsockopen ("ssl://$host", $port, $errno, $errstr, 30);
        if (!$fp)
        {
            $response_text= $errno."=>".$errstr;
        }
        else
        {
            # post the data to the server
            $result  = "";
            fputs ($fp, $header . $xml);
            while (!feof($fp))
                $result .= fgets ($fp, 1024);
            fclose ($fp);
        }
        $response_text = "";

        $id            = "";
        $result = str_replace("\r"," ", $result);
        $result = str_replace("\n"," ", $result);
        if (preg_match("|<item key=\"response_text\">(.*?)</item>|", $result, $out))
        {
            $response_text = $out[1];
        }
        if (preg_match("|<item key=\"id\">(.*?)</item>|", $result, $out))
        {
            $id = $out[1];
        }
        $time   = date('Y-m-d H:i:s');
        $result1= $response_text." : ".$id;
        $this->dom_reg_logs->insert(array("log_time"=>$time,"sub_id"=>$sub_id,"domain"=>$domain,"log_result"=>$result1));

        if (empty($id))
        {
            $registration_result = $this->props->lang['dom_reg_fail']."<br />".$response_text;
        }
        else
        {
            $this->orders->update(array("sub_id"=>$sub_id,"dom_reg_comp"=>1, "dom_reg_result"=>$id, "dom_registrar"=>"opensrs"));
            $order = $this->orders->getByKey($sub_id);
            if ($order['dom_reg_comp'] == '1')
            {
                $registration_result = $this->props->lang['dom_reg_success'].$order['dom_reg_result'];
            }
            else
            {
                $registration_result = $this->props->lang['dom_reg_fail']."<br />".$response_text."<br />".$order['dom_reg_result'];
            }
        }
    }
?>
