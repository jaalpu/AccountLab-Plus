<?php

    /*
    * Copyright Â© 2005-2009 Cosmopoly Europe EOOD (http://netenberg.com).
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
    * derivative code: "Copyright Â© 2005-2009 Cosmopoly Europe EOOD
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

    require_once "init.php";
    require_once(LIBRARIES."xajax".PATH_SEP."xajax.inc.php");

    //Work arround for javascript cross site scripting restriction
    if($enable_wrong_url_redirection){
        $str1 = str_replace("/","",$BL->conf['path_url']);//remove all "/"
        $str2 = str_replace("/","",INSTALL_URL);//remove all "/"
        if(trim($str1)!=trim($str2))
        {
            $url = "Location: ".$BL->conf['path_url']."/index.php?";
            $temp = (count($_GET))?$_GET:$_POST;
            foreach($temp as $k=>$v){
                $url .= trim($k)."=".trim($v)."&";
            }
            header("$url");
            exit;
        }
    }

    $GET_STR      = '?';
    $BUY_NOW_DATA = (count($_GET))?$_GET:$_POST;
    foreach($BUY_NOW_DATA as $key=>$value)
    {
        if(!preg_match("/xajax/i",$key) && !is_array($key) && !is_array($value) && $key!="cmd")
        {
            $GET_STR .= trim($key)."=".trim($value).'&';
        }
        if($key=="cmd" && $value=="step2")
        {
            $_SESSION['group_id']   = isset($BUY_NOW_DATA['category'])?$BUY_NOW_DATA['category']:null;
            $_SESSION['product_id'] = isset($BUY_NOW_DATA['product_id'])?$BUY_NOW_DATA['product_id']:null;
            $_SESSION['addon_ids']  = isset($BUY_NOW_DATA['addon_ids'])?$BUY_NOW_DATA['addon_ids']:null;
            $_SESSION['bill_cycle'] = isset($BUY_NOW_DATA['bill_cycle'])?$BUY_NOW_DATA['bill_cycle']:null;
        }
        if($key=="category" || $key=="category_id" || $key=="group" || $key=="group_id")
        {
            $_SESSION['group_id']   = $value;
        }
        if($key=="product" || $key=="product_id" || $key=="plan" || $key=="plan_id")
        {
            $_SESSION['product_id']   = $value;
        }
        if($key=="bill_cycle" || $key=="billing_cycle" || $key=="cycle" || $key=="bill")
        {
            $_SESSION['bill_cycle']   = $value;
        }
        if($key=="addons" || $key=="addon_ids")
        {
            $_SESSION['addon_ids']   = $value;
        }
        if($key=="tld")
        {
            $_SESSION['ext']   = $value;
        }
        if($key=="sld")
        {
            $_SESSION['domain']   = $value;
        }
        if($key=="subdomain")
        {
            $_SESSION['subdomain'] = 1;
        }
    }
    if($GET_STR=='?')$GET_STR = '';

    $_SESSION['cmd'] = (isset($_SESSION['cmd']) && !empty($_SESSION['cmd']))?$_SESSION['cmd']:"step1";
    $_SESSION['cmd'] = (isset($_SESSION['force_step']) && !empty($_SESSION['force_step']))?$_SESSION['force_step']:$_SESSION['cmd'];//when cmd is blocked in mod_security
    $_SESSION['cmd'] = (isset($BL->REQUEST['cmd']) && !empty($BL->REQUEST['cmd']))?$BL->REQUEST['cmd']:$_SESSION['cmd'];

    $cmd  = $_SESSION['cmd'];
    $cmd  = empty($cmd)?"step1":$cmd;

    $conf = $BL->conf;

    $tlds          = $BL->tlds->getAvailable();
    $subdomains    = $BL->subdomains->getAvailable();
    $BL->customfields->setOrder("customfields_index");
    $custom_fields = $BL->customfields->getAvailable();
    $add_cur       = $BL->currencies->find();

    switch ($cmd)
    {
        case "step8" :
        {
            $BL->REQUEST['skip_auto_creation'] = isset($_SESSION['skip_auto_creation'])?$_SESSION['skip_auto_creation']:0;
            $BL->REQUEST['item_number']        = isset($_SESSION['item_number'])?$_SESSION['item_number']:0;
            if($BL->REQUEST['item_number'])
            {
                $BL->invoices->processTransaction($BL->REQUEST['item_number'], 0);
            }
            $BL->session_restart();
            $cmd = isset($cmd)?$cmd:"step8";
            break;
        }
        case "step7" :
        {
            foreach($_SESSION as $key=>$value)
            {
                if(!is_array($value))
                {
                    $BL->REQUEST[$key]=$value;
                }
            }
            foreach($_SESSION['CUSTOMER'] as $key=>$value)
            {
                $BL->REQUEST[$key]=$value;
            }
            foreach($_SESSION['ORDER'] as $key=>$value)
            {
                $BL->REQUEST[$key]=$value;
            }
            foreach($_SESSION['SPECIAL'] as $key=>$value)
            {
                $BL->REQUEST[$key]=$value;
            }
            foreach($_SESSION['INVOICE'] as $key=>$value)
            {
                $BL->REQUEST[$key]=$value;
            }
            if(isset($BL->REQUEST['pay_curr_id']))
            {
                $add_cur                                = $BL->currencies->getByKey($BL->REQUEST['pay_curr_id']);
                $BL->REQUEST['pay_curr_name']           = $add_cur['curr_name'];
                $BL->REQUEST['pay_curr_symbol']         = $add_cur['curr_symbol'];
                $BL->REQUEST['pay_curr_factor']         = $add_cur['curr_factor'];
                $BL->REQUEST['pay_curr_decimal_number'] = $add_cur['curr_decimal_number'];
                $BL->REQUEST['pay_curr_decimal_str']    = $add_cur['curr_decimal_str'];
                $BL->REQUEST['pay_curr_thousand_str']   = $add_cur['curr_thousand_str'];
                $BL->REQUEST['pay_curr_symbol_prefixed']= $add_cur['curr_symbol_prefixed'];
            }

            $_POST = $BL->REQUEST;
            $pay   = $BL->pp_objs[$BL->REQUEST['payment_method']];
            $pay->sendVariables($BL->conf['path_url'], $BL->pp_vals->getByKey($BL->REQUEST['payment_method']));

            $post_url                   = isset($pay->pay_url)?$pay->pay_url:($BL->conf['path_url']."/");
            $send_method                = isset($BL->pp_send_method[$BL->REQUEST['payment_method']])?$BL->pp_send_method[$BL->REQUEST['payment_method']]:"POST";
            $pay->_POST1['item_number'] = isset($pay->_POST1['item_number'])?$pay->_POST1['item_number']:time().rand(0, 1000);

            if(!isset($_SESSION['order_locked']) || empty($_SESSION['order_locked']))
            {
                $orphanorder_id = $BL->orphan_orders->insert(array("item_number"=>$pay->_POST1['item_number'],"payment_method"=>$BL->REQUEST['payment_method'],"order_date"=>date('Y-m-d H:i:s')));
                foreach($BL->REQUEST as $key=>$value)
                {
                    if(!is_array($value))
                    {
                        $BL->orphan_order_datas->insert(array("orphan_order_id"=>$orphanorder_id,"orphan_order_field"=>$key,"orphan_order_value"=>$value));
                    }
                }
                $_SESSION['order_locked'] = true;
            }
            if($BL->pp_send_method[$BL->REQUEST['payment_method']] == "DIRECT")
            {
                $_SESSION['skip_auto_creation'] = 1;
                $_SESSION['item_number']        = $pay->_POST1['item_number'];
                $BL->Redirect("step8","cart");
                break;
            }
            elseif(isset($BL->REQUEST['gross_amount']) && $BL->REQUEST['gross_amount']==0)
            {
                $_SESSION['item_number']        = $pay->_POST1['item_number'];
                $BL->Redirect("step8","cart");
                break;
            }
            else
            {
                //go to payment gateway
                $BL->session_restart();
                $cmd = isset($cmd)?$cmd:"step7";
                break;
            }
            break;
        }
        case "step6" :
        {
            $ACTIVE_PAYMENT_METHODS = array();
            foreach ($BL->pg as $value)
            {
                if ($BL->pp_active[$value] == "Yes")
                {
                    $ACTIVE_PAYMENT_METHODS[] = $value;
                }
            }
            $_SESSION['payment_method'] = (!isset($_SESSION['payment_method']) || empty($_SESSION['payment_method']))?$ACTIVE_PAYMENT_METHODS[0]:$_SESSION['payment_method'];

            $INVOICE_DATA  = $BL->invoices->calcuateAll();
            $ORDER_DATA    = $INVOICE_DATA['ORDER_DATA'];
            $CUSTOMER_DATA = $INVOICE_DATA['CUSTOMER_DATA'];
            $TAX_DATA      = $INVOICE_DATA['TAX_DATA'];

            $add_fields     = $BL->pp_ext_fields[$_SESSION['payment_method']];
            $disp_msg       = $BL->pp_disp_msg[$_SESSION['payment_method']];
            $show_add_cur   = $BL->pp_add_curr[$_SESSION['payment_method']];

            if ($BL->conf['auto_update_curr'] && $show_add_cur == "Yes")
            {
                for ($i= 0; $i < count($add_cur); $i++)
                {
                    $from   = $BL->conf['curr_name'];
                    $to     = $add_cur[$i]['curr_name'];
                    $factor = $BL->utils->parse_google_currency($to, $from);
                    if ($factor)
                    {
                        $add_cur[$i]['curr_factor'] = $factor;
                        $BL->currencies->update($add_cur[$i]);
                    }
                }
            }
            break;
        }
        case "step5" :
        {
            $special     = $BL->specials->getByKey(isset($_SESSION['specials']['SELECTED'])?$_SESSION['specials']['SELECTED']:0);
            $tld_array   = array();
            $plan_array  = array();
            $addon_array = array();
            if ($special['special_tld_disc'] == "1")
            {
                $tld_array = $BL->tlds->getAvailable();
            }
            elseif (!is_numeric($special['special_tld_disc']))
            {
                $tld_array = $BL->tlds->find(array("WHERE `dom_ext`='".$BL->utils->quoteSmart($special['special_tld_disc'])."'"));
            }
            elseif ($special['special_subdom_disc'] == "1")
            {
                $tld_array = $BL->subdomains->getAvailable();
            }
            elseif (!is_numeric($special['special_subdom_disc']))
            {
                $tld_array = $BL->subdomains->find(array("WHERE `maildomain`='".$BL->utils->quoteSmart($special['special_subdom_disc'])."'"));
            }

            if ($special['special_plan_disc'] == "ALL")
            {
                $plan_array = $BL->products->getAvailable($_SESSION['group_id']);//only under currect group
            }
            elseif (!empty ($special['special_plan_disc']))
            {
                $plan_array = $BL->products->getByKey($special['special_plan_disc']);
            }

            if ($special['special_addon_disc'] == "1")
            {
                $addon_array= $BL->addons->find();
            }
            break;
        }
        case "step4" :
        {
            $specials = array();
            foreach($_SESSION['specials'] as $special_id)
            {
                $specials[] = $BL->specials->getByKey($special_id);
            }
            break;
        }
        case "step3" :
        {
            $BL->customfields->setOrder("customfields_index");
            $custom_fields = $BL->customfields->getAvailable();
            break;
        }
        case "step2" :
        {
            //Check global configuration
            $show_tlds       = ($BL->conf['en_whois']     && count($tlds)      )?true:false;
            $show_subdomains = ($BL->conf['en_subdomain'] && count($subdomains))?true:false;
            $show_owndomain  = ($BL->conf['en_owndomain']                      )?true:false;

            //Check group configuration
            $group_data = $BL->groups->find(array("WHERE `group_id`=".(isset($_SESSION['group_id'])?intval($_SESSION['group_id']):0)));
            if(isset($group_data[0]['group_require_domain']) && empty($group_data[0]['group_require_domain']))
            {
                $show_tlds       = false;
                $show_subdomains = false;
                $show_owndomain  = false;
            }

            //Check product configuration
            $product_data = $BL->products->find(array("WHERE `plan_price_id`=".(isset($_SESSION['product_id'])?intval($_SESSION['product_id']):0)));
            if(isset($product_data[0]['domain']) && empty($product_data[0]['domain']))
            {
                $show_tlds       = false;
            }
            if(isset($product_data[0]['subdomain']) && empty($product_data[0]['subdomain']))
            {
                $show_subdomains = false;
            }
            if(isset($product_data[0]['force_domain_subdomain']) && $product_data[0]['force_domain_subdomain'])
            {
                $show_owndomain = false;
            }
            if(!$show_tlds && !$show_subdomains && !$show_owndomain)
            {
                $BL->customfields->setOrder("customfields_index");
                $custom_fields = $BL->customfields->getAvailable();
                $cmd="step3";
            }
            break;
        }
        default :
        {
            $special_display = $BL->specialAutoDescription();
            $BL->groups->setOrder("group_index");
            $groups          = $BL->groups->getAvailable();
            break;
        }
    }

    $xajax = new xajax();
    $xajax->setRequestURI($BL->conf['path_url']."/");

    if(ALP_DEBUG)
    {
        $xajax->debugOn();
    }
    else
    {
        $xajax->debugOff();
    }
    if (ini_get('output_buffering') == NULL || ini_get('output_buffering') == 'Off')
    {
        $xajax->cleanBufferOn();
    }
    else
    {
        $xajax->cleanBufferOff();
    }

    $xajax->errorHandlerOff();
    $xajax->statusMessagesOn();
    $xajax->waitCursorOn();
    $xajax->exitAllowedOn();
    $xajax->setCharEncoding(CHARSET);
    $xajax->decodeUTF8InputOn();
    $xajax->outputEntitiesOn();

    $xajax->registerFunction("reload"                   );
    $xajax->registerFunction("updateBasket"             );
    $xajax->registerFunction("toggleButtons"            );
    $xajax->registerFunction("step1"                    );
    $xajax->registerFunction("step1_buyNow"             );
    $xajax->registerFunction("step1_selectGroup"        );
    $xajax->registerFunction("step1_selectProduct"      );
    $xajax->registerFunction("step1_selectCycle"        );
    $xajax->registerFunction("step1_addAddon"           );
    $xajax->registerFunction("step1_removeAddon"        );
    $xajax->registerFunction("step1_ShowGroups"         );
    $xajax->registerFunction("step1_HideGroups"         );
    $xajax->registerFunction("step1_ShowProducts"       );
    $xajax->registerFunction("step1_ShowCycles"         );
    $xajax->registerFunction("step2"                    );
    $xajax->registerFunction("step2_buyNow"             );
    $xajax->registerFunction("step2_selectType"         );
    $xajax->registerFunction("step2_whois"              );
    $xajax->registerFunction("step2_addDomain"          );
    $xajax->registerFunction("step3"                    );
    $xajax->registerFunction("step3_memberType"         );
    $xajax->registerFunction("step3_listStates"         );
    $xajax->registerFunction("step3_verifyUser"         );
    $xajax->registerFunction("step4"                    );
    $xajax->registerFunction("step4_selectSpecial"      );
    $xajax->registerFunction("step5"                    );
    $xajax->registerFunction("step5_whois"              );
    $xajax->registerFunction("step5_addDomain"          );
    $xajax->registerFunction("step5_addProduct"         );
    $xajax->registerFunction("step5_addAddon"           );
    $xajax->registerFunction("step6"                    );
    $xajax->registerFunction("step6_selectPaymentMethod");
    $xajax->registerFunction("step6_agree"              );
    $xajax->registerFunction("step7"                    );
    $xajax->registerFunction("step8"                    );
    $xajax->registerFunction("finish"                   );
    $xajax->registerFunction("pay"                      );
    $xajax->registerFunction("logUser"                  );

    include_once PATH_SYSTEM."ajaxFunctions.php";

    $xajax->processRequests();
    include_once $BL->props->get_page("templates/".THEMEDIR."/html/cart/".$cmd.".php");
    if(ALP_DEBUG)
    {
        $errorHandler->getErrorLog();
    }
    $BL->Disconnect();
?>
