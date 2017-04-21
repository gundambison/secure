<?php
//$name=$userlogin['detail']['firstname']." ".$userlogin['detail']['lastname'];
$userlogin['firstname']=isset($userlogin['detail']['firstname'])?$userlogin['detail']['firstname']:'';
$userlogin['lastname']=isset($userlogin['detail']['lastname'])?$userlogin['detail']['lastname']:'';

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

             <div class="col-md-6 no-padding">
                <table class="table no-margin" id="">
                  <tbody>
                    <tr class="active">
                      <td>Account (utama)</td>
                      <td class="text-right">
					  <?=$userlogin['accountid'];?>
					  </td>
                    </tr>
                    <tr>
                      <td>Name:</td>
                      <td class="text-right">
						<?=isset($userlogin['firstname'])?$userlogin['firstname']:'';?>
						<?=isset($userlogin['lastname'])?$userlogin['lastname']:'';?>
					</td>
                    </tr>
                    <tr>
                      <td>Account Type</td>
                      <td class="text-right">
					  <?=isset($userlogin['accounttype'])?$userlogin['accounttype']:'MEMBER.';?>
					  </td>
                    </tr>
                    <tr class="active">
                      <td>Account Status</td>
                      <td class="text-right">Active</td>
                    </tr>
                    <tr >
                      <td>Phone Number</td>
                      <td class="text-right">
					  <?=isset($userlogin['detail']['phone'])?$userlogin['detail']['phone']:' ';?>
					  </td>
                    </tr>
                    <tr class="active">
                      <td colspan=2>Address</td>
                    </tr>
                    <tr>
                      <td colspan=2><?=isset($userlogin['detail']['address'])?nl2br($userlogin['detail']['address']):' ';?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="col-md-6 no-padding">
                <table class="table no-margin" id="">
                  <tbody>
                    <tr>
                      <td>Deposit:</td>
                      <td class="text-right">(on progress)</td>
                    </tr>
                    <tr class="active">
                      <td>Free Margin:</td>
                      <td class="text-right">(on progress)</td>
                    </tr>
                    <tr>
                      <td>Total Profit:</td>
                      <td class="text-right">(on progress)</td>
                    </tr>
                    <tr class="active">
                      <td>Total Open Transaction:</td>
                      <td class="text-right">(on progress)</td>
                    </tr>
                    <tr>
                      <td>Total Close Transaction:</td>
                      <td class="text-right">(on progress)</td>
                    </tr>
                    <tr class="active">
                      <td>Total Open Volume Transaction:</td>
                      <td class="text-right">(on progress)</td>
                    </tr>
                    <tr>
                      <td>Total Close Volume Transaction:</td>
                      <td class="text-right">(on progress)</td>
                    </tr>
                    <tr class="active">
                      <td>Balance</td>
                      <td class="text-right">(on progress)</td>
                    </tr>
                  </tbody>
                </table>
<?php if(defined('LOCAL')) echo '<pre>'.print_r($userlogin,1).'</pre>';?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
