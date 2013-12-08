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

    function killAccount($plesk_server, $plesk_user, $plesk_password, $usessl, $order_data, & $plesk, $plesk_hash)
    {
        preparePlugin($plesk_server, $plesk_user, $plesk_password, $usessl, $plesk, $plesk_hash);

        $plesk->order_data = $order_data;

        $plesk->kill_plesk_account();
        return $plesk->result;
    }
    function suspendAccount($plesk_server, $plesk_user, $plesk_password, $usessl, $order_data, & $plesk, $plesk_hash)
    {
        preparePlugin($plesk_server, $plesk_user, $plesk_password, $usessl, $plesk, $plesk_hash);

        $plesk->order_data = $order_data;

        $plesk->suspend_plesk_account();
        return $plesk->result;
    }
    function unsuspendAccount($plesk_server, $plesk_user, $plesk_password, $usessl, $order_data, & $plesk, $plesk_hash)
    {
        preparePlugin($plesk_server, $plesk_user, $plesk_password, $usessl, $plesk, $plesk_hash);

        $plesk->order_data = $order_data;

        $plesk->unsuspend_plesk_account();
        return $plesk->result;
    }
    function createAccount($plesk_server, $plesk_user, $plesk_password, $usessl, $package_data, $order_data, & $plesk, $plesk_hash)
    {
        preparePlugin($plesk_server, $plesk_user, $plesk_password, $usessl, $plesk, $plesk_hash);

        $plesk->limits     = $package_data;
        $plesk->order_data = $order_data;
        foreach($plesk->permissions as $k=>$v)
            $plesk->permissions[$k] = $package_data[$k];
        $result = $plesk->create_plesk_account();
        return $result;
    }
    function listAccounts($plesk_server, $plesk_user, $plesk_password, $usessl, & $plesk, $plesk_hash)
    {
        preparePlugin($plesk_server, $plesk_user, $plesk_password, $usessl, $plesk, $plesk_hash);
        $plesk->list_plesk_accounts();
        return $plesk->result;
    }
    function listPackages($plesk_server, $plesk_user, $plesk_password, $usessl, & $plesk, $plesk_hash)
    {
        preparePlugin($plesk_server, $plesk_user, $plesk_password, $usessl, $plesk, $plesk_hash);
        $plesk->list_plesk_packages();
        return $plesk->result;
    }
    function syncPackage($plesk_server, $plesk_user, $plesk_password, $usessl, $package_data, $submit, & $plesk, $plesk_hash)
    {
        preparePlugin($plesk_server, $plesk_user, $plesk_password, $usessl, $plesk, $plesk_hash);
        $plesk->create_plesk_package($submit);
        return $plesk->result;
    }
    function preparePlugin($plesk_server, $plesk_user, $plesk_password, $usessl, & $plesk, $plesk_hash)
    {
        $plesk->plesk_server     = $plesk_server;
        $plesk->plesk_user       = $plesk_user;
        $plesk->plesk_password   = $plesk_password;
        $plesk->plesk_hash       = $plesk_hash;
        $plesk->usessl           = $usessl;
        $plesk->plesk_port       = 8443;
        $plesk->proto          = "http://";
        if($plesk->usessl == 1)
        {
            $plesk->proto      = "https://";
        }
    }
?>
