<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

if(!defined('_DEV_')){	
	$route['default_controller'] = 'forex';
}
else{ 
	$route['default_controller'] = 'member/login';
}

$route['register/(:any)/(:any)'] = 'forex/register/$1/$1';
$route['register/(:any)'] = 'forex/register/$1';
//$route['login'] = 'login/member';
$route['welcome'] = 'guest/home';
$route['welcome/(:any)/(:any)'] = 'guest/home/$1/$1';
$route['welcome/(:any)'] = 'guest/home/$1';

$route['loginadmin'] = 'login/admin';
$route['forgot_password'] = 'member/forgot';
$route['deposit-form'] = 'member/deposit';
$route['widtdrawal-form'] = 'member/widtdrawal';
$route['withdraw-form'] = 'member/withdrawal';
$route['rupiah_deposit'] = 'forex/deposit_value';
$route['rupiah_widtdrawal'] = 'forex/widtdrawal_value';
$route['recover/(:any)'] = "member/recover/$1";
$route['send_email'] = "forex/email_send";
$route['404_override'] = 'forex/error404';
$route['translate_uri_dashes'] = FALSE;
