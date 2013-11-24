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
      <div class="tabs" name='tt1' id='tt1' onmouseover="javascript:this.className='tabs1';" onmouseout="javascript:this.className='tabs';" ><a href="admin.php?cmd=tax" class="add_link"><?php echo $BL->props->lang['~tax']; ?></a></div>
      <div class="tab_separator">&nbsp;</div>
      <div class="tabs2" name='tt2' id='tt2' onmouseover="javascript:this.className='tabs1';" onmouseout="javascript:this.className='tabs2';" ><?php echo $title; ?></div>
      <div class="tab_separator">&nbsp;</div>
    </div>
    <div id="display_list">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="list_table">
                    <tr> 
                      <td colspan="2" class="tdheading">
                      <b>&nbsp;</b>
                      </td>
                    </tr>
                    <tr> 
                      <td colspan="2" class="text_grey"><img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" /></td>
                    </tr>
                <tr>
                    <td class="text_grey" colspan="2">
                    <form name='form1' id='form1' method='POST' action='<?php echo $PHP_SELF; ?>'>
                    <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                        <tr> 
                        <td class='text_grey' width='1%'>
                        <div align='center'>
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                        </div>
                        </td>
                        <td class='text_grey'>
                        <div id="form1_label">
                        <?php echo $BL->props->lang['Tax_Name']; ?>
                        </div>
                        <div id="form1_field">
                          <input name='tax_name' type='text' class='search' id='tax_name' size='20' value='<?php if($cmd=="edittax") echo $tax['tax_name']; ?>' />
                        </div>
                        </td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'>
                        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                        </td>
                      </tr>

                      <tr> 
                        <td class='text_grey'>
                        <div align='center'>
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                        </div>
                        </td>
                        <td class='text_grey'>
                        <div id="form1_label">
                        <?php echo $BL->props->lang['Tax_Amount']; ?> (%)
                            </div>
                            <div id="form1_field">
                            <input name='tax_amount' type='text' class='search' id='tax_amount' size='10' value='<?php if($cmd=="edittax") echo $tax['tax_amount']; ?>' />
                          </div>
                         </td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'>
                        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                        </td>
                      </tr>
                      <tr> 
                        <td class='text_grey'>
                        <div align='center'>
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                        </div>
                        </td>
                        <td class='text_grey'>
                        <div id="form1_label">
                        <?php echo $BL->props->lang['add']; ?> / <?php echo $BL->props->lang['subtruct']; ?>
                        </div>
                        <div id="form1_field">
                          <select name='tax_add_sub' class='search' id='tax_add_sub'>
                            <option value='A' <?php if($cmd=="edittax"){if($tax['tax_add_sub']=="A") echo "selected=\"selected\"";} ?>><?php echo $BL->props->lang['add']; ?></option>
                            <option value='S' <?php if($cmd=="edittax"){if($tax['tax_add_sub']=="S") echo "selected=\"selected\"";} ?>><?php echo $BL->props->lang['subtruct']; ?></option>
                          </select>
                          </div>
                          </td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'>
                        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                        </td>
                      </tr>
                      <tr> 
                        <td class='text_grey'>
                        <div align='center'>
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                        </div>
                        </td>
                        <td class='text_grey'>
                        <div id="form1_label">
                        <?php echo $BL->props->lang['net']; ?> / <?php echo $BL->props->lang['compounded']; ?>
                        </div>
                        <div id="form1_field">
                          <select name='tax_net_comp' class='search' id='tax_net_comp'>
                            <option value='N' <?php if($cmd=="edittax"){if($tax['tax_net_comp']=="N") echo "selected=\"selected\"";} ?>><?php echo $BL->props->lang['net']; ?></option>
                            <option value='C' <?php if($cmd=="edittax"){if($tax['tax_net_comp']=="C") echo "selected=\"selected\"";} ?>><?php echo $BL->props->lang['compounded']; ?></option>
                          </select>
                          </div></td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'>
                        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                        </td>
                      </tr>

                      <tr> 
                        <td class='text_grey' valign='top'><div align='center'>
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' /></div></td>
                        <td class='text_grey' valign='top'>
                        <div id="form1_label">
                        <?php echo $BL->props->lang['Country']; ?>
                        </div>
                        <div id="form1_field">
                          <select name='tax_country[]' class='search' id='tax_country[]' size='10' multiple='true' onchange="javacript:if(NumberOfSelection('tax_country[]','form1')==1)updateTaxStates(this.options[this.selectedIndex].value);else getObj('tax_state[]','form1').options.length = 1;">
                            <option value='ALL' <?php if($cmd=="edittax"){if($tc_array=="ALL") echo "selected=\"selected\"";} ?>><?php echo $BL->props->lang['all']; ?></option>
                            <?php foreach($BL->props->country as $x=>$y) {  ?>
                                <option value='<?php echo $x; ?>' <?php if($cmd=="edittax" && is_array($tc_array) && array_search($x, $tc_array)!==false) echo "selected=\"selected\""; ?>><?php echo $y; ?></option>
                            <?php } ?>
                          </select>
                          </div></td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'>
                        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                        </td>
                      </tr>
                      <tr> 
                        <td class='text_grey' valign='top'>
                        <div align='center'>
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' /></div></td>
                        <td class='text_grey' valign='top'>
                        <div id="form1_label">
                        <?php echo $BL->props->lang['State']; ?>
                        </div>
                        <div id="form1_field">
                          <select name='tax_state[]' class='search' id='tax_state[]' size='10' multiple='true'>
                            <option value='ALL' <?php if($cmd=="edittax"){if($ts_array=="ALL") echo "selected=\"selected\"";} ?>><?php echo $BL->props->lang['all']; ?></option>
                          </select>                 
                        </div>
                        </td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'>
                        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                        </td>
                      </tr>
                    
                      <tr> 
                        <td class='text_grey'><div align='center'></div></td>
                        <td class='text_grey'>
                        <div id="form1_label">
                        &nbsp;
                        </div>
                        <div id="form1_field">
                          <?php if($cmd=="edittax"){ ?>
                          <input name='tax_id' type='hidden' value='<?php echo $tax['tax_id']; ?>' />
                          <?php } ?>
                          <input type='hidden' name='cmd' value='<?php echo $cmd; ?>' />
                          <input name='submit' type='submit' class='search1' value='<?php if($cmd=="edittax")echo $BL->props->lang['Update'];else echo $BL->props->lang['add']; ?>' />                          </div></td>
                      </tr>
                    </table>
                  </form>
                    </td>
                </tr>       
                  </table>
    </div>
</div>
<script language="JavaScript" type="text/javascript">
<?php if(count($tc_array)==1) { ?>updateTaxStates('<?php echo $tc_array[0]; ?>');<?php } ?>
</script> 
<!--end content -->
<div id="navBar">
<?php include_once $BL->props->get_page("templates/alp_admin/html/_sidepanel.php"); ?>
</div>
<!--end navbar -->
<?php include_once $BL->props->get_page("templates/alp_admin/html/footer.php"); ?>
