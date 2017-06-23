<?php
$config['app_code']=array(
	'9912310',
);


$config['emailAdmin']=array('admin@dev.salmaforex.com','admin@secure.salmaforex.com');
$config['email_from']=array('name'=>'no reply','email'=>'noreply@salmaforex.com');
if(defined('LOCAL')){
/*	$config['urlForex']=array( 
		'default'=>			'http://advance.forex/forex/fake',
		'activation'=>		'http://advance.forex/forex/fake/activation',
		'update'=>			'http://advance.forex/forex/fake/update',
		'register'=>		'http://advance.forex/forex/fake',
		'updateBalance'=>	'http://advance.forex/forex/fake/updateBalance'		
		
	);
*/
	$default='http://54.64.85.13/api/';
	$config['urlForex']=array( 
		'default'=>			$default,
		'register'=>		$default.'register',
		'update'=>			$default.'update-account',
		'updateBalance'=>	$default.'update-balance',
		'getMargin'=>		$default.'get-margin',
	);

	$config['api_url']='http://advance.forex/forex/api';
	$config['forexKey']='Ap!Dem02017';
}
else{
	$default='http://54.64.85.13/api/';
	$config['urlForex']=array( 
		'default'=>			$default,
		'register'=>		$default.'register',
		'update'=>			$default.'update-account',
		'updateBalance'=>	$default.'update-balance',
		'getMargin'=>		$default.'get-margin',
	);
	
	$config['api_url']='http://secure.salmaforex.com/forex/api';
	$config['forexKey']='SalmaFX123!@#';
	
}

//if dev
if(defined('_DEV_')){
	$config['api_url']='http://dev.salmaforex.com/forex/api';
	$config['urlForex']['updateBalance']=
	  'http://dev.salmaforex.com/forex/fake/updateBalance';
}else{} 

$config['urlForex']['local']='http://advance.forex/index.php/forex/data';
/*
$config['forexBank']=array(
	array('name'=>'BCA21', 'number'=>'8380126282','person'=>'Yadi Supriyadi'),
	array('name'=>'BRI', 'number'=>'2202.01.000120.561','person'=>'Yadi Supriyadi'),
	array('name'=>'MANDIRI', 'number'=>'1300014675337','person'=>'Yadi Supriyadi'),
	array('name'=>'BNI', 'number'=>'0423851338','person'=>'Yadi Supriyadi'),

);
*/
$config['forexBank']=array(
	array('name'=>'BCA 3', 'number'=>'2812226160','person'=>'Bukan P.T. Salma Widyatama Mandiri'),
	array('name'=>'BRI 1', 'number'=>'10700.1000.1953.04','person'=>'Bukan P.T. Salma Widyatama Mandiri'),
	array('name'=>'MANDIRI 2', 'number'=>'13000.2323.1999','person'=>'Bukan P.T. Salma Widyatama Mandiri'),
	array('name'=>'BNI 1', 'number'=>'30.1212.3020','person'=>'Bukan P.T. Salma Widyatama Mandiri'),

);
/*
BCA : 2812226160 a.n PT. Salma Widyatama Mandiri 
BRI : 2202.01.000120.561 a.n Yadi Supriyadi
MANDIRI : 1300023231999 a.n PT. Salma Widyatama Mandiri
BNI : 3012123020 a.n PT. Salma Widyatama Mandiri
*/
$config['sendpulse_pubkey']='
-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDInV8khen8MIFHeqyoXH5ivWqA
sVqLU8tPtHcUawyPaL6QlD4MJjlxytRZIMMrpRQ/uPuR/c3o61STsBEuJ/zeqPvI
mH1yKT5XOjfcRtedWe0MEzJOmSOPaqX394yEV5p9vwE0IvOpaT6g27TPo0j9BHXP
eQcXNZVwGrNVyTrJSwIDAQAB
-----END PUBLIC KEY-----';
$config['smtp']=array(
'host'=>'smtp-pulse.com',
'port'=>465,
'username'=>'gundambison@gmail.com',
'password'=>'njstmAF65K'

);

/*===================ADVANCE FOREX================*/
	$default='http://54.64.85.13/api/';
	$urls=array(
	'default'=>$default,
		'register'=>$default.'register',
		'update'=>$default.'update-account',
		'updatebalance'=>$default.'update-balance',
		'updatecredit'=>$default.'update-credit',
		'get_account'=>$default.'get-account',
		'getMargin'=> $default.'get-margin',
	);
/*

	
http://54.64.85.13/api/register
http://54.64.85.13/api/update-account
http://54.64.85.13/api/update-balance
http://54.64.85.13/api/update-credit
http://54.64.85.13/api/get-account
*/	
	$config['privatekey']='Ap!Dem02017';
	$config['apiForex_url']=$urls;