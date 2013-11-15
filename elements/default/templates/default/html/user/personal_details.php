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
    <td><table width='100%' border='0' cellspacing='0' cellpadding='0'>
        <tr> 
          <td height='22' colspan='2' class='accountlabPlanDataHTD'>
          &nbsp;&nbsp;<?php echo $BL->props->lang['personal_details']; ?></td>
        </tr>
        <tr> 
          <td height='18' class='accountlabAltDataTD'><?php echo $BL->props->lang['Email']; ?></td>
          <td class='accountlabAltDataTD'><?php echo $customer['email']; ?></td>
        </tr>
        <?php
        foreach($custom_fields as $cf){ 
            if($cf['field_name']!="country" && $cf['field_name']!="vat_no"){
        ?>
        <tr> 
          <td width='25%' height='18' class='accountlabDataTD'><?php echo $BL->props->parseLang($cf['field_name']); ?></td>
          <td class='accountlabDataTD'><?php echo $BL->getCustomerFieldValue($cf['field_name'],$customer['id']); ?></td>
        </tr>
        <?php }elseif($cf['field_name']=="country"){ ?>
        <tr> 
          <td width='25%' height='18' class='accountlabDataTD'><?php echo $BL->props->parseLang($cf['field_name']); ?></td>
          <td class='accountlabDataTD'><?php echo $BL->props->country[$BL->getCustomerFieldValue($cf['field_name'],$customer['id'])]; ?></td>
        </tr>
        <?php }elseif($cf['field_name']=="vat_no"){ ?>        
        <?php if ($BL->conf['en_vat']) { ?>
        <tr> 
          <td width='25%' height='18' class='accountlabDataTD'><?php echo $BL->props->parseLang($cf['field_name']); ?></td>
          <td class='accountlabDataTD'><?php echo $BL->getCustomerFieldValue($cf['field_name'],$customer['id']); ?></td>
        </tr>
        <?php } ?>
        <?php } ?>
        <?php } ?>
      </table>
      </td>
     </tr>
</table>
