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
    * A class to do load all properties
    * properties Version 2.0
    */
    class properties
    {
        /*
        * Constractor
        */
        function properties()
        {
            $this->loadVars();
        }
        function parseLang($key)
        {
            return isset($this->lang[$key])?$this->lang[$key]:$key;
        }
        function getElement($path,$relative = 0)
        {
            if($relative)
            {
                return is_readable(PATH_ELEMENTS . "custom" . PATH_SEP . $path)?INSTALL_URL . "/elements/custom" . $path:INSTALL_URL . "/elements/default" . $path;
            }
            return is_readable(PATH_ELEMENTS . "custom" . PATH_SEP . $path)?PATH_ELEMENTS . "custom" . PATH_SEP . $path:PATH_ELEMENTS . "default" . PATH_SEP . $path;
        }
        /*
        * include files and load the arrays, variables etc.
        */
        function loadVars()
        {
            //Load system variables
            require_once DB_FILE;
            require_once CONFIG . "cmds.php";
            require_once CONFIG . "whoisservers.php";
            require_once CONFIG . "tables.php";
            require_once CONFIG . "sqls.php";
            require_once CONFIG . "predefined_arrays.php";
            require_once is_readable(CUSTOM_SYSVAR . "modes.php")   ?CUSTOM_SYSVAR     . "modes.php"    :DEFAULT_SYSVAR . "modes.php";
            require_once is_readable(CUSTOM_SYSVAR . "links.php")   ?CUSTOM_SYSVAR     . "links.php"    :DEFAULT_SYSVAR . "links.php";
            require_once is_readable(CUSTOM_SYSVAR . "country.php") ?CUSTOM_SYSVAR     . "country.php"  :DEFAULT_SYSVAR . "country.php";

            $this->cs_array                     = array();
            $this->encryptionKey                = '%7E]okIO?Bf@6igP>#zU[294pMa,N5dFvW+Yn=m|r:l^w_.Jx)Hq1{3D< SjA&Cyb*ZeTc`hVQ!s8R}$~(;Lt-GK/u0X%';
            $this->c                            = defined("ALP_COPYRIGHT")?ALP_COPYRIGHT:"Copyright &copy; netenberg.com";
            $this->ALPversion                   = defined("ALP_VERSION")?ALP_VERSION:"N/A";
            $this->alp_demo_mode                = $alp_demo_mode;
            $this->payment_method_demo_mode     = $payment_method_demo_mode;
            $this->country                      = $country;
            $this->allstates                    = $allstates;
            $this->phone_codes                  = $phone_codes;
            $this->db_host                      = $db_host;
            $this->db_user                      = $db_user;
            $this->db_pass                      = $db_pass;
            $this->db_name                      = $db_name;
            $this->upgrade_sql_array1           = $upgrade_sql_array1;
            $this->upgrade_sql_array2           = $upgrade_sql_array2;
            $this->install_sql_array1           = $install_sql_array1;
            $this->install_sql_array2           = $install_sql_array2;
            $this->Queries                      = $Queries;
            foreach ($tables as $key => $val)
            {
                $this->{$key} = $val;
            }
            $this->invoice_status               = $invoice_status;
            $this->order_status                 = $order_status;
            $this->ticket_status                = $ticket_status;
            $this->cycles                       = array();
            $this->admin_cmds                   = $admin_cmds;
            $this->ext_links                    = $ext_links;
            $this->tld_array                    = $tld_array;

            ksort($this->cycles);
            ksort($this->tld_array);
        }
        /*
        * load language array
        */
        function getLang($ll)
        {
            $lang = array ();
            require_once is_readable(CUSTOM_LANG . "english.php") ?CUSTOM_LANG . "english.php" :DEFAULT_LANG . "english.php";
            $this->lang = $lang;
            if($ll!="english")
            {
                $lang = array ();
                require_once is_readable(CUSTOM_LANG . $ll.".php") ?CUSTOM_LANG . $ll.".php" :DEFAULT_LANG . $ll.".php";
                foreach ($lang as $k => $v)
                {
                    $this->lang[$k]= ucfirst($v);
                }
            }
        }
        /*
        * Function to get file name
        * It will check if the file/dir exists in custom dir...or not
        * And return the full path of the file/dir that exists
        */
        function get_page($page, $mode= "file", $absolute= 0, $gui_component= false)
        {
            $theme_dir    = defined("THEMEDIR")?THEMEDIR:"default";
            $e_dir        = ($absolute)?PATH_ELEMENTS:"elements".PATH_SEP;

            if ($mode == "file")
            {
                if (is_file($e_dir . "custom".PATH_SEP . $page))
                {
                    return $e_dir  . "custom".PATH_SEP . $page;
                }
                if (is_file($e_dir . "custom".PATH_SEP . str_replace($theme_dir, "custom", $page)))
                {
                    return $e_dir  . "custom".PATH_SEP . str_replace($theme_dir, "custom", $page);
                }
                if (is_file($e_dir . "default".PATH_SEP . $page))
                {
                    return $e_dir  . "default".PATH_SEP . $page;
                }
                if(is_file($e_dir  . "default".PATH_SEP . str_replace($theme_dir, "default", $page)))
                {
                    return $e_dir  . "default".PATH_SEP . str_replace($theme_dir, "default", $page);
                }
                if(empty($absolute) && is_file($this->get_page($page,"file",1)))
                {
                    return defined('CALL_PATH')?str_replace(CALL_PATH.PATH_SEP,'',$this->get_page($page,"file",1)):$this->get_page($page,"file",1);
                }
                return $e_dir . "default".PATH_SEP . str_replace($theme_dir, "default", $page);
            }

            if (is_dir($e_dir . "custom".PATH_SEP  . $page))
            {
                return $e_dir . "custom".PATH_SEP  . $page;
            }
            return $e_dir     . "default".PATH_SEP . $page;
        }
        /*
        * Get custom scripts in folder
        */
        function getCS($path, & $utils)
        {
            $cs = $utils->dirlist($path,"name","php");
            foreach($cs as $k=>$v)
            {
                $str = $path . PATH_SEP . trim($v);
                if(is_dir($str) && $v!='payment' && $v!='controlpanels' && $v!='registrars')
                {
                    $this->getCS($str, $utils);
                }
                elseif(is_readable($str.".php"))
                {
                    $this->cs_array[] = $str.".php";
                }
            }
        }
        /*
        * construct arrays of available themes, language, plugins etc.
        */
        function constructArrays(& $utils)
        {
            $th1                  = $utils->dirlist(PATH_ELEMENTS."default" .PATH_SEP. "templates"                                            , "name");
            $th2                  = $utils->dirlist(PATH_ELEMENTS."custom"  .PATH_SEP. "templates"                                            , "name");
            $ath1                 = $utils->dirlist(PATH_ELEMENTS."default" .PATH_SEP. "templates" .PATH_SEP. "alp_admin" .PATH_SEP. "css"    , "name", "css");
            $ath2                 = $utils->dirlist(PATH_ELEMENTS."custom"  .PATH_SEP. "templates" .PATH_SEP. "alp_admin" .PATH_SEP. "css"    , "name", "css");
            $cp1                  = $utils->dirlist(PATH_ELEMENTS."default" .PATH_SEP. "plugins"   .PATH_SEP. "controlpanels"                 , "name", "php");
            $cp2                  = $utils->dirlist(PATH_ELEMENTS."custom"  .PATH_SEP. "plugins"   .PATH_SEP. "controlpanels"                 , "name", "php");
            $pg1                  = $utils->dirlist(PATH_ELEMENTS."default" .PATH_SEP. "plugins"   .PATH_SEP. "payment"                       , "name", "php");
            $pg2                  = $utils->dirlist(PATH_ELEMENTS."custom"  .PATH_SEP. "plugins"   .PATH_SEP. "payment"                       , "name", "php");
            $dr1                  = $utils->dirlist(PATH_ELEMENTS."default" .PATH_SEP. "plugins"   .PATH_SEP. "registrars"                    , "name", "php");
            $dr2                  = $utils->dirlist(PATH_ELEMENTS."custom"  .PATH_SEP. "plugins"   .PATH_SEP. "registrars"                    , "name", "php");
            $lang_array1          = $utils->dirlist(PATH_ELEMENTS."default" .PATH_SEP. "language"                                             , "name", "php");
            $lang_array2          = $utils->dirlist(PATH_ELEMENTS."custom"  .PATH_SEP. "language"                                             , "name", "php");

            $dr3                  = array_unique(array_merge($dr1             , $dr2));

            foreach($dr3 as $registrar){
                if($registrar!="registerfly"){//BLANK PAGE FIX
                    $this->dr[]=$registrar;
                }
            }


            $this->pg             = array_unique(array_merge($pg1             , $pg2));
            $this->cp             = array_unique(array_merge($cp1             , $cp2));
            $this->lang_array     = array_unique(array_merge($lang_array1     , $lang_array2));
            $theme_list1          = array_unique(array_merge($th1             , $th2));
            $theme_list2          = array_unique(array_unique($theme_list1));
            $admin_theme_list1    = array_unique(array_merge($ath1            , $ath2));
            $admin_theme_list2    = array_unique(array_unique($admin_theme_list1));
            foreach ($theme_list2 as $k => $v)
            {
                if ($v != "alp_admin")
                {
                    $this->theme_list[$k]= $v;
                }
            }
            $this->admin_theme_list= array_unique($admin_theme_list2);
            sort($this->admin_theme_list);
            sort($this->pg);
            sort($this->dr);
            sort($this->cp);
            sort($this->lang_array);
            sort($this->theme_list);
            //re sort payment methods start
            $pg = array ();
            for ($i= 0; $i < count($this->pg); $i++)
            {
                if ($this->pg[$i] != "twocheckout")
                {
                    $pg[$i +1]= $this->pg[$i];
                }
                elseif ($this->pg[$i] == "twocheckout")
                {
                    $pg[0]= $this->pg[$i];
                }
            }
            $this->pg = $pg;
            ksort($this->pg);
            //re sort payment methods end
            $this->getCS(PATH_ELEMENTS  ."default" .PATH_SEP. "plugins",$utils);
            $this->getCS(PATH_ELEMENTS  ."custom"  .PATH_SEP. "plugins",$utils);
            $this->cs_array = $utils->Get_Uniques_Array($utils->Get_Trimmed_Array($this->cs_array));
            sort($this->cs_array);
        }
    }
?>
