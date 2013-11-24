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
      <div class="tabs2" name='tt1' id='tt1' onmouseover="javascript:this.className='tabs1';" onmouseout="javascript:this.className='tabs2';" ><?php echo $BL->props->lang['~billing_cycles']; ?></div>
      <div class="tab_separator">&nbsp;</div>
      <div class="tabs" name='tt2' id='tt2' onmouseover="javascript:this.className='tabs1';" onmouseout="javascript:this.className='tabs';" ><a href="admin.php?cmd=add_cycle" class="add_link"><?php echo $BL->props->lang['+add_cycle']; ?></a></div>
      <div class="tab_separator">&nbsp;</div>
    </div>
	<div id="display_list">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="list_table">
    <tr> 
      <td colspan="4" class="tdheading">
      <b>&nbsp;</b>
      </td>
    </tr>
    <tr> 
    <td colspan="4" class="text_grey"><img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" /></td>
    </tr>
    <tr> 
    <td class='text_grey'><div align='left'>&nbsp;<b><?php echo $BL->props->lang['Nu_Months']; ?></b></div></td>
    <td class='text_grey'><div align='left'><b><?php echo $BL->props->lang['language_key']; ?></b></div></td>
    <td class='text_grey'><div align='left'><b><?php echo $BL->props->lang['language_str']; ?></b></div></td>
    <td width='10%' class='text_grey'><div align='left'><b></b></div></td>
    </tr>
    <?php foreach ($cycles as $temp){ ?>
    <tr>
      <td colspan='4' class='text_grey'>
      <img src="elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg" width="100%" height="1" />
      </td>
    </tr>
    <tr>
        <td class='text_grey'><div align='left'>&nbsp;<?php echo $temp['cycle_month']; ?></div></td>
        <td class='text_grey'><div align='left'><?php echo $temp['cycle_name']; ?></div></td>
        <td class='text_grey'><div align='left'><?php if(isset($BL->props->lang[$temp['cycle_name']]))echo $BL->props->lang[$temp['cycle_name']]; else echo $BL->props->lang['lang_not_found']; ?></div></td>
        <td class='text_grey'>
        <div align='right'>
        <?php if($BL->getCmd("edit_cycle") && $temp['cycle_month']!=1 && $temp['cycle_month']!=3 && $temp['cycle_month']!=6 && $temp['cycle_month']!= 12){ ?>
        <a href='<?php echo $PHP_SELF; ?>?cmd=edit_cycle&id=<?php echo $temp['id']; ?>' class='text_link'>
        <img src='elements/default/templates/alp_admin/images/edit_all.gif' alt='<?php echo $BL->props->lang['Edit']; ?>' border='0' />
        </a>
        &nbsp;
        <?php } ?>
        <?php if($BL->getCmd("del_cycle") && $temp['cycle_month']!=1 && $temp['cycle_month']!=3 && $temp['cycle_month']!=6 && $temp['cycle_month']!= 12){ ?>
        <a href="javascript:if(confirm('<?php echo $BL->props->lang['CYCLE_DEL']; ?>'))document.location='<?php echo $PHP_SELF; ?>?cmd=del_cycle&id=<?php echo $temp['id']; ?>'" class='text_link'>
        <img src='elements/default/templates/alp_admin/images/delete.gif' alt='<?php echo $BL->props->lang['Delete']."?"; ?>' border='0' />
        </a>
        &nbsp;
        <?php } ?>
        </div>
        </td>
    </tr>
    <?php } ?>
    <tr> 
    <td colspan="4" class="text_grey">
    <img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" />
    </td>
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
