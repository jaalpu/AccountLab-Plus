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

    class addons extends model
    {
        var $tableName = "addons";
        var $indexname='addon_index';
        var $keyname='addon_id';
        function updateBillingCycles($addon_id,$data=array())
        {
            $sql = "DELETE FROM `billings_products` WHERE `product_id`='".$addon_id."' AND `product_table`='addons'";
            $this->dbL->executeDELETE($sql);
            foreach($this->dbL->executeSELECT("SELECT * FROM `billing_cycles`") as $cycle)
            {
                $sql = "INSERT INTO `billings_products` VALUES('".$cycle['id']."',".intval($addon_id).",'addons','".$this->utils->quoteSmart($data[$cycle['cycle_name']])."')";
                $this->dbL->executeINSERT($sql);
            }
        }
        function getAvailable($product_id)
        {
            $addon_ids = array();
            $sql         = "SELECT `addons`.`addon_id` FROM `products_addons` LEFT JOIN `addons` ON `addons`.`addon_id`=`products_addons`.`addon_id` WHERE `product_id`=".intval($product_id)." ".$this->orderby;
            $temp        = $this->query($sql);
            foreach($temp as $t)
            {
                $addon_ids[] = $t['addon_id'];
            }
            return $addon_ids;
        }
        function getCycles($addon_id)
        {
            $data_array = array();
            foreach($this->query("SELECT * FROM `billing_cycles` ORDER BY `cycle_month`") as $cycle)
            {
                $sql = "SELECT * FROM `billings_products`
                WHERE `product_id` = ".intval($addon_id)." AND `product_table`='addons' AND `billing_id`='".$cycle['id']."'";
                $temp_data = $this->query($sql);
                $data_array[$cycle['cycle_name']] = isset($temp_data[0]['amount'])?$temp_data[0]['amount']:0;
            }
            return $data_array;
        }
        function getInvoiceAddonStringData($string)
        {
            $Addons = array();
            $temp1  = explode("<&>",$this->utils->htmlspecialchars_decode($string));
            $this->utils->Remove_Empty_Elements($temp1);
            foreach($temp1 as $string)
            {
                $temp2 = explode(">",$this->utils->htmlspecialchars_decode($string),3);
                if(isset($temp2[0]) && !empty($temp2[0]))
                {
                    $temp3 = $this->hasAnyOne(array("WHERE `addon_name`='".$this->utils->quoteSmart($temp2[0])."'"));
                    $Addons[$temp2[0]]['ADDON_ID'] = $temp3['addon_id'];
                    $Addons[$temp2[0]]['SETUP']    = $temp2[1];
                    $Addons[$temp2[0]]['CYCLE']    = $temp2[2];
                }
            }
            return $Addons;
        }
    }
?>
