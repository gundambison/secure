<?php
$config['app_code']=array(
	'9912310',
);
 

$config['emailAdmin']=array('admin@dev.salmaforex.com');

if(defined('LOCAL')){
	$config['urlForex']=array( 
		'default'=>			'localhost/forex/fake',
		'activation'=>		'localhost/forex/fake/activation',
		'update'=>			'localhost/forex/fake/update',
		'register'=>		'localhost/forex/fake',
		'updateBalance'=>	'localhost/forex/fake/updateBalance'		
		
	);
	
	$config['api_url']='localhost/forex/api';
	$config['forexKey']='unknown';
}
else{ 
	$config['urlForex']=array( 
		'default'=>			'http://nfx.posismo.com/api/account/openAccount' ,
		'register'=>		'http://nfx.posismo.com/rest-api/salma/register',
		'update'=>			'http://nfx.posismo.com/rest-api/salma/update-account' ,
		'updateBalance'=>	'http://nfx.posismo.com/api/account/activeAccount'
	);
	
	$config['api_url']='http://secure.salmaforex.com/forex/api';
	$config['forexKey']='SalmaFX1234567*';
	
}

//if dev
if(defined('_DEV_')){
	$config['api_url']='http://dev.salmaforex.com/forex/api';
	$config['urlForex']['updateBalance']=
	  'http://secure.salmaforex.com/forex/fake/updateBalance';
}else{} 

$config['urlForex']['local']='localhost/forex/data';
