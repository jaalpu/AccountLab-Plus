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

    session_start();

    //install pear
    set_include_path(realpath('system'. DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR . 'pear') . PATH_SEPARATOR . get_include_path());
    //install paypal sdk
    set_include_path(realpath('system'. DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR . 'paypalsdk' . DIRECTORY_SEPARATOR . 'php-sdk' . DIRECTORY_SEPARATOR . 'lib') . PATH_SEPARATOR . get_include_path());

    $protocol = "http://";
    if(isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"]        == "on" )$protocol = "https://";
    if(isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"]        == 1    )$protocol = "https://";
    if(isset($_SERVER["HTTPS"]) && $_SERVER["SERVER_PORT"]  == 443  )$protocol = "https://";

    $host_name =  ((isset($_SERVER["HTTP_HOST"]) && !empty($_SERVER["HTTP_HOST"]))?$_SERVER["HTTP_HOST"]:$_SERVER['SERVER_NAME']);

    define("INSTALL_DOMAIN"     , preg_replace('|^www.|', '', $host_name));
    define("INSTALL_URL"        , $protocol.$host_name.dirname($_SERVER['PHP_SELF']).'/');
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

    require_once is_file(CUSTOM_SYSVAR  . "copyright.php")
    ?CUSTOM_SYSVAR        . "copyright.php"
    :DEFAULT_SYSVAR       . "copyright.php";

    require_once  CONFIG                . "version.php";
    require_once  CONFIG                . "bootstrap.php";
    require_once  CONFIG                . "ini_tweaks.php";

    require_once  LIBRARIES             . "phpmailer".PATH_SEP."class.phpmailer.php";
    require_once  LIBRARIES             . "date_calc".PATH_SEP."Calc.php";
    require_once  LIBRARIES             . "pear".PATH_SEP."PEAR.php";
    require_once  LIBRARIES             . "pear".PATH_SEP."PEAR".PATH_SEP."ErrorStack.php";
    require_once  LIBRARIES             . "net_url".PATH_SEP."URL.php";
    require_once  LIBRARIES             . "imapv2".PATH_SEP."IMAPv2.php";
    require_once  LIBRARIES             . "imapv2".PATH_SEP."IMAPv2".PATH_SEP."ManageMB".PATH_SEP."ManageMB.php";

    require_once  CLASSES               . "errorHandler.class.php";
    require_once  CLASSES               . "properties.class.php";
    require_once  CLASSES               . "utils.class.php";
    require_once  CLASSES               . "db.class.php";
    require_once  CLASSES               . "controller.class.php";
    require_once  CLASSES               . "model.class.php";
    require_once  CLASSES               . "alpencrypt.class.php";
    require_once  CLASSES               . "alpmail.class.php";
    require_once  CLASSES               . "BJCBarChart.class.php";
    require_once  CLASSES               . "cpanelHandler.class.php";
    require_once  CLASSES               . "pleskHandler.class.php";
    require_once  CLASSES               . "daHandler.class.php";
    require_once  CLASSES               . "lxadminHandler.class.php";
    require_once  CLASSES               . "directiHandler.class.php";
    require_once  CLASSES               . "clientexecHandler.class.php";
    require_once  CLASSES               . "alpcurl.class.php";

    require_once  CONTROLLERS           . "authorize.php";
    require_once  CONTROLLERS           . "installer.php";
    require_once  CONTROLLERS           . "whois.php";
    require_once  CONTROLLERS           . "emailTemplateParser.php";
    require_once  CONTROLLERS           . "report.php";

    require_once  PATH_SYSTEM           . "busLogic.php";

    define("ALP_DEBUG"      , $debug_mode);
    define("ALP_VERSION"    , $ALPversion);
    define("ALP_BUILD"      , $ALPBuild);
    define("ALP_COPYRIGHT"  , $copyright);

    $REQUEST        = array_merge($_GET, $_POST);
    $PHP_SELF       = isset($PHP_SELF)?$PHP_SELF:$_SERVER['PHP_SELF'];
    $cmd            = isset($REQUEST['cmd'])?$REQUEST['cmd']:"";
    $errorHandler   = new errorHandler();
    $BL             = new busLogic($errorHandler, $REQUEST);
    $conf           = $BL->conf;

    define("ADMINCSS" ,(isset($_SESSION['admin_theme']) && !empty($_SESSION['admin_theme']))?$_SESSION['admin_theme']:"default_horizontal_menu");
    define("LANGUAGE" ,(isset($_SESSION['language']) && !empty($_SESSION['language']))?$_SESSION['language']:"english");
    define("THEMEDIR" ,(isset($_SESSION['theme_dir']) && !empty($_SESSION['theme_dir']))?$_SESSION['theme_dir']:"default");
    define("CHARSET"  ,isset($BL->props->lang['charset'])?$BL->props->lang['charset']:"iso-8859-1");
    define("PAGEDIR"  ,isset($BL->props->lang['direction'])?$BL->props->lang['direction']:"LTR");
?>
