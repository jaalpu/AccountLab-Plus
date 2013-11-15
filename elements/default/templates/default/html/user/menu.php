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

?>

<div id="masthead"> 
  <h1 id="siteName"><?php echo !empty($BL->conf['company_name'])?$BL->conf['company_name']:$BL->props->lang['accountlabplus']; ?></h1>
</div> 
<div id="pagecell1">
  <div id="pageName" align="right"> 
    <?php include_once $BL->props->get_page("templates/".THEMEDIR."/html/user/theme_lang_selector.php"); ?>
  </div> 
  <?php if($BL->auth->IsAuth("user")) { ?>
  <div id="pageNav"> 
    <div id="sectionLinks"> 
      <a href="<?php echo $PHP_SELF; ?>"><?php echo $BL->props->lang['Dashboard']; ?></a> 
      <a href="<?php echo $PHP_SELF; ?>?cmd=edit"><?php echo $BL->props->lang['Edit_Profile']; ?></a> 
      <a href="<?php echo $PHP_SELF; ?>?cmd=orders"><?php echo $BL->props->lang['Orders']; ?></a> 
      <a href="<?php echo $PHP_SELF; ?>?cmd=invoices"><?php echo $BL->props->lang['^invoices']; ?></a>
      <?php if($conf['en_support']){ ?>
      <a href="<?php echo $PHP_SELF; ?>?cmd=tickets"><?php echo $BL->props->lang['^tickets']; ?></a>
      <?php } ?>
      <?php if(count($faqs)){ ?>
      <a href="<?php echo $PHP_SELF; ?>?cmd=faq"><?php echo $BL->props->lang['FAQs']; ?></a>
      <?php } ?>
      <a href="logout.php?&user=customer"><?php echo $BL->props->lang['Logout']; ?></a>
    </div> 
  </div> 
  <?php }elseif($general_section) { ?>
  <div id="pageNav"> 
    <div id="sectionLinks"> 
      <a href="customer.php"><?php echo $BL->props->lang['login']; ?></a> 
      <?php if($conf['en_support']){ ?>
      <a href="support.php"><?php echo $BL->props->lang['add_ticket']; ?></a>
      <?php } ?>
      <?php if(count($faqs)){ ?>
      <a href="faq.php"><?php echo $BL->props->lang['FAQs']; ?></a>
      <?php } ?>
    </div> 
  </div> 
  <?php } ?>
  <div id="content"> 
    <div class="story">
