<?php
defined('BASEPATH') OR exit('No direct script access allowed');?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<?php 
	$load_view=isset($baseFolder)?$baseFolder.'head_view':'head_view';
	$this->load->view($load_view);
?>
<body>
<?php 
	$load_view= $folder.'header_view';
	$this->load->view($load_view);
?>
 <!-- CONTENT-WRAPPER SECTION START-->
    <div class="content-wrapper" id="salma-main">	
<?php 
//$this->load->view('menu_view');
if(isset($content)){
	if(!is_array($content)){
		$contents=array($content);		
	}
	else{ 
		$contents=$content;
	}
	foreach($contents as $viewFile){
			$load_view= $folder.$viewFile.'_view';
			$this->load->view($load_view);
	}
}else{}
?>
	</div>
	<div class='clear'></div>
	<div id='bgAjax'>&nbsp;</div>
	
<!-- CONTENT-WRAPPER SECTION END-->
	<!-- FOOTER SECTION START-->
<?php 
$load_view=isset($baseFolder)?$baseFolder.'footer_view':'footer_view';
$this->load->view($load_view);
?>
    <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    
<?php 
if(isset($footerJS)){ 
	if(!is_array($footerJS)){ 
		$footerJS=array($footerJS); 
	}else{}
	
	foreach($footerJS as $jsFile ){?>
	  <script src="<?=base_url();?>assets/<?=$jsFile;?>"></script>
<?php 
	}
}else{ echo '<!--no footer js -->'; } ?>
<script type="text/javascript">try{Typekit.load({
     active: function() {}
});}catch(e){}</script>
<?php 
if(!defined('LOCAL')){?>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5652d61400c5a4a1546218c3/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
<?php 
}
?>
</body>
</html>
