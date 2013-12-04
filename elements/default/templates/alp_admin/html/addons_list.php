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
      <div class="tabs2" name='tt1' id='tt1' onmouseover="javascript:this.className='tabs1';" onmouseout="javascript:this.className='tabs2';" ><?php echo $BL->props->lang['~addons']; ?></div>
      <div class="tab_separator">&nbsp;</div>
      <div class="tabs" name='tt2' id='tt2' onmouseover="javascript:this.className='tabs1';" onmouseout="javascript:this.className='tabs';" ><a href="admin.php?cmd=add_addon" class="add_link"><?php echo $BL->props->lang['Add_addon']; ?></a></div>
      <div class="tab_separator">&nbsp;</div>
    </div>
	<div id="display_list">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list_table">
					<tr> 
                      <td class="tdheading" colspan="4">
					  <b>&nbsp;</b>
					  </td>
                    </tr>					
					<tr> 
                      <td colspan="4" class="text_grey"><img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" /></td>
                    </tr>
		<?php
		if (!count($addons))
		{
		?>
				<tr>
					<td class="text_grey" colspan="4">
                    	<div align='center'>
                    	<?php echo $BL->props->lang['No_addons']; ?>
                    	</div>
					</td>
				</tr>
		<?php
		}
		else
		{
		?>
					<td class='text_grey' width="1%">&nbsp;&nbsp;</td>
					<td class='text_grey' width="10%"></td>
                    <td class='text_grey'><b><?php echo $BL->props->lang['Name']; ?></b></td>
                    <td class='text_grey' width='10%'></td>
                    </tr>		
					<?php
					foreach($addons as $temp)
					{
					?>
                    <tr> 
                      <td colspan='4' class='text_grey'>
                      <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                      </td>
                    </tr>							
					<tr>
					<td class='text_grey' width="1%"></td>
					  <td class='text_grey'>
					  <?php if($temp['addon_index'] > 1){ ?>
					  &nbsp;<a href='<?php echo $PHP_SELF; ?>?cmd=addons&addon_id=<?php echo $temp['addon_id']; ?>&addon_index=<?php echo $temp['addon_index']; ?>&action=up'>
					  <img src='elements/default/templates/alp_admin/images/up.gif' border='0' /></a>
					  <?php } if(($temp['addon_index'] > 1) && ($temp['addon_index'] < count($addons))){ ?>
					  <br />
					  <?php } if($temp['addon_index'] < count($addons)){ ?>
					  &nbsp;<a href='<?php echo $PHP_SELF; ?>?cmd=addons&addon_id=<?php echo $temp['addon_id']; ?>&addon_index=<?php echo $temp['addon_index']; ?>&action=down'>
					  <img src='elements/default/templates/alp_admin/images/down.gif' border='0' /></a>
					  <?php } ?>
					  </td>
                      <td class='text_grey'>
					  <?php echo $temp['addon_name']; ?></td>
                      <td class='text_grey' width='10%'><div align='right'>
                      <?php if($BL->getCmd("edit_addon")){ ?>
                      <a href='<?php echo $PHP_SELF; ?>?cmd=edit_addon&addon_id=<?php echo $temp['addon_id']; ?>' class='text_link'><img src='elements/default/templates/alp_admin/images/edit_all.gif' alt='<?php echo $BL->props->lang['Edit']; ?>' border='0'></a>
                      <?php } ?>
                      &nbsp;
                      <?php if($BL->getCmd("del_addon")){ ?>
                      <a href="javascript:if(confirm('<?php echo $BL->props->lang['Do_you_want_to_delete_this_addon']; ?>'))document.location='<?php echo $PHP_SELF; ?>?cmd=del_addon&addon_id=<?php echo $temp['addon_id']; ?>'" class='text_link'><img src='elements/default/templates/alp_admin/images/delete.gif' alt='<?php echo $BL->props->lang['Delete']."?"; ?>' border='0'></a>
                      &nbsp;
                      <?php } ?>
                      &nbsp;</div></td>
                    </tr>
                    <?php
					}
					?>
		<?php
		}
		?>
					<tr> 
                      <td colspan="4" class="text_grey"><img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" /></td>
                    </tr>
                  </table>
				  <br />
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list_table">				
					<tr> 
                      <td class="text_grey" align="center">
					  <div style="vertical-align:middle">
					  <img src='elements/default/templates/alp_admin/images/edit_all.gif'> <?php echo $BL->props->lang['Edit']; ?>
					  &nbsp;
					  <img src='elements/default/templates/alp_admin/images/delete.gif'> <?php echo $BL->props->lang['Delete']; ?>
					  </div>
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
