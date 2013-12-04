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
    <?php
    $int = 0;
    foreach ($BL->dr_fields as $key => $val) {
        $int = $int+1;
    ?>
    <tr>
        <td class="tdheading">
            <b>&nbsp;<?php echo $BL->props->parseLang($key); ?> <?php if(isset($BL->dr_vals[$key]['active']) && $BL->dr_vals[$key]['active']=="yes")echo "(*".$BL->props->lang['active'].")"; ?></b>
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
            <?php foreach ($val as $k => $v) { ?>
            <tr>
            <td valign='top' class='text_grey'>
                <div id="form1_label">
                &nbsp;<?php if($v[0]=="password")echo $BL->props->lang['pass_private']; else echo $BL->props->parseLang($v[0]); ?>
                </div>
                <?php
                if (!is_array($v[2])) {
                ?>
                <div id="form1_field">
                <input class='search' type='text' value='<?php echo isset($BL->dr_vals[$key][$v[0]]) ? $BL->dr_vals[$key][$v[0]] :''; ?>' name='<?php echo $key."[".$v[0]."]"; ?>' id='<?php echo $key."[".$v[0]."]"; ?>' size='30' />
                </div>
                <?php } else { ?>
                <div id="form1_field">
                <select name='<?php echo $key."[".$v[0]."]"; ?>' id='<?php echo $key."[".$v[0]."]"; ?>' class='search'>
                <?php foreach ($v[2] as $a=>$b) { ?>
                <option value='<?php echo $a; ?>' <?php if(isset($BL->dr_vals[$key][$v[0]]) && $a==$BL->dr_vals[$key][$v[0]])echo "selected=\"selected\""; ?>><?php echo $b; ?></option>
                <?php } ?>
                </select>
                </div>
                <?php } ?>
            </td>
            </tr>
            <tr>
              <td class='text_grey' colspan="2">
              <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
              </td>
            </tr>
            <?php } ?>
            </table>
            </div>
        </td>
    </tr>
    <?php } ?>
    <tr>
        <td class="text_grey" colspan="2">
        <img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" />
        </td>
    </tr>
    <tr>
        <td class='text_grey' colspan="2">
        <div id="form1_label">&nbsp;</div>
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
    </form>
    </table>
    </div>
</div>
<!--end content -->
<div id="navBar">
<?php include_once $BL->props->get_page("templates/alp_admin/html/_sidepanel.php"); ?>
</div>
<!--end navbar -->
<?php include_once $BL->props->get_page("templates/alp_admin/html/footer.php"); ?>
