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

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list_table">
    <tr> 
        <td colspan="7" class="tdheading">
          <b>&nbsp;</b>
        </td>
    </tr>
    <tr> 
        <td colspan="7" class="text_grey">
            <img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" />
        </td>
    </tr>           
    <tr> 
        <td class="text_grey" width="1%"><div align="left"><b>&nbsp;<?php echo $BL->props->lang['Nu']; ?></b></div></td>
        <td class="text_grey"><div align="left"><b><?php echo $BL->props->lang['Name']; ?></b></div></td>
        <td class="text_grey"><div align="left"><b><?php echo $BL->props->lang['Email']; ?></b></div></td>
        <td class="text_grey"><div align="left"><b><?php echo $BL->props->lang['Description']; ?></b></div></td>
        <td class="text_grey"><div align="right"><b><?php echo $BL->props->lang['Amount']; ?>&nbsp;&nbsp;</b></div></td>
        <td class="text_grey"><div align="left"><b><?php echo $BL->props->lang['remote_country']; ?></b></div></td>
        <td class="text_grey"><div align="left"><b></b></div></td>
    </tr>
    <?php
    $i=0;
    foreach($oOrders as $orphanorder_id=>$temp){
        $temp['remote_country'] = isset($temp['remote_country'])?$temp['remote_country']:"none";
        $co    = isset($BL->props->country[$temp['remote_country']])?$BL->props->country[$temp['remote_country']]:$temp['remote_country'];
        $temp1 = $BL->orphan_orders->getByKey($orphanorder_id);
    ?>
    <tr>
        <td  colspan='7' class='text_grey'>
            <img src="elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg" width="100%" height="1" />
        </td>
    </tr>       
    <tr>
        <td class='text_grey'><div align='left'>&nbsp;<?php echo ++$i; ?></div></td>
        <td class='text_grey'><div align='left'><?php echo $temp['name']; ?></div></td>
        <td class='text_grey'><div align='left'><?php echo $temp['email']; ?></div></td>
        <td class='text_grey'><div align='left'><?php echo $BL->getFriendlyDesc($temp['desc'],0,$temp['sld'].".".$temp['tld']); ?></div></td>
        <td class='text_grey'><div align='right'><b><?php echo $BL->toCurrency($temp['gross_amount'],null,1); ?>&nbsp;&nbsp;</b></div></td>
        <td class='text_grey'><div align='left'><?php echo $co; ?></div></td>
        <td class='text_grey'>
        <div align='right'>
            <?php if($BL->getCmd("addorder")){ ?>
            <a href="<?php echo $PHP_SELF; ?>?cmd=orphan_orders&action=view&orphanorder_id=<?php echo $orphanorder_id; ?>">
            <img src='elements/default/templates/alp_admin/images/edit_all.gif' border='0'>
            &nbsp;  
            </a>
            <a href="javascript:if(confirm('<?php echo $BL->props->lang['Do_you_want_to_confirm_this_orphan_order']; ?>'))document.location='<?php echo $PHP_SELF; ?>?cmd=orphan_orders&action=add&item_number=<?php echo $temp1['item_number']; ?>'">
            <img src='elements/default/templates/alp_admin/images/add_order.gif' border='0'>
            </a>
            &nbsp;
            <?php } ?>
            <?php if($BL->getCmd("delorder")){ ?>
            <a href="javascript:if(confirm('<?php echo $BL->props->lang['Do_you_want_to_delete_this_orphan_order']; ?>'))document.location='<?php echo $PHP_SELF; ?>?cmd=orphan_orders&action=del&orphanorder_id=<?php echo $orphanorder_id; ?>'">
            <img src='elements/default/templates/alp_admin/images/delete.gif' alt='<?php echo $BL->props->lang['Do_you_want_to_delete_this_order']; ?>' border='0'>
            </a>
            &nbsp;
            <?php } ?>
        </div>
        </td>
    </tr>
    <?php } ?>
    <tr> 
        <td colspan="7" class="text_grey">
            <img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" />
        </td>
    </tr>       
</table>
<br />
