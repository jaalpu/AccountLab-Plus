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
      <div class="tabs2" name='t1' id='t1' onmouseover="javascript:this.className='tabs1';" onmouseout="javascript:this.className='tabs2';" ><?php echo $BL->props->lang['~plans']; ?></div>
      <div class="tab_separator">&nbsp;</div>
      <div class="tabs" name='t2' id='t2' onmouseover="javascript:this.className='tabs1';" onmouseout="javascript:this.className='tabs';" ><a href="admin.php?cmd=addplan" class="add_link"><?php echo $BL->props->lang['+addplan']; ?></a></div>
      <div class="tab_separator">&nbsp;</div>
    </div>
	<div id="display_list">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list_table">
					<tr> 
                      <td colspan="10" class="tdheading">
					  <b>&nbsp;</b>
					  </td>
                    </tr>
					<tr> 
                      <td colspan="10" class="text_grey"><img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" /></td>
                    </tr>
		          <?php if (!count($plans)) { ?>
				<tr>
					<td class="text_grey" colspan="10">
                    	<div align='center'>
                    	<?php echo $BL->props->lang['No_Plans']; ?>
                    	</div>
					</td>
				</tr>
		          <?php } else { ?>														
                    <tr> 
                      <td class='text_grey'>&nbsp;&nbsp;</td>
                      <td class='text_grey'><div align='left'><b><?php echo $BL->props->lang['Nu']; ?></b></div></td>
                      <td class='text_grey'><div align='left'><b><?php echo $BL->props->lang['Plan']; ?></b></div></td>
                      <td class='text_grey'><div align='right'><b><?php echo $BL->props->lang['Setup']; ?></b></div></td>
                      <td class='text_grey'><div align='right'><b><?php echo $BL->props->lang['monthly']; ?></b> </div></td>
                      <td class='text_grey'><div align='right'><b><?php echo $BL->props->lang['quarterly']; ?></b></div></td>
                      <td class='text_grey'><div align='right'><b><?php echo $BL->props->lang['half_yearly']; ?></b></div></td>
                      <td class='text_grey'><div align='right'><b><?php echo $BL->props->lang['yearly']; ?></b></div></td>
                      <td class='text_grey'></td>
                      <td class='text_grey' width='25%'></td>
                    </tr>
                    <?php foreach($plans as $temp){ ?>
					<tr>
                      <td colspan='10' class='text_grey'>
					  <img src="elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg" width="100%" height="1" /></td>
                    </tr>					
					<tr> 
                    <td class='text_grey'>
                    <?php if($temp['plan_index'] > 1){ ?>
                    &nbsp;<a href='<?php echo $PHP_SELF; ?>?cmd=plans&plan_price_id=<?php echo $temp['plan_price_id']; ?>&plan_index=<?php echo $temp['plan_index']; ?>&action=up'>
                    <img src='elements/default/templates/alp_admin/images/up.gif' border='0' /></a>
                    <?php }if($temp['plan_index'] > 1 && $temp['plan_index'] < count($plans)){ ?>
                    <br />
                    <?php }if($temp['plan_index'] < count($plans)){ ?>
                    &nbsp;<a href='<?php echo $PHP_SELF; ?>?cmd=plans&plan_price_id=<?php echo $temp['plan_price_id']; ?>&plan_index=<?php echo $temp['plan_index']; ?>&action=down'>
                    <img src='elements/default/templates/alp_admin/images/down.gif' border='0' /></a>
                    <?php } ?>
                    <?php $cycle_data = $BL->products->getCycles($temp['plan_price_id']); ?>
                    </td>
                      <td class='text_grey'><div align='left'>&nbsp;&nbsp;<?php echo $temp['plan_price_id']; ?>&nbsp;</div></td>
                      <td class='text_grey'><div align='left'><?php echo $BL->getFriendlyName($temp['plan_price_id']); ?>&nbsp;</div></td>
                      <td class='text_grey'><div align='right'><?php echo $BL->toCurrency($temp['host_setup_fee'],null,1); ?>&nbsp;</div></td>
                      <td class='text_grey'><div align='right'><?php echo $BL->toCurrency($cycle_data['monthly'],null,1); ?>&nbsp;</div></td>
                      <td class='text_grey'><div align='right'><?php echo $BL->toCurrency($cycle_data['quarterly'],null,1); ?>&nbsp;</div></td>
                      <td class='text_grey'><div align='right'><?php echo $BL->toCurrency($cycle_data['half_yearly'],null,1); ?>&nbsp;</div></td>
                      <td class='text_grey'><div align='right'><?php echo $BL->toCurrency($cycle_data['yearly'],null,1); ?>&nbsp;</div></td>
                      <td class='text_grey'></td>
                      <td class='text_grey'>
                      <div align='right'>                      
                      <?php 
                      $server = $BL->servers->getByKey($temp['server_id']);                      
                      if($BL->getCmd("editplan")){ 
                        if($temp['acc_method']>0 && !empty($server['server_type'])){	
                            if($server['server_type']=="cpanel"){
                      ?>
                      <a href="javascript:if(confirm('<?php echo $BL->props->lang['Do_you_want_to_delete_sync_plan']; ?>'))document.location='<?php echo $PHP_SELF; ?>?cmd=plans&action=sync&plan_price_id=<?php echo $temp['plan_price_id']; ?>'">
                      <img src='elements/default/templates/alp_admin/images/sync.png' alt='<?php echo $BL->props->lang['sync']."?"; ?>' border='0' /></a>                       
                      &nbsp;
                      <?php } ?>
                      <img src='elements/default/templates/alp_admin/images/<?php echo $server['server_type']."-icon-small"; ?>.gif' alt='' border='0' />
                      &nbsp;
                      <?php } ?>
                      <a href='<?php echo $PHP_SELF; ?>?cmd=editplan&plan_price_id=<?php echo $temp['plan_price_id']; ?>'>
					  <img src='elements/default/templates/alp_admin/images/edit_all.gif' alt='<?php echo $BL->props->lang['Edit']; ?>' border='0' /></a>
                      <?php } ?>
                      &nbsp;
                      <?php if($BL->getCmd("delplan")){ ?>
                      <a href="javascript:if(confirm('<?php echo $BL->props->lang['Do_you_want_to_delete_this_plan']; ?>'))document.location='<?php echo $PHP_SELF; ?>?cmd=delplan&plan_price_id=<?php echo $temp['plan_price_id']; ?>'">
					  <img src='elements/default/templates/alp_admin/images/delete.gif' alt='<?php echo $BL->props->lang['Delete']."?"; ?>' border='0' /></a>
                      <?php } ?>
					  &nbsp;
                      </div>
                      </td>
                    </tr>
                   <?php } } ?>
					<tr> 
                      <td colspan="10" class="text_grey">&nbsp;</td>
                    </tr>			
                  </table>
                  <br />
                    <table width="100%" border="0" cellspacing="2" cellpadding="2" class="list_table">              
                    <form name='form1' id='form1' method='post' action='<?php echo $PHP_SELF; ?>'>
                    <tr> 
                      <td class="text_grey" width='1%'>&nbsp;</td>
                      <td class="text_grey">
                      <b><?php echo $BL->props->lang['en_domain_only'] ?></b>
                      &nbsp;
                      <input type='checkbox' name='en_domain_only' value='1' <?php if($conf['en_domain_only']==1)echo "checked=\"checked\""; ?> class='search' />
                      &nbsp;
                      <input type='hidden' name='cmd' value='plans' />
                      <input type='hidden' name='action' value='en_domain_only' />
                      <input type='submit' name='submit' class='search1' value='<?php echo $BL->props->lang['submit']; ?>'>
                      </td>
                    </tr>
                    </form>
                    </table>
				  <br />
					<table width="100%" border="0" cellspacing="2" cellpadding="2" class="list_table">				
					<tr> 
                      <td class="text_grey" align="center">
					  <div style="vertical-align:middle">
                      <img src='elements/default/templates/alp_admin/images/sync.png'  border='0' /> <?php echo $BL->props->lang['sync']; ?>
					  &nbsp;
                      <img src='elements/default/templates/alp_admin/images/edit_all.gif' border="0" /> <?php echo $BL->props->lang['Edit']; ?>
					  &nbsp;
					  <img src='elements/default/templates/alp_admin/images/delete.gif' border="0" /> <?php echo $BL->props->lang['Delete']; ?>
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
