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

    class taxes extends model
    {
        var $tableName = "taxes";
        function moveUp($tax_id,$tax_index)
        {
            $tax_index1 = $tax_index - 1;
            $sql        = "UPDATE ".$this->tableName." SET `tax_index` = ".intval($tax_index)." WHERE `tax_index` = ".intval($tax_index1);
            $this->dbL->executeUPDATE($sql);
            $sql        = "UPDATE ".$this->tableName." SET `tax_index` = ".intval($tax_index1)." WHERE `tax_id`=".intval($tax_id);
            $this->dbL->executeUPDATE($sql);
        }
        function moveDown($tax_id,$tax_index)
        {
            $tax_index1 = $tax_index + 1;
            $sql        = "UPDATE ".$this->tableName." SET `tax_index` = ".intval($tax_index)." WHERE `tax_index` = ".intval($tax_index1);
            $this->dbL->executeUPDATE($sql);
            $sql        = "UPDATE ".$this->tableName." SET `tax_index` = ".intval($tax_index1)." WHERE `tax_id`=".intval($tax_id);
            $this->dbL->executeUPDATE($sql);
        }
        function getAvailable()
        {
            $country = $this->utils->quoteSmart($this->REQUEST['country']);
            $state   = $this->utils->quoteSmart($this->REQUEST['state']);
            if (!empty ($country))
            {
                $condition= "WHERE (`tax_country` = 'ALL' OR `tax_country`   LIKE    '%$country%') AND `tax_enable` = '1' ORDER BY `tax_index` ASC";
            }
            else
            {
                $condition= "WHERE `tax_enable` = '1' ORDER BY `tax_index` ASC";
            }
            $taxes  = array();
            $temp   = $this->find(array($condition));
            foreach ($temp as $k => $v)
            {
                if (empty ($v['tax_state']) || preg_match("/ALL/", $v['tax_state']) || $v['tax_state'] == "|" || empty($state) || preg_match("/$state/", $v['tax_state']))
                {
                    $taxes[] = $v;
                }
            }
            return $taxes;
        }
        function calculateTax($sub_total, $country= "", $state= "", $force_tax_array=array())
        {
            //populate this values to post
            $this->REQUEST['country'] = $country;
            $this->REQUEST['state']   = $state;
            //tax calculation
            $all_taxes          = count($force_tax_array)?$force_tax_array:$this->getAvailable();
            $floating_sub_total = $sub_total;
            $tax_amount         = array();
            $tax_amt_name       = array();
            $tax_percent        = array();
            $tax_name           = array();
            $tax_sign           = array();
            $tax_string         = "|";
            $total_tax_amount   = 0;
            for ($i= 0; $i < count($all_taxes); $i++)
            {
                $tax_percent[$i]= $all_taxes[$i]['tax_amount'];
                $tax_sign[$i]   = "+";
                if ($all_taxes[$i]['tax_add_sub'] == "S")
                {
                    $tax_sign[$i]= "-";
                }
                $tax_name[$i]   = $all_taxes[$i]['tax_name'];
                $tax_amount[$i] = $floating_sub_total * ($tax_percent[$i] / 100);
                if ($all_taxes[$i]['tax_net_comp'] == "N")
                {
                    $tax_amount[$i]= $sub_total * ($tax_percent[$i] / 100);
                }
                if ($tax_sign[$i] == "-")
                {
                    $floating_sub_total = $floating_sub_total - $tax_amount[$i];
                    $total_tax_amount   = $total_tax_amount - $tax_amount[$i];
                }
                else
                {
                    $floating_sub_total = $floating_sub_total + $tax_amount[$i];
                    $total_tax_amount   = $total_tax_amount + $tax_amount[$i];
                }
                $tax_amt_name[$all_taxes[$i]['tax_name']] = $tax_sign[$i].$tax_amount[$i];
                $tax_string .= $tax_percent[$i] . "<&>" . $tax_amount[$i] . "<&>" . $tax_name[$i] . "<&>" . $tax_sign[$i] . "<&>" . $all_taxes[$i]['tax_net_comp'] . "|";
            }
            $r_array['all_taxes']           = $all_taxes;
            $r_array['floating_sub_total']  = $floating_sub_total;
            $r_array['tax_percent']         = $tax_percent;
            $r_array['tax_name']            = $tax_name;
            $r_array['tax_sign']            = $tax_sign;
            $r_array['tax_string']          = $tax_string;
            $r_array['total_tax_amount']    = $total_tax_amount;
            $r_array['tax_amount']          = $tax_amount;
            $r_array['tax_amt_name']        = $tax_amt_name;
            return $r_array;
        }
    }
?>
