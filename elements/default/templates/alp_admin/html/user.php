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
      <div class="tabs" name='tt1' id='tt1' onmouseover="javascript:this.className='tabs1';" onmouseout="javascript:this.className='tabs';" ><a href="admin.php?cmd=users" class="add_link"><?php echo $BL->props->lang['users']; ?></a></div>
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
						<?php echo $BL->props->lang['username']; ?>
						</div>
						<div id="form1_field">
                         <input name='username' type='text' class='search' id='username' size='20' value="<?php if($cmd=="edit_user")echo $User['username']; ?>" />
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
						<?php echo $BL->props->lang['password']; ?>
						</div>
						<div id="form1_field">
						<?php if ($cmd == "add_user") { ?>
						<input name='pass' type='password' class='search' id='pass' size='20' value=''>
						<?php }elseif($_SESSION['admin_id'] == 1 || $_SESSION['admin_id']==$id) { ?>
						<input name='change_pass' type='password' class='search' id='change_pass' size='20' value=''>
						<?php }else { ?>
						****
						<?php } ?>
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
						<?php echo $BL->props->lang['Email']; ?>
							</div>
							<div id="form1_field">
                            <input name='email' type='text' class='search' id='email' size='30' value='<?php if($cmd=="edit_user")echo $User['email']; ?>' />
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
                        <?php echo $BL->props->lang['admin_theme']; ?>
                        </div>
                        <div id="form1_field">
                        <select name="admin_theme" id="admin_theme" class="search">
                          <?php foreach($BL->props->admin_theme_list as $k=>$v){ ?>
                          <option value="<?php echo $v; ?>" <?php if($cmd=="edit_user" && $User['admin_theme']==$v)echo "selected=\"selected\""; ?> ><?php echo $v; ?></option>
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
                        <td class='text_grey' valign="top">
                        <div align='center'>
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
                        </div>
                        </td>
                        <td class='text_grey' valign="top">
						<div id="form1_label">
						<?php echo $BL->props->lang['departments']; ?>
						</div>
						<div id="form1_field">
						<?php if(isset($id) && $id == 1){ ?>
						<input type='checkbox' name='topic_id_array[]' id='topic_id_array[]' value='0' <?php if($id==1)echo "checked=\"checked\""; ?>>&nbsp;<?php echo $BL->props->lang['all']; ?>
						<?php  }  if(!isset($id) || $id != 1){ foreach($topics as $t){ ?>
						  <input type='checkbox' name='topic_id_array[]' id='topic_id_array[]' value='<?php echo $t['topic_id']; ?>' <?php if(isset($id) && array_search($t['topic_id'],$topic_id_array)!==false)echo "checked=\"checked\""; ?>>&nbsp;<?php echo $t['topic_name']; ?><br>
						<?php } } ?>
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
                        <td class='text_grey'>
						<div id="form1_label">
						<?php echo $BL->props->lang['Allow_cmds']; ?>
						</div>
						<div id="form1_field">
						<?php
						$i        = 0;
						$j        = 0;
						$k        = 1;
						$super    = "";
						$submenu  = 0;
						$javascript_string = "";
						foreach ($BL->props->admin_cmds as $c) {
							if (substr($c, 0, 1) == "^") {
								$super = "U_".substr($c, 1, strlen($c));
						?>
								<input type='hidden' id='commands[<?php echo $i; ?>]' name='commands[<?php echo $i; $i++; ?>]' value='<?php echo $c; ?>' class='search' />
								<img src="elements/default/templates/alp_admin/images/menu_icon_plus.gif"  style="cursor:hand; cursor:pointer" onClick="expandcontent('<?php echo $super; ?>')">
							<?php
								echo "<b><a href=\"#\" class=\"menuitem2\" style=\"cursor:hand; cursor:pointer\" onClick=\"expandcontent('".$super."')\">".$BL->props->lang[$c]."</a></b><br><div id='".$super."' class=\"switchcontent\">";
							} if (substr($c, 0, 1) == "~") {
								if($submenu==1) {
									$submenu   = 2;
									$javascript_string .= "\n}\n</script>\n\n";
									$submenu   = 0;
									echo $javascript_string;
								}
							?>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='checkbox' class='search' id='<?php echo $super."_".$k; ?>' name='commands[<?php echo $i; $i++; ?>]' value='<?php echo $c; ?>' <?php if(isset($id) && ($id == 1  || array_search($c,$listed_cmds)!==false)) echo  "checked"; ?> onChange="javascript:chk<?php echo $k;$k++; ?>(this.form)">
							<?php
								echo $BL->props->lang[$c]."<br>";
							} if (substr($c, 0, 1) == "+") {
								if($submenu==0) {
									$submenu = 1;
									$javascript_string  = "\n\n<script language=\"javascript\">\nfunction chk".($k-1)."(item)\n{\n\n";
									$javascript_string .= "item.".$super.($j+1).".checked=item.".$super."_".($k-1).".checked;\n";
								} else {
									$javascript_string.="item.".$super.($j+1).".checked=item.".$super."_".($k-1).".checked;\n";
								}
								$j++;
							?>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='checkbox' class='search' id='<?php echo $super.$j; ?>' name='commands[<?php echo $i; $i++; ?>]' value='<?php echo $c; ?>' <?php if(isset($id) && ($id == 1  || array_search($c,$listed_cmds)!==false)) echo  "checked"; ?> onChange="javascript:this.form.<?php echo $super."_".($k-1); ?>.checked=this.form.<?php echo $super.$j; ?>.checked;">
							<?php
								echo $BL->props->lang[$c]."<br>";
							} if ($c== "-") {
							?>
								<input type='hidden' id='commands[<?php echo $i; ?>]'  name='commands[<?php echo $i; $i++; ?>]' value='<?php echo $c; ?>'></div>
							<?php } if(substr($c, 0, 1) == "-" && $c != "-") { ?>
								<input type='hidden' id='commands[<?php echo $i; ?>]' name='commands[<?php echo $i; $i++; ?>]' value='<?php echo $c; ?>'>
				<?php } } ?>
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
                            <?php if($cmd=="edit_user"){ ?>
							<input name='id'  id='id' type='hidden' value='<?php echo $id; ?>' />
                            <?php } ?>
                        	<input name='cmd' id='cmd' type='hidden' value='<?php echo $cmd; ?>' />
                            <input name='submit' type='submit' class='search1' value='<?php if($cmd=="edit_user")echo $BL->props->lang['Update'];else echo $BL->props->lang['add']; ?>' />
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
