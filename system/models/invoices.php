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
                $sql = "INSERT INTO `orders_invoices` VALUES(".intval($order_id).",".intval($invoice_id).")";
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
                return $this->get("WHERE `status`!='".$this->utils->quoteSmart($this->props->invoice_status[4])."' ".$filter);
            }
            return $this->get("WHERE `status`='".$status."' ".$filter);
        }

        /*
        * Calculate everything while ordering
        */
        function calcuateAll($recurring= false,$calculate_special=true, $ORDER_DATA=array())
        {
            if(!count($ORDER_DATA))
            {
                $ORDER_DATA = array();
                foreach($_SESSION as $key=>$val)
                {
                    $ORDER_DATA[$key]=$val;
                }
            }
            $group_id   = !empty($ORDER_DATA['group_id'])?$ORDER_DATA['group_id']:0;
            $product_id = !empty($ORDER_DATA['product_id'])?$ORDER_DATA['product_id']:0;
            $addon_ids  = is_array($ORDER_DATA['addon_ids'])?$ORDER_DATA['addon_ids']:array();
            $cycle_month= !empty($ORDER_DATA['bill_cycle'])?$ORDER_DATA['bill_cycle']:12;
            $sld        = !empty($ORDER_DATA['sld'])?$ORDER_DATA['sld']:null;
            $tld        = !empty($ORDER_DATA['tld'])?$ORDER_DATA['tld']:null;
            $type       = !empty($ORDER_DATA['type'])?$ORDER_DATA['type']:3;
            $year       = !empty($ORDER_DATA['year'])?$ORDER_DATA['year']:1;
            $special_id = isset($ORDER_DATA['specials']['SELECTED'])?$ORDER_DATA['specials']['SELECTED'][0]:0;

            $payment_method = isset($_SESSION['payment_method'])?$_SESSION['payment_method']:$ORDER_DATA['pay_proc'];

            $customer = $ORDER_DATA['customer'];
            $customer['discount'] = 0;
            $customer['credit']   = 0;
            if($customer['member']=='1')
            {
                if(isset($customer['id']) && !empty($customer['id']))
                {
                    $customer = $this->BL->customers->getByKey($customer['id']);
                }
                else
                {
                    $customer = $this->BL->customers->hasAnyOne(array("WHERE `email`='".$this->utils->quoteSmart($customer['existing_email'])."'"));
                }
                $this->BL->customfields->setOrder("customfields_index");
                foreach($this->BL->customfields->getAvailable() as $customfield)
                {
                    $customer[$customfield['field_name']]= $this->BL->getCustomerFieldValue($customfield['field_name'],$customer['id']);
                }
                $customer['member'] = 1;
                $customer['disc_token_code'] = $ORDER_DATA['customer']['disc_token_code'];
                $customer['dom_user'] = $ORDER_DATA['customer']['dom_user'];
                $customer['dom_pass'] = $ORDER_DATA['customer']['dom_pass'];
            }

            /*
            * CALCULATION STARTS HERE
            */
            $INVOICE_DATA = array();
            $INVOICE_DATA['CUSTOMER_DATA'] = $customer;
            $INVOICE_DATA['ORDER_DATA']= $ORDER_DATA;
            $INVOICE_DATA['TAX_DATA'] = array();

            $INVOICE_DATA['debit_credit']   = '';
            $INVOICE_DATA['debit_credit_amount'] = 0;
            $INVOICE_DATA['debit_credit_reason'] = '';
            $INVOICE_DATA['setup_fee']      = 0;
            $INVOICE_DATA['cycle_fee']      = 0;
            $INVOICE_DATA['tld_fee']        = 0;
            $INVOICE_DATA['addon_fee']      = '<&>';
            $INVOICE_DATA['inv_tld_disc']   = 0;
            $INVOICE_DATA['inv_plan_disc']  = 0;
            $INVOICE_DATA['inv_addon_disc'] = 0;
            $INVOICE_DATA['tax_percent']    = '';
            $INVOICE_DATA['desc']           = $product_id."-".$sld.".".$tld;
            $INVOICE_DATA['due_date']       = isset($ORDER_DATA['due_date'])?$ORDER_DATA['due_date']:date('Y-m-d');
            $INVOICE_DATA['other_amount']   = 0;
            $INVOICE_DATA['net_amount']     = 0;
            $INVOICE_DATA['tax_amount']     = 0;
            $INVOICE_DATA['gross_amount']   = 0;
            $INVOICE_DATA['status']         = $this->props->invoice_status[0];
            $INVOICE_DATA['pay_text']       = '';
            $INVOICE_DATA['payment_method'] = $payment_method;
            $INVOICE_DATA['pay_curr_name']  = '';
            $INVOICE_DATA['pay_curr_symbol']= '';
            $INVOICE_DATA['pay_curr_factor']= 0;
            $INVOICE_DATA['pay_curr_decimal_number'] = 0;
            $INVOICE_DATA['pay_curr_decimal_str']    = 0;
            $INVOICE_DATA['pay_curr_thousand_str']   = 0;
            $INVOICE_DATA['pay_curr_symbol_prefixed']= 1;
            $INVOICE_DATA['prorate_desc']   = '';
            $INVOICE_DATA['prorate_amount'] = 0;

            $INVOICE_DATA['total_recurring_fee'] = 0;
            $INVOICE_DATA['next_bill_date'] = '';
            $INVOICE_DATA['discount_token_amount'] = 0;
            $INVOICE_DATA['discount_coupon_amount'] = 0;
            $INVOICE_DATA['customer_discount_amount'] = 0;
            $INVOICE_DATA['debit_credit_balance'] = 0;

            $group   = $this->BL->groups->getByKey($group_id);
            $cycle   = $this->props->cycles[$cycle_month];
            $special = $this->BL->specials->getByKey($special_id);
            $temp           = $this->BL->disc_token_codes->getByKey($customer['disc_token_code']);
            $discount_token = $this->BL->disc_tokens->getByKey(isset($temp['disc_token_id'])?$temp['disc_token_id']:0);
            $coupon         = $this->BL->coupons->hasAnyOne(array("WHERE `coupon_name`='".$this->utils->quoteSmart($customer['disc_token_code'])."'"));

            //STEP1  : CALCULATE THE BASE PRICE
            $product            = $this->BL->products->getByKey($product_id);
            $product_cycle_data = $this->BL->products->getCycles($product_id);
            $INVOICE_DATA['setup_fee'] = isset($product['host_setup_fee'])?$product['host_setup_fee']:0;
            $INVOICE_DATA['cycle_fee'] = isset($product_cycle_data[$cycle])?$product_cycle_data[$cycle]:0;

            $addons            = array();
            $addon_cycle_datas = array();
            foreach($addon_ids as $addon_id)
            {
                $addons[]                    = $this->BL->addons->getByKey($addon_id);
                $addon_cycle_datas[$addon_id]= $this->BL->addons->getCycles($addon_id);
            }
            $total_addon_price = 0;
            $total_addon_cycle_price = 0;
            foreach($addons as $addon)
            {
                $temp_str                   = $addon['addon_name'].">".$addon['addon_setup'].">".(($product['default_cycle']==0)?0:$addon_cycle_datas[$addon['addon_id']][$cycle])."<&>";
                $total_addon_price          = $total_addon_price + $addon['addon_setup'] + (($product['default_cycle']==0)?0:$addon_cycle_datas[$addon['addon_id']][$cycle]);
                $total_addon_cycle_price    = $total_addon_cycle_price + (($product['default_cycle']==0)?0:$addon_cycle_datas[$addon['addon_id']][$cycle]);
                $INVOICE_DATA['addon_fee'] .= $temp_str;
            }

            if($type==1)
            {
                $domain                  = $this->BL->tlds->hasAnyOne(array("WHERE `dom_ext`='".$this->utils->quoteSmart($tld)."' AND `dom_period`=".intval($year)));
                $INVOICE_DATA['tld_fee'] = $domain['dom_price'];
            }
            elseif($type==2)
            {
                $domain                  = $this->BL->subdomains->hasAnyOne(array("WHERE `maindomain`='".$this->utils->quoteSmart($tld)."'"));
                $domain_cycle_datas      = $this->BL->subdomains->getCycles($domain['main_id']);
                $INVOICE_DATA['tld_fee'] = $domain_cycle_datas[$cycle];
            }
            else
            {
                $domain                  = array();
                $INVOICE_DATA['tld_fee'] = 0;
            }
            $INVOICE_DATA['net_amount']  = $INVOICE_DATA['setup_fee'] + $INVOICE_DATA['cycle_fee'] + $INVOICE_DATA['tld_fee'] + $total_addon_price;
            //STEP2  : CALCULATE THE DISCOUNT BASED ON SPECIALS
            if(
                ($customer['discount']==0 || $customer['cumulative'])      &&
                isset($special['new_order'])                              &&
                empty($special['new_order'])                              &&
                empty($customer['disc_token_code'])                       &&
                $calculate_special
            )
            {
                $INVOICE_DATA['inv_tld_disc']   = (($special['special_tld_disc'] && $type==1) || ($special['special_subdom_disc'] && $type==2))?$special['special_net_disc']:0;
                $INVOICE_DATA['inv_plan_disc']  = ($special['special_plan_disc'] == "ALL")?$special['special_net_disc']:0;
                $INVOICE_DATA['inv_addon_disc'] = ($special['special_addon_disc'])?$special['special_net_disc']:0;
                $INVOICE_DATA['other_amount']   = $INVOICE_DATA['tld_fee']*($INVOICE_DATA['inv_tld_disc']/100)
                + ($INVOICE_DATA['setup_fee']+$INVOICE_DATA['cycle_fee'])*($INVOICE_DATA['inv_plan_disc']/100)
                + $total_addon_price*($INVOICE_DATA['inv_addon_disc']/100);
            }
            //STEP3  : CALCULATE THE DISCOUNT BASED ON DISCOUNT-TOKENS
            elseif(
                ($customer['discount']==0 || $customer['cumulative'])      &&
                $this->BL->conf['en_dt']                                      &&
                $discount_token['disc_token_discount']>0                  &&
                strtotime($discount_token['disc_token_valid'])>=time()
            )
            {
                $temp_discount = $discount_token['disc_token_discount'] / 100 ;
                $INVOICE_DATA['other_amount']   = $INVOICE_DATA['tld_fee']*(!empty($discount_token['disc_token_domain'])?$temp_discount:0)
                + ($INVOICE_DATA['setup_fee']+$INVOICE_DATA['cycle_fee'])*($temp_discount)
                + $total_addon_price*(!empty($discount_token['disc_token_addons'])?$temp_discount:0);
                $INVOICE_DATA['discount_token_amount'] = $INVOICE_DATA['other_amount'];
            }
            //STEP4  : CALCULATE THE DISCOUNT BASED ON COUPON-CODES
            elseif(
                ($customer['discount']==0 || $customer['cumulative'])      &&
                $this->BL->conf['en_cc']                                      &&
                isset($coupon['customer_use'])                            &&
                (empty($coupon['customer_use']) || ($customer['member']    && $coupon['customer_use']==2) || (!$customer['member'] && $coupon['customer_use']==1)) &&
                $coupon['coupon_discount']>0                              &&
                strtotime($coupon['coupon_valid'])>=time()                &&
                (empty($customer['member']) || ($customer['member']        && !count($this->BL->coupons->getUsedCoupons($customer['id'], $coupon['coupon_id']))))
            )
            {
                $temp_discount = $coupon['coupon_discount'] / 100 ;
                $INVOICE_DATA['other_amount']   = $INVOICE_DATA['tld_fee']*(!empty($coupon['coupon_domain'])?$temp_discount:0)
                + ($INVOICE_DATA['setup_fee']+$INVOICE_DATA['cycle_fee'])*($temp_discount)
                + $total_addon_price*(!empty($coupon['coupon_addons'])?$temp_discount:0);
                $INVOICE_DATA['discount_coupon_amount'] = $INVOICE_DATA['other_amount'];
            }
            //STEP5  : CALCULATE TOTAL RECURRING AMOUNT FOR NEXT BILLS
            $INVOICE_DATA['total_recurring_fee'] = 0;
            if(($type==1 && $year*12==$cycle_month) || $type!=1)
            {
                $INVOICE_DATA['total_recurring_fee'] = $INVOICE_DATA['tld_fee'];
            }
            $INVOICE_DATA['total_recurring_fee'] = $INVOICE_DATA['total_recurring_fee']
            + $INVOICE_DATA['cycle_fee']
            + $total_addon_cycle_price;
            if($this->BL->conf['include_sp_rec'])
            {
                if(($type==1 && $year*12==$cycle_month) || $type!=1)
                {
                    $INVOICE_DATA['total_recurring_fee'] = $INVOICE_DATA['total_recurring_fee']
                    + ($INVOICE_DATA['tld_fee']*($INVOICE_DATA['inv_tld_disc']/100));
                }
                $INVOICE_DATA['total_recurring_fee'] = $INVOICE_DATA['total_recurring_fee']
                + ($INVOICE_DATA['cycle_fee']*($INVOICE_DATA['inv_plan_disc']/100))
                + ($total_addon_cycle_price*($INVOICE_DATA['inv_addon_disc']/100));
            }
            //STEP6  : CALCUALTE PRORATE
            $prorate_array = $this->calculateProrate($INVOICE_DATA['total_recurring_fee'], $INVOICE_DATA['due_date'], $cycle_month);
            $INVOICE_DATA['next_bill_date'] = $prorate_array['next_bill_date'];
            $INVOICE_DATA['prorate_amount'] = $prorate_array['prorate_amount'];
            $INVOICE_DATA['prorate_desc']   = $this->props->lang['prorate_upto'] . " " . $this->BL->fDate($prorate_array['due_date']);
            //STEP7  : CALCULATE THE SUBTOTAL
            $INVOICE_DATA['net_amount'] = $INVOICE_DATA['tld_fee']+$INVOICE_DATA['setup_fee']+$INVOICE_DATA['cycle_fee']+$total_addon_price;
            $INVOICE_DATA['net_amount'] = $INVOICE_DATA['net_amount']-$INVOICE_DATA['other_amount'];
            $INVOICE_DATA['net_amount'] = $INVOICE_DATA['net_amount']+$INVOICE_DATA['prorate_amount'];
            //STEP8  : CALCULATE THE DISCOUNT BASED ON CUSTOMER PRE-ASSIGNED DISCOUNTS
            if(!$customer['discount']==0)
            {
                $customer_discount = $INVOICE_DATA['net_amount']*($customer['discount']/100);
                $INVOICE_DATA['customer_discount_amount'] = $customer_discount;
                $INVOICE_DATA['other_amount'] = $INVOICE_DATA['other_amount']+$customer_discount;
                $INVOICE_DATA['net_amount']   = $INVOICE_DATA['net_amount']-$customer_discount;
            }
            //STEP9  : CALCULATE THE DISCOUNT BASED ON CUSTOMER PRE-ASSIGNED CREDITS OR DEBITS
            if ($customer['credit']>0)
            {
                if (empty($customer['credit_type']))
                { //If negetive credit
                    $INVOICE_DATA['debit_credit']        = $this->props->lang['debit'];
                    $INVOICE_DATA['debit_credit_amount'] = $customer['credit'];
                    $INVOICE_DATA['debit_credit_reason'] = $customer['credit_desc'];
                    $INVOICE_DATA['net_amount'] = $INVOICE_DATA['net_amount'] + $INVOICE_DATA['debit_credit_amount'];
                    $INVOICE_DATA['debit_credit_balance']= 0;
                }
                else
                { //If positive credit
                    $INVOICE_DATA['debit_credit']        = $this->props->lang['credit'];
                    $INVOICE_DATA['debit_credit_reason'] = $customer['credit_desc'];
                    if ($customer['credit'] > $INVOICE_DATA['net_amount'])
                    {
                        $INVOICE_DATA['debit_credit_amount'] = $INVOICE_DATA['net_amount'];
                        $INVOICE_DATA['debit_credit_balance']= $INVOICE_DATA['debit_credit_amount'] - $INVOICE_DATA['net_amount'];
                    }
                    else
                    {
                        $INVOICE_DATA['debit_credit_amount'] = $customer['credit'];
                        $INVOICE_DATA['debit_credit_balance']= 0;
                    }
                    $INVOICE_DATA['net_amount'] = $INVOICE_DATA['net_amount'] - $INVOICE_DATA['debit_credit_amount'];
                }
            }
            //STEP10 : CALCULATE THE TAX
            $tax_data = $this->calculateTax($INVOICE_DATA['net_amount'], $customer['country'], $customer['state']);
            $INVOICE_DATA['tax_percent'] = $tax_data['tax_string'];
            $INVOICE_DATA['tax_amount']  = $tax_data['total_tax_amount'];
            $INVOICE_DATA['TAX_DATA']    = $tax_data;
            //STEP11 : CALCULATE TOTAL
            $INVOICE_DATA['gross_amount'] = $INVOICE_DATA['net_amount']+$INVOICE_DATA['tax_amount'];
            $INVOICE_DATA['pay_text']     = $this->props->lang['pay_now'] . " <b>" . $this->BL->toCurrency($INVOICE_DATA['gross_amount'], null, 1) . "</b><br>";

            /*
            * CALCULATION ENDS HERE
            */
            //ADD some more variables
            $INVOICE_DATA['initial']          = $INVOICE_DATA['gross_amount'];
            $INVOICE_DATA['total_tax_amount'] = $INVOICE_DATA['tax_amount'];
            $INVOICE_DATA['bill']             = $ORDER_DATA['bill_cycle'];
            $INVOICE_DATA['tax_string']       = $INVOICE_DATA['tax_percent'];
            $INVOICE_DATA['friendly_desc']    = $this->BL->getFriendlyDesc($INVOICE_DATA['desc'],0,$INVOICE_DATA['ORDER_DATA']['sld'].".".$INVOICE_DATA['ORDER_DATA']['tld']);

            $INVOICE_DATA['ORDER_DATA']['remote_id'] = $this->utils->realip();
            $temp = $this->BL->geoip->getRemoteCountry($INVOICE_DATA['ORDER_DATA']['remote_id']);
            $INVOICE_DATA['ORDER_DATA']['remote_country_code'] = $temp[0]['COUNTRY_CODE2'];
            $INVOICE_DATA['ORDER_DATA']['remote_city']         = $temp[1]['CITY'];
            $INVOICE_DATA['ORDER_DATA']['remote_country']      = isset($this->props->country[strtoupper($INVOICE_DATA['ORDER_DATA']['remote_country_code'])])?$this->props->country[strtoupper($INVOICE_DATA['ORDER_DATA']['remote_country_code'])]:"";

            return $INVOICE_DATA;
        }

        /*
        * Calculate Prorate value
        */
        function calculateProrate($recurring_amount, $current_date, $cycle)
        {
            $next_due_date                  = $this->utils->getXmonthsAfter($cycle, $this->utils->getDateArray($current_date));
            $prorate_array                  = array();
            $prorate_array['prorate_amount']= 0;
            $prorate_array['due_date']      = $current_date;
            $prorate_array['next_bill_date']= $next_due_date['year'] . "-" . $next_due_date['mon'] . "-" . $next_due_date['mday'];
            if ($this->BL->conf['en_prorate'])
            {
                $d1          = $this->utils->getDateArray($current_date);
                $d2          = $this->utils->getDateArray($prorate_array['next_bill_date']);
                $prorate_day = $d1['year'] . "-" . $d1['mon'] . "-" . $this->BL->conf['prorate_date'];
                if ($d1['mday'] > $this->BL->conf['prorate_date'])
                {
                    $prorate_day = $this->utils->beginOfNextMonth($d1['mday'], $d1['mon'], $d1['year'], '%Y-%m') . "-" . $this->BL->conf['prorate_date'];
                }
                $d3            = $this->utils->getDateArray($prorate_day);
                $days_in_cycle = $this->utils->dateDiff($d1['mday'], $d1['mon'], $d1['year'], $d2['mday'], $d2['mon'], $d2['year']);
                $prorate_days  = $this->utils->dateDiff($d1['mday'], $d1['mon'], $d1['year'], $d3['mday'], $d3['mon'], $d3['year']);
                $amount_per_day= $recurring_amount / $days_in_cycle;
                $next_due_date = $this->utils->getXmonthsAfter($cycle, $this->utils->getDateArray($prorate_day));
                $prorate_array['prorate_amount'] = $this->utils->toFloat($amount_per_day * $prorate_days);
                $prorate_array['due_date']       = $prorate_day;
                $prorate_array['next_bill_date'] = $next_due_date['year'] . "-" . $next_due_date['mon'] . "-" . $next_due_date['mday'];
                $prorate_array['prorate_day']    = $prorate_day;
            }
            return $prorate_array;
        }

        /*
        * Calulate tax on an amount
        */
        function calculateTax($sub_total, $country= "", $state= "", $force_tax_array=array())
        {
            return $this->BL->taxes->calculateTax($sub_total, $country, $state, $force_tax_array);
        }

        function invoiceValuesTaxAmount($key,$amount,$data_array,$invoice_tax_string, $tax_names)
        {
            $data_array["float_amount[".$key."]"] = floatval($amount);
            foreach($tax_names as $tn)
            {
                $amt = $this->getTaxAmountForAmountInInvoice($invoice_tax_string,$amount,$tn);
                $data_array["tax_amount[".$tn."][".$key."]"] = $this->BL->toCurrency($amt, null, 1);
                $data_array["float_amount[tax_amount[".$tn."][".$key."]]"] = floatval($amt);
            }
            $amt = $this->getTaxAmountForAmountInInvoice($invoice_tax_string,$amount,'total_tax_amount');
            $data_array["tax_amount[total_tax_amount][".$key."]"] = $this->BL->toCurrency($amt, null, 1);
            $data_array["float_amount[tax_amount[total_tax_amount][".$key."]]"] = floatval($amt);
        }

        function getTaxAmountForAmountInInvoice($invoice_tax_string,$amount,$taxname)
        {
            $tax_data_for_calcutation = array();
            $temp   = explode("|", $invoice_tax_string);
            $this->utils->Remove_Empty_Elements($temp);
            $i      = 0;
            foreach($temp as $k=>$v)
            {
                $temp_v = explode("<&>",$this->utils->htmlspecialchars_decode($v));
                $this->utils->Remove_Empty_Elements($temp_v);

                if($temp_v[3]=='-')
                {
                    $temp_v[3]='S';
                }
                else
                {
                    $temp_v[3]='A';
                }

                $tax_data_for_calcutation[$i]['tax_id']         = $k+1;
                $tax_data_for_calcutation[$i]['tax_name']       = isset($temp_v[2])?$temp_v[2]:0;
                $tax_data_for_calcutation[$i]['tax_amount']     = isset($temp_v[0])?$temp_v[0]:0;
                $tax_data_for_calcutation[$i]['tax_add_sub']    = isset($temp_v[3])?$temp_v[3]:0;
                $tax_data_for_calcutation[$i]['tax_net_comp']   = isset($temp_v[4])?$temp_v[4]:0;
                $tax_data_for_calcutation[$i]['tax_country']    = 'ALL';
                $tax_data_for_calcutation[$i]['tax_state']      = 'ALL';
                $tax_data_for_calcutation[$i]['tax_enable']     = 1;
                $tax_data_for_calcutation[$i]['tax_index']      = $i+1;
                $i++;
            }
            $tax_data = $this->calculateTax($amount,"","",$tax_data_for_calcutation);
            $tax_amt_name = $tax_data['tax_amt_name'];
            if($taxname=='total_tax_amount')
                return $tax_data['total_tax_amount'];
            return $tax_amt_name[$taxname];
        }

        /*
         * Generate invoice for the given order id
         */
        function genInvoice($order_id)
        {

            //CHECK AND GENERATE INVOICE
            $conf = $this->BL->conf;

            $temp  = $this->BL->orders->get("WHERE `orders`.sub_id=".intval($order_id));
            $order = $temp[0];

            $temp              = $this->BL->orders->recurring_data($order_id, 0, "SELECT");
            $next_due_date     = $temp['rec_next_date'];

            $order['bill_cycle'] = (empty ($order['bill_cycle']) || empty ($order['product_id']))?12:$order['bill_cycle'];
            $cycle_name = $this->props->cycles[$order['bill_cycle']];
            $desc       = $order['product_id'] . "-" . $order['domain_name'] . "-" . $next_due_date;

            // Use the first invoice for this order and domain to generate a template.
            $temp = $this->BL->invoices->get("WHERE `invoices`.desc = '" . $this->utils->quoteSmart($order['product_id'] . "-" . $order['domain_name']) . "' AND `orders`.domain_name='".$this->utils->quoteSmart($order['domain_name'])."' AND `orders`.product_id=".intval($order['product_id']));
            $start_invoice = $temp[0];
            $this->REQUEST['pay_text'] = "";
            $echo       = "";


            //GET DOMAIN REGISTRATION PRICE
            $dom_array = explode(".", $order['domain_name'], 2);
            $sld       = $dom_array[0];
            $tld       = $dom_array[1];
            $tld_amount = 0;
            if ($order['dom_reg_type'] == 1)
            {
                $tld_data   = $this->BL->tlds->find(array("WHERE `dom_ext`='".$this->utils->quoteSmart($tld)."'"));
                $month_diff = $this->utils->count_months($order['sign_date'], $next_due_date);
                $division   = $month_diff / ($order['dom_reg_year'] * 12);
                if ($order['dom_reg_year'] * 12 == $month_diff || $division == floor($division))
                {
                    $echo .= "RENEW DOMAIN, ";
                    foreach ($tld_data as $t)
                    {
                        if ($order['dom_reg_year'] == $t['dom_period'])
                        {
                            $tld_amount = $t['dom_price'];
                        }
                    }
                }
            }
            //GET SUB-DOMAIN PRICE
            elseif ($order['dom_reg_type'] == 2)
            {
                $subdomain_data  = $this->BL->subdomains->find(array("WHERE `maindomain`='".$this->utils->quoteSmart($tld)."'"));
                $subdomain_cycle = $this->BL->subdomains->getCycles($subdomain_data[0]['main_id']);
                $echo           .= "RENEW SUB DOMAIN,   ";
                $tld_amount      = $subdomain_cycle[$cycle_name];
            }
            else
            {
                $tld_amount = 0;
            }
            if ($tld_amount > 0)
            {
                $this->REQUEST['pay_text'] .= $order['domain_name'] . " => <b>" . $this->BL->toCurrency($tld_amount,null,1);
                $this->REQUEST['pay_text'] .= "</b><br>";
            }
            $this->REQUEST['tld_fee'] = $tld_amount;


            //GET PRODUCT PRICE
            $cycle_amount   = 0;
            $product_cycles = $this->BL->products->getCycles($order['product_id']);
            $cycle_amount   = $product_cycles[$cycle_name];
            if ($cycle_amount > 0)
            {
                $this->REQUEST['pay_text'] .= $this->BL->getFriendlyName($order['product_id']) . " => <b>" . $this->BL->toCurrency($cycle_amount,null,1);
                $this->REQUEST['pay_text'] .= "</b><br>";
            }
            $this->REQUEST['cycle_fee']= $cycle_amount;


            //GET ADDON PRICE
            $pay_text1     = "";
            $order_addons  = $this->BL->orders->getAddons($order_id);
            $inv_addon_fee = "<&>";
            $addon_amount  = 0;
            foreach ($order_addons as $order_addon)
            {
                $addon_data   = $this->BL->addons->getByKey($order_addon['addon_id']);
                $addon_cycles = $this->BL->addons->getCycles($order_addon['addon_id']);
                if (isset($addon_data['addon_name']))
                {
                    $inv_addon_fee .= $addon_data['addon_name'] . ">0.00>" . $this->utils->toFloat($addon_cycles[$cycle_name]) . "<&>";
                    $addon_amount   = $addon_amount + $addon_cycles[$cycle_name];
                    $pay_text1     .= $addon_data['addon_name'] . " => <b>" . $this->BL->toCurrency($addon_cycles[$cycle_name],null,1);
                    $pay_text1     .= "</b><br>";
                }
            }
            if ($addon_amount > 0)
            {
                $this->REQUEST['addon_fee'] = $inv_addon_fee;
                $this->REQUEST['pay_text']     .= $pay_text1;
            }

            //GET DISCOUNTS
            $this->REQUEST['inv_tld_disc']  = 0;
            $this->REQUEST['inv_plan_disc'] = 0;
            $this->REQUEST['inv_addon_disc']= 0;
            if ($conf['include_sp_rec'] == 1)
            {
                $this->REQUEST['inv_tld_disc']  = $start_invoice['inv_tld_disc'];
                $this->REQUEST['inv_plan_disc'] = $start_invoice['inv_plan_disc'];
                $this->REQUEST['inv_addon_disc']= $start_invoice['inv_addon_disc'];
            }

            //calculate subtotal
            $this->REQUEST['other_amount']= 0;
            $this->REQUEST['other_amount']= $this->REQUEST['other_amount'] + ($this->REQUEST['tld_fee'] * ($this->REQUEST['inv_tld_disc'] / 100));
            $this->REQUEST['other_amount']= $this->REQUEST['other_amount'] + ($this->REQUEST['cycle_fee'] * ($this->REQUEST['inv_plan_disc'] / 100));
            $this->REQUEST['other_amount']= $this->REQUEST['other_amount'] + ($addon_amount * ($this->REQUEST['inv_addon_disc'] / 100));
            $this->REQUEST['net_amount']  = $this->REQUEST['tld_fee'] + $this->REQUEST['cycle_fee'] + $addon_amount - $this->REQUEST['other_amount'];
            $this->REQUEST['desc']        = $desc;
            $temp = explode("-",$next_due_date,3);
            $invoices  = $this->BL->invoices->find(array("WHERE `desc` LIKE '" . $this->utils->quoteSmart($order['product_id'] . "-" . $order['domain_name'] . "-" . trim($temp[0]) . "-" . trim($temp[1]) . "-%")."'"));
            if (count($invoices))
            {
                $order['credit']     = $invoices[0]['debit_credit_amount'];
                $order['credit_desc']= $invoices[0]['debit_credit_reason'];
                $order['credit_type']= 0;
                if ($invoices[0]['debit_credit'] == $this->props->lang['credit'])
                {
                    $order['credit_type']= 1;
                }
            }

            //Count credit
            if ($order['credit'] > 0)
            {
                //negetive credit
                if ($order['credit_type'] == 0)
                {
                    $this->REQUEST['net_amount'] = $this->REQUEST['net_amount'] + $order['credit'];
                    $this->REQUEST['pay_text']  .= $this->props->lang['and'] . " " . $this->props->lang['debit'] . " = <b>" . $this->utils->toFloat($order['credit']);
                    $this->REQUEST['pay_text']  .= "</b> " . $this->props->lang['reason'] . " : <b>" . $order['credit_desc'] . "<b>";
                    $credit_balance              = 0;
                    $this->REQUEST['debit_credit']       = $this->props->lang['debit'];
                    $this->REQUEST['debit_credit_amount']= $order['credit'];
                    $this->REQUEST['credit_desc']        = $order['credit_desc'];
                }
                else
                {
                    if ($this->REQUEST['net_amount'] > $order['credit'])
                    {
                        $this->REQUEST['net_amount']= $this->REQUEST['net_amount'] - $order['credit'];
                        $credit_balance             = 0;
                        $this->REQUEST['debit_credit']       = $this->props->lang['credit'];
                        $this->REQUEST['debit_credit_amount']= $order['credit'];
                        $this->REQUEST['credit_desc']        = $order['credit_desc'];
                    }
                    else
                    {
                        $credit_balance  = $order['credit'] - $this->REQUEST['net_amount'];
                        $this->REQUEST['debit_credit']       = $this->props->lang['credit'];
                        $this->REQUEST['debit_credit_amount']= $this->REQUEST['net_amount'];
                        $this->REQUEST['net_amount']         = 0;
                        $this->REQUEST['credit_desc']        = $order['credit_desc'];
                    }
                    $this->REQUEST['pay_text'] .= $this->props->lang['and'] . " " . $this->props->lang['credit'] . " = <b>" . $this->BL->toCurrency($order['credit'],null,1);
                    $this->REQUEST['pay_text'] .= "</b> " . $this->props->lang['reason'] . " : <b>" . $order['credit_desc'] . "<b>";
                }
                $data       = array();
                $data['id'] = $order['id'];
                if($credit_balance)
                {
                    $data['credit']  = $credit_balance;
                }
                else
                {
                    $data['credit']      = 0;
                    $data['credit_type'] = '';
                    $data['credit_desc'] = '';
                }
                $this->BL->customers->update($data);
            }

            //calculate tax
            //get tax data
            $tax_string       = null;
            $total_tax_amount = 0;
            foreach ($this->calculateTax($this->REQUEST['net_amount'], $this->BL->getCustomerFieldValue("country",$order['id']), $this->BL->getCustomerFieldValue("state",$order['id'])) as $r_k => $r_v)
            {
                ${ $r_k }= $r_v;
            }
            $this->REQUEST['tax_percent']     = $tax_string;
            $this->REQUEST['tax_amount']      = $total_tax_amount;
            $this->REQUEST['gross_amount']    = $this->REQUEST['net_amount'] + $this->REQUEST['tax_amount'];
            $this->REQUEST['status']          = $this->props->invoice_status[0];
            $this->REQUEST['order_id']        = $order_id;
            $this->REQUEST['due_date']        = $next_due_date;

            // Set status if specified (otherwise we use the default)
            if (isset ($this->REQUEST['force_status']))
            {
                $this->REQUEST['status'] = $this->REQUEST['force_status'];
            }
            $echo .= $this->REQUEST['desc'] . "<br />";

            // If the invoice doesn't exist, create it.
            $this->REQUEST['invoice_no'] = 0;
            if (!count($invoices))
            {
                $this->REQUEST['invoice_no'] = $this->BL->invoices->add($this->REQUEST['order_id']);
            }
            // Otherwise, if the invoice already exists, but the status is 'Upcoming', update it.
            elseif ($invoices[0]['status'] == $this->props->invoice_status[5])
            {
                $this->REQUEST['invoice_no'] = $invoices[0]['invoice_no'];
                $this->BL->invoices->update($this->REQUEST);
            }

            // Set new due date if an invoice was created or updated
            if (!empty ($this->REQUEST['invoice_no']) || (count($invoices)))
            {
                $echo .= "Updated due date.\n";
                $this->BL->recurring_data($this->REQUEST['order_id'], 0, "UPDATE", $this->REQUEST['due_date']);
            }

            // Email invoice if configured to do so, and if the invoice was created, and it is "Pending"
            if ($conf['en_automail'] && $this->REQUEST['status']==$this->props->invoice_status[0])
            {
                $this->mailInvoice($this->REQUEST['invoice_no']);
            }
            return $echo;
        }


        /*
        * Generate invoices scheduled to be sent today, or on a specified date
        */
        function genInvoicesForDay($order_id, $date1= null, $prev_bill= false)
        {
            $conf = $this->BL->conf;
            //DATES
            $today = getdate();
            $temp              = $this->BL->recurring_data($order_id, 0, "SELECT");
            $next_due_date     = $temp['rec_next_date'];

            // Calculate what day we're generating invoices for.
            if (!empty ($date1) && $this->utils->checkDateFormat($date1))
            {
                // $prev_bill='U' if we're generating upcoming invoices.
                if (!$prev_bill && $prev_bill!='U')
                {
                    $gen_for_date = $this->utils->getXdayAfter($conf['send_before_due'], $this->utils->getDateArray($date1));
                }
                else
                {
                    $gen_for_date = $today;
                }
            } else {
                $gen_for_date = $this->utils->getXdayAfter($conf['send_before_due'], $today);
            }

            $v_day = date('Y-m-d', strtotime($gen_for_date ['year'] . "-" . $gen_for_date ['mon'] . "-" . $gen_for_date ['mday']));

            // Generate invoice if it is scheduled to be generated for this order
            if ($next_due_date == $v_day)
            {
                return genInvoice($order_id);
            } else {
                return null;
            }

        }

        /*
         * Generate all new invoices currently due for the given account.
         */
        function genNewInvoices($order_id)
        {
            $conf = $this->BL->conf;

            // Calculate what day we're generating invoices for.
            $today = getdate();
            $gen_for_date = $this->utils->getXdayAfter($conf['send_before_due'], $today);
            $v_day = date('Y-m-d', strtotime($gen_for_date ['year'] . "-" . $gen_for_date ['mon'] . "-" . $gen_for_date ['mday']));

            // Generate invoices
            $echo = "";
            $temp              = $this->BL->orders->recurring_data($order_id, 0, "SELECT");
            $next_due_date     = $temp['rec_next_date'];

            while ($next_due_date <= $v_day)
            {
                $echo .= "Processing Order #$order_id - For invoice due date: $next_due_date\n";
                $echo .= $this->genInvoice($order_id);

                $temp              = $this->BL->recurring_data($order_id, 0, "SELECT");
                if ($next_due_date == $temp['rec_next_date'])
                {
                    $echo .= "No change in due date, done processing.\n";
                    break; // Break out if next due date wasn't updated.
                }
                $next_due_date     = $temp['rec_next_date'];
            }

            return $echo;
        }

        /*
         * Generate all invoices between order date and today for the given order, including ones that were already generated.
         */
        function genIntermediateInvoices($order_id)
        {
            if (!empty( $this->REQUEST['mark_as']))
            {
                $this->REQUEST['force_status'] = $this->REQUEST['mark_as'];
            }

            $return_string = '';
            $temp          = $this->BL->recurring_data($order_id, 0, "SELECT");
            $next_due_date = $temp['rec_next_date'];
            while ($next_due_date <= date('Y-m-d'))
            {
                echo $order_id . ' - '. $next_due_date . "<br/>\n";
                $return_string .= $this->genInvoicesForDay($order_id, $next_due_date) . "\n";
                $temp           = $this->BL->recurring_data($order_id, 0, "SELECT");
                $next_due_date  = $temp['rec_next_date'];
            }
            return $return_string;
        }

        /*
         * Generate 'upcoming' invoices for the given order
         */
        function genUpcomingInvoices($order_id)
        {
            $conf = $this->BL->conf;
            // $conf['u_invoice_date'] is how many months in advance to generate upcoming invoices
            if ($conf['u_invoice_date'] > 0)
            {
                // Force generated invoices to be status "Upcoming"
                $this->REQUEST['force_status'] = $this->props->invoice_status[5];

                $echo               = "";
                $continue           = false;

                $temp               = $this->BL->recurring_data($order_id, 0, "SELECT");
                $next_due_date      = $temp['rec_next_date'];
                $next_due_date_array= $this->utils->getDateArray($next_due_date);
                $restore_actual_due = $next_due_date; //restore later

                $delta_date         = ($conf['u_invoice_date'] > 12)?floor($conf['u_invoice_date'] / 30):$conf['u_invoice_date'];
                $max_upcoming_date_array  = $this->utils->getXmonthsAfter($delta_date, getdate());
                $max_upcoming_date  = date('Y-m-d', strtotime($max_upcoming_date_array['year'] . "-" . $max_upcoming_date_array['mon'] . "-" . $max_upcoming_date_array['mday']));

                if ($this->utils->compareDates(
                    $max_upcoming_date_array['mday'],$max_upcoming_date_array['mon'],$max_upcoming_date_array['year'],
                    $next_due_date_array['mday'], $next_due_date_array['mon'],$next_due_date_array['year'])
                        !=-1) // If $max_upcoming_date_arr >= $next_due_date_array
                {
                    $continue = true;
                }

                while ($continue && $next_due_date<$max_upcoming_date)
                {
                    $echo .= "$next_due_date\n";
                    $echo .= $this->genInvoice($order_id);
                    $temp  = $this->BL->recurring_data($order_id, 0, "SELECT");

                    $rec_next_date_array     = $this->utils->getDateArray($temp['rec_next_date']);
                    $next_due_date_array     = $this->utils->getDateArray($next_due_date);

                    $date_compare1 = $this->utils->compareDates($max_upcoming_date_array['mday'],$max_upcoming_date_array['mon'],$max_upcoming_date_array['year'],$rec_next_date_array['mday'],$rec_next_date_array['mon'],$rec_next_date_array['year']);
                    $date_compare2 = $this->utils->compareDates($rec_next_date_array['mday'],$rec_next_date_array['mon'],$rec_next_date_array['year'],$next_due_date_array['mday'],$next_due_date_array['mon'],$next_due_date_array['year']);

                    if($temp['rec_next_date']<$max_upcoming_date && $temp['rec_next_date']!=$next_due_date)
                    {
                        $next_due_date = $temp['rec_next_date'];
                    }
                    else
                    {
                        $continue = false;
                    }
                }

                // Restore proper due date
                $sqlUPDATE = "UPDATE {$this->props->tbl_ord_inv_recs} SET `rec_next_date`='" . $restore_actual_due . "' WHERE `rec_ord_id`=" . intval($order_id);
                $this->dbL->executeUPDATE($sqlUPDATE);
                $echo .= "Restored due date\n";
            }
            return $echo;
        }


        /*
        * Mail Invoice
        */
        function mailInvoice($invoice_no, $no_mail= false, $return_data_array=false)
        {
            $data_array      = array();
            $evaluated_array = array();
            $cycle           = $this->props->cycles;
            $tax_names       = array();
            $addons          = array();

            $temp    = $this->BL->invoices->get("WHERE `invoice_no`=".intval($invoice_no));
            if (empty($temp))
            {
                return false;
            }
            $invoice = $temp[0];
            $invoice_template = $this->BL->emails->getByKey(2);
            $body    = $this->utils->entity_decode($this->utils->htmlspecialchars_decode($invoice_template['email_text']));
            //fix for new tax and date variable name
            $body    = str_replace("<lang>tax</lang>", "<&&>tax_name<&&>", $body);
            $body    = str_replace("<lang>payment_date</lang>", "<&&>due_date<&&>", $body);
            $subject = $this->props->lang['Invoice_from'] . $this->BL->conf['company_name'] . " " . $this->props->lang['for'] . " " . $this->BL->getFriendlyDesc($invoice['desc'],$invoice['order_id'],$invoice['domain_name']);
            if(!empty($invoice_template['email_subject']))
            {
                $subject= $this->utils->entity_decode($this->utils->htmlspecialchars_decode($invoice_template['email_subject']));
            }
            if(empty($invoice_no) || !count($invoice))
            {
                return false;
            }

            $temp   = explode("<&>", $invoice['addon_fee']);
            $this->utils->Remove_Empty_Elements($temp);
            foreach ($temp as $t)
            {
                $temp2  = explode(">", $t);
                $this->utils->Remove_Empty_Elements($temp2);
                $addons[$temp2[0]]= ($temp2[1] + $temp2[2]);
            }

            $body = ($no_mail)?$this->utils->clnTag("mail_footer", "", $body):$body;
            $body = (floatval($invoice['tld_fee'])<=0)?$this->utils->clnTag("if_domain", "", $body):$body;
            $body = (floatval($invoice['setup_fee'])<=0)?$this->utils->clnTag("if_setup", "", $body):$body;
            $body = (floatval($invoice['cycle_fee'])<=0)?$this->utils->clnTag("if_cycle", "", $body):$body;
            $body = (floatval($invoice['other_amount'])<=0)?$this->utils->clnTag("if_discount", "", $body):$body;
            $body = (floatval($invoice['debit_credit_amount'])<=0)?$this->utils->clnTag("if_debit_credit", "", $body):$body;
            $body = (floatval($invoice['prorate_amount'])<=0)?$this->utils->clnTag("if_prorate", "", $body):$body;
            $body = (floatval($invoice['tax_amount'])<=0)?$this->utils->clnTag("if_tax", "", $body):$body;
            $body = (!count($addons))?$this->utils->clnTag("if_order_addon", "", $body):$body;

            $data_array         = $invoice;
            $invoice_tax_string = $invoice['tax_percent'];
            $temp               = explode("|", $invoice_tax_string);
            $this->utils->Remove_Empty_Elements($temp);
            foreach($temp as $k=>$v)
            {
                $temp_v = explode("<&>",$this->utils->htmlspecialchars_decode($v));
                $this->utils->Remove_Empty_Elements($temp_v);
                $data_array["tax_percent[".$temp_v[2]."]"] = $temp_v[2]." ".number_format($temp_v[0],2)."%";
                $tax_names[] = $temp_v[2];
            }
            $i  =1;
            $str= $this->utils->strInTag("if_tax", $body);
            if(empty($str) && count($tax_names)==1)
            {
                $body = str_replace("<&&>tax_name<&&>", $tax_names[0]." <&&>tax_percent[".$tax_names[0]."]<&&>%", $body);
            }
            elseif(empty($str))
            {
                $body = str_replace("<&&>tax_name<&&>", "<lang>~tax</lang>", $body);
                $body = str_replace("<&&>tax_amount<&&>", "<&&>total_tax_amount<&&>", $body);
                $data_array['total_tax_amount'] = $this->BL->toCurrency($invoice['tax_amount'], null, 1);
            }
            else
            {
                foreach($tax_names as $k=>$v)
                {
                    $new_str  = $str;
                    if($i<count($tax_names))
                    {
                        $new_str  = str_replace("<&&>tax_name<&&>", " <&&>tax_percent[".$v."]<&&>", $new_str);
                        $new_str  = str_replace("<&&>tax_amount<&&>", "<&&>tax_amount[".$v."][subtotal]<&&>", $new_str);
                        $body= str_replace($str,$new_str.$str,$body);
                    }
                    else
                    {
                        $new_str  = str_replace("<&&>tax_name<&&>", " <&&>tax_percent[".$v."]<&&>", $new_str);
                        $new_str  = str_replace("<&&>tax_amount<&&>", "<&&>tax_amount[".$v."][subtotal]<&&>", $new_str);
                        $body= str_replace($str,$new_str,$body);
                    }
                    $i++;
                }
            }
            $i=1;
            $str= $this->utils->strInTag("if_order_addon", $body);
            foreach ($addons as $k => $v)
            {
                $new_str  = $str;
                $new_str  = str_replace("<&&>order_addon<&&>", "<&&>order_addon[".$k."]<&&>", $str);
                $new_str  = str_replace("<&&>order_addon_amount<&&>", "<&&>order_addon_amount[".$k."]<&&>", $new_str);
                $new_str  = str_replace("<&&>float_amount[order_addon_amount]<&&>", "<&&>float_amount[order_addon_amount[".$k."]]<&&>", $new_str);
                foreach($tax_names as $tn)
                {
                    $new_str  = str_replace("<&&>tax_amount[".$tn."][order_addon_amount]<&&>", "<&&>tax_amount[".$tn."][".$k."]<&&>", $new_str);
                    $new_str  = str_replace("<&&>float_amount[tax_amount[".$tn."][order_addon_amount]]<&&>", "<&&>float_amount[tax_amount[".$tn."][".$k."]]<&&>", $new_str);
                }
                $data_array["order_addon[".$k."]"] = trim($k);
                $data_array["order_addon_amount[".$k."]"] = $this->BL->toCurrency($v, null, 1);
                $this->invoiceValuesTaxAmount($k,$v,$data_array,$invoice_tax_string, $tax_names);
                $this->invoiceValuesTaxAmount("order_addon_amount[".$k."]",$v,$data_array,$invoice_tax_string, $tax_names);
                if($i<count($addons))
                    $body= str_replace($str,$new_str.$str,$body);
                else
                    $body= str_replace($str,$new_str,$body);
                $i++;
            }

            $data_array['total_amount'] = $this->BL->toCurrency($invoice['gross_amount'], null, 1);
            $data_array['login_link']   = "<a href=\"" . $this->BL->conf['path_url'] . "/customer.php\" target=\"_blank\">" . $this->props->lang['Click_Here'] . "</a>" . $this->props->lang['login_link'];
            $data_array['payment_link'] = "<a href=\"" . $this->BL->conf['path_url'] . "/customer.php?cmd=pay&pp=" . $invoice['pay_proc'] . "&invoice_no=" . $invoice_no . "\" target=\"_blank\">" . $this->props->lang['Click_Here'] . "</a>" . $this->props->lang['paylink'];

            if ($invoice['status'] == $this->props->invoice_status[1])
            {
                $data_array['payment_link']= "<a href=\"" . $this->BL->conf['path_url'] . "/customer.php?cmd=viewInvoice&pp=" . $invoice['pay_proc'] . "&invoice_no=" . $invoice_no . "\" target=\"_blank\">" . $this->props->lang['Click_Here'] . "</a>" . $this->props->lang['paylink'];
            }

            $data_array['domain_amount']= $this->BL->toCurrency($invoice['tld_fee'], null, 1);
            $this->invoiceValuesTaxAmount('domain_amount',$invoice['tld_fee'],$data_array,$invoice_tax_string, $tax_names);

            $data_array['setup_amount'] = $this->BL->toCurrency($invoice['setup_fee'], null, 1);
            $this->invoiceValuesTaxAmount('setup_amount',$invoice['setup_fee'],$data_array,$invoice_tax_string, $tax_names);

            $data_array['cycle_amount'] = $this->BL->toCurrency($invoice['cycle_fee'], null, 1);
            $this->invoiceValuesTaxAmount('cycle_amount',$invoice['cycle_fee'],$data_array,$invoice_tax_string, $tax_names);

            $data_array['cycle']        = $this->props->lang[$cycle[$invoice['bill_cycle']]];

            $data_array['debit_credit'] = $this->props->lang['Credit_Debit'];
            if ($invoice['debit_credit'] != "")
            {
                $data_array['debit_credit']= $invoice['debit_credit'];
            }
            $data_array['debit_credit_reason']= $invoice['debit_credit_reason'];
            $data_array['debit_credit_amount']= $this->BL->toCurrency($invoice['debit_credit_amount'], null, 1);
            $this->invoiceValuesTaxAmount('debit_credit_amount',$invoice['debit_credit_amount'],$data_array,$invoice_tax_string, $tax_names);

            if ($invoice['debit_credit'] == $this->props->lang['debit'])
            {
                $data_array['debit_credit_amount']= "+ " . $this->BL->toCurrency($invoice['debit_credit_amount'], null, 1);
            }
            elseif ($invoice['debit_credit'] == $this->props->lang['credit'])
            {
                $data_array['debit_credit_amount']= "- " . $this->BL->toCurrency($invoice['debit_credit_amount'], null, 1);
            }

            $data_array['discount_amount']  = "- " . $this->BL->toCurrency($invoice['other_amount'], null, 1);
            $this->invoiceValuesTaxAmount('discount_amount',$invoice['other_amount'],$data_array,$invoice_tax_string, $tax_names);

            $data_array['client_email'] = $invoice['email'];
            $this->BL->customfields->setOrder("customfields_index");
            foreach($this->BL->customfields->find() as $customfield)
            {
                $data_array['client_'.$customfield['field_name']]= $this->BL->getCustomerFieldValue($customfield['field_name'],$invoice['customer_id']);
                $body   = empty($data_array['client_'.$customfield['field_name']])?
                $this->utils->clnTag('if_client_'.$customfield['field_name'],"",$body):$body;
            }
            $data_array['client_country']   = $this->props->country[$this->BL->getCustomerFieldValue("country",$invoice['customer_id'])];
            $data_array['company_email']    = $this->BL->conf['comp_email'];
            $data_array['company_name']     = $this->BL->conf['company_name'];
            $data_array['company_address']  = $this->BL->conf['company_address'];
            $data_array['description']      = $this->BL->getFriendlyDesc($invoice['desc'],$invoice['customer_id'],$invoice['domain_name']);

            $txt = "";
            if ($invoice['dom_reg_type'] == 1)
            {
                $txt  = " (" . $invoice['dom_reg_year'] . " " . $this->props->lang['years_registration'] . ")";
                if($invoice['dom_reg_year']==99)
                {
                    $txt= " (". $this->props->lang['one_time'].")";
                }
            }

            $data_array['domain_name']  = $invoice['domain_name'] . $txt;

            $txt    = "N/A";
            if ($invoice['dom_reg_type'] == 1)
            {
                $txt  = " (" . $invoice['dom_reg_year'] . " " . $this->props->lang['years_registration'] . ")";
                if($invoice['dom_reg_year']==99)
                {
                    $txt= " (". $this->props->lang['one_time'].")";
                }
            }
            $data_array['domain_year']      = $txt;
            $data_array['domain']           = $invoice['domain_name'];
            $data_array['payment_date']     = $this->BL->fDate($invoice['due_date']);
            $data_array['due_date']         = $this->BL->fDate($invoice['due_date']);
            $data_array['invoice_no']       = $this->BL->conf['invoice_prefix'] . $invoice['invoice_no'] . $this->BL->conf['invoice_suffix'];
            $data_array['plan_name']        = $this->BL->getFriendlyName($invoice['product_id']);
            $data_array['prorate_desc']     = $invoice['prorate_desc'];
            $data_array['prorate_amount']   = $this->BL->toCurrency($invoice['prorate_amount'], null, 1);
            $this->invoiceValuesTaxAmount('prorate_amount',$invoice['prorate_amount'],$data_array,$invoice_tax_string, $tax_names);

            $data_array['net_amount']       = $this->BL->toCurrency($invoice['net_amount'], null, 1);
            $this->invoiceValuesTaxAmount('net_amount',$invoice['net_amount'],$data_array,$invoice_tax_string, $tax_names);
            $this->invoiceValuesTaxAmount('subtotal',$invoice['net_amount'],$data_array,$invoice_tax_string, $tax_names);

            $data_array['symbol']           = $this->BL->conf['symbol'];
            $data_array['additional_currency']= "";
            if ($invoice['pay_curr_factor'] > 1)
            {
                $curr_conf                    = array ();
                $curr_conf['symbol_prefixed'] = $invoice['pay_curr_symbol_prefixed'];
                $curr_conf['symbol']          = $invoice['pay_curr_symbol'];
                $curr_conf['decimals']        = $invoice['pay_curr_decimal_number'];
                $curr_conf['str1']            = $invoice['pay_curr_decimal_str'];
                $curr_conf['str2']            = $invoice['pay_curr_thousand_str'];
                $data_array['additional_currency']= "<b>" . $this->props->lang['Total_amount_in'] . $invoice['pay_curr_name'] . "(" . $invoice['pay_curr_symbol'] . ") = " . $this->BL->toCurrency($invoice['pay_curr_factor'] * $invoice['gross_amount'], $curr_conf, 1);
            }
            $data_array['detail']           = $invoice['pay_text'];

            $body   = $this->BL->etp->parseEmail($data_array,$body);

            $match  = $this->utils->strInTag('php', $body, 'ALL');
            foreach($match as $k=>$v)
            {
                $echo   = "php[".$k."]";
                $body   = str_replace("<php>".$v."</php>", "<evaluated>".$echo."<evaluated>", $body);
                $evaluated_array[$echo] = $this->utils->eval_html($v);
            }

            $match  = $this->utils->strInTag('eval_currency', $body, 'ALL');
            foreach($match as $k=>$v)
            {
                $echo   = "eval_currency[".$k."]";
                $body   = str_replace("<eval_currency>".$v."</eval_currency>", "<evaluated>".$echo."<evaluated>", $body);
                $v      = $this->utils->matheval($v);
                $evaluated_array[$echo] = $this->BL->toCurrency($v,null,1);
            }

            $match      = $this->utils->strInTag('eval', $body, 'ALL');
            foreach($match as $k=>$v)
            {
                $echo   = "eval[".$k."]";
                $body   = str_replace("<eval>".$v."</eval>", "<evaluated>".$echo."<evaluated>", $body);
                $evaluated_array[$echo] = $this->utils->matheval($v);
            }

            $body   = $this->BL->etp->parseEmail($evaluated_array,$body,"evaluated");
            $body   = $this->BL->etp->parseEmail($data_array,$body);

            //clean $body
            $body   = $this->utils->clnTag("php", "", $body);
            $body   = $this->utils->clnTag("eval_currency", "", $body);
            $body   = $this->utils->clnTag("eval", "", $body);
            $body   = preg_replace("/\<&&\>(.*?)\<\&&\>/", '', $body);
            $body   = $this->utils->clnTag('if_domain',$this->utils->strInTag('if_domain',$body),$body);
            $body   = $this->utils->clnTag('if_setup',$this->utils->strInTag('if_setup',$body),$body);
            $body   = $this->utils->clnTag('if_cycle',$this->utils->strInTag('if_cycle',$body),$body);
            $body   = $this->utils->clnTag('if_order_addon',$this->utils->strInTag('if_order_addon',$body),$body);
            $body   = $this->utils->clnTag('if_discount',$this->utils->strInTag('if_discount',$body),$body);
            $body   = $this->utils->clnTag('if_debit_credit',$this->utils->strInTag('if_debit_credit',$body),$body);
            $body   = $this->utils->clnTag('if_prorate',$this->utils->strInTag('if_prorate',$body),$body);
            $body   = $this->utils->clnTag('if_tax',$this->utils->strInTag('if_tax',$body),$body);
            if($return_data_array)return $data_array;

            $subject= $this->BL->etp->parseEmail($data_array,$subject);
            if ($no_mail)
                return $body;

            $this->BL->inv_to   = $invoice['email'];
            $this->BL->msg      = $body;
            $this->BL->ALPmail->AddAddress($invoice['email'], $this->BL->getCustomerFieldValue("name",$invoice['customer_id']));
            $this->BL->ALPmail->AddCC($this->BL->conf['comp_email'], $this->BL->conf['company_name']);
            $this->BL->ALPmail->Subject = $subject;
            $this->BL->ALPmail->Body    = $body;
            return $this->BL->ALPmail->sendMail();
        }

        function processTransaction($item_number, $transaction_id)
        {
            $pInvoice = $this->BL->invoices->get("WHERE `invoices`.invoice_no=".intval($item_number));
            $oOrder   = $this->BL->orphan_orders->hasAnyOne(array("WHERE `item_number`='".$this->utils->quoteSmart($item_number)."'"));

            if (isset($oOrder['orphanorder_id']))
            {
                $oOrder_Datas = $this->BL->orphan_orders->get();
                $oOrder_Data  = $oOrder_Datas[$oOrder['orphanorder_id']];
                foreach($oOrder as $key=>$val)
                {
                    $this->REQUEST[$key]= $val;
                }
                foreach ($oOrder_Data as $key => $val)
                {
                    $this->REQUEST[$key]= $val;
                }
                $this->BL->orphan_orders->del($oOrder['orphanorder_id']);
                $this->BL->processOrder($transaction_id);
            }
            elseif (isset($pInvoice[0]['invoice_no']))
            {
                $this->BL->invoices->update(array("invoice_no"=>$pInvoice[0]['invoice_no'],"transaction_id"=>$transaction_id,"status"=>$this->props->invoice_status[1]));
                $product = $this->products->getByKey($pInvoice[0]['product_id']);
                if (isset($product['acc_method']) && $product['acc_method'] == '2')
                {
                    if ($pInvoice[0]['cust_status'] == $this->props->order_status[0])
                    {
                        $inst= $this->BL->changeStatus($pInvoice[0]['sub_id'], "create");
                    }
                    elseif ($pInvoice[0]['cust_status'] == $this->props->order_status[2])
                    {
                        $inst= $this->BL->changeStatus($pInvoice[0]['sub_id'], "activate");
                    }
                }
                $this->REQUEST['invoice_no'] = $pInvoice[0]['invoice_no'];
                $this->BL->updateOrderStatus($pInvoice[0]['sub_id']);
            }
            if($transaction_id)
            {
                $this->mailPaymentReceipt($this->REQUEST['invoice_no']);
            }
            return;
        }

        /*
        * Mail payment reciept
        */
        function mailPaymentReceipt($invoice_no,$payment_date="",$payment_amount=0)
        {
            $data_array = array();
            $cycle      = $this->props->cycles;
            $temp       = $this->BL->invoices->get("WHERE `invoice_no`=".intval($invoice_no));
            $invoice    = $temp[0];
            $data_array1= $this->BL->mailWelcome($invoice['order_id'],true);
            $data_array2= $this->BL->invoices->mailInvoice($invoice_no, true, true);
            $data_array = array_merge($data_array1,$data_array2);
            if(empty($payment_date))
            {
                $payment_date = date('Y-m-d');
            }
            if(empty($payment_amount))
            {
                $payment_amount = $invoice['gross_amount'];
            }

            if(empty($payment_amount) || empty($invoice_no) || !count($invoice))
                return false;

            $reciept_template = $this->BL->emails->getByKey(3);
            $subject          = $this->BL->conf['company_name'] . " " . $this->props->lang['payment_confirmation'];
            $body             = $this->utils->entity_decode($this->utils->htmlspecialchars_decode($reciept_template['email_text']));
            if(!empty($reciept_template['email_subject']))
            {
                $subject      = $this->utils->entity_decode($this->utils->htmlspecialchars_decode($reciept_template['email_subject']));
            }
            foreach($invoice as $key=>$data)
            {
                $data_array[$key] = $data;
            }
            $data_array['payment_date'] = $this->BL->fDate($payment_date);
            $data_array['amount_paid']  = $this->BL->toCurrency($payment_amount, null, 1);
            $data_array['due_date']     = $this->BL->fDate($invoice['due_date']);
            $data_array['invoice_no']   = $this->BL->conf['invoice_prefix'] . $invoice['invoice_no'] . $this->BL->conf['invoice_suffix'];
            $data_array['company_email']= $this->BL->conf['comp_email'];
            $data_array['company_name'] = $this->BL->conf['company_name'];
            $data_array['company_address']= $this->BL->conf['company_address'];
            $data_array['description']  = $this->BL->getFriendlyDesc($invoice['desc'],$invoice['sub_id'],$invoice['domain_name']);

            $body   = $this->BL->etp->parseEmail($data_array,$body);
            $subject= $this->BL->etp->parseEmail($data_array,$subject);

            $this->BL->notice_to    = $invoice['email'];
            $this->BL->msg          = $body;
            $this->BL->ALPmail->AddAddress($invoice['email'], $this->BL->getCustomerFieldValue("name",$invoice['id']));
            $this->BL->ALPmail->AddCC($this->BL->conf['comp_email'], $this->BL->conf['company_name']);
            $this->BL->ALPmail->Subject = $subject;
            $this->BL->ALPmail->Body    = $body;
            $return  = $this->BL->ALPmail->sendMail();
            $this->BL->runCS('A_PP',$invoice['sub_id'], $invoice['invoice_no']);
            return $return;
        }
    }
?>
