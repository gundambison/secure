<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Guest extends MY_Controller {
/***
Daftar Fungsi Yang Tersedia :
*	home($raw=false,$agent=false)
*	register()
*	__CONSTRUCT()
***/	
	public function home($raw=false,$agent=false){
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
		$this->param['title']='OPEN LIVE ACCOUNT'; 
		if(!isset($this->param['formTitle'])) 
			$this->param['formTitle']=$this->param['title'];
		$this->param['content']=array(
			//'modal',
			'welcome', 
		);
		$this->showView('newbase_view');
	}
	
	
	public function register(){
		$post=$this->input->post();
		print_r($post); 
		$stat=false;
		
		$respon['title']='NEW LIVE ACCOUNT (CREATED)';
			if($post['statusMember']=='AGENT'){
				$respon['title']='NEW PATNER ACCOUNT (CREATED)';
			}
		$params=$post;
		logCreate(print_r($post,1));
		$stat=$this->forex->saveData($params,$message);
		
		//var_dump($stat);die('--');
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
			$this->session->set_flashdata('notif', array('status' => true, 'msg' => 'Sukses!'));
			redirect(site_url('login'),1);
		}
	}
	
	function __CONSTRUCT(){
	parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
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
		
		if($this->input->post())
			logCreate($this->input->post(),'post');
	}
}