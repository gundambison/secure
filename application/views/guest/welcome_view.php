<?php 
 
?>
<div class="container">
    	<div class="row">
        	<div class="main col-md-12">
            	<h3 class="white nomargin"><strong>Register to the Secure Area of SalmaForex</strong></h3>
                <p class='white'>Welcome and Join With Us</p>
                <div class="vspace-30"></div>
            </div>
    		<div class="main-left col-md-7">
			
<?php 
			$load_view=$baseFolder.'form_view';
			$this->load->view($load_view); 
?>
			<div class="vspace-30"></div>
            </div>
            <div class="col-md-1 col-sm-2"></div>
            <div class="col-md-4 col-sm-10">
            	<div class="row">
<?php 
			$load_view=$baseFolder.'inc/support_view';
			$this->load->view($load_view); 
?>
                </div>
            </div>
    	</div>
    </div>
