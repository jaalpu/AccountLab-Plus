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
      <div class="tabs" name='tt1' id='tt1' onmouseover="javascript:this.className='tabs1';" onmouseout="javascript:this.className='tabs';" ><a href="admin.php?cmd=tld" class="add_link"><?php echo $BL->props->lang['~tld']; ?></a></div>
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
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
						</div>
                        </td>
                        <td class='text_grey'>
						<div id="form1_label">
						<?php echo $BL->props->lang['TLD']; ?>
						</div>
						<div id="form1_field">
						<script language="JavaScript" type="text/JavaScript">
						<!--
						function MM_jumpMenu(targ,selObj){
							eval(targ+".location='<?php echo $PHP_SELF."?cmd=".$cmd.(isset($REQUEST['price_id'])?("&price_id=".$REQUEST['price_id']):"")."&dom_ext="; ?>"+selObj.options[selObj.selectedIndex].value+"'");
						}
						//-->
						</script>
							<select name='dom_ext' class='search' id='dom_ext' onchange="javascript:MM_jumpMenu('parent',this);">
							<option><?php echo $BL->props->lang['select']; ?></option>
							<?php
							$i=0;
							foreach($BL->props->tld_array as $key=>$val){
							?>
							<option value='<?php echo  $key; ?>' <?php if(isset($REQUEST['dom_ext']) && $REQUEST['dom_ext']==$key){echo "selected=\"selected\"";$i=1;} ?>><?php echo  $key; ?></option>
							<?php
							}
							?>
							</select>
							<?php echo $BL->props->lang['OR']; ?>
							<input name='dom_ext1' type='text' class='search' id='dom_ext1' size='10' value='<?php if($cmd=="edittld" && $i==0)echo $tld['dom_ext']; ?>' />
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
                        <?php echo $BL->props->lang['Period']; ?>
                            </div>
                            <div id="form1_field">
                            <select name='dom_period' class='search'>
                                <?php for($i=1;$i<11;$i++){ ?>
                                    <option value='<?php echo $i; ?>' <?php if($cmd=="edittld" && $tld['dom_period']==$i) echo "selected"; ?>><?php echo $i." ".$BL->props->lang['year']; ?></option>
                                <?php } ?>
                                <option value='99' <?php if($cmd=="edittld" && $tld['dom_period']==99) echo "selected"; ?>><?php echo $BL->props->lang['one_time']; ?></option>
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
						<?php echo $BL->props->lang['Price']; ?> (<?php echo $BL->conf['symbol']; ?>)
							</div>
							<div id="form1_field">
	                        <input name='dom_price' type='text' class='search' id='dom_price' size='10' value='<?php if($cmd=="edittld")echo $tld['dom_price']; ?>' />
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
						<?php echo $BL->props->lang['Registrar']; ?>
						</div>
						<div id="form1_field">
                        <select name='tld_registrar' class='search'>
                        <option><?php echo $BL->props->lang['manual']; ?></option>
                            <?php
                            foreach($BL->dr as $k=>$v){
                                if(isset($BL->dr_vals[$v]['active']) && $BL->dr_vals[$v]['active']=="yes"){
                                ?>
                            	<option value='<?php echo $v; ?>' <?php if($cmd=="edittld" && $tld['tld_registrar']==$v) echo "selected=\"selected\""; ?>><?php echo ucfirst($v); ?></option>
                            <?php
                            }
                            }
                            ?>
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
						<?php echo $BL->props->lang['active']; ?>
						</div>
						<div id="form1_field">
						  <select name='tld_active' class='search'>
						  <option value="yes" <?php if($cmd=="edittld" && $tld['tld_active']=="yes")echo "selected=\"selected\""; ?>><?php echo  $BL->props->lang['Yes']; ?></option>
						  <option value="no" <?php if($cmd=="edittld" && $tld['tld_active']=="no")echo "selected=\"selected\""; ?>><?php echo  $BL->props->lang['No']; ?></option>
						  </select>
                          </div></td>
                      </tr>
                      <tr>
                        <td colspan='2' class='text_grey'>
                        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                        </td>
                      </tr>

                      <tr>
                        <td class='text_grey'><div align='center'>
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' /></div></td>
                        <td class='text_grey'>
						<div id="form1_label">
						<?php echo $BL->props->lang['Name']; ?>
						</div>
						<div id="form1_field">
                            <input name='tld_name' type='text' class='search' id='tld_name' size='20' value='<?php if($cmd=="edittld")echo $tld['tld_name']; ?>' />
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
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' /></div></td>
                        <td class='text_grey'>
						<div id="form1_label">
						<?php echo $BL->props->lang['Whois_Server']; ?>
						</div>
						<div id="form1_field">
                        <input name='tld_server' type='text' class='search' id='tld_server' size='20' value='<?php if(isset($new_server_array['server']))echo $new_server_array['server']; elseif($cmd=="edittld")echo $tld['tld_server']; ?>' />
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
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' /></div></td>
                        <td class='text_grey'>
						<div id="form1_label">
						<?php echo $BL->props->lang['no_match_text']; ?>
						</div>
						<div id="form1_field">
                        <input name='tld_match' type='text' class='search' id='tld_match' size='20' value='<?php if(isset($new_server_array['server']))echo $new_server_array['nomatch']; elseif($cmd=="edittld")echo $tld['tld_match']; ?>' />
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
                        <?php if($cmd=="edittld"){ ?>
                        	<input type='hidden' name='price_id' value='<?php echo $tld['price_id']; ?>' />
                        <?php } ?>
                            <input type='hidden' name='cmd' value='<?php echo $cmd; ?>' />
                            <input name='submit' type='submit' class='search1' value='<?php if($cmd=="edittld")echo $BL->props->lang['Update'];else echo $BL->props->lang['add']; ?>' />
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
