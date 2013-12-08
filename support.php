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

    require_once "init.php";
    if(isset($BL->REQUEST['force_theme']) || isset($BL->REQUEST['force_lang']))
    {
        if(isset($BL->REQUEST['force_theme']))$_SESSION['force_theme'] = $BL->REQUEST['force_theme'];
        if(isset($BL->REQUEST['force_lang'])) $_SESSION['force_lang']  = $BL->REQUEST['force_lang'];
        $BL->Redirect($cmd,"support");
    }
    $page            = "support.php";
    $error           = null;
    $general_section = true;
    $conf            = $BL->conf;
    $topics          = $BL->support_topics->find();
    $faqs            = $BL->faqs->find();
    //Deside where to go
    switch ($cmd)
    {
        case "submit_ticket" :
        {
            if(!empty($BL->REQUEST['member']))
            {
                $BL->REQUEST['existing_email']    = $BL->REQUEST['email'];
                $BL->REQUEST['existing_password'] = $BL->REQUEST['password'];

            }
            else
            {
                $BL->REQUEST['password1']         = $BL->REQUEST['password'];
            }
            $err = $BL->customers->validate($BL->REQUEST,array(array('field_name'=>'name','field_id'=>1,'field_optional'=>0)));
            if(empty($err))
            {
                if(empty($BL->REQUEST['member']))
                {
                    $BL->REQUEST['cust_id'] = $BL->customers->add(array(array('field_name'=>'name','field_id'=>1)));
                }
                else
                {
                    $temp = $BL->customers->hasAnyOne(array("WHERE `email`='".$BL->utils->quoteSmart($BL->REQUEST['email'])."' AND `password`='".md5($BL->REQUEST['password'])."'"));
                    $BL->REQUEST['cust_id'] = $temp['id'];
                }
                if(!empty($BL->REQUEST['cust_id']))
                {
                    $BL->REQUEST['ticket_status'] = 1;
                    $BL->REQUEST['ticket_date']= date('Y-m-d H:i:s');
                    $BL->REQUEST['ticket_id']  = $BL->support_tickets->insert($BL->REQUEST);
                    $BL->mailTicket($BL->REQUEST['ticket_id']);
                    include_once $BL->props->get_page("templates/".THEMEDIR."/html/user/submit_ticket_thanks.php");
                    break;
                }
            }
        }
        default :
        {
            include_once $BL->props->get_page("templates/".THEMEDIR."/html/user/submit_ticket.php");
            break;
        }
    }
    $BL->Disconnect();
?>
