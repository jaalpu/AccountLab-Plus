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

<tbody name='extra_user_info_sec' id='extra_user_info_sec' class='off'>
<?php if($conf['ask_login_info']==1){ ?>
<tr> 
    <td>
    <fieldset class='accountlabFormTABLE'>
    <legend><b><?php echo $BL->props->lang['desired_hosting_account']; ?></b></legend>
	<table width='100%' border='0' cellspacing='0' cellpadding='0' align='center'>
        <tr> 
          <td  width='40%' valign='top' class='accountlabPlanDataTD'>
            <?php echo $BL->props->lang['Username']; ?><br>
		    <span class="smaller"><?php echo $BL->props->lang['domain_login']; ?></span>
		  </td>
          <td valign='top' class='accountlabPlanDataTD'>
              <input name='dom_user' id='dom_user' type='text' class='accountlabInput' value='<?php echo strtolower($BL->utils->random_password()); ?>' size='10' />
          </td>
        </tr>
        <tr> 
          <td valign='top' class='accountlabPlanDataTD'>
            <?php echo $BL->props->lang['Password']; ?><br>
		    <span class="smaller"><?php echo $BL->props->lang['domain_pass']; ?></span>
           </td>
          <td valign='top' class='accountlabPlanDataTD'>
              <input name='dom_pass' id='dom_pass' type='text' class='accountlabInput' size='10' value='<?php echo $BL->utils->random_password(); ?>' />
          </td>
        </tr>      		
		</table>
    </fieldset>
	</td>
</tr>
<?php } ?>
<?php if($conf['en_dt']==1 || $conf['en_cc']==1) { ?>
</tr>
	<tr> 
	<td>
    <fieldset class='accountlabFormTABLE'>
    <legend><b><?php echo $BL->props->lang['if_have_disc_token']; ?></b></legend>
    <table width='100%' border='0' cellspacing='0' cellpadding='0' align='center'>
        <tr> 
          <td  width='40%' valign='top' class='accountlabPlanDataTD'>
            
          </td>
          <td valign='top' class='accountlabPlanDataTD'>
              <input type='text' class='accountlabInput' name='disc_token_code' id='disc_token_code' size='10' />
          </td>
        </tr>
    </table>
    </fieldset>
</td>
</tr>
<?php } ?>
</tbody>
