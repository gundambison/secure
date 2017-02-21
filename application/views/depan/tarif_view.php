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
	$rand_url=url_title("{$detail['accountid']}-{$detail['detail']['firstname']}","-");
	$urlAffiliation=base_url("register/{$rand_url}");
?>		
		<div class="main ">
			<form   name="frm"  id="frmLiveAccount" method="POST"   role="form">
		<div class="frame-form-basic">
		<h2>Ganti Harga / Rate</h2>
		  <div class="panel-body">
			<table class='table-striped table' border="0">
<?php 
$data =array('widtdrawal'=>'widtdrawal', 'deposit'=>'deposit');
echo bsSelect("Tipe", "types", $data);?>			
<?=bsInput('Rate ','rate', $rate['mean'],'' );?>
<tr><td colspan=3> 
            <button type="submit" class="btn btn-default submitLogin" >
              Submit
            </button></td></tr>
			</table>
			<div> Deposit : <?=number_format($rate['deposit']);?></div>
			<div> Widtdrawal : <?=number_format($rate['widtdrawal']);?></div>
		</div></div>
	</form> 
	<table id="tblTarif" class="display" cellspacing="0" width="100%">
			<thead>
				<tr>
					 <th>Created</th> 
					<th>Type</th>
					<th>Price (Rp)</th>
				   
				</tr>
			</thead>
			<tfooter>
				<tr>
					 <th>Created</th>  
					<th>Type</th>
					<th>Price (Rp)</th>
				   
				</tr>
			</tfooter>
	</table>	

<script>
urlAPI="<?=base_url("member/data?type=tarif");?>";
urlDetail="<?=base_url("member/data");?>";
</script>	
</div>
</div>
</div>
</div>
</div>
</div></div>