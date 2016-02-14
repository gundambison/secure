<div style='' id='panelMenu'>
	<div class="panel panel-default">
	<!-- Keep all menus within masterdiv-->
	<div id="masterdiv">
		<div class="menutitle" onclick=""><a 
		href='<?=base_url('member');?>'>Home</a></div>
		
		<div class="menutitle" 
		onclick="SwitchMenu('sub1')">Detail</div>
		<span class="submenu" id="sub1">
			- <a href="<?=base_url('member/detail');?>">Detail</a><br>
			- <a href="<?=base_url('member/edit');?>">Edit Detail</a><br>
			- <a href="<?=base_url('member/editpassword');?>">Edit Password</a><br>
		</span>
	<?php 
	if(isset($detail)&&$detail['type']=='admin'){?>
		<div class="menutitle" onclick="SwitchMenu('sub2')">ADMIN</div>	
		<span class="submenu" id="sub2">
			- <a href="<?=base_url("member/listApi/normal");?>" >API</a><br>
			- <a href="<?=base_url("member/listApi/deposit");?>" >Deposit</a><br>
			- <a href="<?=base_url("member/listApi/widtdrawal");?>" >Widtdrawal</a><br>
		</span>
	<?php 
	}else {  }
	?>
		<div class="menutitle" onclick="SwitchMenu('sub3')">Form</div>
		<span class="submenu" id="sub3">
			- <a href="<?=base_url("deposit-form ");?>" >Deposit</a><br>
			- <a href="<?=base_url("widtdrawal-form");?>" >Widtdrawal</a><br>
		</span>
		
		<!--div class="menutitle" onclick="SwitchMenu('sub4')">Cool Links</div>
		<span class="submenu" id="sub4">
			- <a href="http://www.javascriptkit.com">JavaScript Kit</a><br>
			- <a href="http://www.freewarejava.com">Freewarejava</a><br>
			- <a href="http://www.cooltext.com">Cool Text</a><br>
			- <a href="http://www.google.com">Google.com</a>
		</span-->

		<div class="menutitle" onclick=""><a 
		href='<?=base_url("member/logout ");?>'>Logout</a></div>

	</div>
	</div>
	<!--div class="panel panel-default">
		<div class="panel-heading">
			<div class="panel-title">
				<strong style="color:#FFF;">Saldo FasaPay</strong>
			</div>
		</div>
		<ul class="list-group" style="text-align:right;">
				
			<li class="list-group-item"><span data-original-title="IDR" data-toggle="tooltip" title="">Rp0,00</span></li>        
				
			<li class="list-group-item"><span data-original-title="USD" data-toggle="tooltip" title="">US$0,00</span></li>        
				</ul>
	</div-->

</div>
