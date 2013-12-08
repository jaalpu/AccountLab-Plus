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
        $BL->Redirect($cmd,"faq");
    }
    $page            = "faq.php";
    $conf            = $BL->conf;
    $general_section = true;
    $faqs = $BL->faqs->find();


    $Faqgroups = $BL->faqgroups->find();
    foreach($Faqgroups as $faqgroup)
    {
        if(!isset($BL->REQUEST['faqgroup_id']) || $BL->REQUEST['faqgroup_id']==$faqgroup['faqgroup_id'])
        {
            $BL->REQUEST['faqgroup_id']   = $faqgroup['faqgroup_id'];
            $BL->REQUEST['faqgroup_name'] = $faqgroup['faqgroup_name'];
            $BL->REQUEST['faqgroup_desc'] = $faqgroup['faqgroup_desc'];
        }
    }
    if(!count($Faqgroups))
    {
        $Faqs = $BL->faqs->find();
    }
    else
    {
        $Faqs = $BL->faqs->find(array("WHERE `faqgroup_id`=".intval($BL->REQUEST['faqgroup_id'])));
    }

    include_once $BL->props->get_page("templates/".THEMEDIR."/html/user/faq.php");
    $BL->Disconnect();
?>
