<?php
$name=$userlogin['detail']['firstname']." ".$userlogin['detail']['lastname']; 
?>

  <div class="container">
    <div class="row">
	<?php
	$this->load->view('depan/inc/left_view');?>
      <div class="main col-md-9">
        <div class="row">
          <div class="col-md-4">
            <ul class="list-group text-dark panel-shadow">
              <li class="list-group-item active partition-blue"> <span class="text-bold">SalmaForex Ballance</span> </li>
              <li class="list-group-item "> <span class="badge ">1423677</span> <i class="fa fa-user-md" aria-hidden="true"></i>&nbsp; <span class="text-bold">Account</span> </li>
              <li class="list-group-item"> <span class="badge ">IDR 18.000.000</span> <i class="fa fa-money" aria-hidden="true"></i>&nbsp; <span class="text-bold">Balance</span> </li>
            </ul>
          </div>
          <div class="col-md-4 col-xs-6">
            <ul class="list-group text-dark panel-shadow">
              <a href="#" class="list-group-item active partition-blue"> Add Deposit <i class="fa fa-15x fa-arrow-circle-up pull-right"></i> </a>
              <li class="list-group-item "> <a href="#" class="block text-center"><img style="width: 89px;" src="images/deposit.png"></a> </li>
            </ul>
          </div>
          <div class="col-md-4 col-xs-6">
            <ul class="list-group text-dark panel-shadow">
              <a href="#" class="list-group-item active partition-blue"> Make Withdraw <i class="fa fa-15x fa-arrow-circle-down pull-right"></i> </a>
              <li class="list-group-item "> <a href="#" class="block text-center"><img style="width: 89px;" src="images/withdraw.png"></a> </li>
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
			<?php if(defined('LOCAL')) echo '<pre>'.print_r($userlogin,1).'</pre>';?>
              <div class="col-md-6 no-padding">
                <table class="table no-margin" id="">
                  <tbody>
                    <tr class="active">
                      <td >Account</td>
                      <td class="text-right">3453467</td>
                    </tr>
                    <tr>
                      <td >Account</td>
                      <td class="text-right">3453467</td>
                    </tr>
                    <tr class="active">
                      <td >Account</td>
                      <td class="text-right">3453467</td>
                    </tr>
                    <tr>
                      <td >Account</td>
                      <td class="text-right">3453467</td>
                    </tr>
                    <tr class="active">
                      <td >Account</td>
                      <td class="text-right">3453467</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="col-md-6 no-padding">
                <table class="table no-margin" id="">
                  <tbody>
                    <tr>
                      <td >Account</td>
                      <td class="text-right">3453467</td>
                    </tr>
                    <tr class="active">
                      <td >Account</td>
                      <td class="text-right">3453467</td>
                    </tr>
                    <tr>
                      <td >Account</td>
                      <td class="text-right">3453467</td>
                    </tr>
                    <tr class="active">
                      <td >Account</td>
                      <td class="text-right">3453467</td>
                    </tr>
                    <tr>
                      <td >Account</td>
                      <td class="text-right">3453467</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
