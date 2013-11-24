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
            <?php
            $str1 = "\"tab0\"";
            $str2 = "\"t0\"";
            $d1   ="";
            foreach ($e_templates as $key => $value)
            {
                if($d1=="")$d1=$value['email_id'];
                $str1 .= ", \"tab".$value['email_id']."\"";
                $str2 .= ", \"t".$value['email_id']."\"";            
            }
            ?>	
            <script language="JavaScript" type="text/javascript">
            var tabs = [<?php echo $str1; ?>];
            var t    = [<?php echo $str2; ?>];
            </script>	
            <div id="display_list">            
            <?php
            foreach ($e_templates as $key => $value)
            {
            ?>
              <div class="tabs" name='t<?php echo $value['email_id']; ?>' id='t<?php echo $value['email_id']; ?>' onclick="javascript:showTab('tab<?php echo $value['email_id']; ?>', tabs, 't<?php echo $value['email_id']; ?>', t);" onmouseover="javascript:overTab('t<?php echo $value['email_id']; ?>', t);" onmouseout="javascript:outTab(t);" ><?php $et="email_template_".$value['email_id']; echo $BL->props->lang[$et]; ?></div>
              <div class="tab_separator">&nbsp;</div>
            <?php
            }
            ?>
              <div class="tabs" name='t0' id='t0' onclick="javascript:showTab('tab0', tabs, 't0', t);" onmouseover="javascript:overTab('t0', t);" onmouseout="javascript:outTab(t);" ><?php echo $BL->props->lang['Instructions']; ?></div>
              <div class="tab_separator">&nbsp;</div>
            </div> 
			<?php
			foreach ($e_templates as $key => $value)
			{
			?>
            <div id="tab<?php echo $value['email_id']; ?>" name="tab<?php echo $value['email_id']; ?>" class="tabContent" style="display:block;float:left;">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list_table">
                <tr><td class="tdheading">&nbsp;</td></tr>  
                <tr>
                    <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <form name='form<?php echo $value['email_id']; ?>' id='form<?php echo $value['email_id']; ?>' method='post' action='<?php echo $PHP_SELF; ?>'>
                        <tr>
                      <td class="text_grey" width="2%">
                      <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
                      </td>
                        <td class='text_grey'>
                        <div id="form2_label">  
                           <b><?php echo $BL->props->lang['email_subject']; ?></b></div>
                           <div id="form2_field">  
                           <input type='text' size='70' name='email_subject' class='search' id='email_subject' value='<?php echo $value['email_subject']; ?>' />
                           </div>
                        </td>
                        </tr> 
                    <tr>
                      <td class='text_grey' colspan='2'>
                      <img src="elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg" width="100%" height="1"></td>
                    </tr>
                        <tr>
                      <td class="text_grey" width="2%" valign='top'>
                      <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
                      </td>
                        <td class='text_grey'>
                        <div id="form2_label"> 
                           <b><?php echo $BL->props->lang['email_body']; ?></b></div>
                           <div id="form2_field"> 
                           <textarea name='email_text' id='email_text' cols='70' rows='20' class='search' wrap="soft"><?php echo $value['email_text']; ?></textarea>
                           </div>
                        </td>
                        </tr>  
                    <tr>
                      <td class='text_grey' colspan='2'>
                      <img src="elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg" width="100%" height="1"></td>
                    </tr>
                        <tr>
                      <td class="text_grey" width="2%">
                      <img src='elements/default/templates/alp_admin/images/spacer.gif' width='32' height='18'>
                      </td>
                        <td class='text_grey'>
                        <div id="form2_label"> 
                        </div>
                        <div id="form2_field"> 
                           <input type='hidden' name='email_id' value='<?php echo $value['email_id']; ?>' />
                           <input type='hidden' name='cmd' value='<?php echo $cmd; ?>' />
                           <input type='submit' name='submit' value='<?php echo $BL->props->lang['Update']; ?>' class='search1' />
                        </div>
                        </td>
                        </tr>  
                    </form>
                    </table>
                    </td>
                </tr>
			  </table>
              </div>
            <?php
            }
            ?>
              <div id="tab0" name="tab0" class="tabContent" style="display:block;float:left;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="list_table">
                    <tr><td class="tdheading">&nbsp;</td></tr>          
                    <tr>
                    <td class='text_grey'>
                        <table width="100%" border="0" cellspacing="6" cellpadding="6">  
                        <?php
                        foreach ($e_templates as $key => $value)
                        {
                        ?>
                            <tr>
                            <td class='text_grey'>
                               <b><?php $et="email_template_".$value['email_id']; echo $BL->props->lang[$et]; ?></b><br />
                               <pre><?php $et="template_default_".$value['email_id']; echo HTMLSpecialChars($BL->props->lang[$et]); ?></pre>
                            </td>
                            </tr>   
                        <?php
                        }
                        ?>      
                        </table>
                    </td>
                    </tr>         
                </table>
              </div>
		</table>
	</div>
</div>
<script language="JavaScript" type="text/javascript">
  showTab('tab<?php echo $d1; ?>', tabs, 't<?php echo $d1; ?>', t);
</script>
<!--end content -->
<div id="navBar">
<?php include_once $BL->props->get_page("templates/alp_admin/html/_sidepanel.php"); ?>
</div>
<!--end navbar -->
<?php include_once $BL->props->get_page("templates/alp_admin/html/footer.php"); ?>
