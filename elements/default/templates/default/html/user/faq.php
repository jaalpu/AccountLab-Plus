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

<?php include_once $BL->props->get_page("templates/".THEMEDIR."/html/user/header.php"); ?>
<script language="JavaScript" type="text/javascript">
var tabs = ["tab1"];
var t    = ["t1"];
</script>  
<!--tabs//-->
<div class="tabs" name='t1' id='t1' onclick="javascript:showTab('tab1', tabs, 't1', t);" onmouseover="javascript:overTab('t1', t);" onmouseout="javascript:outTab(t);" ><?php echo $BL->props->lang['FAQs']; ?></div>
<div class="tab_separator">&nbsp;</div>
<div>
<div id="tab1" name="tab1" class="tabContent" style="display:none">
<table width='100%' border='0' cellspacing='0' cellpadding='0'>
<?php if(count($Faqgroups)){ ?>
<tr>
    <td>
    <b><?php echo $BL->props->lang['faqgroup_name']; ?>: </b>
    <select name='faqgroup_id' id='faqgroup_id' class='search' onchange="javascript:showFaqGroup('<?php echo $page; ?>',this.options[this.selectedIndex].value);">
    <?php foreach($Faqgroups as $faqgroup){ ?>
    <option value='<?php echo $faqgroup['faqgroup_id']; ?>' <?php if(isset($BL->REQUEST['faqgroup_id']) && $BL->REQUEST['faqgroup_id']==$faqgroup['faqgroup_id'])echo "selected"; ?> ><?php echo $faqgroup['faqgroup_name']; ?></option>
    <?php } ?>
    </select>
    </td>
</tr>
<tr>
    <td height="5" class="accountlabFieldCaptionTD"></td>
</tr>
<tr>
    <td><?php echo $BL->REQUEST['faqgroup_desc']; ?></td>
</tr>
<tr>
    <td height="5" class="accountlabFieldCaptionTD"><hr></td>
</tr>
<?php } ?>
<?php foreach($Faqs as $faq){ ?>
<tr>
    <td>
    <a href='#<?php echo $faq['faq_id']; ?>' class='accountlabPlanLink'><?php echo $faq['questions']; ?></a>
    </td>
</tr>
<?php } ?>
<tr>
    <td height="5" class="accountlabFieldCaptionTD"><hr></td>
</tr>
</table>
<table border='0' cellpadding='1' cellspacing='0'  width="100%" align="center" class="accountlabFormTABLE">
<tr>
    <td height="5" class="accountlabFieldCaptionTD"></td>
</tr>
<?php foreach($Faqs as $faq){ ?>
<tr>
    <td class='accountlabDataTD'>
    <a name='<?php echo $faq['faq_id']; ?>'></a><b><?php echo $faq['questions']; ?></b><BR /><BR /><?php echo $faq['answers']; ?><BR /><BR />[<a href='#top' class='accountlabPlanLink'><?php echo $BL->props->lang['top']; ?></a>]
    </td>
</tr>
<?php } ?>
</table>
</div>
</div>
<script language="JavaScript" type="text/javascript">
  showTab('tab1', tabs, 't1', t);
</script>
<?php include_once $BL->props->get_page("templates/".THEMEDIR."/html/user/footer.php"); ?>
