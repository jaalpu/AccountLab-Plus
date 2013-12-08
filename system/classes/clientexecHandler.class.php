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
    * A class to do all clientexec handling clientexecHandler Version 2.0
    */
    class clientexecHandler
    {
        /*
        * Constructor
        */
        function clientexecHandler()
        {
            $this->db_host = "";
            $this->db_user = "";
            $this->db_pass = "";
            $this->db_name = "";
        }
        /*
        * make connection
        */
        function connectDB()
        {
            $this->errorHandler = new errorHandler();
            $this->dbL          = new db($this->db_host, $this->db_user, $this->db_pass, $this->db_name, $this->errorHandler, true);
        }
        function dbReconnect()
        {
            $this->dbL->dbDisconnect();
            $this->dbL = new db($this->db_host, $this->db_user, $this->db_pass, $this->db_name, $this->errorHandler, true);
        }
        /*
        * Function import tlds
        */
        function importTlds(& $BL)
        {
            $existing_tlds = array();
            $BL->dbReconnect();
            foreach($BL->tlds->find() as $tld)
            {
                $existing_tlds[$tld['price_id']] = $tld['dom_ext']."_".$tld['dom_period'];
            }
            $sqlSELECT = "SELECT * FROM `tld`";
            $this->dbReconnect();
            $tlds = $this->dbL->executeSELECT($sqlSELECT);
            foreach($tlds as $tld)
            {
                $str = $tld['name']."_".$tld['period'];
                if(array_search($str,$existing_tlds)===false)
                {
                    $BL->REQUEST['dom_ext']      = $tld['name'];
                    $BL->REQUEST['dom_period']   = $tld['period'];
                    $BL->REQUEST['dom_price']    = $tld['price'];
                    $server_array          = $BL->props->tld_array[$BL->REQUEST['dom_ext']];
                    $BL->REQUEST['tld_server']   = $server_array['server'];
                    $BL->REQUEST['tld_match']    = $server_array['nomatch'];
                    $BL->REQUEST['tld_active'] = "yes";
                    $BL->REQUEST['tld_registrar'] = "Manual";
                    $BL->dbReconnect();
                    $insert_id  = $BL->tlds->insert($BL->REQUEST);
                    $existing_tlds[$insert_id] = $str;
                }
            }
            return $existing_tlds;
        }
        /*
        * Function import products
        */
        function importProducts(& $BL)
        {
            $existing_products = array();
            $BL->dbReconnect();
            foreach($BL->products->find() as $t)
            {
                $existing_products[] = $t['plan_name'];
            }
            $sqlSELECT = "SELECT * FROM `package`";
            $this->dbReconnect();
            $products  = $this->dbL->executeSELECT($sqlSELECT);

            foreach($products as $product)
            {
                $sqlSELECT = "SELECT * FROM `package_variable` WHERE `packageid` = '".intval($product['id'])."' AND `value`!=''";
                $temp       = $this->dbL->executeSELECT($sqlSELECT);
                $BL->REQUEST['plan_name'] = $temp[0]['value'];
                if(empty($temp[0]['value']))
                {
                    $BL->REQUEST['plan_name']  = $product['planname'];
                }
                $BL->REQUEST['host_setup_fee'] = $product['setup'];
                $BL->REQUEST['plan_desc']      = $product['description'];
                $BL->REQUEST['plan_friendly_name']       = $product['planname'];
                $BL->REQUEST['activation_mail_template'] = $product['welcomeemail'];
                $BL->REQUEST['monthly']       = $product['price'];
                $BL->REQUEST['quarterly']     = $product['price3'];
                $BL->REQUEST['half_yearly']   = $product['price6'];
                $BL->REQUEST['yearly']        = $product['price12'];
                if(array_search($BL->REQUEST['name'],$existing_products)===false)
                {
                    $BL->dbReconnect();
                    $insert_id = $BL->products->insert($BL->REQUEST);
                    $BL->products->updateBillingCycles($insert_id,$BL->REQUEST);
                    $existing_products[] = $BL->REQUEST['name'];
                }
            }
            return $existing_products;
        }
        /*
        * Get custom fields
        */
        function getCustomFields()
        {
            $sqlSELECT = "SELECT * FROM `customuserfields` WHERE `InSignup`='1'";
            $this->dbReconnect();
            $temp = $this->dbL->executeSELECT($sqlSELECT);
            foreach($temp as $t)
            {
                $fields[$t['id']] = trim($t['name']);
            }
            return $fields;
        }
        /*
        * function import customers
        */
        function importCustomers(& $BL)
        {
            $sqlSELECT = "SELECT `id`,`email`,`firstname`,`lastname`,`organization`,`dateActivated`  FROM `users`";
            $this->dbReconnect();
            $customers = $this->dbL->executeSELECT($sqlSELECT);
            $existing_customer_emails = array();
            $BL->dbReconnect();
            foreach($BL->customers->find(array("WHERE `cust_deleted`='0'`")) as $existing_customer)
            {
                $existing_customer_emails[] = $existing_customer['email'];
            }
            foreach($customers as $customer)
            {
                if(array_search($customer['email'],$existing_customer_emails)===false)
                {
                    $sqlSELECT = "SELECT * FROM `user_customuserfields`  WHERE `user_customuserfields`.userid='".intval($customer['id'])."'";
                    $this->dbReconnect();
                    foreach($this->dbL->executeSELECT($sqlSELECT) as $temp)
                    {
                        $customer[$temp['customid']] = $temp['value'];
                    }
                    $BL->REQUEST['email'] = $customer['email'];
                    $BL->REQUEST['name']  = $customer['firstname']." ".$customer['lastname '];
                    if(!empty($customer['organization']))
                    {
                        $BL->REQUEST['name'] .= " - ".$customer['organization'];
                    }
                    $BL->REQUEST['date']      = $customer['dateActivated'];
                    $BL->REQUEST['address']   = $customer[$BL->REQUEST['f_address']];
                    $BL->REQUEST['city']      = $customer[$BL->REQUEST['f_city']];
                    $BL->REQUEST['state']     = $customer[$BL->REQUEST['f_state']];
                    $BL->REQUEST['zip']       = $customer[$BL->REQUEST['f_zip']];
                    $BL->REQUEST['country']   = $customer[$BL->REQUEST['f_country']];
                    $BL->REQUEST['telephone'] = $customer[$BL->REQUEST['f_telephone']];
                    $BL->dbReconnect();
                    $insert_id = $BL->customers->add($BL->customfields->getAvailable());
                    $existing_customer_emails[] = $customer['email'];
                }
            }
            return $existing_customer_emails;
        }
        /*
        * function import orders
        */
        function importOrders(& $BL)
        {
            $sqlSELECT = "SELECT `domains`.*,`users`.email,`package`.planname FROM `domains` " .
            "LEFT JOIN `users`   ON `domains`.CustomerID  = `users`.id " .
            "LEFT JOIN `package` ON `domains`.Plan        = `package`.id";
            $this->dbReconnect();
            $domains  = $this->dbL->executeSELECT($sqlSELECT);
            $e_orders = array();
            $BL->dbReconnect();
            foreach($BL->orders->get() as $e)
            {
                $id = $e['sub_id'];
                $e_orders[$id] = $e['domain_name'];
            }
            foreach($domains as $domain)
            {
                $temp = $BL->customers->find(array("WHERE `email`='".$BL->utils->quoteSmart($domain['email'])."'"));
                $BL->REQUEST['id']     = $temp[0]['id'];
                $BL->REQUEST['domain_name'] = trim($domain['DomainName']);
                list($BL->REQUEST['sld'],$BL->REQUEST['tld']) = explode('.',$BL->REQUEST['domain_name'],2);
                if(array_search($BL->REQUEST['domain_name'],$e_orders)===false || empty($BL->REQUEST['domain_name']))
                {
                    $sqlSELECT = "SELECT * FROM `package_variable` WHERE `packageid` = '".intval($domain['Plan'])."' AND `value`!=''";
                    $this->dbReconnect();
                    $temp = $this->dbL->executeSELECT($sqlSELECT);
                    $BL->REQUEST['product_id'] = $temp[0]['value'];
                    if(empty($temp[0]['value']))
                    {
                        $BL->REQUEST['product_id'] = $domain['planname'];
                    }
                    $BL->REQUEST['bill_cycle']     = $domain['paymentterm'];
                    $BL->REQUEST['dom_reg_type']   = 0;
                    if(!empty($domain['recurring']) && !empty($domain['registration_years']))
                    {
                        $BL->REQUEST['dom_reg_type'] = 1;
                    }
                    $BL->REQUEST['cust_status']  = $BL->props->order_status[$domain['status']];
                    $BL->REQUEST['client_notes'] = $domain['Comments'];
                    $BL->REQUEST['dom_reg_year'] = $domain['registration_years'];
                    $BL->REQUEST['date']         = $domain['dateActivated'];
                    $BL->REQUEST['dom_user']     = $domain['UserName'];
                    $BL->REQUEST['dom_pass']     = $domain['password'];
                    $BL->dbReconnect();
                    $insert_id = $BL->orders->add($BL->REQUEST['id']);
                    $sql       = "INSERT INTO {$BL->props->tbl_ord_inv_recs} VALUES(".intval($insert_id).",'".$domain['nextbilldate']."')";
                    if($insert_id)
                    {
                        $BL->dbL->executeINSERT($sql);
                    }
                    $e_orders[] = $BL->REQUEST['domain'];
                }
            }
            return $e_orders;
        }
        /*
        * function import invoices
        */
        function importInvoices(& $BL,$e_orders)
        {
            foreach($e_orders as $k=>$v)
            {
                $e_ord[$v]=$k;
            }

            $sqlSELECT = "SELECT `invoice`.*,`invoiceentry`.detail,`invoiceentry`.invoiceid,`invoicetransaction`.transactionid, `users`.email FROM `invoice` " .
            "LEFT JOIN `invoiceentry` ON `invoice`.id = `invoiceentry`.invoiceid " .
            "LEFT JOIN `users` ON `users`.id = `invoice`.customerid " .
            "LEFT JOIN `invoicetransaction` ON `invoice`.id = `invoicetransaction`.invoiceid";
            $this->dbReconnect();
            $invoices  = $this->dbL->executeSELECT($sqlSELECT);

            foreach($invoices as $inv)
            {
                //get the order id
                $sub_id = 0;
                preg_match("/^[a-zA-Z0-9-]+\.[a-zA-Z0-9.]{2,10}/", $inv['detail'], $matches1);//domain
                preg_match("/^[a-zA-Z0-9-]+\.[a-zA-Z0-9-]+\.[a-zA-Z0-9.]{2,10}/", $inv['detail'], $matches2);//sub domain

                foreach($matches1 as $m)
                {
                    if(!$sub_id)
                    {
                        $m      = trim($m);
                        $sub_id = $e_ord[$m];
                    }
                }
                foreach($matches2 as $m)
                {
                    if(!$sub_id)
                    {
                        $m      = trim($m);
                        $sub_id = $e_ord[$m];
                    }
                }
                if(!$sub_id)
                {
                    $BL->dbReconnect();
                    $temp       = $BL->orders->get("WHERE `customers`.email = '".$BL->utils->quoteSmart($inv['email'])."'");
                    $sub_id     = $temp[0]['sub_id'];
                }
                $BL->REQUEST['desc']        = $inv['description'];
                $BL->REQUEST['net_amount']  = $inv['amount']-$inv['tax'];
                $BL->REQUEST['tax_amount']  = $inv['tax'];
                $BL->REQUEST['gross_amount']= $inv['amount'];
                $BL->REQUEST['due_date']    = $inv['billdate'];
                $BL->REQUEST['status']      = $BL->props->invoice_status[$inv['paid']];
                $BL->REQUEST['sub_id']      = $sub_id;
                $BL->REQUEST['pay_text']    = $inv['detail'];
                if($sub_id)$insert_id = $BL->invoices->add($BL->REQUEST['sub_id']);
            }
            return;
        }
    }
?>
