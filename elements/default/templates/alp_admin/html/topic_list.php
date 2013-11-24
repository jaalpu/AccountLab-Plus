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
      <div class="tabs2" name='tt1' id='tt1' onmouseover="javascript:this.className='tabs1';" onmouseout="javascript:this.className='tabs2';" ><?php echo $BL->props->lang['~topics']; ?></div>
      <div class="tab_separator">&nbsp;</div>
      <div class="tabs" name='tt2' id='tt2' onmouseover="javascript:this.className='tabs1';" onmouseout="javascript:this.className='tabs';" ><a href="admin.php?cmd=add_topic" class="add_link"><?php echo $BL->props->lang['Add_Topic']; ?></a></div>
      <div class="tab_separator">&nbsp;</div>
    </div>
	<div id="display_list">
    <?php if($BL->getCmd("act_support")){ ?>
    <form name='form1' id='form1' method='POST' action='<?php echo $PHP_SELF; ?>'>
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
                      <td class="text_grey" width="1%" valign='top'>
                      <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                      </td>
					  <td class='text_grey'>					  						
                        <div id='form1_label'>
                    	<?php echo $BL->props->lang['enable_support']; ?></div>
                        <div id='form1_field'>
                            <select name='en_support' class='search' id='en_support'>
                              <option value='1' <?php if($conf['en_support']==1) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['Yes']; ?></option>
                            <option value='0' <?php if($conf['en_support']==0) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['No']; ?></option>
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
                      <td class="text_grey" width="1%" valign='top'>
                      <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                      </td>
                      <td class='text_grey'>                                            
                        <div id='form1_label'>
                        <?php echo $BL->props->lang['en_ticket_by_email']; ?></div>
                        <div id='form1_field'>
                            <select name='en_ticket_by_email' class='search' id='en_ticket_by_email' onchange="javascript:if(this.value==1)toggleTbodyOn('ensp');else toggleTbodyOff('ensp');">
                              <option value='1' <?php if($conf['en_ticket_by_email']==1) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['Yes']; ?></option>
                            <option value='0' <?php if($conf['en_ticket_by_email']==0) echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['No']; ?></option>
                          </select>
                          </div>
                      </td>
                      </tr>
                      
                    <tbody id='ensp' class='<?php if($conf['en_ticket_by_email']==1)echo 'on';else echo 'off'; ?>'>
                    
                    
                    <tr> 
                      <td colspan='2' class='text_grey'>
                      <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                      </td>
                    </tr>
                      <tr>
                      <td class="text_grey" width="1%" valign='top'>
                      <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                      </td>
                      <td class='text_grey'>                                            
                        <div id='form1_label'>
                        <?php echo $BL->props->lang['ticket_email_proto']; ?></div>
                        <div id='form1_field'>                            
                          <select name='ticket_email_proto' class='search' id='ticket_email_proto'>
                            <option value='imap' <?php if($conf['ticket_email_proto']=='imap') echo "selected=\"selected\""; ?>>imap</option>
                            <option value='pop3' <?php if($conf['ticket_email_proto']=='pop3') echo "selected=\"selected\""; ?>>pop3</option>
                            <option value='nntp' <?php if($conf['ticket_email_proto']=='nntp') echo "selected=\"selected\""; ?>>nntp</option>
                            <option value='pop3s' <?php if($conf['ticket_email_proto']=='pop3s') echo "selected=\"selected\""; ?>>pop3s</option>
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
                      <td class="text_grey" width="1%" valign='top'>
                      <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                      </td>
                      <td class='text_grey'>                                            
                        <div id='form1_label'>
                        <?php echo $BL->props->lang['ticket_email']; ?></div>
                        <div id='form1_field'>                            
                            <input type="text" name="ticket_email" id="ticket_email" class="search" value="<?php echo $conf['ticket_email']; ?>" size="25" />  
                          </div>
                      </td>
                      </tr>
                      
                      
                    <tr> 
                      <td colspan='2' class='text_grey'>
                      <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                      </td>
                    </tr>
                      <tr>
                      <td class="text_grey" width="1%" valign='top'>
                      <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                      </td>
                      <td class='text_grey'>                                            
                        <div id='form1_label'>
                        <?php echo $BL->props->lang['ticket_email_host']; ?></div>
                        <div id='form1_field'>                            
                            <input type="text" name="ticket_email_host" id="ticket_email_host" class="search" value="<?php echo $conf['ticket_email_host']; ?>" size="25" />  
                          </div>
                      </td>
                      </tr>
                      
                      
                    <tr> 
                      <td colspan='2' class='text_grey'>
                      <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                      </td>
                    </tr>
                      <tr>
                      <td class="text_grey" width="1%" valign='top'>
                      <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                      </td>
                      <td class='text_grey'>                                            
                        <div id='form1_label'>
                        <?php echo $BL->props->lang['ticket_email_port']; ?></div>
                        <div id='form1_field'>                            
                            <input type="text" name="ticket_email_port" id="ticket_email_port" class="search" value="<?php echo empty($conf['ticket_email_port'])?"143":$conf['ticket_email_port']; ?>" size="10" />  
                          </div>
                      </td>
                      </tr>
                      
                    <!--  
                    <tr> 
                      <td colspan='2' class='text_grey'>
                      <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                      </td>
                    </tr>
                      <tr>
                      <td class="text_grey" width="1%" valign='top'>
                      <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                      </td>
                      <td class='text_grey'>                                            
                        <div id='form1_label'>
                        <?php echo $BL->props->lang['ticket_email_mbox']; ?></div>
                        <div id='form1_field'>                            
                            <input type="text" name="ticket_email_mbox" id="ticket_email_mbox" class="search" value="<?php echo $conf['ticket_email_mbox']; ?>" size="25" />  
                          </div>
                      </td>
                      </tr>
                      //-->
                      <input type="hidden" name="ticket_email_mbox" id="ticket_email_mbox" value="<?php echo (empty($conf['ticket_email_mbox'])?"INBOX#novalidate-cert":$conf['ticket_email_mbox']); ?>" />
                      
                      
                    <tr> 
                      <td colspan='2' class='text_grey'>
                      <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                      </td>
                    </tr>
                      <tr>
                      <td class="text_grey" width="1%" valign='top'>
                      <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                      </td>
                      <td class='text_grey'>                                            
                        <div id='form1_label'>
                        <?php echo $BL->props->lang['ticket_email_user']; ?></div>
                        <div id='form1_field'>                            
                            <input type="text" name="ticket_email_user" id="ticket_email_user" class="search" value="<?php echo $conf['ticket_email_user']; ?>" size="25" />  
                          </div>
                      </td>
                      </tr>
                      
                    <tr> 
                      <td colspan='2' class='text_grey'>
                      <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                      </td>
                    </tr>
                      <tr>
                      <td class="text_grey" width="1%" valign='top'>
                      <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                      </td>
                      <td class='text_grey'>                                            
                        <div id='form1_label'>
                        <?php echo $BL->props->lang['ticket_email_pass']; ?></div>
                        <div id='form1_field'>                            
                            <input type="password" name="ticket_email_pass" id="ticket_email_pass" class="search" value="<?php echo $conf['ticket_email_pass']; ?>" size="25" />  
                          </div>
                      </td>
                      </tr>

                      
                      </tbody>
                      
                    <tr> 
                      <td colspan='2' class='text_grey'>
                      <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                      </td>
                    </tr>
                      <tr>
                      <td class="text_grey" width="1%" valign='top'>
                      <img src='elements/default/templates/alp_admin/images/spacer.gif' width='32' height='18' />
                      </td>
                      <td class='text_grey'>
                          <div id='form1_label'>
                          &nbsp;
                         </div>
                         <div id='form1_field'>
                          <input type='hidden' name='cmd' value='act_support'>
                          <input type='submit' name='submit' class='search1' value='<?php echo $BL->props->lang['submit']; ?>'>
                          </div>    
                      </td>
                      </tr>
                  </table>
				  <br />	
                </form>
                <?php } ?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list_table">
					<tr> 
                      <td colspan="4" class="text_grey"><img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" /></td>
                    </tr>
		        <?php if (!count($topics)) { ?>
				<tr>
					<td class="text_grey" colspan="4">
                    	<div align='center'>
                    	<?php echo $BL->props->lang['No_topics']; ?>
                    	</div>
					</td>
				</tr>
		        <?php } else { ?>														
                   <tr>
                    <td class='text_grey'>&nbsp;<b><?php echo $BL->props->lang['departments']; ?></b></td>
                      <td class='text_grey'><b><?php echo $BL->props->lang['Open_tickets']; ?></b></td>
                      <td class='text_grey'><b><?php echo $BL->props->lang['Closed_tickets']; ?></b></td>
                      <td class='text_grey' width='10%'>&nbsp;</td>
                    </tr>
					<?php
					foreach($topics as $temp){
						if($_SESSION['dept_id']==0 || array_search($temp['topic_id'],$topic_id_array)!==false){
					?>
                    <tr> 
                      <td colspan='4' class='text_grey'>
					  <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
					  </td>
                    </tr>					
		          <tr>
			          <td class='text_grey'>&nbsp;<?php echo $temp['topic_name']; ?></td>
			          <td class='text_grey'><?php echo $count_open[$temp['topic_id']]; ?></td>
			          <td class='text_grey'><?php echo $count_close[$temp['topic_id']]; ?></td>
			          <td class='text_grey'>
			          <div align='right'>
					  <?php if($BL->getCmd("edit_topic")){ ?>
			          <a href='<?php echo $PHP_SELF; ?>?cmd=edit_topic&topic_id=<?php echo $temp['topic_id']; ?>' class='text_link'><img src='elements/default/templates/alp_admin/images/edit_all.gif' alt='<?php echo $BL->props->lang['Edit']; ?>' border='0'></a>
			          <?php } ?>
			          &nbsp;
			          <?php if($BL->getCmd("del_topic")){ ?>
			          <a href="javascript:if(confirm('<?php echo $BL->props->lang['Do_you_want_to_delete_this_topic']; ?>'))document.location='<?php echo $PHP_SELF; ?>?cmd=del_topic&topic_id=<?php echo $temp['topic_id']; ?>'" class='text_link'><img src='elements/default/templates/alp_admin/images/delete.gif' alt='<?php echo $BL->props->lang['Delete']."?"; ?>' border='0'></a>
			          <?php } ?>
			          &nbsp;
			          </div>
			          </td>
			        </tr>
                    <?php } } ?>
		         <?php } ?>
					<tr> 
                      <td colspan="4" class="text_grey"><img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" /></td>
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
