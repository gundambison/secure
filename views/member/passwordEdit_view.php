<?php 

?>
<div class='container'>
    <div style='margin-top:30px;'>
			<div class="frame-form-basic">
			<h2>Detail</h2>
			<form   name="frm"  id="frmLiveAccount" method="POST" class="form-horizontal" role="form">
<?php $detail1=$detail['detail'];  
?>
		<table class='formBasic' border="0">
		<?=bsInput( lang('forex_firstname'),'firstname',$detail1['firstname'], lang('forex_inputsuggestion'));?>
		<?=bsInput( lang('forex_lastname'),'lastname',$detail1['lastname'], lang('forex_inputsuggestion')  );?> 
		<?=bsInput( lang('forex_phone'),'phone',$detail1['phone'], lang('forex_inputsuggestion2')  );?>
			<?=bsInput( lang('forex_address'),'address',$detail1['address'], lang('forex_inputsuggestion2')  );?>
			<?=bsInput( lang('forex_state'),'state',$detail1['state'], lang('forex_inputsuggestion2')  );?>
			 
			<?=bsInput( lang('forex_city'),'city',$detail1['city'], lang('forex_inputsuggestion2')  );?>
			<?=bsInput( lang('forex_zipcode'),'zipcode', $detail1['zipcode'], lang('forex_inputsuggestion') );?>
			<?=bsInput( lang('forex_country'),'citizen', $detail1['citizen'], lang('forex_inputsuggestion'),1  );?>
			<?=bsButton('Update');?>
		</table>
		<input type='hidden' name='rand' value='<?=dbId('id',22222,3);?>' />
		</form>
			</div>
	</div>
</div>