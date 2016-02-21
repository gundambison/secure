<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/***
Register 
---
Deposit_value
Widthrawal_value
---
data 

***/
class Forex extends CI_Controller {
	public $param;	
	public function registerApi(){
		$tmp=$this->load->view('api/forexRegister_data',$this->param,true);
		$res=json_decode($tmp, true);
		print_r($res);
	}
	
	public function error404(){
		logCreate('error 404 link:'.site_url());
		redirect(base_url('member'));
	}
	
	public function deposit_value()	
	{
		$def=14000;
		$res=$this->forex->rateNow('deposit');
		if(isset($res['value'])){
			$def=$res['value'];
		}else{}
		echo $def;
		exit();
	}
	
	public function widtdrawal_value()	
	{
		$def=13000;
		$res=$this->forex->rateNow('widtdrawal');
		if(isset($res['value'])){
			$def=$res['value'];
		}else{}
		echo $def;
		exit();
	}
	
	public function register($raw='0')
	{
		$this->load->library('session');
		if($raw!='0'){
			$ar=explode("-",$raw);
			logCreate("agent ref:$raw id:{$ar[0]}","info");
			$num=trim($ar[0]);
			$this->session->set_flashdata('agent', $num);
			redirect(base_url('forex/register'),1);
			exit();
		}
		else{
			$num=$info=$this->session->flashdata('agent');
			$this->param['agent']=$num!=''?$num:'';
		}
		$this->param['title']='OPEN LIVE ACCOUNT'; 
		$this->param['content']=array(
			'modal',
			'form', 
		);
		$this->showView(); 
		
	}
	
	public function index()
	{
		$this->register();
		//redirect(base_url('forex/register'));
	}
	
	public function data()
	{
		$url=$this->config->item('api_url');
		$this->load->helper('api');
		$respon=array(		
			'html'=>print_r($_REQUEST,1), 
		);
		$type=$this->input->post('type','unknown'); 
		$message='unknown data type';
		if($type=='request'){
			$respon['title']='NEW LIVE ACCOUNT (CREATED)';
			$param['data']=$this->convertData();
			$stat=$this->forex->saveData($param['data'],$message);

			if($stat!==false){
				$respon['html']="Silakan Menunggu Konfirmasi dari Email anda";
				$ok=1;
				$url=$this->config->item('api_url');		
				$param['app_code']=$this->config->item('app_code')[0];
				$param['module']='forex';
				$param['task']='register';
//-------------------TESTED				
				$result=_runApi($url, $param); //test
			}
		}
		
		$open= $this->param['folder']."data/".$type."_data";
		if(is_file('views/'.$open.".php")){
			$param=array(
				'post'=>$this->convertData(),
				'get'=>$this->input->get(),
				'post0'=>$this->input->post()
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
		if(!isset($ok)){
			$this->errorMessage('266',$message);
		}
		
		$this->succesMessage($respon);
	}
	
	private function convertData()
	{
	$post=array();
		if( $this->input->post('data') ){
			foreach($this->input->post('data') as $data){
				$post[$data['name']]=$data['value'];
			}
		}
		return $post;
	}
	
	public function api()
	{		
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
	
	private function succesMessage($respon)
	{
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
	
	private function errorMessage($code, $message,$data=array())
	{
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
	 
	private function showView(){
		$name=$this->uri->segment(2,'');		
		if($name!=''){
			$jsScript=$this->param['folder'].$this->uri->segment(2).".js";
			$this->param['dataUrl']=  $this->uri->segment(1). "_".$name;
			$this->param['script']=$this->param['type']=$name;
			
			$this->param['openScript']=$jsScript;
 			
			if(isset($this->param['content'])&&!is_array($this->param['content'])){
				$this->param['load_view']= 
					$this->param['folder'].$this->param['content'].'_view';
				
			}else{}
 			
		}else{ 
			$controller=$this->uri->segment(1);
			if($controller=='')$controller='forex';
			redirect(base_url().$controller."/index","refresh");	
		}
		 
		$this->load->view('base_view', $this->param);
	
	}
	
	function __CONSTRUCT(){
	parent::__construct(); 
		
		date_default_timezone_set('Asia/Jakarta');
		$this->param['today']=date('Y-m-d');
		$this->param['folder']='forex/';
		$this->load->helper('form');
		$this->load->helper('formtable');
		$this->load->helper('language');
		$this->load->helper('api');
		$this->load->helper('db');
		$this->load->model('forex_model','forex');
		$this->load->model('account_model','account');
		$this->load->model('country_model','country');
		$defaultLang="english";
		$this->lang->load('forex', $defaultLang);
		$this->param['fileCss']=array(	
			'css/style.css',
			'contact-form-7-css'=>'css/salmaforex/style.css', 
			'rs-plugin-settings-css'=>'css/salmaforex/settings.css',
			'wpt-custom-login-css'=>'css/salmaforex/custom-login.css',
			'theme-bootstrap-css'	=>	'css/envision/bootstrap.css',					
			'theme-frontend-style-css'	=>	'css/envision/style.css?ver=384753e655020ba892b1123f6ddf06b2',
			'theme-frontend-extensions-css'	=>			'css/envision/extensions.css',
			'theme-bootstrap-responsive-css'	=>		'css/envision/bootstrap-responsive.css',
			'theme-bootstrap-responsive-1170-css'	=>	'css/envision/bootstrap-responsive-1170.css',
			'theme-frontend-responsive-css'	=>			'css/envision/responsive.css',
			'ttheme-fontawesome-css'	=>				'css/module.fontawesome/source/css/font-awesome.min.css',	
			'theme-icomoon-css'	=>			'css/module.fontawesome/source/css/font-awesome.min.css',
			'theme-skin'	=>				'css/Dark-Blue-Skin_cf846b6937291eb00e63741d95d1ce40.css',
			'css/cupertino/jquery-ui-1.10.3.custom.min.css',
		);
		$this->param['fileJs']=array(
			'js/jquery-1.11.3.js',
			'js/jquery-migrate.min.js',
			'js/rs-plugin/js/jquery.themepunch.tools.min.js',
			'js/rs-plugin/js/jquery.themepunch.revolution.min.js',
			
		);
		
		$this->param['shortlink']=base_url();
		$this->param['footerJS']=array(			
			'js/envision-2.0.9.4/lib/js/common.js',
			'js/envision-2.0.9.4/lib/js/modernizr-2.6.2-respond-1.1.0.min.js',
			'js/envision-2.0.9.4/lib/js/noconflict.js',
			'js/envision-2.0.9.4/cloudfw/js/webfont.js',
			'js/envision-2.0.9.4/lib/js/jquery.prettyPhoto.js',
			'js/envision-2.0.9.4/lib/js/extensions.js',
			'js/envision-2.0.9.4/lib/js/retina.js',
			'js/envision-2.0.9.4/lib/js/queryloader2.js',
			'js/envision-2.0.9.4/lib/js/waypoints.min.js',
			'js/envision-2.0.9.4/lib/js/waypoints-sticky.js',
			'js/envision-2.0.9.4/lib/js/jquery.viewport.mini.js',
			'js/envision-2.0.9.4/lib/js/jquery.flexslider.js',		
			'js/jquery-ui-1.9.2.min.js',			
			'js/bootstrap.js',
			 'js/forex.js',	
		);
 
		$this->param['description']="Trade now with the best and most transparent forex STP broker";
		 
		$this->param['emailAdmin']=$this->forex->emailAdmin; 
		 
		if($this->input->post())
			logCreate($this->input->post(),'post');
	}
	
}