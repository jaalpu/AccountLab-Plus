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
      <div class="tabs" name='tt1' id='tt1' onmouseover="javascript:this.className='tabs1';" onmouseout="javascript:this.className='tabs';" ><a href="admin.php?cmd=specials" class="add_link"><?php echo $BL->props->lang['~specials']; ?></a></div>
      <div class="tab_separator">&nbsp;</div>
      <div class="tabs2" name='tt2' id='tt2'  onmouseover="javascript:this.className='tabs1';" onmouseout="javascript:this.className='tabs2';" ><?php echo $title; ?></div>
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
					  <img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" />
					  </td>
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
						<?php echo $BL->props->lang['Name']; ?>
						</div>
						<div id="form1_field">
                            <input name='special_name' type='text' class='search' id='special_name' size='20' value='<?php if(isset($REQUEST['special_name']))echo $REQUEST['special_name']; elseif($cmd=="edit_special")echo $special['special_name']; ?>' />
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
						<?php echo $BL->props->lang['Description']; ?>
							</div>
							<div id="form1_field">
                            <textarea name="special_desc" id="special_desc" rows="3" cols="25" wrap="soft"><?php if(isset($REQUEST['special_desc']))echo $REQUEST['special_desc']; elseif($cmd=="edit_special")echo $special['special_desc']; ?></textarea>
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
                        <?php echo $BL->props->lang['auto_desc']; ?>
                            </div>
                            <div id="form1_field">
                           <select name='auto_desc' class='search' id='auto_desc'>
                           <option value='1' <?php if(($cmd=="edit_special" && $special['auto_desc']==1 && !isset( $REQUEST['auto_desc'])) || (isset( $REQUEST['auto_desc']) && $REQUEST['auto_desc']=='1')) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['Yes']; ?></option>
                            <option value='0' <?php if(($cmd=="edit_special" && $special['auto_desc']==0 && !isset( $REQUEST['auto_desc'])) || (isset( $REQUEST['auto_desc']) && $REQUEST['auto_desc']=='0')) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['No']; ?></option>
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
						<?php echo $BL->props->lang['Valid From']; ?>
						</div>
						<div id="form1_field">
                        <?php
						if ($cmd == "edit_special" || isset($REQUEST['special_valid_from']))
						{
							list ($y, $m, $d) = explode("-", isset($special['special_valid_from'])?$special['special_valid_from']:date('Y-m-d'));
							if(isset($REQUEST['special_valid_from']))list ($d, $m, $y)= explode("-", $REQUEST['special_valid_from']);
							echo $BL->utils->datePicker($d, $m, $y, "search", "1");
						}
						else
						{
							echo $BL->utils->datePicker(date('d'), date('m'), date('Y'), "search", "1");
						}
						?>
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
						<?php echo $BL->props->lang['Valid Upto']; ?>
						</div>
						<div id="form1_field">
						<?php
						if ($cmd == "edit_special" || isset($REQUEST['special_valid']))
						{
							list ($y, $m, $d)= explode("-", isset($special['special_valid'])?$special['special_valid']:date('Y-m-d'));
							if(isset($REQUEST['special_valid']))list ($d, $m, $y)= explode("-", $REQUEST['special_valid']);
							echo $BL->utils->datePicker($d, $m, $y, "search");
						}
						else
						{
							echo $BL->utils->datePicker(date('d'), date('m')+1, date('Y'), "search");
						}
						?>                            
                          </div></td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'>
                        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='2' />
                        </td>
                      </tr>

                      <tr> 
                        <td class='text_grey'><div align='center'>
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'></div></td>
                        <td class='text_grey'>
						<div id="form1_label">
						<b><?php echo $BL->props->lang['Apply_special_if']; ?></b>
						</div>
						<div id="form1_field">
                        </div>
                        </td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'>
                        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                        </td>
                      </tr>
                      <tr> 
                        <td class='text_grey'></td>
                        <td class='text_grey'>
						<div id="form1_label">
						<?php echo $BL->props->lang['TLD']; ?>
						</div>
						<div id="form1_field">
						<select name='special_tld' class='search' id='special_tld'>
							<option value='0' <?php if(isset($REQUEST['special_tld']) && $REQUEST['special_tld']==0) echo "selected"; elseif($cmd=="edit_special" && $special['special_tld']==0) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['not_required']; ?></option>
							<option value='1' <?php if(isset($REQUEST['special_tld']) && $REQUEST['special_tld']==1) echo "selected"; elseif($cmd=="edit_special" && $special['special_tld']==1) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['any']; ?></option>
						    <?php foreach ($tlds as $tld) { ?>
							<option value='<?php echo $tld['dom_ext']; ?>' <?php if(isset($REQUEST['special_tld']) && $REQUEST['special_tld']==$tld['dom_ext']) echo "selected=\"selected\""; elseif($cmd=="edit_special" && $special['special_tld']==$tld['dom_ext']) echo "selected=\"selected\""; ?>><?php echo $tld['dom_ext']; ?></option>
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
                        <td class='text_grey'></td>
                        <td class='text_grey'>
						<div id="form1_label">
						<?php echo $BL->props->lang['subdomain']; ?>
						</div>
						<div id="form1_field">
						<select name='special_subdom' class='search' id='special_subdom'>
							<option value='0' <?php if(isset($REQUEST['special_subdom']) && $REQUEST['special_subdom']==0) echo "selected=\"selected\""; elseif($cmd=="edit_special" && $special['special_subdom']==0) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['not_required']; ?></option>
							<option value='1' <?php if(isset($REQUEST['special_subdom']) && $REQUEST['special_subdom']==1) echo "selected=\"selected\""; elseif($cmd=="edit_special" && $special['special_subdom']==1) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['any']; ?></option>
						    <?php foreach ($subdomains as $subdomain) { ?>
							<option value='<?php echo $subdomain['maindomain']; ?>' <?php if(isset($REQUEST['special_subdom']) && $REQUEST['special_subdom']==$subdomain['maindomain']) echo "selected=\"selected\""; elseif($cmd=="edit_special" && $special['special_subdom']==$subdomain['maindomain']) echo "selected=\"selected\""; ?>><?php echo $subdomain['maindomain']; ?></option>
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
                        <td class='text_grey'></td>
                        <td class='text_grey'>
						<div id="form1_label">
						<?php echo $BL->props->lang['Plan']; ?>
						</div>
						<div id="form1_field">
						<select name='special_plan' class='search' id='special_plan'>
							<option value='0' <?php if(isset($REQUEST['special_plan']) && $REQUEST['special_plan']==0) echo "selected=\"selected\""; elseif($cmd=="edit_special" && $special['special_plan']==0) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['not_required']; ?></option>
							<option value='ALL' <?php if(isset($REQUEST['special_plan']) && $REQUEST['special_plan']=='ALL') echo "selected=\"selected\""; elseif($cmd=="edit_special" && $special['special_plan']=='ALL') echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['any']; ?></option>
						    <?php foreach ($plans as $plan) { ?>
							<option value='<?php echo $plan['plan_price_id']; ?>' <?php if(isset($REQUEST['special_plan']) && $REQUEST['special_plan']==$plan['plan_price_id']) echo "selected=\"selected\""; elseif($cmd=="edit_special" && ($special['special_plan']==$plan['plan_price_id'] || $special['special_plan']==$plan['plan_name'])) echo "selected=\"selected\""; ?>><?php echo $BL->getFriendlyName($plan['plan_name']); ?></option>
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
                        <td class='text_grey'></td>
                        <td class='text_grey'>
						<div id="form1_label">
						<?php echo $BL->props->lang['Amount']." (".$conf['symbol'].")"; ?>
						</div>
						<div id="form1_field">
						<input type="text" id='special_net' class='search' name="special_net" value="<?php if(isset($REQUEST['special_net']))echo $REQUEST['special_net']; elseif($cmd=="edit_special")echo $special['special_net']; ?>" size="20" />		
						</div>
						</td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'>
                        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='2' />
                        </td>
                      </tr>	

                      <tr> 
                        <td class='text_grey'><div align='center'>
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'></div></td>
                        <td class='text_grey'>
						<div id="form1_label">
						<b><?php echo $BL->props->lang['Special_Offers']; ?></b>
						</div>
						<div id="form1_field">
                        </div></td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'>
                        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                        </td>
                      </tr>                      

                      <tr> 
                        <td class='text_grey'></td>
                        <td class='text_grey'>
						<div id="form1_label">
						<?php echo $BL->props->lang['new_order']; ?>
						</div>
						<div id="form1_field">
						<script language="JavaScript" type="text/JavaScript">
						function MM_jumpMenu(targ,selObj,restore){
                            <?php if(isset($special_id)){ ?>
							eval(targ+".location='<?php echo $PHP_SELF."?cmd=".$cmd."&special_id=".$special_id."&new_order="; ?>"+selObj.options[selObj.selectedIndex].value+"&special_name="+restore.special_name.value+"&special_desc="+restore.special_desc.value+"&auto_desc="+restore.auto_desc.value+"&special_valid_from="+restore.date_field1.value+"-"+restore.month_field1.value+"-"+restore.year_field1.value+"&special_valid="+restore.date_field.value+"-"+restore.month_field.value+"-"+restore.year_field.value+"&special_tld="+restore.special_tld.value+"&special_subdom="+restore.special_subdom.value+"&special_plan="+restore.special_plan.value+"&special_net="+restore.special_net.value+"'");
                            <?php }else{ ?>
                            eval(targ+".location='<?php echo $PHP_SELF."?cmd=".$cmd."&new_order="; ?>"+selObj.options[selObj.selectedIndex].value+"&special_name="+restore.special_name.value+"&special_desc="+restore.special_desc.value+"&auto_desc="+restore.auto_desc.value+"&special_valid_from="+restore.date_field1.value+"-"+restore.month_field1.value+"-"+restore.year_field1.value+"&special_valid="+restore.date_field.value+"-"+restore.month_field.value+"-"+restore.year_field.value+"&special_tld="+restore.special_tld.value+"&special_subdom="+restore.special_subdom.value+"&special_plan="+restore.special_plan.value+"&special_net="+restore.special_net.value+"'");
                            <?php } ?>
						}
						</script>
						<select name='new_order' class='search' id='new_order' onchange="MM_jumpMenu('parent',this,this.form)">
							<option value='0' <?php if(isset($REQUEST['new_order']) && $REQUEST['new_order']==0)echo "selected=\"selected\""; elseif($cmd=="edit_special" && $special['new_order']==0) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['current_type']; ?></option>
							<option value='1' <?php if(isset($REQUEST['new_order']) && $REQUEST['new_order']==1)echo "selected=\"selected\""; elseif($cmd=="edit_special" && $special['new_order']==1) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['new_type']; ?></option>
						</select>                            
                          </div></td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'>
						<img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
                      </tr>
					<?php
					if (isset($REQUEST['new_order']) && is_numeric($REQUEST['new_order']))
						$no= $REQUEST['new_order'];
					elseif ($cmd == "edit_special") $no= $special['new_order'];
					else
						$no= 0;
					?>
                      <tr> 
                        <td class='text_grey'></td>
                        <td class='text_grey'>
						<div id="form1_label">
						<?php echo $BL->props->lang['TLD']; ?>
						</div>
						<div id="form1_field">
						<?php if($cmd=="edit_special")$special_tld_disc=explode("=>",$special['special_tld_disc']); ?>
						<select name='special_tld_disc' class='search' id='special_tld_disc'>
							<option value='0' <?php if($cmd=="edit_special" && $special_tld_disc[0]==0) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['not_required']; ?></option>
							<option value='1' <?php if($cmd=="edit_special" && $special_tld_disc[0]==1) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['any']; ?></option>
						<?php						
						if ($no == 1)
						{
							foreach ($tlds as $tld)
							{
						?>
							<option value='<?php echo $tld['dom_ext']; ?>' <?php if($cmd=="edit_special" && $special_tld_disc[0]==$tld['dom_ext']) echo "selected=\"selected\""; ?>><?php echo $tld['dom_ext']; ?></option>
						<?php						
							}
						}
						?>
						</select>                           
                          </div></td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'>
						<img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
                      </tr>
					
					
                      <tr> 
                        <td class='text_grey'></td>
                        <td class='text_grey'>
						<div id="form1_label">
						<?php echo $BL->props->lang['subdomain']; ?>
						</div>
						<div id="form1_field">
						<?php if($cmd=="edit_special")$special_subdom_disc=explode("=>",$special['special_subdom_disc']); ?>
						<select name='special_subdom_disc' class='search' id='special_subdom_disc'>
							<option value='0' <?php if($cmd=="edit_special" && $special_subdom_disc[0]==0) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['not_required']; ?></option>
							<option value='1' <?php if($cmd=="edit_special" && $special_subdom_disc[0]==1) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['any']; ?></option>
						<?php
						if ($no == 1)
						{
							foreach ($subdomains as $subdomain)
							{
						?>
							<option value='<?php echo $subdomain['maindomain']; ?>' <?php if($cmd=="edit_special" && $special_subdom_disc[0]==$subdomain['maindomain']) echo "selected=\"selected\""; ?>><?php echo $subdomain['maindomain']; ?></option>
						<?php
							}
						}
						?>
						</select>                          
                          </div></td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'>
						<img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
                      </tr>
					
					
                      <tr> 
                        <td class='text_grey'></td>
                        <td class='text_grey'>
						<div id="form1_label">
						<?php echo $BL->props->lang['Plan']; ?>
						</div>
						<div id="form1_field">
                        <?php if($cmd=="edit_special")$special_plan_disc=explode("=>",$special['special_plan_disc']); ?>
						<select name='special_plan_disc' class='search' id='special_plan_disc'>
							<option value='0' <?php if($cmd=="edit_special" && $special_plan_disc[0]==0)echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['not_required']; ?></option>
							<option value='ALL' <?php if($cmd=="edit_special" && $special_plan_disc[0]=='ALL')echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['any']; ?></option>
						<?php						
						if ($no == 1)
						{
							foreach ($plans as $plan)
							{
						?>
							<option value='<?php echo $plan['plan_price_id']; ?>' <?php if($cmd=="edit_special" && ($special_plan_disc[0]==$plan['plan_price_id'] || $special_plan_disc[0]==$plan['plan_name']))echo "selected=\"selected\""; ?>><?php echo $BL->getFriendlyName($plan['plan_name']); ?></option>
						<?php						
							}
						}
						?>
						</select>                       
                          </div></td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'>
						<img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
                      </tr>
					
                      <tr> 
                        <td class='text_grey'></td>
                        <td class='text_grey'>
						<div id="form1_label">
						<?php echo $BL->props->lang['addon']; ?>
						</div>
						<div id="form1_field">
                        <?php if($cmd=="edit_special")$special_addon_disc=explode("=>",$special['special_addon_disc']); ?>
						<select name='special_addon_disc' class='search' id='special_addon_disc'>
							<option value='0' <?php if($cmd=="edit_special" && $special_addon_disc[0]==0)echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['not_required']; ?></option>
							<option value='1' <?php if($cmd=="edit_special" && $special_addon_disc[0]==1)echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['any']; ?></option>
						</select>                
                          </div></td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'>
						<img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
                      </tr>

                      <tr> 
                        <td class='text_grey'></td>
                        <td class='text_grey'>
						<div id="form1_label">
						<?php echo $BL->props->lang['discount']; ?>
						</div>
						<div id="form1_field">
                            <input type="text" class='search' name="special_net_disc" value="<?php if($cmd=="edit_special")echo $special['special_net_disc'] ?>" size="20" /><b>%</b>
                          </div></td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'>
						<img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
                      </tr>
                   
                      
                                           
                      <tr> 
                        <td class='text_grey'><div align='center'></div></td>
                        <td class='text_grey'>
						<div id="form1_label">
						&nbsp;
						</div>
						<div id="form1_field">
                        	<input type='hidden' name='special_id' value='<?php if($cmd=="edit_special")echo $special['special_id']; ?>' />
                        	<input type='hidden' name='special_active' value='<?php if($cmd=="edit_special")echo $special['special_active'];else echo "0"; ?>' />
                            <input type='hidden' name='cmd' value='<?php echo $cmd; ?>' />
                            <input name='submit' type='submit' class='search1' value='<?php if($cmd=="edit_special")echo $BL->props->lang['Update'];else echo $BL->props->lang['add']; ?>' />
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
