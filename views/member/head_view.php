<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, maximum-scale=1.0, minimum-scale=1.0">
	<title itemprop="name">SalmaForex | Full STP Broker</title>

	<!-- W3TC-include-js-head -->
	<!--[if IE 8]> 
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<![endif]-->
	<link rel="alternate" type="application/rss+xml" title="SalmaForex &raquo; Feed" href="http://www.salmaforex.com/feed/" />
	<link rel="alternate" type="application/rss+xml" title="SalmaForex &raquo; Comments Feed" href="http://www.salmaforex.com/comments/feed/" />
	<link rel="alternate" type="application/rss+xml" title="SalmaForex &raquo; Homepage &#8211; Layer Slider Comments Feed" href="http://www.salmaforex.com/homepage-v2/feed/" />
  
	<style id='rs-plugin-settings-inline-css' type='text/css'>	.tp-caption.caption-primary{font-weight:300;font-size:30px;line-height:36px}.tp-caption.caption-white-background{padding:10px 20px;-moz-border-radius:3px;-webkit-border-radius:3px;border-radius:3px;font-weight:300;font-size:24px;line-height:30px;color:#0197ec;background-color:#fff;-webkit-box-shadow:0 1px 2px rgba(0,0,0,.25);-moz-box-shadow:0 1px 2px rgba(0,0,0,.25);box-shadow:0 1px 2px rgba(0,0,0,.25)}.tp-caption.caption-long-text{font-weight:300;font-size:20px;line-height:24px;color:#333;text-align:justify}.tp-caption.noshadow{}.tp-caption a{color:#ff7302;text-shadow:none;-webkit-transition:all 0.2s ease-out;-moz-transition:all 0.2s ease-out;-o-transition:all 0.2s ease-out;-ms-transition:all 0.2s ease-out}.tp-caption a:hover{color:#ffa902}
	</style>
	
 
	<script type='text/javascript'>
	/* <![CDATA[ */
	var CloudFwOp = {"themeurl":"http:\/\/www.salmaforex.com\/wp-content\/themes\/envision-2.0.9.4","ajaxUrl":"http:\/\/www.salmaforex.com\/wp-admin\/admin-ajax.php","device":"widescreen","RTL":false,"SSL":false,"protocol":"http","responsive":true,"lang":"en-US","sticky_header":true,"header_overlapping":false,"navigation_event":"hover","sticky_header_offset":-30,"uniform_elements":true,"disable_prettyphoto_on_mobile":true,"text_close":"Close","gallery_overlay_opacity":"0.9"};
	/* ]]> */
	</script>
	 
	 
	<link rel="EditURI" type="application/rsd+xml" title="RSD" href="http://www.salmaforex.com/xmlrpc.php?rsd" />
	<link rel='canonical' href='http://www.salmaforex.com/' />
	<link rel='shortlink' href='<?=$shortlink;?>' />
	
	<link rel="shortcut icon" href="<?=$shortlink;?>assets/img/salmaforex.png" />
	
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="<?=$description;?>" />
    <meta name="author" content="SalmaForex" />
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
        <meta name="format-detection" content="telephone=no">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="default">
        <meta name="msapplication-tap-highlight" content="no"/>

    <link rel="apple-touch-icon-precomposed" href="<?=base_url().'assets/sencha/';?>images/apple-touch-icon.png">
		
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <title><?php 
if(isset($title)){ 
	echo $title;
}
else{
?>HELLO WORLD<?php 
} ?></title> 
<script>
var siteUrl="<?=base_url();?>";
/* 
var Ext = Ext || {};

Ext.theme={ name:"Default" };
*/ 
</script>
<?php 
if(isset($fileCss)){
	foreach($fileCss as $id=>$file){
		if(intval($id)==0){ $strID='id="'.$id.'"';}else{ $strID='';}
?>
	<link rel="stylesheet" <?=$strID;?> href="<?=base_url().'assets/'.$file;?>?7"  media='all' />
<?php
	}
}
?>
	<!--[if IE 7]>
	<link rel='stylesheet' id='theme-fontawesome-ie7-css'  href='<?=base_url();?>assets/css/module.fontawesome/source/css/font-awesome-ie7.min.css?ver=384753e655020ba892b1123f6ddf06b2' type='text/css' media='all' />
	<![endif]-->
<?php 
if(isset($fileJs)){
	foreach($fileJs as $file){?>
	<script src="<?=base_url().'assets/'.$file;?>"></script><?php
	}
}

?>
<script type="text/javascript">
/***********************************************
* Accordion Content script- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* Visit http://www.dynamicDrive.com for hundreds of DHTML scripts
* Please keep this notice intact
***********************************************/
//Initialize Arrow Side Menu:
ddaccordion.init({
	headerclass: "menuheaders", //Shared CSS class name of headers group
	contentclass: "menucontents", //Shared CSS class name of contents group
	revealtype: "click", //Reveal content when user clicks or onmouseover the header? Valid value: "click", or "mouseover"
	mouseoverdelay: 200, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
	collapseprev: true, //Collapse previous content (so only one open at any time)? true/false 
	defaultexpanded: [0], //index of content(s) open by default [index1, index2, etc]. [] denotes no content.
	onemustopen: false, //Specify whether at least one header should be open always (so never all headers closed)
	animatedefault: false, //Should contents open by default be animated into view?
	persiststate: true, //persist state of opened contents within browser session?
	toggleclass: ["unselected", "selected"], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
	togglehtml: ["none", "", ""], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
	animatespeed: 500, //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
	oninit:function(expandedindices){ //custom code to run when headers have initalized
		//do nothing
	},
	onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
		//do nothing
	}
})

</script>

<style type="text/css">

.arrowsidemenu{
	width: 180px; /*width of menu*/
	border-style: solid solid none solid;
	border-color: #94AA74;
	border-size: 1px;
	border-width: 1px;
}
	
.arrowsidemenu div a{ /*header bar links*/
	font: bold 12px Verdana, Arial, Helvetica, sans-serif;
	display: block;
	background: transparent url(<?=base_url("assets/img/arrowblue.gif");?>) 100% 0;
/*http://forex.local/member/arrowgreen.gif*/	
  height: 24px; /*Set to height of bg image-padding within link (ie: 32px - 4px - 4px)*/
	padding: 4px 0 4px 10px;
	line-height: 24px; /*Set line-height of bg image-padding within link (ie: 32px - 4px - 4px)*/
	text-decoration: none;
}
	
.arrowsidemenu div a:link, .arrowsidemenu div a:visited{
	color: white;
}

.arrowsidemenu div a:hover{
	background-position: 100% -32px;
}

.arrowsidemenu div.unselected a{ /*header that's currently not selected*/
	color: white;
}

	
.arrowsidemenu div.selected a{ /*header that's currently selected*/
	color: #97B9FC;
	background-position: 100% -64px !important;
}

.arrowsidemenu ul{
	list-style-type: none;
	margin: 0;
	padding: 0;
}

.arrowsidemenu ul li{
	border-bottom: 1px solid #a1c67b;
}

.arrowsidemenu ul li a .ui--icon{
	display:none;
}
.arrowsidemenu ul li a{ /*sub menu links*/
	display: block;
	font: normal 12px Verdana, Arial, Helvetica, sans-serif;
	text-decoration: none;
	color: black;
	padding: 5px 0;
	padding-left: 10px;
	border-left: 10px double #97B9FC;
}

.arrowsidemenu ul li a:hover{
	background: RGBA(151, 185, 252, 0.46);
}

.alone{
	color: rgba(255, 209, 13,.9) !important;
}
.box-welcome{
	margin-left:230px;
}
.box-info{	
	width: 200px;
	margin-left: 0px;
	padding: 10px;
	float:left; 
	margin-right:0px;

}
.box-detail{
	background: rgb(14, 90, 242) none repeat scroll 0% 0%;
	margin: 20px;
	font-size:120%;
	color:white;
	width: 89%;
	min-height: 80px;
	text-align:center;
	padding-top:20px;
}
.box-detail button{
	color:gold;
}
.clear{
	clear:both;
}</style>
</head>