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

<tbody name='member_section' id='member_section' class='on'>
    <tr> 
        <td>    
            <table width='100%' border='0' cellspacing='0' cellpadding='0' align='center' class='accountlabFormTABLE'>
                <tr> 
                   <td colspan='2' height='1%'>&#160;</td>
                </tr>
                <tr> 
                    <td width='3%' height='1%' valign='top'>
                        <input type='radio' class='accountlabInput' id='member' name='member' value="1" onclick="javascript:xajax_step3_memberType(1);xajax_toggleButtons(new Array('back2','continue_verify'));" />                   
                    </td>
                    <td valign='top' colspan='3'>
                        <?php echo $BL->props->lang['customers_sign_in']; ?> 
                    </td>
                </tr> 
                <tr> 
                    <td width='3%' height='1%' valign='top'>
                        <input type='radio' class='accountlabInput' id='member' name='member' value="0" onclick="javascript:xajax_step3_memberType(0);xajax_toggleButtons(new Array('back2','continue_verify'));" />                      
                    </td>
                    <td valign='top' colspan='3'>
                        <?php echo $BL->props->lang['new_customers_sign_up']; ?>
                    </td>
                </tr> 
                <tr> 
                   <td colspan='2' height='1%'>&#160;</td>
                </tr>    				
			</table>
		</td>
	</tr>
</tbody>
<tbody name='error_section' id='error_section' class='off'>
    <tr> 
        <td>    
            <table width='100%' border='0' cellspacing='0' cellpadding='2' align='center' class='accountlabFormTABLE'>
                <tr> 
                   <td>
                   <div id="error_msg" name="error_msg" style="color:red;font-weight:bold;">&#160;</div>
                   </td>
                </tr>    
            </table>
        </td>
    </tr>
</tbody>
