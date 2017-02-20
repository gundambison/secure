<?php
//account_balance_view
?>
            <ul class="list-group text-dark panel-shadow">
              <li class="list-group-item active partition-blue"> <span class="text-bold">SalmaForex Ballance</span> </li>
              <li class="list-group-item "> <span class="badge "><?=$userlogin['accountid'];?></span> <i class="fa fa-user-md" aria-hidden="true"></i>&nbsp; <span class="text-bold">Account</span> </li>
              <li class="list-group-item"> <span class="badge ">IDR 
			  <?=number_format($userlogin['balance'],2);?></span> <i class="fa fa-money" aria-hidden="true"></i>&nbsp; <span class="text-bold">Balance</span> </li>
            </ul>