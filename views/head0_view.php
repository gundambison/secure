<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="Klinik Ciracas" />
    <meta name="author" content="Gunawan Wibisono" />
	
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
var siteUrl="<?=site_url();?>";
/* 
var Ext = Ext || {};

Ext.theme={ name:"Default" };
*/ 
</script>
<?php 
if(isset($fileCss)){
	foreach($fileCss as $file){?>
	<link rel="stylesheet" href="<?=base_url().'assets/'.$file;?>" /><?php
	}
}

if(isset($fileJs)){
	foreach($fileJs as $file){?>
	<script src="<?=base_url().'assets/'.$file;?>"></script><?php
	}
}

?>

</head>