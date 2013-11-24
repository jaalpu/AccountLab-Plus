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
<div id="content">
    <div id="display_list">
      <div class="tabs" name='tt1' id='tt1' onmouseover="javascript:this.className='tabs1';" onmouseout="javascript:this.className='tabs';" ><a href="admin.php?cmd=servers" class="add_link"><?php echo $BL->props->lang['server_settings']; ?></a></div>
      <div class="tab_separator">&nbsp;</div>
      <div class="tabs2" name='tt2' id='tt2' onmouseover="javascript:this.className='tabs1';" onmouseout="javascript:this.className='tabs2';" ><?php echo $title; ?></div>
      <div class="tab_separator">&nbsp;</div>
    </div>
	<div id="display_list">
				
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list_table">
					<tr> 
                      <td colspan="2" class="tdheading">
					  <b>&nbsp;</b>
					  </td>
                    </tr>
					<tr> 
                      <td colspan="2" class="text_grey">
					  <img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" /></td>
                    </tr>
				<tr>
					<td class="text_grey" colspan="2">
					<form name='form1' id='form1' method='POST' action='<?php echo $PHP_SELF; ?>'>
					<table width='100%' border='0' cellspacing='0' cellpadding='0'>
		    			<tr> 
                        <td class='text_grey' width='1%'>
						<div align='center'>
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
						</div>
                        </td>
                        <td class='text_grey'>
						<div id="form1_label">
						<?php echo $BL->props->lang['Server_Name']; ?>
						</div>
						<div id="form1_field">
                            <input name='server_name' type='text' class='search' id='server_name' size='20' value='<?php if($cmd=="editserver") echo $server['server_name']; ?>' />
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
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                        </div>
                        </td>
                        <td class='text_grey'>
						<div id="form1_label">
						<?php echo $BL->props->lang['server']." ".$BL->props->lang['IP']; ?>
							</div>
							<div id="form1_field">
                            <input name='server_ip' type='text' class='search' id='server_ip' size='20' value='<?php if($cmd=="editserver")echo $server['server_ip']; ?>' />
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
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                        </div>
                        </td>
                        <td class='text_grey' valign="top">
                        <div id="form1_label">
                        <?php echo $BL->props->lang['additional_ips']; ?>
                        </div>
                        <div id="form1_field">
                         <textarea name='additional_ips' cols='40' rows='3' class='search' id='additional_ips' wrap><?php if($cmd=="editserver")echo $additional_ips; ?></textarea>
                          </div>
                          </td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
                      </tr>
                      
                      <tr> 
                        <td class='text_grey'>
                        <div align='center'>
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                        </div>
                        </td>
                        <td class='text_grey'>
						<div id="form1_label">
						<?php echo $BL->props->lang['ns1']; ?>
						</div>
						<div id="form1_field">
                         <input name='name_server_1' type='text' class='search' id='name_server_1' size='20' value='<?php if($cmd=="editserver")echo $server['name_server_1']; ?>' />
                          </div>
                          </td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
                      </tr>
					  
                      <tr> 
                        <td class='text_grey'>
                        <div align='center'>
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                        </div>
                        </td>
                        <td class='text_grey'>
						<div id="form1_label">
						<?php echo $BL->props->lang['ns2']; ?>
						</div>
						<div id="form1_field">
                         <input name='name_server_2' type='text' class='search' id='name_server_2' size='20' value='<?php if($cmd=="editserver")echo $server['name_server_2']; ?>' />
                          </div>
                          </td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
                      </tr>  
					  
                      <tr> 
                        <td class='text_grey'>
                        <div align='center'>
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                        </div>
                        </td>
                        <td class='text_grey'>
						<div id="form1_label">
						<?php echo $BL->props->lang['Server_Type']; ?>
						</div>
						<div id="form1_field">
                         <select name='server_type' class='search' id='server_type' onchange="javascript:if(this.value=='cpanel')toggleTbodyOn('hash');else toggleTbodyOff('hash');">
                            <option value='other' <?php if($cmd=="editserver"){if($server['server_type']=='other') echo "selected=\"selected\"";} ?>><?php echo $BL->props->lang['other']; ?></option>
    						<?php
    						foreach ($BL->cp as $key => $val)
    						{
    						?>
    						<option value='<?php echo $val; ?>' <?php if($cmd=="editserver"){if($server['server_type']==$val) echo "selected=\"selected\"";} ?>><?php echo $val; ?></option>
    						<?php
    						}
    						?>
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
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                        </div>
                        </td>
                        <td class='text_grey'>
                        <div id="form1_label">
                        <?php echo $BL->props->lang['username_min_length']; ?>
                        </div>
                        <div id="form1_field">
                         <input name='username_min_length' type='text' class='search' id='username_min_length' size='5' value='<?php if($cmd=="editserver")echo $server['username_min_length'];else echo "5"; ?>' />
                          </div>
                          </td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
                      </tr>
	
                                    
                      <tr> 
                        <td class='text_grey'>
                        <div align='center'>
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                        </div>
                        </td>
                        <td class='text_grey'>
                        <div id="form1_label">
                        <?php echo $BL->props->lang['username_max_length']; ?>
                        </div>
                        <div id="form1_field">
                         <input name='username_max_length' type='text' class='search' id='username_max_length' size='5' value='<?php if($cmd=="editserver")echo $server['username_max_length'];else echo "8"; ?>' />
                          </div>
                          </td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
                      </tr>
        	  

                      <tr> 
                        <td class='text_grey'>
                        <div align='center'>
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                        </div>
                        </td>
                        <td class='text_grey'>
						<div id="form1_label">
						<?php echo $BL->props->lang['Server_User']; ?>
						</div>
						<div id="form1_field">
                         <input name='server_user' type='text' class='search' id='server_user' size='20' value='<?php if($cmd=="editserver")echo $server['server_user']; ?>' />
                          </div>
                          </td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
                      </tr>
                      
                      
                      <tr> 
                        <td class='text_grey'>
                        <div align='center'>
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                        </div>
                        </td>
                        <td class='text_grey'>
                        <div id="form1_label">
                        <?php echo $BL->props->lang['Server_Pass']; ?>
                        </div>
                        <div id="form1_field">
                         <input name='server_pass' type='password' class='search' id='server_pass' size='20' value='<?php if($cmd=="editserver")echo $BL->utils->alpencrypt->decrypt($server['server_pass'], $BL->props->encryptionKey); ?>' />
                          </div>
                          </td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
                      </tr> 
                      <tbody id='hash' name='hash'>
                      <tr> 
                        <td class='text_grey' valign="top">
                        <div align='center'>
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                        </div>
                        </td>
                        <td class='text_grey' valign="top">
						<div id="form1_label">
						<?php echo $BL->props->lang['server_hash_only_whm']; ?>
						</div>
						<div id="form1_field">
                         <textarea name='server_hash' cols='40' rows='15' class='search' id='server_hash' wrap><?php if($cmd=="editserver")echo $BL->utils->alpencrypt->decrypt($server['server_hash'], $BL->props->encryptionKey); ?></textarea>
                          </div>
                          </td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
                      </tr>
					  </tbody>
					  <?php if($cmd!="editserver" || $server['server_type']!='cpanel'){ ?>
                        <script language="JavaScript" type="text/javascript">
                            toggleTbodyOff('hash');
                        </script>
                      <?php } ?>
                      <tr> 
                        <td class='text_grey' valign="top">
                        <div align='center'>
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                        </div>
                        </td>
                        <td class='text_grey' valign="top">
						<div id="form1_label">
						<?php echo $BL->props->lang['Server_Auto']; ?>
						</div>
						<div id="form1_field">
                        <select name='server_auto' class='search' id='server_auto'>
                            <option value='yes' <?php if($cmd=="editserver"){if($server['server_auto']=="yes") echo "selected=\"selected\"";} ?>><?php echo $BL->props->lang['Yes']; ?></option>
                            <option value='no' <?php if($cmd=="editserver"){if($server['server_auto']=="no") echo "selected=\"selected\"";} ?>><?php echo $BL->props->lang['No']; ?></option>
                          </select>
                          </div>
                          </td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
                      </tr>	
					  
					  
                      <tr> 
                        <td class='text_grey' valign="top">
                        <div align='center'>
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                        </div>
                        </td>
                        <td class='text_grey' valign="top">
						<div id="form1_label">
						<?php echo $BL->props->lang['Server_SSL']; ?>
						</div>
						<div id="form1_field">
                        <select name='server_ssl' class='search' id='server_ssl'>
                            <option value='no' <?php if($cmd=="editserver"){if($server['server_ssl']=="no") echo "selected=\"selected\"";} ?>><?php echo $BL->props->lang['No']; ?></option>
                            <option value='yes' <?php if($cmd=="editserver"){if($server['server_ssl']=="yes") echo "selected=\"selected\"";} ?>><?php echo $BL->props->lang['Yes']; ?></option>
                          </select>
                          </div>
                          </td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
                      </tr>
                      
                      
                      <tr> 
                        <td class='text_grey' valign="top">
                        <div align='center'>
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                        </div>
                        </td>
                        <td class='text_grey' valign="top">
                        <div id="form1_label">
                        <?php echo $BL->props->lang['maximum_accounts']; ?>
                        </div>
                        <div id="form1_field">
                        <input name='maximum_accounts' type='text' class='search' id='maximum_accounts' size='5' value='<?php if($cmd=="editserver")echo $server['maximum_accounts'];else echo 0; ?>' />
                        </div>
                        </td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
                      </tr>
                      
                      
                      <tr> 
                        <td class='text_grey' valign="top">
                        <div align='center'>
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                        </div>
                        </td>
                        <td class='text_grey' valign="top">
                        <div id="form1_label">
                        <?php echo $BL->props->lang['current_accounts']; ?>
                        </div>
                        <div id="form1_field">
                        <input name='current_accounts' type='text' class='search' id='current_accounts' size='5' value='<?php if($cmd=="editserver")echo $server['current_accounts'];else echo 0; ?>' />
                        </div>
                        </td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
                      </tr>                      
                      
                      
                      <tr> 
                        <td class='text_grey' valign="top">
                        <div align='center'>
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                        </div>
                        </td>
                        <td class='text_grey' valign="top">
                        <div id="form1_label">
                        <?php echo $BL->props->lang['Monitor_httpd']; ?>
                        </div>
                        <div id="form1_field">
                        <select name='httpd_port_yn' class='search' id='server_ssl'>
                            <option value='1' <?php if($cmd=="editserver"){if($server['httpd_port_yn']==1) echo "selected=\"selected\"";} ?>><?php echo $BL->props->lang['Yes']; ?></option>
                            <option value='0' <?php if($cmd=="editserver"){if($server['httpd_port_yn']==0) echo "selected=\"selected\"";} ?>><?php echo $BL->props->lang['No']; ?></option>
                          </select>&nbsp;
                          <?php echo $BL->props->lang['port_no']; ?>&nbsp;:&nbsp;<input type='text' size='5' class='search' name='httpd_port' value='<?php if($cmd=="editserver")echo $server['httpd_port'];else echo "80"; ?>' />
                          </div>
                          </td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
                      </tr>    
                      
                      
                      
                      <tr> 
                        <td class='text_grey' valign="top">
                        <div align='center'>
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                        </div>
                        </td>
                        <td class='text_grey' valign="top">
                        <div id="form1_label">
                        <?php echo $BL->props->lang['Monitor_smtp']; ?>
                        </div>
                        <div id="form1_field">
                        <select name='smtp_port_yn' class='search' id='server_ssl'>
                            <option value='1' <?php if($cmd=="editserver"){if($server['smtp_port_yn']==1) echo "selected=\"selected\"";} ?>><?php echo $BL->props->lang['Yes']; ?></option>
                            <option value='0' <?php if($cmd=="editserver"){if($server['smtp_port_yn']==0) echo "selected=\"selected\"";} ?>><?php echo $BL->props->lang['No']; ?></option>
                          </select>&nbsp;
                          <?php echo $BL->props->lang['port_no']; ?>&nbsp;:&nbsp;<input type='text' size='5' class='search' name='smtp_port' value='<?php if($cmd=="editserver")echo $server['smtp_port'];else echo "25"; ?>' />
                          </div>
                          </td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
                      </tr> 
                      
                      
                      
                      <tr> 
                        <td class='text_grey' valign="top">
                        <div align='center'>
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                        </div>
                        </td>
                        <td class='text_grey' valign="top">
                        <div id="form1_label">
                        <?php echo $BL->props->lang['Monitor_ftp']; ?>
                        </div>
                        <div id="form1_field">
                        <select name='ftp_port_yn' class='search' id='server_ssl'>
                            <option value='1' <?php if($cmd=="editserver"){if($server['ftp_port_yn']==1) echo "selected=\"selected\"";} ?>><?php echo $BL->props->lang['Yes']; ?></option>
                            <option value='0' <?php if($cmd=="editserver"){if($server['ftp_port_yn']==0) echo "selected=\"selected\"";} ?>><?php echo $BL->props->lang['No']; ?></option>
                          </select>&nbsp;
                          <?php echo $BL->props->lang['port_no']; ?>&nbsp;:&nbsp;<input type='text' size='5' class='search' name='ftp_port' value='<?php if($cmd=="editserver")echo $server['ftp_port'];else echo "21"; ?>' />
                          </div>
                          </td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
                      </tr>                       
                      
                      
                      <tr> 
                        <td class='text_grey' valign="top">
                        <div align='center'>
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                        </div>
                        </td>
                        <td class='text_grey' valign="top">
                        <div id="form1_label">
                        <?php echo $BL->props->lang['Monitor_pop3']; ?>
                        </div>
                        <div id="form1_field">
                        <select name='pop3_port_yn' class='search' id='server_ssl'>
                            <option value='1' <?php if($cmd=="editserver"){if($server['pop3_port_yn']==1) echo "selected=\"selected\"";} ?>><?php echo $BL->props->lang['Yes']; ?></option>
                            <option value='0' <?php if($cmd=="editserver"){if($server['pop3_port_yn']==0) echo "selected=\"selected\"";} ?>><?php echo $BL->props->lang['No']; ?></option>
                          </select>&nbsp;
                          <?php echo $BL->props->lang['port_no']; ?>&nbsp;:&nbsp;<input type='text' size='5' class='search' name='pop3_port' value='<?php if($cmd=="editserver")echo $server['pop3_port'];else echo "110"; ?>' />
                          </div>
                          </td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
                      </tr>                           
                      
                      
                      <tr> 
                        <td class='text_grey' valign="top">
                        <div align='center'>
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                        </div>
                        </td>
                        <td class='text_grey' valign="top">
                        <div id="form1_label">
                        <?php echo $BL->props->lang['Monitor_mysql']; ?>
                        </div>
                        <div id="form1_field">
                        <select name='mysql_port_yn' class='search' id='server_ssl'>
                            <option value='1' <?php if($cmd=="editserver"){if($server['mysql_port_yn']==1) echo "selected=\"selected\"";} ?>><?php echo $BL->props->lang['Yes']; ?></option>
                            <option value='0' <?php if($cmd=="editserver"){if($server['mysql_port_yn']==0) echo "selected=\"selected\"";} ?>><?php echo $BL->props->lang['No']; ?></option>
                          </select>&nbsp;
                          <?php echo $BL->props->lang['port_no']; ?>&nbsp;:&nbsp;<input type='text' size='5' class='search' name='mysql_port' value='<?php if($cmd=="editserver")echo $server['mysql_port'];else echo "3306"; ?>' />
                          </div>
                          </td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
                      </tr> 
                      
                      
                                           
                      <tr> 
                        <td class='text_grey'><div align='center'></div></td>
                        <td class='text_grey'>
						<div id="form1_label">
						&nbsp;
						</div>
						<div id="form1_field">
                          <?php if($cmd=="editserver"){ ?>
                          <input name='server_id' type='hidden' value='<?php echo $server['server_id']; ?>' />
                          <?php } ?>
                          <input type='hidden' name='cmd' value='<?php echo $cmd; ?>' />
                          <input name='submit' type='submit' class='search1' value='<?php if($cmd=="editserver")echo $BL->props->lang['Update'];else echo $BL->props->lang['add']; ?>' />
                          </div></td>
                      </tr>
                    </table>
				  </form>
					</td>
				</tr>		
                  </table>
	</div>
</div>
<!--end content -->
<div id="navBar">
<?php include_once $BL->props->get_page("templates/alp_admin/html/_sidepanel.php"); ?>
</div>
<!--end navbar -->
<?php include_once $BL->props->get_page("templates/alp_admin/html/footer.php"); ?>
