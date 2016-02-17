<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends MY_Controller {
	public $param;	
	
	public function edit(){
		$this->checkLogin();
		if($this->input->post('rand')){
			$param=array(
				'type'=>'updateDetail',
				'data'=>array(					 
				),
				'recover'=>true
			);
			$this->param['post']=$param['post']=$this->input->post();
			$param['username']= $this->param['detail']['username'];
			$param['post']['detail']= $this->param['detail']['detail'];
			
 
			$url=$this->forex->forexUrl('local');
 
			$param['data']=$this->convertData();
 
			$result=$this->load->view('member/data/updateDetail_data',$param,true);
			$ar=json_decode($result); 
			
			if(isset($result['status'])&&$result['status']==true){
				redirect(base_url('member/detail'));
			}
			else{ 
				redirect(base_url('member/edit'));
			}
		}
		else{ 
			$this->param['title']='OPEN LIVE ACCOUNT'; 
			$this->param['content']=array(
				'detailEdit', 
			);
			$this->param['footerJS'][]='js/login.js';
			$this->showView(); 
		}
		
	}
	
	public function editPassword(){
		$this->checkLogin();
		if($this->input->post('rand')){
			$post=$this->input->post();
			$data=array( 
				'investor'=>$post['investor1'],
				'trading'=>$post['trading1']
			); 
			
		if( $post['expire'] > date("Y-m-d H:i:s") && $post['expire'] < date("Y-m-d H:i:s",
		strtotime("+2 hour"))){
			$data['member']=$this->param['detail']; 
			$data['now']=date("Y-m-d H:i:s", strtotime("+2 hour"));
			
			$url=$this->forex->forexUrl('local'); 
			$param=array(
				'type'=>'updatePassword',
				'raw'=>$data,
				'recover'=>true,
				'post'=> $this->input->post() 
			);
			$param['member']= $this->param['detail'] ; 
			$result=$this->load->view('member/data/updatePassword_data',$param,true);
 
//-----------EMAIL
			$param2=array( 
				'username'=>	$this->param['detail']['username'],
				'masterpassword'=>		$data['trading'],
				'investorpassword'=>	$data['investor'],
				'email'=>		$this->param['detail']['email']
			);
			$param2['emailAdmin']=array();//$this->forex->emailAdmin;
			
			$this->load->view('member/email/emailPasswordChange_view',$param2);
			
			
		}else{ 
			echo 'not valid';redirect(base_url("member/editPassword"));
		}
			redirect(base_url('member/logout'));//echo '<pre>';print_r($data);die();
		}
		
		$this->param['title']='Edit Password'; 
		$this->param['content']=array(
			'passwordEdit', 'modal'
		);
		$this->param['footerJS'][]='js/login.js';
		$this->showView(); 
		
	}	
	
	public function forgot(){
		$this->param['title']='Recover your Live Account'; 
		$this->param['content']=array(
			'modal',
			'forgot', 
		);
		$this->param['footerJS'][]='js/login.js';
		$this->showView(); 
	}
	
	public function recover($id=0){
		$this->param['title']='Recover your Live Account'; 
		$this->param['content']=array(
			'modal',
			'recover', 
		);
		$this->param['recoverId']=$id;
		$detail=$this->account->recoverId($id);
		
		if($detail!=false){ 	
			$url=base_url("member/data");
			//reset 
			$this->account->noPass($detail['id']);
			$param=array(
				'type'=>'login',
				'data'=>array(
					array('name'=>'username', 'value'=>$detail['username'])
				),
				'recover'=>true
			);
			
//-----------LAKUKAN POST KE SITE UTAMA
			$params=array(
			  'post'=>array(
				'username'=>$detail['username']
			  )
			);
			$tmp=$this->load->view('member/data/login_data',$params,true);
			$respon=json_decode($tmp);
			$this->param['raw']=array(
			  'code'=>266,
			  'message'=>$respon->message
			);
			$detail='click from :('.$_SERVER['HTTP_REFERER'].')';
			$sql="update `{$this->account->tableAccountRecover}` 
		set  detail='$detail' , `expired`='0000-00-00'
		where id='$id'";
			dbQuery($sql,1);
		}
		else{ 
			$this->param['raw']=array('invalid');
		}
		$this->param['footerJS'][]='js/login.js';
		$this->showView(); 
	}

//==================	
	public function deposit($status='none'){	
		$this->checkLogin();
		$this->param['content']=array();
		if($status=='done'){
			$info=$this->session->flashdata('info');
			if($info==1)
				$this->param['content'][]='done' ;
		}
		
		if($this->input->post('orderDeposit')){
			$this->param['post0']=$post0=$this->input->post();
			$this->param['rate']=$rate=$this->forex->rateNow('deposit')['value'];
			$this->param['post0']['order1']=$rate * $post0['orderDeposit'];
			$data=array( 'url'=>'Deposit',
				'parameter'=>json_encode($post0),
				'error'=>2,
				'response'=>"rate:{$rate}\n".print_r($this->param['userlogin'],1)
			);
			$this->db->insert('mujur_api',$data);
			
			$data=$post0;
			$data['userlogin']=$this->param['userlogin'];
			$data['rate']=$rate;
			$this->forex->flowInsert('deposit', $data); 
			$this->session->set_flashdata('info', '1');
			//kirim email 1
			$this->load->view('member/email/emailDepositAdmin_view',$this->param);			
			//kirim email 2
			$this->load->view('member/email/emailDepositMember_view',$this->param);
			redirect(base_url('member/deposit/done/'.rand(100,999) ),true);
			exit();
		}
		else{ 
			$this->param['title']='OPEN LIVE ACCOUNT'; 
			$this->param['content'][]='deposit' ;
		}
		$this->param['footerJS'][]='js/login.js';
		$this->showView(); 
		
	}	

	public function widtdrawal($status='none'){
		$this->checkLogin();
		$this->param['title']='OPEN LIVE ACCOUNT';
		$this->param['content']=array();
		if($status=='done'){
			$info=$this->session->flashdata('info');
			if($info==1)
				$this->param['content'][]='done' ;
		}
		
		if($this->input->post('orderWidtdrawal')){
			$this->param['post0']=$post0=$this->input->post();
			$this->param['rate']=$rate=$this->forex->rateNow('widtdrawal')['value'];
			$this->param['post0']['order1']=$rate * $post0['orderWidtdrawal'];
			
			$data=array( 'url'=>'widtdrawal',
				'parameter'=>json_encode($post0),
				'error'=>2,
				'response'=>"rate:{$rate}\n".print_r($this->param['userlogin'],1)
			);
			$this->db->insert('mujur_api',$data);
			
			$data=$post0;
			$data['userlogin']=$this->param['userlogin'];
			$data['rate']=$rate;
			$this->forex->flowInsert('widtdrawal', $data); 
			$this->session->set_flashdata('info', '1');
			//kirim email 1
			$this->load->view('member/email/emailWidtdrawalAdmin_view',$this->param);			
			//kirim email 2
			$this->load->view('member/email/emailWidtdrawalMember_view',$this->param);
			redirect(base_url('member/widtdrawal/done/'.rand(100,999) ),true);
			
			exit();
		}
		else{ 	
			$this->param['content'][]='widtdrawal';
			
		}
		
		$this->param['footerJS'][]='js/login.js';
		$this->showView(); 
		
	}	
  
	public function login(){
		$this->param['title']='OPEN LIVE ACCOUNT'; 
		$this->param['content']=array(
			'modal',
			'login', 
		);
		$this->param['footerJS'][]='js/login.js';
		$this->showView(); 
		
	}

	public function logout(){
		$_SESSION['username']='';
		$_SESSION['password']='';
		redirect(base_url("login"));
	}
	 
	public function detail(){
		$this->checkLogin();
		$this->param['title']='OPEN LIVE ACCOUNT'; 
		$this->param['content']=array(
			'detail', 
		);
		$this->param['footerJS'][]='js/login.js';
		$this->showView(); 
		
	}	
	
	public function index(){
		$this->checkLogin();
		$this->param['title']='OPEN LIVE ACCOUNT'; 
		$this->param['content']=array(
			'info', 
		);
		$this->param['footerJS'][]='js/login.js';
		$this->showView(); 
		
	}	

	public function listApi($type='api'){
	$types=array('api','deposit','widtdrawal');	
		if(!defined('LOCAL')){
			$this->checkLogin();
		}
		$this->param['title']='List API'; 
		$this->param['content']=array(
			'modal',			
		) ;
		
		if(in_array($type,$types)){
			$this->param['content']='api/'.$type;
		}
		else{ 
			$this->param['content']='api/api';
		}
//datatables		
		$this->param['footerJS'][]='js/jquery.dataTables.min.js';
		$this->param['footerJS'][]='js/api.js';
		$this->param['fileCss']['dataTable']='css/jquery.dataTables.min.css';
		$this->showView(); 
	}
	
	public function tarif(){
		if(!defined('LOCAL')){
			$this->checkLogin();
		}
		if($this->input->post('rate')){
			$post= $this->input->post();
			$stat=$this->forex->rateUpdate($post);
			if($stat===false)die('error');
			redirect(base_url('member/tarif'));
			exit();
		}else{}
		$this->param['title']='Tarif'; 
		$this->param['content']=array(
			'modal',
			'tarif', 
		);
		$this->param['rate']=array(
			'mean'=>ceil( ($this->forex->rateNow('deposit')['value'] + $this->forex->rateNow('widtdrawal')['value']	)/2),
			'deposit'=>$this->forex->rateNow('deposit')['value'],
			'widtdrawal'=>$this->forex->rateNow('widtdrawal')['value']
		);
//datatables		
		$this->param['footerJS'][]='js/jquery.dataTables.min.js';
		$this->param['footerJS'][]='js/tarif.js';
		$this->param['fileCss']['dataTable']='css/jquery.dataTables.min.css';
		$this->showView(); 
	}
	
	
	private function checkLogin(){
		$session=$this->param['session'];
		$detail=$this->account->detail($session['username'],'username');
		if($detail==false){
			logCreate('no username','error');
			redirect("login");			
		}
		else{ 
			
		}		
		if($session['password']==$detail['masterpassword']){			
			$array=array( 
				'username'=>$session['username'],
				'password'=>($session['password'])
			);
			$this->session->set_userdata($array);
			$this->param['detail']=$this->param['userlogin']=$detail;
			$uniqid=url_title(trim($detail['id']).' '.$session['username'],'-');
			$this->param['urlAffiliation']=base_url('register/'.$uniqid);
		}
		else{
			logCreate('wrong password','error');
			redirect("login");			
		}
	}
	
	function __CONSTRUCT(){
	parent::__construct(); 
		
		date_default_timezone_set('Asia/Jakarta');
		$this->param['today']=date('Y-m-d');
		$this->param['folder']='member/';
		$this->load->helper('form');
		$this->load->helper('formtable');
		$this->load->helper('language');
		$this->load->helper('api');
		$this->load->helper('db');
		$this->load->model('forex_model','forex');
		$this->load->model('country_model','country');
		$this->load->model('account_model','account');
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
		
		$this->param['shortlink']=site_url();
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
		 
		$this->param['session']=$this->session-> all_userdata(); 
		if($this->input->post())
			logCreate($this->input->post(),'post');
	}
	
}