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
    * A class to do load all error handling
    * errorHandler Version 1.0
    */
    class errorHandler {

        var $error;
        var $error_type;
        var $error_msg;

        function errorHandler()
        {
            $this->error        = false;
            $this->error_type   = array();
            $this->error_msg    = array();
        }
        function setError($error)
        {
            $this->error = $error;
        }
        function setErrorType($type)
        {
            $this->error_type[] = $type;
        }
        function setErrorMsg($type,$msg)
        {
            if(!in_array($type,$this->error_type))
            {
                $this->setErrorType($type);
            }
            $date = date('d-M-Y H:i:s');
            $this->error_msg[$type][] = $msg;
            $fp   = @fopen(ERROR_LOG_FILE, "a+");
            $data = "$date | $type | $msg \n";
            fwrite($fp, $data);
            fclose($fp);
        }
        function getErrorLog()
        {
            $Error_Log = '';
            foreach($this->error_type as $type)
            {
                $Error_Log .= "================<b>".$type." Errors Start:</b>================<br />";
                foreach($this->error_msg[$type] as $error)
                {
                    $Error_Log .= $error."<br />";
                }
                $Error_Log .= "================<b>".$type." Errors End:</b>==================<br />";
            }
            echo $Error_Log."<br />";
        }
    }
?>
