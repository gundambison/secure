<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
 class MY_Controller extends CI_Controller {
	function __CONSTRUCT(){
		parent::__construct(); 
		$this->load->library('session');
	}
//---------Tidak diketahui kegunaannya?	
	public function runApi(){
		$url=$this->config->item('api_url');		
		$param['app_code']='9912310';
		$param['module']='forex';
		$param['task']='register';
		$result=_runApi($url, $param);
 
	} 
	
	public function data(){
		$this->checkLogin();
	// die('check login');
		
		$url=$this->config->item('api_url');
		$this->load->helper('api');
		$this->param['session']=$this->session-> all_userdata();
		$session=$this->param['session'];
		$detail=$this->account->detail($session['username'],'username');
		if($detail==false){
			$detail=$this->account->detail($session['username'],'accountid');
			if($detail==false){
			logCreate('no username','error');
			redirect(site_url("login")."?err=no_user" );
			}
		}
		else{}
		$this->param['userlogin']=$detail;
		
		$respon=array(		
			'html'=>print_r($_REQUEST,1), 
		);

		$type=$this->input->post('type','unknown'); 
		if($type=='unknown'||$type=='')$type=$this->input->get('type','unknown');
		$message='unknown data type';
		$open= $this->param['folder']."data/".$type."_data";
		if(is_file('application/views/'.$open.".php")){
			$param=array(
				'post'=>$this->convertData(),
				'get'=>$this->input->get(),
				'post0'=>$this->input->post(),
				'userlogin'=>$this->param['userlogin']
			);
			$raw=$this->load->view($open, $param, true);
			$ar=json_decode($raw,true);

			if(is_array($ar)){
				$respon=$ar;				
				logCreate($respon);
				if(!isset($respon['status'])){ 
					echo json_encode($respon);exit(); 
				}
				if($respon['status']==true){
					$ok=1;
				}
				else{
					$message=$respon['message'];
				}
			}
			else{
				logCreate("unknown :".htmlentities($raw));
				$this->errorMessage('267',$raw,$message);
			}
		}
		else{
			logCreate("unknown :".$open);
		}
		
		if(!isset($ok)){
			$this->errorMessage('266',$message);
		}
		
		$this->succesMessage($respon);
	}
	
	protected function convertData(){
	$post=array();
		if(is_array($this->input->post('data'))){
			foreach($this->input->post('data') as $data){
				if(isset($data['name'])){
					$post[$data['name']]=$data['value'];
				}
			}
		}else{}
		return $post;
	}
	
	public function api(){		
		$module=$this->input->post('module');
		$task=$this->input->post('task');
		$appcode=$this->input->post('app_code');
		$aAppcode=$this->config->item('app_code');
		if(array_search($appcode, $aAppcode)!==false){
			$this->load->model('forex_model','modelku');
			$param=$this->input->post('data');
			$function= strtolower($module ).ucfirst(strtolower($task )); 
			$file='views/api/'.$function.'_data.php';
			if(is_file($file)){
				$res =$this->load->view('api/'.$function.'_data', $param,true);
				$respon=json_decode($res,1);
			}else{ 
				$this->errorMessage('277','unknown action');
			}
		}else{ 
			$this->errorMessage('276','unknown app code');
		}
		
		if(isset($respon['succes'])){	
			$this->succesMessage($respon);
		}else{ 
			$respon=array( 
				'raw'=>$res,
				'req'=>$_REQUEST
			);
			$this->errorMessage('334','unknown error',$respon );
		}
	}
	
	protected function succesMessage($respon){
		echo json_encode(
		  array(
			'status'=>true,
			'code'=>9, 
			'data'=>$respon,
			'message'=>'succes'
		  )
		);
		
		exit();	
	}
	
	protected function errorMessage($code, $message,$data=array()){
		$json=array(
			'status'=>false,
			'code'=>$code, 
			'message'=>$message 
		  );
		  
		if(count($data)!=0) 
			$json['data']=$data;
		
		echo json_encode($json);
		logCreate($json,"error");
		
		exit();
	}
	 
	protected function showView($target='newbase_view'){
		$name=$this->uri->segment(2,'');		
		if($name!=''){
			$jsScript=$this->param['folder'].$this->uri->segment(2).".js";
			$this->param['dataUrl']=  $this->uri->segment(1). "_".$name;
			$this->param['script']=$this->param['type']=$name; 
			
			if(isset($this->param['content'])&&!is_array($this->param['content'])){
				$this->param['load_view']= 
					$this->param['folder'].$this->param['content'].'_view';
				
			}else{}
			 
			
		}else{ 
			 
		}
		 
		$this->load->view($target, $this->param);
	
	}
	
	private function checkLogin(){
		$session=$this->param['session'];
		logCreate('controller:member |checkLogin |username:'.$session['username'] );
		$detail=$this->account->detail($session['username'],'username');
		logCreate('username found:'.count($detail) );
		if($detail==false){
			logCreate('session accountid:'.$session['username']);
			$detail=$this->account->detail($session['username'],'accountid');
		}
		
		if($detail==false){
			logCreate('no username/accid:'.$session['username'],'error');
			redirect("login");
		}
		else{}
		logCreate('username:'.$session['username'],'error');
		$post=array();
		if(isset($session['expire'])){
			if($session['expire']<strtotime("now")){
				logCreate('User Expired '.$session['expire']." vs ". strtotime("now") );
				$post['message']='Please Login Again';
				$this->session->set_flashdata('login', $post);
				$array=array( 
					'username'=>null,
					'password'=>null,
					'expire'=>strtotime("+12 minutes")
				);
				$this->session->set_userdata($array);
				
				redirect("login/member");
			}
			else{
				$session['expire']=strtotime("+10 minutes");
				logCreate('add User Expired '.$session['expire']  );
			}
		}
		else{
			logCreate('User don\'t have Expired' );
			$post['message']='Your Login Has expired?';
			$this->session->set_flashdata('login', $post);
			$array=array(  
					'expire'=>strtotime("+12 minutes")
				);
				$this->session->set_userdata($array);
			redirect(base_url("member"));
			$session['expire']=strtotime("+10 minutes");
		}
		
		if($session['password']==$detail['masterpassword']){
			logCreate('password OK:'.$session['username'],'error');
			$array=array( 
				'username'=>$session['username'],
				'password'=>($session['password']),
				'expire'=>$session['expire']
			);
			$this->session->set_userdata($array);
			$this->param['detail']=$this->param['userlogin']=$detail;
			$uniqid=url_title(trim($detail['id']).' '.$session['username'],'-');
			$this->param['urlAffiliation']=base_url('register/'.$uniqid);
		}
		else{
			logCreate('wrong password','error');
			$post['message']='Please Login Again';
			$this->session->set_flashdata('login', $post);
			redirect("login");			
		}
		
	}
	 
 }