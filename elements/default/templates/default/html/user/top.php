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

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html dir="<?php echo PAGEDIR; ?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title>
<?php if(isset($Custompage_Data['title']))echo $Custompage_Data['title']; else echo !empty($BL->conf['company_name'])?$BL->conf['company_name']:$BL->props->lang['accountlabplus']; ?>
</title>
<?php if(isset($Custompage_Data['metatags']))echo $Custompage_Data['metatags']; else echo $BL->conf['metatags']; ?>
<link rel="stylesheet" href="<?php echo $BL->props->get_page("templates/".THEMEDIR."/css/user.css"); ?>" type="text/css">
<script type="text/javascript">
<!--
var time = 3000;
var numofitems = 7;

//menu constructor
function menu(allitems,thisitem,startstate){ 
  callname= "gl"+thisitem;
  divname="subglobal"+thisitem;  
  this.numberofmenuitems = 7;
  this.caller = document.getElementById(callname);
  this.thediv = document.getElementById(divname);
  this.thediv.style.visibility = startstate;
}

//menu methods
function ehandler(event,theobj){
  for (var i=1; i<= theobj.numberofmenuitems; i++){
    var shutdiv =eval( "menuitem"+i+".thediv");
    shutdiv.style.visibility="hidden";
  }
  theobj.thediv.style.visibility="visible";
}
                
function closesubnav(event){
  if ((event.clientY <48)||(event.clientY > 107)){
    for (var i=1; i<= numofitems; i++){
      var shutdiv =eval('menuitem'+i+'.thediv');
      shutdiv.style.visibility='hidden';
    }
  }
}

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
var clicked = 't1';
function showTab( tab , tabs , t, ts){
    for(i=0; i < tabs.length; i++){
        var obj = document.getElementById(tabs[i]);
        obj.style.display = "none";
        var obj1 = document.getElementById(ts[i]);
        obj1.className = "tabs";        
    }
    var obj = document.getElementById(tab);
    obj.style.display = "block";  
    var obj1 = document.getElementById(t);
    obj1.className = "tabs2";
    clicked = t;    
}
function overTab( t, ts){
    for(i=0; i < ts.length; i++){
        if(clicked!=ts[i]){
            var obj1 = document.getElementById(ts[i]);
            obj1.className = "tabs";  
        }   
    }
    var obj1 = document.getElementById(t);
    obj1.className = "tabs1";
}
function outTab(ts){
    for(i=0; i < ts.length; i++){
        var obj1 = document.getElementById(ts[i]);
        obj1.className = "tabs";        
    }
    var obj1 = document.getElementById(clicked);
    obj1.className = "tabs2";
}

function Trim(TRIM_VALUE){
    if(TRIM_VALUE.length < 1){
        return"";
    }
    TRIM_VALUE = RTrim(TRIM_VALUE);
    TRIM_VALUE = LTrim(TRIM_VALUE);
    if(TRIM_VALUE==""){
        return "";
    }
    else{
        return TRIM_VALUE;
    }
} //End Function

function RTrim(VALUE){
    var w_space = String.fromCharCode(32);
    var v_length = VALUE.length;
    var strTemp = "";
    if(v_length < 0){
        return"";
    }
    var iTemp = v_length -1;
    
    while(iTemp > -1){
    if(VALUE.charAt(iTemp) == w_space){
    }
    else{
        strTemp = VALUE.substring(0,iTemp +1);
        break;
    }
    iTemp = iTemp-1;
    
    } //End While
    return strTemp;

} //End Function

function LTrim(VALUE){
    var w_space = String.fromCharCode(32);
    if(v_length < 1){
        return"";
    }
    var v_length = VALUE.length;
    var strTemp = "";
    
    var iTemp = 0;
    
    while(iTemp < v_length){
    if(VALUE.charAt(iTemp) == w_space){
    }
    else{
        strTemp = VALUE.substring(iTemp,v_length);
        break;
    }
    iTemp = iTemp + 1;
    } //End While
    return strTemp;
} //End Function   
function ajax(){
    var http_request = false;
    var img_id  = null;
    var cmd = 0;
    function makeRequest(url,imgid,c) {
        http_request = false;
        img_id = imgid;
        cmd = c;
        if (window.XMLHttpRequest) { // Mozilla, Safari,...
            http_request = new XMLHttpRequest();
            if (http_request.overrideMimeType) {
                http_request.overrideMimeType('text/xml');
                // See note below about this line
            }
        } else if (window.ActiveXObject) { // IE
            try {
                http_request = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (e) {
                try {
                    http_request = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (e) {}
            }
        }

        if (!http_request) {
            alert('Giving up :( Cannot create an XMLHTTP instance');
            return false;
        }
        http_request.onreadystatechange = listStates;
        http_request.open('GET', url, true);
        http_request.send(null);
    }
    function listStates() {
        if (http_request.readyState == 4) {
            if (http_request.status == 200) {
                var xmlDoc = http_request.responseXML;          
                var state_obj = getObj('state','form1');
                var count = 0;
                state_obj.options.length = count;  
                <?php echo "var key = '".(isset($customer['state'])?$customer['state']:'0')."';"; ?> 
                var key_added = 0;
                for(i=0; i<xmlDoc.getElementsByTagName('count').item(0).firstChild.data; i++)
                {
					var elem = xmlDoc.getElementsByTagName('state').item(i);
                    var state = elem.firstChild.data;
					var abbr = elem.getAttribute('abbr');

                    if(escape(Trim(state)).charAt(0)!='%' && Trim(state)!='')
                    {
                        if((state == key) || (abbr == key))
                        {
                            state_obj.options[count++] = new Option(Trim(state), Trim(abbr ? abbr : state), true, true);
                            key_added = 1;
                        }
                        else
                            state_obj.options[count++] = new Option(Trim(state), Trim(abbr ? abbr : state), false);
                    }
                }
                if(key_added == 0 && key!='0')
                {
                    state_obj.options[count++] = new Option(Trim(key), Trim(key), true, true);
                }
                
            } else {
                //alert('There was a problem with the request.');
            }
        }
    }
    this.makeRequest = makeRequest;
}
function updateStates(ccode)
{
    var url = 'info.php?cc='+ccode;
    var stateHandler = new ajax();
    stateHandler.makeRequest(url,'state',1);
}
function getObj(obj_name,form_name)
{
    var form  = document.getElementById(form_name);
    for(i=0; i<form.length; i++)
    {
        if(form[i].name==obj_name)
            return form[i];
    }
    return null;
}
function showFaqGroup(page,faqgroup_id){
    <?php $url = "page+'?cmd=".$cmd."&faqgroup_id='+faqgroup_id"; ?>
    var url  = <?php echo $url; ?>;
    eval("parent.location='"+url+"'");
}
function changeLang(page,language){
    <?php $url = "page+'?cmd=".$cmd."&force_lang='+language"; ?>
    var url  = <?php echo $url; ?>;
    eval("parent.location='"+url+"'");
}
function changeTheme(page,theme){
    <?php $url = "page+'?cmd=".$cmd."&force_theme='+theme"; ?>
    var url  = <?php echo $url; ?>;
    eval("parent.location='"+url+"'");
}
//-->
</script>
<?php if($BL->conf['en_html_editor']){ ?>
<script language="javascript" type="text/javascript" src="system/libraries/tinymce/jscripts/tiny_mce/tiny_mce_gzip.php"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
    mode : "textareas",
    theme : "advanced",
    auto_reset_designmode : true,
    browsers : "msie,gecko,opera",
    dialog_type : "modal",
    directionality : "<?php echo strtolower(PAGEDIR); ?>",
    object_resizing : false,
    plugins : "table,advhr,advimage,advlink,emotions,iespell,flash,searchreplace,print,contextmenu",
    theme_advanced_buttons1 : "bold,italic,underline,strikethrough,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist,separator,forecolor,backcolor,separator,hr,charmap,image,emotions,code",
    theme_advanced_buttons2 : "",
    theme_advanced_buttons3 : "",
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    theme_advanced_path_location : "bottom",
    theme_advanced_resizing : true,
    height:"200px",
    width:"450px",
    extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]"
});
</script>
<?php } ?>
</head>
<body>
