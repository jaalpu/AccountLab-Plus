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

    class subdomains extends model
    {
        var $tableName = "subdomains";
        function getAvailable()
        {
            return $this->find();
        }
        function updateBillingCycles($main_id,$data=array())
        {
            $sql = "DELETE FROM `billings_products` WHERE `product_id`=".intval($main_id)." AND `product_table`='subdomains'";
            $this->dbL->executeDELETE($sql);
            foreach($this->dbL->executeSELECT("SELECT * FROM `billing_cycles`") as $cycle)
            {
                $sql = "INSERT INTO `billings_products` VALUES(".$cycle['id'].",".intval($main_id).",'subdomains','".$this->utils->quoteSmart($data[$cycle['cycle_name']])."')";
                $this->dbL->executeINSERT($sql);
            }
        }
        function getCycles($main_id)
        {
            $data_array = array();
            foreach($this->query("SELECT * FROM `billing_cycles` ORDER BY `cycle_month`") as $cycle)
            {
                $sql = "SELECT * FROM `billings_products`
                WHERE `product_id` = ".intval($main_id)." AND `product_table`='subdomains' AND `billing_id`=".intval($cycle['id']);
                $temp_data = $this->query($sql);
                $data_array[$cycle['cycle_name']] = isset($temp_data[0]['amount'])?$temp_data[0]['amount']:0;
            }
            return $data_array;
        }
        function isAvailable($sld,$tld)
        {
            if (!$this->utils->chksubDomainFormat($sld . "." . $tld))
            {
                return "<b>" . $this->props->lang['err_domain'] . "</b>";
            }
            if(!count($this->find()))
            {
                return 0;
            }
            $temp      = $sld . "." . $tld;
            $sqlSELECT = "SELECT * FROM `orders` WHERE domain_name='".$this->utils->quoteSmart($temp)."' AND `order_deleted`!='1'";
            if (count($this->dbL->executeSELECT($sqlSELECT)))
            {
                return 0;
            }
            if (count($this->find(array("WHERE `reserved_names` LIKE '%".$this->utils->quoteSmart($sld)."%' && `maindomain`='".$this->utils->quoteSmart($tld)."'"))))
            {
                return 0;
            }
            return 1;
        }
    }
?>
