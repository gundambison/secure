<?php 
///detail 
?>
<div class='container'>
    <div style='margin-top:30px;'>
			<div class="frame-form-basic">
			<h2>Detail</h2>
			<form   name="frm"  id="frmLiveAccount" method="POST" class="form-horizontal" role="form">
<?php 
$detail1=$detail['detail'];
if(isset($warning)&&$warning!==0){
	?><b>SILAKAN LENGKAPI SEMUA DETAIL YANG TERSEDIA</b><?php 
}
$allow=false;
if(isset($detail1['firstname'])&&$detail1['firstname']!=''){
	$allow=1;
}
?>
		<table class='formBasic' border="0">
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