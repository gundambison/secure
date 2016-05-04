<?php 
//deposit_view.php
if (  function_exists('logFile')){ logFile('view/member/data','widtdrawalProcess_data.php','data'); };

$uDetail=$userlogin['detail'];
defined('BASEPATH') OR exit('No direct script access allowed');
if(!isset($uDetail['bank'])||$uDetail['bank']==''){
	$notAllow=1;
	$uDetail['bank']='';
}

if(!isset($uDetail['bank_norek'])||$uDetail['bank_norek']==''){
	$notAllow=1;
	$uDetail['bank_norek']='';
}

if(isset($notAllow)){
	redirect(site_url("member/edit/warning"),1);
}
 
$name=$userlogin['detail']['firstname']." ".$userlogin['detail']['lastname']; 
?>
<div class="container">
	<div class="row">
<?php 
	$load_view=isset($baseFolder)?$baseFolder.'inc/leftmenu_view':'leftmenu_view';
	$this->load->view($load_view);
	
	$rand_url=url_title("{$detail['accountid']}-{$detail['detail']['firstname']}","-");
	$urlAffiliation=base_url("register/{$rand_url}");
?>		
		<div class="main col-md-8">
			<!--form novalidate="novalidate" name="frm" id0="frm"   method="POST"  class="form-horizontal" role="form"-->
			<form   name="frm"  id="frmLiveAccount" method="POST"   role="form">
				<div class="frame-form-basic">
				<h2>Deposit</h2>
					  <div class="panel-body">
						<table class='table-striped table' border="0">
			<?php 
			$name=$userlogin['detail']['firstname']." ".$userlogin['detail']['lastname']; 
			$name1='<input type="hidden" name="accountid" value="'.$userlogin['accountid'].'" />
			<input type="hidden" name="name" value="'.$name.'" />
			<input type="hidden" name="username" value="'.$userlogin['username'].'" />';
			echo bsInput('Akun Salmaforex','akun', $userlogin['username'] ,'',true);
			echo bsInput('Name','name', $name.$name1 ,'',true);
			echo bsInput('Phone','phone', trim($uDetail['phone']) ,'Please Input Valid Phonenumber' );
			echo bsInput('Nama Bank','bank', trim($uDetail['bank']) ,'BCA, Mandiri, BNI, BII, etc' );
			echo bsInput('No Rekening','norek', trim($uDetail['bank_norek']) ,'999 999 999 9' );
			echo bsInput('Nama Pemilik Rekening','namerek', trim($name) ,'Please Input Valid Name' );

			echo bsInput('Jumlah Order ($)','orderDeposit', 10 ,'Minimal $10' );
			echo bsInput('Rate ($)','orderDeposit', 
			'<div id="input_rate">0</div>' ,'Minimal $10',true );
			echo bsInput('Jumlah Transfer (Rp)','order1', '' ,'Nominal Hanya Estimasi Saja' );

			?>             
						<tr><td colspan=3> 
						<button type="submit" class="btn btn-default submitLogin" >
						  Submit
						</button></td></tr>
						</table>
					  </div>
				  <div class='clear'></div> 
				</div>
				<div class='notice'>
							  <p><br />
						Please transfer in accordance with the amount of transfer listed above , the maximum transfer time 1x24 hours . If the transfer is not in that time period , then the system will automatically cancel the order.  Hopefully this information is useful .<br />
						<br />
						Our Bank information :</p>
					  <h3><strong>BCA : 8380126282 a.n Yadi Supriyadi <br />
						</strong><strong>BRI : 2202.01.000120.561 a.n Yadi Supriyadi</strong><br />
						<strong>BNI : 0423851338 a.n Yadi Supriyadi</strong></h3>
					  <p id="yui_3_16_0_1_1443010679159_2162">In case you have any questions, please <a rel="nofollow" target="_blank" href="https://www.salmaforex.com/contact/" id="yui_3_16_0_1_1443010679159_2161">contact us</a>, we will be happy to answer them.</p>
					  <p id="yui_3_16_0_1_1443010679159_2163">Wishing you luck and profitable trading! </p>
					  <p><strong>Thank you for choosing SalmaForex to provide you with brokerage services on the forex market! We wish you every success in your trading!</strong></p>
					  <p>Sincerely,<br />
					  Finance Departement</p>
				</div>
		
			</form>
		</div>
	</div>
</div>
<script>
urlDeposit = "<?=base_url("rupiah_deposit");?>";
</script>