<?php
$name=$userlogin['detail']['firstname']." ".$userlogin['detail']['lastname']; 
?>
  <div class="container">
    <div class="row">
	<?php
	$this->load->view('depan/inc/left_view');
	?>
      <div class="main col-md-9">
        <div class="row">
          <div class="col-md-4">
	<?php
	$this->load->view('depan/inc/account_balance_view');
	?>

          </div>
          <div class="col-md-4 col-xs-6">
            <ul class="list-group text-dark panel-shadow">
              <a href="<?=base_url('deposit-form');?>#" class="list-group-item active partition-blue"> Add Deposit <i class="fa fa-15x fa-arrow-circle-up pull-right"></i> </a>
              <li class="list-group-item "> <a href="#" class="block text-center"><img style="width: 89px;" 
			  src="<?=base_url('media');?>/images/deposit.png"></a> </li>
            </ul>
          </div>
          <div class="col-md-4 col-xs-6">
            <ul class="list-group text-dark panel-shadow">
              <a href="<?=base_url('withdraw-form');?>#" class="list-group-item active partition-blue"> Make Withdraw <i class="fa fa-15x fa-arrow-circle-down pull-right"></i> </a>
              <li class="list-group-item "> <a href="#" class="block text-center"><img style="width: 89px;" 
			  src="<?=base_url('media');?>/images/withdraw.png"></a> </li>
            </ul>
          </div>
        </div>
        <div class="panel panel-white">
          <div class="panel-heading border-light">
            <h3><strong>Welcome to secure area</strong></h3>
            <p>Since you have existing live accounts please use this form to create your additional live account.</p>
          </div>
        </div>
        <div class="panel panel-white">
          <div class="panel-heading partition-blue"> <span class="text-bold"> Summary</span> </div>
          <div class="panel-body no-padding">
            <div class="row no-margin">
		  <!--start here-->
<?php 
	$load_view=isset($baseFolder)?$baseFolder.'inc/leftmenu_view':'leftmenu_view';
	//$this->load->view($load_view);
	
	$rand_url=url_title("{$detail['accountid']}-{$detail['detail']['firstname']}","-");
	$urlAffiliation=base_url("register/{$rand_url}");
?>		
			<div class="main col-md-12"> 
				<h3 class="orange nomargin"><strong>Welcome to the Secure Area of SalmaForex</strong></h3>
                <p>Dear <?=isset($userlogin['detail']['firstname'])?$userlogin['detail']['firstname']:'';?>&nbsp;<?=isset($userlogin['detail']['lastname'])?$userlogin['detail']['lastname']:'';?>,<br/>
				Your are now logged-in the Secure Area. Here you can view all the Information from your accounts. You can also Update Your Profile before deposit and withdrawn and many more. </p>
                <div class="vspace-30"></div>
				
				<h2>Detail</h2>
				<form   name="frm"  id="frmLiveAccount" method="POST"   role="form">
<?php 
	$detail1=$detail['detail'];
	callback_submit();
	$allow=false;
	if(isset($detail1['firstname'])&&trim($detail1['firstname'])!=''){
		$allow=1;
	}
?>
			<table class='table-striped table' border="0">
			<?=bsInput( lang('forex_firstname'),'firstname',isset($detail1['firstname'])?$detail1['firstname']:'', lang('forex_inputsuggestion'),$allow );?>
			<?=bsInput( lang('forex_lastname'),'lastname',isset($detail1['lastname'])?$detail1['lastname']:'', 
			lang('forex_inputsuggestion'),$allow   );?> 
			<?=bsInput( lang('forex_phone'),'phone',$detail1['phone'], lang('forex_inputsuggestion2')  );?>
			
			<?=bsInput( lang('forex_bank'),'bank',isset($detail1['bank'])?$detail1['bank']:'', lang('forex_inputsuggestion2')  );?>
			<?=bsInput( lang('forex_bank_norek'),'bank_norek',isset($detail1['bank_norek'])?$detail1['bank_norek']:'', lang('forex_inputsuggestion2')  );?>
			
				<?=bsInput( lang('forex_address'),'address',$detail1['address'], lang('forex_inputsuggestion2')  );?>
				<?=bsInput( lang('forex_state'),'state',$detail1['state'], lang('forex_inputsuggestion2')  );?>
				 
				<?=bsInput( lang('forex_city'),'city',$detail1['city'], lang('forex_inputsuggestion2')  );?>
				<?=bsInput( lang('forex_zipcode'),'zipcode', $detail1['zipcode'], lang('forex_inputsuggestion') );?>
			<?=bsInput( lang('forex_country'),'citizen', isset($detail1['citizen'])?$detail1['citizen']:'Indonesia', lang('forex_inputsuggestion'),1  );?>
			<?=bsButton('Update');?>
			</table>
			<input type='hidden' name='rand' value='<?=dbId('id',22222,3);?>' />
			</form> 
				
			</div>
		</div>
	</div>
	
</div>
</div></div></div>