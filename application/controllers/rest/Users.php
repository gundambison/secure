<?php 
require_once APPPATH.'/libraries/REST_Controller.php';
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
class Users extends REST_Controller {

    function __construct(){
	parent::__construct();
	$this->load->helper('api');
	$this->load->database();
	$this->load->model('users_model');
	$this->load->model('password_model');
	$this->load->model('forex_model');
	header('Access-Control-Allow-Origin: *'); 
    }

	function index_post(){
		$post=$param=$this->post();
		$function=isset($post['function'])?$post['function']:'fail';
		$res=array('message'=>'unknown', 'param'=>$post);
		logCreate('post '.json_encode($post));
		if(method_exists($this, $function)){
			logCreate('function (OK)'.$function);
			$data=isset($post['data'])?$post['data']:array();
			$res=$this->$function($data);
			if(isset($res['rest_code'])){
				$code=$res['rest_code'];
				unset($res['rest_code']);
				
			}
			else{
				$code=200;
			}
			$param['function']=$function;
			save_and_send_rest($code,$res,$param);
		}
		else{
			save_and_send_rest(204,$res,$param);
		}
	}
	
	function exist($param){
		$target=isset($param[0])?$param[0]:'';
		$fields=isset($param[1])?$param[1]:'u_email';

		$res=$this->users_model->exist($target,5,$fields);

		return $res;
	}
	
	function register($param){
		$res['users']=$this->users_model->register($param);
		$message='unknown';
		$res['register']=$this->forex_model->saveData($param, $message);
		$res['message']=$message;
		$email_data=array(
		'username'=>$param['email'],
		'email'=>$param['email'],
		
		'masterpassword'=>$res['users']['masterpassword'] 
		);
		$this->load->view('email/emailRegister_email',$email_data);
		$this->users_model->active_email($param['email']);
		return $res;
	}
	
	function login($params){
		$username=$params[0];
		$password=$params[1];
		$status=$this->users_model->checkLogin($username, $password);
		if($status===true){
			$respon=array('valid'=>true);
			$respon['password']= $this->users_model->gets($username)['u_password']; 
			$respon['param']=$params;
		}
		else{
			$respon=array('valid'=>false);
			$respon['password']=sha1("$password|zzzz")."|zzzz";
		}
		return $respon;
	}
	
	function loginCheck($params){
		$username=$params[0];
		$password=$params[1];
		$status=$this->users_model->loginCheck($username, $password);
		if($status==true){
			$respon=array('valid'=>true);
			$respon['password']= $this->users_model->gets($username)['u_password']; 
		}
		else{
			$respon=array('valid'=>false);
			$respon['password']=null;//sha1("$password|zzzz")."|zzzz";
		}
		$respon['status']=$status;
		return $respon;
	}
	
	function detail($params){
		$username=$params[0];
		$respon['users']= $users =$this->users_model->gets($username);
		$detail= $this->users_model->getDetail($username);
		foreach($detail as $name=>$val){
			$respon[$name]=$val;
		}
		$respon['users']=$users;
		//$respon['param']=$params;
		return $respon;
	}
}