    		<div class="main-left col-md-4">
            	<div class="box green-box">
                	<h3 class="box-title"><strong>SalmaForex Ballance</strong></h3>
                    <div class="row large">
                    	<div class="col-xs-5"><strong>Account :</strong></div>
                        <div class="col-xs-7 text-right"><?=isset($userlogin['username'])?$userlogin['username']:'';?></div>
                    </div>
                    <div class="row large">
                    	<div class="col-xs-5"><strong>Name :</strong></div>
                        <div class="col-xs-7 text-right"><?=isset($userlogin['detail']['firstname'])?$userlogin['detail']['firstname']:'';?>&nbsp;<?=isset($userlogin['detail']['lastname'])?$userlogin['detail']['lastname']:'';?></div>
                    </div>
                    <hr/>
                    <!--div class="row large">
                    	<div class="col-xs-5"><strong>Ballance :</strong></div>
                        <div class="col-xs-7 text-right">$ 12.00</div>
                    </div-->
                </div>
                <div class="vspace-30"></div>
                <div class="drop-nav">
<?php 
$menu=2;
if($menu==2){
	if(isset($detail)&&$detail['type']=='admin'){
		$this->load->view('depan/inc/menu_admin_view');
		$menuShow=1;
	}
	
	if(!isset($menuShow)){
		$this->load->view('depan/inc/menu_usernormal_view');
	}
}
?>
 
                </div>
                <div class="vspace-30"></div>
                <div class="row">
                	<div class="col-xs-6 text-center">
                    	<a href="#"><img class="img-responsive inlineblock" alt="Live Support" src="<?=base_url();?>media/images/live-support.jpg" /></a>
                    </div>
                    <div class="col-xs-6 text-center">
                    	<a href="#"><img class="img-responsive inlineblock" alt="Skype Support" src="<?=base_url();?>media/images/skype-support.jpg" /></a>
                    </div>
                </div>
                <div class="vspace-30 visible-sm visible-xs"></div>
            </div>
      