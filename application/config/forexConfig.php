<?php
$config['app_code']=array(
	'9912310',
);
 

$config['emailAdmin']=array('admin@dev.salmaforex.com','admin@secure.salmaforex.com');

if(defined('LOCAL')){
	$config['urlForex']=array( 
		'default'=>			'http://advance.forex/forex/fake',
		'activation'=>		'http://advance.forex/forex/fake/activation',
		'update'=>			'http://advance.forex/forex/fake/update',
		'register'=>		'http://advance.forex/forex/fake',
		'updateBalance'=>	'http://advance.forex/forex/fake/updateBalance'		
		
	);
	
	$config['api_url']='http://advance.forex/forex/api';
	$config['forexKey']='unknown99';
}
else{ 
/* null */
}

//if dev
if(defined('_DEV_')){
/*
null
*/
}else{} 
