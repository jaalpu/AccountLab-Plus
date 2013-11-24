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
      <div class="tabs" name='tt1' id='tt1' onmouseover="javascript:this.className='tabs1';" onmouseout="javascript:this.className='tabs';" ><a href="admin.php?cmd=currency" class="add_link"><?php echo $BL->props->lang['~currency']; ?></a></div>
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
					<form name='form1' id='form1' method='POST' action='<?php echo $PHP_SELF; ?>'>
					<table width='100%' border='0' cellspacing='0' cellpadding='0'>
		    			<tr> 
                        <td class='text_grey' width='1%'>
						<div align='center'>
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
						</div>
                        </td>
                        <td class='text_grey'>
						<div id="form1_label">
						<?php echo $BL->props->lang['currency']; ?>
						</div>
						<div id="form1_field">
                            <input name='curr_name' type='text' class='search' id='curr_name' size='20' value='<?php if($cmd=="editcurrency")echo $currency['curr_name']; ?>' />
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
						<?php echo $BL->props->lang['symbol']; ?>
							</div>
							<div id="form1_field">
                            <input name='curr_symbol' type='text' class='search' size='3' value='<?php if($cmd=="editcurrency")echo $currency['curr_symbol']; ?>' />
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
						<?php echo $BL->props->lang['currency_rate']; ?>
						</div>
						<div id="form1_field">
                         <?php echo $conf['symbol']."1 ".$conf['curr_name']; ?> = <input name='curr_factor' type='text' class='search' size='5' value='<?php if($cmd=="editcurrency")echo $currency['curr_factor']; ?>' />
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
                        <?php echo $BL->props->lang['curr_symbol_position']; ?>
                        </div>
                        <div id="form1_field">
                            <select name='curr_symbol_prefixed' name='curr_symbol_prefixed' class="search">
                            <option value="1" <?php  if($cmd=="editcurrency" && $currency['curr_symbol_prefixed']==1)echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['Prefixed']; ?></option>
                            <option value="0" <?php  if($cmd=="editcurrency" && $currency['curr_symbol_prefixed']==0)echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['Suffixed']; ?></option>
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
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
                        </div>
                        </td>
                        <td class='text_grey'>
                        <div id="form1_label">
                        <?php echo $BL->props->lang['decimal_number']; ?>
                            </div>
                            <div id="form1_field">
                            
                          <select name="curr_decimal_number" id="curr_decimal_number" size="1">
                          <?php for($i=0;$i<=6;$i++){ ?>
                            <option value="<?php echo $i; ?>" <?php if($cmd=="editcurrency" && $i==$currency['curr_decimal_number'])echo "selected=\"selected\""; ?>><?php echo $i; ?></option>
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
                        <td class='text_grey'>
                        <div align='center'>
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
                        </div>
                        </td>
                        <td class='text_grey'>
                        <div id="form1_label">
                        <?php echo $BL->props->lang['decimal_str']; ?>
                            </div>
                            <div id="form1_field">
                            
                          <select name="curr_decimal_str" id="curr_decimal_str" size="1">
                            <option value="," <?php if($cmd=="editcurrency" && $currency['curr_decimal_str']==',')echo "selected=\"selected\""; ?>>,</option>
                            <option value="." <?php if($cmd=="editcurrency" && $currency['curr_decimal_str']=='.')echo "selected=\"selected\""; ?>>.</option>
                            <option value="'" <?php if($cmd=="editcurrency" && $currency['curr_decimal_str']=='\'')echo "selected=\"selected\""; ?>>'</option>
                            <option value="&#8217;" <?php if($cmd=="editcurrency" && $currency['curr_decimal_str']=='&#8217;')echo "selected=\"selected\""; ?>>&#8217;</option>
                            <option value=" " <?php if($cmd=="editcurrency" && $currency['curr_decimal_str']==' ')echo "selected=\"selected\""; ?>>[<?php echo $BL->props->lang['blank']; ?>]</option>
                            <option value="" <?php if($cmd=="editcurrency" && $currency['curr_decimal_str']=='')echo "selected=\"selected\""; ?>>[<?php echo $BL->props->lang['none']; ?>]</option>
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
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
                        </div>
                        </td>
                        <td class='text_grey'>
                        <div id="form1_label">
                        <?php echo $BL->props->lang['thousand_str']; ?>
                            </div>
                            <div id="form1_field">
                            
                          <select name="curr_thousand_str" id="curr_thousand_str" size="1">
                            <option value="," <?php if($cmd=="editcurrency" && $currency['curr_thousand_str']==',')echo "selected=\"selected\""; ?>>,</option>
                            <option value="." <?php if($cmd=="editcurrency" && $currency['curr_thousand_str']=='.')echo "selected=\"selected\""; ?>>.</option>
                            <option value="'" <?php if($cmd=="editcurrency" && $currency['curr_thousand_str']=='\'')echo "selected=\"selected\""; ?>>'</option>
                            <option value="&#8217;" <?php if($cmd=="editcurrency" && $currency['curr_thousand_str']=='&#8217;')echo "selected=\"selected\""; ?>>&#8217;</option>
                            <option value=" " <?php if($cmd=="editcurrency" && $currency['curr_thousand_str']==' ')echo "selected=\"selected\""; ?>>[<?php echo $BL->props->lang['blank']; ?>]</option>
                            <option value="" <?php if($cmd=="editcurrency" && $currency['curr_thousand_str']=='')echo "selected=\"selected\""; ?>>[<?php echo $BL->props->lang['none']; ?>]</option>
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
                        <td class='text_grey'><div align='center'></div></td>
                        <td class='text_grey'>
						<div id="form1_label">
						&nbsp;
						</div>
						<div id="form1_field">
                            <?php if($cmd=="editcurrency"){ ?>
                        	<input type='hidden' name='curr_id' value='<?php echo $currency['curr_id']; ?>' />
                            <?php } ?>
                            <input type='hidden' name='cmd' value='<?php echo $cmd; ?>' />
                            <input name='submit' type='submit' class='search1' value='<?php if($cmd=="editcurrency")echo $BL->props->lang['Update'];else echo $BL->props->lang['add']; ?>' />
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
