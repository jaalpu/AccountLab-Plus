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

    class installer_controller extends controller
    {
        function checkandupgrade()
        {
            if (!$this->dbL->dbConnection)
            {
                return "NO_CONNECT";
            }
            else
            {
                $conf = $this->dbL->findAllFromTable("order_conf");
                if(!isset($conf[0]['build']) || ALP_BUILD>$conf[0]['build'])
                {
                    if($this->upgrade()==1)
                    {
                        return "OK";
                    }
                    else
                    {
                        return "NOK";
                    }
                }
                return "OK";
            }
        }
        function checkInstall()
        {
            $err    = null;
            $warning= null;
            $tables = array();
            include CONFIG . "tables.php";
            $list_tables = $this->dbL->listTables($this->props->db_name);
            if (count($list_tables) != count($tables))
            {
                $err  = "<font color='red'>".$this->props->parseLang('upgrade_err')."</font>";
                $err .= "<br><br>".$this->props->parseLang('failed_to_create')."<br><ul>";
                foreach ($tables as $t)
                {
                    if (array_search($t, $list_tables) === false)
                    {
                        $err .= "<li><b>".$t."</b></li>";
                    }
                }
                $err .= "</ul>";
            }
            $temp = $this->dbL->findAllFromTable("order_conf");
            $conf = $temp[0];
            if ($conf['path_url'] != INSTALL_URL || $conf['path_abs'] != INSTALL_PATH)
            {
                $warning = $this->props->parseLang('path_warn');
            }
            return array($err,$warning);
        }
        function install($step)
        {
            if ($step == "2")
            {
                $link        = @mysql_connect($this->REQUEST['hostname'], $this->REQUEST['user'], $this->REQUEST['pass']);
                $db_selected = @mysql_select_db($this->REQUEST['dbname'], $link);
                if (!$link)
                {
                    $err  = $this->props->parseLang('err_mysql_connect') . "\"" . $this->REQUEST['hostname'] . "\"<br><b>" . mysql_error() . "</b>";
                }
                elseif (!$db_selected)
                {
                    $err .= $this->props->parseLang('err_mysql_use') . "\"" . $this->REQUEST['dbname'] . "\"<br><b>" . mysql_errno($link) . ": " . mysql_error() . "</b>";
                }
                @mysql_close($link);
                if (!isset($err))
                {
                    $db_file = PATH_ELEMENTS . PATH_SEP . "default".PATH_SEP."sysvar".PATH_SEP."db.php";
                    if (is_writable($db_file))
                    {
                        $fp      = fopen($db_file, "w+");
                        $data    = "<?php \n" . "$" . "db_host = \"" . $this->REQUEST['hostname'] . "\";\n" . "$" . "db_user = \"" . $this->REQUEST['user'] . "\";\n" . "$" . "db_pass = \"" . $this->REQUEST['pass'] . "\";\n" . "$" . "db_name = \"" . $this->REQUEST['dbname'] . "\";\n" . "?>";
                        fwrite($fp, $data);
                        fclose($fp);
                    }
                    $db_file = PATH_ELEMENTS . PATH_SEP . "custom".PATH_SEP."sysvar".PATH_SEP."db.php";
                    if (is_writable($db_file))
                    {
                        $fp= fopen($db_file, "w+");
                        $data= "<?php \n" . "$" . "db_host = \"" . $this->REQUEST['hostname'] . "\";\n" . "$" . "db_user = \"" . $this->REQUEST['user'] . "\";\n" . "$" . "db_pass = \"" . $this->REQUEST['pass'] . "\";\n" . "$" . "db_name = \"" . $this->REQUEST['dbname'] . "\";\n" . "?>";
                        fwrite($fp, $data);
                        fclose($fp);
                    }
                }
                return isset($err)?$err:null;
            }
            if ($step == "4")
            {
                $values                 = array ();
                $values['admin_pass']   = md5($this->REQUEST['admin_pass']);
                $values['ins_path']     = $this->REQUEST['ins_path'];
                $values['ins_url']      = $this->REQUEST['ins_url'];
                $values['admin_email']  = $this->REQUEST['admin_email'];
                $sqlDROP = "DROP TABLE ";
                $i       = 0;
                foreach ($this->dbL->listTables($this->props->db_name) as $val)
                {
                    if ($i != 0)
                    {
                        $sqlDROP .= ", ";
                    }
                    $sqlDROP .= "`" . $val . "`";
                    $i++;
                }
                $this->dbL->executeDROP($sqlDROP);
                $this->dbL->executeMixedSQLArray($this->props->install_sql_array1);
                $this->upgradeto2_6r4();
                $this->asso_servers();
                $this->encrypt_firsttime();
                $this->dbL->executeMixedSQLArray($this->props->install_sql_array2, $values);
                $this->upgrade(true);
            }
        }
        function asso_servers()
        {
            if (!count($this->dbL->findAllFromTable("order_server_ip")))
            {
                $sqlSELECT2 = "SELECT        *
                FROM          sub_order
                INNER JOIN    hosting_price
                ON            sub_order.plan=hosting_price.plan_name";
                $server     = array ();
                foreach ($this->dbL->findAllFromTable("servers") as $s)
                {
                    $server[$s['server_id']] = $s;
                    if ($s['server_default'] == "default")
                    {
                        $server[0]= $s;
                    }
                }
                $temp = array ();
                $temp = $this->dbL->executeSELECT($sqlSELECT2);
                foreach ($temp as $v)
                {
                    $server_id = $server[$v['server_id']]['server_id'];
                    $status    = 0;
                    if ($v['cust_status'] == $this->props->order_status[1])
                    {
                        $status= 1;
                    }
                    elseif ($v['cust_status'] == $this->props->order_status[2])
                    {
                        $status= 2;
                    }
                    elseif ($v['cust_status'] == $this->props->order_status[3])
                    {
                        $status= 3;
                    }
                    $sqlINSERT= "INSERT INTO order_server_ip
                    VALUES('" . $v['sub_id'] . "','" . $server_id . "','0','$status')";
                    $this->dbL->executeINSERT($sqlINSERT);
                }
            }
        }
        function encrypt_firsttime()
        {
            $conf = $this->dbL->findAllFromTable("order_conf");
            if (count($conf) && array_key_exists('encrypeted', $conf[0]) && $conf[0]['encrypeted'] != 1)
            {
                $servers = $this->dbL->findAllFromTable("servers");
                foreach ($servers as $server)
                {
                    $server_id = $server['server_id'];
                    $enc_pass  = $this->utils->alpcrypt->encrypt($server['server_hash'], $this->props->encryptionKey);
                    $sqlUPDATE = "UPDATE servers
                    SET    `server_hash` = '$enc_pass'
                    WHERE  `server_id`   = '$server_id'";
                    $this->dbL->executeUPDATE($sqlUPDATE);
                }
                $enom       = $this->dbL->findAllFromTable("enom");
                $directi    = $this->dbL->findAllFromTable("directi");
                $enc_pass   = $this->utils->alpcrypt->encrypt($enom[0]['enom_pw'], $this->props->encryptionKey);
                $sqlUPDATE  = "UPDATE       enom
                SET         `enom_pw` = '$enc_pass'";
                $this->dbL->executeUPDATE($sqlUPDATE);
                $enc_pass   = $this->utils->alpcrypt->encrypt($enom[0]['di_pw'], $this->props->encryptionKey);
                $sqlUPDATE  = "UPDATE      directi
                SET         `di_pw` = '$enc_pass'";
                $this->dbL->executeUPDATE($sqlUPDATE);
                $orders     = $this->dbL->findAllFromTable("sub_order");
                foreach ($orders as $order)
                {
                    $sub_id     = $order['sub_id'];
                    $enc_pass   = $this->utils->alpcrypt->encrypt($order['dom_pass'], $this->props->encryptionKey);
                    $sqlUPDATE  = "UPDATE      sub_order
                    SET         `dom_pass`  = '$enc_pass'
                    WHERE       `sub_id`    = '$sub_id'";
                    $this->dbL->executeUPDATE($sqlUPDATE);
                }
                $sqlUPDATE= "UPDATE      order_conf
                SET         `encrypeted` = '1'";
                $this->dbL->executeUPDATE($sqlUPDATE);
            }
        }
        /*
        * Functions to upgrade the alp to 2_6r4
        */
        function upgradeto2_6r4()
        {
            $this->dbL->executeMixedSQLArray($this->props->upgrade_sql_array1);
            if (!$this->dbL->findAllFromTable("sub_order"))
            {
                $temp = $this->dbL->findAllFromTable("cust_tab");
                if (count($temp))
                {
                    foreach ($temp as $key => $data)
                    {
                        $sqlINSERT = "INSERT INTO sub_order
                        (
                        `sub_id` ,
                        `parent_id` ,
                        `plan` ,
                        `bill_cycle` ,
                        `sign_date` ,
                        `domain_name` ,
                        `dom_reg` ,
                        `net_pay` ,
                        `tax_pay` ,
                        `cycle_pay` ,
                        `initial_pay` ,
                        `cust_status` ,
                        `remote_ip` ,
                        `client_notes` ,
                        `server` ,
                        `server_ip` ,
                        `name_ser_1` ,
                        `name_ser_2` ,
                        `pay_proc` ,
                        `fs_complete` ,
                        `dom_reg_comp` ,
                        `dom_reg_result` ,
                        `di_cust_id` ,
                        `di_cont_id` ,
                        `dom_registrar`
                        )
                        VALUES
                        (
                        '',
                        '$data[id]',
                        '$data[plan]',
                        '$data[bill_cycle]',
                        '$data[sign_date]',
                        '$data[domain_name]',
                        '$data[dom_reg]',
                        '$data[net_pay]',
                        '$data[tax_pay]',
                        '$data[cycle_pay]',
                        '$data[initial_pay]',
                        '$data[cust_status]',
                        '$data[remote_ip]',
                        '$data[client_notes]',
                        '$data[server]',
                        '$data[server_ip]',
                        '$data[name_ser_1]',
                        '$data[name_ser_2]',
                        '$data[pay_proc]',
                        '$data[fs_complete]',
                        '$data[dom_reg_comp]',
                        '$data[dom_reg_result]',
                        '$data[di_cust_id]',
                        '$data[di_cont_id]',
                        '$data[dom_registrar]'
                        );";
                        $this->dbL->executeINSERT($sqlINSERT);
                    }
                }
            }
            $this->dbL->executeMixedSQLArray($this->props->upgrade_sql_array2);
            $temp = $this->dbL->findAllFromTable("order_conf");
            if (!empty ($temp[0]['acc_method']))
            {
                $acc_method = $temp[0]['acc_method'];
                $sqlUPDATE  = "UPDATE hosting_price SET `acc_method`='$acc_method'";
                $this->dbL->executeUPDATE($sqlUPDATE);
                $sqlDELETE  = "ALTER TABLE order_conf DROP `acc_method`";
                $this->dbL->executeDELETE($sqlDELETE);
            }
            return 1;
        }
        function upgrade($skip= false)
        {
            $upgrade = 0;
            $conf    = $this->dbL->findAllFromTable("order_conf");
            //Upgrade to Version 2.6 r4
            if (!array_key_exists('build', $conf[0]) && !$skip)
            {
                $this->upgradeto2_6r4();
                $this->asso_servers();
                $this->encrypt_firsttime();
                $upgrade= 1;
            }
            $sql_errors = "";
            $conf       = $this->dbL->findAllFromTable("order_conf");
            if (!array_key_exists('build', $conf[0]) || $conf[0]['build'] < 2)
            {
                $sql_errors .= $this->runVersionSqls('2_6r5');
                $sql1 = "SELECT sub_order.`sign_date`,customers.`id` FROM `sub_order` LEFT JOIN customers ON sub_order.parent_id=customers.`id` ORDER BY customers.`id`, sub_order.`sign_date` DESC";
                $dates= array();
                foreach ($this->dbL->executeSELECT($sql1) as $v)
                {
                    $dates[$v['id']]= $v['sign_date'];
                }
                foreach ($dates as $k => $v)
                {
                    $sql2   = "UPDATE customers SET `creation_date`='$v' WHERE `id`='$k'";
                    $r      = $this->dbL->executeUPDATE($sql2,true);
                    if (preg_match("/MYSQL ERROR/i", $r))
                    {
                        $sql_errors .= "<b>SQL:</b>\"" . $sql2 . "\";<br />".$r."<br />";
                    }
                }
                $sql_errors .= $this->updateBuild(2);
                $upgrade= 1;
            }
            //Upgrade to Version 2.6 r6 (build no 3)
            if ($this->getBuild() < 3)
            {
                $sql_errors .= $this->runVersionSqls('2_6r6');
                ///////////////////////////
                $sql1= "SELECT      *
                FROM        sub_order
                LEFT JOIN   customers
                ON          sub_order.parent_id=customers.id
                LEFT JOIN   invoices
                ON          invoices.cust_id=sub_order.sub_id";
                $r   = $this->dbL->executeSELECT($sql1);
                if (count($r))
                {
                    $fields = $this->pp_ext_fields['creditcard'];
                    foreach ($r as $v)
                    {
                        $_POST['card_holder']   = $this->utils->alpcrypt->decrypt($v['card_holder'], $this->props->encryptionKey);
                        $_POST['card_no']       = $this->utils->alpcrypt->decrypt($v['card_no'], $this->props->encryptionKey);
                        $_POST['card_type']     = $this->utils->alpcrypt->decrypt($v['card_type'], $this->props->encryptionKey);
                        $_POST['exp_date']      = $v['exp_date'];
                        $_POST['CVV2']          = $this->utils->alpcrypt->decrypt($v['CVV2'], $this->props->encryptionKey);
                        if (!empty ($_POST['card_holder']))
                        {
                            if (!$this->extraFields($v['parent_id'], $v['sub_id'], $v['invoice_no'], $fields, "UPDATE"))
                            {
                                $this->extraFields($v['parent_id'], $v['sub_id'], $v['invoice_no'], $fields, "INSERT");
                            }
                        }
                    }
                }
                $sql2[] = "ALTER TABLE `sub_order` DROP `card_holder`, DROP `card_no`, DROP `card_type`, DROP `exp_date`, DROP `CVV2`";
                $this->dbL->executeMixedSQLArray($sql2);
                $sql_errors .= $this->updateBuild(3);
                $upgrade= 1;
            }
            //Upgrade to Version 2.7 (build no 4)
            if ($this->getBuild() < 4)
            {
                $sql_errors .= $this->runVersionSqls('2_7');
                $servers     = $this->dbL->findAllFromTable("servers");
                foreach ($servers as $server)
                {
                    if ($server['server_type'] != "cpanel")
                    {
                        $server_id = $server['server_id'];
                        $pass_hash = $server['server_hash'];
                        $sqlUPDATE = "UPDATE servers SET `server_pass`='$pass_hash', `server_hash`='' WHERE `server_id`='$server_id'";
                        $this->dbL->executeUPDATE($sqlUPDATE);
                    }
                }
                $orders = $this->dbL->findAllFromTable("sub_order");
                foreach ($orders as $order)
                {
                    $last_inv_date  = $order['sign_date'];
                    $sqlSELECT      = "SELECT * FROM invoices WHERE `cust_id`='" . $order['sub_id'] . "' AND `status`!='" . $this->props->invoice_status[5] . "' AND `desc` LIKE '" . $order['plan'] . "-" . $order['domain_name'] . "-%' ORDER BY `invoice_no` DESC";
                    $temp           = $this->dbL->executeSELECT($sqlSELECT);
                    if (count($temp))
                    {
                        $last_inv_date= $temp[0]['due_date'];
                    }
                    $date       = $this->utils->getXmonthsAfter($order['bill_cycle'], $this->utils->getDateArray($last_inv_date));
                    $next_date  = $date['year'] . "-" . $date['mon'] . "-" . $date['mday'];
                    $sqlINSERT  = "INSERT INTO ord_inv_rec (`rec_ord_id`, `rec_next_date`)" .
                    "VALUES ('" . $order['sub_id'] . "','" . $next_date . "')";
                    $this->dbL->executeINSERT($sqlINSERT);
                }
                $sql_errors .= $this->updateBuild(4);
                $upgrade= 1;
            }
            //Upgrade to Version 2.7 r2 (build no 5)
            if ($this->getBuild() < 5)
            {
                $sql_errors .= $this->runVersionSqls('2_7r2');
                $orders = $this->dbL->findAllFromTable("sub_order");
                foreach ($orders as $order)
                {
                    $temp       = $this->dbL->executeSELECT("SELECT * FROM hosting_price WHERE `plan_name`='".$order['plan']."'");
                    $plan_id    = $temp[0]['plan_price_id'];
                    $plan_name  = $temp[0]['plan_name'];
                    $plan_friendly_name= $temp[0]['plan_friendly_name'];
                    $sub_id     = $order['sub_id'];
                    $sql        = "UPDATE sub_order SET `plan`='$plan_id' WHERE `sub_id`='$sub_id'";
                    if (is_numeric($plan_id))
                    {
                        $this->dbL->executeUPDATE($sql);
                    }
                    $sqlSELECT  = "SELECT * FROM invoices WHERE `cust_id`='" . $order['sub_id'] . "' AND (`desc` LIKE '" . $plan_name . "-" . $order['domain_name'] . "%' OR  `desc` LIKE '" . $plan_friendly_name . "-" . $order['domain_name'] . "%' OR `desc` LIKE '%-" . $plan_name . "-" . $order['domain_name'] . "%' OR  `desc` LIKE '%-" . $plan_friendly_name . "-" . $order['domain_name'] . "%') ORDER BY `invoice_no` DESC";
                    $temp       = $this->dbL->executeSELECT($sqlSELECT);
                    foreach ($temp as $t)
                    {
                        $new_desc= $t['desc'];
                        if (preg_match("/". $plan_name . "-/", $new_desc))
                        {
                            $new_desc= str_replace($plan_name . "-", $plan_id . "-", $t['desc']);
                        }
                        elseif (preg_match("/".$plan_friendly_name . "-/", $new_desc))
                        {
                            $new_desc= str_replace($plan_friendly_name . "-", $plan_id . "-", $t['desc']);
                        }
                        $sql    = "UPDATE invoices SET `desc`='$new_desc' WHERE `invoice_no`='" . $t['invoice_no'] . "'";
                        $this->dbL->executeUPDATE($sql);
                    }
                }
                $temp = $this->dbL->findAllFromTable("specials");
                foreach ($temp as $t)
                {
                    $temp = $this->dbL->executeSELECT("SELECT * FROM `hosting_price` WHERE `plan_name`='".$t['special_plan']."'");
                    $P1   = isset($temp[0]['plan_price_id'])?$temp[0]['plan_price_id']:(is_numeric($t['special_plan'])?$t['special_plan']:0);
                    $temp = $this->dbL->executeSELECT("SELECT * FROM `hosting_price` WHERE `plan_name`='".$t['special_plan_disc']."'");
                    $P2   = isset($temp[0]['plan_price_id'])?$temp[0]['plan_price_id']:(is_numeric($t['special_plan_disc'])?$t['special_plan_disc']:0);
                    $P3   = 1;

                    if ($t['special_plan'] == 1)
                    {
                        $P1 = "ALL";
                    }
                    if ($t['special_plan_disc'] == 1)
                    {
                        $P2 = "ALL";
                    }
                    if (empty ($t['special_plan']))
                    {
                        $P1 = 0;
                    }
                    if (empty ($t['special_plan_disc']))
                    {
                        $P2 = 0;
                    }
                    if (empty ($t['special_addon_disc']))
                    {
                        $P3 = 0;
                    }
                    $sql    = "UPDATE specials SET `special_plan`='" . $P1 . "', `special_plan_disc`='" . $P2 . "', `special_addon_disc`='" . $P3 . "' WHERE `special_id`='" . $t['special_id'] . "'";
                    $this->dbL->executeUPDATE($sql);
                }
                $sql_errors .= $this->updateBuild(5);
                $upgrade= 1;
            }
            //Upgrade to Version 2.7 r5 (build no 6)
            if ($this->getBuild() < 6)
            {
                $sql_errors .= $this->runVersionSqls('2_7r5');
                $sql_errors .= $this->updateBuild(6);
                $upgrade= 1;
            }
            //Upgrade to Version 2.7 r8 (build no 7)
            if ($this->getBuild() < 7)
            {
                $sql_errors .= $this->runVersionSqls('2_7r8');
                $sql_errors .= $this->updateBuild(7);
                $upgrade= 1;
            }
            //Upgrade to Version 2.7 r9 (build no 9)
            if ($this->getBuild() < 9)
            {
                $sql_errors .= $this->runVersionSqls('2_7r9');
                $sql_errors .= $this->updateBuild(9);
                $upgrade= 1;
            }
            //Upgrade to Version 2.8 (build no 10)
            if ($this->getBuild() < 10)
            {
                $sql_errors .= $this->runVersionSqls('2_8');
                $temp        = $this->dbL->findAllFromTable("billing_cycles");
                if(!count($temp))
                {
                    $sql_errors .= $this->runVersionSqls('2_8_INSERTS');
                }

                $plans  = $this->dbL->findAllFromTable("hosting_price");
                $i      = count($plans);
                foreach($plans as $kp=>$vp)
                {
                    $sqlUPDATE  = "UPDATE hosting_price SET `plan_index`='".$i."' WHERE `plan_price_id`='".$vp['plan_price_id']."'";
                    $this->dbL->executeUPDATE($sqlUPDATE);
                    $i          = $i-1;
                }
                //create cycle array
                $tc        = array();
                $temp      = $this->dbL->findAllFromTable("billing_cycles");
                foreach($temp as $c)
                {
                    $tc[$c['cycle_name']] = $c['id'];
                }
                //move hosting plan billing cycles
                $allok = true;
                $plans = $this->dbL->findAllFromTable("hosting_price");
                if(count($plans) && isset($plans[0]['monthly']))
                {
                    foreach($plans as $kp=>$vp)
                    {
                        foreach($tc as $cycle=>$cycle_id)
                        {
                            $sqlINSERT = "INSERT INTO billings_products (`billing_id`,`product_id`,`product_table`,`amount`)
                            VALUES ('".$cycle_id."','".$vp['plan_price_id']."','hosting_price','".$vp[$cycle]."')";
                            if(!$this->dbL->executeINSERT($sqlINSERT))
                            {
                                $allok = false;
                            }
                        }
                    }
                }

                //move addon billing cycles
                $addons = $this->dbL->findAllFromTable("addons");
                if(count($addons) && isset($addons[0]['monthly']))
                {
                    foreach($addons as $kp=>$vp)
                    {
                        foreach($tc as $cycle=>$cycle_id)
                        {
                            $sqlINSERT = "INSERT INTO billings_products (`billing_id`,`product_id`,`product_table`,`amount`)
                            VALUES ('".$cycle_id."','".$vp['addon_id']."','".$this->props->tbl_addons."','".$vp[$cycle]."')";
                            if(!$this->dbL->executeINSERT($sqlINSERT))
                            {
                                $allok = false;
                            }
                        }
                    }
                }

                //move subdomain billing cycles
                $subdomains = $this->dbL->findAllFromTable("subdomains");
                if(count($subdomains) && isset($subdomains[0]['monthly']))
                {
                    foreach($subdomains as $kp=>$vp)
                    {
                        foreach($tc as $cycle=>$cycle_id)
                        {
                            $sqlINSERT = "INSERT INTO billings_products (`billing_id`,`product_id`,`product_table`,`amount`)
                            VALUES ('".$cycle_id."','".$vp['main_id']."','".$this->props->tbl_subdomains."','".$vp[$cycle]."')";
                            if(!$this->dbL->executeINSERT($sqlINSERT))
                            {
                                $allok = false;
                            }
                        }
                    }
                }
                if($allok)
                {
                    //delete fields
                    $sqlALTER = "ALTER TABLE hosting_price DROP `monthly` , DROP `quarterly` , DROP `half_yearly` , DROP `yearly`" ;
                    $this->dbL->executeALTER($sqlALTER);
                    $sqlALTER = "ALTER TABLE subdomains DROP `monthly` , DROP `quarterly` , DROP `half_yearly` , DROP `yearly`" ;
                    $this->dbL->executeALTER($sqlALTER);
                    $sqlALTER = "ALTER TABLE addons DROP `monthly` , DROP `quarterly` , DROP `half_yearly` , DROP `yearly`" ;
                    $this->dbL->executeALTER($sqlALTER);
                }

                $sql_errors .= $this->updateBuild(10);
                $upgrade= 1;
            }
            //Upgrade to Version 2.8 r3 (build no 11)
            if ($this->getBuild() < 11)
            {
                $sql_errors .= $this->runVersionSqls('2_8r3_1');

                $move_data_successfull = empty($sql_errors)?true:false;

                /*
                * Move customer fields and datas start
                */
                if($move_data_successfull){
                    $field_names = $this->dbL->findAllFromTable("customfields");
                    $temp        = $this->dbL->findAllFromTable("customers");
                    foreach($temp as $data)
                    {
                        foreach($field_names as $f)
                        {
                            $field_name = $f['field_name'];
                            $sql        = "INSERT INTO `customers_customfields` VALUES ('".$data['id']."','".$f['field_id']."','".$this->utils->quoteSmart($data[$field_name])."')";
                            if(!$this->dbL->executeINSERT($sql))
                            {
                                $sql_errors .= "<b>SQL:</b>\"" . $sql . "\"; <br />";
                                $move_data_successfull = false;
                            }
                        }
                    }
                }
                if($move_data_successfull)
                {
                    foreach($field_names as $f)
                    {
                        $field_name = $f['field_name'];
                        $sql        = "ALTER TABLE `customers` DROP ".$field_name;
                        if(!$this->dbL->executeALTER($sql))
                        {
                            $sql_errors .= "<b>SQL:</b>\"" . $sql . "\"; <br />";
                            $move_data_successfull = false;
                        }
                    }
                }
                /*
                * Move customer fields and datas end
                */

                /*
                * Move orders datas start
                */
                if($move_data_successfull){
                    $temp = $this->dbL->findAllFromTable("orders");
                    foreach($temp as $data)
                    {
                        $sub_id       = $data['sub_id'];
                        $dom_reg      = (strtolower($data['dom_reg'])=='yes')?1:0;
                        $dom_reg_comp = (strtolower($data['dom_reg_comp'])=='yes')?1:0;

                        list($sld,$tld)= explode(".", $data['domain_name'], 2);
                        if(!$dom_reg && !$dom_reg_comp && $this->utils->chksubDomainFormat($data['domain_name']))
                        {
                            $subdomains = $this->dbL->findAllFromTable("subdomains");
                            foreach($subdomains as $subdomain)
                            {
                                if($subdomain['maindomain']==$tld)
                                {
                                    $dom_reg = 2;
                                }
                            }
                        }

                        $sql = "UPDATE `orders` SET `dom_reg`='$dom_reg', `dom_reg_comp`='$dom_reg_comp' WHERE `sub_id`='$sub_id'";
                        if(!$this->dbL->executeUPDATE($sql))
                        {
                            $sql_errors .= "<b>SQL:</b>\"" . $sql . "\"; <br />";
                            $move_data_successfull = false;
                        }
                        foreach(explode("<&&>",$data['addon_ids']) as $str)
                        {
                            $date = null;
                            $id   = null;
                            $str  = trim($str);
                            if(!empty($str))
                            {
                                list($date,$id) = explode("=>",$str,2);
                            }
                            if(!empty($id))
                            {
                                $sql = "INSERT INTO `orders_addons` VALUES ('$sub_id','$id','$date')";
                                if(!$this->dbL->executeINSERT($sql))
                                {
                                    $sql_errors .= "<b>SQL:</b>\"" . $sql . "\"; <br />";
                                    $move_data_successfull = false;
                                }
                            }
                        }
                    }
                }
                /*
                * Move orders datas end
                */
                /*
                * Move groups and products datas start
                */
                if($move_data_successfull){
                    $temp = $this->dbL->findAllFromTable("groups");
                    foreach($temp as $data)
                    {
                        foreach(explode("<&&>",$data['products']) as $id)
                        {
                            $id = trim($id);
                            if(!empty($id))
                            {
                                $sql = "INSERT INTO `groups_products` VALUES ('".$data['group_id']."','$id')";
                                if(!$this->dbL->executeINSERT($sql))
                                {
                                    $sql_errors .= "<b>SQL:</b>\"" . $sql . "\"; <br />";
                                    $move_data_successfull = false;
                                }
                            }
                        }
                    }
                }
                if($move_data_successfull){
                    $temp = $this->dbL->findAllFromTable("products");
                    foreach($temp as $data)
                    {
                        foreach(explode("<&&>",$data['addons']) as $id)
                        {
                            $id = trim($id);
                            if(!empty($id))
                            {
                                $sql = "INSERT INTO `products_addons` VALUES ('".$data['plan_price_id']."','$id')";
                                if(!$this->dbL->executeINSERT($sql))
                                {
                                    $sql_errors .= "<b>SQL:</b>\"" . $sql . "\"; <br />";
                                    $move_data_successfull = false;
                                }
                            }
                        }
                    }
                }
                /*
                * Move groups and products datas end
                */
                /*
                * Move order_id and customer_id from invoice and order tables datas start
                */
                if($move_data_successfull){
                    $temp = $this->dbL->findAllFromTable("orders");
                    foreach($temp as $data)
                    {
                        $customer_id = $data['parent_id'];
                        $order_id    = $data['sub_id'];
                        $sql = "INSERT INTO `customers_orders` VALUES('".$customer_id."','".$order_id."')";
                        if(!$this->dbL->executeINSERT($sql))
                        {
                            $sql_errors .= "<b>SQL:</b>\"" . $sql . "\"; <br />";
                            $move_data_successfull = false;
                        }
                    }
                }
                if($move_data_successfull)
                {
                    $sql = "ALTER TABLE `orders` DROP `parent_id`";
                    if(!$this->dbL->executeALTER($sql))
                    {
                        $sql_errors .= "<b>SQL:</b>\"" . $sql . "\"; <br />";
                        $move_data_successfull = false;
                    }
                }
                if($move_data_successfull){
                    $temp = $this->dbL->findAllFromTable("invoices");
                    foreach($temp as $data)
                    {
                        $invoice_id  = $data['invoice_no'];
                        $order_id    = $data['cust_id'];
                        $sql = "INSERT INTO `orders_invoices` VALUES('".$order_id."','".$invoice_id."')";
                        if(!$this->dbL->executeINSERT($sql))
                        {
                            $sql_errors .= "<b>SQL:</b>\"" . $sql . "\"; <br />";
                            $move_data_successfull = false;
                        }
                    }
                }
                if($move_data_successfull)
                {
                    $sql = "ALTER TABLE `invoices` DROP `cust_id`";
                    if(!$this->dbL->executeALTER($sql))
                    {
                        $sql_errors .= "<b>SQL:</b>\"" . $sql . "\"; <br />";
                        $move_data_successfull = false;
                    }
                }
                /*
                * Move order_id and customer_id from invoice and order tables datas end
                */
                /*
                * Move orphan orders start
                */
                if($move_data_successfull){
                    $temp_orders = $this->dbL->findAllFromTable("temp");
                    foreach($temp_orders as $temp_order)
                    {
                        $sql = "INSERT INTO `orphan_orders` VALUES('','".$temp_order['temp_id']."','".$this->utils->quoteSmart($temp_order['pp'])."','".date('Y-m-d H:i:s')."')";
                        $orphan_order_id = (is_numeric($temp_order['temp_id']))?$this->dbL->executeINSERT($sql):0;
                        $temp1 = split("<&&>", $temp_order['text_detail']);
                        foreach ($temp1 as $key => $val)
                        {
                            if(preg_match("/=>/",$val))
                            {
                                list ($a, $b) = split("=>", $val);
                                if($a=="plan_id")$a="product_id";
                                if($a=="initial")$a="gross_amount";
                                if($a=="net")$a="net_amount";
                                if($a=="total_tax_amount")$a="tax_amount";
                                if($a=="tax")$a="tax_percent";
                                if($a=="inv_tld_fee")$a="tld_fee";
                                if($a=="inv_setup_fee")$a="setup_fee";
                                if($a=="inv_cycle_fee")$a="cycle_fee";
                                if($a=="inv_addon_fee")$a="addon_fee";
                                if($a=="selected_server_id")$a="server_id";
                                if($a=="domain")$a="domain_name";

                                if($a=="type")
                                {
                                    $b = ($b=="register_subdomain")?2:(($b=="register_domain")?1:0);
                                }

                                if($a=="existing_email" && !empty($b))
                                {
                                    $customer = $this->dbL->executeSELECT("SELECT * FROM `customers` WHERE `email`='".$b."'");
                                    $sql = "INSERT INTO `orphan_order_datas` VALUES('".$orphan_order_id."','member','1')";
                                    $this->dbL->executeINSERT($sql);
                                    $sql = "INSERT INTO `orphan_order_datas` VALUES('".$orphan_order_id."','id','".$customer[0]['id']."')";
                                    $this->dbL->executeINSERT($sql);
                                }

                                $sql = "INSERT INTO `orphan_order_datas` VALUES('".$orphan_order_id."','".$this->utils->quoteSmart($a)."','".$this->utils->quoteSmart($b)."')";
                                if(!preg_match("/xajax/",$a) && $b!="none" && $b!='')$this->dbL->executeINSERT($sql);
                            }
                        }
                    }
                }
                /*
                * Move orphan orders end
                */
                if($move_data_successfull)
                {
                    $sql_errors .= $this->runVersionSqls('2_8r3_2');
                }
                $sql_errors .= $this->updateBuild(11);
                $upgrade= 1;
            }
            //Upgrade to Version 2.8 r4 (build no 12)
            if ($this->getBuild() < 12)
            {
                $sql_errors .= $this->runVersionSqls('2_8r4');
                $sql_errors .= $this->updateBuild(12);
                $upgrade= 1;
            }
            //Upgrade to Version 2.8 r10 (build no 13)
            if ($this->getBuild() < 13)
            {
                $sql_errors .= $this->runVersionSqls('2_8r10');
                $sql_errors .= $this->updateBuild(13);
                $upgrade= 1;
            }
            //Upgrade to Version 2.8 r12 (build no 14)
            if ($this->getBuild() < 14)
            {
                $sql_errors .= $this->runVersionSqls('2_8r12');
                //Move directi
                $temp = $this->dbL->findAllFromTable("`directi`");
                if(count($temp)){
                    $INSERTs = array();
                    $INSERTs[] = "INSERT INTO `registrars` VALUES ('','directi','login','".$temp[0]['di_uid']."')";
                    $INSERTs[] = "INSERT INTO `registrars` VALUES ('','directi','password','".$temp[0]['di_pw']."')";
                    $INSERTs[] = "INSERT INTO `registrars` VALUES ('','directi','parent_id','".$temp[0]['di_par_id']."')";
                    $INSERTs[] = "INSERT INTO `registrars` VALUES ('','directi','mode','".$temp[0]['di_url']."')";
                    $INSERTs[] = "INSERT INTO `registrars` VALUES ('','directi','active','".$temp[0]['di_active']."')";
                    $this->dbL->executeMixedSQLArray($INSERTs);
                }
                //Move enom
                $temp = $this->dbL->findAllFromTable("`enom`");
                if(count($temp)){
                    $INSERTs = array();
                    $INSERTs[] = "INSERT INTO `registrars` VALUES ('','enom','login','".$temp[0]['enom_uid']."')";
                    $INSERTs[] = "INSERT INTO `registrars` VALUES ('','enom','password','".$temp[0]['enom_pw']."')";
                    $INSERTs[] = "INSERT INTO `registrars` VALUES ('','enom','mode','".$temp[0]['enom_test_mode']."')";
                    $INSERTs[] = "INSERT INTO `registrars` VALUES ('','enom','active','".$temp[0]['enom_active']."')";
                    $this->dbL->executeMixedSQLArray($INSERTs);
                }
                //Move opensrs
                $temp = $this->dbL->findAllFromTable("`opensrs`");
                if(count($temp)){
                    $INSERTs = array();
                    $INSERTs[] = "INSERT INTO `registrars` VALUES ('','opensrs','login','".$temp[0]['opensrs_uid']."')";
                    $INSERTs[] = "INSERT INTO `registrars` VALUES ('','opensrs','password','".$temp[0]['opensrs_pw']."')";
                    $INSERTs[] = "INSERT INTO `registrars` VALUES ('','opensrs','mode','".$temp[0]['opensrs_test_mode']."')";
                    $INSERTs[] = "INSERT INTO `registrars` VALUES ('','opensrs','active','".$temp[0]['opensrs_active']."')";
                    $this->dbL->executeMixedSQLArray($INSERTs);
                }

                $this->dbL->executeDROP("DROP TABLE `directi`, `enom`, `opensrs`, `registerfly`;");
                $sql_errors .= $this->updateBuild(14);
                $upgrade= 1;
            }
            //Upgrade to Version 2.9.0
            if ($this->getBuild() < 20900)
            {
                $sql_errors .= $this->runVersionSqls('2_9_0');
                $sql_errors .= $this->updateBuild(20900);
                $upgrade= 1;
            }
            //Upgrade to Version 2.9.1
            if ($this->getBuild() < 20901)
            {
                $sql_errors .= $this->runVersionSqls('2_9_1');
                $sql_errors .= $this->updateBuild(20901);
                $upgrade= 1;
            }
            ///////////////////////////
            if ($upgrade)
            {
                $conf   = $this->dbL->findAllFromTable("order_conf");
                //Email to admin about this upgrade
                $to     = $conf[0]['comp_email'];
                $from   = "accountlabplus@" . INSTALL_DOMAIN;
                $sub    = $this->props->parseLang('alp_upgraded') . " " . $this->props->ALPversion;
                $msg    = $this->props->parseLang('Hi') .
                $this->props->parseLang('alp_upgraded') . " " .
                $this->props->ALPversion . "<br /><br />";
                $msg .= "<br /><b>" .
                $this->props->parseLang('install_url') .
                " : </b><a href='" . $conf[0]['path_url'] .
                "/admin.php'>" . $conf[0]['path_url'] .
                "/admin.php</a><br /><br />";
                $msg .= $this->props->parseLang('pls_conf_alp') . "<br /><br /><br />";
                $msg1= "";
                if (!empty ($sql_errors))
                {
                    $msg1 = "==========================================<br />" .
                    $this->props->parseLang('err_upgrade') .
                    "==========================================<br />" .
                    $sql_errors .
                    "==========================================<br /><br />" .
                    $this->props->parseLang('open_alp_ticket');
                    echo $msg1;
                }
                $this->initMailAgent();
                $message                = $msg . $msg1;
                $this->ALPmail->AddAddress($conf[0]['comp_email'], $conf[0]['company_name']);
                $this->ALPmail->Subject = $sub;
                $this->ALPmail->Body    = $message;
                $this->ALPmail->IsHTML(true);
                return $this->ALPmail->sendMail();
            }
            return $upgrade;
        }
        function initMailAgent()
        {
            $conf   = $this->dbL->findAllFromTable("order_conf");
            $this->ALPmail= new ALPmail;
            $this->ALPmail->setProps($conf[0], $this->props);
        }
        function getBuild()
        {
            $conf = $this->dbL->findAllFromTable("order_conf");
            return $conf[0]['build'];
        }
        function updateBuild($build)
        {
            $sql_errors = "";
            if($this->getBuild()<$build)
            {
                $sql = "UPDATE order_conf SET `build`=".intval($build);
                $v   = $this->dbL->executeUPDATE($sql,true);
                if (preg_match("/MYSQL ERROR/i",$v))
                {
                    $sql_errors .= "<b>SQL:</b>\"" . $sql . "\"; <br />".$v."<br />";
                }
            }
            return $sql_errors;
        }
        function runVersionSqls($version)
        {
            $sql_errors = "";
            $sqls   = $this->props->Queries[$version];
            $array  = $this->dbL->executeMixedSQLArray($sqls,array(),true);
            foreach ($array as $k => $v)
            {
                if (!is_array($v) && preg_match("/MYSQL ERROR/i",$v))
                {
                    $sql_errors .= "<b>SQL:</b>\"" . $sqls[$k] . "\"; <br />".$v."<br />";
                }
            }
            return $sql_errors;
        }
        function extraFields($cust_id, $sub_id, $inv_no, $fields, $do= "INSERT")
        {
            if ($do == "INSERT")
            {
                $str1 = "`cust_id`,`sub_id`,`inv_no`";
                $str2 = "'$cust_id','$sub_id','$inv_no'";
                foreach ($fields as $v)
                {
                    if ($v[2] == 1)
                    {
                        $x     = $v[1];
                        $str1 .= ", `" . $x . "`";
                        if ($v[3] == 1)
                        {
                            $str2 .= ", '" . $this->utils->alpcrypt->encrypt($_POST[$x], $this->props->encryptionKey) . "'";
                        }
                        else
                        {
                            $str2 .= ", '" . $this->utils->quoteSmart($_POST[$x]) . "'";
                        }
                    }
                }
                $sqlINSERT = "INSERT INTO extra_fields (" . $str1 . ") VALUES (" . $str2 . ")";
                return $this->dbL->executeINSERT($sqlINSERT);
            }
            elseif ($do == "UPDATE")
            {
                $str1 = "";
                foreach ($fields as $v)
                {
                    if ($str1 != "")
                    {
                        $str1 .= ", ";
                    }
                    if ($v[2] == 1)
                    {
                        $x      = $v[1];
                        $str1  .= "`" . $x . "`=";
                        if ($v[3] == 1)
                        {
                            $str1 .= "'" .  $this->utils->alpcrypt->encrypt($_POST[$x], $this->props->encryptionKey) . "'";
                        }
                        else
                        {
                            $str1 .= "'" .  $this->utils->quoteSmart($_POST[$x]) . "'";
                        }
                    }
                }
                $sqlUPDATE= "UPDATE extra_fields SET " . $str1 . " WHERE `inv_no`=".intval($inv_no);
                return $this->dbL->executeUPDATE($sqlUPDATE);
            }
        }
    }
?>
