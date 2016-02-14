<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
if(!defined('_DEV_')){	
	$route['default_controller'] = 'forex';
}
else{ 
	$route['default_controller'] = 'member/login';
}
$route['login'] = 'member/login';
$route['forgot_password'] = 'member/forgot';
$route['deposit-form'] = 'member/deposit';
$route['widtdrawal-form'] = 'member/widtdrawal';
$route['withdrawal-form'] = 'member/widtdrawal';
$route['rupiah_deposit'] = 'forex/deposit_value';
$route['rupiah_widtdrawal'] = 'forex/widtdrawal_value';
$route['recover/(:any)'] = "member/recover/$1";
$route['404_override'] = 'forex/error404';
$route['translate_uri_dashes'] = FALSE;
