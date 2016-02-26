<?php 
///detail 
$rand_url=url_title("{$detail['accountid']}-{$detail['detail']['firstname']}","-");
	$urlAffiliation=base_url("register/{$rand_url}");
?>
<div class='container'>
    <div style='margin-top:30px;'>
			<div class="frame-form-basic">
			<h2>Detail</h2>
<?php $detail1=$detail['detail']; 
 //echo '<pre>'.print_r($detail,1); 
?>
		<a href='<?=base_url('member/edit');?>'>
		<input type='button' value='Edit Detail' />
		</a>
		<a href='<?=base_url('member/editpassword');?>'>
		<input type='button' value='Edit Password' />
		</a>
		<table class='formBasic' border="0">
		<?=bsInput( lang('forex_firstname'),'firstname',$detail1['firstname'], lang('forex_inputsuggestion'), 1);?>
		<?=bsInput( lang('forex_lastname'),'lastname',$detail1['lastname'], lang('forex_inputsuggestion'),1 );?> 
			<?=bsInput( lang('forex_address'),'address',$detail1['address'], lang('forex_inputsuggestion2'),1 );?>
			<?=bsInput( lang('forex_phone'),'phone',$detail1['phone'], lang('forex_inputsuggestion2'),1 );?>
			<?=bsInput( lang('forex_state'),'state',$detail1['state'], lang('forex_inputsuggestion2'),1 );?>
			 
			<?=bsInput( lang('forex_city'),'city',$detail1['city'], lang('forex_inputsuggestion2'),1 );?>
			<?=bsInput( lang('forex_zipcode'),'zipcode', $detail1['zipcode'], lang('forex_inputsuggestion'),1 );?>
			<?=bsInput( lang('forex_country'),'citizen', $detail1['citizen'], lang('forex_inputsuggestion'),1 );?>
			
		</table>
<?php 
	if($detail['accounttype']!='MEMBER'){?>
		Link Affiliation:<br/>
		<?=anchor_popup($urlAffiliation,$urlAffiliation);
	}else{}	
		?>
			</div>
	</div>
</div>