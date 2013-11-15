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

<?php include_once $BL->props->get_page("templates/".THEMEDIR."/html/cart/top.php"); ?>
<!--Main table. Contains two rows:
1. top picture, logo and menu
2. page body with texts etc.
-->
  <table width="767" border="0" cellpadding="0" cellspacing="0" align="center">
<!--Top image with logo and contact info-->    
    <tr valign="top">
      <td colspan="3" background="<?php echo $BL->props->get_page("templates/".THEMEDIR."/images/top.jpg"); ?>" width="767" height="196">
              <div style="position: relative; top: 100px; left: 57px">
                <table border="0" cellpadding="5">
                  <tr valign="top">
                    <td><img src="<?php echo $BL->props->get_page("templates/".THEMEDIR."/images/logo.gif"); ?>" width="54" height="82"></td>
                    <td><div class="logo" style="padding-top:10px">Company LOGO</div><div class="slogan">Company slogan</div></td>
                  </tr>
                </table>
              </div>
        <div class="contact">Live Sales and Support<br><img src="<?php echo $BL->props->get_page("templates/".THEMEDIR."/images/phone.gif"); ?>" width="17" height="12" alt="">&nbsp;&nbsp;1-800-124-7823</div>
      </td>
    </tr>
<!--HMENU-->    
    <tr valign="top">
      <td><img src="<?php echo $BL->props->get_page("templates/".THEMEDIR."/images/hmenu_left.gif"); ?>" width="1" height="26" alt=""></td>
      <td background="<?php echo $BL->props->get_page("templates/".THEMEDIR."/images/hmenu_fill.gif"); ?>" class="hmenu" width="765" height="26" valign="top" style="padding-top:3px; padding-left:10px">
      <img src="<?php echo $BL->props->get_page("templates/".THEMEDIR."/images/bullet.gif"); ?>" alt="" width="4" height="6" hspace="12"><a href="#">Lorem ipsum</a><img src="<?php echo $BL->props->get_page("templates/".THEMEDIR."/images/bullet.gif"); ?>" alt="" width="4" height="6" hspace="12"><a href="#">Lorem ipsum</a><img src="<?php echo $BL->props->get_page("templates/".THEMEDIR."/images/bullet.gif"); ?>" alt="" width="4" height="6" hspace="12"><a href="#">Lorem ipsum</a></td>
      <td><img src="<?php echo $BL->props->get_page("templates/".THEMEDIR."/images/hmenu_right.gif"); ?>" width="1" height="26" alt=""></td>
    </tr>
<!--Content rows-->
    <tr valign="top">
      <td colspan="3">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" height="100%">
          <tr valign="top">
            <td width="2" background="<?php echo $BL->props->get_page("templates/".THEMEDIR."/images/left_fill.gif"); ?>"><img src="<?php echo $BL->props->get_page("templates/".THEMEDIR."/images/left_top.gif"); ?>" width="2" height="2" alt=""></td>
            <td width="762" bgcolor="#F3F3F3">
              <table width="100%" border="0" cellpadding="0" cellspacing="0" height="100%">
<!--Content and promo-->
                <tr valign="top">
<!--Your content here-->
                  <td class="a_content">
