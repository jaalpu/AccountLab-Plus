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
      <div class="tabs2" name='tt1' id='tt1' onmouseover="javascript:this.className='tabs1';" onmouseout="javascript:this.className='tabs2';" ><?php echo $BL->props->lang['server_settings']; ?></div>
      <div class="tab_separator">&nbsp;</div>
      <div class="tabs" name='tt2' id='tt2' onmouseover="javascript:this.className='tabs1';" onmouseout="javascript:this.className='tabs';" ><a href="admin.php?cmd=addservers" class="add_link"><?php echo $BL->props->lang['add_server']; ?></a></div>
      <div class="tab_separator">&nbsp;</div>
    </div>
	<div id="display_list">
                <form name='form1' id='form1' method='post' action='<?php echo $PHP_SELF; ?>'>
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list_table">
					<tr> 
                      <td class="tdheading" colspan="2">
					  <b><?php echo $BL->props->lang['def_server']; ?></b> <?php  echo $default_server; ?>
					  </td>
                    </tr>                   
					<tr> 
                      <td class="text_grey" colspan="2">
                      <img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" />
                      </td>
                    </tr>
					  <tr>
                      <td class="text_grey" width="2%">
                      <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
                      </td>
					  <td class='text_grey'>
        				<div id="form1_label">
                            <b><?php echo $BL->props->lang['change_server']; ?>:</b>
                        </div>
                      <div id="form1_field">						
						<select name='server_id' id='server_id' class='search'>
						<?php foreach ($servers as $temp) { ?>
						<option value="<?php echo $temp['server_id']; ?>"><?php echo $temp['server_name']; ?></option>
						<?php } ?>
						</select>
                        </div>
                    </td>
                    </tr>
                    <tr>
                      <td colspan='2' class='text_grey'>
                      <img src="elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg" width="100%" height="1"></td>
                    </tr>
                    <tr>  
                    <td class="text_grey" width="2%">
                    <img src='elements/default/templates/alp_admin/images/spacer.gif' width='32' height='18'>
                    </td> 
                    <td class="text_grey">
                    <div id="form1_field">
                        <input type='hidden' name='action' value='default' />
                        <input type='hidden' name='cmd' value='<?php echo $cmd; ?>' />
                        <input name='submit' type='submit' value='<?php echo $BL->props->lang['submit']; ?>' class='search1' />
                    </div>
                     </td>
                     </tr>
                  </table>
                  </form>
				  <br />	
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list_table">
					<tr> 
                      <td colspan="6" class="text_grey"><img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" /></td>
                    </tr>
		<?php if (!count($servers)) { ?>
				<tr>
					<td class="text_grey" colspan="6">
                    	<div align='center'>
                    	<?php echo $BL->props->lang['no_servers_added']; ?>
                    	</div>
					</td>
				</tr>
		<?php } else { ?>														
                    <tr> 
					  <td class='text_grey' width='5%'></td>
                      <td class='text_grey'><div align='left'><b><a href='<?php echo $PHP_SELF."?cmd=".$cmd."&sort=server_name" ?>'><?php echo $BL->props->lang['server']." ";  echo $BL->props->lang['Name']; ?></a></b></div></td>
                      <td class='text_grey'><div align='left'><b><a href='<?php echo $PHP_SELF."?cmd=".$cmd."&sort=server_ip" ?>'><?php echo $BL->props->lang['server_ip']; ?></a></b> </div></td>
                      <td class='text_grey'><div align='left'><b><a href='<?php echo $PHP_SELF."?cmd=".$cmd."&sort=maximum_accounts" ?>'><?php echo $BL->props->lang['maximum_accounts']; ?></a></b> </div></td>
                      <td class='text_grey'><div align='left'><b><a href='<?php echo $PHP_SELF."?cmd=".$cmd."&sort=current_accounts" ?>'><?php echo $BL->props->lang['current_accounts']; ?></a></b> </div></td>
                      <td width='15%' class='text_grey'><div align='center'><b></b></div></td>
                    </tr>
                    <?php foreach ($servers as $temp) { ?>
					<tr>
                      <td colspan='6' class='text_grey'>
					  <img src="elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg" width="100%" height="1" /></td>
                    </tr>					
                    <tr> 
					  <td class='text_grey'>
						<div align='center'>
						<img src='elements/default/templates/alp_admin/images/<?php echo $temp['server_type']."-icon-small"; ?>.gif' alt='' border='0' /></div>
					  </td>
                      <td class='text_grey'>
						<div align='left'><?php echo $temp['server_name']; ?></div>
					  </td>
                      <td class='text_grey'>
                      <div align='left'><?php echo $temp['server_ip']; ?></div>
                      </td>
                      <td class='text_grey'>
                      <div align='left'><?php echo $temp['maximum_accounts']; ?></div>
                      </td>
                      <td class='text_grey'>
                      <div align='left'><b><?php echo $temp['current_accounts']; ?></b></div>
                      </td>
                      <td class='text_grey'>
                      <div align='right'>
                      <a href='<?php echo $PHP_SELF; ?>?cmd=servers&action=sync&server_id=<?php echo $temp['server_id']; ?>'>
                      <img src='elements/default/templates/alp_admin/images/sync.png' alt='<?php echo $BL->props->lang['sync']; ?>' border='0' /></a>
                      &nbsp;
                      <?php if($BL->getCmd("editserver")){ ?>
                      <a href='<?php echo $PHP_SELF; ?>?cmd=editserver&server_id=<?php echo $temp['server_id']; ?>'>
					  <img src='elements/default/templates/alp_admin/images/edit_all.gif' alt='<?php echo $BL->props->lang['Edit']; ?>' border='0' /></a>
                      &nbsp;
                      <?php } ?>
                      
                      <?php if($BL->getCmd("delserver")){ ?>
                      <a href="javascript:if(confirm('<?php echo $BL->props->lang['Do_you_want_to_delete_this_server']; ?>'))document.location='<?php echo $PHP_SELF; ?>?cmd=delserver&server_id=<?php echo $temp['server_id']; ?>'">
					  <img src='elements/default/templates/alp_admin/images/delete.gif' alt='<?php echo $BL->props->lang['Delete']."?"; ?>' border='0' /></a>
                      &nbsp;
                      <?php } ?>
					  
                      </div>
					  </td>
                    </tr>
                    <?php } } ?>
					<tr> 
                      <td colspan="6" class="text_grey"><img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" /></td>
                    </tr>			
                  </table>
				  <br />
					<table width="100%" border="0" cellspacing="2" cellpadding="2" class="list_table">				
					<tr> 
                      <td class="text_grey" align="center">
                      <img src='elements/default/templates/alp_admin/images/sync.png'  border='0' /> <?php echo $BL->props->lang['sync']; ?>
                      &nbsp;
					  <img src='elements/default/templates/alp_admin/images/edit_all.gif' /> <?php echo $BL->props->lang['Edit']; ?>
					  &nbsp;
					  <img src='elements/default/templates/alp_admin/images/delete.gif' /> <?php echo $BL->props->lang['Delete']; ?>
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
