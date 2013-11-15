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

<?php foreach($groups as $group){ ?>
<tbody name='group_section_<?php echo $group['group_id']; ?>' id='group_section_<?php echo $group['group_id']; ?>' class='on'>
    <tr> 
        <td>    
            <table width='100%' border='0' cellspacing='0' cellpadding='0' align='center' class='accountlabFormTABLE'>
            
                <tr> 
                    <td width='3%' height='1%' valign='top'>
                        <input type="radio" id="group_id<?php echo $group['group_id']; ?>" name="group_id" class='accountlabInput' value="<?php echo $group['group_id']; ?>" onclick="javascript:xajax_step1_selectGroup(<?php echo $group['group_id']; ?>);" />
                    </td>
                    <td valign='top' colspan='3'>
                        <b><?php echo $group['group_name']; ?></b>
                    </td>
                </tr> 
                <tr> 
                    <td width='3%' height='1%' valign='top'> 
                    &#160;                
                    </td>
                    <td valign='top' colspan='3'>
                        <?php echo $group['group_desc']; ?>
                    </td>
                </tr>
 
                <tbody name='prod_sec_<?php echo $group['group_id']; ?>' id='prod_sec_<?php echo $group['group_id']; ?>' class='off'>  
                <tr> 
                    <td width='3%' height='1%' valign='top'> 
                    &#160;                       
                    </td>
                    <td valign='top'>
                        <div name="prod_div_<?php echo $group['group_id']; ?>" id="prod_div_<?php echo $group['group_id']; ?>">&#160;</div>
                    </td>
                    <td valign='top'>
                        <div name="bill_div_<?php echo $group['group_id']; ?>" id="bill_div_<?php echo $group['group_id']; ?>">&#160;</div>
                    </td>
                    <td valign='top'>
                        <div name="bill_opt_<?php echo $group['group_id']; ?>" id="bill_opt_<?php echo $group['group_id']; ?>">&#160;</div>
                    </td>                    
                </tr> 
                <tr> 
                    <td width='3%' height='1%' valign='top'>
                    &#160;
                    </td>
                    <td valign='top' colspan='3'>
                        <div name="prod_desc_<?php echo $group['group_id']; ?>" id="prod_desc_<?php echo $group['group_id']; ?>">&#160;</div>
                    </td>
                </tr>  
                </tbody>
                
                
                <tbody name='addon_sec<?php echo $group['group_id']; ?>' id='addon_sec_<?php echo $group['group_id']; ?>' class='off'>             
                <tr> 
                    <td width='3%' height='1%' valign='bottom'>
                    &#160; 
                    </td>
                    <td valign='top' colspan='3' valign='bottom'>
                        <div name="addon_div_<?php echo $group['group_id']; ?>" id="addon_div_<?php echo $group['group_id']; ?>">&#160;</div>
                     </td>
                </tr> 
                 <tr> 
                   <td colspan='4' height='1%'>&#160;</td>
                 </tr>                
                </tbody>
 
            </table>
        </td>
     </tr>
</tbody>
<?php 
}
?>
<?php if($BL->conf['en_domain_only']){ ?>
<tbody name='group_section_0' id='group_section_0' class='on'>
    <tr> 
        <td>    
            <table width='100%' border='0' cellspacing='0' cellpadding='0' align='center' class='accountlabFormTABLE'>
            
                <tr> 
                    <td width='3%' height='1%' valign='top'>
                        <input type="radio" id="group_id0" name="group_id" class='accountlabInput' value="0" onclick="javascript:xajax_reload('step2');" />
                    </td>
                    <td valign='top' colspan='3'>
                        <b><?php echo $BL->props->lang['Register_a_domain_only']; ?></b>
                    </td>
                </tr> 
                
                <tr> 
                    <td width='3%' height='1%' valign='top'>                        
                    </td>
                    <td valign='top' colspan='3'>
                        <?php echo $BL->props->lang['Register_a_domain_only_desc']; ?>
                    </td>
                </tr>
                
            </table>
        </td>
     </tr>
</tbody>
<?php } ?>
