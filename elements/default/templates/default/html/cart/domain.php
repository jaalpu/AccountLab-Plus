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

    <tr> 
        <td>    
            <table width='100%' border='0' cellspacing='0' cellpadding='0' align='center' class='accountlabFormTABLE'>
            <tbody id='domain_type_sec' name='domain_type_sec' class='on'>
                <tr> 
                   <td colspan='2' height='1%'>&#160;</td>
                </tr>    
            <?php if($show_tlds) { ?>
                <tr> 
                    <td width='3%' height='1%' valign='top'>  
                        <input type='radio' name='domain_type' id='domain_type1' class='accountlabInput' value='1' onclick="javascript:xajax_step2_selectType(1);" />                   
                    </td>
                    <td valign='top' colspan='3'>
                        <?php echo $BL->props->lang['search_for_domain']; ?>
                    </td>
                </tr>
             <?php } ?>
             <?php if($show_subdomains) { ?>
                <tr> 
                    <td width='3%' height='1%' valign='top' >  
                        <input type='radio' name='domain_type' id='domain_type2' class='accountlabInput' value='2' onclick="javascript:xajax_step2_selectType(2);" />                      
                    </td>
                    <td valign='top' colspan='3'>
                        <?php echo $BL->props->lang['search_for_subdomain']; ?>
                    </td>
                </tr>                 
             <?php } ?>
             <?php if($show_owndomain) { ?>
                <tr> 
                    <td width='3%' height='1%' valign='top'> 
                        <input type='radio' name='domain_type' id='domain_type3' class='accountlabInput' value='3' onclick="javascript:xajax_step2_selectType(3);" />                       
                    </td>
                    <td valign='top' colspan='3'>
                        <?php echo $BL->props->lang['use_own_domain']; ?>           
                    </td>
                </tr> 
              <?php } ?>
                <tr> 
                   <td colspan='2' height='1%'>&#160;</td>
                </tr>  
              </tbody>
              </table>
         </td>
    </tr>
    <tbody id='domain_search_sec' name='domain_search_sec' class='off'>
    <tr>
        <td>
            <fieldset class='accountlabFormTABLE'>
            <legend id='domain_sec_legend' name='domain_sec_legend'><b><?php echo $BL->props->lang['use_own_domain']; ?></b></legend>
            <table width='100%' border='0' cellspacing='0' cellpadding='0' align='center'>
                <tr> 
                    <td width='3%' height='1%' valign='top'>                        
                    </td>
                    <td valign='top' colspan='3'>
                    <div style="float:left;" name='www'       id='www'      ><b>www.</b></div>
                    <div style="float:left;" name='sld_field' id='sld_field'>&#160;</div>
                    <div style="float:left;" name='dot_field' id='dot_field'><b>.</b></div>
                    <div style="float:left;" name='tld_field' id='tld_field'>&#160;</div>
                    <div style="float:left;" name='blk_field' id='blk_field'>&#160;</div>
                    <div style="float:left;" name='btn_field' id='btn_field'>&#160;</div>
                    </td>
                </tr> 
                <tr> 
                    <td width='3%' height='1%' valign='top'>                        
                    </td>
                    <td valign='top' colspan='3'>
                    <div name='whois_result' id='whois_result'>&#160;</div>                 
                    </td>
                </tr>   
            </table>
            </fieldset>
         </td>
    </tr>
    </tbody>
