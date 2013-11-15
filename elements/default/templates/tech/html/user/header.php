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

<?php include_once $BL->props->get_page("templates/".THEMEDIR."/html/user/top.php"); ?>
<!--Main table. Contains two rows:
1. top picture, logo and menu
2. page body with texts etc.
-->
  <table width="100%" cellpadding="0" cellspacing="0" border="0" height="100%">
    <tr>
      <td background="<?php echo $BL->props->get_page("templates/".THEMEDIR."/images/bg1.gif"); ?>" height="258" width="100%" valign="top">
        <table width="790" cellpadding="0" cellspacing="0" border="0">
          <tr>
<!--Top picture with logo-->
            <td colspan="2" width="786" height="227" background="<?php echo $BL->props->get_page("templates/".THEMEDIR."/images/top.jpg"); ?>" valign="top">
              <div style="position: relative; top: 43px; left: 57px">
                <table border="0" cellpadding="5">
                  <tr valign="top">
                    <td><img src="<?php echo $BL->props->get_page("templates/".THEMEDIR."/images/logo.gif"); ?>" width="54" height="93"></td>
                    <td><div class="logo" style="padding-top:10px">Company LOGO</div><div class="slogan">Company slogan</div></td>
                  </tr>
                </table>
              </div>
            </td>
            <td rowspan="2" width="4" height="258" background="<?php echo $BL->props->get_page("templates/".THEMEDIR."/images/right_shadow1.gif"); ?>"><img src="<?php echo $BL->props->get_page("templates/".THEMEDIR."/images/spacer.gif"); ?>" width="4"></td>
          </tr>
          <tr>
<!--Hor. menu-->
            <td width="21" height="31" background="<?php echo $BL->props->get_page("templates/".THEMEDIR."/images/menu_left.gif"); ?>"></td>
            <td width="765" class="hmenu" height="31" background="<?php echo $BL->props->get_page("templates/".THEMEDIR."/images/menu_fill.gif"); ?>" valign="center"><img src="<?php echo $BL->props->get_page("templates/".THEMEDIR."/images/bullet.gif"); ?>" alt="" width="4" height="6" hspace="12"><a href="#">Lorem ipsum</a><img src="<?php echo $BL->props->get_page("templates/".THEMEDIR."/images/bullet.gif"); ?>" alt="" width="4" height="6" hspace="12"><a href="#">Lorem ipsum</a><img src="<?php echo $BL->props->get_page("templates/".THEMEDIR."/images/bullet.gif"); ?>" alt="" width="4" height="6" hspace="12"><a href="#">Lorem ipsum</a></td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td valign="top">
        <table width="790" cellpadding="0" cellspacing="0" border="0" bgcolor="#F4F0E0" height="100%">
          <tr valign="top">
            <td width="21" height="200" background="<?php echo $BL->props->get_page("templates/".THEMEDIR."/images/left_fill.gif"); ?>" rowspan="2"><img src="<?php echo $BL->props->get_page("templates/".THEMEDIR."/images/spacer.gif"); ?>" width="21"></td>
<!--Cell with site content-->
            <td style="padding-left: 21px; padding-right: 10px; padding-top: 21px; padding-bottom: 21px">
			
<!--ALP code start here-->
<div id="masthead"> 
  <h1 id="siteName">
    <?php 
    if(!empty($conf['company_name']))echo $conf['company_name'];
    else echo $BL->props->lang['accountlabplus']; 
    ?>
  </h1> 
  <!-- end globalNav --> 
</div> 
<!-- end masthead --> 
<?php include $BL->props->get_page("templates/".THEMEDIR."/html/user/menu.php"); ?>
