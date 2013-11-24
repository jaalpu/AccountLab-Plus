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
      <div class="tabs" name='t1' id='t1' onmouseover="javascript:this.className='tabs1';" onmouseout="javascript:this.className='tabs';" ><a href="admin.php?cmd=groups" class="add_link"><?php echo $BL->props->lang['~groups']; ?></a></div>
      <div class="tab_separator">&nbsp;</div>
      <div class="tabs2" name='t2' id='t2' onmouseover="javascript:this.className='tabs1';" onmouseout="javascript:this.className='tabs2';" ><?php echo $title; ?></div>
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
                      <td colspan="2" class="text_grey"><img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" /></td>
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
						<?php echo $BL->props->lang['group_name']; ?>
						</div>
						<div id="form1_field">
                            <input type='text' name='group_name' class='search' size='40' value='<?php if($cmd=="edit_group")echo $group['group_name']; ?>' />
						</div>
						</td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'>
                        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                        </td>
                      </tr>
                      <tr> 
                        <td class='text_grey' valign='top'>
                        <div align='center'>
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                        </div>
                        </td>
                        <td class='text_grey' valign='top'>
						<div id="form1_label">
						<?php echo $BL->props->lang['group_desc']; ?>
							</div>
							<div id="form1_field">
                            <textarea name='group_desc' cols='55' rows='10'><?php if($cmd=="edit_group")echo $group['group_desc']; ?></textarea>
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
						<?php echo $BL->props->lang['group_require_domain']; ?>
						</div>
						<div id="form1_field">
                         <select name='group_require_domain' class='search'>
						<option value='1' <?php if($cmd=="edit_group" && $group['group_require_domain']==1)echo "selected=\"selected\""; ?>><?php echo  $BL->props->lang['Yes']; ?></option>
						<option value='0' <?php if($cmd=="edit_group" && $group['group_require_domain']==0)echo "selected=\"selected\""; ?>><?php echo  $BL->props->lang['No']; ?></option>
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
                        <td class='text_grey'>
                        <div align='center'>
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                        </div>
                        </td>
                        <td class='text_grey'>
						<div id="form1_label">
						<?php echo $BL->props->lang['show_in_order_page']; ?>
						</div>
						<div id="form1_field">
                        <select name='group_active' class='search'>                           
						<option value='0' <?php if($cmd=="edit_group" && $group['group_active']==0)echo "selected=\"selected\""; ?>><?php echo  $BL->props->lang['No']; ?></option>						
						<option value='1' <?php if($cmd=="edit_group" && $group['group_active']==1 || $cmd == "add_group")echo "selected=\"selected\""; ?>><?php echo  $BL->props->lang['Yes']; ?></option>
                        </select>
                          </div></td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'>
                        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                        </td>
                      </tr>


                      <tr> 
                        <td class='text_grey' valign="top"><div align='center'>
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' /></div></td>
                        <td class='text_grey' valign="top">
						<div id="form1_label">
						<?php echo $BL->props->lang['~plans']; ?>
						</div>
						<div id="form1_field">
                        <table width='100%' border='0' cellspacing='1' cellpadding='1'>
						<?php foreach($products as $p) {?>
							<tr>
                            <td width='10%'>
							<input type='checkbox' name='products[]' class='search' value='<?php echo $p['plan_price_id']; ?>' <?php echo ($cmd=="edit_group" && array_search($p['plan_price_id'],$available_products)!==false)?"checked":""; ?>/>
							</td>
                            <td>
						    <?php echo $BL->getFriendlyName($p['plan_name']); ?>
							</td>
                            </tr>
						<?php } ?>
						</table>
                          </div></td>
                      </tr>
                                       
                      <tr> 
                        <td colspan='2' class='text_grey'>
                        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                        </td>
                      </tr>
                                           
                      <tr> 
                        <td class='text_grey'><div align='center'></div></td>
                        <td class='text_grey'>
						<div id="form1_label">
						&nbsp;
						</div>
						<div id="form1_field">
                         	<input name='cmd' type='hidden' value='<?php echo $cmd; ?>' />
							<?php if($cmd=="edit_group"){ ?>
                            <input name='group_id' type='hidden' value='<?php echo $group['group_id']; ?>' />
                            <?php } ?>
                            <input name='submit' type='submit' class='search1' value='<?php if($cmd=="edit_group") echo $BL->props->lang['Update'];else echo $BL->props->lang['add']; ?>' />
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
