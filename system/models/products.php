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

    class products extends model
    {
        var $tableName = "products";
        var $indexname='plan_index';
        var $keyname='plan_price_id';
        function updateBillingCycles($product_id,$data=array())
        {
            $sql = "DELETE FROM `billings_products` WHERE `product_id`=".intval($product_id)." AND `product_table`='products'";
            $this->dbL->executeDELETE($sql);
            foreach($this->dbL->executeSELECT("SELECT * FROM `billing_cycles`") as $cycle)
            {
                $sql = "INSERT INTO `billings_products` VALUES(".intval($cycle['id']).",".intval($product_id).",'products','".$this->utils->quoteSmart($data[$cycle['cycle_name']])."')";
                $this->dbL->executeINSERT($sql);
            }
        }
        function updateAssociatedGroups($product_id,$groups=array())
        {
            $sql = "DELETE FROM `groups_products` WHERE `product_id`=".intval($product_id);
            $this->dbL->executeDELETE($sql);
            foreach($groups as $group_id)
            {
                $sql = "INSERT INTO `groups_products` VALUES(".intval($group_id).",".intval($product_id).")";
                $this->dbL->executeINSERT($sql);
            }
        }
        function updateAssociatedAddons($product_id,$addons=array())
        {
            $sql = "DELETE FROM `products_addons` WHERE `product_id`=".intval($product_id);
            $this->dbL->executeDELETE($sql);
            foreach($addons as $addon_id)
            {
                $sql = "INSERT INTO `products_addons` VALUES(".intval($product_id).",".intval($addon_id).")";
                $this->dbL->executeINSERT($sql);
            }
        }
        function updateAssociatedServers($product_id,$servers=array())
        {
            $sql = "DELETE FROM `products_servers` WHERE `package_id`=".intval($product_id);
            $this->dbL->executeDELETE($sql);
            foreach($servers as $server_id=>$rotation_index)
            {
                $sql = "INSERT INTO `products_servers` VALUES(".intval($product_id).",".intval($server_id).",".intval($rotation_index).")";
                $this->dbL->executeINSERT($sql);
            }
        }
        function getAdditionalServers($product_id)
        {
            $server_ids  = array();
            $sql         = "SELECT * FROM `products_servers` WHERE `package_id`=".intval($product_id);
            $temp        = $this->query($sql);
            foreach($temp as $t)
            {
                $server_ids[$t['server_id']] = $t['rotation_index'];
            }
            return $server_ids;
        }
        function getAssociatedGroups($product_id)
        {
            $group_ids = array();
            $sql       = "SELECT `group_id` FROM `groups_products` WHERE `product_id`=".intval($product_id);
            $temp      = $this->query($sql);
            foreach($temp as $t)
            {
                $group_ids[] = $t['group_id'];
            }
            return $group_ids;
        }
        function getAvailable($group_id)
        {
            $product_ids = array();
            $sql         = "SELECT `product_id` FROM `groups_products` WHERE `group_id`=".intval($group_id);
            $temp        = $this->query($sql);
            foreach($temp as $t)
            {
                $product_ids[] = $t['product_id'];
            }
            if(!count($product_ids))
            {
                $temp = $this->find();
                foreach($temp as $t)
                {
                    $product_ids[] = $t['plan_price_id'];
                }
            }
            return $product_ids;
        }
        function getCycles($product_id)
        {
            $data_array = array();
            foreach($this->dbL->executeSELECT("SELECT * FROM `billing_cycles` ORDER BY `cycle_month`") as $cycle)
            {
                $sql = "SELECT * FROM `billings_products`
                WHERE `product_id` = ".intval($product_id)." AND `product_table`='products' AND `billing_id`='".$cycle['id']."'";
                $temp_data = $this->query($sql);
                $data_array[$cycle['cycle_name']] = isset($temp_data[0]['amount'])?$temp_data[0]['amount']:0;
            }
            return $data_array;
        }
        function getServerForProduct($product_id)
        {
            $product = $this->find(array("WHERE `plan_price_id`=".intval($product_id)));
            if(!isset($product[0]['server_id']) || empty($product[0]['server_id']))
            {
                $temp = $this->query("SELECT * FROM `servers` WHERE `server_default`='default'");
            }
            else
            {
                $temp = $this->query("SELECT * FROM `servers` WHERE `server_id`=".intval($product[0]['server_id']));
            }
            $server_default = $temp[0];
            if ($server_default['maximum_accounts'] > 0 && $server_default['maximum_accounts'] <= $server_default['current_accounts'])
            {
                if ($product[0]['en_server_rotation'] == 1)
                {
                    $addi_servers = $this->query(array("SELECT * FROM `products_servers` WHERE `package_id` =".intval($product_id)." ORDER BY `rotation_index`"));
                    foreach ($addi_servers as $addi_server)
                    {
                        $server_id   = $addi_server['server_id'];
                        $temp        = $this->query("SELECT * FROM `servers` WHERE `server_id`=".intval($server_id));
                        $server_temp = $temp[0];
                        if ($server_temp['maximum_accounts'] == 0 || $server_temp['maximum_accounts'] > $server_temp['current_accounts'])
                        {
                            $server_default = $server_temp;
                            break;
                        }
                    }
                }
            }
            return $server_default;
        }
        function getProductId($prod)
        {
            $temp = $this->hasAnyOne(array("WHERE `plan_name`='".$this->utils->quoteSmart($prod)."'"));
            return isset($temp['plan_price_id'])?$temp['plan_price_id']:(is_numeric($prod)?$prod:0);//because $prod can me product id too{this is bad coding}
        }
        function getFriendlyName($product_name_or_id)
        {
            $temp = $this->hasAnyOne(array("WHERE `plan_price_id`='".$this->utils->quoteSmart($product_name_or_id)."' OR `plan_name`='".$this->utils->quoteSmart($product_name_or_id)."'"));
            if(!empty ($temp['plan_friendly_name']))return $temp['plan_friendly_name'];
            elseif(!empty ($temp['plan_name']))return $temp['plan_name'];
            else return $product_name_or_id;
        }
    }
?>
