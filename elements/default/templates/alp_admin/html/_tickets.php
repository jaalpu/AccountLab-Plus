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

<?php foreach($topics as $topic) { ?>                                               
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="list_table">
                    <tr> 
                      <td class="tdheading" colspan="5">&nbsp;<b><?php echo $topic['topic_name']; ?></b></td>
                      <td class="tdheading" width="10%">&nbsp;</td>
                    </tr>           
                    <tr> 
                      <td colspan="6" class="text_grey"><img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" /></td>
                    </tr>               
                    <tr>
                        <td class='text_grey'>&nbsp;<b><?php echo $BL->props->lang['Nu']; ?></b></td>
                        <td class='text_grey'><b><?php echo $BL->props->lang['Date']; ?></b></td>
                        <td class='text_grey'><b><?php echo $BL->props->lang['Name']; ?></b></td>
                        <td class='text_grey'><b><?php echo $BL->props->lang['ticket_subject']; ?></b></td>
                        <td class='text_grey'><b><?php echo $BL->props->lang['Status']; ?></b></td>
                        <td width='10%' class='text_grey'>&nbsp;</td>
                    </tr>
                    <?php foreach ($tickets[$topic['topic_id']][(($REQUEST['ticket_status']==3)?'closed':'open')] as $ticket) { ?>
                    <tr> 
                        <td colspan='6' class='text_grey'>
                        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                        </td>
                    </tr>
                              <tr> 
                                <td class='text_grey'>&nbsp;<?php echo $ticket['ticket_id']; ?></td>
                                <td class='text_grey'><?php echo $BL->fDate($ticket['ticket_date'], ' H:i:s'); ?></td>
                                <td class='text_grey'><a href="<?php echo $PHP_SELF; ?>?cmd=editcustomers&id=<?php echo $ticket['cust_id']; ?>"><?php echo $BL->getCustomerFieldValue("name",$ticket['cust_id']); ?></a></td>
                                <td class='text_grey'><?php echo empty($ticket['ticket_subject'])?substr(strip_tags($ticket['ticket_text']), 0, 15):substr(strip_tags($ticket['ticket_subject']), 0, 15); ?>...</td>
                                <td class='text_grey'><?php echo $BL->props->ticket_status[$ticket['ticket_status']]; ?></td>
                                <td class='text_grey'>
                                      <div align='right'>
                                      <?php if($BL->getCmd("viewTicket")){ ?>
                                      <a href='<?php echo $PHP_SELF; ?>?cmd=viewTicket&ticket_id=<?php echo $ticket['ticket_id']; ?>'><img src='elements/default/templates/alp_admin/images/edit_all.gif' alt='<?php echo $BL->props->lang['Edit']; ?>' border='0'></a>
                                      &nbsp;
                                      <?php } ?>                                      
                                      <?php if($BL->getCmd("closeTicket")){ ?>
                                      <a href='<?php echo $PHP_SELF; ?>?cmd=closeTicket&ticket_id=<?php echo $ticket['ticket_id']; ?>'><img src='elements/default/templates/alp_admin/images/delete.gif' alt='<?php echo $BL->props->lang['Delete']."?"; ?>' border='0'></a>
                                      &nbsp;
                                      <?php } ?>
                                      </div>
                                </td>
                              </tr>
                    <?php } ?>
                    <tr> 
                      <td colspan="6" class="text_grey">&nbsp;</td>
                    </tr>
                  </table>  
                  <br />
            <?php } ?>
