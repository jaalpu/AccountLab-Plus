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
<script language="JavaScript" type="text/javascript">
var tabs = ["tab1"];
var t    = ["t1"];
</script>  
<!--tabs//-->
<div class="tabs" name='t1' id='t1' onclick="javascript:showTab('tab1', tabs, 't1', t);" onmouseover="javascript:overTab('t1', t);" onmouseout="javascript:outTab(t);" ><?php echo $BL->props->lang['add_ticket']; ?></div>
<div>
<div id="tab1" name="tab1" class="tabContent" style="display:none">
<form name='form1' id='form1' method='post' action='<?php echo $PHP_SELF; ?>'>
<table width='100%' border='0' cellspacing='0' cellpadding='0'>
<?php if(!empty($err)){ ?>
<tr> 
    <td colspan='2' height='18' class='accountlabDataTD'><font color='red'><b><?php echo $err; ?></b></font></td>
</tr>
<?php } ?>
<tr> 
    <td width='25%' height='18' class='accountlabDataTD'>&nbsp;</td>
    <td class='accountlabDataTD'>
    <input type='radio' name='member' value='1' <?php if(isset($REQUEST['member']) && $REQUEST['member'])echo "checked"; ?> class='accountlabInput' onclick="javascript:toggleTbodyOff('confirm_pass_sec');toggleTbodyOff('name_sec');" /><b><?php echo $BL->props->lang['existinguser']; ?></b>
    &nbsp;&nbsp;
    <input type='radio' name='member' value='0' <?php if(!isset($REQUEST['member']) || !$REQUEST['member'])echo "checked"; ?> class='accountlabInput' onclick="javascript:toggleTbodyOn('confirm_pass_sec');toggleTbodyOn('name_sec');" /><b><?php echo $BL->props->lang['newuser']; ?></b>
    </td>
</tr>
<tbody id='name_sec' name='name_sec' class='<?php if(isset($REQUEST['member']) && $REQUEST['member'])echo "off"; else echo "on"; ?>'>
<tr> 
    <td width='25%' height='18' class='accountlabDataTD'><?php echo $BL->props->lang['Name']; ?></td>
    <td class='accountlabDataTD'>
    <input type='text' name='name' id='name' value="<?php if(isset($REQUEST['name']))echo $REQUEST['name']; ?>" size='40' class='accountlabInput' />
    </td>
</tr>
</tbody>
<tr> 
    <td width='25%' height='18' class='accountlabDataTD'><?php echo $BL->props->lang['Email']; ?></td>
    <td class='accountlabDataTD'>
    <input type='text' name='email' id='email' value="<?php if(isset($REQUEST['email']))echo $REQUEST['email']; ?>" size='40' class='accountlabInput' />
    </td>
</tr>
<tr> 
    <td width='25%' height='18' class='accountlabDataTD'><?php echo $BL->props->lang['Password']; ?></td>
    <td class='accountlabDataTD'>
    <input type='password' name='password' id='password' size='15' class='accountlabInput' />
    </td>
</tr>
<tbody id='confirm_pass_sec' name='confirm_pass_sec' class='<?php if(isset($REQUEST['member']) && $REQUEST['member'])echo "off";else echo "on"; ?>'>
<tr> 
    <td width='25%' height='18' class='accountlabDataTD'><?php echo $BL->props->lang['Confirm_password']; ?></td>
    <td class='accountlabDataTD'>
    <input type='password' name='password2' id='password2' size='15' class='accountlabInput' />
    </td>
</tr>
</tbody> 
<tr> 
    <td width='25%' height='18' class='accountlabDataTD'><?php echo $BL->props->lang['department']; ?></td>
    <td class='accountlabDataTD'>
    <select name='topic_id' id='topic_id' class='accountlabInput'>
    <?php foreach ($topics as $topic) { ?>
    <option value='<?php echo $topic['topic_id']; ?>' value="<?php if(isset($REQUEST['topic_id']) && $REQUEST['topic_id']==$topic['topic_id'])echo "selected"; ?>" ><?php echo $topic['topic_name']; ?></option>
    <?php } ?>
    </select>
    </td>
</tr>
<tr> 
    <td height='18' class='accountlabDataTD' valign='top'><?php echo $BL->props->lang['ticket_subject']; ?></td>
    <td class='accountlabDataTD'><input type="text" name="ticket_subject" id="ticket_subject" class='accountlabInput' size="50" />  
  </td>
</tr>
<tr> 
    <td height='18' class='accountlabDataTD' valign='top'><?php echo $BL->props->lang['Description']; ?></td>
    <td class='accountlabDataTD'><textarea name='ticket_text' id='ticket_text' cols='75' rows='10'><?php if(isset($REQUEST['ticket_text']))echo $REQUEST['ticket_text']; ?></textarea></td>
</tr>
<tr> 
    <td height='18' class='accountlabDataTD'></td>
    <td class='accountlabDataTD'>
    <input name='cmd' id='cmd' type='hidden' value='submit_ticket' />
    <input name='submit' id='submit' type='submit' class='accountlabButton' value='<?php echo $BL->props->lang['submit']; ?>' />
    </td>
</tr>
</table>
</form>
</div>
</div>
<script language="JavaScript" type="text/javascript">showTab('tab1', tabs, 't1', t);</script>
<?php include_once $BL->props->get_page("templates/".THEMEDIR."/html/user/footer.php"); ?>
