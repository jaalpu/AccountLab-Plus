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
    <form name='form1' id='form1' action="<?php echo $PHP_SELF; ?>" method="POST">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="list_table">
        <?php  if(!count($custom_scripts))  { ?>
        <tr> 
            <td align='center'>
            <p><?php echo $BL->props->lang['no_cs']; ?></p>
            </td>   
        </tr>
        <?php } else { ?>
        <?php 
        foreach ($custom_scripts as $value) {
        $k   = $value['id'];
        $val = $value['file_name'];
        $key = "cs_".$k;
        if(empty($value['run_schedule']))$value['run_schedule']="INACTIVE";
        ?>
        <input type='hidden' name='file_name[<?php echo $k; ?>]' value='<?php echo $val; ?>' />
        <tr> 
            <td class="tdheading">
            <b>&nbsp;<?php echo $val; ?></b> [<?php if($value['run_schedule']=="MANUAL"){?><a style='color:#ffffff' href='?cmd=custom_scripts&id=<?php echo $k; ?>&manual=true'><?php echo $BL->props->lang['MANUAL']; ?></a><?php }else { ?><?php echo $BL->props->lang[$value['run_schedule']]; ?><?php } ?>]
            </td>
            <td class="tdheading" align="right">
            <a href="#" onClick="expandcontent('section_<?php echo $key; ?>')"><img src="elements/default/templates/alp_admin/images/top_arrow.gif" alt="" border="0" /></a>
            </td>   
        </tr>
        <tr> 
          <td class="text_grey" colspan="2">
          <img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" />
          </td>
        </tr>   
        <tr> 
            <td class="text_grey" colspan="2">
            <div id='section_<?php echo $key; ?>' class="switchcontent">
            <table width='100%' border='0' cellspacing='0' cellpadding='0'>
            <tr>
                <td>
                <div id="form1_label">
                &nbsp;<b><?php echo $BL->props->lang['run_schedule']; ?></b>
                </div>
                <div id="form1_field">
                  <select name="run_schedule[<?php echo $k; ?>]" id="run_schedule[<?php echo $k; ?>]" class='search' size="1">
                    <option value="INACTIVE" <?php if($value['run_schedule']=="INACTIVE") echo "selected"; ?>><?php echo $BL->props->lang['INACTIVE']; ?></option>
                    <option value="MANUAL" <?php if($value['run_schedule']=="MANUAL") echo "selected"; ?>><?php echo $BL->props->lang['MANUAL']; ?></option>
                    <option value="A_AC" <?php if($value['run_schedule']=="A_AC") echo "selected"; ?>><?php echo $BL->props->lang['A_AC']; ?></option>
                    <option value="A_PP" <?php if($value['run_schedule']=="A_PP") echo "selected"; ?>><?php echo $BL->props->lang['A_PP']; ?></option>
                    <option value="W_B"  <?php if($value['run_schedule']=="W_B") echo "selected"; ?>><?php echo $BL->props->lang['W_B']; ?></option>
                    <option value="A_B"  <?php if($value['run_schedule']=="A_B") echo "selected"; ?>><?php echo $BL->props->lang['A_B']; ?></option>
                    <option value="W_L" <?php if($value['run_schedule']=="W_L") echo "selected"; ?>><?php echo $BL->props->lang['W_L']; ?></option>
                  </select>
                </div>
                </td>
            </tr>  
            <tr> 
                <td class='text_grey'>
                <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                </td>
            </tr>   
            <tr>
                <td>
                <div id="form1_label">
                &nbsp;<b><?php echo $BL->props->lang['available_post_vars']; ?></b>
                </div>
                <div id="form1_field">
                <textarea name="post_variables[<?php echo $k; ?>]" id="post_variables[<?php echo $k; ?>]" class='search' rows="10" cols="55" wrap="soft"><?php echo $value['post_variables']; ?></textarea>
                </div>
                </td>
            </tr>  
            <tr> 
                <td class='text_grey'>
                <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                </td>
            </tr> 
            </table>
            </div>
            </td>
        </tr>   
        <tr> 
          <td class="text_grey" colspan="2">
          <img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="10" />
          </td>
        </tr>   
        <?php } ?>
        <tr> 
          <td class="text_grey">
          <img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" />
          </td>
        </tr>
        <tr>
          <td class='text_grey'>
          <div id="form1_label"> &nbsp; </div>
          <div id="form1_field">
          <input type='hidden' name='cmd' value='<?php echo $cmd; ?>' />
          <input type='submit' class='search1' name='update' value='<?php echo $BL->props->lang['Update']; ?>' />
          </div>
          </td>
        </tr>
        <tr> 
          <td class="text_grey">
          <img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" />
          </td>
        </tr>   
        <?php  }  ?>
        </table>
     </form>
    </div>
</div>
<!--end content -->
<div id="navBar">
<?php include_once $BL->props->get_page("templates/alp_admin/html/_sidepanel.php"); ?>
</div>
<!--end navbar -->
<?php include_once $BL->props->get_page("templates/alp_admin/html/footer.php"); ?>
