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
    <?php if(!isset($REQUEST['ticket_status']) || $REQUEST['ticket_status']!=3){ ?>
      <div class="tabs2" name='tt1' id='tt1' onmouseover="javascript:this.className='tabs1';" onmouseout="javascript:this.className='tabs2';" ><?php echo $BL->props->lang['Open_tickets']; ?></div>
      <div class="tab_separator">&nbsp;</div>
      <div class="tabs" name='tt2' id='tt2' onmouseover="javascript:this.className='tabs1';" onmouseout="javascript:this.className='tabs';" ><a href="admin.php?cmd=ticket&ticket_status=3" class="add_link"><?php echo $BL->props->lang['Closed_tickets']; ?></a></div>
      <div class="tab_separator">&nbsp;</div> 
    <?php } ?> 
    <?php if(isset($REQUEST['ticket_status']) && $REQUEST['ticket_status']==3){ ?>
      <div class="tabs" name='tt1' id='tt1' onmouseover="javascript:this.className='tabs1';" onmouseout="javascript:this.className='tabs';" ><a href="admin.php?cmd=ticket" class="add_link"><?php echo $BL->props->lang['Open_tickets']; ?></a></div>
      <div class="tab_separator">&nbsp;</div>
      <div class="tabs2" name='tt2' id='tt2' onmouseover="javascript:this.className='tabs1';" onmouseout="javascript:this.className='tabs2';" ><?php echo $BL->props->lang['Closed_tickets']; ?></div>
      <div class="tab_separator">&nbsp;</div> 
    <?php } ?> 
    </div>
	<div id="display_list">
    <?php include $BL->props->get_page("templates/alp_admin/html/_tickets.php"); ?>
    <table width="100%" border="0" cellspacing="2" cellpadding="2" class="list_table">				
    <tr> 
    <td class="text_grey" align="center">
    <div style="vertical-align:middle">
    <img src='elements/default/templates/alp_admin/images/edit_all.gif'> <?php echo $BL->props->lang['Edit']; ?>
    &nbsp;
    <img src='elements/default/templates/alp_admin/images/delete.gif'> <?php echo $BL->props->lang['Close']; ?>
    </div>
    </td>
    </tr>
    </table>		
	</div>
</div>
<!--end content -->
<div id="navBar">
<table width="80%" cellpadding="0" cellspacing="0" border="0">
		<?php if($BL->getCmd("viewTicket")){ ?>
		<form name='form1' id='form1' method='POST' action='<?php echo $PHP_SELF; ?>'>
		<tr> 
		  <td class='text_grey' width="20%">&nbsp;</td>
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
