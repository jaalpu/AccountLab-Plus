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

<?php include_once $BL->props->get_page("templates/".THEMEDIR."/html/user/header.php"); ?>
<form name='form1' id='form1' action='<?php echo $PHP_SELF; ?>' method='POST' class='alpform'>
<table width='100%' border='0' cellspacing='0' cellpadding='0'>            
<tr> 
  <td colspan='2'>
  <b><?php echo $BL->props->lang['login']; ?></b>
  </td>
</tr>
<tr> 
  <td width='40%'><span class='alplabel'><?php echo $BL->props->lang['Email']; ?></span></td>
  <td>
  <input name='email' type='text' class='alpinput' id='email' size='20' />
  </td>
</tr>
<tr> 
  <td><span class='alplabel'><?php echo $BL->props->lang['password']; ?></span></td>
  <td>
  <input name='password' type='password' class='alpinput' id='password' size='20' />
  <?php foreach($_GET as $k=>$v) { ?>
  <input name='<?php echo $k; ?>' type='hidden' value='<?php echo $v; ?>' />
  <?php } ?>
  </td>
</tr>
<tr> 
  <td>&nbsp;</td>
  <td>
  <input name='submit_login' type='submit' class='alpinput' value='<?php echo $BL->props->lang['login']; ?>' />
  </td>
</tr>
</table>
</form>
<br />
<form name='form2' id='form2' method='post' action='<?php echo $PHP_SELF; ?>' class='form'>
<table width='100%' border='0' cellspacing='0' cellpadding='0'>
<tr> 
  <td colspan='2'>
  <b><?php echo $BL->props->lang['fp']; ?></b>
  </td>
</tr>
<tr> 
 <td width='40%'><span class='alplabel'><?php echo $BL->props->lang['Email']; ?></span></td>
 <td><input name='email' type='text' class='alpinput' id='email' size='20' /></td>
</tr>
<tr> 
 <td>&nbsp;</td>
 <td>
 <input name='get_pass' type='hidden' value='1'>
 <input name='submit' type='submit' class='alpinput' value='<?php echo $BL->props->lang['gp']; ?>' />
 </td>
</tr>
</table>
</form>
<br />
<?php include_once $BL->props->get_page("templates/".THEMEDIR."/html/user/footer.php"); ?>
