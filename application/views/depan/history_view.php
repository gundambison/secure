<?php
//history_view.php
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
          <div class="panel-heading partition-blue"> <span class="text-bold"> Summary</span> </div>
          <div class="panel-body no-padding">
            <div class="row no-margin">
<?php 
	$load_view=isset($baseFolder)?$baseFolder.'inc/leftmenu_view':'leftmenu_view';
	//$this->load->view($load_view);
	
	$rand_url=url_title("{$detail['accountid']}-{$detail['detail']['firstname']}","-");
	$urlAffiliation=base_url("register/{$rand_url}");
//$user_id=2325;
$user_id=$userlogin['id'];
$data=$this->forex->flowMember($user_id);
if($data['count']==0){?>
<!--
<?php echo '<pre>'.print_r($_POST,1).'</pre>'; ?>
-->
			<div class="main col-md-8"> 
<h3>Tidak ada Catatan Kegiatan</h3>

			</div>
<?php
}
else{?>		
			<div class="main col-md-8">
<hr/>	
	<div id='preview'></div>
				<table id="history-table" class="display" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>Date</th>
								<th>ID</th>
								<th>Username</th>
								<th>Name</th>
								<th>Tipe</th>
								<th>Transaksi</th>
								<th>Rate</th>
								<th>Total</th>				
								<th>Status</th>
							</tr>
						</thead>
						<tfooter>
							<tr>
								<th>Date</th>
								<th>ID</th>
								<th>Username</th>
								<th>Name</th>
								<th>Tipe</th>
								<th>Transaksi</th>
								<th>Rate</th>
								<th>Total</th>				
								<th>Status</th>
							</tr>
						</tfooter>
				</table>
	</div>
<script>
urlAPI="<?=base_url("member/data?type=history");?>";
urlData="<?=base_url("member/data");?>";
</script>
<?php
}
?>
</div></div>


</div>
</div></div></div>
<?php
//echo '<pre>';print_r($data );echo '</pre>';