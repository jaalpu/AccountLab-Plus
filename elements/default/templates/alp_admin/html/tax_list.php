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
      <div class="tabs2" name='tt1' id='tt1' onmouseover="javascript:this.className='tabs1';" onmouseout="javascript:this.className='tabs2';" ><?php echo $BL->props->lang['~tax']; ?></div>
      <div class="tab_separator">&nbsp;</div>
      <div class="tabs" name='tt2' id='tt2' onmouseover="javascript:this.className='tabs1';" onmouseout="javascript:this.className='tabs';" ><a href="admin.php?cmd=addtax" class="add_link"><?php echo $BL->props->lang['+addtax']; ?></a></div>
      <div class="tab_separator">&nbsp;</div>
    </div>
	<div id="display_list">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="list_table">
                    <tr> 
                      <td class="tdheading" colspan="2">
                      <b>&nbsp;</b>
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
                        <?php echo $BL->props->lang['ask_fot_vat']; ?>
                      </div>
                      <div id="form1_field">
                            <select name='en_vat' class='search' id='en_vat'>
                                  <option value='1' <?php if($conf['en_vat']==1) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['Yes']; ?></option>
                                <option value='0' <?php if($conf['en_vat']==0) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['No']; ?></option>
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
                    <input type='hidden' name='cmd' value='<?php echo $cmd; ?>' />
                    <input type='hidden' name='action' value='togglevat' />
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
                      <b>&nbsp;</b>
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
                        <?php echo $BL->props->lang['tax_display']; ?>
                      </div>
                      <div id="form1_field">
                                <select name='tax_calculation' class='search' id='tax_calculation'>
                                  <option value='0' <?php if($conf['tax_calculation']==0) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['tax_on_total']; ?></option>
                                  <option value='1' <?php if($conf['tax_calculation']==1) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['tax_on_each_product']; ?></option>
                                  <option value='2' <?php if($conf['tax_calculation']==2) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['product_incl_tax']; ?></option>
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
                    <input type='hidden' name='action' value='tax_display' />
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
                      <td colspan="6" class="text_grey"><img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" /></td>
                    </tr>
					<tr>											
                    <td class='text_grey' width='5%'></td>
                    <td class='text_grey'><b><?php echo $BL->props->lang['Tax_Name']; ?></b></td>
                    <td class='text_grey'><b><?php echo $BL->props->lang['net']; ?> / <?php echo $BL->props->lang['compounded']; ?></b>&nbsp;&nbsp;</td>
                    <td class='text_grey' align='right'><b><?php echo $BL->props->lang['Tax_Amount']; ?></b></td>
                    <td class='text_grey'></td>
                    <td class='text_grey' width='10%'></td>
                    </tr>
                    <script language="JavaScript" type="text/javascript">
                    function changeTaxStatus(tax_id,tax_enable){
                        <?php $url = "'admin.php?cmd=".$cmd."&action=changestatus&tax_id='+tax_id"; ?>
                        var url = <?php echo $url; ?>;
                            url = url+"&tax_enable="+tax_enable
                            eval("parent.location='"+url+"'");
                    }
                    </script>
                     <form method="POST" name='form3' id='form3' action="<?php echo $PHP_SELF; ?>">
                    <?php foreach($taxes as $k=>$v) { ?>
					<tr>
                      <td colspan='6' class='text_grey'>
					  <img src="elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg" width="100%" height="1" /></td>
                    </tr>					
                    <tr>
                    <td class='text_grey'>
                    <?php if($v['tax_index'] > 1){ ?>
                    &nbsp;<a href='<?php echo $PHP_SELF; ?>?cmd=tax&tax_id=<?php echo $v['tax_id']; ?>&tax_index=<?php echo $v['tax_index']; ?>&action=up'>
					<img src='elements/default/templates/alp_admin/images/up.gif' border='0' /></a>
                    <?php }if($v['tax_index'] > 1 && $v['tax_index'] < count($taxes)){ ?>
                    <br>
                    <?php }if($v['tax_index'] < count($taxes)){ ?>
                    &nbsp;<a href='<?php echo $PHP_SELF; ?>?cmd=tax&tax_id=<?php echo $v['tax_id']; ?>&tax_index=<?php echo $v['tax_index']; ?>&action=down'>
					<img src='elements/default/templates/alp_admin/images/down.gif' border='0' /></a>
                    <?php } ?>
                    </td>
                    <td class='text_grey'><?php echo $v['tax_name']; ?></td>
                    <td class='text_grey'><?php echo ($v['tax_net_comp']=="N")?$BL->props->lang['net']:$BL->props->lang['compounded']; ?></td>
                    <td class='text_grey' align='right'><?php echo (($v['tax_add_sub']=="S")?"-":"").number_format($v['tax_amount'],2); ?>%&nbsp;&nbsp;</td>
                    
                      <td class='text_grey'>
                        <select name='tax_enable' class='search' id='tax_enable' onchange="javascript:changeTaxStatus(<?php echo $v['tax_id']; ?>,this.options[this.selectedIndex].value);">
                            <option value='0' <?php if($v['tax_enable']==0)echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['inactive']; ?></option>
                            <option value='1' <?php if($v['tax_enable']==1)echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['active']; ?></option>
                        </select>                      
                      </td>
                      
                    <td class='text_grey' align='right'>
                    <?php if($BL->getCmd("edittax")){ ?>
                    <a href="<?php echo $PHP_SELF; ?>?cmd=edittax&tax_id=<?php echo $v['tax_id']; ?>">
                    <img src='elements/default/templates/alp_admin/images/edit_all.gif' border='0' />
                    </a>        
                    <?php } ?>    
                    <?php if($BL->getCmd("deltax")){ ?>        
                    &nbsp;
                    <a href="javascript:if(confirm('<?php echo $BL->props->lang['Do_you_want_to_delete_this_tax']; ?>'))document.location='<?php echo $PHP_SELF; ?>?cmd=deltax&tax_id=<?php echo $v['tax_id']; ?>'">
                    <img src='elements/default/templates/alp_admin/images/delete.gif' border='0' />
                    </a>
                    <?php } ?>
                    &nbsp;
                    </td>
                    </tr>
                    <?php } ?>
                    </form>
					<tr> 
                      <td colspan="6" class="text_grey"><img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" /></td>
                    </tr>			
                  </table>
				  <br />
					<table width="100%" border="0" cellspacing="2" cellpadding="2" class="list_table">				
					<tr> 
                      <td class="text_grey" align="center">
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
