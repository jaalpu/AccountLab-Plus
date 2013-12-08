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
    * authorize Version 2.0
    */
    class authorize_controller extends controller
    {
        var $NoLicense          = 1;
        var $ALPLicense         = 0;
        var $ALPsaved           = "saved";
        var $ALPpermissiondenied= "Forbidden";
        /*
        * Verify login data and register ther user to the session
        */
        function ipBasedAuth($admin_id)
        {
            $login_time     = date('d-M-Y H:i:s');
            $secure_text    = "1762DFSD4439Ge74CKd5d5a6B77TC04220AS349"; //This is a text which can not be guessed this is to be packed with the fingerprint
            if (!empty($admin_id))
            {
                $sqlSELECT  = "SELECT `id`,`username`,`topic_id`,`admin_theme`,`email` FROM {$this->props->tbl_admin_users} WHERE `id`=".intval($admin_id);
                $user       = $this->dbL->executeSELECT($sqlSELECT);
                //Check if the user exists or not.
                if (count($user) == 0)
                {
                    $this->logout("admin");
                    return false;
                }
                //Register the variables to the session
                $_SESSION['admin_theme']        = $user[0]['admin_theme'];
                $_SESSION['username']           = $user[0]['username'];
                $_SESSION['admin_id']           = $user[0]['id'];
                $_SESSION['dept_id']            = $user[0]['topic_id'];
                $_SESSION['admin_email']        = $user[0]['email'];
                $_SESSION['admin_logged_in']    = true;
                $_SESSION['admin_login_time']   = $login_time;
                $_SESSION['admin_token']        = uniqid(rand(), true);
                $_SESSION['admin_fingerprint']  = md5($_SERVER['HTTP_USER_AGENT'].$secure_text.date('d-M-Y').$_SESSION['admin_token']);
                return true;
            }
            return false;
        }
        /*
        * Verify login data and register ther user to the session
        */
        function login($user_type = "admin")
        {
            $login_time   = date('d-M-Y H:i:s');
            $secure_text  = "1762DFSD4439Ge74CKd5d5a6B77TC04220AS349"; //This is a text which can not be guessed this is to be packed with the fingerprint
            if ($user_type == "admin")
            {
                $sql  = sprintf("SELECT `id`,`username`,`topic_id`,`admin_theme`,`email` FROM {$this->props->tbl_admin_users} WHERE `username`='%s' AND `password`='%s'", $this->utils->quoteSmart($this->REQUEST['username']), $this->utils->quoteSmart(md5($this->REQUEST['password'])));
                $user = $this->dbL->executeSELECT($sql);
                //Check if the user exists or not.
                if (count($user) == 0)
                {
                    $this->logout("admin");
                    return false;
                }
                //Register the variables to the session
                $_SESSION['admin_theme']        = $user[0]['admin_theme'];
                $_SESSION['username']           = $user[0]['username'];
                $_SESSION['admin_id']           = $user[0]['id'];
                $_SESSION['dept_id']            = $user[0]['topic_id'];
                $_SESSION['admin_email']        = $user[0]['email'];
                $_SESSION['admin_logged_in']    = true;
                $_SESSION['admin_login_time']   = $login_time;
                $_SESSION['admin_token']        = uniqid(rand(), true);
                $_SESSION['admin_fingerprint']  = md5($_SERVER['HTTP_USER_AGENT'].$secure_text.date('d-M-Y').$_SESSION['admin_token']);
                return true;
            }
            $sql  = sprintf("SELECT `id`,`email` FROM {$this->props->tbl_customers} WHERE `cust_deleted`!='1' AND `email`='%s' AND `password`='%s'", $this->utils->quoteSmart($this->REQUEST['email']), $this->utils->quoteSmart(md5($this->REQUEST['password'])));
            $user = $this->dbL->executeSELECT($sql);
            //Check if the user exists or not.
            if (!count($user))
            {
                $this->logout("user");
                return false;
            }
            $sql = "SELECT `field_value` FROM `customers_customfields` WHERE `customer_id`=".intval($user[0]['id'])." AND `field_id`='1'";
            $custom_fields= $this->dbL->executeSELECT($sql);
            //Register the variables to the session
            $_SESSION['name']             = $custom_fields[0]['field_value'];
            $_SESSION['email']            = $user[0]['email'];
            $_SESSION['user_id']          = $user[0]['id'];
            $_SESSION['user_logged_in']   = true;
            $_SESSION['user_login_time']  = $login_time;
            $_SESSION['user_token']       = uniqid(rand(), true);
            $_SESSION['user_fingerprint'] = md5($_SERVER['HTTP_USER_AGENT'].$secure_text.date('d-M-Y').$_SESSION['user_token']);
            return true;
        }
        /*
        * Authenitication check
        */
        function IsAuth($user_type="admin", $ip_is_licensed_for=0,$check_ip=false)
        {
            $secure_text  = "1762DFSD4439Ge74CKd5d5a6B77TC04220AS349"; //This is a text which can not be guessed this is packed with the fingerprint
            //check for finger print against session hijack and it will ensure that session is maximum valid for 24 hours
            if ($user_type == "admin")
            {
                if(!$check_ip || $ip_is_licensed_for==$_SESSION['admin_id'])
                {
                    if (isset($_SESSION['admin_fingerprint']) && isset($_SESSION['admin_token']) && $_SESSION['admin_fingerprint'] == md5($_SERVER['HTTP_USER_AGENT'].$secure_text.date('d-M-Y').$_SESSION['admin_token']))
                        if ($_SESSION['admin_logged_in'] == true && is_numeric($_SESSION['admin_id']) && $_SESSION['admin_id'] > 0 && $this->utils->chkUserFormat($_SESSION['username']))
                        {
                            //log user
                            $log_time       = date('Y-m-d H:i:s');
                            $log_user_type  = 2;
                            $log_user_id    = $_SESSION['admin_id'];
                            $log_user_ip    = $this->utils->realip();
                            $log_user_name  = $this->utils->quoteSmart($_SESSION['username']);
                            $log_user_login = $this->utils->quoteSmart($_SESSION['username']);
                            $log_user_email = $this->utils->quoteSmart($_SESSION['admin_email']);
                            $entry_time		= date('Y-m-d H:i:s', strtotime($_SESSION['admin_login_time']));
                            if(empty($_SESSION['log_session_id']))
                            {
                                $_SESSION['log_session_id'] = session_id();
                            }
                            $log_session_id = $_SESSION['log_session_id'];
                            $cmd            = isset($this->REQUEST['cmd'])?$this->REQUEST['cmd']:"";
                            $log_page       = $this->utils->quoteSmart($cmd);
                            $sqlSELECT = "SELECT * FROM {$this->props->tbl_online_users} WHERE `log_session_id`	= '$log_session_id' AND `user_type`='2' AND `visiting_page` != 'order_page'";
                            if(count($this->dbL->executeSELECT($sqlSELECT)))//update
                            {
                                $sqlUPDATE="UPDATE  {$this->props->tbl_online_users}
                                SET     `log_time`          = '$log_time',
                                `visiting_page`     = '$log_page'
                                WHERE   `log_session_id`	= '$log_session_id'
                                AND 	`user_type`         = '2'
                                AND 	`visiting_page`    != 'order_page'";
                                $this->dbL->executeUPDATE($sqlUPDATE);
                            }
                            else//insert
                            {
                                $sqlINSERT="INSERT INTO     {$this->props->tbl_online_users} (
                                `log_time` , `user_type` , `user_id` , `user_ip` , `user_name` , `user_login` , `user_email` , `visiting_page` , `items_in_basket` , `entry_time`, `log_session_id`
                                )
                                VALUES (
                                '$log_time', '2', '$log_user_id', '$log_user_ip', '$log_user_name', '$log_user_login', '$log_user_email', '$log_page', '---', '$entry_time', '$log_session_id'
                                )";
                                $this->dbL->executeINSERT($sqlINSERT);
                            }
                            //
                            return true;
                        }
                }
                $this->logout("admin");
                return false;
            }
            else
            {
                if (isset($_SESSION['user_fingerprint']) && $_SESSION['user_fingerprint'] == md5($_SERVER['HTTP_USER_AGENT'].$secure_text.date('d-M-Y').$_SESSION['user_token']))
                    if ($_SESSION['user_logged_in'] == true && is_numeric($_SESSION['user_id']) && $_SESSION['user_id'] > 0 && $this->utils->chkEmailFormat($_SESSION['email']))
                    {
                        //log user
                        $log_time       = date('Y-m-d H:i:s');
                        $log_user_type  = 1;
                        $log_user_id    = intval($_SESSION['user_id']);
                        $log_user_ip    = $this->utils->realip();
                        $log_user_name  = $this->utils->quoteSmart($_SESSION['name']);
                        $log_user_login = $this->utils->quoteSmart($_SESSION['email']);
                        $log_user_email = $this->utils->quoteSmart($_SESSION['email']);
                        $entry_time		= date('Y-m-d H:i:s', strtotime($_SESSION['user_login_time']));
                        if(empty($_SESSION['log_session_id']))
                        {
                            $_SESSION['log_session_id'] = session_id();
                        }
                        $log_session_id = $_SESSION['log_session_id'];
                        $cmd            = isset($this->REQUEST['cmd'])?$this->REQUEST['cmd']:"";
                        $log_page       = $this->utils->quoteSmart($cmd);
                        $sqlSELECT = "SELECT * FROM {$this->props->tbl_online_users} WHERE `log_session_id`	= '$log_session_id' AND `user_type`='1'";
                        if(count($this->dbL->executeSELECT($sqlSELECT)))//update
                        {
                            $sqlUPDATE="UPDATE  {$this->props->tbl_online_users}
                            SET     `log_time`          = '$log_time',
                            `visiting_page`     = '$log_page'
                            WHERE   `log_session_id`	= '$log_session_id'
                            AND 	`user_type`		    = '1'";
                            $this->dbL->executeUPDATE($sqlUPDATE);
                        }
                        else//insert
                        {
                            $sqlINSERT="INSERT INTO     {$this->props->tbl_online_users} (
                            `log_time` , `user_type` , `user_id` , `user_ip` , `user_name` , `user_login` , `user_email` , `visiting_page` , `items_in_basket` , `entry_time`, `log_session_id`
                            )
                            VALUES (
                            '$log_time', '1', '$log_user_id', '$log_user_ip', '$log_user_name', '$log_user_login', '$log_user_email', '$log_page', '---', '$entry_time', '$log_session_id'
                            )";
                            $this->dbL->executeINSERT($sqlINSERT);
                        }
                        //
                        return true;
                    }
                    $this->logout("user");
                return false;
            }
        }
        /*
        * is session
        */
        function IsSESSION($user_type='user')
        {
            $secure_text= "1762DFSD4439Ge74CKd5d5a6B77TC04220AS349"; //This is a text which can not be guessed this is packed with the fingerprint
            //check for finger print against session hijack and it will ensure that session is maximum valid for 24 hours
            if ($user_type == "admin")
            {
                if (isset($_SESSION['admin_fingerprint']) && $_SESSION['admin_fingerprint'] == md5($_SERVER['HTTP_USER_AGENT'].$secure_text.date('d-M-Y').$_SESSION['admin_token']))
                {
                    if ($_SESSION['admin_logged_in'] == true && is_numeric($_SESSION['admin_id']) && $_SESSION['admin_id'] > 0 && $this->utils->chkUserFormat($_SESSION['username']))
                    {
                        return true;
                    }
                }
            }
            else
            {
                if ($_SESSION['user_fingerprint'] == md5($_SERVER['HTTP_USER_AGENT'].$secure_text.date('d-M-Y').$_SESSION['user_token']))
                    if ($_SESSION['user_logged_in'] == true && is_numeric($_SESSION['user_id']) && $_SESSION['user_id'] > 0 && $this->utils->chkEmailFormat($_SESSION['email']))
                    {
                        return true;
                    }
            }
            return false;
        }
        /*
        * Logout
        */
        function logout($user_type="")
        {
            if ($user_type == "admin")
            {
                //echo "logout admin";
                $_SESSION['username']            = "";
                $_SESSION['admin_id']            = 0;
                $_SESSION['admin_email']         = "";
                $_SESSION['dept_id']             = "";
                $_SESSION['admin_logged_in']     = false;
                $_SESSION['admin_login_time']    = "";
                $_SESSION['admin_token']         = uniqid(rand(), true);
                $_SESSION['admin_fingerprint']   = "";
                $_SESSION['admin_theme']         = "";
                $_SESSION['refr']                = 0;

            }
            else
            {
                //echo "logout user";
                $_SESSION['name']                = "";
                $_SESSION['email']               = "";
                $_SESSION['user_id']             = 0;
                $_SESSION['user_logged_in']      = false;
                $_SESSION['user_login_time']     = "";
                $_SESSION['user_token']          = uniqid(rand(), true);
                $_SESSION['user_fingerprint']    = "";
            }
            @session_destroy();	// Delete all session data
            return true;
        }
    }
?>
