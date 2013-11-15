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
 
class invoices extends model
{
	var $tableName = "invoices";
    function del($invoice_no)
    {
        return $this->update(array("status"=>$this->props->invoice_status[4],"invoice_no"=>$invoice_no));
    }
    function add($order_id)
    {
    	if($this->REQUEST['gross_amount']==0)
        {
        	$this->REQUEST['status'] = $this->props->invoice_status[1];
        }
        $invoice_id = $this->insert($this->REQUEST);
        if($invoice_id)
        {
        	$sql = "INSERT INTO `orders_invoices` VALUES('".$order_id."','".$invoice_id."')";
            $this->dbL->executeINSERT($sql);
        }
        return $invoice_id;
    }
    function get($condition="")
    {
    	$sql = "LEFT JOIN  `orders_invoices` ON `orders_invoices`.invoice_id   = `invoices`.invoice_no "       .
               "LEFT JOIN `customers_orders` ON `customers_orders`.order_id    = `orders_invoices`.order_id "  .
               "LEFT JOIN `orders`           ON `orders_invoices`.order_id     = `orders`.sub_id "             .
               "LEFT JOIN `customers`        ON `customers_orders`.customer_id = `customers`.id "              .
               $condition;
        return $this->find(array($sql));
    }
    function getByStatus($status, $filter='')
    {
        if(empty($status))
        {
            return $this->get("WHERE `status`!='".$this->props->invoice_status[4]."' ".$filter);
        }
        return $this->get("WHERE `status`='".$status."' ".$filter);
    }
}
?>
