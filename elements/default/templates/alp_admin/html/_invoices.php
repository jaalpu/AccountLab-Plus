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
    <form name='form2' id='form2' action="admin.php" method="post">
      <input type='hidden' name='search_term' id='search_term' value='<?php echo isset($BL->REQUEST['search_term'])?$BL->REQUEST['search_term']:""; ?>' >
      <input type='hidden' name='cmd' id='cmd' value='<?php echo $cmd; ?>' />
      <input type='hidden' name='status' id='status' value='<?php echo $status; ?>' />
      <input type='hidden' name='id' id='id' value='<?php echo isset($BL->REQUEST['id'])?$BL->REQUEST['id']:0; ?>' />
        <td colspan="8" class="tdheading" align='right'>
            <?php if($cmd=="viewinvoice"){ ?>
            <?php echo $BL->props->lang['ORDER_BY']; ?>
            <select name="orderby1" id="orderby1" class="search" onchange="javascript:this.form.submit();">
            <option value='invoice_no' <?php if($BL->REQUEST['orderby1']=='invoice_no')echo "selected"; ?> ><?php echo $BL->props->lang['Nu']; ?></option>
            <option value='gross_amount' <?php if($BL->REQUEST['orderby1']=='gross_amount')echo "selected"; ?> ><?php echo $BL->props->lang['Amount']; ?></option>
            <option value='due_date' <?php if($BL->REQUEST['orderby1']=='due_date')echo "selected"; ?> ><?php echo $BL->props->lang['Due_Date']; ?></option>
            <option value='status' <?php if($BL->REQUEST['orderby1']=='status')echo "selected"; ?> ><?php echo $BL->props->lang['Status']; ?></option>
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
        <td colspan="8" class="text_grey">
            <img src="elements<?php echo PATH_SEP; ?>default<?php echo PATH_SEP; ?>templates<?php echo PATH_SEP; ?>alp_admin<?php echo PATH_SEP; ?>images<?php echo PATH_SEP; ?>spacer.gif" alt="" width="100%" height="1" />
        </td>
    </tr>  
    <tr> 
        <td class="text_grey" width="5%"><div align="left"><b>&nbsp;<?php echo $BL->props->lang['Nu']; ?></b></div></td>
        <td class="text_grey"><div align="left"><b><?php echo $BL->props->lang['Description']; ?></b></div></td>
        <td class="text_grey" colspan="2"><div align="left"><b><?php echo $BL->props->lang['Name']; ?></b></div></td>
        <td class="text_grey"><div align="center"><b><?php echo $BL->props->lang['Amount']; ?>&nbsp;&nbsp;</b></div></td>
        <td class="text_grey"><div align="left"><b><?php echo $BL->props->lang['Due_Date']; ?></b></div></td>
        <td class="text_grey"><div align="left"><b><?php echo $BL->props->lang['Status']; ?></b></div></td>
        <td class="text_grey"><div align="left"><b></b></div></td>
    </tr>
    <?php foreach ($Invoices as $Invoice) { ?>
    <tr>
        <td  colspan='8' class='text_grey'>
            <img src="elements<?php echo PATH_SEP; ?>default<?php echo PATH_SEP; ?>templates<?php echo PATH_SEP; ?>alp_admin<?php echo PATH_SEP; ?>images<?php echo PATH_SEP; ?>menu_line_lightgreen-long.jpg" width="100%" height="1" />
        </td>
    </tr>       
    <tr>
        <td class='text_grey'><div align='left'>&nbsp;<?php echo $conf['invoice_prefix'].$Invoice['invoice_no'].$conf['invoice_suffix']; ?>&nbsp;</div></td>
        <td class='text_grey'><div align='left'><?php echo $BL->getFriendlyDesc($Invoice['desc'],$Invoice['order_id']); ?></div></td>
        <td class='text_grey'><div align='left'><a href="<?php echo $PHP_SELF; ?>?cmd=editcustomers&id=<?php echo $Invoice['customer_id']; ?>"><?php echo $BL->getCustomerFieldValue("name",$Invoice['customer_id']); ?></a></div></td>
        <td class='text_grey'><div align='left'>[<a href="<?php echo $PHP_SELF; ?>?cmd=viewinvoice&id=<?php echo $Invoice['customer_id']; ?>"><?php echo $BL->props->lang['^invoices']; ?></a>]</div></td>
        <td class='text_grey'><div align='right'><b><?php echo $BL->toCurrency($Invoice['gross_amount'],null,1); ?>&nbsp;&nbsp;</b></div></td>
        <td class='text_grey'><div align='left'><?php echo $BL->fDate($Invoice['due_date']); ?></div></td>
        <td class='text_grey'><div align='left'><?php echo $BL->props->lang[$Invoice['status']]; ?></div></td>
        <td class='text_grey'>
            <div align='left'>
            <a href='info.php?cmd=PDF&invoice_no=<?php echo $Invoice['invoice_no']; ?>' target='_blank'>          
            <img src='elements<?php echo PATH_SEP; ?>default<?php echo PATH_SEP; ?>templates<?php echo PATH_SEP; ?>alp_admin<?php echo PATH_SEP; ?>images<?php echo PATH_SEP; ?>pdf.gif' alt='<?php echo $BL->props->lang['PDF']; ?>' border='0' /></a>
            &nbsp;
            <?php if($BL->getCmd("editinvoice")){ ?>
            <a href='<?php echo $PHP_SELF; ?>?cmd=editinvoice&invoice_no=<?php echo $Invoice['invoice_no']; ?>'class='text_link'><img src='elements<?php echo PATH_SEP; ?>default<?php echo PATH_SEP; ?>templates<?php echo PATH_SEP; ?>alp_admin<?php echo PATH_SEP; ?>images<?php echo PATH_SEP; ?>edit_all.gif' border='0'></a>&nbsp;
            <?php } ?>
            </div>
        </td>
    </tr>
    <?php } ?>
    <tr>
        <td colspan="8" class="text_grey">
            <img src="elements<?php echo PATH_SEP; ?>default<?php echo PATH_SEP; ?>templates<?php echo PATH_SEP; ?>alp_admin<?php echo PATH_SEP; ?>images<?php echo PATH_SEP; ?>spacer.gif" alt="" width="100%" height="1" />
        </td>
    </tr>     
</table>
<br />
