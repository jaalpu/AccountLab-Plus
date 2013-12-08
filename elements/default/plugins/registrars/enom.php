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

    $enom_fields = array (
        array ("login"    , "0",""),
        array ("password" , "1",""),
        array ("mode"     , "0",array("test_http"=>"TEST MODE (HTTP)","test_https"=>"TEST MODE (HTTPS)","live_http"=>"LIVE MODE (HTTP)","live_https"=>"LIVE MODE (HTTPS)")),
        array ("active"   , "0",array("no"=>"No","yes"=>"Yes"))
    );
    if(isset($process_domain) && $process_domain == true){
        $_GET   = $this->REQUEST;
        $_POST  = $this->REQUEST;
        $user   = $this->REQUEST['user'];
        $name   = $this->REQUEST['name'];
        $dom1   = $this->REQUEST['domain'];
        $City   = $this->REQUEST['city'];
        $fax    = $this->REQUEST['telephone'];
        $phone  = $this->REQUEST['telephone'];
        $zip    = $this->REQUEST['zip'];
        $state  = $this->REQUEST['state'];
        $Address1= $this->REQUEST['address'];
        $NS1    = $this->REQUEST['ns1'];
        $NS2    = $this->REQUEST['ns2'];
        $sub_id = $this->REQUEST['sub_id'];
        $RegistrantOrganizationName = $this->REQUEST['domain'];
        $RegistrantCountry          = $this->REQUEST['country'];
        $RegistrantEmailAddress     = $this->REQUEST['email'];
        $RegistrantAddress1         = str_replace(" ", "%20", $Address1);
        $RegistrantCity             = str_replace(" ", "%20", $City);
        $RegistrantPostalCode       = str_replace(" ", "%20", $zip);
        $RegistrantStateProvince    = str_replace(" ", "%20", $state);
        $RegistrantPhone            = str_replace(" ", "", $phone);
        $RegistrantFax              = str_replace(" ", "", $fax);

        $uid    = $this->dr_vals['enom']['login'];
        $pw     = $this->dr_vals['enom']['password'];
        $array_d= explode('.', $dom1, 2);
        $dom    = $array_d[0];
        $tld    = $array_d[1];
        $array_a= explode(' ', $name, 2);
        $RegistrantFirstName    = $array_a[0];
        $RegistrantLastName     = $array_a[1];
        $ResponseType           = "HTML";
        $RegistrantNexus        = "C11/us";
        $RegistrantPurpose  = "P1";
        $EmailNotify        = 1;
        $UnLockRegistrar    = 0;
        $Renewname  = 0;
        $ukowner    = "IND";
        $years      = 1;
        if (!empty($this->REQUEST['dom_period']))
        {
            $years  = $this->REQUEST['dom_period'];
        }
        if ($this->dr_vals['enom']['mode'] == "test_https")
        {
            $ch = curl_init("https://resellertest.enom.com/interface.asp?command=purchase&uid=$uid&pw=$pw&sld=$dom&tld=$tld&ResponseType=$ResponseType&RegistrantNexus=$RegistrantNexus&RegistrantPurpose=$RegistrantPurpose&RegistrantAddress1=$RegistrantAddress1&EmailNotify=$EmailNotify&RegistrantCity=$RegistrantCity&RegistrantCountry=$RegistrantCountry&RegistrantEmailAddress=$RegistrantEmailAddress&RegistrantFax=$RegistrantFax&RegistrantFirstName=$RegistrantFirstName&RegistrantLastName=$RegistrantLastName&RegistrantOrganizationName=$RegistrantOrganizationName&RegistrantPhone=$RegistrantPhone&RegistrantPostalCode=$RegistrantPostalCode&RegistrantStateProvince=$RegistrantStateProvince&UnLockRegistrar=$UnLockRegistrar&Renewname=$Renewname&uk_legal_type=$ukowner&registered_for=$RegistrantFirstName%20$RegistrantLastName&NumYears=$years&UseDNS=default");
        }
        elseif ($this->dr_vals['enom']['mode'] == "test_http")
        {
            $ch = curl_init("http://resellertest.enom.com/interface.asp?command=purchase&uid=$uid&pw=$pw&sld=$dom&tld=$tld&ResponseType=$ResponseType&RegistrantNexus=$RegistrantNexus&RegistrantPurpose=$RegistrantPurpose&RegistrantAddress1=$RegistrantAddress1&EmailNotify=$EmailNotify&RegistrantCity=$RegistrantCity&RegistrantCountry=$RegistrantCountry&RegistrantEmailAddress=$RegistrantEmailAddress&RegistrantFax=$RegistrantFax&RegistrantFirstName=$RegistrantFirstName&RegistrantLastName=$RegistrantLastName&RegistrantOrganizationName=$RegistrantOrganizationName&RegistrantPhone=$RegistrantPhone&RegistrantPostalCode=$RegistrantPostalCode&RegistrantStateProvince=$RegistrantStateProvince&UnLockRegistrar=$UnLockRegistrar&Renewname=$Renewname&uk_legal_type=$ukowner&registered_for=$RegistrantFirstName%20$RegistrantLastName&NumYears=$years&UseDNS=default");
        }
        elseif($this->dr_vals['enom']['mode'] == "live_http")
        {
            $ch = curl_init("http://reseller.enom.com/interface.asp?command=purchase&uid=$uid&pw=$pw&sld=$dom&tld=$tld&ResponseType=$ResponseType&RegistrantNexus=$RegistrantNexus&RegistrantPurpose=$RegistrantPurpose&RegistrantAddress1=$RegistrantAddress1&EmailNotify=$EmailNotify&RegistrantCity=$RegistrantCity&RegistrantCountry=$RegistrantCountry&RegistrantEmailAddress=$RegistrantEmailAddress&RegistrantFax=$RegistrantFax&RegistrantFirstName=$RegistrantFirstName&RegistrantLastName=$RegistrantLastName&RegistrantOrganizationName=$RegistrantOrganizationName&RegistrantPhone=$RegistrantPhone&RegistrantPostalCode=$RegistrantPostalCode&RegistrantStateProvince=$RegistrantStateProvince&UnLockRegistrar=$UnLockRegistrar&Renewname=$Renewname&uk_legal_type=$ukowner&registered_for=$RegistrantFirstName%20$RegistrantLastName&NumYears=$years&NS1=$NS1&NS2=$NS2");
        }
        else
        {
            $ch = curl_init("https://reseller.enom.com/interface.asp?command=purchase&uid=$uid&pw=$pw&sld=$dom&tld=$tld&ResponseType=$ResponseType&RegistrantNexus=$RegistrantNexus&RegistrantPurpose=$RegistrantPurpose&RegistrantAddress1=$RegistrantAddress1&EmailNotify=$EmailNotify&RegistrantCity=$RegistrantCity&RegistrantCountry=$RegistrantCountry&RegistrantEmailAddress=$RegistrantEmailAddress&RegistrantFax=$RegistrantFax&RegistrantFirstName=$RegistrantFirstName&RegistrantLastName=$RegistrantLastName&RegistrantOrganizationName=$RegistrantOrganizationName&RegistrantPhone=$RegistrantPhone&RegistrantPostalCode=$RegistrantPostalCode&RegistrantStateProvince=$RegistrantStateProvince&UnLockRegistrar=$UnLockRegistrar&Renewname=$Renewname&uk_legal_type=$ukowner&registered_for=$RegistrantFirstName%20$RegistrantLastName&NumYears=$years&NS1=$NS1&NS2=$NS2");
        }
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        preg_match("/<STRONG>OrderID: <\/STRONG>[0-9]+/", $result, $reg_array);
        $oid    = $reg_array[0];
        $time   = date('Y-m-d H:i:s');
        $domain = $this->REQUEST['domain'];
        $this->dom_reg_logs->insert(array("log_time"=>$time,"sub_id"=>$sub_id,"domain"=>$domain,"log_result"=>$this->utils->onlyStr($result)));

        if (empty($oid))
        {
            $registration_result = $this->props->lang['dom_reg_fail'].$result;
        }
        else
        {
            $oid   = str_replace("<STRONG>OrderID: </STRONG>", "", $oid);
            $this->orders->update(array("sub_id"=>$sub_id,"dom_reg_comp"=>1, "dom_reg_result"=>$oid, "dom_registrar"=>"enom"));
            $order = $this->orders->getByKey($this->REQUEST['sub_id']);
            if ($order['dom_reg_comp'] == '1')
            {
                $registration_result = $this->props->lang['dom_reg_success'].$order[0]['dom_reg_result'];
            }
            else
            {
                $registration_result = $this->props->lang['dom_reg_fail'].$order[0]['dom_reg_result'];
            }
        }
    }
?>
