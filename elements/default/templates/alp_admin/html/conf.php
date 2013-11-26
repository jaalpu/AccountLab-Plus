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
var tabs = ["tab1","tab2","tab3","tab4","tab5"];
var t    = ["t1","t2","t3","t4","t5"];
</script>  
<div id="content">
    <div id="display_list">
      <div class="tabs" name='t2' id='t2' onclick="javascript:showTab('tab2', tabs, 't2', t);" onmouseover="javascript:overTab('t2', t);" onmouseout="javascript:outTab(t);" ><?php echo $BL->props->lang['General']; ?></div>
      <div class="tab_separator">&nbsp;</div>
      <div class="tabs" name='t1' id='t1' onclick="javascript:showTab('tab1', tabs, 't1', t);" onmouseover="javascript:overTab('t1', t);" onmouseout="javascript:outTab(t);" ><?php echo $BL->props->lang['Order_Page']; ?></div>
      <div class="tab_separator">&nbsp;</div>

      <div class="tabs" name='t3' id='t3' onclick="javascript:showTab('tab3', tabs, 't3', t);" onmouseover="javascript:overTab('t3', t);" onmouseout="javascript:outTab(t);" ><?php echo $BL->props->lang['Billing']; ?></div>
      <div class="tab_separator">&nbsp;</div>

      <div class="tabs" name='t5' id='t5' onclick="javascript:showTab('tab5', tabs, 't5', t);" onmouseover="javascript:overTab('t5', t);" onmouseout="javascript:outTab(t);" ><?php echo $BL->props->lang['email_settings']; ?></div>
      <div class="tab_separator">&nbsp;</div>
      <div class="tabs" name='t4' id='t4' onclick="javascript:showTab('tab4', tabs, 't4', t);" onmouseover="javascript:overTab('t4', t);" onmouseout="javascript:outTab(t);" ><?php echo $BL->props->lang['other']; ?></div>
      
    </div>
    <div id="display_list">
	<form name='form1' id='form1' method='POST' action='<?php echo $PHP_SELF; ?>'>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="list_table">
    <tr> 
      <td colspan="2" class="tdheading">
      <b>&nbsp;</b>
      </td>
    </tr>
    <tr> 
      <td colspan="2" class="text_grey"><img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" /></td>
    </tr>
    <tr> 
      <td colspan="2">
    <div id="tab1" name="tab1" class="tabContent" style="display:none">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr> 
        <td class='text_grey'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['Page_title']; ?>
        </div>
        <div id="form1_field">
        <input name='title' type='text' class='search' id='title' value='<?php echo $conf[0]['title']; ?>' size='40' />
        </div>
        </td>
      </tr>
      <tr> 
        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
      </tr>
    
    
    
      <tr> 
        <td class='text_grey' width='1%'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['Title_of_Opening_paragraph']; ?>
        </div>
        <div id="form1_field">
         <input name='order_para_title' type='text' class='search' id='order_para_title' value='<?php echo $conf[0]['order_para_title']; ?>' size='40' />
          </div>
        </td>
      </tr> 
      <tr> 
        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
      </tr>

					  
      <tr> 
        <td class='text_grey' valign="top">
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey' valign="top">
        <div id="form1_label">
        <?php echo $BL->props->lang['Opening_paragraph_on_order_page']; ?>
        </div>
        <div id="form1_field">
        <textarea name='order_para' cols='55' rows='10' id='order_para'><?php echo $conf[0]['order_para']; ?></textarea>
        </div>
        </td>
      </tr>
      <tr> 
        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
      </tr> 
      
      
      
      <tr> 
        <td class='text_grey'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['lang_selector']; ?>
        </div>
        <div id="form1_field">
        <select name='lang_selector' class='search' id='lang_selector'>
        <option value='1' <?php if($conf[0]['lang_selector']=='1') echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['Yes']; ?></option>
        <option value='0' <?php if($conf[0]['lang_selector']=='0') echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['No']; ?></option>
        </select>
        </div>
        </td>
      </tr>
      <tr> 
        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
      </tr> 
      
      
      <tr> 
        <td class='text_grey'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['theme_selector']; ?>
        </div>
        <div id="form1_field">
        <select name='theme_selector' class='search' id='theme_selector'>
        <option value='1' <?php if($conf[0]['theme_selector']=='1') echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['Yes']; ?></option>
        <option value='0' <?php if($conf[0]['theme_selector']=='0') echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['No']; ?></option>
        </select>
        </div>
        </td>
      </tr>
      <tr> 
        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
      </tr> 
      
      
      <tr> 
        <td class='text_grey'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['Display_whois_in_order_script']; ?>
        </div>
        <div id="form1_field">
        <select name='en_whois' class='search' id='en_whois'>
        <option value='1' <?php if($conf[0]['en_whois']=='1') echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['Yes']; ?></option>
        <option value='0' <?php if($conf[0]['en_whois']=='0') echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['No']; ?></option>
        </select>
        </div>
        </td>
      </tr>
      <tr> 
        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
      </tr>	
      <tr> 
        <td class='text_grey'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['Display_subdomain_search_in_order_script']; ?>
        </div>
        <div id="form1_field">
        <select name='en_subdomain' class='search' id='en_subomain'>
        <option value='1' <?php if($conf[0]['en_subdomain']=='1') echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['Yes']; ?></option>
        <option value='0' <?php if($conf[0]['en_subdomain']=='0') echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['No']; ?></option>
        </select>
        </div>
        </td>
      </tr>
      <tr> 
        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
      </tr> 
      
      <tr> 
        <td class='text_grey'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['Display_owndomain_in_order_script']; ?>
        </div>
        <div id="form1_field">
        <select name='en_owndomain' class='search' id='en_owndomain'>
        <option value='1' <?php if($conf[0]['en_owndomain']=='1') echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['Yes']; ?></option>
        <option value='0' <?php if($conf[0]['en_owndomain']=='0') echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['No']; ?></option>
        </select>
        </div>
        </td>
      </tr>
      <tr> 
        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
      </tr> 
      
      <tr> 
        <td class='text_grey'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey'>
		<div id="form1_label">
		<?php echo $BL->props->lang['ask_login_info']; ?>
		</div>
		<div id="form1_field">
        <select name='ask_login_info' class='search' id='ask_login_info'>
        <option value='1' <?php if($conf[0]['ask_login_info']==1) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['Yes']; ?></option>
        <option value='0' <?php if($conf[0]['ask_login_info']==0) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['No']; ?></option>
        </select>
        </div>
        </td>
      </tr>
      <tr> 
        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
      </tr>		
      
      <tr> 
        <td class='text_grey'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['show_loader']; ?>
        </div>
        <div id="form1_field">
        <select name='show_loader' class='search' id='show_loader'>
        <option value='1' <?php if($conf[0]['show_loader']==1) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['Yes']; ?></option>
        <option value='0' <?php if($conf[0]['show_loader']==0) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['No']; ?></option>
        </select>
        </div>
        </td>
      </tr>
      <tr> 
        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
      </tr>     
      
      <tr> 
        <td class='text_grey'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['en_quickpay']; ?>
        </div>
        <div id="form1_field">
        <select name='en_quickpay' class='search' id='en_quickpay'>
        <option value='1' <?php if($conf[0]['en_quickpay']==1) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['Yes']; ?></option>
        <option value='0' <?php if($conf[0]['en_quickpay']==0) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['No']; ?></option>
        </select>
        </div>
        </td>
      </tr>
      <tr> 
        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
      </tr>     
      
      <tr> 
        <td class='text_grey'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['show_price']; ?>
        </div>
        <div id="form1_field">
        <select name='show_price' class='search' id='show_price'>
        <option value='1' <?php if($conf[0]['show_price']==1) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['Yes']; ?></option>
        <option value='0' <?php if($conf[0]['show_price']==0) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['No']; ?></option>
        </select>
        </div>
        </td>
      </tr>
    <tr> 
      <td colspan="2" class="text_grey"><img src="elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg" alt="" width="100%" height="1" /></td>
    </tr>
      			  
	 </table>
    </div>     
    <div id="tab2" name="tab2" class="tabContent" style="display:none">    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr> 
        <td class='text_grey' width='1%'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['Company_Name']; ?>
        </div>
        <div id="form1_field">
            <input name='company_name' type='text' class='search' id='company_name' value='<?php echo $conf[0]['company_name']; ?>' size='30' />
        </div>
        </td>
      </tr>
      <tr> 
        <td colspan='2' class='text_grey'>
        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
        </td>
      </tr>
      <tr> 
        <td class='text_grey' valign="top">
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey' valign="top">
        <div id="form1_label">
        <?php echo $BL->props->lang['Company_Address']; ?>
        </div>
        <div id="form1_field">
         <textarea name='company_address' class='search' cols='30' rows='5'><?php echo $conf[0]['company_address']; ?></textarea>
          </div>
          </td>
      </tr>
      <tr> 
        <td colspan='2' class='text_grey'>
        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
        </td>
      </tr>
      
      <tr> 
        <td class='text_grey'><div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'></div></td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['Terms_URL']; ?>
        </div>
        <div id="form1_field">
        <input name='terms_url' type='text' class='search' id='terms_url' value='<?php echo $conf[0]['terms_url']; ?>' size='40'>
        </div></td>
      </tr>
      <tr> 
        <td colspan='2' class='text_grey'>
        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
        </td>
      </tr>      

      <tr> 
        <td class='text_grey'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['Site_URL']="Site URL"; ?>
        </div>
        <div id="form1_field">
        <input name='path_url' type='text' class='search' id='path_url' value='<?php echo $conf[0]['path_url']; ?>' size='40' />
        </div>
        </td>
      </tr>
      <tr> 
        <td colspan='2' class='text_grey'>
        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
      </tr> 
      <tr> 
        <td class='text_grey'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'></div></td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['Email_Address']; ?>
        </div>
        <div id="form1_field">
        <input name='comp_email' type='text' class='search' id='comp_email' value='<?php echo $conf[0]['comp_email']; ?>' size='30'>    
        </div>
        </td>
      </tr>
      <tr> 
        <td colspan='2' class='text_grey'>
        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
        </td>
      </tr>   
      <tr> 
        <td class='text_grey'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['default_language']; ?>
        </div>
        <div id="form1_field">
        <select name='d_lang' id='d_lang' class='search'>
        <?php foreach ($BL->lang_array as $language) { ?>
        <option value='<?php echo $language; ?>' <?php echo ($language == $conf[0]['d_lang'])?"selected":""; ?>><?php echo ucfirst($language); ?></option>
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
        <td class='text_grey'><div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'></div></td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['default_theme']; ?>
        </div>
        <div id="form1_field">
        <select name='theme' id='theme' class='search'>
        <?php
        $selected_theme = !empty($conf[0]['theme'])?$conf[0]['theme']:"default";
        foreach ($BL->theme_list as $theme){
        $theme_name = str_replace("_", " ",$theme);
        ?>
        <option value='<?php echo $theme; ?>' <?php echo ($selected_theme == $theme)?"selected":""; ?>><?php echo ucfirst($theme_name); ?></option>
        <?php } ?>
        </select>
        </div>
        </td>
      </tr>
      <tr> 
        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
      </tr>
      
      
      <tr> 
        <td class='text_grey'><div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'></div></td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['en_html_editor']; ?>
        </div>
        <div id="form1_field">
        <select name='en_html_editor' id='en_html_editor' class='search'>
        <option value='1' <?php if($conf[0]['en_html_editor']==1) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['Yes']; ?></option>
        <option value='0' <?php if($conf[0]['en_html_editor']==0) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['No']; ?></option>
        </select>
        </div>
        </td>
      </tr>
      <tr> 
        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
      </tr>      
      
      
      <tr> 
        <td class='text_grey'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['Copyright_note']; ?>
        </div>
        <div id="form1_field">
         <input name='cp_note' type='text' class='search' id='cp_note' value='<?php echo $conf[0]['cp_note']; ?>' size='40' />
        </div>
        </td>
      </tr>      
    <tr> 
      <td colspan="2" class="text_grey"><img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" /></td>
    </tr>
    
      <tr> 
        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
      </tr>   
      <tr> 
        <td class='text_grey'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['date_format']; ?>
        </div>
        <div id="form1_field">
         <input name='date_format' type='text' class='search' id='date_format' value='<?php echo $conf[0]['date_format']; ?>' size='15' />
        </div>
        </td>
      </tr>      
    <tr> 
      <td colspan="2" class="text_grey"><img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" /></td>
    </tr>
    
      <tr> 
        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
      </tr>   
      <tr> 
        <td class='text_grey'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['records_per_page']; ?>
        </div>
        <div id="form1_field">
         <input name='records_per_page' type='text' class='search' id='records_per_page' value='<?php echo $conf[0]['records_per_page']; ?>' size='15' />
        </div>
        </td>
      </tr>      
    <tr> 
      <td colspan="2" class="text_grey"><img src="elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg" alt="" width="100%" height="1" /></td>
    </tr>
     </table>
     </div>
     <div id="tab3" name="tab3" class="tabContent" style="display:none">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr> 
        <td class='text_grey' width='1%' valign='top'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey'>
		<div id="form1_label">
		<?php echo $BL->props->lang['u_invoice_date']; ?>
		</div>
		<div id="form1_field">
		<select name='u_invoice_date' id='u_invoice_date' class='search'>
        <option value='0' <?php if(empty($conf[0]['u_invoice_date']))echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['disable_u_inv']; ?></option>
	    <option value='1' <?php if($conf[0]['u_invoice_date']==1)echo "selected=\"selected\""; ?>>1 <?php echo $BL->props->lang['months']; ?></option>
	    <option value='3' <?php if($conf[0]['u_invoice_date']==3)echo "selected=\"selected\""; ?>>3 <?php echo $BL->props->lang['months']; ?></option>
	    <option value='6' <?php if($conf[0]['u_invoice_date']==6)echo "selected=\"selected\""; ?>>6 <?php echo $BL->props->lang['months']; ?></option>
	    <option value='12' <?php if($conf[0]['u_invoice_date']==12)echo "selected=\"selected\""; ?>>12 <?php echo $BL->props->lang['months']; ?></option>
        </select>
          </div></td>
      </tr>
      <tr> 
        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
      </tr>	
	  	       
      <tr> 
        <td class='text_grey' width='1%'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey'>
		<div id="form1_label">
		<?php echo $BL->props->lang['order_start_no']; ?>
		</div>
		<div id="form1_field">
        <input name='order_start_no' type='text' class='search' value='' size='20' />
        </div>
        </td>
      </tr>
      <tr> 
        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
      </tr>
	  
	  
      <tr> 
        <td class='text_grey'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey'>
		<div id="form1_label">
		<?php echo $BL->props->lang['inv_start_no']; ?>
		</div>
		<div id="form1_field">
        <input name='inv_start_no' type='text' class='search' value='' size='20' />
        </div>
        </td>
      </tr>
      <tr> 
        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
      </tr>
	  
	  
      <tr> 
        <td class='text_grey'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey'>
		<div id="form1_label">
		<?php echo $BL->props->lang['order_prefix']; ?>
		</div>
		<div id="form1_field">
        <input name='order_prefix' type='text' class='search' value='<?php echo $conf[0]['order_prefix']; ?>' size='20' />
        </div>
        </td>
      </tr>
      <tr> 
        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
      </tr>
	  
	  
      <tr> 
        <td class='text_grey'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey'>
		<div id="form1_label">
		<?php echo $BL->props->lang['order_suffix']; ?>
		</div>
		<div id="form1_field">
        <input name='order_suffix' type='text' class='search' value='<?php echo $conf[0]['order_suffix']; ?>' size='20' />
        </div>
        </td>
      </tr>
      <tr> 
        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
      </tr>		
	  
	  
      <tr> 
        <td class='text_grey'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey'>
		<div id="form1_label">
		<?php echo $BL->props->lang['invoice_prefix']; ?>
		</div>
		<div id="form1_field">
        <input name='invoice_prefix' type='text' class='search' value='<?php echo $conf[0]['invoice_prefix']; ?>' size='20' />
        </div>
        </td>
      </tr>
      <tr> 
        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
      </tr>		
	  
	  
	  
      <tr> 
        <td class='text_grey'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey'>
		<div id="form1_label">
		<?php echo $BL->props->lang['invoice_suffix']; ?>
		</div>
		<div id="form1_field">
        <input name='invoice_suffix' type='text' class='search' value='<?php echo $conf[0]['invoice_suffix']; ?>' size='20' />
        </div>
        </td>
      </tr>
      <tr> 
        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
      </tr>		    			  
      
	  
	  
      <tr> 
        <td class='text_grey'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey'>
		<div id="form1_label">
		<?php echo $BL->props->lang['send_before_due']; ?>
		</div>
		<div id="form1_field">
        <input name='send_before_due' type='text' class='search' value='<?php echo $conf[0]['send_before_due']; ?>' size='20' />
        </div>
        </td>
      </tr>
      <tr> 
        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
      </tr>
	  
      <tr> 
        <td class='text_grey'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey'>
		<div id="form1_label">
		<?php echo $BL->props->lang['include_sp_rec']; ?>
		</div>
		<div id="form1_field">
            <select name='include_sp_rec' class='search' id='include_sp_rec'>
              <option value='1' <?php if($conf[0]['include_sp_rec']==1) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['Yes']; ?></option>
            <option value='0' <?php if($conf[0]['include_sp_rec']==0) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['No']; ?></option>
          </select>
          </div></td>
      </tr>
	<tr> 
      <td colspan="2" class="text_grey"><img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" /></td>
    </tr>
      <tr> 
        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
      </tr>
      <tr> 
        <td class='text_grey' valign='top'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['suspend_after_due']; ?>
        </div>
        <div id="form1_field">
            <input name='suspend_after_due' type='text' class='search' value='<?php echo $conf[0]['suspend_after_due']; ?>' size='20' />
          </div></td>
      </tr>
      
      <tr> 
        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
      </tr>
      
      <tr> 
        <td class='text_grey'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['send_pending_invoice_everyday']; ?>
        </div>
        <div id="form1_field">
            <select name='send_pending_invoice_everyday' class='search' id='send_pending_invoice_everyday'>
              <option value='1' <?php if($conf[0]['send_pending_invoice_everyday']==1) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['Yes']; ?></option>
            <option value='0' <?php if($conf[0]['send_pending_invoice_everyday']==0) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['No']; ?></option>
          </select>
          </div></td>
      </tr>
    <tr> 
      <td colspan="2" class="text_grey"><img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" /></td>
    </tr>
    
    
      <tr> 
        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
      </tr>
    
      <tr> 
        <td class='text_grey'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['en_prorate']; ?>
        </div>
        <div id="form1_field">
            <select name='en_prorate' class='search' id='en_prorate'>
              <option value='1' <?php if($conf[0]['en_prorate']==1) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['Yes']; ?></option>
            <option value='0' <?php if($conf[0]['en_prorate']==0) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['No']; ?></option>
          </select>
          </div></td>
      </tr>
    <tr> 
      <td colspan="2" class="text_grey"><img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" /></td>
    </tr>
      <tr> 
        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
      </tr>
      <tr> 
        <td class='text_grey'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey'>
        <div id="form1_label">
        <?php echo $BL->props->lang['prorate_date']; ?>
        </div>
        <div id="form1_field">
            <select name='prorate_date' class='search' id='prorate_date'>
            <?php for($i=1;$i<=28;$i++){ ?>
              <option value='<?php echo $i; ?>' <?php if($conf[0]['prorate_date']==$i) echo "selected=\"selected\""; ?>><?php echo $i; ?></option>
            <?php } ?>
          </select>
          </div></td>
      </tr>
    <tr> 
      <td colspan="2" class="text_grey"><img src="elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg" alt="" width="100%" height="1" /></td>
    </tr>
    
	 </table>
     </div>
     <div id="tab4" name="tab4" class="tabContent" style="display:none">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr> 
        <td class='text_grey' width='1%'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey'>
		<div id="form1_label">
		<?php echo $BL->props->lang['Absolute_path']; ?>
		</div>
		<div id="form1_field">
            <input name='path_abs' type='text' class='search' id='path_abs' value='<?php echo $conf[0]['path_abs']; ?>' size='40' />
          </div></td>
      </tr>
      <tr> 
        <td colspan='2' class='text_grey'>
		<img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
      </tr>	  

      <tr> 
        <td class='text_grey' valign="top">
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey' valign="top">
		<div id="form1_label">
		<?php echo $BL->props->lang['metatags']; ?>
		</div>
		<div id="form1_field">
            <textarea name='metatags' cols='37' rows='10' class='search' id='metatags'><?php echo $conf[0]['metatags']; ?></textarea>
          </div>
		</td>
      </tr>
    <tr> 
      <td colspan="2" class="text_grey"><img src="elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg" alt="" width="100%" height="1" /></td>
    </tr>
	 </table>     
     </div>
     
     
     <div id="tab5" name="tab5" class="tabContent" style="display:none">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr> 
        <td class='text_grey' valign="top" width='1%'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey' valign="top">
        <div id="form1_label">
        <?php echo $BL->props->lang['auto_email']; ?>
        </div>
        <div id="form1_field">
          <select name='en_automail' class='search' id='en_automail'>
              <option value='1' <?php if($conf[0]['en_automail']==1) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['Yes']; ?></option>
            <option value='0' <?php if($conf[0]['en_automail']==0) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['No']; ?></option>
          </select>
          </div></td>
      </tr>    
    <tr> 
      <td colspan="2" class="text_grey"><img src="elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg" alt="" width="100%" height="1" /></td>
    </tr>
      <tr> 
        <td class='text_grey' valign="top" width='1%'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey' valign="top">
        <div id="form1_label">
        <?php echo $BL->props->lang['emailer']; ?>
        </div>
        <div id="form1_field">
          <select name='emailer' class='search' id='emailer' onchange="javascript:if(this.value=='smtp'){toggleTbodyOn('smtp_param');toggleTbodyOff('sendmail_param');} if(this.value=='sendmail'){toggleTbodyOff('smtp_param');toggleTbodyOn('sendmail_param');} if(this.value=='mail') {toggleTbodyOff('smtp_param');toggleTbodyOff('sendmail_param');}">
            <option value='mail' <?php if($conf[0]['emailer']=='mail' || empty($conf[0]['emailer'])) echo "selected=\"selected\""; ?>>mail</option>
            <option value='sendmail' <?php if($conf[0]['emailer']=='sendmail') echo "selected=\"selected\""; ?>>sendmail</option>
            <option value='smtp' <?php if($conf[0]['emailer']=='smtp') echo "selected=\"selected\""; ?>>smtp</option>
          </select>
          </div></td>
      </tr>
    <tr> 
      <td colspan="2" class="text_grey"><img src="elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg" alt="" width="100%" height="1" /></td>
    </tr>
      <tr> 
        <td class='text_grey' valign="top" width='1%'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey' valign="top">
        <div id="form1_label">
        <?php echo $BL->props->lang['email_priority']; ?>
        </div>
        <div id="form1_field">
          <select name='email_priority' class='search' id='email_priority'>
            <option value='1' <?php if($conf[0]['email_priority']==1) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['High']; ?></option>
            <option value='3' <?php if($conf[0]['email_priority']==3) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['Normal']; ?></option>
            <option value='5' <?php if($conf[0]['email_priority']==5) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['Low']; ?></option>
          </select>
          </div></td>
      </tr>    
    <tr> 
      <td colspan="2" class="text_grey"><img src="elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg" alt="" width="100%" height="1" /></td>
    </tr>
    
    
      <tr> 
        <td class='text_grey' valign="top" width='1%'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey' valign="top">
        <div id="form1_label">
        <?php echo $BL->props->lang['email_charset']; ?>
        </div>
        <div id="form1_field">
        <input type="text" name="email_charset" id="email_charset" class='search' value="<?php echo $conf[0]['email_charset']; ?>" size="15" />  
        </div></td>
      </tr>    
    <tr> 
      <td colspan="2" class="text_grey"><img src="elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg" alt="" width="100%" height="1" /></td>
    </tr>
    
      <tr> 
        <td class='text_grey' valign="top" width='1%'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey' valign="top">
        <div id="form1_label">
        <?php echo $BL->props->lang['email_content_type']; ?>
        </div>
        <div id="form1_field">
        <input type="text" name="email_content_type" id="email_content_type" class='search' value="<?php echo $conf[0]['email_content_type']; ?>" size="15" />  
        </div></td>
      </tr>    
    <tr> 
      <td colspan="2" class="text_grey"><img src="elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg" alt="" width="100%" height="1" /></td>
    </tr>
      <tr> 
        <td class='text_grey' valign="top" width='1%'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey' valign="top">
        <div id="form1_label">
        <?php echo $BL->props->lang['email_encoding']; ?>
        </div>
        <div id="form1_field">
          <select name='email_encoding' class='search' id='email_encoding'>
            <option value='8bit' <?php if($conf[0]['email_encoding']=='8bit') echo "selected=\"selected\""; ?>>8bit</option>
            <option value='7bit' <?php if($conf[0]['email_encoding']=='7bit') echo "selected=\"selected\""; ?>>7bit</option>
            <option value='binary' <?php if($conf[0]['email_encoding']=='binary') echo "selected=\"selected\""; ?>>binary</option>
            <option value='base64' <?php if($conf[0]['email_encoding']=='base64') echo "selected=\"selected\""; ?>>base64</option>
            <option value='quoted-printable' <?php if($conf[0]['email_encoding']=='quoted-printable') echo "selected=\"selected\""; ?>>quoted-printable</option>
          </select>
          </div></td>
      </tr>    
    <tr> 
      <td colspan="2" class="text_grey"><img src="elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg" alt="" width="100%" height="1" /></td>
    </tr>
      <tr> 
        <td class='text_grey' valign="top" width='1%'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey' valign="top">
        <div id="form1_label">
        <?php echo $BL->props->lang['email_wordwrap']; ?>
        </div>
        <div id="form1_field">
        <input type="text" name="email_wordwrap" id="email_wordwrap" class='search' value="<?php echo $conf[0]['email_wordwrap']; ?>" size="15" />  
        </div></td>
      </tr>   
      
    <!--   
    <tr> 
      <td colspan="2" class="text_grey"><img src="elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg" alt="" width="100%" height="1" /></td>
    </tr>
      <tr> 
        <td class='text_grey' valign="top" width='1%'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey' valign="top">
        <div id="form1_label">
        <?php echo $BL->props->lang['email_sender']; ?>
        </div>
        <div id="form1_field">
        <input type="text" name="email_sender" id="email_sender" class='search' value="<?php echo $conf[0]['email_sender']; ?>" size="40" />  
        </div></td>
      </tr>    
    <tr> 
      <td colspan="2" class="text_grey"><img src="elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg" alt="" width="100%" height="1" /></td>
    </tr>
    //-->
    
      <tr> 
        <td class='text_grey' valign="top" width='1%'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey' valign="top">
        <div id="form1_label">
        <?php echo $BL->props->lang['reading_confirm']; ?>
        </div>
        <div id="form1_field">
        <input type="text" name="reading_confirm" id="reading_confirm" class='search' value="<?php echo $conf[0]['reading_confirm']; ?>" size="40" />  
        </div></td>
      </tr>    
    <tr> 
      <td colspan="2" class="text_grey"><img src="elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg" alt="" width="100%" height="1" /></td>
    </tr>
    <tbody id='sendmail_param'>
      <tr> 
        <td class='text_grey' valign="top" width='1%'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey' valign="top">
        <div id="form1_label">
        <?php echo $BL->props->lang['sendmail_path']; ?>
        </div>
        <div id="form1_field">
        <input type="text" name="sendmail_path" id="sendmail_path" class='search' value="<?php echo $conf[0]['sendmail_path']; ?>" size="40" />  
        </div></td>
      </tr>    
    <tr> 
      <td colspan="2" class="text_grey"><img src="elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg" alt="" width="100%" height="1" /></td>
    </tr>
    </tbody>
    <tbody id='smtp_param'>
      <tr> 
        <td class='text_grey' valign="top" width='1%'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey' valign="top">
        <div id="form1_label">
        <?php echo $BL->props->lang['smtp_host']; ?>
        </div>
        <div id="form1_field">
        <input type="text" name="smtp_host" id="smtp_host" class='search' value="<?php echo $conf[0]['smtp_host']; ?>" size="40" />  
        </div></td>
      </tr>    
    <tr> 
      <td colspan="2" class="text_grey"><img src="elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg" alt="" width="100%" height="1" /></td>
    </tr>
    
      <tr> 
        <td class='text_grey' valign="top" width='1%'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey' valign="top">
        <div id="form1_label">
        <?php echo $BL->props->lang['smtp_port']; ?>
        </div>
        <div id="form1_field">
        <input type="text" name="smtp_port" id="smtp_port" class='search' value="<?php echo $conf[0]['smtp_port']; ?>" size="15" />  
        </div></td>
      </tr>    
    <tr> 
      <td colspan="2" class="text_grey"><img src="elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg" alt="" width="100%" height="1" /></td>
    </tr>
    
      <tr> 
        <td class='text_grey' valign="top" width='1%'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey' valign="top">
        <div id="form1_label">
        <?php echo $BL->props->lang['smtp_auth']; ?>
        </div>
        <div id="form1_field">
          <select name='smtp_auth' class='search' id='smtp_auth'>
            <option value='0' <?php if($conf[0]['smtp_auth']=='0') echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['No']; ?></option>
            <option value='1' <?php if($conf[0]['smtp_auth']=='1') echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['Yes']; ?></option>
            </select>
          </div></td>
      </tr>    
    <tr> 
      <td colspan="2" class="text_grey"><img src="elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg" alt="" width="100%" height="1" /></td>
    </tr>
      <tr> 
        <td class='text_grey' valign="top" width='1%'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey' valign="top">
        <div id="form1_label">
        <?php echo $BL->props->lang['smtp_user']; ?>
        </div>
        <div id="form1_field">
        <input type="text" name="smtp_user" id="smtp_user" class='search' value="<?php echo $conf[0]['smtp_user']; ?>" size="40" />  
        </div></td>
      </tr>    
    <tr> 
      <td colspan="2" class="text_grey"><img src="elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg" alt="" width="100%" height="1" /></td>
    </tr>
    
      <tr> 
        <td class='text_grey' valign="top" width='1%'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey' valign="top">
        <div id="form1_label">
        <?php echo $BL->props->lang['smtp_pass']; ?>
        </div>
        <div id="form1_field">
        <input type="password" name="smtp_pass" id="smtp_pass" class='search' value="<?php echo $conf[0]['smtp_pass']; ?>" size="40" />  
        </div></td>
      </tr>    
    <tr> 
      <td colspan="2" class="text_grey"><img src="elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg" alt="" width="100%" height="1" /></td>
    </tr>

    </tbody>
     </table>     
     </div>
     <div>
     
     
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr> 
        <td class='text_grey' valign="top" width='1%'>
        <div align='center'>
        <img src='elements/default/templates/alp_admin/images/spacer.gif' width='32' height='18'>
        </div>
        </td>
        <td class='text_grey' valign="top">
        <div id="form1_label">
        
        </div>
        <div id="form1_field">
            <input type='hidden' name='cmd' value='<?php echo $cmd; ?>' />
            <input name='submit' type='submit' class='search1' value='<?php echo $BL->props->lang['Update']; ?>' />
          </div>
          </td>
      </tr>    
    <tr> 
      <td colspan="2" class="text_grey"><img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" /></td>
    </tr>
    </table>
     </div>
     </td>
     </tr>
	<tr> 
      <td colspan="2" class="text_grey"><img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" /></td>
    </tr>             
    </table>
</form>
	</div>
</div>
<script language="JavaScript" type="text/javascript">
  showTab('tab2', tabs, 't2', t);
</script>
<?php if($conf[0]['emailer']=='mail' || empty($conf[0]['emailer'])){ ?>
<script language="JavaScript" type="text/javascript">toggleTbodyOff('smtp_param');toggleTbodyOff('sendmail_param');</script>  
<?php }elseif($conf[0]['emailer']=='sendmail'){ ?>
<script language="JavaScript" type="text/javascript">toggleTbodyOff('smtp_param');toggleTbodyOn('sendmail_param');</script>  
<?php }else{ ?>
<script language="JavaScript" type="text/javascript">toggleTbodyOn('smtp_param');toggleTbodyOff('sendmail_param');</script>  
<?php } ?>
<!--end content -->
<div id="navBar">
<?php include_once $BL->props->get_page("templates/alp_admin/html/_sidepanel.php"); ?>
</div>
<!--end navbar -->
<?php include_once $BL->props->get_page("templates/alp_admin/html/footer.php"); ?>
