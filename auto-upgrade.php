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

    require_once realpath(dirname(__FILE__)) . "/" . "init.php";
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
    {
        echo "This feature is not supported in Windows ";
        exit;
    }
    for ($i= 1; $i < $argc; $i++)
    {
        parse_str($argv[$i]);
    }
    $arguments  = compact('force');
    $force  = (isset ($arguments['force']) && trim($arguments['force']) == 'uncheck') ? 1 : 0;
    $uname  = `uname`;
    $FREEBSD= preg_match("/freebsd/i", $uname);
    $BASE   = realpath(dirname(__FILE__)) . "/";
    $PARENT = realpath(dirname(__FILE__) . "/../") . "/";
    require_once dirname(__FILE__) . "/system/config/version.php";
    $current_version    = $ALPversion;
    $latest_version     = getLatestVersionNo("http://files.betaservant.com/files/accountlab_plus/free/version.txt");
    $current_version_array  = splitVersionNo($current_version);
    $latest_version_array   = splitVersionNo($latest_version);
    $file_name  = "accountlab_plus.tar.bz2";
    $tgz_file   = "http://softlayer.dl.sourceforge.net/project/accountlabplus/" . $file_name;
    $cmds           = array ();
    $cmds['mkdir']  = "";
    $cmds['tar']    = "";
    $cmds['cp']     = "";
    $cmds['rm']     = "";
    $cmds['mysqldump']= "";
    if (!$force)
    {
        if (!checkCmds($cmds))
            exit;
    }
    if ($current_version != $latest_version && ($latest_version_array[0] > $current_version_array[0] || ($latest_version_array[0] == $current_version_array[0] && $latest_version_array[1] > $current_version_array[1])))
    {
        echo "Starting AccountLab plus automatic upgrade utility \n\r";
        echo "====================================================\n\r";
        echo "Current installation is version : " . $current_version . "\n\rLastest version is : " . $latest_version . "\n\r";
        echo "Downloading latest accountlab plus files ...\n\r";
        $download_complete= download($tgz_file, $PARENT . $file_name);
        if (!is_readable($PARENT . $file_name))
        {
            echo "Error: The downloaded file is not readable!\n\r";
            exit;
        }
        if ($download_complete)
        {
            echo "File saved as: ";
            echo $PARENT . $file_name . "\n\r";
            require_once $BASE . "elements/default/sysvar/db.php";
            $commands1[]= "echo \"Extracting new AccountLab Plus files ... \"";
            $commands1[]= "mkdir -p " . $PARENT . "alpnew_temporary/";
            $commands1[]= "tar -xzpf " . $PARENT . $file_name . " -C " . $PARENT . "alpnew_temporary/";
            $commands1[]= "echo \"Creating backup archive of existing installation ...\"";
            $commands1[]= "echo \"Dumping mysql database...\"";
            $commands1[]= "mysqldump -Q --add-drop-table -c -u " . $db_user . " -p" . $db_pass . " -h " . $db_host . " " . $db_name . " > " . $db_name . time() . ".sql";
            $commands1[]= "echo \"Creating backup...\"";
            $commands1[]= "mkdir -p " . $PARENT . "alpbkp_temporary/";
            $commands1[]= (($FREEBSD) ? "cp -rfp " : "cp -rfpd ") . $BASE . "* " . $PARENT . "alpbkp_temporary/";
            $commands1[]= "tar -czpf " . $PARENT . "accountlab_plus_" . str_replace(" ", "_", $current_version) . "_" . time() . "_bkp.tgz " . $PARENT . "alpbkp_temporary/";
            $commands2[]= "echo \"Restoring db.php ...\"";
            $commands2[]= "cp " . $PARENT . "alpbkp_temporary/elements/default/sysvar/db.php " . $BASE . "elements/default/sysvar/";
            $commands2[]= "chmod 644 " . $BASE . "elements/default/sysvar/db.php";
            $commands1[]= "echo \"Coping new AccountLab Plus files to install directory ...\"";
            $commands1[]= (($FREEBSD) ? "cp -rfp " : "cp -rfpd ") . $PARENT . "alpnew_temporary/accountlab_plus/* " . $BASE;
            $commands3[]= "echo \"Removing temporary files ...\"";
            $commands3[]= "rm -rf " . $PARENT . "alpbkp_temporary/";
            $commands3[]= "rm -rf " . $PARENT . "alpnew_temporary/";
            $commands3[]= "rm " . $PARENT . $file_name;
            $commands3[]= "rm " . $BASE . "/install.php";
            echo "Running unix commands...\n\r";
            echo "====================================================\n\r";
            foreach ($commands1 as $c1)
            {
                echo `$c1`;
            }
            foreach ($commands2 as $c2)
            {
                echo `$c2`;
            }
            echo "====================================================\n\r";
            echo "New files for AccountLab Plus " . $latest_version . " has been copied.\n\r\n\r";
            foreach ($commands3 as $c3)
            {
                echo `$c3`;
            }
            echo "Initiating Upgrade process...\n\r";
            error_reporting(0);
            require_once realpath(dirname(__FILE__)) . "/" . "init.php";
            $just_upgraded = $BL->installer->checkandupgrade();
            echo "\n\r#################################################################################\n\r";
            if($just_upgraded=="OK")
            {
                echo "Database Upgrade Complete.";
            }
            elseif($just_upgraded=="NO_CONNECT")
            {
                echo "Please access your AccountLab Plus admin backend from a browser, to complete the upgrade process.";
            }
            else
            {
                echo "Database Upgrade Failed.";
            }
            echo "\n\r#################################################################################\n\r";
            exit;
        }
    }
    function splitVersionNo($version_no)
    {
        if (preg_match("/r/", $version_no))
        {
            $temp= explode("r", $version_no, 2);
            $version[0]= trim($temp[0]);
            $version[1]= trim($temp[1]);
        }
        else
        {
            $version[0]= trim($version_no);
            $version[1]= 0;
        }
        return $version;
    }
    function checkCmds($commands)
    {
        $return= true;
        $msg= "\n\rFollowing shell commands are not installed, or may not have permissions to execute.\n\r";
        foreach ($commands as $k => $v)
        {
            $command_file= "";
            $t= "whereis " . $k;
            $str= `$t`;
            $str= trim($str);
            $p1= explode(" ", $str);
            foreach ($p1 as $p2)
            {
                $p2= trim($p2);
                $p3= explode("/", $p2);
                $c= count($p3);
                $p4= $p3[($c -1)];
                if (trim($p4) == $k)
                {
                    $command_file= $p2;
                }
            }
            if (!is_executable($command_file) && !is_executable($k))
            {
                $msg .= "Command: '" . $k . "' is not executable\n\r";
                $return= false;
            }
        }
        if (!$return)
        {
            echo $msg . "\n\r";
            exit;
        }
        return $return;
    }
    function checkZend($file)
    {
        $fp= fopen($file, "ab+");
        $str= substr(fgets($fp, 5), 0, 4);
        fclose($fp);
        return ($str == "Zend") ? true : false;
    }
    function getLatestVersionNo($filename)
    {
        $fd= fopen($filename, "r");
        if (!$fd)
        {
            echo "Error: Can not open a connection to AccountLab Plus official server!\n\r";
            exit;
        }
        $content= fread($fd, 1024);
        fclose($fd);
        if (empty ($content))
        {
            echo "Error: Latest version number can not be resolved!\n\r";
            exit;
        }
        return $content;
    }
    function download($file_source, $file_target)
    {
        $rh= fopen($file_source, 'rb');
        $wh= fopen($file_target, 'wb');
        if ($rh === false || $wh === false)
        {
            if ($rh === false)
                echo "\n\rDownload error: Cannot read from file (" . $file_source . ")\n\r";
            else
                echo "\n\rDownload error: Cannot write to file (" . $file_target . ")\n\r";
            return false;
        }
        $i= 0;
        $j= array (
            "|",
            "/",
            "-",
            "\\"
        );
        while (!feof($rh))
        {
            if (fwrite($wh, fread($rh, 1024)) === FALSE)
            {
                echo "\n\rDownload error: Cannot write to file (" . $file_target . ")\n\r";
                return false;
            }
            $i++;
            $l= $i -4 * floor($i / 4);
            echo "( " . $j[$l] . " )" . $i . " Kilo bytes downloaded so far" . "\r";
        }
        fclose($rh);
        fclose($wh);
        echo "\n\rDownload complete. \n\r";
        return true;
    }
    exit;
?>
