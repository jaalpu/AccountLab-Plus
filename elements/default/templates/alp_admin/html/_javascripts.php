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

<?php if($BL->conf['en_html_editor']==1){ ?>
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
    editor_deselector : "search",
    plugins : "table,advhr,advimage,advlink,emotions,iespell,flash,searchreplace,print,contextmenu",
    theme_advanced_buttons1 : "formatselect,separator,bold,italic,underline,strikethrough,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist",
    theme_advanced_buttons2 : "undo,redo,link,unlink,forecolor,backcolor,removeformat,separator,hr,charmap,image,emotions,separator,search,replace,cleanup,code",
    theme_advanced_buttons3 : "tablecontrols",
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
<script language="JavaScript" type="text/javascript">
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

var enablepersist="on"
var collapseprevious="no"

if (document.getElementById)
{
    document.write('<style type="text/css">')
    document.write('.switchcontent{display:none;}')
    document.write('</style>')
}

function getElementbyClass(classname)
{
    ccollect=new Array()
    var inc=0
    var alltags=document.all? document.all : document.getElementsByTagName("*")
    for (i=0; i<alltags.length; i++)
    {
        if (alltags[i].className==classname)
        ccollect[inc++]=alltags[i]
    }
}

function contractcontent(omit)
{
    var inc=0
    while (ccollect[inc])
    {
        if (ccollect[inc].id!=omit)
        ccollect[inc].style.display="none"
        inc++
    }
}

function expandcontent(cid)
{
    if (typeof ccollect!="undefined")
    {
        if (collapseprevious=="yes")
        contractcontent(cid)
        document.getElementById(cid).style.display=(document.getElementById(cid).style.display!="block")? "block" : "none"
    }
}

function revivecontent()
{
    contractcontent("omitnothing")
    selectedItem=getselectedItem()
    selectedComponents=selectedItem.split("|")
    for (i=0; i<selectedComponents.length-1; i++)
        document.getElementById(selectedComponents[i]).style.display="block"
}

function get_cookie(Name)
{
    var search = Name + "="
    var returnvalue = "";
    if (document.cookie.length > 0)
    {
        offset = document.cookie.indexOf(search)
        if (offset != -1)
        {
            offset += search.length
            end = document.cookie.indexOf(";", offset);
            if (end == -1) end = document.cookie.length;
            returnvalue=unescape(document.cookie.substring(offset, end))
        }
    }
    return returnvalue;
}

function getselectedItem()
{
    if (get_cookie(window.location.pathname) != "")
    {
        selectedItem=get_cookie(window.location.pathname)
        return selectedItem
    }
    else
        return ""
}

function saveswitchstate()
{
    var inc=0, selectedItem=""
    while (ccollect[inc])
    {
        if (ccollect[inc].style.display=="block")
        selectedItem+=ccollect[inc].id+"|"
        inc++
    }
    document.cookie=window.location.pathname+"="+selectedItem
}

function do_onload()
{
    uniqueidn=window.location.pathname+"firsttimeload"
    getElementbyClass("switchcontent")
    if (enablepersist=="on" && typeof ccollect!="undefined")
    {
        document.cookie=(get_cookie(uniqueidn)=="")? uniqueidn+"=1" : uniqueidn+"=0"
        firsttimeload=(get_cookie(uniqueidn)==1)? 1 : 0 //check if this is 1st page load
        if (!firsttimeload)
            revivecontent()
    }
}

if (window.addEventListener)
    window.addEventListener("load", do_onload, false)
else if (window.attachEvent)
    window.attachEvent("onload", do_onload)
else if (document.getElementById)
    window.onload=do_onload

if (enablepersist=="on" && document.getElementById)
    window.onunload=saveswitchstate
//dropdown menu script
var cssdropdown={
    disappeardelay: 250,
    dropmenuobj: null, ie: document.all, firefox: document.getElementById&&!document.all,

    getposOffset:function(what, offsettype)
    {
        var totaloffset=(offsettype=="left")? what.offsetLeft : what.offsetTop;
        var parentEl=what.offsetParent;
        while (parentEl!=null)
        {
            totaloffset=(offsettype=="left")? totaloffset+parentEl.offsetLeft : totaloffset+parentEl.offsetTop;
            parentEl=parentEl.offsetParent;
        }
        return totaloffset;
    },

    showhide:function(obj, e, visible, hidden)
    {
        if (this.ie || this.firefox)
            this.dropmenuobj.style.left=this.dropmenuobj.style.top="-500px"
        if (e.type=="click" && obj.visibility==hidden || e.type=="mouseover")
            obj.visibility=visible
        else if (e.type=="click")
            obj.visibility=hidden
    },

    iecompattest:function()
    {
        return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
    },

    clearbrowseredge:function(obj, whichedge)
    {
        var edgeoffset=0
        if (whichedge=="rightedge")
        {
            var windowedge=this.ie && !window.opera? this.iecompattest().scrollLeft+this.iecompattest().clientWidth-15 : window.pageXOffset+window.innerWidth-15
            this.dropmenuobj.contentmeasure=this.dropmenuobj.offsetWidth
            if (windowedge-this.dropmenuobj.x < this.dropmenuobj.contentmeasure)  //move menu to the left?
                edgeoffset=this.dropmenuobj.contentmeasure-obj.offsetWidth
        }
        else
        {
            var topedge=this.ie && !window.opera? this.iecompattest().scrollTop : window.pageYOffset
            var windowedge=this.ie && !window.opera? this.iecompattest().scrollTop+this.iecompattest().clientHeight-15 : window.pageYOffset+window.innerHeight-18
            this.dropmenuobj.contentmeasure=this.dropmenuobj.offsetHeight
            if (windowedge-this.dropmenuobj.y < this.dropmenuobj.contentmeasure)
            { //move up?
                edgeoffset=this.dropmenuobj.contentmeasure+obj.offsetHeight
                if ((this.dropmenuobj.y-topedge)<this.dropmenuobj.contentmeasure) //up no good either?
                    edgeoffset=this.dropmenuobj.y+obj.offsetHeight-topedge
            }
        }
        return edgeoffset
    },

    dropit:function(obj, e, dropmenuID)
    {
        if (this.dropmenuobj!=null) //hide previous menu
            this.dropmenuobj.style.visibility="hidden"
        this.clearhidemenu()
        if (this.ie||this.firefox)
        {
            obj.onmouseout=function(){cssdropdown.delayhidemenu()}
            this.dropmenuobj=document.getElementById(dropmenuID)
            this.dropmenuobj.onmouseover=function(){cssdropdown.clearhidemenu()}
            this.dropmenuobj.onmouseout=function(){cssdropdown.dynamichide(e)}
            this.dropmenuobj.onclick=function(){cssdropdown.delayhidemenu()}
            this.showhide(this.dropmenuobj.style, e, "visible", "hidden")
            this.dropmenuobj.x=this.getposOffset(obj, "left")
            this.dropmenuobj.y=this.getposOffset(obj, "top")
            this.dropmenuobj.style.left=this.dropmenuobj.x-this.clearbrowseredge(obj, "rightedge")+"px"
            this.dropmenuobj.style.top=this.dropmenuobj.y-this.clearbrowseredge(obj, "bottomedge")+obj.offsetHeight+1+"px"
        }
    },

    contains_firefox:function(a, b)
    {
        while (b.parentNode)
            if ((b = b.parentNode) == a)
                return true;
        return false;
    },

    dynamichide:function(e)
    {
        var evtobj=window.event? window.event : e
        if (this.ie&&!this.dropmenuobj.contains(evtobj.toElement))
            this.delayhidemenu()
        else if (this.firefox&&e.currentTarget!= evtobj.relatedTarget&& !this.contains_firefox(evtobj.currentTarget, evtobj.relatedTarget))
            this.delayhidemenu()
    },
    delayhidemenu:function()
    {
        this.delayhide=setTimeout("cssdropdown.dropmenuobj.style.visibility='hidden'",this.disappeardelay)
    },

    clearhidemenu:function()
    {
        if (this.delayhide!="undefined")
            clearTimeout(this.delayhide)
    }
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
        if(imgid=='state')
        {
            http_request.onreadystatechange = listStates;
        }
        else if(imgid=='country_3')
        {
            http_request.onreadystatechange = listNewsletterStates;
        }
        else if(imgid=='tax_state[]')
        {
        	http_request.onreadystatechange = listTaxStates;
        }
        else if(imgid=='whois')
        {
        	http_request.onreadystatechange = showWhois;
        }
        else
        {
            http_request.onreadystatechange = serverStatus;
        }
        http_request.open('GET', url, true);
        http_request.send(null);
    }
    function showWhois() {
        if (http_request.readyState == 4) {
            if (http_request.status == 200) {
                s = http_request.responseText;
                toggleTbodyOn('whoisresult_div');
                document.getElementById('whoisresult').innerHTML = s;
            } else {
                //alert('There was a problem with the request.');
            }
        }
        else if(http_request.readyState != 0)
        {
            toggleTbodyOn('whoisresult_div');
            document.getElementById('whoisresult').innerHTML = '<img src=\"elements/default/templates/alp_admin/images/quering.gif\" alt=\"<?php echo $BL->props->lang['quering']; ?>\" border=\"0\" />';
        }
    }

    function serverStatus() {
        if(cmd == 1)
        {
            if (http_request.readyState == 4) {
                if (http_request.status == 200) {
                    status1 = http_request.responseText;
                    if(status1=='online')
                        document.getElementById(img_id).innerHTML='<img src=\"elements/default/templates/alp_admin/images/online.gif\" alt=\"---\" border=\"0\" />';
                    else
                        document.getElementById(img_id).innerHTML='<img src=\"elements/default/templates/alp_admin/images/offline.gif\" alt=\"---\" border=\"0\" />';
                } else {
                    document.getElementById(img_id).innerHTML='<img src=\"elements/default/templates/alp_admin/images/offline.gif\" alt=\"---\" border=\"0\" />';
                }
            }
            else
                if(http_request.readyState != 0)
                {
                    document.getElementById(img_id).innerHTML='<img src=\"elements/default/templates/alp_admin/images/quering.gif\" alt=\"<?php echo $BL->props->lang['quering']; ?>\" border=\"0\" />';
                }
        }
    }
    function listStates() {
        if (http_request.readyState == 4) {
            if (http_request.status == 200) {
                var xmlDoc = http_request.responseXML;
                var state_obj = getObj('state','form1');
                var count = 0;
                state_obj.options.length = count;
                <?php echo "var key = '".(isset($REQUEST['state'])?$REQUEST['state']:'0')."';"; ?>
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
    function listNewsletterStates() {
        if (http_request.readyState == 4) {
            if (http_request.status == 200) {
                var xmlDoc = http_request.responseXML;
                var state_obj = getObj('country_3','form1');
                var count = 1;
                state_obj.options.length = count;
                <?php echo "var key = '".(isset($REQUEST['country_3'])?$REQUEST['country_3']:'0')."';"; ?>
                var key_added = 0;
                for(i=0; i<xmlDoc.getElementsByTagName('count').item(0).firstChild.data; i++)
                {
                    var state = xmlDoc.getElementsByTagName('state').item(i).firstChild.data;
                    if(escape(Trim(state)).charAt(0)!='%' && Trim(state)!='' && Trim(state)!='N/A')
                    {
                        if(state == key)
                        {
                            state_obj.options[count++] = new Option(Trim(state), Trim(state), true, true);
                            key_added = 1;
                        }
                        else
                            state_obj.options[count++] = new Option(Trim(state), Trim(state), false);
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
    function listTaxStates() {
        if (http_request.readyState == 4) {
            if (http_request.status == 200) {
                var xmlDoc = http_request.responseXML;
                var state_obj = getObj('tax_state[]','form1');
                var count = 0;
                state_obj.options.length = count;
                state_obj.options[count++] = new Option('<?php echo $BL->props->lang['all']; ?>', '<?php echo $BL->props->lang['all']; ?>', false);
                pre_states_array = new Array();
                <?php if(isset($ts_array) && is_array($ts_array) && count($ts_array)>0) {
                    $str = "";
                    foreach($ts_array as $temp) {
                        $str .= empty($str)?"\"".$temp."\"":", \"".$temp."\"";
                    }
                    echo "pre_states_array = new Array(".$str.");";
                } ?>
                for(i=0; i<xmlDoc.getElementsByTagName('count').item(0).firstChild.data; i++)
                {
                    var state = xmlDoc.getElementsByTagName('state').item(i).firstChild.data;
                    if(escape(Trim(state)).charAt(0)!='%' && Trim(state)!='' && Trim(state)!='N/A')
                    {
                        x = 0;
                        if(pre_states_array.length > 0)
                        {
                            for(j=0; j<pre_states_array.length; j++)
                            {
                                if(pre_states_array[j] == state)
                                    x = 1;
                            }
                        }
                        if(x == 1)
                        {
                            state_obj.options[count++] = new Option(Trim(state), Trim(state), true, true);
                        }
                        else
                        {
                            state_obj.options[count++] = new Option(Trim(state), Trim(state), false);
                        }
                    }
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
function updateNewsletterStates(ccode)
{
    var url = 'info.php?cc='+ccode;
    var stateHandler = new ajax();
    stateHandler.makeRequest(url,'country_3',1);
}
function updateTaxStates(ccode)
{
    var url = 'info.php?cc='+ccode;
    var taxstateHandler = new ajax();
    taxstateHandler.makeRequest(url,'tax_state[]',1);
}
function whoisQuery(sld,tld,type)
{
    if(type==1)
    {
    	var url = 'info.php?whois=true&tld='+tld+'&sld='+sld;
    }
    else
    {
    	var url = 'info.php?subdomain=true&tld='+tld+'&sld='+sld;
    }

    var whoisHandler = new ajax();
    whoisHandler.makeRequest(url,'whois',1);
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
function jumpMenu(url_index){
    <?php $ext = ($cmd=="editorder")?("&sub_id=".$REQUEST['sub_id']):""; ?>
    <?php $url = "'admin.php?cmd=".$cmd.$ext."&customer_id='+getObj('customer_id','form1').options[getObj('customer_id','form1').selectedIndex].value"; ?>
    var url  = <?php echo $url; ?>;
    if(url_index==1)
    {
        url = url+"&group_id="+getObj('group_id','form1').options[getObj('group_id','form1').selectedIndex].value
    }
    if(url_index==2)
    {
        url = url+"&group_id="+getObj('group_id','form1').options[getObj('group_id','form1').selectedIndex].value
        url = url+"&product_id="+getObj('product_id','form1').options[getObj('product_id','form1').selectedIndex].value
    }
    if(url_index==3)
    {
        url = url+"&group_id="+getObj('group_id','form1').options[getObj('group_id','form1').selectedIndex].value
        url = url+"&product_id="+getObj('product_id','form1').options[getObj('product_id','form1').selectedIndex].value
        url = url+"&server_id="+getObj('server_id','form1').options[getObj('server_id','form1').selectedIndex].value

    }
    eval("parent.location='"+url+"'");
}
function NumberOfSelection(obj_name,form_name)
{
    var obj = getObj(obj_name,form_name);
    var selectedArray = new Array();
    var i;
    var count = 0;
    for (i=0; i<obj.options.length; i++) {
        if (obj.options[i].selected) {
              selectedArray[count] = obj.options[i].value;
              count++;
        }
    }
    return selectedArray.length;
}
</script>
