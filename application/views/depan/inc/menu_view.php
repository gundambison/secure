<?php 
/*** menu ***/
?>
<div class="top-header">
	<div class="container">
    	<div class="row">
        	<div class="social col-md-6">
                <ul class="list-inline">
                    <li><a href="https://www.facebook.com/salmaforexbroker"><span class="glyphicon-social facebook"></span></a></li>
                    <li><a href="https://twitter.com/salmaforex"><span class="glyphicon-social twitter"></span></a></li>
                    <li><a href="https://instagram.com/salmaforex/"><span class="glyphicon-social instagram"></span></a></li>
                    <li><a href="http://www.salmaforex.com/contact/"><span class="glyphicon-social e-mail"></span></a></li> 
                </ul>
            </div>
            <div class="quicklinks col-md-6">	
                <ul class="list-inline text-right">
<?php 
	if(!isset($userlogin)){?>
                    <li><a href="<?=base_url('login');?>"><span class="glyphicon glyphicon-user"></span> <span class="small">Login</span></a></li>
<?php 
	}
	else{?>
					<li><a href="<?=base_url('member/logout');?>"><span class="glyphicon glyphicon-user"></span> <span class="small">Logout</span></a></li>
<?php 	
	}?>
                    <li><a href="<?=base_url('deposit-form');?>"><span class="glyphicon glyphicon-import"></span> <span class="small">Deposit</span></a></li>
                    <li><a href="<?=base_url('widtdrawal-form');?>"><span class="glyphicon glyphicon-export"></span> <span class="small">Withdrawal</span></a></li>
                </ul>
<script type="text/javascript" src="https://secure.skypeassets.com/i/scom/js/skype-uri.js"></script>
<div id="SkypeButton_Call_sfx.partnership_1">
 <script type="text/javascript">
 Skype.ui({
 "name": "dropdown",
 "element": "SkypeButton_Call_sfx.partnership_1",
 "participants": ["sfx.partnership"]
 });
 </script>
</div>
            </div>
        </div>
    </div>
</div>