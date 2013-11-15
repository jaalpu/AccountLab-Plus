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

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html dir="<?php echo PAGEDIR; ?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo $BL->props->lang['accountlabplus']; ?></title>
<link rel="stylesheet" href="<?php $horizonal = 1; echo $BL->props->get_page("templates/alp_admin/css/".ADMINCSS.".css"); ?>" type="text/css" />
<?php include_once $BL->props->get_page("templates/alp_admin/html/_javascripts.php"); ?>
</head>
<body>
<?php include_once $BL->props->get_page("templates/alp_admin/html/alert.php"); ?>
<div id="masthead">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr><td align="left" valign="top">
  <img src="<?php echo $BL->props->get_page("templates/alp_admin/images/alp-logo.gif"); ?>" alt="" width="190" height="24" border="0" />
	</td>
	<td align="right" valign="bottom">
  <b>
  <?php echo $BL->props->lang['version']." ".$BL->props->ALPversion; ?>
  <?php if($BL->props->alp_demo_mode==1) echo $BL->props->lang['demomode']; ?>
  <?php if($BL->props->payment_method_demo_mode==1) echo $BL->props->lang['testmode']; ?>
  </b>
  </td></tr>
  </table>
</div>
<?php if(ADMINCSS != "default_vertical_menu") $return_cmds = $BL->buildMenu(); else echo "&nbsp;"; ?>
<div id="masthead1">&nbsp;</div>
<br />
<?php if(ADMINCSS == "default_vertical_menu"){ ?>
<div id="sidemenu">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<?php $return_cmds = $BL->buildMenu(0); ?>
</table>
</div>
<?php } ?>
<!-- end masthead -->
