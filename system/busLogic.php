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
 * A class to do all toplevel operations
 * busLogic Version 2.0
 */
/*
 * Class business logic
 */
class busLogic
{
	var $REQUEST;
    var $errorHandler;
    /*
	 * Constructor
	 */
	function busLogic(& $errorHandler, & $REQUEST)
	{
		$this->REQUEST      = & $REQUEST;
        $this->errorHandler = & $errorHandler;

        $this->utils        = new utils();
        $this->props        = new properties();
        $this->dbL          = new db($this->props->db_host, $this->props->db_user, $this->props->db_pass, $this->props->db_name, $this->errorHandler);

        $this->installer    = new installer_controller($this->dbL,$this->props,$this->utils,$this->REQUEST,$this->errorHandler);
        $this->auth         = new authorize_controller($this->dbL,$this->props,$this->utils,$this->REQUEST,$this->errorHandler);
        $this->whois        = new whois_controller($this->dbL,$this->props,$this->utils,$this->REQUEST,$this->errorHandler);
        $this->etp          = new emailTemplateParser_controller($this->dbL,$this->props,$this->utils,$this->REQUEST,$this->errorHandler);
        $this->report       = new report_controller($this->dbL,$this->props,$this->utils,$this->REQUEST,$this->errorHandler);

        $this->loadModels();
        $this->loadConf();
        $this->loadArrays();
        $this->loadLang();
        $this->loadTheme();
        $this->loadPP();
        $this->loadDR();
        $this->loadCurrencySettings();
        $this->initMailAgent();

		$this->cpanelHandler      = new cpanelHandler();
		$this->pleskHandler       = new pleskHandler();
		$this->directadminHandler = new daHandler();
		$this->lxadminHandler     = new lxadminHandler();
	}
    function dbReconnect()
    {
    	$this->dbL->dbDisconnect();
        $this->dbL = new db($this->props->db_host, $this->props->db_user, $this->props->db_pass, $this->props->db_name, $this->errorHandler);
    }
    function session_restart()
    {
       if (session_name()=='')
       {
           session_start();
       }
       else
       {
           session_destroy();
           session_start();
           session_regenerate_id();
       }
    }
    function ResetALP()
    {
        if(!isset($this->REQUEST['confirm']) && isset($_SESSION['admin_fingerprint']) && !empty($_SESSION['admin_fingerprint']))
        {
            $str  = "<br><font size='2' color='red'>".$this->props->lang['reset_db']."</font><br><br>";
            $str .= "<form name='form1' id='form1' method='post' action='admin.php'>" .
                    "<input type='hidden' name='cmd' value='reset_alp'>" .
                    "<input type='hidden' name='confirm' value='".md5($_SESSION['admin_fingerprint'])."'>" .
                    "<input type='submit' name='submit' class='search1' value='".$this->props->lang['~reset_alp']."'>" .
                    "</form><br>";
            $this->utils->alert($str);
        }
        elseif(isset($this->REQUEST['confirm']) && isset($_SESSION['admin_fingerprint']) && md5($_SESSION['admin_fingerprint'])==$this->REQUEST['confirm'])
        {
            foreach($this->dbL->listTables($this->props->db_name) as $table_name)
            {
            	if($table_name!="admin_users" && $table_name!="billing_cycles" && $table_name!="customfields" && $table_name!="emails" && $table_name!="order_conf")
                {
                    $this->dbL->executeDELETE("TRUNCATE `".$table_name."`");
                }
            }
            $this->Redirect();
        }
    }
    function Redirect($cmd="",$user="admin")
    {
        $this->REQUEST['cmd'] = isset($this->REQUEST['cmd'])?$this->REQUEST['cmd']:"";
        if($user=="admin")
        {
        	$url = "Location: ".$this->conf['path_url']."/admin.php?cmd_prev=".$this->REQUEST['cmd']."&cmd=".$cmd;
        }
        elseif($user=="cart")
        {
        	$url = "Location: ".$this->conf['path_url']."/index.php?cmd=".$cmd;
        }
        elseif($user=="faq")
        {
        	$url = "Location: ".$this->conf['path_url']."/faq.php?cmd=".$cmd;
        }
        elseif($user=="support")
        {
            $url = "Location: ".$this->conf['path_url']."/support.php?cmd=".$cmd;
        }
        else
        {
        	$url = "Location: ".$this->conf['path_url']."/customer.php?cmd=".$cmd;
        }
        header("$url");
        exit;
    }
    function Disconnect()
    {
    	$this->dbL->dbDisconnect();
        exit;
    }
    function loadModels()
    {
        $this->Models = $this->utils->dirlist(MODELS, "name", "php");
        foreach($this->Models as $model)
        {
            require_once MODELS . $model.".php";
            $this->$model = new $model($this->dbL,$this->props,$this->utils,$this->REQUEST,$this->err);
        }
    }
    /*
     * Load settings
     */
    function loadConf()
    {
        $this->conf = $this->configurations->hasAnyOne();
        $this->props->cycles = array();
        foreach($this->billing_cycles->find() as $c)
        {
            $this->props->cycles[$c['cycle_month']] = $c['cycle_name'];
        }
    }
    /*
     * Load language
     */
    function loadLang()
    {
        $_SESSION['language'] = !empty($this->conf['d_lang'])?$this->conf['d_lang']:"english";
        if(isset($_SESSION['force_lang']) && !empty($_SESSION['force_lang']))$_SESSION['language'] = $_SESSION['force_lang'];
        $this->props->getLang($_SESSION['language']);
    }
    /*
     * Load theme
     */
    function loadTheme()
    {
        $_SESSION['theme_dir'] = isset($this->conf['theme'])?$this->conf['theme']:"default";
        if(isset($_SESSION['force_theme']) && !empty($_SESSION['force_theme']))$_SESSION['theme_dir'] = $_SESSION['force_theme'];
    }
    /*
     * Get admin email
     */
    function getAdminEmail($admin_id = 0)
    {
        $Admin = $this->admin_users->hasAnyOne(array("WHERE `id`='1'"));
        return $Admin['email'];
    }
    /*
     * To Currency
     */
    function toCurrency($number, $array= array (), $format= 0, $with_symbol= 1, $strict=0)
    {
        $array = !count($array)?$this->curr_conf:$array;
        $number= str_replace($array['str1'], '.', $number);
        $number= str_replace($array['str2'], '', $number);
        $number= $this->utils->toFloat($number);
        return empty ($format)
                ?(($strict)?null:$number)
                :$this->utils->toCurrency($number, $array, $with_symbol);
    }
    /*
     * Load currency settings
     */
    function loadCurrencySettings()
    {
        $curr_conf= array ();
        $curr_conf['symbol_prefixed']= $this->conf['curr_symbol_prefixed'];
        $curr_conf['symbol']         = $this->conf['symbol'];
        $curr_conf['decimals']       = $this->conf['decimal_number'];
        $curr_conf['str1']           = $this->conf['decimal_str'];
        $curr_conf['str2']           = $this->conf['thousand_str'];
        $this->curr_conf             = $curr_conf;
    }
    /*
     * Load arrays
     */
    function loadArrays()
    {
        $this->props->constructArrays($this->utils);
        $this->dr         = $this->props->dr; //Domain registrars
        $this->pg         = $this->props->pg; //Payment Processors
        $this->cp         = $this->props->cp; //Control panels
        $this->lang_array = $this->props->lang_array; //Languages
        $this->theme_list = $this->props->theme_list; //themes
    }
    /*
     * Load domain registrars
     */
    function loadDR()
    {
        foreach($this->props->dr as $registrar){
            require_once $this->props->get_page("plugins/registrars/" . $registrar . ".php", "file", 1);
            $this->dr_fields[$registrar]=${$registrar."_fields"};
            $datas = $this->registrars->find(array("WHERE `name`='".$registrar."'"));
            $temp = array ();
            foreach(${$registrar."_fields"} as $field){
                foreach($datas as $data){
                	if($field[1]==0 && $data['field']==$field[0]){
                		$temp[$field[0]] = $data['value'];
                	}elseif($field[1]==1 && $data['field']==$field[0]){
                        $temp[$field[0]] = $this->utils->alpencrypt->decrypt($data['value'], $this->props->encryptionKey);;
                    }
                }
            }
            $this->dr_vals[$registrar] = $temp;
        }
    }
    /*
     * Load payment processors
     */
    function loadPP()
    {
        $this->pp_objs     = array();
        $this->pp_disp_msg = array();
        $this->pp_active   = array();
        $this->pp_add_curr = array();
        $this->pg_name     = array();
        $this->pp_ext_fields = array();
        $this->arrays      = array();
        $this->pp_send_method = array();

        $demo_mode = isset($this->props->payment_method_demo_mode)?$this->props->payment_method_demo_mode:0;

        foreach ($this->pg as $k => $v)
        {
            if(!isset($this->REQUEST['pp']) || !($this->REQUEST['pp']=='paypalwpp' && $v=='paypal'))//tweak for paypal class redeclared in php-sdk from paypal
            {
                $ext_fields = array();
                $data = $this->pp_vals->hasAnyOne(array("WHERE `pp_name`='".$v."'"));
                if($v=="proxypay")
                {
                    $proxy_url = isset($data['server_url'])?$data['server_url']:"";
                }
                require_once $this->props->get_page("plugins/payment/" . $v . ".php", "file", 1);
                $this->pp_objs[$v]      = $pay;
                $this->pp_disp_msg[$v]  = !empty($data['disp_msg'])?$data['disp_msg']:"";
                $this->pp_active[$v]    = !empty($data['active'])?$data['active']:"No";
                $this->pp_add_curr[$v]  = !empty($data['add_curr'])?$data['add_curr']:"";
                $this->pg_name[$v]      = !empty($data['title'])?$data['title']:(isset($name)?$name:$v);
                $this->pp_ext_fields[$v]= $ext_fields;
                $this->arrays[$v]       = isset(${$v})?${$v}:array();
                $this->pp_send_method[$v]= isset($send_method)?$send_method:"POST";
                $this->extra_fields->createExtraFields($this->pp_ext_fields[$v]);
            }
        }
    }
    /*
     * display price tag
     */
    function displayPrice($amount, $use_html= false)
    {
        $tax_str  = '';
        $tax_name = $this->props->lang['tax'];
        $tax      = $this->calculateTax($amount);
        if(count($tax['tax_name'])==1)
        {
            $tax_name = $tax['tax_name'][0];
        }
        $tax_str   = " + " . $tax_name . ": " . $this->toCurrency($tax['total_tax_amount'], null, 1);
        if ($use_html)
        {
          $tax_str = " + <b>" . $tax_name . "</b>: " . $this->toCurrency($tax['total_tax_amount'], null, 1);
        }

        if(empty($this->conf['tax_calculation']) || !count($tax['tax_name']))
        {
            return $this->toCurrency($amount, null, 1);
        }
        elseif($this->conf['tax_calculation']==1)
        {
            return $this->toCurrency($amount, null, 1) . $tax_str;
        }
        else
        {
            return $this->toCurrency($amount+$tax['total_tax_amount'], null, 1)." ".$this->props->lang['including']." ".$tax_name;
        }
    }
    /*
     * Init Mail agent
     */
    function initMailAgent()
    {
        $this->ALPmail= new ALPmail;
        $this->ALPmail->setProps($this->conf, $this->props);
    }
    /*
     * Format date
     */
    function fDate($date, $time_format= '')
    {
        return $this->utils->toDate($date, $this->conf['date_format'] . $time_format);
    }
    /*
     * Get customer field value
     */
    function getCustomerFieldValue($field_name,$customer_id)
    {
        $temp = $this->customfields->hasAnyOne(array("WHERE `field_name`='".$field_name."'"));
        return isset($temp['field_id'])?$this->customers->getFieldValue($temp['field_id'],$customer_id):null;
    }
    /*
     * Get products friendly name
     */
    function getFriendlyName($product_name_or_id)
    {
        if(empty($product_name_or_id))return "";
        return $this->products->getFriendlyName($product_name_or_id);
    }
    /*
     * Get invoice desc friendly name
     */
    function getFriendlyDesc($desc, $order_id, $domain= '')
    {
        $f_desc = $desc;
        if(!empty ($domain))
        {
            $domain_name = $domain;
        }
        elseif (!empty ($order_id))
        {
            $order_data  = $this->orders->hasAnyOne(array("WHERE `sub_id`='".$order_id."'"));
            $domain_name = $order_data['domain_name'];
        }

        if (eregi($domain_name, $desc))
        {
            $temp1 = stristr($desc, $domain_name);
            $temp2 = str_replace($temp1, '', $desc);
            $temp3 = explode('-', $temp2);
            $temp4 = array ();
            foreach ($temp3 as $t)
            {
                if (!empty ($t))
                {
                    $temp4[] = trim($t);
                }
            }
            if (count($temp4) == 1)
            {
                $f_desc = $this->getFriendlyName($temp4[0]) . "-" . $temp1;
            }
            elseif (count($temp4) == 2)
            {
                $f_desc = $temp4[0] . "-" . $this->getFriendlyName($temp4[1]) . "-" . $temp1;
            }
            elseif(substr($desc,0,2)=="0-")
            {
            	$f_desc = substr($desc,2);
            }
            elseif(substr($desc,0,1)=="-")
            {
                $f_desc = substr($desc,1);
            }
            else
            {
                $f_desc = $desc;
            }
        }
        return $f_desc;
    }
    /*
     * Calulate tax on an amount
     */
    function calculateTax($sub_total, $country= "", $state= "", $force_tax_array=array())
    {
        return $this->taxes->calculateTax($sub_total, $country, $state, $force_tax_array);
    }
    /*
     * Get Command array
     */
    function getCmd($cmd = "")
    {
        if ($_SESSION['admin_id'] == 1)
        {
            $commands = $this->props->admin_cmds;
        }
        else
        {
            $thisUser = array ();
            $thisUser = $this->admin_users->hasAnyOne(array("WHERE `id`='".$_SESSION['admin_id']."'"));
            $commands = explode("|", $thisUser['permissions']);
        }
        if (!empty($cmd))
        {
            if (array_search($cmd, $commands) !== false || array_search("~" . $cmd, $commands) !== false || array_search("+" . $cmd, $commands) !== false || array_search("-" . $cmd, $commands) !== false)
            {
            	return true;
            }
            return false;
        }
        return $commands;
    }
    /*
     * Security scheck
     */
    function accessIPCheck($ip = null, $force = false)
    {
        $ip_detect = $this->utils->realip();
        if(!empty($this->conf['security_degree']) || $force)
        {
            foreach($this->access_ips->find() as $ap)
            {
                $real_ip_array = $this->utils->splitIParray($ip_detect);
                $ip_array      = $this->utils->splitIParray($ap['ip_address']);
                if($ip_detect==$ap['ip_address'])
                {
                    return $ap['admin_id'];
                }
                elseif(
                        $real_ip_array[0]==$ip_array[0] &&
                        $real_ip_array[1]==$ip_array[1] &&
                        $real_ip_array[2]==$ip_array[2] &&
                        $real_ip_array[4]>=$ip_array[3] &&
                        $real_ip_array[4]<=$ip_array[4]
                      )
                {
                    return $ap['admin_id'];
                }
            }
            return false;
        }
        return true;
    }
    /*
     * Function to include page
     */
    function include_page($page, $type= "admin")
    {
        if ($type == "admin")
        {
            $this->props->c          = ALP_COPYRIGHT;
            $this->props->ALPversion = ALP_VERSION;
            if ($this->auth->IsAuth($type))
            {
                return $this->props->get_page("templates/alp_admin/html/" . $page, "file", 1);
            }
            return $this->props->get_page("templates/alp_admin/html/login.php", "file", 1);
        }
        elseif($type=="admin_captcha")
        {
            $this->props->c         = ALP_COPYRIGHT;
            $this->props->ALPversion= ALP_VERSION;
            return $this->props->get_page("templates/alp_admin/html/captcha.php", "file", 1);
        }
        else
        {
            if ($this->auth->IsAuth($type))
            {
                return $this->props->get_page("templates/" . THEMEDIR. "/html/" . $type . "/" . $page, "file", 1);
            }
            return $this->props->get_page("templates/" . THEMEDIR . "/html/" . $type . "/login.php", "file", 1);
        }
    }
    function specialAutoDescription()
    {
        $special_display = array();
        $all_specials    = $this->specials->getAvailable();
        foreach ($all_specials as $special)
        {
            $WHATEVER = "";
            if ($special['special_tld'] == "1")
            {
                $WHATEVER = $this->props->lang['anydomain'];
            }
            elseif ($special['special_tld'] != "0")
            {
                $WHATEVER = " ." . $special['special_tld'];
            }
            if ($special['special_subdom'] == "1")
            {
                if (!empty ($WHATEVER))
                {
                    $WHATEVER .= $this->props->lang['or'];
                }
                $WHATEVER .= $this->props->lang['anysubdomain'];
            }
            elseif ($special['special_subdom'] != "0")
            {
                if (!empty ($WHATEVER))
                {
                    $WHATEVER .= $this->props->lang['or'];
                }
                $WHATEVER .= " ." . $special['special_subdom'];
            }
            if ($special['special_plan'] == "ALL")
            {
                if (!empty ($WHATEVER))
                {
                    $WHATEVER .= $this->props->lang['and'];
                }
                $WHATEVER .= $this->props->lang['anyproduct'];
            }
            elseif ($special['special_plan'] != "0")
            {
                if (!empty ($WHATEVER))
                {
                    $WHATEVER .= $this->props->lang['and'];
                }
                $WHATEVER .= " " . $this->getFriendlyName($special['special_plan']) . "  ";
            }
            if ($special['special_net'] > 0)
            {
                if (!empty ($WHATEVER))
                {
                    $WHATEVER .= $this->props->lang['with'];
                }
                $WHATEVER .= $this->props->lang['minamount'] . $this->toCurrency($special['special_net'], null, 1) . "  ";
            }
            $WHATEVER1= "";
            if ($special['special_tld_disc'] == "1")
            {
                if ($special['new_order'] == 1)
                    $WHATEVER1= $this->props->lang['anydomain'];
                else
                    $WHATEVER1= $this->props->lang['domainprice'];
            }
            elseif ($special['special_tld_disc'] != "0")
            {
                $WHATEVER1= " ." . $special['special_tld_disc'];
            }
            if ($special['special_subdom_disc'] == "1")
            {
                if (!empty ($WHATEVER1))
                {
                    $WHATEVER1 .= $this->props->lang['or'];
                }
                if ($special['new_order'] == 1)
                    $WHATEVER1 .= $this->props->lang['anysubdomain'];
                else
                    $WHATEVER1 .= $this->props->lang['subdomainprice'];
            }
            elseif ($special['special_subdom_disc'] != "0")
            {
                if (!empty ($WHATEVER1))
                {
                    $WHATEVER1 .= $this->props->lang['or'];
                }
                $WHATEVER1 .= " ." . $special['special_subdom_disc'];
            }
            if ($special['special_plan_disc'] == "ALL")
            {
                if (!empty ($WHATEVER1))
                {
                    $WHATEVER1 .= $this->props->lang['and'];
                }
                if ($special['new_order'] == 1)
                    $WHATEVER1 .= $this->props->lang['anyproduct'];
                else
                    $WHATEVER1 .= $this->props->lang['productprice'];
            }
            elseif ($special['special_plan_disc'] != "0")
            {
                if (!empty ($WHATEVER1))
                {
                    $WHATEVER1 .= $this->props->lang['and'];
                }
                $WHATEVER1 .= " " . $this->getFriendlyName($special['special_plan_disc']) . "  ";
            }
            if ($special['special_addon_disc'] == "1")
            {
                if (!empty ($WHATEVER1))
                {
                    $WHATEVER1 .= $this->props->lang['and'];
                }
                if ($special['new_order'] == 1)
                    $WHATEVER1 .= $this->props->lang['anyaddon'];
                else
                    $WHATEVER1 .= $this->props->lang['addonprice'];
            }
            if ($special['auto_desc'] != 1 && !empty ($special['special_desc']))
            {
                $special_display[]= $special['special_desc'];
            }
            elseif ($special['new_order'] != 1 && $special['auto_desc'] == 1)
            {
                $WHATEVER2= number_format($special['special_net_disc'], 2) . "% " . $this->props->lang['discount_on'] . " " . $WHATEVER1;
                $special_display[]= $this->props->lang['purchase'] . " " . $WHATEVER . " " . $this->props->lang['andget'] . " " . $WHATEVER2 . "!";
            }
            elseif ($special['auto_desc'] == 1)
            {
                $special_display[]= $this->props->lang['purchase'] . " " . $WHATEVER . " " . $this->props->lang['andget'] . " " . $WHATEVER1 . " " . $this->props->lang['free'] . "!";
            }
        }
        return $special_display;
    }
    /*
     * whoisonline
     */
    function whoisonline($sec= 600)
    {
        $sqlDELETE = "DELETE FROM {$this->props->tbl_online_users} WHERE DATE_SUB(CURDATE(),INTERVAL 1 DAY) >= `log_time`";
        $this->dbL->executeDELETE($sqlDELETE); //delete records older than 24 hours
        $sqlSELECT = "SELECT * FROM {$this->props->tbl_online_users} WHERE `log_time` >= (NOW() - SEC_TO_TIME(" . $sec . ")) ORDER BY `log_time` DESC";
        $temp      = $this->dbL->executeSELECT($sqlSELECT);
        $whoisonline= array ();
        foreach ($temp as $k => $v)
        {
            if ($v['user_type'] == 2)
            {
                if (array_key_exists("~" . $v['visiting_page'], $this->props->lang))
                {
                    $v['visiting_page']= $this->props->lang["~" . $v['visiting_page']];
                }
                elseif (array_key_exists("+" . $v['visiting_page'], $this->props->lang))
                {
                    $v['visiting_page']= $this->props->lang["+" . $v['visiting_page']];
                }
                elseif (empty ($v['visiting_page']) || $v['visiting_page'] == "main")
                {
                	$v['visiting_page']= $this->props->lang['Dashboard'];
                }
            }
            elseif ($v['user_type'] == 1)
            {
                if (empty ($v['visiting_page']))
                {
                    $v['visiting_page']= $this->props->lang['Dashboard'];
                }
                else
                {
                    $v['visiting_page']= $this->props->lang["-" . $v['visiting_page']];
                }
            }
            elseif ($v['user_type'] == 0)
            {
                $v['visiting_page']= $this->props->lang['-order_page'];
            }
            if (empty ($v['user_name']))
            {
                $v['user_name']= $this->props->lang['Unknown'];
            }
            $whoisonline[$k]= $v;
        }
        return $whoisonline;
    }
    /*
     * Pagination
     */
    function doPagination($data_count)
    {
        $pagination          = '';
        $next_start          = 0;
        $this->REQUEST['l2'] = $this->conf['records_per_page'];
        $this->REQUEST['l1'] = isset($this->REQUEST['l1'])?$this->REQUEST['l1']:0;
        $prev_start          = (trim($this->REQUEST['l1']) - $this->conf['records_per_page']>0)?trim($this->REQUEST['l1']) - $this->conf['records_per_page']:0;

        if ($this->REQUEST['l1'] >= $this->conf['records_per_page'])
        {
            $pagination .= "[<a style=\"color:#ffffff\" href=\"admin.php?l1=" . $prev_start . "&";
            foreach ($this->REQUEST as $k => $v)
            {
                if ($k != "dir" && $k != "l1" && $k != "l2")
                {
                    $pagination .= $k . "=" . $v . "&";
                }
            }
            $pagination .= "\">";
            $pagination .= $this->props->lang['Previous'] . " " . $this->conf['records_per_page'] . "</a>]&nbsp;&nbsp;";
        }
        $next_start      = trim($this->REQUEST['l1']) + $this->conf['records_per_page'];
        if ($next_start < $data_count)
        {
            $pagination .= "[<a style=\"color:#ffffff\" href=\"admin.php?l1=" . $next_start . "&";
            foreach ($this->REQUEST as $k => $v)
            {
                if ($k != "dir" && $k != "l1" && $k != "l2")
                {
                    $pagination .= $k . "=" . $v . "&";
                }
            }
            $pagination .= "\">";
            $pagination .= $this->props->lang['Next'] . " " . $this->conf['records_per_page'] . "</a>]&nbsp;&nbsp;";
        }
        return $pagination;
    }
    /*
     * Get accounts for customer
     */
    function getAccounts($customer_id)
    {
        $return_array = array();
        foreach($this->props->invoice_status as $status)
        {
            $return_array[$status] = 0;
        }
        $Invoices = $this->invoices->get("WHERE `customers_orders`.customer_id='".$customer_id."'");
        foreach($Invoices as $Invoice)
        {
            $status = $Invoice['status'];
            $return_array[$status] = $return_array[$status] + $Invoice['gross_amount'];
        }
        return $return_array;
    }
    /*
     * Run Custom Scripts
     */
    function runCS($schedule='MANUAL',$order_id=0, $invoice_no=0, $orphan_order_id=0)
    {
        $result = array();
        if(is_numeric($schedule))
        {
            $cs = $this->custom_scripts->find(array("WHERE `id`='".$schedule."'"));
        }
        else
        {
            $cs = $this->custom_scripts->find(array("WHERE `run_schedule`='".$schedule."'"));
        }
        if(count($cs))
        {
            $data_array1 = array();
            $data_array2 = array();
            $data_array3 = array();

            if(!empty($order_id))
            {
                $data_array1   = $this->mailWelcome($order_id,true);
            }
            if(!empty($invoice_no))
            {
                $data_array2   = $this->mailInvoice($invoice_no,false,true);
            }
            if(!empty($orphan_order_id))
            {
                $orphanOrders  = $this->orphan_orders();
                for ($i= 0; $i < count($orphanOrders); $i++)
                {
                    $temp      = $orphanOrders[$i];
                    if ($temp['temp_id'] == $orphan_order_id)
                    {
                        $data_array3 = $temp;
                    }
                }
            }
            foreach($cs as $k=>$c)
            {
                $plugin_file = $c['file_name'];
                if(is_readable($plugin_file))
                {
                    $_ALP = array();
                    $str  = str_replace("<&&>","|",isset($cs['post_variables'])?$cs['post_variables']:"");
                    $str  = str_replace(" ","",$str );
                    $str  = str_replace("||","|",$str);
                    $post_vars = $this->utils->Get_Trimmed_Array(explode("|",$str));
                    foreach($post_vars as $v)
                    {
                        if(array_key_exists($v,$data_array3))$_ALP[$v] = $data_array3[$v];
                        if(array_key_exists($v,$data_array2))$_ALP[$v] = $data_array2[$v];
                        if(array_key_exists($v,$data_array1))$_ALP[$v] = $data_array1[$v];
                    }
                    ob_start();
                    require_once $plugin_file;
                    $result[$k] = ob_get_contents();
                    ob_end_clean();
                    $this->ALPmail->AddAddress($this->conf['comp_email'], $this->conf['company_name']);
                    $this->ALPmail->Subject = $plugin_file." ==> ".date('d-M-Y H:i:s');
                    $this->ALPmail->Body    = $result[$k];
                    $this->ALPmail->sendMail();
                }
            }
        }
        return $result;
    }
    /*
     * Build Menu
     */
    function buildMenu($horizonal= 1)
    {
        $cmd_prev = isset($this->REQUEST['cmd'])?$this->REQUEST['cmd']:"";
        $commands = array ();
        $commands1= array ();
        $temp_cmd = "";
        //construct the array for building the menu
        foreach ($this->getCmd() as $cmd)
        {
            if (substr($cmd, 0, 1) == "^")
            {
                $temp_cmd= $cmd;
            }
            if (substr($cmd, 0, 1) == "~")
            {
                $commands[$temp_cmd][$cmd]= 1;
                $commands1[$temp_cmd][$cmd]= 1;
            }
            if (substr($cmd, 0, 1) == "+")
            {
                $commands1[$temp_cmd][$cmd]= 1;
            }
        }
        $return_cmds= array ();
        foreach ($commands1 as $k => $v)
        {
            foreach ($v as $k1 => $v1)
            {
                if ($cmd_prev == substr($k1, 1, strlen($k1)))
                {
                    $return_cmds= $commands[$k];
                    break;
                }
            }
        }
        if ($horizonal)
        {
            //build menu
            $i= 0;
            echo "<div id=\"alpmenu\"><ul>\n\r";
            echo "<li><a href=\"admin.php?cmd=main\">" . $this->props->lang['Dashboard'] . "</a></li>\n\r";
            foreach ($commands as $k => $v)
            {
                $i= $i +1;
                echo "<li><a href=\"#\" onMouseover=\"cssdropdown.dropit(this,event,'dropmenu" . $i . "')\">" . $this->props->lang[$k] . "</a></li>\n\r";
            }
            foreach ($this->props->ext_links as $l1 => $l2)
                echo "<li><a href=\"" . $l2 . "\" target=\"_blank\">" . $this->props->lang[$l1] . "</a></li>\n\r";
            echo "<li><a href=\"logout.php?url=admin.php&user=admin\">" . $this->props->lang['Logout'] . "</a></li>\n\r";
            echo "</ul></div>\n\r";
            $i= 0;
            foreach ($commands as $k => $v)
            {
                $i= $i +1;
                echo "<div id=\"dropmenu" . $i . "\" class=\"dropmenudiv\">\n\r";
                foreach ($v as $k1 => $v1)
                {
                    if($k1=="~systemtest")
                    {
                    	echo "<a href=\"systemtest.php\" target=\"_blank\">" . $this->props->lang[$k1] . "</a>\n\r";
                    }
                    else
                    {
                    	echo "<a href=\"admin.php?cmd_prev=" . $cmd_prev . "&cmd=" . substr($k1, 1, strlen($k1)) . "\">" . $this->props->lang[$k1] . "</a>\n\r";
                    }
                }
                echo "</div>\n\r";
            }
        }
        else
        {
            echo "<tr>\n\r
                              <td width=\"1%\">\n\r
                              <img src=\"elements".PATH_SEP."default".PATH_SEP."templates".PATH_SEP."alp_admin".PATH_SEP."images".PATH_SEP."menu_icon_plus.gif\" width=\"32\" height=\"18\" style=\"cursor:hand; cursor:pointer\">\n\r
                              </td>\n\r
                              <td>\n\r
                              <a href=\"admin.php?cmd=main\">" . $this->props->lang['Dashboard'] . "</a>\n\r
                              </td>\n\r
                              <td>\n\r
                              <img src=\"elements".PATH_SEP."default".PATH_SEP."templates".PATH_SEP."alp_admin".PATH_SEP."images".PATH_SEP."spacer.gif\" width=\"1\" height=\"1\">\n\r
                              </td>\n\r
                            </tr>\n\r
                            <tr> \n\r
                              <td colspan=\"3\">\n\r
                              <img src=\"elements".PATH_SEP."default".PATH_SEP."templates".PATH_SEP."alp_admin".PATH_SEP."images".PATH_SEP."menu_line_lightgreen.jpg\" width=\"100%\" height=\"2\">\n\r
                              </td>\n\r
                            </tr>\n\r
                            ";
            $commands= array ();
            $commands= $this->getCmd();
            $str= "";
            foreach ($commands as $cmd)
            {
                if ($cmd != "~addinvoice")
                {
                    //main menu
                    if (substr($cmd, 0, 1) == "^")
                    {
                        $menu_name= substr($cmd, 1, strlen($cmd));
                        include $this->props->get_page("templates/alp_admin/html/main_menu_template.php", "file", 1);
                    }
                    //submenu
                    if (substr($cmd, 0, 1) == "~")
                    {
                        $cmd= substr($cmd, 1, strlen($cmd));
                        include $this->props->get_page("templates/alp_admin/html/sub_menu_template.php", "file", 1);
                    }
                    //seperator
                    if ($cmd == "-")
                    {
                        include $this->props->get_page("templates/alp_admin/html/separator_menu_template.php", "file", 1);
                    }
                }
            }
            foreach ($this->props->ext_links as $l1 => $l2)
                echo "<tr>\n\r
                                  <td width=\"1%\">\n\r
                                  <img src=\"elements".PATH_SEP."default".PATH_SEP."templates".PATH_SEP."alp_admin".PATH_SEP."images".PATH_SEP."menu_icon_plus.gif\" width=\"32\" height=\"18\" style=\"cursor:hand; cursor:pointer\">\n\r
                                  </td>\n\r
                                  <td>\n\r
                                  <a href=\"" . $l2 . "\" target=\"_blank\">" . $this->props->lang[$l1] . "</a>\n\r
                                  </td>\n\r
                                  <td>\n\r
                                  <img src=\"elements".PATH_SEP."default".PATH_SEP."templates".PATH_SEP."alp_admin".PATH_SEP."images".PATH_SEP."spacer.gif\" width=\"1\" height=\"1\">\n\r
                                  </td>\n\r
                                </tr>\n\r
                                <tr> \n\r
                                  <td colspan=\"3\">\n\r
                                  <img src=\"elements".PATH_SEP."default".PATH_SEP."templates".PATH_SEP."alp_admin".PATH_SEP."images".PATH_SEP."menu_line_lightgreen.jpg\" width=\"100%\" height=\"2\">\n\r
                                  </td>\n\r
                                </tr>\n\r
                                ";
            echo "<tr>\n\r
                              <td width=\"1%\">\n\r
                              <img src=\"elements".PATH_SEP."default".PATH_SEP."templates".PATH_SEP."alp_admin".PATH_SEP."images".PATH_SEP."menu_icon_plus.gif\" width=\"32\" height=\"18\" style=\"cursor:hand; cursor:pointer\">\n\r
                              </td>\n\r
                              <td>\n\r
                              <a href=\"logout.php?url=admin.php&user=admin\">" . $this->props->lang['Logout'] . "</a>\n\r
                              </td>\n\r
                              <td>\n\r
                              <img src=\"elements".PATH_SEP."default".PATH_SEP."templates".PATH_SEP."alp_admin".PATH_SEP."images".PATH_SEP."spacer.gif\" width=\"1\" height=\"1\">\n\r
                              </td>\n\r
                            </tr>\n\r
                            <tr> \n\r
                              <td colspan=\"3\">\n\r
                              <img src=\"elements".PATH_SEP."default".PATH_SEP."templates".PATH_SEP."alp_admin".PATH_SEP."images".PATH_SEP."menu_line_lightgreen.jpg\" width=\"100%\" height=\"2\">\n\r
                              </td>\n\r
                            </tr>\n\r
                            ";
        }
        return $return_cmds;
    }
	/*
	 * Insert/UPDATE extra fields
	 */
	function extraFields($cust_id, $sub_id, $inv_no, $fields, $do= "INSERT")
	{
        $data = array();
        $data['cust_id'] = $cust_id;
        $data['sub_id']  = $sub_id;
        $data['inv_no']  = $inv_no;
        if ($do == "SELECT")
        {
            $field_data = $this->extra_fields->hasAnyOne(array("WHERE `inv_no`='".$inv_no."'"));
            foreach ($fields as $field)
            {
                if ($field[2])//stored or not
                {
                    $data[$field[1]] = ($field[3])?$this->utils->alpencrypt->decrypt($field_data[$field[1]], $this->props->encryptionKey):$field_data[$field[1]];
                }
            }
            return $data;
        }
        else
        {
            foreach ($fields as $field)
            {
                if ($field[2])//stored or not
                {
                    $data[$field[1]] = ($field[3])?$this->utils->alpencrypt->encrypt($this->REQUEST[$field[1]], $this->props->encryptionKey):$this->REQUEST[$field[1]];
                }
            }
            if ($do == "INSERT")
    		{
    			return $this->extra_fields->insert($data);
    		}
    		if ($do == "UPDATE")
    		{
    			return $this->extra_fields->update($data,'inv_no');
    		}
        }
        return;
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
		if ($this->conf['en_prorate'])
		{
			$d1          = $this->utils->getDateArray($current_date);
			$d2          = $this->utils->getDateArray($prorate_array['next_bill_date']);
			$prorate_day = $d1['year'] . "-" . $d1['mon'] . "-" . $this->conf['prorate_date'];
			if ($d1['mday'] > $this->conf['prorate_date'])
            {
				$prorate_day = $this->utils->beginOfNextMonth($d1['mday'], $d1['mon'], $d1['year'], '%Y-%m') . "-" . $this->conf['prorate_date'];
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
	 * GET used coupons
	 */
	function getUsedCoupons($cust_id, $coupon_id = 0)
	{
		return $this->coupons->getUsedCoupons($cust_id, $coupon_id);
	}
	/*
	 * Mark hosting accounts
	 */
	function markAccounts($sub_id, $action)
	{
		$order      = $this->orders->getByKey($sub_id);
		$status     = $order['cust_status'];
		$product    = $this->products->getByKey($order['product_id']);
		$acc_method = isset($product['acc_method'])?$product['acc_method']:0;
		$product_id = isset($product['plan_price_id'])?$product['plan_price_id']:0;

		$server_default = empty($order['server_id'])?$this->products->getServerForProduct($product_id):$this->servers->getByKey($order['server_id']);

		$server_id  = $server_default['server_id'];
		if($action == "_create")       { $status = 1;}
		elseif($action == "_suspend")  { $status = 2;}
		elseif($action == "_unsuspend"){ $status = 1;}
		else                           { $status = 0;}

		$sql = "SELECT * FROM {$this->props->tbl_orders_servers_ips} WHERE `sub_id`='$sub_id'";
		if (count($this->dbL->executeSELECT($sql)))
		{
			$sql = "UPDATE {$this->props->tbl_orders_servers_ips} SET `server_id`='" . $server_id . "', `acct_status`='$status' WHERE `sub_id`='$sub_id'";
			$this->dbL->executeUPDATE($sql);
		}
		else
		{
			$sql= "INSERT INTO {$this->props->tbl_orders_servers_ips} VALUES('$sub_id','" . $server_id . "','0','$status')";
			$this->dbL->executeINSERT($sql);
		}
		$sql= "UPDATE {$this->props->tbl_orders} SET `cust_status`='" . $this->props->order_status[$status] . "' WHERE `sub_id`='$sub_id'";
		$this->dbL->executeUPDATE($sql);
	}
    function updateOrderStatus($order_id)
    {
    	$order_data = $this->orders->get("WHERE `orders`.sub_id='".$order_id."'");
        $data                = array();
        $data['sub_id']      = $order_id;
        $data['cust_status'] = $this->props->order_status[1];

        if(!empty($order_data[0]['dom_reg_type']) && empty($order_data[0]['dom_reg_comp']))
        {
        	$data['cust_status'] = $this->props->order_status[0];
        }
        if(!empty($order_data[0]['product_id']) && empty($order_data[0]['acct_status']))
        {
        	$data['cust_status'] = $this->props->order_status[0];
        }

        $this->orders->update($data);
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
            	$customer = $this->customers->getByKey($customer['id']);
            }
            else
            {
                $customer = $this->customers->hasAnyOne(array("WHERE `email`='".$customer['existing_email']."'"));
            }
            foreach($this->customfields->getAvailable() as $customfield)
            {
            	$customer[$customfield['field_name']]= $this->getCustomerFieldValue($customfield['field_name'],$customer['id']);
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

        $group   = $this->groups->getByKey($group_id);
        $cycle   = $this->props->cycles[$cycle_month];
        $special = $this->specials->getByKey($special_id);
        $temp           = $this->disc_token_codes->getByKey($customer['disc_token_code']);
        $discount_token = $this->disc_tokens->getByKey(isset($temp['disc_token_id'])?$temp['disc_token_id']:0);
        $coupon         = $this->coupons->hasAnyOne(array("WHERE `coupon_name`='".$customer['disc_token_code']."'"));

        //STEP1  : CALCULATE THE BASE PRICE
        $product            = $this->products->getByKey($product_id);
        $product_cycle_data = $this->products->getCycles($product_id);
        $INVOICE_DATA['setup_fee'] = isset($product['host_setup_fee'])?$product['host_setup_fee']:0;
        $INVOICE_DATA['cycle_fee'] = isset($product_cycle_data[$cycle])?$product_cycle_data[$cycle]:0;

        $addons            = array();
        $addon_cycle_datas = array();
        foreach($addon_ids as $addon_id)
        {
            $addons[]                    = $this->addons->getByKey($addon_id);
            $addon_cycle_datas[$addon_id]= $this->addons->getCycles($addon_id);
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
            $domain                  = $this->tlds->hasAnyOne(array("WHERE `dom_ext`='".$tld."' AND `dom_period`='".$year."'"));
            $INVOICE_DATA['tld_fee'] = $domain['dom_price'];
        }
        elseif($type==2)
        {
        	$domain                  = $this->subdomains->hasAnyOne(array("WHERE `maindomain`='".$tld."'"));
            $domain_cycle_datas      = $this->subdomains->getCycles($domain['main_id']);
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
             $this->conf['en_dt']                                      &&
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
             $this->conf['en_cc']                                      &&
             isset($coupon['customer_use'])                            &&
            (empty($coupon['customer_use']) || ($customer['member']    && $coupon['customer_use']==2) || (!$customer['member'] && $coupon['customer_use']==1)) &&
             $coupon['coupon_discount']>0                              &&
             strtotime($coupon['coupon_valid'])>=time()                &&
            (empty($customer['member']) || ($customer['member']        && !count($this->coupons->getUsedCoupons($customer['id'], $coupon['coupon_id']))))
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
        if($this->conf['include_sp_rec'])
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
        $INVOICE_DATA['prorate_desc']   = $this->props->lang['prorate_upto'] . " " . $this->fDate($prorate_array['due_date']);
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
        $INVOICE_DATA['pay_text']     = $this->props->lang['pay_now'] . " <b>" . $this->toCurrency($INVOICE_DATA['gross_amount'], null, 1) . "</b><br>";

        /*
         * CALCULATION ENDS HERE
         */
        //ADD some more variables
        $INVOICE_DATA['initial']          = $INVOICE_DATA['gross_amount'];
        $INVOICE_DATA['total_tax_amount'] = $INVOICE_DATA['tax_amount'];
        $INVOICE_DATA['bill']             = $ORDER_DATA['bill_cycle'];
        $INVOICE_DATA['tax_string']       = $INVOICE_DATA['tax_percent'];
        $INVOICE_DATA['friendly_desc']    = $this->getFriendlyDesc($INVOICE_DATA['desc'],0,$INVOICE_DATA['ORDER_DATA']['sld'].".".$INVOICE_DATA['ORDER_DATA']['tld']);

        $INVOICE_DATA['ORDER_DATA']['remote_id'] = $this->utils->realip();
        $temp = $this->geoip->getRemoteCountry($INVOICE_DATA['ORDER_DATA']['remote_id']);
        $INVOICE_DATA['ORDER_DATA']['remote_country_code'] = $temp[0]['COUNTRY_CODE2'];
        $INVOICE_DATA['ORDER_DATA']['remote_city']         = $temp[1]['CITY'];
        $INVOICE_DATA['ORDER_DATA']['remote_country']      = isset($this->props->country[strtoupper($INVOICE_DATA['ORDER_DATA']['remote_country_code'])])?$this->props->country[strtoupper($INVOICE_DATA['ORDER_DATA']['remote_country_code'])]:"";

        return $INVOICE_DATA;
    }
    function processOrder($TRANSACTION_ID=0)
    {
        $AUTO_EMAIL = false;
        $AUTO_CREATE= false;

        if(isset($this->REQUEST['id']) && $this->REQUEST['id'] && $this->REQUEST['member'])
        {
            $this->REQUEST['customer_id'] = $this->REQUEST['id'];
            $data = array();
            $data['id'] = $this->REQUEST['customer_id'];
            if ($this->REQUEST['customer_discount_amount'] && $this->REQUEST['disposable'])
            {
                $data['discount']   = 0;
                $data['disposable'] = 0;
            }
            if($this->REQUEST['debit_credit_balance'])
            {
                $data['credit'] = $this->REQUEST['debit_credit_balance'];
            }
            else
            {
                $data['credit']      = 0;
                $data['credit_type'] = '';
                $data['credit_desc'] = '';
            }
            $this->customers->update($data);
        }
        else
        {
            $this->REQUEST['customer_id'] = $this->customers->add($this->customfields->getAvailable());
        }
        $temp = $this->customers->getByKey($this->REQUEST['customer_id']);
        if($temp['trusted'])
        {
            $this->REQUEST['skip_auto_creation'] = 0;
        }
        if(isset($this->REQUEST['gross_amount']) && $this->REQUEST['gross_amount']==0)
        {
            $this->REQUEST['skip_auto_creation'] = 0;
        }

        if(isset($this->REQUEST['product_id']) && $this->REQUEST['product_id'])
        {
            $product_data = $this->products->getByKey($this->REQUEST['product_id']);
            if($product_data['acc_method']==2)
            {
                $AUTO_CREATE = true;
            }
        }
        $AUTO_CREATE = (isset($this->REQUEST['skip_auto_creation']) && $this->REQUEST['skip_auto_creation']==1)?false:$AUTO_CREATE;

        $AUTO_EMAIL = empty($this->conf['en_automail'])?false:true;

        //PREPARE SOME EXTRA DATA START
        $this->REQUEST['dom_reg_type']= ($this->REQUEST['type']==3)?0:$this->REQUEST['type'];
        $this->REQUEST['cust_status'] = $this->props->order_status[0];
        $this->REQUEST['status']      = ($TRANSACTION_ID)?$this->props->invoice_status[1]:$this->props->invoice_status[0];
        $this->REQUEST['transaction_id']= $TRANSACTION_ID;
        $this->REQUEST['pay_proc']    = $this->REQUEST['payment_method'];
        $this->REQUEST['dom_reg_year']= $this->REQUEST['year'];
        $Server = $this->getServerForProduct($this->REQUEST['product_id']);
        $this->REQUEST['server_id']   = $Server['server_id'];
        $this->REQUEST['ip_id']       = 0;
        $this->REQUEST['addon_ids']   = array();
        foreach($this->addons->getInvoiceAddonStringData($this->REQUEST['addon_fee']) as $addon_data)
        {
        	$this->REQUEST['addon_ids'][] = $addon_data['ADDON_ID'];
        }
        $this->REQUEST['desc']        = $this->REQUEST['product_id']."-".$this->REQUEST['sld'].".".$this->REQUEST['tld'];
        //PREPARE SOME EXTRA DATA END

        $this->REQUEST['order_id']    = $this->orders->add($this->REQUEST['customer_id']);
        $this->REQUEST['invoice_no']  = $this->invoices->add($this->REQUEST['order_id']);

        //DELETE DISPOSABLE DISCOUNTS AND COUPONS
        if(!empty($this->REQUEST['CUSTOMER_DATA']['disc_token_code']))
        {
            $disc_token_code= $this->REQUEST['CUSTOMER_DATA']['disc_token_code'];
            $temp           = $this->disc_token_codes->getByKey($disc_token_code);
            $discount_token = $this->disc_tokens->getByKey(isset($temp['disc_token_id'])?$temp['disc_token_id']:0);
            $coupon         = $this->coupons->hasAnyOne(array("WHERE `coupon_name`='".$disc_token_code."'"));

            if(isset($discount_token['disposable']) && $discount_token['disposable'])
            {
                $this->disc_token_codes->delete(array("WHERE `disc_token_codes`='".$disc_token_code."'"));
            }
            elseif(isset($coupon['coupon_id']) && $coupon['coupon_id'])
            {
                $this->coupons->useCoupon($this->REQUEST['customer_id'],$this->REQUEST['order_id'], $coupon['coupon_id']);
            }
        }

        //RECURRING DATA
        $this->recurring_data($this->REQUEST['order_id'], $this->REQUEST['bill_cycle'], "INSERT", "", $this->REQUEST['next_bill_date']);
        $this->extraFields($this->REQUEST['customer_id'], $this->REQUEST['order_id'], $this->REQUEST['invoice_no'], $this->pp_ext_fields[$this->REQUEST['pay_proc']], "INSERT");

        $change_order_status_result = ($AUTO_CREATE)?$this->changeStatus($this->REQUEST['order_id'], "create"):"";
        $domain_registration_result = ($AUTO_CREATE && $this->REQUEST['type'] == 1)?$this->registerDomain($this->REQUEST['domain_name'], $this->REQUEST['order_id'], "false", 0, $this->REQUEST['dom_reg_year']):0;
        $this->runCS('A_AC',$this->REQUEST['order_id'], $this->REQUEST['invoice_no']);

        if($AUTO_EMAIL)
        {
            $this->mailWelcome($this->REQUEST['order_id']);
            $this->mailInvoice($this->REQUEST['invoice_no']);
        }
        $this->updateOrderStatus($this->REQUEST['order_id']);
        $this->processSpecialOrder();
        return "<br />$change_order_status_result<br />$domain_registration_result<br />";
    }
    function processSpecialOrder()
    {
    	$special = $this->specials->getByKey(isset($this->REQUEST['SELECTED'])?$this->REQUEST['SELECTED']:0);
        if(isset($special['special_id']) && $special['new_order'])
        {
            $this->REQUEST['sld'] = isset($this->REQUEST['SELECTED_SLD'])?$this->REQUEST['SELECTED_SLD']:"";
            $this->REQUEST['tld'] = isset($this->REQUEST['SELECTED_TLD'])?$this->REQUEST['SELECTED_TLD']:"";
            $this->REQUEST['dom_reg_type'] = ($this->REQUEST['SELECTED_TYPE']==3)?0:$this->REQUEST['SELECTED_TYPE'];
            $this->REQUEST['product_id']   = isset($this->REQUEST['SELECTED_PRODUCT'])?$this->REQUEST['SELECTED_PRODUCT']:0;
            $this->REQUEST['addon_ids']    = isset($this->REQUEST['SELECTED_ADDON'])?array($this->REQUEST['SELECTED_ADDON']):array();
            $this->REQUEST['desc']         = $this->REQUEST['product_id']."-".$this->REQUEST['sld'].".".$this->REQUEST['tld'];

            $this->REQUEST['special_order_id']   = $this->orders->add($this->REQUEST['customer_id']);
            $this->REQUEST['special_invoice_no'] = $this->invoices->insert(array("desc"=>$this->REQUEST['desc'],"due_date"=>$this->REQUEST['due_date'],"status"=>$this->props->invoice_status[1]));
            if($this->REQUEST['special_invoice_no'])
            {
                $sql = "INSERT INTO `orders_invoices` VALUES('".$this->REQUEST['special_order_id']."','".$this->REQUEST['special_invoice_no']."')";
                $this->dbL->executeINSERT($sql);
            }
            $this->recurring_data($this->REQUEST['special_order_id'], $this->REQUEST['bill_cycle'], "INSERT", "", $this->REQUEST['next_bill_date']);
            $this->updateOrderStatus($this->REQUEST['special_order_id']);
        }
    }
    function processTransaction($item_number, $transaction_id)
    {
        $pInvoice = $this->invoices->get("WHERE `invoices`.invoice_no='".$item_number."'");
        $oOrder   = $this->orphan_orders->hasAnyOne(array("WHERE `item_number`='$item_number'"));

        if (isset($oOrder['orphanorder_id']))
        {
            $oOrder_Datas = $this->orphan_orders->get();
            $oOrder_Data  = $oOrder_Datas[$oOrder['orphanorder_id']];
            foreach($oOrder as $key=>$val)
            {
                $this->REQUEST[$key]= $val;
            }
            foreach ($oOrder_Data as $key => $val)
            {
                $this->REQUEST[$key]= $val;
            }
            $this->orphan_orders->del($oOrder['orphanorder_id']);
            $this->processOrder($transaction_id);
        }
        elseif (isset($pInvoice[0]['invoice_no']))
        {
            $this->invoices->update(array("invoice_no"=>$pInvoice[0]['invoice_no'],"transaction_id"=>$transaction_id,"status"=>$this->props->invoice_status[1]));
            $product = $this->products->getByKey($pInvoice[0]['product_id']);
            if (isset($product['acc_method']) && $product['acc_method'] == '2')
            {
                if ($pInvoice[0]['cust_status'] == $this->props->order_status[0])
                {
                    $inst= $this->changeStatus($pInvoice[0]['sub_id'], "create");
                }
                elseif ($pInvoice[0]['cust_status'] == $this->props->order_status[2])
                {
                    $inst= $this->changeStatus($pInvoice[0]['sub_id'], "activate");
                }
            }
            $this->REQUEST['invoice_no'] = $pInvoice[0]['invoice_no'];
            $this->updateOrderStatus($pInvoice[0]['sub_id']);
        }
        if($transaction_id)
        {
            $this->mailPaymentReciept($this->REQUEST['invoice_no']);
        }
        return;
    }
	/*
	 * change status
	 */
	function changeStatus($sub_id, $action)
	{
		$order                  = $this->orders->get("WHERE `orders`.sub_id='".$sub_id."'");
        $order_data             = $order[0];
		$order_data['dom_user'] = strtolower($order_data['dom_user']);
		$order_data['dom_pass'] = $this->utils->alpencrypt->decrypt($order_data['dom_pass'], $this->props->encryptionKey);
		$status                 = $order_data['cust_status'];

        $condition  = "LEFT JOIN `cpanel_reseller_profiles` ON `cpanel_reseller_profiles`.cpr_profile_id=`products`.cpr_profile_id " .
                      "LEFT JOIN `plesk_profiles` ON `plesk_profiles`.plesk_profile_id =`products`.plesk_profile_id " .
                      "WHERE `products`.plan_price_id='".$order_data['product_id']."'";

		$product    = $this->products->hasAnyOne(array($condition));
		$acc_method = $product['acc_method'];
		$product_id = $product['plan_price_id'];
		if ($product_id > 0 && $acc_method > 0)
		{
			$server = $this->getServerForProduct($product_id);
            //check and correction for cpanel
            if($server['server_type']=="cpanel" && (($server['server_user']!="root" && !eregi($server['server_user']."_",$product['plan_name'])) || eregi(" ",$product['plan_name'])))
            {
                $this->syncPackage($product_id);
                $product = $this->products->hasAnyOne(array($condition));
            }
			//Get plesk id if its a plesk order
			if ($server['server_type'] == "plesk")
			{
				$temp = $this->plesk_ids->hasAnyOne(array("WHERE `cust_id`='".$order_data['id']."'"));
				$order_data['plesk_id'] = $temp['plesk_id'];
			}
			if (!empty ($server['server_type']) && $server['server_auto'] == "yes" && $server['server_type'] != "other")
			{
				$serverHandler = null;
				$plugin_file   = $this->props->get_page("plugins/controlpanels/" . $server['server_type'] . ".php", "file", 1);
				if (is_readable($plugin_file))
                {
					require_once $plugin_file;
                }
				else
                {
					return $plugin_file . " " . $this->props->lang['not_readable'];
                }
				$plugin_name = $server['server_type'];
				$plugin_name = $plugin_name . "Handler";
				if (isset ($this-> $plugin_name))
                {
					$serverHandler= & $this-> $plugin_name;
                }
				//call functions
				$ip_id      = 0;
				$server_id  = $server['server_id'];
				$host       = $server['server_ip'];
				$user       = $server['server_user'];
				$password   = $this->utils->alpencrypt->decrypt($server['server_pass'], $this->props->encryptionKey);
				$accesshash = $this->utils->alpencrypt->decrypt($server['server_hash'], $this->props->encryptionKey);
				$usessl     = ($server['server_ssl'] == "yes")?1:0;
				$order_data['ns1'] = $server['name_server_1'];
				$order_data['ns2'] = $server['name_server_2'];
				///Activate order
				if ($action == "create")
				{
					$result = createAccount($host, $user, $password, $usessl, $product, $order_data, $serverHandler, $accesshash);
					$this->cp_message = $result['response'];
					if ($result['result'] == 1)
					{
						$status = 1;
						$sql    = "UPDATE {$this->props->tbl_servers} SET `current_accounts`=(`current_accounts`+1) WHERE `server_id`='" . $server_id . "'";
						$this->dbL->executeUPDATE($sql);
						$addi_ips = array();
						$temp   = $this->servers->additionalIPs($server_id);
						foreach ($temp as $t)
                        {
							$addi_ips[$t['ip_id']]= $t['ip'];
                        }
						$ip_id  = array_search($result['ip_address'], $addi_ips);
						if ($ip_id === false && !empty ($result['result']))
						{
							$ip    = $result['ip_address'];
							$ip_id = $this->ips->insert(array("server_id"=>$server_id,"ip"=>$ip));
						}
						//Store plesk if
						if ($server['server_type'] == "plesk")
						{
							$cust_id  = $order_data['parent_id'];
							$plesk_id = $result['plesk_id'];
                            $this->plesk_ids->insert(array("cust_id"=>$cust_id,"plesk_id"=>$plesk_id));
						}
						$sqlSELECT1= "SELECT * FROM {$this->props->tbl_orders_servers_ips} WHERE `sub_id`='$sub_id'";
						if (count($this->dbL->executeSELECT($sqlSELECT1)))
						{
							if (!empty ($ip_id))
                            {
								$str = "`ip_id`='$ip_id',";
                            }
							$sql = "UPDATE {$this->props->tbl_orders_servers_ips} SET `server_id`='" . $server_id . "', " . $str . " `acct_status`='$status' WHERE `sub_id`='$sub_id'";
							$this->dbL->executeUPDATE($sql);
						}
						else
						{
							if (!empty ($ip_id))
                            {
								$str = "'$ip_id',";
                            }
							$sql = "INSERT INTO {$this->props->tbl_orders_servers_ips} VALUES('$sub_id','$server_id'," . $str . "'$status')";
							$this->dbL->executeINSERT($sql);
						}
						$this->markAccounts($sub_id, "_" . $action);
						$this->mailNotice($sub_id, "ACTIVE");
					}
				}
				elseif ($action == "suspend")
				{
					$result = suspendAccount($host, $user, $password, $usessl, $order_data, $serverHandler, $accesshash);
					$this->cp_message = $result['response'];
					if ($result['result'] == 1)
					{
						$status = 2;
						$this->markAccounts($sub_id, "_" . $action);
						$this->mailNotice($sub_id, "SUSPEND");
					}
				}
				elseif ($action == "unsuspend")
				{
					$result = unsuspendAccount($host, $user, $password, $usessl, $order_data, $serverHandler, $accesshash);
					$this->cp_message = $result['response'];
					if ($result['result'] == 1)
					{
						$status = 1;
						$this->markAccounts($sub_id, "_" . $action);
						$this->mailNotice($sub_id, "ACTIVE");
					}
				}
				elseif ($action == "kill")
				{
					$result = killAccount($host, $user, $password, $usessl, $order_data, $serverHandler, $accesshash);
					$this->cp_message = $result['response'];
					if ($result['result'] == 1)
					{
						$status = 0;
						$sqlUPDATE = "UPDATE {$this->props->tbl_servers} SET `current_accounts`=(`current_accounts`-1) WHERE `server_id`='" . $server_id . "'";
						$this->dbL->executeUPDATE($sqlUPDATE);
						//Del plesk if
						if ($server['server_type'] == "plesk")
						{
							$cust_id  = $order_data['parent_id'];
							$this->plesk_ids->delete(array("WHERE `cust_id`='".$cust_id."'"));
						}
						$this->markAccounts($sub_id, "_" . $action);
					}
				}
			}
			if (empty ($this->props->order_status[$status]))
            {
				$status = 0;
            }
			$sqlUPDATE = "UPDATE {$this->props->tbl_orders} SET `cust_status`='" . $this->props->order_status[$status] . "' WHERE `sub_id`='$sub_id'";
			$this->dbL->executeUPDATE($sqlUPDATE);
            $this->orders->update(array("cust_status"=>$this->props->order_status[$status],"sub_id"=>$sub_id));
			$this->cp_message = trim($this->cp_message);
			if (empty ($this->cp_message))
            {
				$this->cp_message = $this->props->lang['No_respose_from_server'];
            }
			return $this->cp_message;
		}
		return $this->props->lang['either_product_doesnot_exist'];
	}
	/*
	 * List Accounts
	 */
	function listAccount($server_id)
	{
		$server= $this->servers->getByKey($server_id);
		if ($server['server_type'] == "other")
			return array ();
		$serverHandler= null;
		//include plugin
		$plugin_file= $this->props->get_page("plugins/controlpanels/" . $server['server_type'] . ".php", "file", 1);
		if (is_readable($plugin_file))
			require_once $plugin_file;
		else
			return $plugin_file . " " . $this->props->lang['not_readable'];
		$plugin_name= $server['server_type'];
		$plugin_name= $plugin_name . "Handler";
		if (isset ($this-> $plugin_name))
			$serverHandler= & $this-> $plugin_name;
		//call functions
		$host= $server['server_ip'];
		$user= $server['server_user'];
		$password= $this->utils->alpencrypt->decrypt($server['server_pass'], $this->props->encryptionKey);
		$accesshash= $this->utils->alpencrypt->decrypt($server['server_hash'], $this->props->encryptionKey);
		$usessl= 0;
		if ($server['server_ssl'] == "yes")
			$usessl= 1;
		$existing_accounts= listAccounts($host, $user, $password, $usessl, $serverHandler, $accesshash);
        return $existing_accounts;
	}
	/*
	 * Get Server for product
	 */
	function getServerForProduct($product_id)
	{
		return $this->products->getServerForProduct($product_id);
	}
	/*
	 * Check Account Exist or not in server
	 */
	function checkAccountExistInServer($server_default, $username, $return_count= false)
	{
		if (count($server_default))
		{
			$hosting_accounts = $this->listAccount($server_default['server_id']);
			foreach ($hosting_accounts as $key => $val)
			{
				if ($username === $key)
				{
					if ($return_count)
						return count($hosting_accounts);
					else
						return true;
				}
			}
		}
		return false;
	}
	/*
	 * sync packages
	 */
	function syncPackage($product_id)
	{
		$product = $this->products->getByKey($product_id);
	    $server  = $this->servers->getByKey($product['server_id']);

        //check and correction for cpanel
        if($server['server_type']=="cpanel")
        {
        	$product['plan_name'] = str_replace(" ","_",$product['plan_name']);
            if($server['server_user']!="root" && !eregi($server['server_user']."_",$product['plan_name']))
            {
            	$product['plan_name'] = $server['server_user']."_".$product['plan_name'];
            }
            $this->products->update(array("plan_name"=>$product['plan_name'], "plan_price_id"=>$product['plan_price_id']));
        }

		$serverHandler = null;
		$plugin_file   = $this->props->get_page("plugins/controlpanels/" . $server['server_type'] . ".php", "file", 1);
		if (is_readable($plugin_file))
        {
			require_once $plugin_file;
        }
		else
        {
			return $plugin_file . " " . $this->props->lang['not_readable'];
        }
		$plugin_name = $server['server_type'];
		$plugin_name = $plugin_name . "Handler";
		if (isset ($this->$plugin_name))
        {
			$serverHandler = &$this->$plugin_name;
        }
		//call functions
		$host      = $server['server_ip'];
		$user      = $server['server_user'];
		$password  = $this->utils->alpencrypt->decrypt($server['server_pass'], $this->props->encryptionKey);
		$accesshash= $this->utils->alpencrypt->decrypt($server['server_hash'], $this->props->encryptionKey);
		$usessl    = ($server['server_ssl'] == "yes")?1:0;
		$existing_packages= listPackages($host, $user, $password, $usessl, $serverHandler, $accesshash);
		if (array_search($product['plan_name'], $existing_packages) === false)
		{
			$action= $this->props->lang['Creating_package'];
			$result= syncPackage($host, $user, $password, $usessl, $product, "Create", $serverHandler, $accesshash);
		}
		else
		{
			$action= $this->props->lang['Editing_package'];
			$result= syncPackage($host, $user, $password, $usessl, $product, "Edit", $serverHandler, $accesshash);
		}
		$result    = trim($result);
		return empty ($result)?$this->props->lang['No_respose_from_server']:$action . $result;
	}
	/*
	 * import packages from server
	 */
	function impPackages($server_id)
	{
		$server       = $this->servers->hasAnyOne(array("WHERE `server_id`='".$server_id."'"));
		$serverHandler= null;
		//include plugin
		$plugin_file  = $this->props->get_page("plugins/controlpanels/" . $server['server_type'] . ".php", "file", 1);
		if (is_readable($plugin_file))
        {
			require_once $plugin_file;
        }
		else
        {
			return $plugin_file . " " . $this->props->lang['not_readable'];
        }
		$plugin_name  = $server['server_type'];
		$plugin_name  = $plugin_name . "Handler";
		if (isset ($this-> $plugin_name))
        {
			$serverHandler= & $this-> $plugin_name;
        }
		//call functions
		$host         = $server['server_ip'];
		$user         = $server['server_user'];
		$password     = $this->utils->alpencrypt->decrypt($server['server_pass'], $this->props->encryptionKey);
		$accesshash   = $this->utils->alpencrypt->decrypt($server['server_hash'], $this->props->encryptionKey);
		$usessl       = ($server['server_ssl'] == "yes")?1:0;
		$existing_packages= listPackages($host, $user, $password, $usessl, $serverHandler, $accesshash);
		return $existing_packages;
	}
	/*
	 * Function to send pass
	 */
	function get_pass($email)
	{
		if (!$this->utils->chkEmailFormat($email))
        {
			return false;
        }
        $customer = $this->customers->hasAnyOne(array("WHERE `email`='".$this->utils->quoteSmart($email)."'"));
		if (!isset($customer['id']))
        {
            return false;
        }
        $temp_pass = $this->utils->random_password();
        $hash      = md5($temp_pass);

        $this->customers->update(array("password"=>$hash,"id"=>$customer['id']));

        $from    = $this->conf['comp_email'];
        $to      = $customer['email'];
        $to_name = $this->getCustomerFieldValue("name",$customer['id']);
        $subject = $this->props->lang['pass_send'];
        $msg     = $this->props->lang['pass_send_body'];
        $msg    .= "    " . $temp_pass;
        $this->ALPmail->AddAddress($to, $to_name);
        $this->ALPmail->Subject = $subject;
        $this->ALPmail->Body    = $msg;
        $this->ALPmail->AltBody = $msg;
        $this->ALPmail->IsHTML(true);
        return $this->ALPmail->sendMail();
	}
	/*
	 * Verify transaction amount
	 */
	function verifyAmount($item_numder, $amount)
	{
		$amount  = number_format($amount, 2);
		$oOrders = $this->orphan_orders->get();
        foreach($oOrders as $orphanorder_id=>$oOrder)
        {
        	$temp = $this->orphan_orders->getByKey($orphanorder_id);
            if($temp['item_number']==$item_numder && number_format($oOrder['gross_amount'], 2)==$amount)
            {
            	return 1;
            }
        }
		$invoice = $this->invoices->getByKey($item_numder);
		if (number_format($invoice[0]['gross_amount'], 2) == $amount)
        {
			return 1;
        }
		return 0;
	}
	/*
	 * change_next_bill_date
	 */
	function change_next_bill_date($sub_id, $next_date)
	{
		$next_date= date('Y-m-d', strtotime($next_date));
		if (count($this->recurring_data($sub_id, 0, "SELECT")))
		{
			$sqlUPDATE= "UPDATE {$this->props->tbl_ord_inv_recs} SET `rec_next_date`='" . $next_date . "' WHERE `rec_ord_id`='" . $sub_id . "'";
            return $this->dbL->executeUPDATE($sqlUPDATE);
		}
		else
		{
			$sqlINSERT= "INSERT INTO {$this->props->tbl_ord_inv_recs} (`rec_ord_id`, `rec_next_date`)" .			"VALUES ('" . $sub_id . "','" . $next_date . "')";
            return $this->dbL->executeINSERT($sqlINSERT);
		}
	}
	/*
	 * recurring data
	 */
	function recurring_data($sub_id, $cycle, $do= "INSERT", $d1= "", $d2= "")
	{
		return $this->orders->recurring_data($sub_id, $cycle, $do, $d1, $d2);
	}
	/*
	 * Register domain
	 */
	function registerDomain($domain_name, $order_id, $get_registrar = "false", $registrar = "", $year = 1)
	{
		$dom_array    = explode(".", $domain_name, 2);
		$sld          = $dom_array[0];
		$tld          = $dom_array[1];
		$tld_data     = $this->tlds->hasAnyOne(array("WHERE `dom_ext`='".$tld."'"));
		if ($get_registrar == "true")
        {
			return $tld_data['tld_registrar'];
        }

        $registrar = empty($registrar)?$tld_data['tld_registrar']:$registrar;

		if (strtolower($registrar) == "manual")
		{
            $this->orders->update(array("dom_reg_comp"=>1,"dom_reg_type"=>1,"dom_registrar"=>"manual","sub_id"=>$order_id));
			return $this->props->lang['domain_marker_registered'];
		}

		$temp       = $this->orders->get("WHERE `orders`.sub_id='".$order_id."'");
		$order_data = $temp[0];
		$conf       = $this->conf;

		/*data for the registrar*/
        foreach($this->customfields->find() as $customfield)
        {
            $this->REQUEST[$customfield['field_name']]= $this->getCustomerFieldValue($customfield['field_name'],$order_data['id']);
        }
        $this->REQUEST['id']      = $order_data['id'];
		$this->REQUEST['email']   = $order_data['email'];
        $this->REQUEST['domain_name'] = $order_data['domain_name'];
		$this->REQUEST['domain']  = $order_data['domain_name'];
        $this->REQUEST['user']    = $order_data['dom_user'];
		$this->REQUEST['dom_user']= $order_data['dom_user'];
		$this->REQUEST['dom_pass']= $this->utils->alpencrypt->decrypt($order_data['dom_pass'], $this->props->encryptionKey);
		$this->REQUEST['r_ip']    = $order_data['remote_ip'];
		//Determine name server
		$product    = $this->products->getByKey($order_data['product_id']);
		$server_id  = $product['server_id'];
		$server_default = $this->getServerForProduct($server_id);
		if (!empty ($order_data['dom_reg_year']) || $order_data['dom_reg_year']==99)
        {
			$order_data['dom_reg_year']= 1;
        }
        if($year==99)
        {
            $year=1;
        }
		$this->REQUEST['ns1']         = $server_default['name_server_1'];
		$this->REQUEST['ns2']         = $server_default['name_server_2'];
		$this->REQUEST['dom_period']  = $order_data['dom_reg_year'];
		if (!empty ($year))
		{
			$this->REQUEST['dom_period'] = $year;
		}
		$order_data['sub_id']     = $order_id;
		$this->REQUEST['sub_id']  = $order_data['sub_id'];
		$registration_result      = "";
        $file_name = $this->props->get_page("plugins/registrars/".$registrar.".php", "file", 1);
		if (is_readable($file_name))
		{
			$process_domain = true;
            include $file_name;//include_once will not work as its included already
		}
		$registration_result = trim($registration_result);
		if (empty ($registration_result))
        {
			return $this->props->lang['No_respose_from_registrar'];
        }
		return $registration_result;
	}
    /*
     * Generate Invoices
     */
    function genInvoices($order_id, $intermediate= false, $date1= null, $upcoming= false, $prev_bill= false)
    {
        $conf = $this->conf;
        //DATES
        $todays_date_array = getdate();
        $temp              = $this->recurring_data($order_id, 0, "SELECT");
        $next_due_date     = $temp['rec_next_date'];
        $today             = $this->utils->getXdayAfter($conf['send_before_due'], $todays_date_array);
        if (!empty ($date1) && $this->utils->checkDateFormat($date1))
        {
            $todays_date_array = $this->utils->getDateArray($date1);
            if (!$prev_bill && $prev_bill!='U')
            {
                $today = $this->utils->getXdayAfter($conf['send_before_due'], $todays_date_array);
            }
            else
            {
                $today = $todays_date_array;
            }
        }
        $v_day = date('Y-m-d', strtotime($today['year'] . "-" . $today['mon'] . "-" . $today['mday']));

        //CHECK AND GENERATE INVOICE
        //echo $next_due_date." == ".$v_day."<br>";
        if ($next_due_date == $v_day && $intermediate == false && $upcoming == false)
        {
            $temp  = $this->orders->get("WHERE `orders`.sub_id='".$order_id."'");
            $order = $temp[0];

            $order['bill_cycle'] = (empty ($order['bill_cycle']) || empty ($order['product_id']))?12:$order['bill_cycle'];
            $cycle_name = $this->props->cycles[$order['bill_cycle']];
            $desc       = $order['product_id'] . "-" . $order['domain_name'] . "-" . $next_due_date;

            $temp = $this->invoices->get("WHERE `invoices`.desc = '" . $order['product_id'] . "-" . $order['domain_name'] . "' AND `orders`.domain_name='".$order['domain_name']."' AND `orders`.product_id='".$order['product_id']."'");
            $start_invoice = $temp[0];

            $dom_array = explode(".", $order['domain_name'], 2);
            $sld       = $dom_array[0];
            $tld       = $dom_array[1];

            $this->REQUEST['pay_text'] = "";

            $tld_amount = 0;
            $echo       = "";
            //GET DOMAIN REGISTRATION PRICE
            if ($order['dom_reg_type'] == 1)
            {
                $tld_data   = $this->tlds->find(array("WHERE `dom_ext`='".$tld."'"));
                $month_diff = $this->utils->count_months($order['sign_date'], $next_due_date);
                $division   = $month_diff / ($order['dom_reg_year'] * 12);
                if ($order['dom_reg_year'] * 12 == $month_diff || $division == floor($division))
                {
                    $echo .= "RENUE DOMAIN,   ";
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
                $subdomain_data  = $this->subdomains->find(array("WHERE `maindomain`='".$tld."'"));
                $subdomain_cycle = $this->subdomains->getCycles($subdomain_data[0]['main_id']);
                $echo           .= "RENUE SUB DOMAIN,   ";
                $tld_amount      = $subdomain_cycle[$cycle_name];
            }
            else
            {
                $tld_amount = 0;
            }
            if ($tld_amount > 0)
            {
                $this->REQUEST['pay_text'] .= $order['domain_name'] . " => <b>" . $this->toCurrency($tld_amount,null,1);
                $this->REQUEST['pay_text'] .= "</b><br>";
            }
            $this->REQUEST['tld_fee'] = $tld_amount;


            //GET PRODUCT PRICE
            $cycle_amount   = 0;
            $product_cycles = $this->products->getCycles($order['product_id']);
            $cycle_amount   = $product_cycles[$cycle_name];
            if ($cycle_amount > 0)
            {
                $this->REQUEST['pay_text'] .= $this->getFriendlyName($order['product_id']) . " => <b>" . $this->toCurrency($cycle_amount,null,1);
                $this->REQUEST['pay_text'] .= "</b><br>";
            }
            $this->REQUEST['cycle_fee']= $cycle_amount;


            //GET ADDON PRICE
            $pay_text1     = "";
            $order_addons  = $this->orders->getAddons($order_id);
            $inv_addon_fee = "<&>";
            $addon_amount  = 0;
            foreach ($order_addons as $order_addon)
            {
                $addon_data   = $this->addons->getByKey($order_addon['addon_id']);
                $addon_cycles = $this->addons->getCycles($order_addon['addon_id']);
                if (isset($addon_data['addon_name']))
                {
                    $inv_addon_fee .= $addon_data['addon_name'] . ">0.00>" . $this->utils->toFloat($addon_cycles[$cycle_name]) . "<&>";
                    $addon_amount   = $addon_amount + $addon_cycles[$cycle_name];
                    $pay_text1     .= $addon_data['addon_name'] . " => <b>" . $this->toCurrency($addon_cycles[$cycle_name],null,1);
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
            $invoices  = $this->invoices->find(array("WHERE `desc` LIKE '" . $order['product_id'] . "-" . $order['domain_name'] . "-" . trim($temp[0]) . "-" . trim($temp[1]) . "-%'"));
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
                    $this->REQUEST['pay_text'] .= $this->props->lang['and'] . " " . $this->props->lang['credit'] . " = <b>" . $this->toCurrency($order['credit'],null,1);
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
                $this->customers->update($data);
            }
            //calculate tax
            //get tax data
            $tax_string       = null;
            $total_tax_amount = 0;
            foreach ($this->calculateTax($this->REQUEST['net_amount'], $this->getCustomerFieldValue("country",$order['id']), $this->getCustomerFieldValue("state",$order['id'])) as $r_k => $r_v)
            {
                ${ $r_k }= $r_v;
            }
            $this->REQUEST['tax_percent']     = $tax_string;
            $this->REQUEST['tax_amount']      = $total_tax_amount;
            $this->REQUEST['gross_amount']    = $this->REQUEST['net_amount'] + $this->REQUEST['tax_amount'];
            $this->REQUEST['status']          = $this->props->invoice_status[0];
            $this->REQUEST['order_id']        = $order_id;
            $this->REQUEST['due_date']        = $next_due_date;
            if (isset ($this->REQUEST['force_status']))
            {
                $this->REQUEST['status'] = $this->REQUEST['force_status'];
            }
            $echo .= $this->REQUEST['desc'] . "<br />";

            $this->REQUEST['invoice_no'] = 0;
            if (!count($invoices))
            {
                $this->REQUEST['invoice_no'] = $this->invoices->add($this->REQUEST['order_id']);
            }
            elseif ($invoices[0]['status'] == $this->props->invoice_status[5])
            {
                $this->REQUEST['invoice_no'] = $invoices[0]['invoice_no'];
                $this->invoices->update($this->REQUEST);
            }
            if (!empty ($this->REQUEST['invoice_no']))
            {
                $this->recurring_data($this->REQUEST['order_id'], 0, "UPDATE", $this->REQUEST['due_date']);
            }
            if ($conf['en_automail'] && $this->REQUEST['status']==$this->props->invoice_status[0])
            {
                $this->mailInvoice($this->REQUEST['invoice_no']);
            }
            return $desc;
        }
        elseif ($intermediate == true)
        {
            $this->REQUEST['force_status'] = $this->REQUEST['mark_as'];
            $return_string = '';
            $temp          = $this->recurring_data($order_id, 0, "SELECT");
            $next_due_date = $temp['rec_next_date'];
            while ($next_due_date <= date('Y-m-d'))
            {
                $return_string .= $this->genInvoices($order_id, false, $next_due_date) . "\n";
                $temp           = $this->recurring_data($order_id, 0, "SELECT");
                $next_due_date  = $temp['rec_next_date'];
            }
            return $return_string;
        }
        elseif ($upcoming == true && $conf['u_invoice_date'] > 0)
        {
            $this->REQUEST['force_status'] = $this->props->invoice_status[5];

            $echo               = "";
            $continue           = false;
            $temp               = $this->recurring_data($order_id, 0, "SELECT");
            $next_due_date      = $temp['rec_next_date'];
            $restore_actual_due = $next_due_date; //restore later
            $max_upcoming_date  = date('Y-m-d');
            $d1                 = ($conf['u_invoice_date'] > 12)?floor($conf['u_invoice_date'] / 30):$conf['u_invoice_date'];
            $today              = $this->utils->getXmonthsAfter($d1, getdate());
            $max_upcoming_date  = date('Y-m-d', strtotime($today['year'] . "-" . $today['mon'] . "-" . $today['mday']));
            $next_due_date_array= $this->utils->getDateArray($next_due_date);
            //echo $max_upcoming_date. "<br />";
            //echo $next_due_date. "<br />";
            if($this->utils->compareDates($today['mday'],$today['mon'],$today['year'],$next_due_date_array['mday'],$next_due_date_array['mon'],$next_due_date_array['year'])!=-1)
            {
                $continue = true;
            }
            while ($continue && $next_due_date<$max_upcoming_date)
            {
                $echo .= $this->genInvoices($order_id, false, $next_due_date,false,'U') . "<br />";
                $temp  = $this->recurring_data($order_id, 0, "SELECT");

                $rec_next_date_array     = $this->utils->getDateArray($temp['rec_next_date']);
                $max_upcoming_date_array = $this->utils->getDateArray($max_upcoming_date);
                $next_due_date_array     = $this->utils->getDateArray($next_due_date);

                //echo $temp['rec_next_date']."<br />";

                $date_compare1 = $this->utils->compareDates($max_upcoming_date_array['mday'],$max_upcoming_date_array['mon'],$max_upcoming_date_array['year'],$rec_next_date_array['mday'],$rec_next_date_array['mon'],$rec_next_date_array['year']);
                $date_compare2 = $this->utils->compareDates($rec_next_date_array['mday'],$rec_next_date_array['mon'],$rec_next_date_array['year'],$next_due_date_array['mday'],$next_due_date_array['mon'],$next_due_date_array['year']);

                //if ($date_compare1 != -1 && $date_compare2 == -1)
                if($temp['rec_next_date']<$max_upcoming_date && $temp['rec_next_date']!=$next_due_date)
                {
                    $next_due_date = $temp['rec_next_date'];
                }
                else
                {
                    $continue = false;
                }
            }
            $sqlUPDATE = "UPDATE {$this->props->tbl_ord_inv_recs} SET `rec_next_date`='" . $restore_actual_due . "' WHERE `rec_ord_id`='" . $order_id . "'";
            $this->dbL->executeUPDATE($sqlUPDATE);
            echo $echo;
        }
        return null;
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

        $temp    = $this->invoices->get("WHERE `invoice_no`='".$invoice_no."'");
        $invoice = $temp[0];
        $invoice_template = $this->emails->getByKey(2);
        $body    = $this->utils->entity_decode($this->utils->htmlspecialchars_decode($invoice_template['email_text']));
        //fix for new tax and date variable name
        $body    = str_replace("<lang>tax</lang>", "<&&>tax_name<&&>", $body);
        $body    = str_replace("<lang>payment_date</lang>", "<&&>due_date<&&>", $body);
        $subject = $this->props->lang['Invoice_from'] . $this->conf['company_name'] . " " . $this->props->lang['for'] . " " . $this->getFriendlyDesc($invoice['desc'],$invoice['order_id'],$invoice['domain_name']);
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
            $data_array['total_tax_amount'] = $this->toCurrency($invoice['tax_amount'], null, 1);
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
            $data_array["order_addon_amount[".$k."]"] = $this->toCurrency($v, null, 1);
            $this->_invoiceValuesTaxAmount($k,$v,& $data_array,$invoice_tax_string, $tax_names);
            $this->_invoiceValuesTaxAmount("order_addon_amount[".$k."]",$v,& $data_array,$invoice_tax_string, $tax_names);
            if($i<count($addons))
                $body= str_replace($str,$new_str.$str,$body);
            else
                $body= str_replace($str,$new_str,$body);
            $i++;
        }

        $data_array['total_amount'] = $this->toCurrency($invoice['gross_amount'], null, 1);
        $data_array['login_link']   = "<a href=\"" . $this->conf['path_url'] . "/customer.php\" target=\"_blank\">" . $this->props->lang['Click_Here'] . "</a>" . $this->props->lang['login_link'];
        $data_array['payment_link'] = "<a href=\"" . $this->conf['path_url'] . "/customer.php?cmd=pay&pp=" . $invoice['pay_proc'] . "&invoice_no=" . $invoice_no . "\" target=\"_blank\">" . $this->props->lang['Click_Here'] . "</a>" . $this->props->lang['paylink'];

        if ($invoice['status'] == $this->props->invoice_status[1])
        {
            $data_array['payment_link']= "<a href=\"" . $this->conf['path_url'] . "/customer.php?cmd=viewInvoice&pp=" . $invoice['pay_proc'] . "&invoice_no=" . $invoice_no . "\" target=\"_blank\">" . $this->props->lang['Click_Here'] . "</a>" . $this->props->lang['paylink'];
        }

        $data_array['domain_amount']= $this->toCurrency($invoice['tld_fee'], null, 1);
        $this->_invoiceValuesTaxAmount('domain_amount',$invoice['tld_fee'],& $data_array,$invoice_tax_string, $tax_names);

        $data_array['setup_amount'] = $this->toCurrency($invoice['setup_fee'], null, 1);
        $this->_invoiceValuesTaxAmount('setup_amount',$invoice['setup_fee'],& $data_array,$invoice_tax_string, $tax_names);

        $data_array['cycle_amount'] = $this->toCurrency($invoice['cycle_fee'], null, 1);
        $this->_invoiceValuesTaxAmount('cycle_amount',$invoice['cycle_fee'],& $data_array,$invoice_tax_string, $tax_names);

        $data_array['cycle']        = $this->props->lang[$cycle[$invoice['bill_cycle']]];

        $data_array['debit_credit'] = $this->props->lang['Credit_Debit'];
        if ($invoice['debit_credit'] != "")
        {
          $data_array['debit_credit']= $invoice['debit_credit'];
        }
        $data_array['debit_credit_reason']= $invoice['debit_credit_reason'];
        $data_array['debit_credit_amount']= $this->toCurrency($invoice['debit_credit_amount'], null, 1);
        $this->_invoiceValuesTaxAmount('debit_credit_amount',$invoice['debit_credit_amount'],& $data_array,$invoice_tax_string, $tax_names);

        if ($invoice['debit_credit'] == $this->props->lang['debit'])
        {
          $data_array['debit_credit_amount']= "+ " . $this->toCurrency($invoice['debit_credit_amount'], null, 1);
        }
        elseif ($invoice['debit_credit'] == $this->props->lang['credit'])
        {
          $data_array['debit_credit_amount']= "- " . $this->toCurrency($invoice['debit_credit_amount'], null, 1);
        }

        $data_array['discount_amount']  = "- " . $this->toCurrency($invoice['other_amount'], null, 1);
        $this->_invoiceValuesTaxAmount('discount_amount',$invoice['other_amount'],& $data_array,$invoice_tax_string, $tax_names);

        $data_array['client_email'] = $invoice['email'];
        foreach($this->customfields->find() as $customfield)
        {
            $data_array['client_'.$customfield['field_name']]= $this->getCustomerFieldValue($customfield['field_name'],$invoice['customer_id']);
        }
        $data_array['client_country']   = $this->props->country[$this->getCustomerFieldValue("country",$invoice['customer_id'])];
        $data_array['company_email']    = $this->conf['comp_email'];
        $data_array['company_name']     = $this->conf['company_name'];
        $data_array['company_address']  = $this->conf['company_address'];
        $data_array['description']      = $this->getFriendlyDesc($invoice['desc'],$invoice['customer_id'],$invoice['domain_name']);

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
        $data_array['payment_date']     = $this->fDate($invoice['due_date']);
        $data_array['due_date']         = $this->fDate($invoice['due_date']);
        $data_array['invoice_no']       = $this->conf['invoice_prefix'] . $invoice['invoice_no'] . $this->conf['invoice_suffix'];
        $data_array['plan_name']        = $this->getFriendlyName($invoice['product_id']);
        $data_array['prorate_desc']     = $invoice['prorate_desc'];
        $data_array['prorate_amount']   = $this->toCurrency($invoice['prorate_amount'], null, 1);
        $this->_invoiceValuesTaxAmount('prorate_amount',$invoice['prorate_amount'],& $data_array,$invoice_tax_string, $tax_names);

        $data_array['net_amount']       = $this->toCurrency($invoice['net_amount'], null, 1);
        $this->_invoiceValuesTaxAmount('net_amount',$invoice['net_amount'],& $data_array,$invoice_tax_string, $tax_names);
        $this->_invoiceValuesTaxAmount('subtotal',$invoice['net_amount'],& $data_array,$invoice_tax_string, $tax_names);

        $data_array['symbol']           = $this->conf['symbol'];
        $data_array['additional_currency']= "";
        if ($invoice['pay_curr_factor'] > 1)
        {
          $curr_conf                    = array ();
          $curr_conf['symbol_prefixed'] = $invoice['pay_curr_symbol_prefixed'];
          $curr_conf['symbol']          = $invoice['pay_curr_symbol'];
          $curr_conf['decimals']        = $invoice['pay_curr_decimal_number'];
          $curr_conf['str1']            = $invoice['pay_curr_decimal_str'];
          $curr_conf['str2']            = $invoice['pay_curr_thousand_str'];
          $data_array['additional_currency']= "<b>" . $this->props->lang['Total_amount_in'] . $invoice['pay_curr_name'] . "(" . $invoice['pay_curr_symbol'] . ") = " . $this->toCurrency($invoice['pay_curr_factor'] * $invoice['gross_amount'], $curr_conf, 1);
        }
        $data_array['detail']           = $invoice['pay_text'];

        $body   = $this->etp->parseEmail($data_array,$body);

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
            $evaluated_array[$echo] = $this->toCurrency($v,null,1);
        }

        $match      = $this->utils->strInTag('eval', $body, 'ALL');
        foreach($match as $k=>$v)
        {
            $echo   = "eval[".$k."]";
            $body   = str_replace("<eval>".$v."</eval>", "<evaluated>".$echo."<evaluated>", $body);
            $evaluated_array[$echo] = $this->utils->matheval($v);
        }

        $body   = $this->etp->parseEmail($evaluated_array,$body,"evaluated");
        $body   = $this->etp->parseEmail($data_array,$body);

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
        $body   = $this->utils->clnTag('if_dedit_credit',$this->utils->strInTag('if_debit_credit',$body),$body);
        $body   = $this->utils->clnTag('if_prorate',$this->utils->strInTag('if_prorate',$body),$body);
        $body   = $this->utils->clnTag('if_tax',$this->utils->strInTag('if_tax',$body),$body);
        if($return_data_array)return $data_array;

        $subject= $this->etp->parseEmail($data_array,$subject);
        if ($no_mail)
            return $body;

        $this->inv_to   = $invoice['email'];
        $this->msg      = $body;
        $this->ALPmail->AddAddress($invoice['email'], $this->getCustomerFieldValue("name",$invoice['customer_id']));
        $this->ALPmail->AddCC($this->conf['comp_email'], $this->conf['company_name']);
        $this->ALPmail->Subject = $subject;
        $this->ALPmail->Body    = $body;
        return $this->ALPmail->sendMail();
    }
    function _invoiceValuesTaxAmount($key,$amount,& $data_array,$invoice_tax_string, $tax_names)
    {
        $data_array["float_amount[".$key."]"] = floatval($amount);
        foreach($tax_names as $tn)
        {
            $amt = $this->_getTaxAmountForAmountInInvoice($invoice_tax_string,$amount,$tn);
            $data_array["tax_amount[".$tn."][".$key."]"] = $this->toCurrency($amt, null, 1);
            $data_array["float_amount[tax_amount[".$tn."][".$key."]]"] = floatval($amt);
        }
        $amt = $this->_getTaxAmountForAmountInInvoice($invoice_tax_string,$amount,'total_tax_amount');
        $data_array["tax_amount[total_tax_amount][".$key."]"] = $this->toCurrency($amt, null, 1);
        $data_array["float_amount[tax_amount[total_tax_amount][".$key."]]"] = floatval($amt);
    }
    function _getTaxAmountForAmountInInvoice($invoice_tax_string,$amount,$taxname)
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
            $tax_data_for_calcutation[$i]['tax_name']       = $temp_v[2];
            $tax_data_for_calcutation[$i]['tax_amount']     = $temp_v[0];
            $tax_data_for_calcutation[$i]['tax_add_sub']    = $temp_v[3];
            $tax_data_for_calcutation[$i]['tax_net_comp']   = $temp_v[4];
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
     * Ticket email
     */
    function mailTicket($ticket_id,$new_ticket = true)
    {
        $conf      = $this->conf;
        $ticket    = $this->support_tickets->getByKey($ticket_id);
        $co_admins = $this->admin_users->find();
        $customer  = $this->customers->getByKey($ticket['cust_id']);
        $customer_name = $this->getCustomerFieldValue("name",$customer['id']);
        if ($new_ticket)
        {
            $subject = $conf['company_name'] . " - " . $this->props->lang['new_ticket_added'] . $customer_name;
            $msg     = $this->props->lang['ticket_no'] . $ticket['ticket_id'] . "<br>";
            $msg    .= $this->props->lang['Date'] . " : " . $this->fDate($ticket['ticket_date'], ' H:i:s') . "<br>";
            $msg    .= $subject . "<br><hr><br><br>";
            $msg    .= $ticket['ticket_text'];
            $msg    .= "<br><hr><br><br>";
            $msg    .= "Details:<br>".$_SERVER. "<br><br>";
        }
        else
        {
            $reply  = $this->support_replies->hasAnyOne(array("WHERE `ticket_id` = '".$ticket_id."' ORDER BY `reply_id` DESC"));
            $reply_by_user = $reply['reply_by'];
            $temp_data     = $this->customers->hasAnyOne(array("WHERE `email`='".$reply_by_user."'"));
            if(isset($temp_data['id']) && !empty($temp_data['id']))
            {
            	$reply_by_user = $this->getCustomerFieldValue("name",$temp_data['id']);
            }

            if ($ticket['ticket_status'] < 3)
            {
                $subject = $conf['company_name'] . " - " . $this->props->lang['reply_added'] . $reply_by_user;
                $msg     = $this->props->lang['ticket_no'] . $ticket['ticket_id'] . "<br>";
                $msg    .= $this->props->lang['Date'] . " : " . $this->fDate($reply['reply_date'], ' H:i:s') . "<br>";
                $msg    .= $subject . "<br><hr><br><br>";
                $msg    .= $reply['reply_text'];
                $msg    .= "<br><hr><br><br>";
            }
            else
            { //closed
                $subject = $conf['company_name'] . " - " . $this->props->lang['ticket_closed_by'] . $reply_by_user;
                $msg     = $this->props->lang['ticket_no'] . $ticket['ticket_id'] . "<br>";
                $msg    .= $this->props->lang['Date'] . " : " . $this->fDate(date('d-M-Y H:i:s'), ' H:i:s') . "<br>";
                $msg    .= $subject . "<br><hr><br><br>";
                $msg    .= $subject;
                $msg    .= "<br><hr><br><br>";
            }
        }

        $subject = $subject."[TICKET NO:".$ticket_id."]";

        //mail to customer
        $link      = "<a href=\"" . $conf['path_url'] . "/customer.php?cmd=viewTicket&ticket_id=" . $ticket_id . "\" target=\"_blank\">" . $this->props->lang['go_ticket'] . "</a>";
        $message_b = $msg . $link;
        $message   = $message_b;
        $to1       = $customer['email'];
        $from      = $conf['comp_email'];
        $this->ALPmail->AddAddress($customer['email'], $this->getCustomerFieldValue("name",$customer['id']));
        $this->ALPmail->Subject = $subject;
        $this->ALPmail->Body    = $message;
        $this->ALPmail->sendMail();
        //mail to admin main
        $link      = "<a href=\"" . $conf['path_url'] . "/admin.php?cmd=viewTicket&ticket_id=" . $ticket_id . "\" target=\"_blank\">" . $this->props->lang['go_ticket'] . "</a>";
        $message_b = $msg . $link;
        $message   = $message_b;
        $to2       = $conf['comp_email'];
        $this->ALPmail->AddAddress($conf['comp_email'], $conf['company_name']);
        $this->ALPmail->Subject = $subject;
        $this->ALPmail->Body    = $message;
        $this->ALPmail->sendMail();
        //mail to co-admins
        foreach ($co_admins as $admin)
        {
            $topic_ids = explode("<&&>", $admin['topic_id']);
            $this->utils->Remove_Empty_Elements($topic_ids);
            if (array_search($ticket['topic_id'], $topic_ids) !== false)
            {
                $link      = "<a href=\"" . $conf['path_url'] . "/admin.php?cmd=viewTicket&ticket_id=" . $ticket_id . "\" target=\"_blank\">" . $this->props->lang['go_ticket'] . "</a>";
                $message_b = $msg . $link;
                $message   = $message_b;
                $this->ALPmail->AddAddress($admin['email'], $conf['company_name']);
                $this->ALPmail->Subject = $subject;
                $this->ALPmail->Body    = $message;
                $this->ALPmail->sendMail();
            }
        }
    }
    /*
     * Mail welcome
     */
    function mailWelcome($order_no,$return_data_array=false)
    {
        $data_array = array();
        $cycle  = $this->props->cycles;
        $temp   = $this->orders->get("WHERE `orders`.sub_id='".$order_no."'");
        $order  = $temp[0];
        $server = $this->servers->getByKey($order['server_id']);
        $ip     = $this->ips->getByKey($order['ip_id']);
        $order_template  = $this->emails->getByKey(1);
        $subject= $this->conf['company_name'] . " " . $this->props->lang['order_confirmation'];
        $body   = $this->utils->entity_decode($this->utils->htmlspecialchars_decode($order_template['email_text']));
        if(!empty($order_template['email_subject']))
        {
            $subject = $this->utils->entity_decode($this->utils->htmlspecialchars_decode($order_template['email_subject']));
        }

        if (empty ($body) || empty($order_no) || !count($order))
        {
            return false;
        }

        $data_array = $order;
        foreach($server as $key=>$value)
        {
        	$data_array[$key]=$value;
        }
        $data_array['ip']           = $ip['ip'];
        $data_array['login_link']   = "<a href=\"" . $this->conf['path_url'] . "/customer.php\" target=\"_blank\">" . $this->props->lang['Click_Here'] . "</a>" . $this->props->lang['login_link'];
        $data_array['order_no']     = $this->conf['order_prefix'] . $order['sub_id'] . $this->conf['order_suffix'];
        $data_array['client_email'] = $order['email'];
        foreach($this->customfields->find() as $customfield)
        {
            $data_array['client_'.$customfield['field_name']]= $this->getCustomerFieldValue($customfield['field_name'],$order['customer_id']);
        }
        $data_array['client_country']= $this->props->country[$this->getCustomerFieldValue("country",$order['customer_id'])];
        $data_array['company_email'] = $this->conf['comp_email'];
        $data_array['company_name']  = $this->conf['company_name'];
        $data_array['company_address']= $this->conf['company_address'];
        $txt = '';
        if ($order['dom_reg_type'] == 1)
        {
          $txt= $this->props->lang['domain_management'];
        }
        if (!empty ($order['product_id']))
        {
          if (!empty ($txt))
          {
              $txt .= ", ";
          }
          $txt .= $this->props->lang['cp_ftp'];
        }
        $data_array['login_for']= $this->props->lang['for'] . " " . $txt;
        $data_array['username'] = $order['dom_user'];
        $data_array['password'] = $this->utils->alpencrypt->decrypt($order['dom_pass'], $this->props->encryptionKey);
        if ($order['dom_reg_type'] == 1)
        {
          $txt  = $order['dom_reg_year'] . " " . $this->props->lang['years_registration'];
          if($order['dom_reg_year']==99)
            $txt= "(". $this->props->lang['one_time'].")";
        }
        $data_array['domain_name']= $order['domain_name'] . " " . $txt;
        $txt    = "N/A";
        if ($order['dom_reg_type'] == 1)
        {
          $txt  = " (" . $order['dom_reg_year'] . " " . $this->props->lang['years_registration'] . ")";
          if($order['dom_reg_year']==99)
          {
            $txt= "(". $this->props->lang['one_time'].")";
          }
        }
        $data_array['domain_year'] = $txt;
        $data_array['domain']      = $order['domain_name'];
        $data_array['plan_name']   = $this->getFriendlyName($order['product_id']);
        $data_array['sign_date']   = $this->fDate($order['sign_date']);

        if($return_data_array)return $data_array;

        $body       = $this->etp->parseEmail($data_array,$body);
        $subject    = $this->etp->parseEmail($data_array,$subject);
        $this->notice_to = $order['email'];
        $this->msg  = $body;
        $this->ALPmail->AddAddress($order['email'], $this->getCustomerFieldValue("name",$order['id']));
        $this->ALPmail->AddCC($this->conf['comp_email'], $this->conf['company_name']);
        $this->ALPmail->Subject = $subject;
        $this->ALPmail->Body    = $body;
        return $this->ALPmail->sendMail();
    }
    /*
     * Activation Suspension mail
     */
    function mailNotice($order_no, $type= "ACTIVE")
    {
        $data_array = array();
        $cycle  = $this->props->cycles;
        $temp   = $this->orders->get("WHERE `orders`.sub_id='".$order_no."'");
        $order  = $temp[0];
        $product= $this->products->getByKey($order['product_id']);

        if ($type == "ACTIVE")
        {
            $order_template = $product['activation_mail_template'];
            $subject        = $this->conf['company_name'] . " " . $this->props->lang['activation_mail_subject'] . " ";
        }
        if ($type == "SUSPEND")
        {
            $order_template = $product['suspended_mail_template'];
            $subject        = $this->conf['company_name'] . " " . $this->props->lang['suspended_mail_subject'] . " ";
        }
        $body   = $this->utils->entity_decode($this->utils->htmlspecialchars_decode($order_template));

        if (empty ($body) || empty($order_no) || !count($order))
            return false;

        $data_array = $this->mailWelcome($order_no,true);
        $body       = $this->etp->parseEmail($data_array,$body);
        $subject    = $this->etp->parseEmail($data_array,$subject);

        $this->notice_to = $order['email'];
        $this->msg  = $body;
        $this->ALPmail->AddAddress($order['email'], $this->getCustomerFieldValue("name",$order['id']));
        $this->ALPmail->AddCC($this->conf['comp_email'], $this->conf['company_name']);
        $this->ALPmail->Subject = $subject;
        $this->ALPmail->Body    = $body;
        return $this->ALPmail->sendMail();
    }
    /*
     * Mail payment reciept
     */
    function mailPaymentReciept($invoice_no,$payment_date="",$payment_amount=0)
    {
        $data_array = array();
        $cycle      = $this->props->cycles;
        $temp       = $this->invoices->get("WHERE `invoice_no`='".$invoice_no."'");
        $invoice    = $temp[0];
        $data_array1= $this->mailWelcome($invoice['order_id'],true);
        $data_array2= $this->mailInvoice($invoice_no, true, true);
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

        $reciept_template = $this->emails->getByKey(3);
        $subject          = $this->conf['company_name'] . " " . $this->props->lang['payment_confirmation'];
        $body             = $this->utils->entity_decode($this->utils->htmlspecialchars_decode($reciept_template['email_text']));
        if(!empty($reciept_template['email_subject']))
        {
            $subject      = $this->utils->entity_decode($this->utils->htmlspecialchars_decode($reciept_template['email_subject']));
        }
        foreach($invoice as $key=>$data)
        {
            $data_array[$key] = $data;
        }
        $data_array['payment_date'] = $this->fDate($payment_date);
        $data_array['amount_paid']  = $this->toCurrency($payment_amount, null, 1);
        $data_array['due_date']     = $this->fDate($invoice['due_date']);
        $data_array['invoice_no']   = $this->conf['invoice_prefix'] . $invoice['invoice_no'] . $this->conf['invoice_suffix'];
        $data_array['company_email']= $this->conf['comp_email'];
        $data_array['company_name'] = $this->conf['company_name'];
        $data_array['company_address']= $this->conf['company_address'];
        $data_array['description']  = $this->getFriendlyDesc($invoice['desc'],$invoice['sub_id'],$invoice['domain_name']);

        $body   = $this->etp->parseEmail($data_array,$body);
        $subject= $this->etp->parseEmail($data_array,$subject);

        $this->notice_to    = $invoice['email'];
        $this->msg          = $body;
        $this->ALPmail->AddAddress($invoice['email'], $this->getCustomerFieldValue("name",$invoice['id']));
        $this->ALPmail->AddCC($this->conf['comp_email'], $this->conf['company_name']);
        $this->ALPmail->Subject = $subject;
        $this->ALPmail->Body    = $body;
        $return  = $this->ALPmail->sendMail();
        $this->runCS('A_PP',$invoice['sub_id'], $invoice['invoice_no']);
        return $return;
    }
}
?>
