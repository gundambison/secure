<?php
$config['app_code']=array(
	'9912310',
);


if(defined('LOCAL')){
	$config['urlForex']=array( 
		'default'=>'localhost/forex/fake',
		'activation'=>'localhost/forex/fake/activation'
		
	);
	$config['api_url']='localhost/forex/api';
	$config['forexKey']='unknown';
}
else{ 
	$config['urlForex']=array( 
		'default'=>'http://nfx.posismo.com/api/account/openAccount' ,
		'activation'=>'http://nfx.posismo.com/api/account/activeAccount'
	);
	$config['api_url']='http://dev.salmaforex.com/forex/api';
	$config['forexKey']='SalmaFX1234567*';
}