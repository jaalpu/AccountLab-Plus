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

    error_reporting(0);
    $host_name =  ((isset($_SERVER["HTTP_HOST"]) && !empty($_SERVER["HTTP_HOST"]))?$_SERVER["HTTP_HOST"]:$_SERVER['SERVER_NAME']);

    $_SESSION['FTP_DOMAIN'] = preg_replace('|^www.|', '', $host_name);
    $_SESSION['FTP_USER']   = isset($_POST['FTP_USER'])?$_POST['FTP_USER']:"";
    $_SESSION['FTP_PW']     = isset($_POST['FTP_PW'])?$_POST['FTP_PW']:"";

    if (!empty($_SESSION['FTP_USER']) && !empty($_SESSION['FTP_PW']) && ftp_login(ftp_connect($_SESSION['FTP_DOMAIN']),$_SESSION['FTP_USER'],$_SESSION['FTP_PW']))
    {
        if(isset($_GET['phpinfo']))
        {
            phpinfo();
        }
        else
        {
            error_reporting(0);
            $protocol = "http://";
            if(isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"]        == "on" )$protocol = "https://";
            if(isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"]        == 1    )$protocol = "https://";
            if(isset($_SERVER["HTTPS"]) && $_SERVER["SERVER_PORT"]  == 443  )$protocol = "https://";

            define("INSTALL_DOMAIN"     , preg_replace('|^www.|', '', $host_name));
            define("INSTALL_URL"        , $protocol.$host_name . str_replace("/".array_pop(explode("/",$_SERVER['REQUEST_URI'])),"/",$_SERVER['REQUEST_URI']));
            define("INSTALL_PATH"       , realpath(dirname(__FILE__)));
            define("PATH_SEP"           , (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') ? '\\' : '/');
            define("PATH_BASE"          , realpath(dirname(__FILE__))   . PATH_SEP);
            define("PATH_SYSTEM"        , PATH_BASE     . "system"      . PATH_SEP);
            define("PATH_ELEMENTS"      , PATH_BASE     . "elements"    . PATH_SEP);

            define("MODELS"             , PATH_SYSTEM   . "models"      . PATH_SEP);
            define("CONTROLLERS"        , PATH_SYSTEM   . "controllers" . PATH_SEP);
            define("LIBRARIES"          , PATH_SYSTEM   . "libraries"   . PATH_SEP);
            define("XMLFEEDS"           , PATH_SYSTEM   . "xmlfeeds"    . PATH_SEP);
            define("CLASSES"            , PATH_SYSTEM   . "classes"     . PATH_SEP);
            define("CONFIG"             , PATH_SYSTEM   . "config"      . PATH_SEP);
            define("LOGS"               , PATH_SYSTEM   . "logs"        . PATH_SEP);

            define("CUSTOM_SYSVAR"      , PATH_ELEMENTS . "custom"  . PATH_SEP . "sysvar"   . PATH_SEP);
            define("DEFAULT_SYSVAR"     , PATH_ELEMENTS . "default" . PATH_SEP . "sysvar"   . PATH_SEP);
            define("CUSTOM_LANG"        , PATH_ELEMENTS . "custom"  . PATH_SEP . "language" . PATH_SEP);
            define("DEFAULT_LANG"       , PATH_ELEMENTS . "default" . PATH_SEP . "language" . PATH_SEP);

            define("ERROR_LOG_FILE"     , LOGS."error_log.txt");
            define("DB_FILE"            , is_file(CUSTOM_SYSVAR . "db.php")?CUSTOM_SYSVAR . "db.php":DEFAULT_SYSVAR . "db.php");

            require_once  CONFIG . "ini_tweaks.php";

            $functions= array (
                'ftp_login' => 'The function "ftp_login()" must be enabled',
                'ftp_connect' => 'The function "ftp_connect()" must be enabled',
                'ini_get' => 'The function "ini_get()" must be enabled',
                'ini_set' => 'The function "ini_set()" must be enabled',
                'fopen' => 'The function "fopen()" must be enabled',
                'phpinfo' => 'The function "phpinfo()" is required to test the system.',
                'fsockopen' => 'The function "fsockopen()" must be enabled',
                'curl_exec' => 'The function "curl_exec()" must be enabled',
            );
            $function_check_results= array ();
            $function_check_results_string= array ();
            $disabled_functions= explode(',', ini_get('disable_functions'));
            foreach ($functions as $function => $description)
            {
                if (array_search($function, $disabled_functions) !== false)
                {
                    $function_check_results[$function]= false;
                    $function_check_results_string[$function]= "DISABLED";
                }
                else
                {
                    $function_check_results[$function]= true;
                    $function_check_results_string[$function]= "ENABLED";
                }
            }

            function getModuleSetting($pModuleName, $pSetting)
            {
                $vModules= parsePHPModules();
                return $vModules[strtolower($pModuleName)][strtolower($pSetting)];
            }
            function parsePHPModules()
            {
                ob_start();
                phpinfo();
                $s= ob_get_contents();
                ob_end_clean();
                $s= strip_tags($s, '<h2><th><td>');
                $s= preg_replace('/<th[^>]*>([^<]+)<\/th>/', "<info>\\1</info>", $s);
                $s= preg_replace('/<td[^>]*>([^<]+)<\/td>/', "<info>\\1</info>", $s);
                $vTmp= preg_split('/(<h2>[^<]+<\/h2>)/', $s, -1, PREG_SPLIT_DELIM_CAPTURE);
                $vMat= array ();
                $vModules= array ();
                for ($i= 1; $i < count($vTmp); $i++)
                {
                    if (preg_match('/<h2>([^<]+)<\/h2>/', $vTmp[$i], $vMat))
                    {
                        $vName= trim($vMat[1]);
                        $vTmp2= explode("\n", $vTmp[$i +1]);
                        foreach ($vTmp2 AS $vOne)
                        {
                            $vPat= '<info>([^<]+)<\/info>';
                            $vPat3= "/$vPat\s*$vPat\s*$vPat/";
                            $vPat2= "/$vPat\s*$vPat/";
                            if (preg_match($vPat3, $vOne, $vMat))
                            { // 3cols
                                $vModules[strtolower($vName)][strtolower(trim($vMat[1]))]= array (
                                    trim($vMat[2]
                                    ), trim($vMat[3]));
                            }
                            elseif (preg_match($vPat2, $vOne, $vMat))
                            { // 2cols
                                $vModules[strtolower($vName)][strtolower(trim($vMat[1]))]= trim($vMat[2]);
                            }
                        }
                    }
                }
                return $vModules;
            }
            require_once DB_FILE;
            $mysqlerr    = "Database connected successfully";
            $link        = @mysql_connect($db_host, $db_user, $db_pass);
            $db_selected = @mysql_select_db($db_name, $link);
            if (!$link)
            {
                $mysqlerr = mysql_error();
            }
            elseif (!$db_selected)
            {
                $mysqlerr = mysql_error();
            }
            @mysql_close($link);
        ?>
        <html>
            <head>
                <title>AccountLab Plus System Test</title>
                <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
            </head>
            <body>

                <table align="center" cellpadding="2" width="80%" style="font-family: Verdana, sans-serif; font-size: 10px;">
                    <tr>
                        <td colspan='3'><h2>AccountLab Plus System Test</h2></td>
                    </tr>

                    <tr>
                        <td colspan='3'></td>
                    </tr>

                    <tr>
                        <td colspan='3'>
                            <ul>
                                <li><b>Settings status in <font color='red'>red</font>: this function is elementary for AccountLab Plus, please review the description for more information.</b></li>
                                <li><b>Settings status in <font color='orange'>orange</font>: this function is mandatory for certain modules only, please review the description for more information.</b></li>
                                <li><b>If you make changes to your php.ini file, please restart your web server, then refresh this page.</b></li>
                            </ul>
                        </td>
                    </tr>

                    <tr>
                        <td colspan='3'></td>
                    </tr>

                    <tr bgcolor="#FFCC00">
                        <td colspan='3' style="border: 1px solid #000000;">&nbsp;<b>Install Setting</b>&nbsp;</td>
                    </tr>

                    <tr bgcolor="#EEEEEE">
                        <td align="left" style="border: 1px solid #000000;">
                            &nbsp;<b>Domain</d>
                        </td>
                        <td colspan='2' style="border: 1px solid #000000;">
                            <?php echo INSTALL_DOMAIN; ?>
                        </td>
                    </tr>

                    <tr bgcolor="#EEEEEE">
                        <td align="left" style="border: 1px solid #000000;">
                            &nbsp;<b>URL</d>
                        </td>
                        <td colspan='2' style="border: 1px solid #000000;">
                            <?php echo INSTALL_URL; ?>
                        </td>
                    </tr>

                    <tr bgcolor="#EEEEEE">
                        <td align="left" style="border: 1px solid #000000;">
                            &nbsp;<b>PATH</d>
                        </td>
                        <td colspan='2' style="border: 1px solid #000000;">
                            <?php echo INSTALL_PATH; ?>
                        </td>
                    </tr>

                    <tr bgcolor="#EEEEEE">
                        <td align="left" style="border: 1px solid #000000;">
                            &nbsp;<b>Database Setup</b>
                        </td>
                        <td colspan='2' style="border: 1px solid #000000;">
                            <font color=<?php echo ($link && $db_selected)?"green":"red";  ?>><b><?php echo $mysqlerr; ?></b></font>
                        </td>
                    </tr>

                    <tr>
                        <td colspan='3'></td>
                    </tr>

                    <tr bgcolor="#FFCC00">
                        <td style="border: 1px solid #000000;" width="20%">&nbsp;<b>General Setting</b>&nbsp;</td>
                        <td align="center" style="border: 1px solid #000000;" width="5%">&nbsp;<b>Status</b>&nbsp;</td>
                        <td style="border: 1px solid #000000;">&nbsp;<b>Description</b>&nbsp;</td>
                    </tr>

                    <tr bgcolor="#EEEEEE">
                        <td align="left" style="border: 1px solid #000000;">
                            &nbsp;PHP Version
                        </td>
                        <td align="center" style="border: 1px solid #000000;">
                            <font color=<?php echo (version_compare(phpversion(), "4.3.0", ">="))?"green":"red";  ?>><b><?php echo phpversion(); ?></b></font>
                        </td>
                        <td style="border: 1px solid #000000;">
                            Minimum PHP Version is 4.3.0
                        </td>
                    </tr>

                    <tr bgcolor="#EEEEEE">
                        <td align="left" style="border: 1px solid #000000;">
                            &nbsp;allow_url_fopen
                        </td>
                        <td align="center" style="border: 1px solid #000000;">
                            <?php $status = getModuleSetting("PHP Core", "allow_url_fopen"); ?>
                            <font color=<?php echo (strtolower($status[0])=="on")?"green":"red";  ?>><b><?php echo $status[0]; ?></b></font>
                        </td>
                        <td style="border: 1px solid #000000;">
                            "allow_url_fopen" must be set to On
                        </td>
                    </tr>

                    <tr bgcolor="#EEEEEE">
                        <td align="left" style="border: 1px solid #000000;">
                            &nbsp;allow_call_time_pass_reference
                        </td>
                        <td align="center" style="border: 1px solid #000000;">
                            <?php $status = getModuleSetting("PHP Core", "allow_call_time_pass_reference"); ?>
                            <font color=<?php echo (strtolower($status[0])=="on")?"green":"red";  ?>><b><?php echo $status[0]; ?></b></font>
                        </td>
                        <td style="border: 1px solid #000000;">
                            "allow_call_time_pass_reference" must be set to On
                        </td>
                    </tr>


                    <tr bgcolor="#EEEEEE">
                        <td align="left" style="border: 1px solid #000000;">
                            &nbsp;max_execution_time
                        </td>
                        <td align="center" style="border: 1px solid #000000;">
                            <?php $status = getModuleSetting("PHP Core", "max_execution_time"); ?>
                            <font color=<?php echo ($status[0]>= 60)?"green":"orange";  ?>><b><?php echo $status[0]; ?></b></font>
                        </td>
                        <td style="border: 1px solid #000000;">
                            "max_execution_time" must be minimum 60
                        </td>
                    </tr>

                    <tr bgcolor="#EEEEEE">
                        <td align="left" style="border: 1px solid #000000;">
                            &nbsp;memory_limit
                        </td>
                        <td align="center" style="border: 1px solid #000000;">
                            <?php $status = getModuleSetting("PHP Core", "memory_limit"); ?>
                            <font color=<?php echo (str_replace("M","",$status[0])>= 12)?"green":"orange";  ?>><b><?php echo $status[0]; ?></b></font>
                        </td>
                        <td style="border: 1px solid #000000;">
                            "memory_limit" should be minimum 12M, In case of ioncube versions and any out of memory errors, you have to increase the limit to higher values.
                        </td>
                    </tr>

                    <?php if(version_compare(phpversion(), "5.0.0", ">=")){ ?>
                        <tr bgcolor="#EEEEEE">
                            <td align="left" style="border: 1px solid #000000;">
                                &nbsp;Zend Engine 1
                            </td>
                            <td align="center" style="border: 1px solid #000000;">
                                <?php $status = getModuleSetting("PHP Core", "zend.ze1_compatibility_mode"); ?>
                                <font color=<?php echo (strtolower($status[0])== "on")?"green":"red";  ?>><b><?php echo $status[0]; ?></b></font>
                            </td>
                            <td style="border: 1px solid #000000;">
                                "zend.ze1_compatibility_mode" must be set to On.
                            </td>
                        </tr>
                        <?php } ?>

                    <tr bgcolor="#EEEEEE">
                        <td align="left" style="border: 1px solid #000000;">
                            &nbsp;open_basedir
                        </td>
                        <td align="center" style="border: 1px solid #000000;">
                            <?php $status = getModuleSetting("PHP Core", "open_basedir"); ?>
                            <font color=<?php echo ($status[0]== "no value")?"green":"orange";  ?>><b><?php echo $status[0]; ?></b></font>
                        </td>
                        <td style="border: 1px solid #000000;">
                            When "open_basedir" is set, it may affect the ioncube version of ALP and may create unresolvable problems.
                        </td>
                    </tr>

                    <tr bgcolor="#EEEEEE">
                        <td align="left" style="border: 1px solid #000000;">
                            &nbsp;MySQL Support
                        </td>
                        <td align="center" style="border: 1px solid #000000;">
                            <?php $status = getModuleSetting("mysql", "MySQL Support"); ?>
                            <font color=<?php echo (strtolower($status)== "enabled")?"green":"red";  ?>><b><?php echo $status; ?></b></font>
                        </td>
                        <td style="border: 1px solid #000000;">
                            "MySQL Support" must be enabled.
                        </td>
                    </tr>

                    <tr bgcolor="#EEEEEE">
                        <td align="left" style="border: 1px solid #000000;">
                            &nbsp;Sockets Support
                        </td>
                        <td align="center" style="border: 1px solid #000000;">
                            <?php $status = getModuleSetting("sockets", "Sockets Support"); ?>
                            <font color=<?php echo (strtolower($status)== "enabled")?"green":"red";  ?>><b><?php echo $status; ?></b></font>
                        </td>
                        <td style="border: 1px solid #000000;">
                            "Sockets Support" must be enabled.
                        </td>
                    </tr>

                    <tr bgcolor="#EEEEEE">
                        <td align="left" style="border: 1px solid #000000;">
                            &nbsp;XML Support
                        </td>
                        <td align="center" style="border: 1px solid #000000;">
                            <?php $status = getModuleSetting("xml", "XML Support"); ?>
                            <font color=<?php echo (strtolower($status)== "active")?"green":"red";  ?>><b><?php echo $status; ?></b></font>
                        </td>
                        <td style="border: 1px solid #000000;">
                            "XML Support" must be enabled.
                        </td>
                    </tr>

                    <tr bgcolor="#EEEEEE">
                        <td align="left" style="border: 1px solid #000000;">
                            &nbsp;ZLib Support
                        </td>
                        <td align="center" style="border: 1px solid #000000;">
                            <?php $status = getModuleSetting("zlib", "ZLib Support"); ?>
                            <font color=<?php echo (strtolower($status)== "enabled")?"green":"red";  ?>><b><?php echo $status; ?></b></font>
                        </td>
                        <td style="border: 1px solid #000000;">
                            "ZLib Support" must be enabled.
                        </td>
                    </tr>

                    <tr bgcolor="#EEEEEE">
                        <td align="left" style="border: 1px solid #000000;">
                            &nbsp;Calendar support
                        </td>
                        <td align="center" style="border: 1px solid #000000;">
                            <?php $status = getModuleSetting("calendar", "Calendar support"); ?>
                            <font color=<?php echo (strtolower($status)== "enabled")?"green":"red";  ?>><b><?php echo $status; ?></b></font>
                        </td>
                        <td style="border: 1px solid #000000;">
                            "Calendar support" must be enabled.
                        </td>
                    </tr>

                    <tr bgcolor="#EEEEEE">
                        <td align="left" style="border: 1px solid #000000;">
                            &nbsp;cURL support
                        </td>
                        <td align="center" style="border: 1px solid #000000;">
                            <?php $status = getModuleSetting("cURL", "cURL support"); ?>
                            <font color=<?php echo (strtolower($status)== "enabled")?"green":"red";  ?>><b><?php echo $status; ?></b></font>
                        </td>
                        <td style="border: 1px solid #000000;">
                            "cURL support" must be enabled.
                        </td>
                    </tr>

                    <tr bgcolor="#EEEEEE">
                        <td align="left" style="border: 1px solid #000000;">
                            &nbsp;cURL with OpenSSL and Zlib
                        </td>
                        <td align="center" style="border: 1px solid #000000;">
                            <?php $status = getModuleSetting("cURL", "cURL Information"); ?>
                            <font color=<?php echo (preg_match("/openssl/", strtolower($status)) && preg_match("/zlib/", strtolower($status)))?"green":"red";  ?>><b><?php echo $status; ?></b></font>
                        </td>
                        <td style="border: 1px solid #000000;">
                            "cURL" must be installed with OpenSSL and Zlib.
                        </td>
                    </tr>

                    <tr bgcolor="#EEEEEE">
                        <td align="left" style="border: 1px solid #000000;">
                            &nbsp;iconv support
                        </td>
                        <td align="center" style="border: 1px solid #000000;">
                            <?php $status = getModuleSetting("iconv", "iconv support"); ?>
                            <font color=<?php echo (strtolower($status)== "enabled")?"green":"orange";  ?>><b><?php echo $status; ?></b></font>
                        </td>
                        <td style="border: 1px solid #000000;">
                            "iconv support" is required for non english languages.
                        </td>
                    </tr>

                    <tr bgcolor="#EEEEEE">
                        <td align="left" style="border: 1px solid #000000;">
                            &nbsp;mbstring
                        </td>
                        <td align="center" style="border: 1px solid #000000;">
                            <?php $status = getModuleSetting("mbstring", "Multibyte Support"); ?>
                            <font color=<?php echo (strtolower($status)== "enabled")?"green":"orange";  ?>><b><?php echo $status; ?></b></font>
                        </td>
                        <td style="border: 1px solid #000000;">
                            "mbstring" is required for non english languages.
                        </td>
                    </tr>


                    <tr bgcolor="#EEEEEE">
                        <td align="left" style="border: 1px solid #000000;">
                            &nbsp;IMAP Support
                        </td>
                        <td align="center" style="border: 1px solid #000000;">
                            <?php $status = getModuleSetting("imap", "IMAP c-Client Version"); ?>
                            <font color=<?php echo (strtolower($status)!= "")?"green":"orange";  ?>><b><?php echo $status; ?></b></font>
                        </td>
                        <td style="border: 1px solid #000000;">
                            "IMAP Support" is required for the email to support ticket feature.
                        </td>
                    </tr>


                    <tr bgcolor="#EEEEEE">
                        <td align="left" style="border: 1px solid #000000;">
                            &nbsp;IMAP-SSL
                        </td>
                        <td align="center" style="border: 1px solid #000000;">
                            <?php $status = getModuleSetting("imap", "SSL Support"); ?>
                            <font color=<?php echo (strtolower($status)== "enabled")?"green":"orange";  ?>><b><?php echo $status; ?></b></font>
                        </td>
                        <td style="border: 1px solid #000000;">
                            IMAP must be compiled with "SSL Support" for the email to support ticket feature.
                        </td>
                    </tr>


                    <tr bgcolor="#EEEEEE">
                        <td align="left" style="border: 1px solid #000000;">
                            &nbsp;IMAP-Kerberos
                        </td>
                        <td align="center" style="border: 1px solid #000000;">
                            <?php $status = getModuleSetting("imap", "Kerberos Support"); ?>
                            <font color=<?php echo (strtolower($status)== "enabled")?"green":"orange";  ?>><b><?php echo $status; ?></b></font>
                        </td>
                        <td style="border: 1px solid #000000;">
                            IMAP must be compiled with "Kerberos Support" for the email to support ticket feature.
                        </td>
                    </tr>

                    <tr bgcolor="#EEEEEE">
                        <td align="left" style="border: 1px solid #000000;">
                            &nbsp;GD Support
                        </td>
                        <td align="center" style="border: 1px solid #000000;">
                            <?php $status = getModuleSetting("gd", "GD Support"); ?>
                            <font color=<?php echo (strtolower($status)== "enabled")?"green":"orange";  ?>><b><?php echo $status; ?></b></font>
                        </td>
                        <td style="border: 1px solid #000000;">
                            "GD Support" is required to generate report charts.
                        </td>
                    </tr>

                    <tr bgcolor="#EEEEEE">
                        <td align="left" style="border: 1px solid #000000;">
                            &nbsp;FreeType Support
                        </td>
                        <td align="center" style="border: 1px solid #000000;">
                            <?php $status = getModuleSetting("gd", "FreeType Support"); ?>
                            <font color=<?php echo (strtolower($status)== "enabled")?"green":"orange";  ?>><b><?php echo $status; ?></b></font>
                        </td>
                        <td style="border: 1px solid #000000;">
                            "FreeType Support" is required to generate report charts.
                        </td>
                    </tr>

                    <tr bgcolor="#EEEEEE">
                        <td align="left" style="border: 1px solid #000000;">
                            &nbsp;OpenSSL support
                        </td>
                        <td align="center" style="border: 1px solid #000000;">
                            <?php $status = getModuleSetting("openssl", "OpenSSL support"); ?>
                            <font color=<?php echo (strtolower($status)== "enabled")?"green":"orange";  ?>><b><?php echo $status; ?></b></font>
                        </td>
                        <td style="border: 1px solid #000000;">
                            "OpenSSL support" is required for OpenSRS registrar.
                        </td>
                    </tr>

                    <tr bgcolor="#EEEEEE">
                        <td align="left" style="border: 1px solid #000000;">
                            &nbsp;MHASH support
                        </td>
                        <td align="center" style="border: 1px solid #000000;">
                            <?php $status = getModuleSetting("mhash", "MHASH support"); ?>
                            <font color=<?php echo (strtolower($status)== "enabled")?"green":"orange";  ?>><b><?php echo $status; ?></b></font>
                        </td>
                        <td style="border: 1px solid #000000;">
                            "MHASH support" is required for Authorize.net payment method.
                        </td>
                    </tr>

                    <tr>
                        <td colspan='3'></td>
                    </tr>

                    <tr bgcolor="#FFCC00">
                        <td style="border: 1px solid #000000;" width="20%">&nbsp;<b>PHP Functions</b>&nbsp;</td>
                        <td align="center" style="border: 1px solid #000000;" width="5%">&nbsp;<b>Status</b>&nbsp;</td>
                        <td style="border: 1px solid #000000;">&nbsp;<b>Description</b>&nbsp;</td>
                    </tr>

                    <?php foreach($functions as $function=>$string){ ?>
                        <tr bgcolor="#EEEEEE">
                            <td align="left" style="border: 1px solid #000000;">
                                &nbsp;<?php echo $function; ?>
                            </td>
                            <td align="center" style="border: 1px solid #000000;">
                                <font color=<?php echo ($function_check_results[$function])?"green":"red";  ?>><b><?php echo $function_check_results_string[$function];  ?></b></font>
                            </td>
                            <td style="border: 1px solid #000000;">
                                <?php echo $string; ?>
                            </td>
                        </tr>
                        <?php } ?>

                </table>
            </body>
        </html>
        <?php
        }
    }
    else
    {
    ?>
    <html>
        <head>
            <title>AccountLab Plus System Test</title>
            <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
        </head>
        <body>

            <table align="center" cellpadding="2" width="80%" style="font-family: Verdana, sans-serif; font-size: 10px;">
                <tr>
                    <td align="center"><h2>AccountLab Plus System Test</h2></td>
                </tr>

                <tr>
                    <td align="center"><h2><font color="red">Please login using the FTP username and password.</font></h2></td>
                </tr>

                <tr>
                    <td align="center">
                        <form action="" method="post">
                            <table align="center" cellpadding="2" width="40%" style="font-family: Verdana, sans-serif; font-size: 10px; border: 1px solid #000000;">
                                <tr>
                                    <td align="left">FTP username</td>
                                    <td align="left"><input type="text" name="FTP_USER" value="" size="30" /></td>
                                </tr>
                                <tr>
                                    <td align="left">FTP password</td>
                                    <td align="left"><input type="password" name="FTP_PW" value="" size="30" /></td>
                                </tr>
                                <tr>
                                    <td align="left"></td>
                                    <td align="left"><input type="submit" name="Submit" value="Submit" /></td>
                                </tr>
                            </table>
                        </form>
                    </td>
                </tr>
            </table>
        </body>
    </html>
    <?php
    }
?>
