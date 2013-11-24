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
      <div class="tabs2" name='tt1' id='tt1' onmouseover="javascript:this.className='tabs1';" onmouseout="javascript:this.className='tabs2';" ><?php echo $BL->props->lang['~ips']; ?></div>
      <div class="tab_separator">&nbsp;</div>
      <div class="tabs" name='tt2' id='tt2' onmouseover="javascript:this.className='tabs1';" onmouseout="javascript:this.className='tabs';" ><a href="admin.php?cmd=add_ip" class="add_link"><?php echo $BL->props->lang['+add_ip']; ?></a></div>
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
					  <tr>
					  <td class="text_grey" width="2%">&nbsp;</td>
					  <td class='text_grey'>                      
						<form name='form1' id='form1' method='POST' action='<?php echo $PHP_SELF; ?>' onsubmit="javascript:if(this.security_degree.value==0)return true;<?php if($BL->accessIPCheck(null,true)){echo "return true;";}else{ echo "if(confirm('".$BL->props->lang['current_ip_not_defined'].$BL->props->lang['detected_ip'].$BL->utils->realip()."'))return true;else return false;"; }; ?>">
                    	<?php echo $BL->props->lang['security_degree']; ?>
                            <select name='security_degree' class='search' id='security_degree'>
                              <option value='2' <?php if($conf['security_degree']==2) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['security_degree_2']; ?></option>
                              <option value='1' <?php if($conf['security_degree']==1) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['security_degree_1']; ?></option>
                              <option value='0' <?php if($conf['security_degree']==0) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['security_degree_0']; ?></option>
                          </select>
                          <input type='hidden' name='cmd' value='<?php echo $cmd; ?>'>
                          <input type='hidden' name='action' value='change_security_level'>
                          <input type='submit' name='submit' class='search1' value='<?php echo $BL->props->lang['Change']; ?>'>
						</form>
					  </td>
					  </tr>
					<tr> 
                      <td class="text_grey" colspan="2">&nbsp;</td>
                    </tr>		
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
                      <tr>
                      <td class="text_grey" width="2%">&nbsp;</td>
                      <td class='text_grey'>                      
                        <form name='form2' id='form2' method='POST' action='<?php echo $PHP_SELF; ?>'>
                        <?php echo $BL->props->lang['en_image_verification']; ?><br />
                        &nbsp;&nbsp;<input type='checkbox' value='1' name='image_verification_admin' id='image_verification_admin' <?php if(!empty($conf['image_verification_admin']))echo "checked"; ?> class='search' />&nbsp;<?php echo $BL->props->lang['for_admins']; ?><br />
                        &nbsp;&nbsp;<input type='checkbox' value='1' name='image_verification_customer' id='image_verification_customer' <?php if(!empty($conf['image_verification_customer']))echo "checked"; ?> class='search' />&nbsp;<?php echo $BL->props->lang['for_customers']; ?><br />
                          <input type='hidden' name='cmd' value='<?php echo $cmd; ?>'><br />
                          <input type='hidden' name='action' value='image_verification'>
                          <input type='submit' name='submit' class='search1' value='<?php echo $BL->props->lang['Change']; ?>'>
                        </form>
                      </td>
                      </tr>
                    <tr> 
                      <td class="text_grey" colspan="2">&nbsp;</td>
                    </tr>   
                    						
                  </table>
				  <br />	

			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list_table">
					<tr> 
                      <td colspan="4" class="text_grey">&nbsp;</td>
                    </tr>
		      <?php if (!count($access_ips)) { ?>
				<tr>
					<td class="text_grey" colspan="4">
                    	<div align='center'>
                    	<?php echo $BL->props->lang['IPS_No']; ?>
                    	</div>
					</td>
				</tr>
		      <?php } else { ?>
					<td class='text_grey' width="1%"></td>
                      <td class='text_grey'>
					  <b><?php echo $BL->props->lang['access_IP_address']; ?></b></td>
                      <td class='text_grey'>
                      <b><?php echo $BL->props->lang['admin_user']; ?></b></td>
                      <td class='text_grey' width='10%'></td>
                    </tr>		
					<?php foreach ($access_ips as $temp) { ?>
                    <tr> 
                      <td colspan='4' class='text_grey'>
                      <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                      </td>
                    </tr>							
					<tr>
					<td class='text_grey' width="1%"></td>
                      <td class='text_grey'>
					  <?php echo $temp['ip_address']; ?></td>
                      <td class='text_grey'>
                      <?php echo $users[$temp['admin_id']]['username']." (".$users[$temp['admin_id']]['email'].")"; ?></td>
                      <td class='text_grey' width='10%'><div align='right'>
                      <?php if($BL->getCmd("edit_ip")){ ?>
                      <a href='<?php echo $PHP_SELF; ?>?cmd=edit_ip&id=<?php echo $temp['id']; ?>' class='text_link'><img src='elements/default/templates/alp_admin/images/edit_all.gif' alt='<?php echo $BL->props->lang['Edit']; ?>' border='0'></a>
                      &nbsp;
                      <?php } ?>
                      
                      <?php if($BL->getCmd("delmaindomain")){ ?>
                      <a href="javascript:if(confirm('<?php echo $BL->props->lang['ip_DEL']; ?>'))document.location='<?php echo $PHP_SELF; ?>?cmd=del_ip&id=<?php echo $temp['id']; ?>'" class='text_link'><img src='elements/default/templates/alp_admin/images/delete.gif' alt='<?php echo $BL->props->lang['Delete']."?"; ?>' border='0'></a>
                      &nbsp;
                      <?php } ?>
                      </div></td>
                    </tr>
                    <?php } ?>
		      <?php } ?>
					<tr> 
                      <td colspan="4" class="text_grey">&nbsp;</td>
                    </tr>
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
