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
      <div class="tabs2" name='tt1' id='tt1' onmouseover="javascript:this.className='tabs1';" onmouseout="javascript:this.className='tabs2';" ><?php echo $BL->props->lang['~currency']; ?></div>
      <div class="tab_separator">&nbsp;</div>
      <div class="tabs" name='tt2' id='tt2' onmouseover="javascript:this.className='tabs1';" onmouseout="javascript:this.className='tabs';" ><a href="admin.php?cmd=addcurrency" class="add_link"><?php echo $BL->props->lang['+addcurrency']; ?></a></div>
      <div class="tab_separator">&nbsp;</div>
    </div>
	<div id="display_list">        
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list_table">
					<tr> 
                      <td class="tdheading" colspan="2">
					  <b>&nbsp;<?php echo $BL->props->lang['default_currency']; ?></b>
					  </td>
                    </tr>
					<tr> 
                      <td class="text_grey" colspan="2"><img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" /></td>
                    </tr>
					<form name='form1' id='form1' method='POST' action='<?php echo $PHP_SELF; ?>'>
					<tr>
					  <td class="text_grey" width="2%">
                      <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
                      </td>
					  <td class='text_grey'>	
                      <div id="form1_label">  
                      <?php echo $BL->props->lang['currency']; ?>
                      </div>
                      <div id="form1_field">
                      <input type='text' name='curr_name' value='<?php echo $conf['curr_name']; ?>' class='search' size='10' />
					  </div>
                    </td>
                    </tr>
                    <tr>
                      <td colspan='2' class='text_grey'>
                      <img src="elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg" width="100%" height="1"></td>
                    </tr>
                    <tr>  
                    <td class="text_grey" width="2%">
                    <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
                    </td>                  
					<td class="text_grey">
                    <div id="form1_label">
                    <?php echo $BL->props->lang['symbol']; ?>
                    </div>
                    <div id="form1_field">
                    <input type='text' name='symbol' value='<?php echo $conf['symbol']; ?>' class='search' size='3' />
					</div>
                    </td>
                    </tr>
                    <tr>
                      <td colspan='2' class='text_grey'>
                      <img src="elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg" width="100%" height="1"></td>
                    </tr>
                    <tr>  
                    <td class="text_grey" width="2%">
                    <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
                    </td> 
                    <td class='text_grey'>   
                    <div id="form1_label">                 
                    <?php echo $BL->props->lang['curr_symbol_position']; ?>
                    </div>
                    <div id="form1_field">
                    <select name='curr_symbol_prefixed' class="search">
                    <option value="1" <?php  if($conf['curr_symbol_prefixed']==1)echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['Prefixed']; ?></option>
                    <option value="0" <?php  if($conf['curr_symbol_prefixed']==0)echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['Suffixed']; ?></option>
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
                    <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
                    </td>               
                    <td class="text_grey">
                    <div id="form1_label">
                    <?php echo $BL->props->lang['decimal_number']; ?>
                    </div>
                    <div id="form1_field">
                    
                      <select name="decimal_number" id="decimal_number" size="1">
                      <?php for($i=0;$i<=6;$i++){ ?>
                        <option value="<?php echo $i; ?>" <?php if($i==$conf['decimal_number'])echo "selected=\"selected\""; ?>><?php echo $i; ?></option>
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
                    <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
                    </td>                
                    <td class="text_grey">
                    <div id="form1_label">
                    <?php echo $BL->props->lang['decimal_str']; ?>
                      </div>
                      <div id="form1_field">
                      
                      <select name="decimal_str" id="decimal_str" size="1">
                        <option value="," <?php if($conf['decimal_str']==',')echo "selected=\"selected\""; ?>>,</option>
                        <option value="." <?php if($conf['decimal_str']=='.')echo "selected=\"selected\""; ?>>.</option>
                        <option value="'" <?php if($conf['decimal_str']=="'")echo "selected=\"selected\""; ?>>'</option>
                        <option value="&#8217;" <?php if($conf['decimal_str']=='&#8217;')echo "selected=\"selected\""; ?>>&#8217;</option>
                        <option value=" " <?php if($conf['decimal_str']==' ')echo "selected=\"selected\""; ?>>[<?php echo $BL->props->lang['blank']; ?>]</option>
                        <option value="" <?php if($conf['decimal_str']=='')echo "selected=\"selected\""; ?>>[<?php echo $BL->props->lang['none']; ?>]</option>
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
                    <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
                    </td>                
                    <td class="text_grey">
                    <div id="form1_label">
                    <?php echo $BL->props->lang['thousand_str']; ?>
                      </div>
                      <div id="form1_field">
                      
                      <select name="thousand_str" id="thousand_str" size="1">
                        <option value="," <?php if($conf['thousand_str']==',')echo "selected=\"selected\""; ?>>,</option>
                        <option value="." <?php if($conf['thousand_str']=='.')echo "selected=\"selected\""; ?>>.</option>
                        <option value="'" <?php if($conf['thousand_str']=='\'')echo "selected=\"selected\""; ?>>'</option>
                        <option value="&#8217;" <?php if($conf['thousand_str']=='&#8217;')echo "selected=\"selected\""; ?>>&#8217;</option>                        
                        <option value=" " <?php if($conf['thousand_str']==' ')echo "selected=\"selected\""; ?>>[<?php echo $BL->props->lang['blank']; ?>]</option>
                        <option value="" <?php if($conf['thousand_str']=='')echo "selected=\"selected\""; ?>>[<?php echo $BL->props->lang['none']; ?>]</option>
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
                    <input type='hidden' name='action' value='default_curr' />
                    <input type='hidden' name='cmd' value='<?php echo $cmd; ?>' />
                    <input type='submit' name='submit' class='search1' value='<?php echo $BL->props->lang['submit']; ?>' />
                    </div>
					 </td>
                     </tr>
                     </form>
                     </table>
                     <br />
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="list_table">
                    <tr> 
                      <td class="tdheading" colspan="2">
                      <b>&nbsp;<?php echo $BL->props->lang['auto_currency_rates']; ?></b>
                      </td>
                    </tr>
                    <tr> 
                      <td class="text_grey" colspan="2"><img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" /></td>
                    </tr>
					<form name='form2' id='form2' method='POST' action='<?php echo $PHP_SELF; ?>'>
					<tr>
                    <td class="text_grey" width="2%">
                    <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
                    </td> 
					  <td class='text_grey'>
                      <div id="form1_label">				
                        <?php echo $BL->props->lang['auto_update_currency']; ?>
    				  </div>
                      <div id="form1_field">
                    <select name='auto_update_curr' class="search">
					<option value="1" <?php  if($conf['auto_update_curr']==1)echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['Yes']; ?></option>
					<option value="0" <?php  if($conf['auto_update_curr']==0)echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['No']; ?></option>
					</select>
                      </div>
					</td>
                    </tr>
                    <tr>
                      <td colspan='2' class='text_grey'>
                      <img src="elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg" width="100%" height="1"></td>
                    </tr>
                    <tr>
                    <td class="text_grey">&nbsp;</td>
					<td class="text_grey">
                    <div id="form1_field">
                    <input type='hidden' name='action' value='auto_update_curr' />
                    <input type='hidden' name='cmd' value='<?php echo $cmd; ?>' />
                    <input type='submit' name='submit' class='search1' value='<?php echo $BL->props->lang['submit']; ?>' />
                    </div>
					</td>
					</tr>
					 </form>
													
                  </table>
				  <br />		
			     <table width="100%" border="0" cellspacing="0" cellpadding="0" class="list_table">
					<tr> 
                      <td colspan="5" class="tdheading">
					  <b>&nbsp;<?php echo $BL->props->lang['additional_currencies']; ?></b>
					  </td>
                    </tr>
					<tr> 
                      <td colspan="5" class="text_grey"><img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" /></td>
                    </tr>
		          <?php if (!count($currencies)) { ?>
				<tr>
					<td class="text_grey" colspan="5">
                    	<div align='center'>
                    	<?php echo $BL->props->lang['No_Currency']; ?>
                    	</div>
					</td>
				</tr>
		          <?php } else { ?>
                    <?php foreach ($currencies as $temp) { ?>					
                    <tr>
                      <td class='text_grey' width='15%'><div align='left'><?php echo $temp['curr_name']; ?></div></td>
                      <td class='text_grey' width='25%'><div align='right'><?php echo $conf['symbol']." 1 ".$conf['curr_name']; ?> = </div></td>
                      <td class='text_grey' width='15%'><div align='right'><?php echo $temp['curr_symbol']; ?>&nbsp;<?php echo $temp['curr_factor']; ?></div></td>
                      <td class='text_grey'><div align='left'>&nbsp;&nbsp;<?php echo $temp['curr_name']; ?></div></td>
                      <td class='text_grey' width='10%'><div align='right'>
                      <?php if($BL->getCmd("editcurrency")){ ?>
                      <a href='<?php echo $PHP_SELF; ?>?cmd=editcurrency&curr_id=<?php echo $temp['curr_id']; ?>' class='text_link'><img src='elements/default/templates/alp_admin/images/edit_all.gif' alt='<?php echo $BL->props->lang['Edit']; ?>' border='0'></a>
                      &nbsp;
                      <?php } ?>                      
                      <?php if($BL->getCmd("delcurrency")){ ?>
                      <a href="javascript:if(confirm('<?php echo $BL->props->lang['Do_you_want_to_delete_this_currency']; ?>'))document.location='<?php echo $PHP_SELF; ?>?cmd=delcurrency&curr_id=<?php echo $temp['curr_id']; ?>'" class='text_link'><img src='elements/default/templates/alp_admin/images/delete.gif' alt='<?php echo $BL->props->lang['Delete']."?"; ?>' border='0'></a>
                      &nbsp;
                      <?php } ?>
                      </div></td>
                    </tr>
					<tr>
                      <td colspan='5' class='text_grey'>
					  <img src="elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg" width="100%" height="1"></td>
                    </tr>					
                    <?php }  ?>           
                      </table>
                      </td>
                    </tr>                
            <?php
			}
			?>	

                  </table>
				  <br />
					<table width="100%" border="0" cellspacing="2" cellpadding="2" class="list_table">				
					<tr> 
                      <td class="text_grey" align="center">
					  <img src='elements/default/templates/alp_admin/images/edit_all.gif'> <?php echo $BL->props->lang['Edit']; ?>
					  &nbsp;
					  <img src='elements/default/templates/alp_admin/images/delete.gif'> <?php echo $BL->props->lang['Delete']; ?>
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
