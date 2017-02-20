<?php 
require_once APPPATH.'/libraries/REST_Controller.php';
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
class Account extends REST_Controller {
    function __construct(){
	parent::__construct();
	$this->load->helper('api');
	$this->load->database();
	$this->load->model('account_model');
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
	
	function lists($params){
	$email=$params[0];
		$res=$this->account_model->get_by_field($email,'email');
	//	return $res;
		$account=array();
		foreach($res as $row){
			if(isset($row['id']))
				$account[]= $this->account_model->gets($row['id']);//,'id',true);
		}
		//$account['raw']=$res;
		return $account;
	}
	
}