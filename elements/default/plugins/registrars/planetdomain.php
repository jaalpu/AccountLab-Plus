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

    $planetdomain_fields = array (
        array ("login"    , "0",""),
        array ("password" , "1",""),
        array ("reseller_id", "0",""),
        array ("mode"     , "0",array("test"=>"TEST MODE","live"=>"LIVE MODE")),
        array ("active"   , "0",array("no"=>"No","yes"=>"Yes"))
    );
    if(isset($process_domain) && $process_domain == true){
        $url = "https://test-www.planetdomain.com/servlet/TLDServlet";
        if($this->dr_vals['planetdomain']['mode']=="live"){
            $url = "https://www.planetdomain.com/servlet/TLDServlet";
        }
        //Add user
        $post = array();
        $post['operation'] = "user.add";
        $post['admin.username'] = $this->dr_vals['planetdomain']['login'];
        $post['admin.password'] = $this->dr_vals['planetdomain']['password'];
        $post['reseller.id'] = $this->dr_vals['planetdomain']['reseller_id'];
        $post['response.format'] = "XML";

        list($first_name,$last_name) = explode(" ",$this->REQUEST['name'],2);
        $post['user.firstname'] = $first_name;
        $post['user.lastname'] = $last_name;
        $post['user.address1'] = $this->REQUEST['address'];
        $post['user.suburb'] = $this->REQUEST['city'];
        $post['user.postcode'] = $this->REQUEST['zip'];
        $post['user.state'] = $this->REQUEST['state'];
        $post['user.country'] = $this->REQUEST['country'];
        $post['user.phone'] = $this->REQUEST['telephone'];
        $post['user.email'] = $this->REQUEST['email'];
        $post['user.username'] = $this->REQUEST['dom_user'];
        $post['user.password'] = $this->REQUEST['dom_pass'];

        $http_code="";
        $ac = new alpcurl(); //create an instance
        $ac->getHeaders = false;
        $ac->getContent = true;
        $contents = $ac->post($url, $post, 0, $http_code);
        $success = $ac->get_parsed($contents,"<success>","</success>");
        if($sucess=="TRUE"){
            $user_id = $ac->get_parsed($contents,"<user.id>", "</user.id>");
        }else{
            $user_id = $ac->get_parsed($contents,"<error.desc.1>", "</error.desc.1>");
        }
        if(empty($user_id)){
            $user_id = $post['reseller.id'];
        }
        //Domain lookup
        $post = array();
        $post['operation'] = "domain.lookup";
        $post['admin.username'] = $this->dr_vals['planetdomain']['login'];
        $post['admin.password'] = $this->dr_vals['planetdomain']['password'];
        $post['reseller.id'] = $this->dr_vals['planetdomain']['reseller_id'];
        $post['response.format'] = "XML";

        $post['domain.name'] = $this->REQUEST['domain'];
        $contents = $ac->post($url, $post, 0, $http_code);
        $success = $ac->get_parsed($contents,"<success>","</success>");

        //Add domain
        $post = array();
        $post['operation'] = "domain.register";
        $post['admin.username'] = $this->dr_vals['planetdomain']['login'];
        $post['admin.password'] = $this->dr_vals['planetdomain']['password'];
        $post['reseller.id'] = $this->dr_vals['planetdomain']['reseller_id'];
        $post['response.format'] = "XML";

        $post['domain.name'] = $this->REQUEST['domain'];
        $post['owner.id'] = $user_id;
        $post['tech.id'] = $user_id;
        $post['admin.id'] = $user_id;
        $post['billing.id'] = $user_id;
        $post['register.period'] = $this->REQUEST['dom_period'];
        $post['ns.name.0'] = $this->REQUEST['ns1'];
        $post['ns.ip.0'] = $this->REQUEST['ns1'];
        $post['ns.name.1'] = $this->REQUEST['ns2'];
        $post['ns.ip.1'] = $this->REQUEST['ns2'];

        $contents = $ac->post($url, $post, 0, $http_code);
        $this->dom_reg_logs->insert(array("log_time"=>date('Y-m-d H:i:s'),"sub_id"=>$this->REQUEST['sub_id'],"domain"=>$this->REQUEST['domain'],"log_result"=>$contents));
        $success = $ac->get_parsed($contents,"<success>","</success>");
        if($sucess=="TRUE"){
            $registration_result = $ac->get_parsed($contents,"<registration.status>", "</registration.status>");
            $this->orders->update(array("sub_id"=>$this->REQUEST['sub_id'],"dom_reg_comp"=>1, "dom_reg_result"=>$registration_result, "dom_registrar"=>"planetdomain"));
            $order = $this->orders->getByKey($this->REQUEST['sub_id']);
            if ($order['dom_reg_comp'] == '1'){
                $registration_result = $this->props->lang['dom_reg_success'].$order[0]['dom_reg_result'];
            }else{
                $registration_result = $this->props->lang['dom_reg_fail'].$order[0]['dom_reg_result'];
            }

        }else{
            $registration_result = $ac->get_parsed($contents,"<error.desc.0>", "</error.desc.0>");
        }


        //Domain info
        $post = array();
        $post['operation'] = "domain.info";
        $post['admin.username'] = $this->dr_vals['planetdomain']['login'];
        $post['admin.password'] = $this->dr_vals['planetdomain']['password'];
        $post['reseller.id'] = $this->dr_vals['planetdomain']['reseller_id'];
        $post['response.format'] = "XML";

        $post['domain.name'] = $this->REQUEST['domain'];
        $contents = $ac->post($url, $post, 0, $http_code);
        $success = $ac->get_parsed($contents,"<success>","</success>");



    }
?>
