<?php
		$showAgentMenu0=isset($userlogin['type'])&&$userlogin['type']=='agent'?true:false;
		$showAgentMenu1=isset($userlogin['patner'])&&$userlogin['patner']!=0?true:false;
		$showAgentMenu=$showAgentMenu0||$showAgentMenu1?true:false;
		
?> <div class="panel panel-mainmenu no-overflow">
   <div class="panel-heading no-padding partition-blue"> <a class="panel-link-title" href="<?=base_url('member');?>#"><span class="fa fa-home"></span> <span class="text">Home</span></a> </div>
   <div class="panel-body no-padding">
     <div class="mainmenu drop-nav">
       <ul>
<?php if($showAgentMenu){?>	   
  <li> <a href="#"><span class="fa fa-user"></span><span class="text">Agent</span></a> <span class="toggle fa fa-chevron-down"></span>
    <ul>
      <li><a href="<?=base_url('member/listApi/partner');?>#"><span class="fa fa-triangle-right"></span> Partners</a></li>
      <li><a href="#"><span class="fa fa-triangle-right"></span> On progress</a></li>
    </ul>
  </li>
<?php }?>
  <li> <a href="#"><span class="fa fa-user"></span><span class="text">Profile</span></a> <span class="toggle fa fa-chevron-down"></span>
    <ul>
      <li><a href="<?=base_url('member/detail');?>#"><span class="fa fa-triangle-right"></span> Detail</a></li>
      <li><a href="<?=base_url('member/edit');?>#"><span class="fa fa-triangle-right"></span> Edit</a></li>
      <li><a href="<?=base_url('member/uploads');?>#"><span class="fa fa-triangle-right"></span> Upload Document</a></li>
      <li><a href="<?=base_url('member/editpassword');?>#"><span class="fa fa-triangle-right"></span> Edit Password</a></li>
    </ul>
  </li>
  <li> <a href="#"><i class="fa fa-server" aria-hidden="true"></i> <span class="text">Admin Tools</span></a> <span class="toggle fa fa-chevron-down"></span>
    <ul>
      <li><a href="<?=base_url('member/listApi/api');?>#"><span class="fa fa-triangle-right"></span>API</a></li>
      <li><a href="<?=!isset($detail['id'])?base_url("member/logout"):base_url("member/listApi/deposit");?>#"><span class="fa fa-triangle-right"></span>Deposit (On Repair)</a></li>
      <li><a href="<?=base_url('member/tarif');?>#"><span class="fa fa-triangle-right"></span>Tarif</a></li>
      <li><a href="<?=!isset($detail['id'])?base_url("member/logout"):base_url("member/listApi/widtdrawal");?>#"><span class="fa fa-triangle-right"></span>Widtdrawal (On Repair)</a></li>
    </ul>
  </li>
  <li> <a href="#"><i class="fa fa-shield" aria-hidden="true"></i> <span class="text">Admin User </span></a> <span class="toggle fa fa-chevron-down"></span>
    <ul>
      <li><a href="<?=base_url('member/listApi/approval');?>#"><span class="fa fa-triangle-right"></span>Approval (On Repair)</a></li>
      <li><a href="<?=base_url('member/listApi/user');?>#"><span class="fa fa-triangle-right"></span>Detail User (On Repair)</a></li>
      <li><a href="#"><span class="fa fa-triangle-right"></span> Other (On Progress)</a></li>
    </ul>
  </li>
  </ul>
     </div>
   </div>
   <div class="panel-footer partition-blue text-right"><a href="<?=base_url('member/logout');?>#" class="btn btn-transparent-white btn-xs">Logout <i class="fa fa-power-off" aria-hidden="true"></i> </a></div>
 </div>
