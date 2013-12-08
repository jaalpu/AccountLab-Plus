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
    * A class to generate all reports
    * reports Version 1.0
    */
    class report_controller extends controller
    {
        var $sort = "";
        var $limit= "";
        var $rFromDate = '0000-00-00';
        var $rToDate   = '0000-00-00';
        var $rAllDate  = false;
        var $rColumns  = array();
        /*
        * Set report parameters
        */
        function setParam()
        {
            $this->rFromDate = '0000-00-00';
            $this->rToDate   = date('Y-m-d');
            $this->rAllDate  = false;
            $this->rColumns  = array();
        }
        /*
        * Function to get invoice report
        */
        function invoiceReport($status="")
        {
            $condition = "";
            if(!empty($status) && !$this->rAllDate)
            {
                $condition = " AND {$this->props->tbl_invoices}.`due_date` >= '".$this->utils->quoteSmart($this->rFromDate)."' AND {$this->props->tbl_invoices}.`due_date` <= '".$this->utils->quoteSmart($this->rToDate)."' AND {$this->props->tbl_invoices}.`status` = '".$this->utils->quoteSmart($status)."'";
            }
            elseif(!empty($status) && $this->rAllDate)
            {
                $condition = " AND {$this->props->tbl_invoices}.`status` = '".$this->utils->quoteSmart($status)."'";
            }
            elseif(!$this->rAllDate)
            {
                $condition = " AND {$this->props->tbl_invoices}.`due_date` >= '".$this->utils->quoteSmart($this->rFromDate)."' AND {$this->props->tbl_invoices}.`due_date` <= '".$this->utils->quoteSmart($this->rToDate)."'";
            }
            $sql = "SELECT * FROM {$this->props->tbl_invoices} "                                                                                                          .
            "LEFT  JOIN {$this->props->tbl_orders_invoices}  ON {$this->props->tbl_orders_invoices}.invoice_id   = {$this->props->tbl_invoices}.invoice_no "       .
            "LEFT  JOIN {$this->props->tbl_orders}           ON {$this->props->tbl_orders_invoices}.order_id     = {$this->props->tbl_orders} .sub_id "            .
            "LEFT  JOIN {$this->props->tbl_customers_orders} ON {$this->props->tbl_customers_orders}.order_id    = {$this->props->tbl_orders_invoices}.order_id "  .
            "LEFT  JOIN {$this->props->tbl_customers}        ON {$this->props->tbl_customers_orders}.customer_id = {$this->props->tbl_customers}.id "              .
            "WHERE      {$this->props->tbl_invoices}.`status`!='Deleted'".$condition;
            $data = array();
            $temp = $this->dbL->executeSELECT($sql);
            foreach($temp as $k=>$inv)
            {
                foreach($this->rColumns as $c)
                {
                    $data[$k][$c] = $inv[$c];
                }
            }
            return $data;
        }
        /*
        * Function to get sales report
        */
        function salesReport($status="")
        {
            if(!empty($status) && !$this->rAllDate)
            {
                $condition = "AND           {$this->props->tbl_orders}.`sign_date` >= '".$this->utils->quoteSmart($this->rFromDate)."'       ".
                "AND           {$this->props->tbl_orders}.`sign_date` <= '".$this->utils->quoteSmart($this->rToDate)."'         ".
                "AND           {$this->props->tbl_orders}.`cust_status`='".$this->utils->quoteSmart($status)."'                 ".
                "AND			{$this->props->tbl_orders}.`order_deleted` != '1'                  ".
                "GROUP BY      {$this->props->tbl_orders}.`sub_id`";
            }
            if(!empty($status) && $this->rAllDate)
            {
                $condition = "AND           {$this->props->tbl_orders}.`cust_status`='".$this->utils->quoteSmart($status)."'                 ".
                "AND           {$this->props->tbl_orders}.`order_deleted` != '1'                  ".
                "GROUP BY      {$this->props->tbl_orders}.`sub_id`";
            }
            elseif(!$this->rAllDate)
            {
                $condition = "AND           {$this->props->tbl_orders}.`sign_date` >= '".$this->utils->quoteSmart($this->rFromDate)."'       ".
                "AND           {$this->props->tbl_orders}.`sign_date` <= '".$this->utils->quoteSmart($this->rToDate)."'         ".
                "AND           {$this->props->tbl_orders}.`order_deleted` != '1'                  ".
                "GROUP BY      {$this->props->tbl_orders}.`sub_id`";
            }
            else
            {
                $condition = "AND           {$this->props->tbl_orders}.`order_deleted` != '1'                  ".
                "GROUP BY      {$this->props->tbl_orders}.`sub_id`";
            }

            $sql = "SELECT     {$this->props->tbl_customers}.*, {$this->props->tbl_orders}.*, SUM({$this->props->tbl_invoices}.`gross_amount`) as `amt` " .
            "FROM       {$this->props->tbl_orders} " .
            "LEFT  JOIN {$this->props->tbl_customers_orders} ON {$this->props->tbl_customers_orders}.order_id    = {$this->props->tbl_orders}.sub_id " .
            "LEFT  JOIN {$this->props->tbl_customers}        ON {$this->props->tbl_customers_orders}.customer_id = {$this->props->tbl_customers}.id  " .
            "LEFT  JOIN {$this->props->tbl_orders_invoices}  ON {$this->props->tbl_orders_invoices}.order_id     = {$this->props->tbl_orders}.sub_id " .
            "LEFT  JOIN {$this->props->tbl_invoices}         ON {$this->props->tbl_invoices}.invoice_no          = {$this->props->tbl_orders_invoices}.invoice_id  " .
            "WHERE      {$this->props->tbl_invoices}.`status`!='Deleted' ".
            $condition;
            $data = array();
            $temp = $this->dbL->executeSELECT($sql);
            foreach($temp as $k=>$ord)
            {
                foreach($this->rColumns as $c)
                {
                    $data[$k][$c] = $ord[$c];
                }
            }
            return $data;
        }
    }
?>
