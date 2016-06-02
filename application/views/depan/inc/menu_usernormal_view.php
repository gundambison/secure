<?php ?>
<div class="glossymenu">
	<a class="menuitem" href="<?=base_url('member');?>"><span class="glyphicon glyphicon-home"></span> Home</a>
	<a class="menuitem submenuheader" href="#" ><span class="glyphicon glyphicon-retweet"></span> Transactions</a>
	<!--TRANSAKSI-->
	<div class="submenu">
		<ul>
			<li><a href="<?=base_url('deposit-form');?>"> <img class="ui--icon" src="<?=base_url();?>media/img/partners.png" alt="" data-at2x="size:14px" data-retina-auto="1" style="margin-right: 5px;">Deposit</a></li>
			<li><a href="<?=base_url('withdraw-form');?>"> <img class="ui--icon" src="<?=base_url();?>media/img/partners.png" alt="" data-at2x="size:14px" data-retina-auto="1" style="margin-right: 5px;">Withdrawal</a></li>
		</ul>
	</div>

	<a class="menuitem submenuheader" href="#" ><span class="glyphicon glyphicon-user"></span>  PROFILE</a>
	<div class="submenu">
		<ul>
			<li><a href="<?=base_url('member/detail');?>"> <img class="ui--icon" src="<?=base_url();?>media/img/open-account.png" alt="" data-at2x="size:14px" data-retina-auto="1" style="margin-right: 5px;" />Detail</a></li>
			<li><a href="<?=base_url('member/edit');?>"> <img class="ui--icon" src="<?=base_url();?>media/img/open-account.png" alt="" data-at2x="size:14px" data-retina-auto="1" style="margin-right: 5px;" />Edit Detail</a></li>
			<li><a href="<?=base_url('member/editpassword');?>"> <img class="ui--icon" src="<?=base_url();?>media/img/open-account.png" alt="" data-at2x="size:14px" data-retina-auto="1" style="margin-right: 5px;" />Edit Password</a></li>
		</ul>
	</div>
	
	<a class="menuitem" href="<?=base_url('member/logout');?>" ><span class="glyphicon glyphicon-log-out"></span> Logout</a>
</div>