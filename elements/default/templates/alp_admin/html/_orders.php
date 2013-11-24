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
        <form name='form_orderby' id='form_orderby' action="admin.php" method="post">
        <input type='hidden' name='search_term' id='search_term' value='<?php echo isset($BL->REQUEST['search_term'])?$BL->REQUEST['search_term']:""; ?>' >
        <input type='hidden' name='cmd' id='cmd' value='<?php echo $cmd; ?>' />
        <input type='hidden' name='id' id='id' value='<?php echo isset($BL->REQUEST['id'])?$BL->REQUEST['id']:0; ?>' />
        <td colspan="9" class="tdheading" align='right'>
            <?php if($cmd=="vieworders"){ ?>
            <?php echo $BL->props->lang['ORDER_BY']; ?>
            <select name="orderby1" id="orderby1" class="search" onchange="javascript:this.form.submit();">
            <option value='sub_id' <?php if($BL->REQUEST['orderby1']=='sub_id')echo "selected"; ?> ><?php echo $BL->props->lang['Nu']; ?></option>
            <option value='sign_date' <?php if($BL->REQUEST['orderby1']=='sign_date')echo "selected"; ?> ><?php echo $BL->props->lang['Date']; ?></option>
            <option value='cust_status' <?php if($BL->REQUEST['orderby1']=='cust_status')echo "selected"; ?> ><?php echo $BL->props->lang['Status']; ?></option>
            </select>
            <select name="orderby2" id="orderby2" class="search" onchange="javascript:this.form.submit();">
            <option value='DESC' <?php if($BL->REQUEST['orderby2']=='DESC')echo "selected"; ?> ><?php echo $BL->props->lang['DESC']; ?></option>
            <option value='ASC' <?php if($BL->REQUEST['orderby2']=='ASC')echo "selected"; ?> ><?php echo $BL->props->lang['ASC']; ?></option>
            </select>
            <?php } ?>
            &nbsp;<?php echo isset($pagination)?$pagination:""; ?>
        </td>
        </form>
    </tr>
    <tr> 
        <td colspan="9" class="text_grey">
            <img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" />
        </td>
    </tr> 
    <tr> 
        <td class="text_grey" width="1%"><div align="left"><b>&nbsp;<?php echo $BL->props->lang['Nu']; ?></b></div></td>
        <td class="text_grey"><div align="left"><b><?php echo $BL->props->lang['Plan']; ?></b></div></td>
        <td class="text_grey"><div align="left"><b><?php echo $BL->props->lang['Domain']; ?></b></div></td>
        <td class="text_grey" colspan="2"><div align="left"><b><?php echo $BL->props->lang['Name']; ?></b></div></td>
        <td class="text_grey"><div align="left"><b><?php echo $BL->props->lang['Date']; ?></b></div></td>
        <td class="text_grey"><div align="left"><b><?php echo $BL->props->lang['Status']; ?></b></div></td>
        <td class="text_grey"><div align="left"><b><?php echo $BL->props->lang['next_bill_date']; ?></b></div></td>
        <td class="text_grey"><div align="left"><b></b></div></td>
    </tr>
    <?php foreach($Orders as $temp){ ?>
    <?php
        $rec_date_array           = $BL->utils->getDateArray(date('Y-m-d',strtotime($temp['rec_next_date'])));                    
        $upcoming_bill_date_array = $BL->utils->getXmonthsAfter((empty ($temp['bill_cycle'])?12:$temp['bill_cycle']), $rec_date_array);        
    ?>
    <tr>
        <td colspan='9' class='text_grey'>
            <img src="elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg" width="100%" height="1" />
        </td>
    </tr>       
    <tr>
        <td class='text_grey'><div align='left'>&nbsp;<?php echo $conf['order_prefix'].$temp['sub_id'].$conf['order_suffix']; ?>&nbsp;</div></td>
        <td class='text_grey'>
        <div align='left'>
        <?php echo $BL->getFriendlyName($temp['product_id']); ?>
        <?php if($temp['acct_status']!=0) { ?>
        <?php $server = $BL->servers->getByKey($temp['server_id']); ?>
        <img src='elements/default/templates/alp_admin/images/<?php echo $server['server_type']."-icon-small"; ?>.gif' alt='' border='0' />
        <?php } ?>
        </div>
        </td>
        <td class='text_grey'><div align='left'><?php echo $temp['domain_name']; if($temp['dom_reg_comp']=='1')echo "<font size='3' color='red'><b>&reg;</b></font>"; ?></div></td>
        <td class='text_grey'><div align='left'><a href="<?php echo $PHP_SELF; ?>?cmd=editcustomers&id=<?php echo $temp['customer_id']; ?>"><?php echo $BL->getCustomerFieldValue("name",$temp['customer_id']); ?></a></div></td>
        <td class='text_grey'><div align='left'>[<a href="<?php echo $PHP_SELF; ?>?cmd=vieworders&id=<?php echo $temp['customer_id']; ?>"><?php echo $BL->props->lang['^orders']; ?></a>]</div></td>
        <td class='text_grey'><div align='left'><?php echo $BL->fDate($temp['sign_date']); ?></div></td>
        <td class='text_grey'><div align='left'><?php echo $BL->props->lang[$temp['cust_status']]; ?></div></td>
        <?php if($BL->utils->compareDates(date('d'),date('m'),date('Y'),$rec_date_array['mday'],$rec_date_array['mon'],$rec_date_array['year'])!=-1){ ?>
        <td class='text_grey'>
        <div align='left'>
        <a href="javascript:if(confirm('<?php echo $BL->props->lang['Are_you_sure_you_want_to_send_the'].$BL->fDate($temp['rec_next_date'])." ".$BL->props->lang['invoice_and_set_the_next_billing_date_to'].$BL->fDate($upcoming_bill_date_array['year'] . "-" . $upcoming_bill_date_array['mon'] . "-" . $upcoming_bill_date_array['mday']); ?>'))document.location='<?php echo $PHP_SELF."?cmd=".$cmd."&gen_invoice=1&date=".date('Y-m-d',strtotime($temp['rec_next_date']))."&sub_id=".$temp['sub_id']; ?>';">
        <?php echo $BL->fDate($temp['rec_next_date']); ?>
        </a>
        </div>
        </td>
        <?php }else{ ?>
        <td class='text_grey'><div align='left'><?php echo $BL->fDate($temp['rec_next_date']); ?></div></td>
        <?php } ?>
        <td class='text_grey'><div align='left'>
            <?php if($BL->getCmd("editorder")){ ?>
            <a href='<?php echo $PHP_SELF; ?>?cmd=editorder&sub_id=<?php echo $temp['sub_id']; ?>'>
            <img src='elements/default/templates/alp_admin/images/edit_all.gif' border='0'>
            </a>
            &nbsp;
            <?php } ?>
            <?php if($cmd=="vieworders"){ ?>
            <?php if($BL->getCmd("addinvoice")){ ?>
            <a href="<?php echo $PHP_SELF; ?>?cmd=addinvoice&sub_id=<?php echo $temp['sub_id']; ?>">
            <img src='elements/default/templates/alp_admin/images/add_invoice.gif' border='0' />
            </a>
            &nbsp;
            <?php } ?>
            <?php if($BL->getCmd("delorder")){ ?>
            <a href="javascript:if(confirm('<?php echo $BL->props->lang['Do_you_want_to_delete_this_order']; ?>'))document.location='<?php echo $PHP_SELF; ?>?cmd=delorder&sub_id=<?php echo $temp['sub_id']; ?>'">
            <img src='elements/default/templates/alp_admin/images/delete.gif' alt='<?php echo $BL->props->lang['Delete']; ?>' border='0'>
            </a>
            &nbsp;
            <?php } ?>
            <?php } ?>
            </div>
        </td>
    </tr>
    <?php } ?>
    <tr> 
      <td colspan="9" class="text_grey">
        <img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" />
      </td>
    </tr>       
</table>
<br />
