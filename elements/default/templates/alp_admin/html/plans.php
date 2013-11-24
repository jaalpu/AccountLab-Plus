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

<?php include_once $BL->props->get_page("templates/alp_admin/html/header.php"); ?>
<script language="JavaScript" type="text/javascript">
var tabs = ["tab1","tab2","tab3"];
var t    = ["t1","t2","t3"];
</script> 
<div id="content">
    <div id="display_list">
      <div class="tabs" name='tt1' id='tt1' onmouseover="javascript:this.className='tabs1';" onmouseout="javascript:this.className='tabs';" ><a href="admin.php?cmd=plans" class="add_link"><?php echo $BL->props->lang['~plans']; ?></a></div>
      <div class="tab_separator">&nbsp;</div>
      <div class="tabs2" name='tt2' id='tt2' onmouseover="javascript:this.className='tabs1';" onmouseout="javascript:this.className='tabs2';" ><?php echo $title; ?></div>
      <div class="tab_separator">&nbsp;</div>
    </div>
    <div id="display_list">
      <div class="tabs" name='t1' id='t1' onclick="javascript:showTab('tab1', tabs, 't1', t);" onmouseover="javascript:overTab('t1', t);" onmouseout="javascript:outTab(t);" ><?php echo $BL->props->lang['General']; ?></div>
      <div class="tab_separator">&nbsp;</div>
      <div class="tabs" name='t2' id='t2' onclick="javascript:showTab('tab2', tabs, 't2', t);" onmouseover="javascript:overTab('t2', t);" onmouseout="javascript:outTab(t);" ><?php echo $BL->props->lang['account_creation_settings']; ?></div>
      <div class="tab_separator">&nbsp;</div>
      <div class="tabs" name='t3' id='t3' onclick="javascript:showTab('tab3', tabs, 't3', t);" onmouseover="javascript:overTab('t3', t);" onmouseout="javascript:outTab(t);" ><?php echo $BL->props->lang['server_settings']; ?></div>
    </div>
	<div id="display_list">
    <form name='form1' id='form1' method='post' action='<?php echo $PHP_SELF; ?>'>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="list_table">
    <tr>
        <td colspan="2" class="tdheading">
        <b>&nbsp;</b>
        </td>
    </tr>
    <tr> 
        <td colspan="2" class="text_grey">
        <img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" />
        </td>
    </tr>  
    <tr>
        <td colspan='2'>
        <div id="tab1" name="tab1" class="tabContent" style="display:none">
        <table width='100%' border='0' cellspacing='0' cellpadding='0'>
        <tr> 
        <td class='text_grey' width='1%' valign='top'>
        <div align='center'></div>
        </td>
        <td class='text_grey'>
        <fieldset>
        <legend><b><?php echo $BL->props->lang['~groups']; ?></b></legend>
        <table width='100%' border='0' cellspacing='0' cellpadding='0' align='center'>
        <?php foreach ($groups as $group) { ?>
        <tr> 
          <td valign='top' width='29%'>
          <?php echo $group['group_name']; ?>
          </td>
          <td>
          <input type='checkbox' class='search' name='group_ids[]' id='group_ids[]' value='<?php echo $group['group_id']; ?>' <?php if($cmd=="editplan" && array_search($group['group_id'],$group_ids)!==false)echo "checked"; ?> />
          </td>
        </tr>  
        <?php } ?>
        </table>
        </fieldset>
        </td>
        </tr>
        <tr> 
        <td colspan='2' class='text_grey'>
        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
        </td>
        </tr>

        <tr> 
        <td class='text_grey' width='1%' valign='top'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['plan_name']; ?>
        </div>
        <div id="form1_field">
        <input type='text' name='plan_friendly_name' class='search' size='40' value='<?php if($cmd=="editplan")echo $plan['plan_friendly_name']; ?>' />
        </div>
        </td>
        </tr>
        <tr> 
        <td colspan='2' class='text_grey'>
        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
        </td>
        </tr>
        
        <tr> 
        <td class='text_grey' width='1%' valign='top'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['plandesc']; ?>
        </div>
        <div id="form1_field">
        <textarea name='plan_desc' id='plan_desc' cols='55' rows='10'><?php if($cmd=="editplan")echo $plan['plan_desc']; ?></textarea>
        </div>
        </td>
        </tr>
        <tr> 
        <td colspan='2' class='text_grey'>
        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
        </td>
        </tr>
        
        <tr> 
        <td class='text_grey' width='1%' valign='top'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['setup_fee']." (".$conf['symbol'].")"; ?>
        </div>
        <div id="form1_field">
        <input name='host_setup_fee' type='text' class='search' id='host_setup_fee' size='20' value='<?php if($cmd=="editplan")echo $plan['host_setup_fee']; ?>' />
        </div>
        </td>
        </tr>
        <tr> 
        <td colspan='2' class='text_grey'>
        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
        </td>
        </tr>
        
        <?php foreach($BL->props->cycles as $month=>$cycle){ ?>
        <tr> 
        <td class='text_grey' width='1%' valign='top'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->parseLang($cycle)." (".$conf['symbol'].")"; ?>
        </div>
        <div id="form1_field">
        <input name='<?php echo $cycle; ?>' type='text' class='search' id='<?php echo $cycle; ?>' size='20' value='<?php if($cmd=="editplan")echo $plan_cycles[$cycle]; ?>' />
        </div>
        </td>
        </tr>
        <tr> 
        <td colspan='2' class='text_grey'>
        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
        </td>
        </tr>
        <?php } ?>
        
        <tr> 
        <td class='text_grey' width='1%' valign='top'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['force_domain_subdomain']; ?>
        </div>
        <div id="form1_field">        
        <select name='force_domain_subdomain' id='force_domain_subdomain' class='search'>
        <option value='1' <?php if($cmd=="editplan" && $plan['force_domain_subdomain']==1)echo "selected=\"selected\""; ?>><?php echo  $BL->props->lang['Yes']; ?></option>
        <option value='0' <?php if($cmd=="editplan" && $plan['force_domain_subdomain']==0)echo "selected=\"selected\""; ?>><?php echo  $BL->props->lang['No']; ?></option>
        </select>
        </div>
        </td>
        </tr>
        <tr> 
        <td colspan='2' class='text_grey'>
        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
        </td>
        </tr>
        
        
        <tr> 
        <td class='text_grey' width='1%' valign='top'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['offer_domains']; ?>
        </div>
        <div id="form1_field">
        <select name='domain' id='domain' class='search'>
        <option value='1' <?php if($cmd=="editplan" && $plan['domain']==1)echo "selected=\"selected\""; ?>><?php echo  $BL->props->lang['Yes']; ?></option>
        <option value='0' <?php if($cmd=="editplan" && $plan['domain']==0)echo "selected=\"selected\""; ?>><?php echo  $BL->props->lang['No']; ?></option>
        </select>
        </div>
        </td>
        </tr>
        <tr> 
        <td colspan='2' class='text_grey'>
        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
        </td>
        </tr>
        
        
        
        
        <tr> 
        <td class='text_grey' width='1%' valign='top'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['offer_subdomains']; ?>
        </div>
        <div id="form1_field">
        <select name='subdomain' id='subdomain' class='search'>
        <option value='1' <?php if($cmd=="editplan" && $plan['subdomain']==1)echo "selected=\"selected\""; ?>><?php echo  $BL->props->lang['Yes']; ?></option>
        <option value='0' <?php if($cmd=="editplan" && $plan['subdomain']==0)echo "selected=\"selected\""; ?>><?php echo  $BL->props->lang['No']; ?></option>
        </select>
        </div>
        </td>
        </tr>
        <tr> 
        <td colspan='2' class='text_grey'>
        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
        </td>
        </tr>
        
        <tr> 
        <td class='text_grey' width='1%' valign='top'>
        <div align='center'></div>
        </td>
        <td class='text_grey'>
        <fieldset>
        <legend><b><?php echo $BL->props->lang['addons']; ?></b></legend>
        <table width='100%' border='0' cellspacing='0' cellpadding='0' align='center'>
        <?php foreach ($addons as $addon) { ?>
        <tr> 
          <td valign='top' width='29%'>
          <?php echo $addon['addon_name']; ?>
          </td>
          <td>
          <input type='checkbox' class='search' name='addon_ids[]' id='addon_ids[]' value='<?php echo $addon['addon_id']; ?>' <?php if($cmd=="editplan" && array_search($addon['addon_id'],$addon_ids)!==false)echo "checked"; ?> />
          </td>
        </tr>  
        <?php } ?>
        </table>
        </fieldset>
        </td>
        </tr>
        <tr> 
        <td colspan='2' class='text_grey'>
        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
        </td>
        </tr>
        
        <tr> 
        <td class='text_grey' width='1%' valign='top'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['default_cycle']; ?>
        </div>
        <div id="form1_field">
        <select name='default_cycle' id='default_cycle' class='search'>
        <option value='0' <?php if($cmd == "editplan" && $plan['default_cycle'] == 0)echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['free']; ?></option>                                
        <?php foreach($BL->props->cycles as $ck=>$cv){ ?>
        <option value='<?php echo $ck; ?>' <?php if($cmd == "editplan" && $plan['default_cycle'] == $ck)echo "selected=\"selected\""; ?>><?php echo $BL->props->lang[$cv]; ?></option>
        <?php } ?>
        <option value='13' <?php if($cmd == "addplan" || $plan['default_cycle'] == 13)echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['customer_selection']; ?></option>                           
        </select>
        </div>
        </td>
        </tr>
        <tr> 
        <td colspan='2' class='text_grey'>
        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
        </td>
        </tr>
        
        </table>
        </div>
        <div id="tab2" name="tab2" class="tabContent" style="display:none">
        <table width='100%' border='0' cellspacing='0' cellpadding='0'>

        <tr> 
        <td class='text_grey' width='1%' valign='top'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['Account_Creation_Method']; ?>
        </div>
        <div id="form1_field">
        <select name='acc_method' class='search' id='acc_method'>
        <option value='2' <?php if($cmd == "editplan" && $plan['acc_method']==2) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['upon_payment']; ?></option>
        <option value='1' <?php if($cmd == "editplan" && $plan['acc_method']==1) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['upon_validation']; ?></option>
        <option value='0' <?php if($cmd == "editplan" && $plan['acc_method']==0) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['no_create']; ?></option>
        </select>
        </div>
        </td>
        </tr>
        <tr> 
        <td colspan='2' class='text_grey'>
        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
        </td>
        </tr>
        
        <tr> 
        <td class='text_grey' width='1%' valign='top'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['activation_mail']; ?>
        </div>
        <div id="form1_field">
        <textarea name='activation_mail_template' id='activation_mail_template' cols='55' rows='10'><?php if($cmd == "editplan")echo $plan['activation_mail_template']; ?></textarea>
        </div>
        </td>
        </tr>
        <tr> 
        <td colspan='2' class='text_grey'>
        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
        </td>
        </tr>
        
        <tr> 
        <td class='text_grey' width='1%' valign='top'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['suspended_mail']; ?>
        </div>
        <div id="form1_field">
        <textarea name='suspended_mail_template' id='suspended_mail_template' cols='55' rows='10'><?php if($cmd == "editplan")echo $plan['suspended_mail_template']; ?></textarea>
        </div>
        </td>
        </tr>
        <tr> 
        <td colspan='2' class='text_grey'>
        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
        </td>
        </tr>
        
        </table>
        </div>
        <div id="tab3" name="tab3" class="tabContent" style="display:none">
        <table width='100%' border='0' cellspacing='0' cellpadding='0'>
        
        <tr> 
        <td class='text_grey' width='1%' valign='top'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['Server_Name']; ?>
        </div>
        <div id="form1_field">
        <select name='server_id' id='server_id' class='search'>
        <?php if(!count($servers)){ ?>
        <option value='0' <?php if($cmd == "editplan" && $plan['server_id'] == 0) echo "selected"; ?>><?php echo $BL->props->lang['Default_Server']; ?></option>
        <?php } ?>
        <?php foreach ($servers as $server) { ?>
        <option value='<?php echo $server['server_id']; ?>' <?php if($cmd == "editplan" && $plan['server_id'] == $server['server_id']) echo "selected"; ?>><?php echo $server['server_name']; ?></option>
        <?php } ?>
        </select>
        </div>
        </td>
        </tr>
        <tr> 
        <td colspan='2' class='text_grey'>
        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
        </td>
        </tr>
        
        <tr> 
        <td class='text_grey' width='1%' valign='top'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['en_server_rotation']; ?>
        </div>
        <div id="form1_field">
        <select name='en_server_rotation' class='search' id='en_server_rotation'>
        <option value='0' <?php if($cmd == "editplan" && $plan['en_server_rotation']==0) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['No']; ?></option>
        <option value='1' <?php if($cmd == "editplan" && $plan['en_server_rotation']==1) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['Yes']; ?></option>
        </select>
        </div>
        </td>
        </tr>
        <tr> 
        <td colspan='2' class='text_grey'>
        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
        </td>
        </tr>
        
        <tr> 
        <td class='text_grey' width='1%' valign='top'>
        <div align='center'></div>
        </td>
        <td class='text_grey'>
        <fieldset>
        <legend><b><?php echo $BL->props->lang['additional_servers']; ?></b></legend>
        <table width='100%' border='0' cellspacing='0' cellpadding='0' align='center'>
        <?php foreach ($servers as $server) { ?>
        <tr> 
          <td valign='top' width='29%'>
          <?php echo $server['server_name']; ?>
          </td>
          <td width='5%'>
          <input type='checkbox' class='search' name='server_ids[<?php echo $server['server_id']; ?>]' id='server_ids[<?php echo $server['server_id']; ?>]' value='1' <?php if($cmd=="editplan" && array_search($server['server_id'],$server_ids)!==false)echo "checked"; ?> />
          </td>
          <td valign='top' width='20%'>
          <?php echo $BL->props->lang['rotation_index']; ?>
          </td>
          <td>
            <select name='rotation_indexes[<?php echo $server['server_id']; ?>]' class='search' id='rotation_indexes[<?php echo $server['server_id']; ?>]'>
            <?php for($i=1;$i<=count($servers);$i++){ ?>
            <option value='<?php echo $i; ?>' <?php if($cmd=="editplan" && isset($server_ids[$server['server_id']]) && $server_ids[$server['server_id']]==$i)echo "selected"; ?>><?php echo $i; ?></option>
            <?php } ?>
            </select>
          </td>
        </tr>  
        <?php } ?>
        </table>
        </fieldset>
        </td>
        </tr>
        <tr> 
        <td colspan='2' class='text_grey'>
        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
        </td>
        </tr>
        
        <tr> 
        <td class='text_grey' width='1%' valign='top'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['server_package']; ?>
        </div>
        <div id="form1_field">
        <input name='plan_name' type='text' class='search' id='plan_name' size='20' value='<?php if($cmd=="editplan")echo $plan['plan_name']; ?>' />
        </div>
        </td>
        </tr>
        <tr> 
        <td colspan='2' class='text_grey'>
        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
        </td>
        </tr>
        
        <tr> 
        <td class='text_grey' width='1%' valign='top'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['cip']; ?>
        </div>
        <div id="form1_field">
        <select name='cip' id='cip' class='search'>
        <option value='1' <?php if($cmd=="editplan" && $plan['cip']==1)echo "selected=\"selected\""; ?>><?php echo  $BL->props->lang['Yes']; ?></option>
        <option value='0' <?php if($cmd=="editplan" && $plan['cip']==0)echo "selected=\"selected\""; ?>><?php echo  $BL->props->lang['No']; ?></option>
        </select>
        </div>
        </td>
        </tr>
        <tr> 
        <td colspan='2' class='text_grey'>
        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
        </td>
        </tr>
        
        <tr> 
        <td class='text_grey' width='1%' valign='top'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['cgi']; ?>
        </div>
        <div id="form1_field">
        <select name='cgi' id='cgi' class='search'>
        <option value='1' <?php if($cmd=="editplan" && $plan['cgi']==1)echo "selected=\"selected\""; ?>><?php echo  $BL->props->lang['Yes']; ?></option>
        <option value='0' <?php if($cmd=="editplan" && $plan['cgi']==0)echo "selected=\"selected\""; ?>><?php echo  $BL->props->lang['No']; ?></option>
        </select>        
        </div>
        </td>
        </tr>
        <tr> 
        <td colspan='2' class='text_grey'>
        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
        </td>
        </tr>
        
        <tr> 
        <td class='text_grey' width='1%' valign='top'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['quota']; ?>
        </div>
        <div id="form1_field">
        <input name='quota' type='text' class='search' id='quota' size='20' value='<?php if($cmd=="editplan")echo $plan['quota']; ?>' />
        
        </div>
        </td>
        </tr>
        <tr> 
        <td colspan='2' class='text_grey'>
        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
        </td>
        </tr>
        
        <tr> 
        <td class='text_grey' width='1%' valign='top'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['frontpage']; ?>
        </div>
        <div id="form1_field">
        <select name='frontpage' id='frontpage' class='search'>
        <option value='1' <?php if($cmd=="editplan" && $plan['frontpage']==1)echo "selected=\"selected\""; ?>><?php echo  $BL->props->lang['Yes']; ?></option>
        <option value='0' <?php if($cmd=="editplan" && $plan['frontpage']==0)echo "selected=\"selected\""; ?>><?php echo  $BL->props->lang['No']; ?></option>
        </select>
        </div>
        </td>
        </tr>
        <tr> 
        <td colspan='2' class='text_grey'>
        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
        </td>
        </tr>
        
        <tr> 
        <td class='text_grey' width='1%' valign='top'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['maxsql']; ?>
        </div>
        <div id="form1_field">
        <input name='maxsql' type='text' class='search' id='maxsql' size='20' value='<?php if($cmd=="editplan")echo $plan['maxsql']; ?>' />
        
        </div>
        </td>
        </tr>
        <tr> 
        <td colspan='2' class='text_grey'>
        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
        </td>
        </tr>
        
        <tr> 
        <td class='text_grey' width='1%' valign='top'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['maxpop']; ?>
        </div>
        <div id="form1_field">
        <input name='maxpop' type='text' class='search' id='maxpop' size='20' value='<?php if($cmd=="editplan")echo $plan['maxpop']; ?>' />
        
        </div>
        </td>
        </tr>
        <tr> 
        <td colspan='2' class='text_grey'>
        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
        </td>
        </tr>
        
        <tr> 
        <td class='text_grey' width='1%' valign='top'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['maxlst']; ?>
        </div>
        <div id="form1_field">
        <input name='maxlst' type='text' class='search' id='maxlst' size='20' value='<?php if($cmd=="editplan")echo $plan['maxlst']; ?>' />
        
        </div>
        </td>
        </tr>
        <tr> 
        <td colspan='2' class='text_grey'>
        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
        </td>
        </tr>
        
        <tr> 
        <td class='text_grey' width='1%' valign='top'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['maxsub']; ?>
        </div>
        <div id="form1_field">
        <input name='maxsub' type='text' class='search' id='maxsub' size='20' value='<?php if($cmd=="editplan")echo $plan['maxsub']; ?>' />
        
        </div>
        </td>
        </tr>
        <tr> 
        <td colspan='2' class='text_grey'>
        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
        </td>
        </tr>
        
        <tr> 
        <td class='text_grey' width='1%' valign='top'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['bwlimit']; ?>
        </div>
        <div id="form1_field">
        <input name='bwlimit' type='text' class='search' id='bwlimit' size='20' value='<?php if($cmd=="editplan")echo $plan['bwlimit']; ?>' />
        
        </div>
        </td>
        </tr>
        <tr> 
        <td colspan='2' class='text_grey'>
        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
        </td>
        </tr>
        
        <tr> 
        <td class='text_grey' width='1%' valign='top'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['maxftp']; ?>
        </div>
        <div id="form1_field">
        <input name='maxftp' type='text' class='search' id='maxftp' size='20' value='<?php if($cmd=="editplan")echo $plan['maxftp']; ?>' />
        
        </div>
        </td>
        </tr>
        <tr> 
        <td colspan='2' class='text_grey'>
        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
        </td>
        </tr>
        
        <tr> 
        <td class='text_grey' width='1%' valign='top'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['hasshell']; ?>
        </div>
        <div id="form1_field">
        <select name='hasshell' id='hasshell' class='search'>
        <option value='1' <?php if($cmd=="editplan" && $plan['hasshell']==1)echo "selected=\"selected\""; ?>><?php echo  $BL->props->lang['Yes']; ?></option>
        <option value='0' <?php if($cmd=="editplan" && $plan['hasshell']==0)echo "selected=\"selected\""; ?>><?php echo  $BL->props->lang['No']; ?></option>
        </select>
        </div>
        </td>
        </tr>
        <tr> 
        <td colspan='2' class='text_grey'>
        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
        </td>
        </tr>
        
        <tr> 
        <td class='text_grey' width='1%' valign='top'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['maxpark']; ?>
        </div>
        <div id="form1_field">
        <input name='maxpark' type='text' class='search' id='maxpark' size='20' value='<?php if($cmd=="editplan")echo $plan['maxpark']; ?>' />
        
        </div>
        </td>
        </tr>
        <tr> 
        <td colspan='2' class='text_grey'>
        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
        </td>
        </tr>
        
        <tr> 
        <td class='text_grey' width='1%' valign='top'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['maxaddon']; ?>
        </div>
        <div id="form1_field">
        <input name='maxaddon' type='text' class='search' id='maxaddon' size='20' value='<?php if($cmd=="editplan")echo $plan['maxaddon']; ?>' />
        
        </div>
        </td>
        </tr>
        <tr> 
        <td colspan='2' class='text_grey'>
        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
        </td>
        </tr>
        
        <tr> 
        <td colspan='2' class='text_grey'>&nbsp;</td>
        </tr>
        
        <tr> 
        <td class='text_grey' colspan='2'>
        <fieldset>
        <legend>
        <input type="checkbox" name="cpanel_plan" id="cpanel_plan" class='search' value="1" <?php if($cmd=="editplan" && $plan['cpr_profile_id']>0)echo "checked"; ?> onclick="javascript:if(this.checked)toggleTbodyOn('cpanel_sec');else toggleTbodyOff('cpanel_sec');" />
        <b><?php echo $BL->props->lang['cpanel_plan']; ?></b>
        </legend>
        <table width='100%' border='0' cellspacing='0' cellpadding='0' align='center'>
        <tbody name='cpanel_sec' id='cpanel_sec' class='off'>
        <tr> 
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['cp']; ?>
        </div>
        <div id="form1_field">
        <input name='cp' type='text' class='search' id='cp' size='20' value='<?php if($cmd=="editplan")echo $plan['cp']; ?>' />
        </div>
        </td>
        </tr>
        
        <tr> 
        <td class='text_grey'>
        <fieldset>
        <legend>
        <input type="checkbox" name="cpanel_reseller" id="cpanel_reseller" class='search' value="1" <?php if($cmd=="editplan" && $plan['cpanel_reseller']==1)echo "checked=\"checked\""; ?> />
        <b><?php echo $BL->props->lang['cpanel_reseller']; ?></b>
        </legend>
         <table width='100%' border='0' cellspacing='0' cellpadding='0' align='center'>
         <tr><td><b><?php echo $BL->props->lang['Limit_the_reseller']; ?></b></td>
             <td></td></tr>
         <tr><td><?php echo $BL->props->lang['to_a_fixed_number_of_accounts_per_individual_package']; ?></td>
             <td><input type='radio' name='limit_type' value='0' <?php if($cmd=="editplan" && empty($plan_cpanel_reseller_profile['limit_type']))echo "checked=\"checked\""; ?> class='search' /></td></tr>
         <tr><td><?php echo $BL->props->lang['--to']; ?><input size='3' maxlength='4' class='search' type='text' id='resnumlimitamt' name='resnumlimitamt' value='<?php if($cmd=="editplan") echo $plan_cpanel_reseller_profile['resnumlimitamt'];else echo "0"; ?>'><?php echo $BL->props->lang['resnumlimitamt']; ?></td>
             <td><input type='radio' name='limit_type' value='1' class='search' <?php if($cmd=="editplan" && $plan_cpanel_reseller_profile['limit_type']==1)echo "checked=\"checked\""; ?> /></td></tr>
         <tr><td><?php echo $BL->props->lang['by_the_resource_usage_below']; ?></td>
             <td><input type='radio' name='limit_type' value='2' class='search' <?php if($cmd=="editplan" && $plan_cpanel_reseller_profile['limit_type']==2)echo "checked=\"checked\""; ?> /></td></tr> 
         <tr>
             <td colsspan='2'>
             <table width='100%' cellpadding='0' cellspacing='0' border='0'>
              <tr>
                  <td>&nbsp;</td>
                  <td><?php echo $BL->props->lang['Disk_Space']; ?></td>
                  <td><input class='search' size='5' maxlength='20' type='text' name='rslimit_disk' value='<?php if($cmd=="editplan") echo $plan_cpanel_reseller_profile['rslimit_disk']; ?>' /> MB</td>
                  <td>&nbsp;<input type='checkbox' class='search' <?php if($cmd=="editplan" && $plan_cpanel_reseller_profile['rsolimit_disk']==1)echo "checked=\"checked\""; ?> name='rsolimit_disk' id='rsolimit_disk' value='1' /><?php echo $BL->props->lang['rsolimit_disk']; ?></td>
              </tr>
              <tr>
                  <td>&nbsp;</td>
                  <td><?php echo $BL->props->lang['Bandwidth']; ?></td>
                  <td><input class='search' size='5' maxlength='20' type='text' name='rslimit_bw' value='<?php if($cmd=="editplan") echo $plan_cpanel_reseller_profile['rslimit_bw']; ?>' /> MB</td>
                  <td>&nbsp;<input type='checkbox' class='search' <?php if($cmd=="editplan" && $plan_cpanel_reseller_profile['rsolimit_bw']==1)echo "checked=\"checked\""; ?> name='rsolimit_bw'  id='rsolimit_bw' value='1' /><?php echo $BL->props->lang['rsolimit_bw']; ?></td>
              </tr>
              </table>
              </td>
           </tr>
           <tr> 
             <td colspan='2'>
             <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
           </tr>             
           <tr><td><b><?php echo $BL->props->lang['edit_ns']; ?></b></td>
             <td><input type='checkbox' name='edit_ns' id='edit_ns' value='1' <?php if($cmd=="editplan" && $plan_cpanel_reseller_profile['edit_ns']==1)echo "checked=\"checked\""; ?> class='search' /></td></tr>
           <tr> 
             <td colspan='2'>
             <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
           </tr>             
           <tr><td><b><?php echo $BL->props->lang['acloptions']; ?></b></td>
             <td></td></tr>
           <tr>
             <td colsspan='2'>
             <table width='100%' cellpadding='0' cellspacing='0' border='0'>
             <?php foreach($BL->cpanelHandler->acl_fields as $k=>$v){ ?>
              <tr>
                  <td>&nbsp;</td>
                  <td><input type='checkbox' class='search' <?php if($cmd=="editplan" && $plan_cpanel_reseller_profile[$k]==1)echo "checked=\"checked\""; ?> name='<?php echo $k; ?>' id='<?php echo $k; ?>' value='1' /></td>
                  <td>&nbsp;&nbsp;<?php echo $BL->props->lang[$k]; ?></td>
              </tr>
             <?php } ?>
             </table>
             </td>
             </tr>
         </table>
        </fieldset>
        </td>
        </tr>
        </tbody>
        </table>
        </fieldset>        
        </td>
        </tr>      
          
        <tr> 
        <td colspan='2' class='text_grey'>&nbsp;</td>
        </tr>
        
        <tr> 
        <td class='text_grey' colspan='2'>
        <fieldset>
        <legend>
        <input type="checkbox" name="plesk_plan" id="plesk_plan" <?php if($cmd=="editplan" && $plan['plesk_profile_id']>0)echo "checked"; ?>  class='search' value="1" onclick="javascript:if(this.checked)toggleTbodyOn('plesk_sec');else toggleTbodyOff('plesk_sec');" />
        <b><?php echo $BL->props->lang['plesk_plan']; ?></b>
        </legend>
        <table width='100%' border='0' cellspacing='0' cellpadding='0' align='center'>
        <tbody name='plesk_sec' id='plesk_sec' class='off'>
        <?php foreach($BL->pleskHandler->permissions as $key=>$value){ ?>
        <tr> 
          <td valign='top' width='29%'>
          <?php echo $BL->props->lang[$key]; ?>
          </td>
          <td>
          <input type='checkbox' class='search' <?php if($cmd=="editplan" && $plan_plesk_profile[$key]==1)echo "checked=\"checked\""; ?> name='<?php echo $key; ?>' value='1' />
          </td>
        </tr>  
        <?php } ?>
        </tbody>
        </table>
        </fieldset>
        </td>
        </tr>
        
        <tr> 
        <td colspan='2' class='text_grey'>&nbsp;</td>
        </tr>
        
        <tr> 
        <td class='text_grey' colspan='2'>
        <fieldset>
        <legend>
        <input type="checkbox" name="da_plan" id="da_plan" <?php if($cmd=="editplan" && $plan['da_reseller']>0)echo "checked"; ?> class='search' value="1" onclick="javascript:if(this.checked)toggleTbodyOn('da_sec');else toggleTbodyOff('da_sec');" />
        <b><?php echo $BL->props->lang['da_plan']; ?></b>
        </legend>
        <table width='100%' border='0' cellspacing='0' cellpadding='0' align='center'>
        <tbody name='da_sec' id='da_sec' class='off'>
        <tr>
        <td>
        <select name='da_reseller' id='da_reseller' class='search'>
        <option value='1' <?php if($cmd=="editplan" && $plan['da_reseller']==1)echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['da_user']; ?></option>
        <option value='2' <?php if($cmd=="editplan" && $plan['da_reseller']==2)echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['da_reseller']; ?></option>
        <option value='3' <?php if($cmd=="editplan" && $plan['da_reseller']==3)echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['da_admin']; ?></option>
        </select>
         </td>
        </tr>
        </tbody>
        </table>
        </fieldset>
        </td>
        </tr>
        
        </table>
        </div>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
        <td class='text_grey' width='1%' ><div align='center'><img src='elements/default/templates/alp_admin/images/spacer.gif' width='32' height='18' /></div></td>
        <td class='text_grey'>
        <div id="form1_label">
        &nbsp;
        </div>
        <div id="form1_field"> 
        <?php if($cmd=="editplan"){ ?>   
        <input type='hidden' name='plesk_profile_id' id='plesk_profile_id' value='<?php echo $plan['plesk_profile_id']; ?>' />        
        <input type='hidden' name='cpr_profile_id' id='cpr_profile_id' value='<?php echo $plan['cpr_profile_id']; ?>' />
        <input type='hidden' name='plan_price_id' id='plan_price_id' value='<?php echo $plan['plan_price_id']; ?>' />
        <?php } ?>
        <input type='hidden' name='cmd' value='<?php echo $cmd; ?>' />
        <input name='submit' type='submit' class='search1' value='<?php if($cmd=="editplan")echo $BL->props->lang['Update'];else echo $BL->props->lang['add']; ?>' />
        </div>
        </td>
        </tr>
        </table>
        </td>
    </tr>
    </table>
    </form>
    <script language="JavaScript" type="text/javascript">
    showTab('tab1', tabs, 't1', t);
    <?php if($cmd=="editplan" && $plan['da_reseller']>0){ ?>
    toggleTbodyOn('da_sec');
    <?php } ?>
    <?php if($cmd=="editplan" && $plan['plesk_profile_id']>0){ ?>
    toggleTbodyOn('plesk_sec');
    <?php } ?>
    <?php if($cmd=="editplan" && $plan['cpr_profile_id']>0){ ?>
    toggleTbodyOn('cpanel_sec');
    <?php } ?>
    </script>
	</div>
</div>
<!--end content -->
<div id="navBar">
<?php include_once $BL->props->get_page("templates/alp_admin/html/_sidepanel.php"); ?>
</div>
<!--end navbar -->
<?php include_once $BL->props->get_page("templates/alp_admin/html/footer.php"); ?>
