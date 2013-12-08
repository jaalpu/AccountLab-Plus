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

    function updateBasket()
    {
        global $BL, $cmd, $BUY_NOW_DATA;
        $show_basket = false;
        $basket_body = "<table width='100%' border='0' cellspacing='0' cellpadding='0' align='center' class='accountlabFormTABLE'>
        <tr>
        <td width='2%'></td>
        <td width='28%'><b>".$BL->props->lang['items_in_basket']."</b></td>
        <td width='50%'><b>".$BL->props->lang['description']."</b></td>
        <td width='18%' align='right'><b>".$BL->props->lang['cost']."</b></td>
        <td width='2%'></td>
        </tr>   ";

        $product_cost = 0;
        $product_data = $BL->products->hasAnyOne(array("WHERE `plan_price_id`=".intval($_SESSION['product_id'])));
        $product_name = $BL->getFriendlyName($_SESSION['product_id']);
        $cycles_data  = $BL->products->getCycles($_SESSION['product_id']);
        $product_desc = $product_data['host_setup_fee']>0?$BL->props->lang['setup_fee'] . " " . $BL->toCurrency($product_data['host_setup_fee'], null, 1):'';
        $product_cost = $product_data['host_setup_fee'];

        if($_SESSION['bill_cycle']>0)
        {
            $cycle_name   = $BL->props->cycles[$_SESSION['bill_cycle']];
            $product_desc.= $product_data['host_setup_fee']>0?" + ":"";
            $product_desc.= $BL->props->lang[$cycle_name] . " " . $BL->toCurrency($cycles_data[$cycle_name], null, 1);
            $product_cost = $product_cost + $cycles_data[$cycle_name];
        }
        if($_SESSION['product_id']){
            $show_basket = true;
            $basket_body .= "
            <tr>
            <td></td>
            <td>".$product_name."</td>
            <td>".$product_desc."</td>
            <td  align='right'>".$BL->toCurrency($product_cost, null, 1)."</td>
            <td></td>
            </tr>";
        }

        $_SESSION['addon_ids'] = isset($_SESSION['addon_ids'])?$_SESSION['addon_ids']:array();
        $addon_cost            = 0;
        $total_addon_cost      = 0;
        foreach($_SESSION['addon_ids'] as $addon_id)
        {
            $show_basket= true;
            $addon_data = $BL->addons->hasAnyOne(array("WHERE `addon_id`=".intval($addon_id)));
            $cycles_data= $BL->addons->getCycles($addon_id);
            $addon_desc = $addon_data['addon_setup']>0?$BL->props->lang['setup_fee'] . " " . $BL->toCurrency($addon_data['addon_setup'], null, 1):'';
            $addon_cost = $addon_data['addon_setup'];

            $cycle_name = $BL->props->cycles[$_SESSION['bill_cycle']];
            $addon_desc.= $addon_data['addon_setup']>0?" + ":'';
            $addon_desc.= $BL->props->lang[$cycle_name] . " " . $BL->toCurrency(($product_data['default_cycle']==0)?0:$cycles_data[$cycle_name], null, 1);
            $addon_cost = $addon_cost + $cycles_data[$cycle_name];

            $basket_body .= "
            <tr>
            <td></td>
            <td>".$addon_data['addon_name']."</td>
            <td>".$addon_desc."</td>
            <td  align='right'>".$BL->toCurrency($addon_cost, null, 1)."</td>
            <td></td>
            </tr>";
            $total_addon_cost = $total_addon_cost+$addon_cost;
        }


        $tld_cost = 0;
        if(!empty($_SESSION['sld']) && !empty($_SESSION['tld']))
        {
            $show_basket= true;
            $tld_name   = $_SESSION['sld'] . "." . $_SESSION['tld'];
            $tld_cost   = $_SESSION['tld_price'];
            $cycle_name = $BL->props->cycles[$_SESSION['bill_cycle']];
            $tld_desc   = $BL->props->lang[$cycle_name] . " " . $BL->toCurrency($_SESSION['tld_price'], null, 1);
            if($_SESSION['type']==1)
            {
                $tld_desc = ($_SESSION['year']<99)?$_SESSION['year']." ".$BL->props->lang['years']:$BL->props->lang['one_time'];
            }
            $basket_body .= "
            <tr>
            <td></td>
            <td>".$tld_name."</td>
            <td>".$tld_desc."</td>
            <td  align='right'>".$BL->toCurrency($tld_cost, null, 1)."</td>
            <td></td>
            </tr>";
        }

        if(isset($_SESSION['specials']['SELECTED_SLD']))
        {
            $special_domain = $_SESSION['specials']['SELECTED_SLD'].".".$_SESSION['specials']['SELECTED_TLD'];
            if($BL->utils->chkDomainFormat($special_domain) || $BL->utils->chkDomainFormat($special_domain))
            {
                $show_basket  = true;
                $basket_body .= "
                <tr>
                <td></td>
                <td>".$special_domain."</td>
                <td>".$BL->props->lang['special_offer']."</td>
                <td  align='right'>".$BL->toCurrency(0, null, 1)."</td>
                <td></td>
                </tr>";
            }
        }
        if(isset($_SESSION['specials']['SELECTED_PRODUCT']))
        {
            $show_basket  = true;
            $product_name = $BL->getFriendlyName($_SESSION['specials']['SELECTED_PRODUCT']);
            if(!empty($product_name))
            {
                $basket_body .= "
                <tr>
                <td></td>
                <td>".$product_name."</td>
                <td>".$BL->props->lang['special_offer']."</td>
                <td  align='right'>".$BL->toCurrency(0, null, 1)."</td>
                <td></td>
                </tr>";
            }
        }
        if(isset($_SESSION['specials']['SELECTED_ADDON']))
        {
            $show_basket = true;
            $addon = $BL->addons->getByKey($_SESSION['specials']['SELECTED_ADDON']);
            if(isset($addon['addon_name']))
            {
                $basket_body .= "
                <tr>
                <td></td>
                <td>".$addon['addon_name']."</td>
                <td>".$BL->props->lang['special_offer']."</td>
                <td  align='right'>".$BL->toCurrency(0, null, 1)."</td>
                <td></td>
                </tr>";
            }
        }

        $sub_total = $product_cost+$total_addon_cost+$tld_cost;
        $tax_data  = $BL->invoices->calculateTax($sub_total);
        $tax       = $tax_data['total_tax_amount'];
        $total_text= ($tax>0)?$BL->props->lang['estimated_total']:$BL->props->lang['Total'];
        if ($tax != 0) {
            $basket_body .= "
            <tr>
            <td></td>
            <td colspan=\"3\" height=\"1\" bgcolor=\"#aaaaaa\"></td>
            <td></td>
            </tr>
            <tr>
            <td></td>
            <td></td>
            <td><b>".$BL->props->lang['subtotal']."</b></td>
            <td  align='right'>".$BL->toCurrency($sub_total, null, 1)."</td>
            <td></td>
            </tr>
            <tr>
            <td></td>
            <td></td>
            <td><b>".$BL->props->lang['estimated_tax']."</b></td>
            <td  align='right'>".$BL->toCurrency($tax, null, 1)."</td>
            <td></td>
            </tr>";
        }
        $basket_body .= "
        <tr>
        <td></td>
        <td colspan=\"3\" height=\"1\" bgcolor=\"#aaaaaa\"></td>
        <td></td>
        </tr>
        <tr>
        <td></td>
        <td></td>
        <td><b>".$total_text."</b></td>
        <td  align='right'>".$BL->toCurrency($tax+$sub_total, null, 1)."</td>
        <td></td>
        </tr>
        </table>";

        $_SESSION['sub_total'] = $sub_total;
        $_SESSION['tax']       = $tax;
        $_SESSION['total']     = $tax+$sub_total;

        $objResponse   = new xajaxResponse(CHARSET);
        $objResponse->addAssign("basket_body", "innerHTML", $basket_body);
        if($show_basket == true)
        {
            $objResponse->addScriptCall("toggleTbodyOn", "basket_section");
        }
        $buttons_array = array();
        if($cmd == "step6")
        {
            $buttons_array[] = "back3";
        }
        if($cmd == "step5")
        {
            $buttons_array[] = "back3";
            $buttons_array[] = "continue3";
            $focus_element = "continue";
        }
        if($cmd == "step4")
        {
            $buttons_array[] = "back3";
            $buttons_array[] = "continue_without_special";
            $focus_element = "continue";
        }
        if($cmd == "step3")
        {
            if(
                isset($_SESSION['tld'])  &&  !empty($_SESSION['tld']) &&
                isset($_SESSION['sld'])  &&  !empty($_SESSION['sld'])
            )
            {
                $buttons_array[] = "back2";
            }
            else
            {
                $buttons_array[] = "back1";
            }
            $buttons_array[] = "continue_verify";
            $focus_element = "continue";
        }
        if($cmd == "step2")
        {
            if($_SESSION['product_id'] && (!isset($BUY_NOW_DATA['cmd']) || $BUY_NOW_DATA['cmd']!="step2"))
            {
                $buttons_array[] = "back1";
            }
            elseif(!isset($BUY_NOW_DATA['cmd']) || $BUY_NOW_DATA['cmd']!="step2")
            {
                $buttons_array[] = "reset";
            }
            if(
                isset($_SESSION['tld'])  &&  !empty($_SESSION['tld']) &&
                isset($_SESSION['sld'])  &&  !empty($_SESSION['sld'])
            )
            {
                $buttons_array[] = "continue2";
                $focus_element = "continue";
            }
        }
        elseif($cmd == "step1")
        {
            $buttons_array[] = "reset";
            if(
                isset($_SESSION['group_id'])    &&  $_SESSION['group_id']   > 0      &&
                isset($_SESSION['product_id'])  &&  $_SESSION['product_id'] > 0      &&
                isset($_SESSION['bill_cycle'])  &&  $_SESSION['bill_cycle'] > 0
            )
            {
                $buttons_array[] = "continue1";
                $focus_element = "continue";
            }
        }
        $objResponse->loadXML(toggleButtons($buttons_array));
        if(isset($focus_element))
        {
            $objResponse->addScript("xajax.$('".$focus_element."').focus();");
        }
        return $objResponse;
    }
    function toggleButtons($buttons=array())
    {
        global $BL;
        $objResponse= new xajaxResponse(CHARSET);
        $btns      = "&#160;";
        $reset     = "<input name='reset'  id='reset'  type='button' class='accountlabButton' value='" . $BL->props->lang['reset'] . "'     onclick=\"javascript:xajax_reload('step1','step1');\" />&nbsp;";
        $back1     = "<input name='back'  id='back'  type='button' class='accountlabButton' value='" . $BL->props->lang['back'] . "'     onclick=\"javascript:xajax_reload('step1','step2');\" />&nbsp;";
        $back2     = "<input name='back'  id='back'  type='button' class='accountlabButton' value='" . $BL->props->lang['back'] . "'     onclick=\"javascript:xajax_reload('step2','step3');\" />&nbsp;";
        $back3     = "<input name='back'  id='back'  type='button' class='accountlabButton' value='" . $BL->props->lang['back'] . "'     onclick=\"javascript:xajax_reload('step3','step4');\" />&nbsp;";
        $continue1 = "<input name='continue'  id='continue'  type='button' class='accountlabButton' value='" . $BL->props->lang['continue'] . "'     onclick=\"javascript:xajax_reload('step2','step2');\" />&nbsp;";
        $continue2 = "<input name='continue'  id='continue'  type='button' class='accountlabButton' value='" . $BL->props->lang['continue'] . "'     onclick=\"javascript:xajax_reload('step3','step3');\" />&nbsp;";
        $continue3 = "<input name='continue'  id='continue'  type='button' class='accountlabButton' value='" . $BL->props->lang['continue'] . "'     onclick=\"javascript:xajax_reload('step6','step6');\" />&nbsp;";
        $continue_without_special = "<input name='continue' id='continue' type='button' class='accountlabButton' value='" . $BL->props->lang['continue_without_special'] . "' onclick=\"javascript:xajax_reload('step6','step6');\" />&nbsp;";
        $continue_verify = "<input name='continue' id='continue' type='button' class='accountlabButton' value='" . $BL->props->lang['continue'] . "'  onclick=\"javascript:xajax_step3_verifyUser(xajax.getFormValues('order_form'));\" />&nbsp;";
        $finish    = "<input type='button' name='finish' id='finish' class='accountlabButton' value='" . $BL->props->lang['finish'] . "' onclick=\"javascript:xajax_finish(xajax.getFormValues('order_form'));\" />";
        $pay       = "<input type='button' name='pay' id='pay' class='accountlabButton' value='" . $BL->props->lang['Pay'] . "' onclick=\"javascript:xajax_pay(xajax.getFormValues('order_form'));\" />";
        foreach($buttons as $btn)
        {
            $btns .= ${$btn};
        }
        $objResponse->addAssign("foot", "innerHTML", $btns);
        return $objResponse;
    }
    function resetcartdata($step='')
    {
        if($step=='step1' || empty($step))
        {
            $_SESSION['sub_total']  = 0;
            $_SESSION['tax']        = 0;
            $_SESSION['total']      = 0;
            $_SESSION['group_id']   = null;
            $_SESSION['product_id'] = null;
            $_SESSION['addon_ids']  = null;
            $_SESSION['bill_cycle'] = null;
            $step = '';
        }
        if($step=='step2' || empty($step))
        {
            $_SESSION['sld']   = null;
            $_SESSION['tld']   = null;
            $_SESSION['type']  = null;
            $_SESSION['tld_price'] = null;
            $_SESSION['year']  = null;
            $step = '';
        }
        if($step=='step3' || empty($step))
        {
            $_SESSION['customer']= null;
            $_SESSION['specials']= null;
            $step = '';
        }
        if($step=='step4' || empty($step))
        {
            $step = '';
        }
        if($step=='step5' || empty($step))
        {
            $step = '';
        }
        if($step=='step6' || empty($step))
        {
            $step = '';
        }
        if($step=='step7' || empty($step))
        {
            $step = '';
        }
    }
    function reload($step='',$reset_data='',$theme='',$lang='')
    {
        global $GET_STR, $BL;
        resetcartdata($reset_data);
        $_SESSION['cmd'] = (empty($step)?"step1":$step);
        if(!empty($theme))$_SESSION['force_theme'] = $theme;
        if(!empty($lang)) $_SESSION['force_lang']  = $lang;
        if(!empty($step)) $_SESSION['force_step']  = $step;//when cmd is blocked in mod_security
        $objResponse = new xajaxResponse(CHARSET);
        $objResponse->addRedirect($BL->conf['path_url']."/".$GET_STR);
        return $objResponse;
    }
    function step1()
    {
        $objResponse= new xajaxResponse(CHARSET);
        $objResponse->loadXML(step1_ShowGroups());
        $objResponse->loadXML(step1_buyNow());
        return $objResponse;
    }
    function step1_buyNow()
    {
        global $cmd;
        $objResponse= new xajaxResponse(CHARSET);
        if(isset($_SESSION['group_id'])  && $cmd == "step1")
        {
            $objResponse->loadXML(step1_selectGroup($_SESSION['group_id']));
            if(isset($_SESSION['product_id']))
            {
                $objResponse->loadXML(step1_selectProduct($_SESSION['product_id'],true));
                if(isset($_SESSION['bill_cycle']))
                {
                    $objResponse->loadXML(step1_selectCycle($_SESSION['bill_cycle']));
                }
            }
        }
        return $objResponse;
    }
    function step1_selectGroup($group_id)
    {
        $_SESSION['group_id'] = $group_id;
        $objResponse= new xajaxResponse(CHARSET);
        if(empty($_SESSION['group_id']))
        {
            $objResponse->loadXML(reload('step2'));
        }
        else
        {
            $objResponse->loadXML(step1_HideGroups($group_id));
            $objResponse->loadXML(step1_ShowProducts($group_id));
            $objResponse->addRemove("group_id".$group_id);
        }
        return $objResponse;
    }
    function step1_selectProduct($product_id, $buy_now=false)
    {
        global $BL;
        $_SESSION['product_id'] = $product_id;
        if(!$buy_now)
        {
            $_SESSION['addon_ids']  = null;
            $_SESSION['bill_cycle'] = null;
        }
        $objResponse= new xajaxResponse(CHARSET);
        $objResponse->loadXML(updateBasket());
        $objResponse->loadXML(step1_ShowCycles());
        $objResponse->addAssign("addon_div_"  . $_SESSION['group_id'], "innerHTML", "&#160;");
        $objResponse->addScriptCall("toggleTbodyOff", "addon_sec_"  . $_SESSION['group_id']);
        return $objResponse;
    }
    function step1_selectCycle($bill_cycle)
    {
        global $BL;
        $_SESSION['bill_cycle'] = $bill_cycle;
        $objResponse= new xajaxResponse(CHARSET);
        $objResponse->loadXML(updateBasket());
        $objResponse->loadXML(step1_ShowAddons());
        return $objResponse;
    }
    function step1_addAddon($addon_id)
    {
        global $BL;
        if(array_search($addon_id,$_SESSION['addon_ids'])===false)
        {
            $_SESSION['addon_ids'][] = $addon_id;
        }
        $_SESSION['addon_ids'] = count($_SESSION['addon_ids'])?$_SESSION['addon_ids']:array();
        $_SESSION['addon_ids'] = $BL->utils->Get_Uniques_Array($_SESSION['addon_ids']);
        $objResponse= new xajaxResponse(CHARSET);
        $objResponse->loadXML(updateBasket());
        return $objResponse;
    }
    function step1_removeAddon($addon_id)
    {
        global $BL;
        $temp = array();
        foreach($_SESSION['addon_ids'] as $id)
        {
            if($id!=$addon_id)
            {
                $temp[] = $id;
            }
        }
        $_SESSION['addon_ids'] = count($temp)?$temp:array();
        $_SESSION['addon_ids'] = $BL->utils->Get_Uniques_Array($_SESSION['addon_ids']);
        $objResponse= new xajaxResponse(CHARSET);
        $objResponse->loadXML(updateBasket());
        return $objResponse;
    }
    function step1_ShowAddons()
    {
        global $BL;
        $bill_cycle = $_SESSION['bill_cycle'];
        $product_id = $_SESSION['product_id'];
        $product    = $BL->products->hasAnyOne(array("WHERE `plan_price_id`=".intval($product_id)));
        $BL->addons->setOrder("addon_index");
        $addons     = $BL->addons->getAvailable($product_id);
        $addon_sec = "&#160;";
        if(count($addons))
        {
            $addon_sec = "<fieldset class='accountlabFormTABLE' style='width:90%'>" .
            "<legend><b>".$BL->props->lang['~addons']."</b></legend>" .
            "<table width='100%' border='0' cellspacing='0' cellpadding='0' align='center'>";
            foreach($addons as $addon_id)
            {
                $addon_data  = $BL->addons->hasAnyOne(array("WHERE `addon_id`=".intval($addon_id)));
                $cycle_amounts= $BL->addons->getCycles($addon_id);
                $checked     = (is_array($_SESSION['addon_ids']) && array_search($addon_id,$_SESSION['addon_ids'])!==false)?"checked":"";
                $addon_sec .= "<tr>";
                $addon_sec .= "<td width='1%' ><input type='checkbox' id='addon_ids[]' name='addon_ids[]' value='".$addon_id."' ".$checked." onchange=\"javascript:if(this.checked==true)xajax_step1_addAddon('" . $addon_id . "');else xajax_step1_removeAddon('" . $addon_id . "');\" /></td>";
                $addon_sec .= "<td width='20%'>".$addon_data['addon_name']."</td>";
                $addon_sec .= "<td align='right'><b>" . $addon_data['addon_setup']>0?$BL->props->lang['setup_fee']:'' . ":</b></td>";
                $addon_sec .= "<td align='right'>". $addon_data['addon_setup']>0?$BL->displayPrice($addon_data['addon_setup'], true):''. "</td>";
                $addon_sec .= "<td align='right'><b>" . $BL->props->parseLang($BL->props->cycles[$bill_cycle]) . "</b></td>";
                $addon_sec .= "<td align='right'>" . $BL->displayPrice(($product['default_cycle']==0)?0:$cycle_amounts[$BL->props->cycles[$bill_cycle]], true)."</td>";
                $addon_sec .= "</tr>";
            }
            $addon_sec .= "</table>" .
            "</fieldset>";
        }
        $objResponse= new xajaxResponse(CHARSET);
        $objResponse->addAssign("addon_div_"  . $_SESSION['group_id'], "innerHTML", $addon_sec);
        if(count($addons))
        {
            $objResponse->addScriptCall("toggleTbodyOn", "addon_sec_"  . $_SESSION['group_id']);
        }
        else
        {
            $objResponse->addScriptCall("toggleTbodyOff", "addon_sec_"  . $_SESSION['group_id']);
        }
        return $objResponse;
    }
    function step1_ShowCycles()
    {
        global $BL;
        $product_id       = $_SESSION['product_id'];
        $product          = $BL->products->hasAnyOne(array("WHERE `plan_price_id`=".intval($product_id)));
        $products_cycles  = $BL->products->getCycles($product_id);
        $temp_cycle_sum   = 0;
        foreach($BL->props->cycles as $k1=>$v1)
        {
            $temp_cycle_sum = $temp_cycle_sum + $products_cycles[$v1];
        }
        $objResponse= new xajaxResponse(CHARSET);
        if ($temp_cycle_sum || ($temp_cycle_sum==0 && $product['default_cycle']==13))
        {
            $bill_div_desc = $BL->props->lang['pay_cycle'];
            $select_tag  = "<select name='bill_cycle' id='bill_cycle' class='accountlabInput' onchange=\"javascript:xajax_step1_selectCycle(xajax.$('bill_cycle').value);\">";
            $select_tag .= "<option>" . $BL->props->lang['select_a_bill_cycle'] . "</option>";
            foreach($BL->props->cycles as $k1=>$v1)
            {
                if ($products_cycles[$v1]>0 || ($temp_cycle_sum==0 && $product['default_cycle']==13))
                {
                    $display_string = $BL->props->lang[$v1];
                    $display_string = $BL->props->lang[$v1] . " (" . $BL->displayPrice($products_cycles[$v1]) . ")";
                    if((isset($_SESSION['bill_cycle']) && $_SESSION['bill_cycle']==$k1))
                    {
                        $select_tag .= "<option value='".$k1."' selected>" . $display_string . "</option>";
                    }
                    else
                    {
                        $select_tag .= "<option value='".$k1."'>" . $display_string . "</option>";
                    }
                }
            }
            $select_tag .= "</select>";
        }
        elseif(!empty($product['default_cycle']) && $product['default_cycle']!=13)
        {
            $objResponse->addScriptCall("xajax_step1_selectCycle",$product['default_cycle']);
            $bill_div_desc = "&#160;";
            $select_tag    = "&#160;";
        }
        else
        {
            $objResponse->addScriptCall("xajax_step1_selectCycle",12);
            $bill_div_desc = "&#160;";
            $select_tag    = "&#160;";
        }
        $objResponse->addAssign("prod_desc_" . $_SESSION['group_id'], "innerHTML", $product['plan_desc']);
        $objResponse->addAssign("bill_div_"  . $_SESSION['group_id'], "innerHTML", $bill_div_desc);
        $objResponse->addAssign("bill_opt_"  . $_SESSION['group_id'], "innerHTML", $select_tag);
        return $objResponse;
    }
    function step1_ShowProducts()
    {
        global $BL;
        $group_id   = $_SESSION['group_id'];
        $select_tag = "<select name='product_id' id='product_id' class='accountlabInput' onchange=\"javascript:xajax_step1_selectProduct(xajax.$('product_id').value);\">";
        $select_tag.= "<option>" . $BL->props->lang['select_a_product'] . "</option>";
        $BL->products->setOrder("plan_index");
        $sorted_prods = array();
        foreach($BL->products->getAvailable($group_id) as $product_id)
        {
            $temp = $BL->products->getByKey($product_id);
            $sorted_prods[$temp['plan_index']] = $product_id;
        }
        ksort($sorted_prods);
        foreach($sorted_prods as $product_id)
        {
            $product      = $BL->products->getByKey($product_id);
            $product_name = $BL->getFriendlyName($product_id);
            $price_tag    = '';
            if($BL->conf['show_price'] && $product['host_setup_fee']>0)
            {
                $price_tag = " (" . $BL->props->lang['setup_fee'] . ": " . $BL->displayPrice($product['host_setup_fee']) . ")";
            }
            if((isset($_SESSION['product_id']) && $_SESSION['product_id']==$product_id))
            {
                $select_tag.= "<option value='".$product_id."' selected>" . $product_name . $price_tag ."</option>";
            }
            else
            {
                $select_tag.= "<option value='".$product_id."'>" . $product_name . $price_tag ."</option>";
            }
        }
        $select_tag.= "</select>";
        $objResponse = new xajaxResponse(CHARSET);
        $objResponse->addAssign("prod_div_" . $group_id, "innerHTML", $select_tag);
        $objResponse->addScriptCall("toggleTbodyOn", "prod_sec_" . $group_id);
        return $objResponse;
    }
    function step1_ShowGroups($hide_group_id=null)
    {
        global $groups;
        $objResponse= new xajaxResponse(CHARSET);
        foreach($groups as $group)
        {
            $objResponse->addScriptCall("toggleTbodyOn", "group_section_" . $group['group_id']);
        }
        $objResponse->addScriptCall("toggleTbodyOn", "group_section_0");
        if($hide_group_id!=null)
        {
            $objResponse->addScriptCall("toggleTbodyOn", "group_section_".$hide_group_id);
        }
        return $objResponse;
    }
    function step1_HideGroups($show_group_id=null)
    {
        global $groups;
        $objResponse= new xajaxResponse(CHARSET);
        foreach($groups as $group)
        {
            $objResponse->addScriptCall("toggleTbodyOff", "group_section_" . $group['group_id']);
        }
        $objResponse->addScriptCall("toggleTbodyOff", "group_section_0");
        if($show_group_id!=null)
        {
            $objResponse->addScriptCall("toggleTbodyOn", "group_section_".$show_group_id);
        }
        return $objResponse;
    }
    function step2()
    {
        global $show_tlds ,$show_subdomains, $show_owndomain;
        $_SESSION['group_id']   = isset($_SESSION['group_id'])?$_SESSION['group_id']:0;
        $_SESSION['product_id'] = isset($_SESSION['product_id'])?$_SESSION['product_id']:0;
        $_SESSION['bill_cycle'] = isset($_SESSION['bill_cycle'])?$_SESSION['bill_cycle']:12;
        $_SESSION['addon_ids']  = isset($_SESSION['addon_ids'])?$_SESSION['addon_ids']:array();
        $objResponse= new xajaxResponse(CHARSET);
        if(empty($_SESSION['product_id']) && $show_tlds)
        {
            $objResponse->loadXML(step2_selectType(1));
        }
        elseif($show_tlds  && !$show_subdomains && !$show_owndomain)
        {
            $objResponse->loadXML(step2_selectType(1));
        }
        elseif(!$show_tlds  && $show_subdomains && !$show_owndomain)
        {
            $objResponse->loadXML(step2_selectType(2));
        }
        elseif(!$show_tlds  && !$show_subdomains && $show_owndomain)
        {
            $objResponse->loadXML(step2_selectType(3));
        }
        $objResponse->loadXML(step2_buyNow());
        $objResponse->loadXML(updateBasket());
        return $objResponse;
    }
    function step2_buyNow()
    {
        global $cmd;
        $_SESSION['type']= isset($_SESSION['type'])?$_SESSION['type']:(isset($_SESSION['subdomain'])?2:1);
        $_SESSION['sld']= isset($_SESSION['sld'])?$_SESSION['sld']:(isset($_SESSION['domain'])?$_SESSION['domain']:'');
        $_SESSION['tld']= isset($_SESSION['tld'])?$_SESSION['tld']:(isset($_SESSION['ext'])?$_SESSION['ext']:'');
        $objResponse = new xajaxResponse(CHARSET);
        if(!empty($_SESSION['sld']) && !empty($_SESSION['tld']) && $cmd=="step2")
        {
            $objResponse->loadXML(step2_selectType($_SESSION['type']));
            if($_SESSION['type']!=3)
            {
                $objResponse->loadXML(step2_whois($_SESSION['type'],$_SESSION['sld'],$_SESSION['tld']));
            }
        }
        return $objResponse;
    }
    function step2_selectType($type)
    {
        global $BL, $tlds, $subdomains;
        $legend    = $BL->props->lang['use_own_domain'];
        $sld_field = "<input type='text' name='sld' id='sld' class='accountlabInput' size='35' />";
        $tld_field = "<input type='text' name='tld' id='tld' class='accountlabInput' size='6'  />";
        $btn_field = "&#160;";
        if($type==1)
        {
            $legend    = $BL->props->lang['search_for_domain'];
            $tld_field = "<select name='tld' id='tld' class='accountlabInput'>";
            $tlds_added= array ();
            foreach ($tlds as $t)
            {
                if (array_search($t['dom_ext'], $tlds_added) === false)
                {
                    $tlds_added[]= $t['dom_ext'];
                    $tld_field  .= "<option value='" . $t['dom_ext'] . "'>" . $t['dom_ext'] . "</option>";
                }
            }
            $tld_field .= "</select>";
            $btn_field  = "<input type='button' class='accountlabButton' name='Button1' id='Button1' value='" . $BL->props->lang['check'] . "' onclick=\"javascript:xajax_step2_whois(1,xajax.$('sld').value,xajax.$('tld').value);\" />";
        }
        if($type==2)
        {
            $legend     = $BL->props->lang['search_for_subdomain'];
            $tld_field  = "<select name='tld' id='tld' class='accountlabInput'>";
            foreach ($subdomains as $subdomain)
            {
                $tld_field  .= "<option value='" . $subdomain['maindomain'] . "'>" . $subdomain['maindomain'] . "</option>";
            }
            $tld_field .= "</select>";
            $btn_field  = "<input type='button' class='accountlabButton' name='Button1' id='Button1' value='" . $BL->props->lang['check'] . "' onclick=\"javascript:xajax_step2_whois(2,xajax.$('sld').value,xajax.$('tld').value);\" />";
        }
        if($type==3)
        {
            $btn_field  = "<input type='button' class='accountlabButton' name='Button1' id='Button1' value='" . $BL->props->lang['add'] . "' onclick=\"javascript:if(xajax.$('sld').value!='' && xajax.$('tld').value!='')xajax_step2_addDomain(3,xajax.$('sld').value,xajax.$('tld').value);\" />";
        }

        $objResponse = new xajaxResponse(CHARSET);
        $objResponse->addAssign("domain_sec_legend", "innerHTML", "<b>".$legend."</b>");
        $objResponse->addAssign("tld_field", "innerHTML", $tld_field);
        $objResponse->addAssign("sld_field", "innerHTML", $sld_field);
        $objResponse->addAssign("btn_field", "innerHTML", $btn_field);
        $objResponse->addScriptCall("toggleTbodyOff", "domain_type_sec");
        $objResponse->addScriptCall("toggleTbodyOn" , "domain_search_sec");
        $objResponse->addScript("xajax.$('sld').focus();");
        return $objResponse;
    }
    function step2_whois($type,$sld,$tld)
    {
        global $BL, $tlds;
        $objResponse = new xajaxResponse(CHARSET);
        $whois_result = "<b>".$sld.".".$tld." ".$BL->props->lang['not_available']."</b>";
        if($type==1)
        {
            $whois  = $BL->whois->checkDomain($sld, $tld);
            if (!is_numeric($whois))
            {
                $whois_result = "<b>".$whois."</b>";
            }
            if (!$whois)
            {
                $whois_result = "<fieldset class='accountlabFormTABLE' style='width:90%'>" .
                "<legend><b>".$sld.".".$tld." ".$BL->props->lang['is_available']."</b></legend>";

                $available_domains = array();
                foreach ($tlds as $t)
                {
                    if ($t['dom_ext'] == $tld)
                    {
                        $available_domains[$t['dom_period']]= $t;
                    }
                }
                ksort($available_domains);
                $count = 0;
                foreach ($available_domains as $t1)
                {
                    $count++;
                    #if ($count == count($available_domains))
                    if ($count == 1)
                    {
                        $pre_select    = $t1['price_id'];
                        $whois_result .= "<input type='radio' name='dom_reg_year' id='dom_reg_year' checked  class='accountlabInput' value='" . $t1['dom_period'] . "' onclick=\"javascript:xajax_step2_addDomain(" . $type . ",xajax.$('sld').value,xajax.$('tld').value, ".$t1['dom_price']." ,".$t1['dom_period'].");\" />&nbsp;";
                        $t0 = $t1;
                    }
                    else
                    {
                        $whois_result .= "<input type='radio' name='dom_reg_year' id='dom_reg_year' class='accountlabInput' value='" . $t1['dom_period'] . "' onclick=\"javascript:xajax_step2_addDomain(" . $type . ",xajax.$('sld').value,xajax.$('tld').value, ".$t1['dom_price']." ,".$t1['dom_period'].");\" />&nbsp;";
                    }
                    $period_display = $t1['dom_period'] . " " . $BL->props->lang['year'];
                    if($t1['dom_period']==99)
                    {
                        $period_display = $BL->props->lang['one_time'];
                    }
                    $whois_result .= $BL->props->lang['register_domain_for'] . " " . $period_display . " (" . $BL->displayPrice($t1['dom_price']) . ")<br />";
                }
                $whois_result .= "</fieldset>";
                $objResponse->loadXML(step2_addDomain($type,$sld,$tld,$t0['dom_price'],$t0['dom_period']));
            }
        }
        if($type==2)
        {
            $isAvailable  = $BL->subdomains->isAvailable($sld, $tld);
            if (!is_numeric($isAvailable))
            {
                $whois_result = "<b>".$isAvailable."</b>";
            }
            if ($isAvailable)
            {
                $whois_result = "<b>".$sld.".".$tld." ".$BL->props->lang['is_available']."</b>";
                $subdomain    = $BL->subdomains->find(array("WHERE `maindomain`='".$BL->utils->quoteSmart($tld)."'"));
                $cycle_data   = $BL->subdomains->getCycles(isset($subdomain[0]['main_id'])?$subdomain[0]['main_id']:0);
                $cycle_name   = $BL->props->cycles[($_SESSION['bill_cycle'])?$_SESSION['bill_cycle']:12];
                $objResponse->loadXML(step2_addDomain($type,$sld,$tld,$cycle_data[$cycle_name]));
            }
        }
        $objResponse->addAssign("whois_result", "innerHTML","<br />".$whois_result);
        return $objResponse;
    }
    function step2_addDomain($type,$sld,$tld,$tld_price=0,$year=1)
    {
        $_SESSION['sld']   = $sld;
        $_SESSION['tld']   = $tld;
        $_SESSION['type']  = $type;
        $_SESSION['tld_price']  = $tld_price;
        $_SESSION['year']  = $year;
        $objResponse = new xajaxResponse(CHARSET);
        if($type==3)
        {
            $objResponse->loadXML(reload('step3','step4'));
        }
        else
        {
            $objResponse->loadXML(updateBasket());
        }
        return $objResponse;
    }
    function step3()
    {
        $objResponse= new xajaxResponse(CHARSET);
        $objResponse->loadXML(updateBasket());
        return $objResponse;
    }
    function step3_memberType($member)
    {
        $objResponse= new xajaxResponse(CHARSET);
        $objResponse->loadXML(updateBasket());
        $objResponse->addScriptCall("toggleTbodyOn", "extra_user_info_sec");
        if($member)
        {
            $objResponse->addScriptCall("toggleTbodyOn" , "existing_user_sec");
            $objResponse->addScriptCall("toggleTbodyOff" , "new_user_sec");
        }
        else
        {
            $objResponse->addScriptCall("toggleTbodyOff" , "existing_user_sec");
            $objResponse->addScriptCall("toggleTbodyOn" , "new_user_sec");
        }
        return $objResponse;
    }
    function step3_listStates($CC, $SS)
    {
        global $BL;
        $objResponse = new xajaxResponse(CHARSET);
        $states      = $BL->props->allstates[$CC];
        if (count($states) && $states[0] != "N/A")
        {
            $str  = "<select name='state".$SS."' id='state".$SS."' class='accountlabInput'>";
            $str .= "<option>" . $BL->props->lang['select_state'] . "</option>";
            foreach ($states as $k=>$v)
            {
                if (!empty ($v))
                {
                    $str .= "<option value='" . (is_numeric($k)?trim($v):trim($k)) . "'>" . trim($v) . "</option>";
                }
            }
            $str .= "</select>";
        }
        else
        {
            $str  = "<input type='text' size='25' name='state".$SS."' id='state".$SS."' class='accountlabInput' />";
        }
        $objResponse->addAssign("state_selection".$SS, "innerHTML", $str);
        return $objResponse;
    }
    function step3_verifyUser($form_data)
    {
        global $BL,$conf,$custom_fields;
        $err            = $BL->customers->validate($form_data,$custom_fields);
        $product_data   = $BL->products->find(array("WHERE `plan_price_id`='".(isset($_SESSION['product_id'])?$BL->utils->quoteSmart($_SESSION['product_id']):0)."'"));
        $server_default = $BL->products->getServerForProduct(isset($_SESSION['product_id'])?$_SESSION['product_id']:0);
        if (empty($err) && isset($product_data[0]['acc_method']) && $product_data[0]['acc_method'] == 2 && !empty ($form_data['dom_user']))
        {
            if(!empty($server_default['username_min_length']) && strlen($form_data['dom_user'])<$server_default['username_min_length'])
            {
                $err = $BL->props->lang['username_is_short'].$server_default['username_min_length'];
            }
            if(!empty($server_default['username_max_length']) && strlen($form_data['dom_user'])>$server_default['username_max_length'])
            {
                $err = $BL->props->lang['username_is_large'].$server_default['username_max_length'];
            }
            if ($BL->checkAccountExistInServer($server_default, $form_data['dom_user']))
            {
                $err = $BL->props->lang['err_user_exist'];
            }
        }

        $form_data['selected_server_id'] = isset($server_default['server_id'])?$server_default['server_id']:0;

        $objResponse = new xajaxResponse(CHARSET);
        if(empty($err))
        {
            $objResponse->addScriptCall("toggleTbodyOff" , "error_section");
            $_SESSION['customer'] = $form_data;
            $objResponse->loadXML(logUser($_SESSION['sld'].".".$_SESSION['tld']."-".$BL->getFriendlyName($_SESSION['product_id'])));
            $AVAILABLE_SPECIALS   = getQualifiedSpecials();
            $_SESSION['specials'] = array();
            foreach($AVAILABLE_SPECIALS as $special)
            {
                $_SESSION['specials'][] = $special['special_id'];
            }
            if(count($AVAILABLE_SPECIALS)>1)//display special chooser
            {
                $objResponse->loadXML(reload('step4','step4'));
            }
            elseif(isset($AVAILABLE_SPECIALS[0]) && $AVAILABLE_SPECIALS[0]['new_order'])//display new special free order
            {
                $_SESSION['specials']['SELECTED'] = $AVAILABLE_SPECIALS[0]['special_id'];
                $objResponse->loadXML(reload('step5','step5'));
            }
            elseif(isset($AVAILABLE_SPECIALS[0]))
            {
                $_SESSION['specials']['SELECTED'] = $AVAILABLE_SPECIALS[0]['special_id'];
                $objResponse->loadXML(reload('step6','step6'));
            }
            else//proceed as is
            {
                $objResponse->loadXML(reload('step6','step6'));
            }
        }
        else
        {
            $objResponse->addScriptCall("toggleTbodyOn" , "error_section");
        }
        $objResponse->addAssign("error_msg", "innerHTML", $err);
        return $objResponse;
    }
    function getQualifiedSpecials()
    {
        global $BL;
        $cust_data = $_SESSION['customer'];
        if($_SESSION['customer']['member']=='1')
        {
            $cust_data = $BL->customers->hasAnyOne(array("WHERE `email`='".$BL->utils->quoteSmart($_SESSION['customer']['existing_email'])."'"));
            $cust_data['disc_token_code'] = $_SESSION['customer']['disc_token_code'];
            $cust_data['dom_user'] = $_SESSION['customer']['dom_user'];
            $cust_data['dom_pass'] = $_SESSION['customer']['dom_pass'];
        }
        /*
        * Calculate Specials If Apply
        * RULE1: If customer has discount and if not cummulative, we dont offer specials
        */
        $AVAILABLE_SPECIALS       = array();
        $cust_discount            = (isset($cust_data['discount'])?$cust_data['discount']:0)/100;
        $cust_discount_cumulative = (isset($cust_data['cumulative'])?$cust_data['cumulative']:1);
        if (($cust_discount == 0 || $cust_discount_cumulative == 1) && empty ($cust_data['disc_token_code']))
        {
            $all_specials = $BL->specials->getAvailable();
            foreach($all_specials as $special)
            {
                if ($special['special_net'] <= $_SESSION['sub_total'])
                {
                    if ($BL->specials->planpass($_SESSION['product_id'],$special) && $BL->specials->tldpass($_SESSION['tld'],$_SESSION['type'],$special))
                    {
                        $AVAILABLE_SPECIALS[] = $special;
                    }
                }
            }
        }
        return $AVAILABLE_SPECIALS;
    }
    function step4()
    {
        $objResponse= new xajaxResponse(CHARSET);
        $objResponse->loadXML(updateBasket());
        return $objResponse;
    }
    function step4_selectSpecial($special_id,$new_order)
    {
        $_SESSION['specials']['SELECTED'] = $special_id;
        $objResponse= new xajaxResponse(CHARSET);
        if($new_order)
        {
            $objResponse->loadXML(reload('step5','step5'));
        }
        else
        {
            $objResponse->loadXML(reload('step6','step6'));
        }
        return $objResponse;
    }
    function step5()
    {
        $objResponse= new xajaxResponse(CHARSET);
        $objResponse->loadXML(updateBasket());
        return $objResponse;
    }
    function step5_whois($type,$sld,$tld)
    {
        global $BL, $tlds;
        $objResponse = new xajaxResponse(CHARSET);
        $whois_result = "<b>".$sld.".".$tld." ".$BL->props->lang['not_available']."</b>";
        if($type==1)
        {
            $whois  = $BL->whois->checkDomain($sld, $tld);
            if (!is_numeric($whois))
            {
                $whois_result = "<b>".$whois."</b>";
            }
            if (!$whois)
            {
                $whois_result = "<b>".$sld.".".$tld." ".$BL->props->lang['is_available']."</b>";
                $objResponse->loadXML(step5_addDomain($type,$sld,$tld));
                $focus_element = "continue";
            }
        }
        if($type==2)
        {
            $isAvailable  = $BL->subdomains->isAvailable($sld, $tld);
            if (!is_numeric($isAvailable))
            {
                $whois_result = "<b>".$isAvailable."</b>";
            }
            if ($isAvailable)
            {
                $whois_result = "<b>".$sld.".".$tld." ".$BL->props->lang['is_available']."</b>";
                $objResponse->loadXML(step5_addDomain($type,$sld,$tld));
                $focus_element = "continue";
            }
        }
        $objResponse->addAssign("special_whois_result", "innerHTML",$whois_result);
        if(isset($focus_element))
        {
            $objResponse->addScript("xajax.$('".$focus_element."').focus();");
        }
        return $objResponse;
    }
    function step5_addDomain($type,$sld, $tld)
    {
        $_SESSION['specials']['SELECTED_TYPE'] = $type;
        $_SESSION['specials']['SELECTED_SLD']  = $sld;
        $_SESSION['specials']['SELECTED_TLD']  = $tld;
        $objResponse= new xajaxResponse(CHARSET);
        $objResponse->loadXML(updateBasket());
        return $objResponse;
    }
    function step5_addProduct($product_id)
    {
        $_SESSION['specials']['SELECTED_PRODUCT'] = $product_id;
        $objResponse= new xajaxResponse(CHARSET);
        $objResponse->loadXML(updateBasket());
        return $objResponse;
    }
    function step5_addAddon($addon_id)
    {
        $_SESSION['specials']['SELECTED_ADDON'] = $addon_id;
        $objResponse= new xajaxResponse(CHARSET);
        $objResponse->loadXML(updateBasket());
        return $objResponse;
    }
    function step6()
    {
        $objResponse= new xajaxResponse(CHARSET);
        $objResponse->loadXML(toggleButtons(array("back3")));
        return $objResponse;
    }
    function step6_selectPaymentMethod($payment_method)
    {
        $_SESSION['payment_method'] = $payment_method;
        $objResponse= new xajaxResponse(CHARSET);
        $objResponse->loadXML(reload('step6','step6'));
        return $objResponse;
    }
    function step6_agree($agree)
    {
        global $BL,$INVOICE_DATA;
        $objResponse = new xajaxResponse(CHARSET);
        if($agree)
        {
            if($BL->pp_send_method[$_SESSION['payment_method']] == "DIRECT" || $INVOICE_DATA['gross_amount']==0)
            {
                $objResponse->loadXML(toggleButtons(array("finish")));
                $focus_element = "finish";
            }
            else
            {
                $objResponse->loadXML(toggleButtons(array("pay")));
                $focus_element = "pay";
            }
        }
        else
        {
            $objResponse->loadXML(toggleButtons(array("back3")));
        }
        if(isset($focus_element))
        {
            $objResponse->addScript("xajax.$('".$focus_element."').focus();");
        }
        return $objResponse;
    }
    function finish($form_data)
    {
        global $BL,$INVOICE_DATA;
        prepareFinalData($INVOICE_DATA,$form_data);
        $objResponse= new xajaxResponse(CHARSET);
        //$objResponse->addConfirmCommands(1,$BL->props->lang['confirm_submit']);
        $objResponse->loadXML(reload('step7','step7'));
        return $objResponse;
    }
    function pay($form_data)
    {
        global $BL,$INVOICE_DATA;
        prepareFinalData($INVOICE_DATA,$form_data);
        $objResponse= new xajaxResponse(CHARSET);
        //$objResponse->addConfirmCommands(1,$BL->props->lang['confirm_submit']);
        $objResponse->loadXML(reload('step7','step7'));
        return $objResponse;
    }
    function prepareFinalData($INVOICE_DATA, $PAYMENT_DATA)
    {
        $_SESSION['CUSTOMER']= $INVOICE_DATA['CUSTOMER_DATA'];
        $_SESSION['INVOICE'] = array();
        foreach($INVOICE_DATA as $key=>$value)
        {
            if($key!="CUSTOMER_DATA" && $key!="ORDER_DATA" && $key!="TAX_DATA")
            {
                $_SESSION['INVOICE'][$key] = $value;
            }
        }
        foreach($PAYMENT_DATA as $key=>$value)
        {
            $_SESSION['INVOICE'][$key] = $value;
        }
        $_SESSION['ORDER'] = array();
        $_SESSION['ORDER']['group_id']   = $_SESSION['group_id'];
        $_SESSION['ORDER']['product_id'] = $_SESSION['product_id'];
        $_SESSION['ORDER']['addon_ids']  = $_SESSION['addon_ids'];
        $_SESSION['ORDER']['bill_cycle'] = $_SESSION['bill_cycle'];
        $_SESSION['ORDER']['sld']        = $_SESSION['sld'];
        $_SESSION['ORDER']['tld']        = $_SESSION['tld'];
        $_SESSION['ORDER']['type']       = $_SESSION['type'];
        $_SESSION['ORDER']['tld_price']  = $_SESSION['tld_price'];
        $_SESSION['ORDER']['year']       = $_SESSION['year'];
        foreach($INVOICE_DATA['ORDER_DATA'] as $key=>$value)
        {
            $_SESSION['ORDER'][$key] = $value;
        }
        $_SESSION['SPECIAL'] = $_SESSION['specials'];
        $_SESSION['TAX']     = $INVOICE_DATA['TAX_DATA'];
    }
    function step7()
    {
        global $BL;
        $objResponse = new xajaxResponse(CHARSET);
        $objResponse->addCreateInput("click_btn", "submit", "submit", "submit");
        $objResponse->addAssign("submit", "value", $BL->props->lang['Click_to_pay']);
        $objResponse->addScript("xajax.$('submit').focus();");
        $objResponse->addScript("xajax.$('submit').click()");
        $objResponse->addScript("xajax.$('order_form').submit()");
        return $objResponse;
    }
    function step8()
    {
        $objResponse = new xajaxResponse(CHARSET);
        return $objResponse;
    }
    function logUser($items_in_basket)
    {
        global $BL;
        $objResponse = new xajaxResponse(CHARSET);
        //log user
        $name        = $BL->utils->quoteSmart(isset($_SESSION['customer']['name'])?$_SESSION['customer']['name']:"");
        $log_user_id = isset($_SESSION['log_user_id'])?intval($_SESSION['log_user_id']):0;
        $log_time    = date('Y-m-d H:i:s');
        $log_user_ip = $BL->utils->realip();
        $log_user_name = $BL->utils->quoteSmart(isset($_SESSION['customer']['name'])?$_SESSION['customer']['name']:"");
        $log_user_login= $BL->utils->quoteSmart(isset($_SESSION['customer']['email'])?$_SESSION['customer']['email']:"");
        $log_user_email= $log_user_login;
        $entry_time    = date('Y-m-d H:i:s');
        $log_session_id = session_id();
        $log_page       = 'order_page';
        $sqlSELECT      = "SELECT * FROM `online_users` WHERE `visiting_page`='order_page' AND `log_session_id` = '$log_session_id' AND `user_type` = '0'";
        $select         = $BL->dbL->executeSELECT($sqlSELECT);
        if (count($select)>0) //update
        {
            if (!empty ($name))
                $sqlUPDATE= "UPDATE  `online_users`
                SET     `user_name`         = '$name'
                WHERE   `log_session_id`    = '$log_session_id'
                AND     `visiting_page`     = 'order_page'
                AND     `user_type`         = '0'";
            else
                $sqlUPDATE= "UPDATE  `online_users`
                SET     `log_time`          = '$log_time',
                `user_id`           = '$log_user_id',
                `user_ip`           = '$log_user_ip',
                `user_name`         = '$log_user_name',
                `user_login`        = '$log_user_login',
                `user_email`        = '$log_user_email',
                `items_in_basket`   = '$items_in_basket'
                WHERE   `log_session_id`    = '$log_session_id'
                AND     `visiting_page`     = 'order_page'
                AND     `user_type`         = '0'";
            $BL->dbL->executeUPDATE($sqlUPDATE);
        }
        else //insert
        {
            $sqlINSERT= "INSERT INTO `online_users` (
            `log_time` , `user_type` , `user_id` , `user_ip` , `user_name` , `user_login` , `user_email` , `visiting_page` , `items_in_basket` , `entry_time`, `log_session_id`
            )
            VALUES (
            '$log_time', '0', '$log_user_id', '$log_user_ip', '$log_user_name', '$log_user_login', '$log_user_email', '$log_page', '".$BL->utils->quoteSmart($items_in_basket)."', '$entry_time', '$log_session_id'
            )";
            $BL->dbL->executeINSERT($sqlINSERT);
        }
        return $objResponse;
    }
?>
