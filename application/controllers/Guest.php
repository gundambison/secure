<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
class Guest extends MY_Controller {
/***
Daftar Fungsi Yang Tersedia :
*	home($raw=false,$agent=false)
*	register()
*	recover($id=0)
*	forgot()
*	__CONSTRUCT()
***/
	public function home($agent=false,$raw=false){
//public function home($raw=false,$agent=false){
		$this->load->library('session');
		$this->param['statAccount']='member';
		if($agent!=false){
			$this->param['fullregis']=true;
			$this->param['statAccount']='agent';
		}
		
		if($this->session->flashdata('register')){
			$this->param['register']=$this->session->flashdata('register');
			logCreate('session register valid','info');
		}
		
		if($raw!='0'){
			$ar=explode("-",$raw);
			logCreate("agent ref:$raw id:{$ar[0]}","info");
			$num=trim($ar[0]);
			$this->session->set_flashdata('agent', $num);
			logCreate('parameter agent:'.$num,'info');
			redirect(base_url('welcome'),1);
			exit();
		}
		else{
			$num=$info=$this->session->flashdata('agent');
			$this->param['agent']=$num!=''?$num:'';
		}
		$this->param['showAgent']=true;
		$this->param['title']='Open Live Account';//-- 
		if(!isset($this->param['formTitle'])) 
			$this->param['formTitle']=$this->param['title'];
		$this->param['content']=array(
			//'modal',
			'welcome', 
		);
		$this->showView('newbase_view');
	}

	public function agent(){
		$this->load->library('session');
		 
			$this->param['fullregis']=true;
			$this->param['statAccount']='agent';
		$this->param['agent']=false;
		$this->param['showAgent']=false;
		$this->param['showForm']=false;
		
		$this->param['title']='OPEN PATNER ACCOUNT'; 
		if(!isset($this->param['formTitle'])) 
			$this->param['formTitle']=$this->param['title'];
		$this->param['content']=array(
			'welcome', 
		);
		$this->showView();
	}

	public function register(){
		$post=$this->input->post();
		//print_r($post); 
		$stat=false;
		
		$respon['title']='NEW LIVE ACCOUNT (CREATED)';
			if($post['statusMember']=='AGENT'){
				$respon['title']='NEW PATNER ACCOUNT (CREATED)';
			}
		$params=$post;
		if( isset($post['accept']))$stat=true;
		logCreate('register post:'.print_r($post,1));
		if($stat==true)
			$stat=$this->forex->saveData($params,$message);
		
		if($stat==false){
			echo 'balik ke welcome';
			//print_r($_SERVER);
			$post['message']='Please Review Your Input';
			$this->session->set_flashdata('register', $post);
			logCreate('parameter invalid','error');
			redirect($_SERVER['HTTP_REFERER'],1);
		}
		else{
			echo 'menuju login';
			logCreate('parameter valid and success input into register table','success');
			$this->session->set_flashdata('notif', array('status' => true, 'message' => 'Sukses!'));
			redirect(site_url('login'),1);
		}
	}
	
	public function recover($id=0){
//	echo '<pre>'.$id;
		$this->param['title']='Recover your Live Account';
		$this->param['title']='Recover your Secure Account';
		$this->param['content']=array(
			'modal',
			'recover', 
		);
		$this->param['recoverId']=$id;
		$detail=$this->account->recoverId($id);
		$this->load->driver('advforex'); /*gunakan hanya bila diperlukan*/
                    $driver_core = 'advforex';
                    $driver_name='recover';
                    $func_name='execute';
					
		if($detail!=false){ 	
			$url=base_url("depan/data");
			//reset
//			print_r($detail);die();
			        //=================DRIVER
                    
                    if( !method_exists($this->{$driver_core}->{$driver_name},$func_name) ){
                            $output=array('function "'.$func_name.'" unable to declare');
                            die(json_encode($output));
                    }
                    else{
                            $row=$params=$id;
                            $params=$this->{$driver_core}->{$driver_name}->{$func_name}($row);
                           // echo '<pre>'; print_r($params);
						$respon = $params['respon'];
                    }
					
					
		//	exit();
			$this->param['raw']=$respon;
			//array('code'=>266,'message'=>'Please Check you email');
		}
		else{ 
			$this->param['raw']=array('invalid');
		}
		$params=$this->{$driver_core}->{$driver_name}->clean( );
		$this->param['footerJS'][]='js/login.js';
		$this->showView(); 
	}
	
	public function forgot(){
		$post=$this->input->post();
		if($post){
			echo 'proses melakukan forgot password';
			$forgot = array('status'=>false, 'message'=>'Email tidak ditemukan');
        //=================DRIVER
                    $this->load->driver('advforex'); /*gunakan hanya bila diperlukan*/
                    $driver_core = 'advforex';
                    $driver_name='recover';
                    $func_name='requesting';
                    if( !method_exists($this->{$driver_core}->{$driver_name},$func_name) ){
                            $output=array('function "'.$func_name.'" unable to declare');
                            die(json_encode($output));
                    }
                    else{
                            $row=$params=$post['email'];
                            $params=$this->{$driver_core}->{$driver_name}->{$func_name}($row);
                            echo '<pre>';
							//print_r($post);print_r($params);
							$respon = $params['data']['result'];
                    }
			//print_r($respon);die();
			if($respon['status']==1){
				$forgot = array('status'=>true, 'message'=>'Silakan periksa email anda. Terutama pada SPAM');
			}
			$this->session->set_flashdata('forgot', $forgot);
			redirect($_SERVER['HTTP_REFERER'],1);
			exit('');
            die('stop');
            
			$respon=$this->load->view('guest/data/forgot_data',array('post'=>$post),true);
			$json=@json_decode($respon,true);
			$respon=is_array($json)?$json:$respon;
//			die('<pre>'.print_r($respon,1));
/*
			$this->load->driver('advforex');
			$forgotPassword=$this->advforex->member->forgot()?false:true;
*/			

		}
		$this->param['title']='Recover your Live Account'; 
		$this->param['content']=array(
			'modal',
			'forgot', 
		);
		$this->param['footerJS'][]='js/login.js';
		$this->showView(); 
	}
	function __CONSTRUCT(){
	parent::__construct();
		$this->param['today']=date('Y-m-d');
		$this->param['folder']='guest/';
		$this->param['baseFolder']='guest/';
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
			'css/bootstrap.css',
		);
		$this->param['fileJs']=array(
			'js/jquery-1.7.min.js',
		);
		
		$this->param['shortlink']=base_url();
		$this->param['footerJS']=array(	 
			'js/bootstrap.min.js',
			'js/formValidation.min.js',
			'js/scripts.js'
		);
 
		$this->param['description']="Trade now with the best and most transparent forex STP broker";
		 
		$this->param['emailAdmin']=$this->forex->emailAdmin; 
		logCreate('Guest Controllers','start');
		logCreate(current_url(),'url');
/*		
		if($this->input->post())
			logCreate($this->input->post(),'post');
*/
	}
}