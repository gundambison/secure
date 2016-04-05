<div class='menu-container'>
<!--new menu-->
<div class="arrowsidemenu">

<div><a href="<?=base_url("member");?>" title="Home" class="alone">Home</a></div>
<div class="menuheaders"><a href="#" title="DETAIL">Profile</a></div>
<ul class="menucontents">
	<li><a href="<?=base_url("member/profile");?>" 
				block="0" lightbox="0" title="Detail" font="" color="29a4dd"><img class="ui--icon" src="<?=base_url();?>assets/img/open-account.png" alt="" data-at2x="size:14px" data-retina-auto="1" style="margin-right: 5px;" />Detail</a></li>
	<li><a href="<?=base_url("member/edit");?>"><img class="ui--icon" src="<?=base_url();?>assets/img/open-account.png" alt="" data-at2x="size:14px" data-retina-auto="1" style="margin-right: 5px;" />Edit Detail</a></li>
	<li><a href="<?=base_url("member/editpassword");?>"><img class="ui--icon" src="<?=base_url();?>assets/img/open-account.png" alt="" data-at2x="size:14px" data-retina-auto="1" style="margin-right: 5px;" />Edit Password</a></li>
</ul>

<?php 
if(isset($detail)&&$detail['type']=='admin'){?>
<div class="menuheaders"><a href="#" title="ADM">Admin Tools</a></div>
<ul class="menucontents">
	<li><a href="<?=!isset($detail['id'])?base_url("member/logout"):base_url("member/listApi");?>" block="0" lightbox="0" title="Live Account" font="" color="29a4dd"><img class="ui--icon" src="<?=base_url();?>assets/img/open-account.png" alt="" data-at2x="size:14px" data-retina-auto="1" style="margin-right: 5px;"><?php 
							echo isset($detail['id'])?'API':'unknown';?>
				</a></li>
	<li><a href="<?=!isset($detail['id'])?base_url("member/logout"):base_url("member/listApi/deposit");?>" block="0" lightbox="0" title="Live Account" font="" color="29a4dd"><img class="ui--icon" src="<?=base_url();?>assets/img/open-account.png" alt="" data-at2x="size:14px" data-retina-auto="1" style="margin-right: 5px;"><?php 
							echo isset($detail['id'])?'DAFTAR DEPOSIT':'unknown';?>
				</a></li>
	<li><a href="<?=!isset($detail['id'])?base_url("member/logout"):base_url("member/listApi/widtdrawal");?>" block="0" lightbox="0" title="Live Account" font="" color="29a4dd"><img class="ui--icon" src="<?=base_url();?>assets/img/open-account.png" alt="" data-at2x="size:14px" data-retina-auto="1" style="margin-right: 5px;"><?php 
							echo isset($detail['id'])?'DAFTAR WIDTDRAWAL':'unknown';?>
				</a></li>
	<li><a href="<?=!isset($detail['id'])?base_url("member/logout"):base_url("member/tarif");?>" block="0" lightbox="0" title="Live Account" font="" color="29a4dd"><img class="ui--icon" src="<?=base_url();?>assets/img/partners.png" alt="" data-at2x="size:14px" data-retina-auto="1" style="margin-right: 5px;"><?php 
							echo isset($detail['id'])?'Tarif':'unknown';?>
				</a>
	<li><a href="<?=!isset($detail['id'])?base_url("member/logout"):base_url("member/listApi/user");?>"><img class="ui--icon" src="<?=base_url();?>assets/img/contact.png" alt="" data-at2x="size:14px" data-retina-auto="1" style="margin-right: 5px;">
		List User
	</a></li>
	</li>
</ul>
<?php 
}else{}
?>

<div class="menuheaders"><a href="#" title="TRX">TRANSAKSI</a></div>
<ul class="menucontents">
	<li><a href="<?=base_url("deposit-form ");?>"><img class="ui--icon" src="<?=base_url();?>assets/img/partners.png" alt="" data-at2x="size:14px" data-retina-auto="1" style="margin-right: 5px;">Form Deposit</a></li>
	<li><a href="<?=base_url("widtdrawal-form");?>"><img class="ui--icon" src="<?=base_url();?>assets/img/partners.png" alt="" data-at2x="size:14px" data-retina-auto="1" style="margin-right: 5px;">Form Widthdrawal</a></li>
</ul>

<div><a href="<?=base_url("member/logout");?>" class="alone" title="LOGOUT">LOGOUT</a></div>
<!--	
<div class="menuheaders"><a href="" title="CSS">CSS Library</a></div>
<ul class="menucontents">
	<li><a href=""></a></li>
</ul>
-->
<!--
<div class="menuheaders"><a href="http://www.dynamicdrive.com/style/" title="CSS">CSS Library</a></div>
	<ul class="menucontents">
	<li><a href="http://www.dynamicdrive.com/style/csslibrary/category/C1/">Horizontal CSS Menus</a></li>
	<li><a href="http://www.dynamicdrive.com/style/csslibrary/category/C2/">Vertical CSS Menus</a></li>
	<li><a href="http://www.dynamicdrive.com/style/csslibrary/category/C4/">Image CSS</a></li>
	<li><a href="http://www.dynamicdrive.com/style/csslibrary/category/C6/">Form CSS</a></li>
	<li><a href="http://www.dynamicdrive.com/style/csslibrary/category/C5/">DIVs and containers</a></li>
	<li><a href="http://www.dynamicdrive.com/style/csslibrary/category/C7/">Links & Buttons</a></li>
	<li><a href="http://www.dynamicdrive.com/style/csslibrary/category/C8/">Other</a></li>
	<li><a href="http://www.dynamicdrive.com/style/csslibrary/all/">Browse All</a></li>
	</ul>
<div><a href="http://www.dynamicdrive.com/forums/" title="Forums">Forums</a></div>
<div class="menuheaders"><a href="http://www.javascriptkit.com" title="JavaScript">JavaScript</a></div>
	<ul class="menucontents">
	<li><a href="http://www.javascriptkit.com/jsref/index.shtml">JavaScript Reference</a></li>
	<li><a href="http://www.javascriptkit.com/cutpastejava.shtml">Free JavaScripts</a></li>
	</ul>
<div><a href="http://tools.dynamicdrive.com/" title="Tools">Webmaster Tools</a></div>
-->
</div>
<!--end menu
<ul class='myMenu'>
	<li><a href="<?=base_url("member/detail");?>" 
				block="0" lightbox="0" title="Detail" font="" color="29a4dd"><img 
				class="ui--icon" src="<?=base_url();?>assets/img/contact.png" 
				alt="" data-at2x="size:14px" data-retina-auto="1"
				style="margin-right: 5px;">Detail</a></li>
 
	<li><a href="<?=base_url("deposit-form ");?>" block="0" lightbox="0" title="Form Deposit" font="" color="29a4dd"><img class="ui--icon" src="<?=base_url();?>assets/img/partners.png" alt="" data-at2x="size:14px" data-retina-auto="1" style="margin-right: 5px;">Form Deposit</a></li>
	<li><a href="<?=base_url("widtdrawal-form");?>" block="0" lightbox="0" title="Form Widtdrawal" font="" color="29a4dd"><img class="ui--icon" src="<?=base_url();?>assets/img/contact.png" alt="" data-at2x="size:14px" data-retina-auto="1" style="margin-right: 5px;">Form Withdrawal</a></li>  
</ul>
-->
</div>