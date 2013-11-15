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

<table width='100%' border='0' cellpadding='0' cellspacing='0'>
  <tr> 
    <td>
    <table width='100%' border='0' cellspacing='0' cellpadding='0'>
        <tr> 
          <td width='5%' class='accountlabPlanDataHTD'><?php echo $BL->props->lang['Nu']; ?></td>
          <td width='50%' class='accountlabPlanDataHTD'><?php echo $BL->props->lang['Description']; ?></td>
          <td width='15%' class='accountlabPlanDataHTD'><div align='right'><?php echo $BL->props->lang['Amount']; ?>&nbsp;</div></td>
          <td width='10%' class='accountlabPlanDataHTD'><?php echo $BL->props->lang['Due_Date']; ?></td>
          <td width='10%' class='accountlabPlanDataHTD'><?php echo $BL->props->lang['Status']; ?></td>
          <td width='10%' class='accountlabPlanDataHTD'></td>
        </tr>
        <?php
        $bgcolor= "accountlabDataTD";
        foreach ($invoices as $key => $value) {
                if ($bgcolor == "accountlabAltDataTD")
                    $bgcolor= "accountlabDataTD";
                elseif ($bgcolor == "accountlabDataTD") 
                    $bgcolor= "accountlabAltDataTD";
        ?>
         <tr> 
          <td class='<?php echo $bgcolor; ?>'><?php echo $conf['invoice_prefix'].$value['invoice_no'].$conf['invoice_suffix']; ?></td>
          <td class='<?php echo $bgcolor; ?>'><?php echo $BL->getFriendlyDesc($value['desc'],$value['sub_id']); ?></td>
          <td class='<?php echo $bgcolor; ?>'><div align='right'><?php echo $BL->toCurrency($value['gross_amount'],null,1); ?>&nbsp;</div></td>
          <td class='<?php echo $bgcolor; ?>'><?php echo $BL->fDate($value['due_date']); ?></td>
          <td class='<?php echo $bgcolor; ?>'><?php echo $BL->props->lang[$value['status']]; ?></td>
          <td class='<?php echo $bgcolor; ?>'>
          &nbsp;<a class='accountlabPlanLink' href='<?php echo $PHP_SELF; ?>?cmd=<?php if($value['status']==$BL->props->invoice_status[1])echo "viewInvoice"; else echo "pay"; ?>&invoice_no=<?php echo $value['invoice_no']; ?>'><?php echo $BL->props->lang['View']; ?></a>
          &nbsp;<a class='accountlabPlanLink' href='info.php?cmd=VPDF&invoice_no=<?php echo $value['invoice_no']; ?>' target='_blank'><?php echo $BL->props->lang['PDF']; ?></a>
          &nbsp;<a class='accountlabPlanLink' href='info.php?cmd=PDF&invoice_no=<?php echo $value['invoice_no']; ?>' target='_blank'><?php echo $BL->props->lang['Download_PDF']; ?></a>
          </td>
        </tr>
        <?php } ?>
        </table>
       </td>
  </tr>
</table>
