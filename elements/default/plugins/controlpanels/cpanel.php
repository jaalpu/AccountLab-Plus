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

    function killAccount($whm_server, $whm_user, $whm_password, $usessl, $order_data, & $cpanel, $whm_hash)
    {
        preparePlugin($whm_server, $whm_user, $whm_password, $usessl, $cpanel, $whm_hash);
        $cpanel->order_data['username'] = $order_data['dom_user'];
        $cpanel->order_data['domain']   = $order_data['domain_name'];
        $cpanel->kill_whm_account();
        return $cpanel->result;
    }
    function suspendAccount($whm_server, $whm_user, $whm_password, $usessl, $order_data, & $cpanel, $whm_hash)
    {
        preparePlugin($whm_server, $whm_user, $whm_password, $usessl, $cpanel, $whm_hash);

        $cpanel->order_data['username'] = $order_data['dom_user'];
        $cpanel->order_data['domain']   = $order_data['domain_name'];

        $cpanel->suspend_whm_account();
        return $cpanel->result;
    }
    function unsuspendAccount($whm_server, $whm_user, $whm_password, $usessl, $order_data, & $cpanel, $whm_hash)
    {
        preparePlugin($whm_server, $whm_user, $whm_password, $usessl, $cpanel, $whm_hash);

        $cpanel->order_data['username'] = $order_data['dom_user'];
        $cpanel->order_data['domain']   = $order_data['domain_name'];

        $cpanel->unsuspend_whm_account();
        return $cpanel->result;
    }
    function createAccount($whm_server, $whm_user, $whm_password, $usessl, $package_data, $order_data, & $cpanel, $whm_hash)
    {
        preparePlugin($whm_server, $whm_user, $whm_password, $usessl, $cpanel, $whm_hash);

        $cpanel->package_data['name']       = $package_data['plan_name'];
        $cpanel->package_data['quota']      = $package_data['quota'];
        $cpanel->package_data['hasshell']   = $package_data['hasshell'];
        $cpanel->package_data['maxftp']     = $package_data['maxftp'];
        $cpanel->package_data['maxpop']     = $package_data['maxpop'];
        $cpanel->package_data['maxlst']     = $package_data['maxlst'];
        $cpanel->package_data['maxsql']     = $package_data['maxsql'];
        $cpanel->package_data['maxsub']     = $package_data['maxsub'];
        $cpanel->package_data['maxpark']    = $package_data['maxpark'];
        $cpanel->package_data['maxaddon']   = $package_data['maxaddon'];
        $cpanel->package_data['ip']          = $package_data['cip'];
        $cpanel->package_data['cgi']         = $package_data['cgi'];
        $cpanel->package_data['frontpage']  = $package_data['frontpage'];
        $cpanel->package_data['bwlimit']    = $package_data['bwlimit'];
        $cpanel->package_data['cpmod']      = $package_data['cp'];
        $cpanel->order_data['username']     = $order_data['dom_user'];
        $cpanel->order_data['password']     = $order_data['dom_pass'];
        $cpanel->order_data['domain']       = $order_data['domain_name'];
        $cpanel->order_data['ns1']          = $order_data['ns1'];
        $cpanel->order_data['ns2']          = $order_data['ns2'];
        $cpanel->order_data['contactemail'] = $order_data['email'];
        $cpanel->order_data['reseller']     = $package_data['cpanel_reseller'];
        $cpanel->order_data['ownerself']    = "";
        foreach($cpanel->limits_fields as $k=>$v)
        {
            $cpanel->limits_fields[$k] = isset($package_data[$k])?$package_data[$k]:"";
        }
        foreach($cpanel->acl_fields as $k=>$v)
        {
            $cpanel->acl_fields[$k] = isset($package_data[$k])?$package_data[$k]:"";
        }
        $result = $cpanel->create_whm_account();
        return $result;
    }
    function listAccounts($whm_server, $whm_user, $whm_password, $usessl, & $cpanel, $whm_hash)
    {
        preparePlugin($whm_server, $whm_user, $whm_password, $usessl, $cpanel, $whm_hash);
        $cpanel->list_whm_accounts();
        return $cpanel->result;
    }
    function listPackages($whm_server, $whm_user, $whm_password, $usessl, & $cpanel, $whm_hash)
    {
        preparePlugin($whm_server, $whm_user, $whm_password, $usessl, $cpanel, $whm_hash);
        $cpanel->list_whm_packages();
        return $cpanel->result;
    }
    function syncPackage($whm_server, $whm_user, $whm_password, $usessl, $package_data, $submit, & $cpanel, $whm_hash)
    {
        preparePlugin($whm_server, $whm_user, $whm_password, $usessl, $cpanel, $whm_hash);

        $cpanel->package_data['name']       = $package_data['plan_name'];
        $cpanel->package_data['quota']      = $package_data['quota'];
        $cpanel->package_data['hasshell']   = $package_data['hasshell'];
        $cpanel->package_data['maxftp']     = $package_data['maxftp'];
        $cpanel->package_data['maxpop']     = $package_data['maxpop'];
        $cpanel->package_data['maxlst']     = $package_data['maxlst'];
        $cpanel->package_data['maxsql']     = $package_data['maxsql'];
        $cpanel->package_data['maxsub']     = $package_data['maxsub'];
        $cpanel->package_data['maxpark']    = $package_data['maxpark'];
        $cpanel->package_data['maxaddon']   = $package_data['maxaddon'];
        $cpanel->package_data['ip']         = $package_data['cip'];
        $cpanel->package_data['cgi']        = $package_data['cgi'];
        $cpanel->package_data['frontpage']  = $package_data['frontpage'];
        $cpanel->package_data['bwlimit']    = $package_data['bwlimit'];
        $cpanel->package_data['cpmod']      = $package_data['cp'];
        //$submit is "Create" or "Edit"

        $cpanel->create_whm_package($submit);
        return $cpanel->result;
    }
    function preparePlugin($whm_server, $whm_user, $whm_password, $usessl, & $cpanel, $whm_hash)
    {
        $cpanel->whm_server     = $whm_server;
        $cpanel->whm_user       = $whm_user;
        $cpanel->whm_password   = $whm_password;
        $cpanel->whm_hash       = $whm_hash;
        $cpanel->usessl         = $usessl;
        $cpanel->whm_port       = 2086;
        $cpanel->proto          = "http://";
        if($cpanel->usessl == 1)
        {
            $cpanel->whm_port   = 2087;
            $cpanel->proto      = "https://";
        }
    }
?>
