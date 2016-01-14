<?php
defined('BASEPATH') OR exit('No direct script access allowed');?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<?php 
	$load_view=isset($baseFolder)?$baseFolder.'head_view':'head_view';
	$this->load->view($load_view);
?>
<body>
<!-- HEADER START-->	
<?php 
$load_view=isset($baseFolder)?$baseFolder.'header_view':'header_view';
$this->load->view($load_view);
?>
<!-- HEADER END-->    
<!-- NAVBAR START-->    
<?php 
$load_view=isset($baseFolder)?$baseFolder.'navbar_view':'navbar_view';
$this->load->view($load_view);
?>
<!-- NAVBAR END-->  
<!-- CONTENT-WRAPPER SECTION START-->
    <div class="content-wrapper">
<?php 
if(isset($content)){
	$load_view= $folder.$content.'_view';
	$this->load->view($load_view);
}else{}
?>
	</div>
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
	  <script src="<?=base_url();?>assets/js/<?=$jsFile;?>"></script>
<?php 
	}
}else{ echo '<!--no footer js -->'; } ?>
</body>
</html>
