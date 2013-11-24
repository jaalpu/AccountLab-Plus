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
      <div class="tabs" name='tt1' id='tt1' onmouseover="javascript:this.className='tabs1';" onmouseout="javascript:this.className='tabs';" ><a href="admin.php?cmd=coupons" class="add_link"><?php echo $BL->props->lang['~coupons']; ?></a></div>
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
                      <td colspan="2" class="text_grey"><img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" /></td>
                    </tr>
				<tr>
					<td class="text_grey" colspan="2">
					<form name='form1' id='form1' method='post' action='<?php echo $PHP_SELF; ?>'>
				    <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                      <tr> 
                        <td width='1%' class='text_grey'><div align='center'>
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'></div></td>
                        <td class='text_grey'>
						<div id="form1_label">
						<?php echo $BL->props->lang['Name']; ?>
						</div>
						<div id="form1_field">
                            <input name='coupon_name' type='text' class='search' id='coupon_name' size='20' value='<?php if($cmd=="edit_coupon")echo $coupon['coupon_name']; ?>' />
                          </div></td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
                      </tr>

                      <tr> 
                        <td class='text_grey'><div align='center'><img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' 
height='18'></div></td>
                        <td class='text_grey'>
						<div id="form1_label">
						<?php echo $BL->props->lang['discount']; ?>
						</div>
						<div id="form1_field">
                            %<input name='coupon_discount' type='text' class='search' id='coupon_discount' size='7' value='<?php if($cmd=="edit_coupon")echo $coupon['coupon_discount']; ?>' />
                          </div></td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
                      </tr>
                                          
                      
                      <tr> 
                        <td class='text_grey'><div align='center'><img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' 
height='18'></div></td>
                        <td class='text_grey'>
						<div id="form1_label">
						<?php echo $BL->props->lang['Include_domains']; ?>
						</div>
						<div id="form1_field">
                            <select name='coupon_domain' class='search'>
                            <option value='1' <?php if($cmd=="edit_coupon" && $coupon['coupon_domain']==1)echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['Yes']; ?></option>
                            <option value='0' <?php if($cmd=="edit_coupon" && $coupon['coupon_domain']==0)echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['No']; ?></option>
                            </select>
                        </div>
                        </td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
                      </tr>
                      
                      
                      <tr> 
                        <td class='text_grey'><div align='center'><img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' 
height='18'></div></td>
                        <td class='text_grey'>
						<div id="form1_label">
						<?php echo $BL->props->lang['Include_addons']; ?>
						</div>
						<div id="form1_field">
                            <select name='coupon_addons' class='search'>
                            <option value='1' <?php if($cmd=="edit_coupon" && $coupon['coupon_addons']==1)echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['Yes']; ?></option>
                            <option value='0' <?php if($cmd=="edit_coupon" && $coupon['coupon_addons']==0)echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['No']; ?></option>
                            </select>
                        </div>
                        </td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
                      </tr>
                      
                      <tr> 
                        <td class='text_grey'><div align='center'><img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' 
height='18'></div></td>
                        <td class='text_grey'>
                        <div id="form1_label">
                        <?php echo $BL->props->lang['customer_to_use']; ?>
                        </div>
                        <div id="form1_field">
                            <select name='customer_use' class='search'>
                            <option value='0' <?php if($cmd=="edit_coupon" && $coupon['customer_use']==0)echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['all']; ?></option>
                            <option value='1' <?php if($cmd=="edit_coupon" && $coupon['customer_use']==1)echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['new']; ?></option>
                            <option value='2' <?php if($cmd=="edit_coupon" && $coupon['customer_use']==2)echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['current']; ?></option>
                            </select>
                        </div>
                        </td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
                      </tr>
                      
                      
                      <tr> 
                        <td class='text_grey'><div align='center'><img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' 
height='18'></div></td>
                        <td class='text_grey'>
                        <div id="form1_label">
                        <?php echo $BL->props->lang['usage']; ?>
                        </div>
                        <div id="form1_field">
                            <select name='repeated' class='search'>
                            <option value='0' <?php if($cmd=="edit_coupon" && $coupon['repeated']==0)echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['once']; ?></option>
                            <option value='1' <?php if($cmd=="edit_coupon" && $coupon['repeated']==1)echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['repeated']; ?></option>
                            </select>
                        </div>
                        </td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
                      </tr>
                      
                      <tr> 
                        <td class='text_grey'><div align='center'><img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' 
height='18'></div></td>
                        <td class='text_grey'>
						<div id="form1_label">
						<?php echo $BL->props->lang['Valid Upto']; ?>
						</div>
						<div id="form1_field">
							<?php
							if ($cmd == "edit_coupon")
							{
								list ($y, $m, $d)= explode("-", $coupon['coupon_valid']);
								echo $BL->utils->datePicker($d, $m, $y, "search");
							}
							else
							{
								echo $BL->utils->datePicker(date('d'), date('m'), date('Y'), "search");
							}
							?>
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
                        	<input type='hidden' name='coupon_id' value='<?php if($cmd=="edit_coupon")echo $coupon['coupon_id']; ?>' />
                            <input type='hidden' name='cmd' value='<?php echo $cmd; ?>' />
                            <input name='submit' type='submit' class='search1' value='<?php if($cmd=="edit_coupon")echo $BL->props->lang['Update'];else echo $BL->props->lang['add']; ?>' />
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
