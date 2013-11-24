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
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list_table">
					<tr> 
                      <td class="tdheading" colspan="4">
					  <b>&nbsp;<?php echo $BL->props->lang['ticket_no'].$ticket['ticket_id']; ?></b>
					  </td>
                    </tr>
					<tr> 
                      <td class="text_grey" colspan="4"><img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" /></td>
                    </tr>
					<tr>
					  <td class='text_grey' width="20%">
					  &nbsp;&nbsp;
					  <?php echo $BL->props->lang['Name']; ?> </td>
					  <td class="text_grey" width="5%">&nbsp;:&nbsp;</td>
					  <td class='text_grey' width="35%">
					  <?php echo "<b><a href=\"".$PHP_SELF."?cmd=editcustomers&id=".$ticket['cust_id']."\">".$BL->getCustomerFieldValue("name",$ticket['cust_id'])."</a></b>"; ?>
					  </td>
					  <td class="text_grey">&nbsp;</td>
					</tr>
					<tr>
					  <td class='text_grey' width="20%">
					  &nbsp;&nbsp;
					  <?php echo $BL->props->lang['department']; ?> </td>
					  <td class="text_grey" width="5%">&nbsp;:&nbsp;</td>
					  <td class='text_grey' width="35%">
					  <?php echo "<b>".$topic['topic_name']."</b>"; ?>
					  </td>
					  <td class="text_grey">&nbsp;</td>
					</tr>					
					<tr>
					  <td class='text_grey' width="20%">
					  &nbsp;&nbsp;
					  <?php echo $BL->props->lang['Date']; ?> </td>
					  <td class="text_grey" width="5%">&nbsp;:&nbsp;</td>
					  <td class='text_grey' width="35%">
					  <?php echo "<b>".$BL->fDate($ticket['ticket_date'],' H:i:s')."</b>"; ?>
					  </td>
					  <td class="text_grey">&nbsp;</td>
					</tr>	
					<tr>
					  <td class='text_grey' width="20%">
					  &nbsp;&nbsp;
					  <?php echo $BL->props->lang['Status']; ?> </td>
					  <td class="text_grey" width="5%">&nbsp;:&nbsp;</td>
					  <td class='text_grey' width="35%">
					  <?php echo "<b>".$BL->props->ticket_status[$ticket['ticket_status']]."</b>"; ?>
					  </td>
					  <td class="text_grey">
					  </td>
					</tr>
                    <tr>
                      <td class='text_grey' width="20%">
                      &nbsp;&nbsp;
                      <?php echo $BL->props->lang['ticket_subject']; ?> </td>
                      <td class="text_grey" width="5%">&nbsp;:&nbsp;</td>
                      <td class='text_grey' width="35%">
                      <?php echo "<b>".$ticket['ticket_subject']."</b>"; ?>
                      </td>
                      <td class="text_grey">
                      </td>
                    </tr>
					<tr> 
                      <td class="text_grey" colspan="4">
					  	<img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
					  </td>
                    </tr>
					<tr> 
                      <td class="text_grey" colspan="4">
					  	<p style="padding:0;padding-left:25px;">
					  	<?php echo $ticket['ticket_text']; ?>
						</p>
					  </td>
                    </tr>	
					<tr> 
                      <td class="text_grey" colspan="4">
					  	<img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
					  </td>
                    </tr>
					<tr> 
                      <td class="text_grey" colspan="4">
					  &nbsp;&nbsp;
						  <?php
							if ($ticket['ticket_status'] == 3 && $BL->getCmd("openTicket"))
                            {
								echo "<a href=\"".$PHP_SELF."?cmd=openTicket&ticket_id=".$ticket['ticket_id']."\"><b>".$BL->props->lang['re-open']."</b></a>";
                            }
                            elseif($BL->getCmd("closeTicket"))
                            {
								echo "<a href=\"".$PHP_SELF."?cmd=closeTicket&ticket_id=".$ticket['ticket_id']."\"><b>".$BL->props->lang['close_this_ticket']."</b></a>";
                            }
						  ?>
					  </td>
                    </tr>										
					<tr> 
                      <td class="text_grey" colspan="4"><img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" /></td>
                    </tr>									
                  </table>
				  <br />
		         <?php if ($ticket['ticket_status'] != 3) { ?>
				<form name='form1' id='form1' method='post' action='<?php echo $PHP_SELF; ?>'>
				    <table width='100%' border='0' cellspacing='0' cellpadding='0' class="list_table">
					<tr> 
                      <td class="tdheading">
					  <b>&nbsp;<?php echo $BL->props->lang['reply']; ?></b>
					  </td>
                    </tr>  
					<tr> 
                      <td class="text_grey"><img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" /></td>
                    </tr>					                    
					<tr>
                     <td class='text_grey'>
					 &nbsp;&nbsp;
                        <textarea name='reply_text' cols='55' rows='10'></textarea>
                     </td>
                     </tr>
					<tr> 
                      <td class="text_grey"><img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" /></td>
                    </tr>						 
                     <tr>
                     <td class='text_grey'>
					 &nbsp;&nbsp;
                        	<input type='hidden' name='ticket_status' value='0' />
                        	<input type='hidden' name='reply_by' value='<?php echo $_SESSION['username']; ?>' />
                            <input type='hidden' name='reply_date' value='<?php echo date('Y-m-d H:i:s'); ?>' />
                        	<input type='hidden' name='ticket_id' value='<?php echo $ticket['ticket_id']; ?>' />
                            <input type='hidden' name='cmd' value='<?php echo $cmd; ?>' />
                            <input name='submit' type='submit' class='search1' value='<?php echo $BL->props->lang['submit']; ?>' />
                     </td>
                     </tr>
					<tr> 
                      <td class="text_grey"><img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" /></td>
                    </tr>						 
                    </table>
				  </form>
				  <br />
            <?php } ?>
			<table width='100%' border='0' cellspacing='0' cellpadding='0' class="list_table">
					<tr> 
                      <td class="tdheading">
					  <b>&nbsp;<?php echo $BL->props->lang['replies']; ?></b>
					  </td>
                    </tr>  
                    <?php foreach ($replies as $reply) { ?>					
					<tr> 
                      <td class="text_grey">
					  <p style="padding-left:5px;">
					  <?php echo "<b>".$BL->props->lang['reply_by']." :</b> ".$reply['reply_by']."<br />"; ?>
					  <?php echo "<b>".$BL->props->lang['Date']." : </b>".$BL->fDate($reply['reply_date'], ' H:i:s')."<br />"; ?>
					  <?php echo $reply['reply_text']; ?>
					  </p>					
					  </td>
                    </tr>
				      <tr>
		              	<td class='text_grey'>
		                   <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
		                 </td>
		              </tr> 					
					<?php } ?>				
            </table>		
	</div>
</div>
<!--end content -->
<div id="navBar">
<table width="80%" cellpadding="0" cellspacing="0" border="0">
		<?php if($BL->getCmd("viewTicket")){ ?>
		<form name='form2' id='form2' method='POST' action='<?php echo $PHP_SELF; ?>'>
		<tr> 
		  <td class='text_grey' width="20%">&nbsp;
          
          </td>
          <td class='text_grey'>
            <b><?php echo $BL->props->lang['View_ticket_by_ticket_id']; ?></b><br>
            <?php echo $BL->props->lang['ticket_no']; ?><input type='text' name='ticket_id' value='' size='4' class='search'>
            <input type='hidden' name='cmd' value='viewTicket'>
            <input type='submit' name='submit1' class='search1' value='<?php echo $BL->props->lang['View']; ?>'>
          </td>
        </tr> 
		</form>    
        <tr> 
          <td colspan='2'>
          <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen.jpg' width='180' height='2'>
          </td>
        </tr>        
        <?php } ?>	
</table>
<?php include_once $BL->props->get_page("templates/alp_admin/html/_sidepanel.php"); ?>	
</div>
<!--end navbar -->
<?php include_once $BL->props->get_page("templates/alp_admin/html/footer.php"); ?>
