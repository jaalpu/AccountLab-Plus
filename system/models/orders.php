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

    class orders extends model
    {
        var $tableName = "orders";
        function edit($order_id)
        {
            $this->REQUEST['domain_name'] = $this->REQUEST['sld'].".".$this->REQUEST['tld'];
            $this->REQUEST['dom_pass'] = $this->utils->alpencrypt->encrypt($this->REQUEST['dom_pass'], $this->props->encryptionKey);
            $this->REQUEST['addon_ids']   = isset($this->REQUEST['addon_ids'])?$this->REQUEST['addon_ids']:array();
            $this->REQUEST['server_id']   = isset($this->REQUEST['server_id'])?$this->REQUEST['server_id']:0;
            $this->REQUEST['ip_id']       = isset($this->REQUEST['ip_id'])?$this->REQUEST['ip_id']:0;
            $this->update($this->REQUEST);

            $sql = "DELETE FROM `orders_addons` WHERE `sub_id`=".intval($order_id);
            $this->dbL->executeDELETE($sql);
            $sql = "DELETE FROM `orders_servers_ips` WHERE `sub_id`=".intval($order_id);
            $this->dbL->executeDELETE($sql);

            foreach($this->REQUEST['addon_ids'] as $addon_id)
            {
                $activation_date = isset($this->REQUEST['addon_dates'])?$this->REQUEST['addon_dates'][$addon_id]:date('Y-m-d');
                $sql = "INSERT INTO `orders_addons` VALUES(".intval($order_id).",".intval($addon_id).",'".$this->utils->quoteSmart($activation_date)."')";
                $this->dbL->executeINSERT($sql);
            }

            if(isset($this->REQUEST['server_id']) && isset($this->REQUEST['ip_id']))
            {
                $sql = "INSERT INTO `orders_servers_ips` VALUES(".intval($order_id).",".intval($this->REQUEST['server_id']).",".intval($this->REQUEST['ip_id']).",0)";
                $this->dbL->executeINSERT($sql);
            }

            return $order_id;
        }
        function add($customer_id)
        {
            $this->REQUEST['cust_status'] = isset($this->REQUEST['cust_status'])?$this->REQUEST['cust_status']:$this->props->order_status[0];
            $this->REQUEST['domain_name'] = $this->REQUEST['sld'].".".$this->REQUEST['tld'];
            $this->REQUEST['dom_pass'] = $this->utils->alpencrypt->encrypt($this->REQUEST['dom_pass'], $this->props->encryptionKey);
            $this->REQUEST['sign_date']   = isset($this->REQUEST['sign_date'])?$this->REQUEST['sign_date']:date('Y-m-d');
            $this->REQUEST['addon_ids']   = isset($this->REQUEST['addon_ids'])?$this->REQUEST['addon_ids']:array();
            $this->REQUEST['server_id']   = isset($this->REQUEST['server_id'])?$this->REQUEST['server_id']:0;
            $this->REQUEST['ip_id']       = isset($this->REQUEST['ip_id'])?$this->REQUEST['ip_id']:0;
            $order_id = $this->insert($this->REQUEST);
            if($order_id)
            {
                $sql = "INSERT INTO `customers_orders` VALUES(".intval($customer_id).",".intval($order_id).")";
                $this->dbL->executeINSERT($sql);

                foreach($this->REQUEST['addon_ids'] as $addon_id)
                {
                    $activation_date = isset($this->REQUEST['addon_dates'])?$this->REQUEST['addon_dates'][$addon_id]:date('Y-m-d');
                    $sql = "INSERT INTO `orders_addons` VALUES(".intval($order_id).",".intval($addon_id).",'".$this->utils->quoteSmart($activation_date)."')";
                    $this->dbL->executeINSERT($sql);
                }
                if(isset($this->REQUEST['server_id']) && isset($this->REQUEST['ip_id']))
                {
                    $sql = "INSERT INTO `orders_servers_ips` VALUES(".intval($order_id).",".intval($this->REQUEST['server_id']).",".intval($this->REQUEST['ip_id']).",0)";
                    $this->dbL->executeINSERT($sql);
                }
            }
            return $order_id;
        }
        function del($sub_id)
        {
            return $this->update(array("order_deleted"=>1,"sub_id"=>$sub_id));
        }
        function get($condition="")
        {
            $sql = "LEFT  JOIN `customers_orders`   ON `customers_orders`.order_id    = `orders`.sub_id " .
            "LEFT  JOIN `customers`          ON `customers_orders`.customer_id = `customers`.id  " .
            "LEFT  JOIN `ord_inv_recs`       ON `ord_inv_recs`.rec_ord_id      = `orders`.sub_id " .
            "LEFT  JOIN `orders_servers_ips` ON `orders_servers_ips`.sub_id    = `orders`.sub_id " .
            $condition;
            return $this->find(array($sql));
        }
        function getAddons($order_id)
        {
            $sql = "SELECT * FROM `orders_addons` WHERE `sub_id`=".intval($order_id);
            return $this->dbL->executeSELECT($sql);
        }
        function getByStatus($status)
        {
            return $this->get("WHERE `order_deleted`='0' AND `cust_status`='".$this->utils->quoteSmart($status)."'");
        }
        /*
        * recurring data
        */
        function recurring_data($sub_id, $cycle, $do= "INSERT", $date1= "", $date2= "")
        {
            $date = getdate();
            if (!empty ($date1) && $this->utils->checkDateFormat($date1))
            {
                $date = $this->utils->getDateArray($date1);
            }
            if (!empty ($cycle) && $do == "INSERT")
            {
                $date = $this->utils->getXmonthsAfter($cycle, $date);
                if (!empty ($date2) && $this->utils->checkDateFormat($date2))
                {
                    $date = $this->utils->getDateArray($date2);
                }
                $next_date= $date['year'] . "-" . $date['mon'] . "-" . $date['mday'];
                $sql      = "INSERT INTO `ord_inv_recs` (`rec_ord_id`, `rec_next_date`)" .
                "VALUES (" . intval($sub_id) . ",'" . $next_date . "')";
                return $this->dbL->executeINSERT($sql);
            }
            elseif ($do == "DELETE")
            {
                $sql = "DELETE FROM `ord_inv_recs` WHERE `rec_ord_id`=" . intval($sub_id);
                return $this->dbL->executeDELETE($sql);
            }
            elseif ($do == "UPDATE")
            {
                $order= $this->getByKey($sub_id);
                $cycle= empty ($order['bill_cycle'])?12:$order['bill_cycle'];
                $date = $this->utils->getXmonthsAfter($cycle, $date);
                $next_date= $date['year'] . "-" . $date['mon'] . "-" . $date['mday'];
                $sql  = "UPDATE `ord_inv_recs` SET `rec_next_date`='" . $next_date . "' WHERE `rec_ord_id`=" . intval($sub_id);
                return $this->dbL->executeUPDATE($sql);
            }
            else
            {
                $sql = "SELECT * FROM `ord_inv_recs` WHERE `rec_ord_id`=" . intval($sub_id);
                $temp= $this->dbL->executeSELECT($sql);
                return $temp[0];
            }
        }
    }
?>
