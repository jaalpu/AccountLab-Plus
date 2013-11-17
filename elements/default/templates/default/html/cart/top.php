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

<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN''http://www.w3.org/TR/html4/loose.dtd'>
<html dir="<?php echo PAGEDIR; ?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<?php echo $conf['metatags']; ?>
<title><?php echo !empty($conf['title'])?$conf['title']:$BL->props->lang['accountlabplus']; ?></title>
<link rel="stylesheet" href="<?php echo $BL->props->get_page("templates/".THEMEDIR."/css/style.css"); ?>" type="text/css" />
<?php isset($xajax)?$xajax->printJavascript("system/libraries/xajax"):""; ?>
<script language="JavaScript" type="text/JavaScript">
<!--
  function toggleTbody(id) {
       if (document.getElementById) {
           var tbod = document.getElementById(id);
           if (tbod && typeof tbod.className == 'string') {
               if (tbod.className == 'off') {
                   tbod.className = 'on';
               } else {
                   tbod.className = 'off';
               }
           }
       }
       return false;
   }
   function toggleTbodyOff(id) {
       if (document.getElementById) {
           var tbod = document.getElementById(id);
           if (tbod && typeof tbod.className == 'string') {
               if (tbod.className == 'off') {
                   tbod.className = 'off';
               } else {
                   tbod.className = 'off';
               }
           }
       }
       return false;
   }
   function toggleTbodyOn(id) {
       if (document.getElementById) {
           var tbod = document.getElementById(id);
           if (tbod && typeof tbod.className == 'string') {
               if (tbod.className == 'off') {
                   tbod.className = 'on';
               } else {
                   tbod.className = 'on';
               }
           }
       }
       return false;
   }
   function getObj(objname)
   {
         form  = document.getElementById('step1');
         for(i=0; i<form.length; i++)
         {
                if(form[i].name==objname)
                    return form[i];
         }
         return null;
   }
   //End Function
   <?php if(isset($xajax)){ ?>
   xajax.realCall = xajax.call;
   xajax.call     = function(sFunction, aArgs, sRequestType)
   {
       this.$('spinner').style.display = 'inline';
       return this.realCall(sFunction, aArgs, sRequestType);
   }
   xajax.realProcessResponse = xajax.processResponse;
   xajax.processResponse     = function(xml)
   {
       this.$('spinner').style.display = 'none';
       return this.realProcessResponse(xml);
   }
   <?php } ?>
//-->
</script>
<?php if(isset($xajax)){ ?>
<style type="text/css">
tbody.on  { display:table-row-group; }
tbody.off { display:none; }
.smaller { font-size: smaller; font-style: italic; }

#waitsymbol {
  width: 250px;
  margin-left: auto;
  margin-right: auto;
}

#waitsymbol td {
  background: #ffffff;
}

#waitsymbol p {
  border: 4px solid #336699;
  padding: 10px;
  margin: 0;
  background: #ffffff;
}

#waitsymbol img {
  float: left;
  margin-right: 30px;
}

#waitsymbol strong {
  display: block;
  margin-bottom: 3px;
}

#waitsymbolContainer {
  position: fixed;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  position: expression('absolute');
  height: expression(document.documentElement.scrollHeight+'px');
  width: expression(document.documentElement.scrollWidth+'px');
  z-index: 1000;
}

#waitsymbolContainer td {
    padding-top: <?php echo (THEMEDIR=="default")?'150':'250'; ?>px;
    vertical-align: top;
    text-align: center;
    background-image: url(<?php echo empty($conf['show_loader'])?$BL->props->get_page("templates/".THEMEDIR."/images/opaque.gif"):$BL->props->get_page("templates/".THEMEDIR."/images/transparent.gif"); ?>);
}

#waitsymbolContainer td td {
    padding-top: 0px;
    text-align: left;
}
</style>
<?php } ?>
</head>
<body>
<?php if(isset($xajax))include_once $BL->props->get_page("templates/".THEMEDIR."/html/cart/loader.php"); ?>
