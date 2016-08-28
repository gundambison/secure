<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends MY_Controller {
	public $param;
	public $folderUpload;
/***
Daftar Fungsi Yang Tersedia :
*	loginProcess()
*	uploads($warn=0)
*	edit($warn=0)
*	editPassword()
*	forgot()
*	recover($id=0)
*	deposit($status='none')
*	widtdrawal($status=null)
*	withdrawal($status=null)
*	updateDocument($status=null, $userid=null)
*	show_upload($userid=null)
*	login()
*	logout()
*	detail()
*	profile()
*	index()
*	listApi($type=null)
*	tarif()
*	checkLogin()
*	send_email($status='',$id='')
*	__CONSTRUCT()
***/	
	public function loginProcess(){
		$login=$this->session->userdata('login');
		$param=array( 'post'=>$login );
		$raw=$this->load->view('depan/data/login_data',$param,true);
		$response=json_decode($raw);
		if($response->status===false){
			$post['message']=$response->message;
			$this->session->set_flashdata('login', $post);
			redirect(base_url('login/member'),1);
		}
		redirect(base_url('member'),1);
	}

	public function uploads($warn=0){
		$this->checkLogin();
		if($this->input->post('rand')){
			$rand=dbId();
			//print_r($_POST);print_r($_FILES);
			$files=$_FILES['doc'];
			//var_dump($files);die();
			if($files['size']>550000){
				$post['message']="upload to big";
				$this->session->set_flashdata('login', $post);
				redirect(site_url('member/uploads/'.$rand));exit();
			}
			$user=$this->param['detail'];
			$filename=url_title($user['email']).".".date("ymd").".tmp";
			@copy($files['tmp_name'],$this->folderUpload.$filename);
			$url=  $this->folderUpload.$filename  ;
			$this->account->updateDocument($user['username'], $url,$files['type']);
			//exit('file:'.$url);
			redirect(site_url('member/profile'));
		}
		$this->param['title']='OPEN LIVE ACCOUNT'; 
		$this->param['content']=array(
				'detailUpload', 
		);
		$this->param['footerJS'][]='js/login.js';
		$this->param['warning']=$warn;
		$this->showView();
	}

	public function edit($warn=0){
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
 
			$ar=$this->load->view('depan/data/updateDetail_data',$param,true);
			$result=json_decode($ar,1); 
			
			if(isset($result['status'])&&(int)$result['status']==1){
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
			$this->param['warning']=$warn;
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
			$result=$this->load->view('depan/data/updatePassword_data',$param,true);
 
//-----------EMAIL
			$param2=array( 
				'username'=>	$this->param['detail']['username'],
				'masterpassword'=>		$data['trading'],
				'investorpassword'=>	$data['investor'],
				'email'=>		$this->param['detail']['email']
			);
			$param2['emailAdmin']=array();//$this->forex->emailAdmin;
			
			$this->load->view('depan/email/emailPasswordChange_view',$param2);
			
			
		}else{ 
			echo 'not valid';redirect(base_url("depan/editPassword"));
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
		redirect('guest/forgot');

		$this->param['title']='Recover your Live Account'; 
		$this->param['content']=array(
			'modal',
			'forgot', 
		);
		$this->param['footerJS'][]='js/login.js';
		$this->showView(); 
	}
	
	public function recover($id=0){
		redirect('guest/recover/'.$id);
		$this->param['title']='Recover your Live Account'; 
		$this->param['content']=array(
			'modal',
			'recover', 
		);
		$this->param['recoverId']=$id;
		$detail=$this->account->recoverId($id);
		
		if($detail!=false){ 	
			$url=base_url("depan/data");
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
			$tmp=$this->load->view('depan/data/login_data',$params,true);
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
	public function history($status='none'){	
		$this->checkLogin();
		$this->param['content']=array();
		$this->param['title']='OPEN LIVE ACCOUNT'; 
		$this->param['content'][]='history' ;
		$this->param['content'][]='modal' ;
		$this->param['footerJS'][]='js/login.js';
		$this->param['footerJS'][]='js/jquery.dataTables.min.js';
		$this->param['footerJS'][]='js/api.js';
		$this->param['fileCss']['dataTable']='css/jquery.dataTables.min.css';
		$this->showView();  
	}

	public function deposit($status='none'){	
		$this->checkLogin();
		$this->param['content']=array();
		if($status=='done'){
			$info=$this->session->flashdata('info');
			if($info==1){
				$this->param['done']=1;//$this->param['content'][]='done' ;
			}
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
			$this->db->insert($this->forex->tableAPI,$data);
			
			$data=$post0;
			$data['userlogin']=$this->param['userlogin'];
			$data['rate']=$rate;
			$this->forex->flowInsert('deposit', $data); 
			$this->session->set_flashdata('info', '1');
			//kirim email 1
			$this->load->view('depan/email/emailDepositAdmin_view',$this->param);			
			//kirim email 2
			$this->load->view('depan/email/emailDepositMember_view',$this->param);
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

	public function widtdrawal($status=null){
		$this->withdrawal($status);//redirect(base_url('member/withdrawal/'.$status));
	}
	function withdrawal($status=null){
		$this->checkLogin();
		$this->param['title']='OPEN LIVE ACCOUNT';
		$this->param['content']=array();
		if($status=='done'){
			$info=$this->session->flashdata('info');
			if($info==1){
				//$this->param['content'][]='done' ;
				$this->param['done']=1;
			}
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
			$this->db->insert($this->forex->tableAPI,$data);
			
			$data=$post0;
			$data['userlogin']=$this->param['userlogin'];
			$data['rate']=$rate;
			$this->forex->flowInsert('widtdrawal', $data); 
			$this->session->set_flashdata('info', '1');
			//kirim email 1
			$this->load->view('depan/email/emailWidtdrawalAdmin_view',$this->param);			
			//kirim email 2
			$this->load->view('depan/email/emailWidtdrawalMember_view',$this->param);
			redirect(base_url('member/widtdrawal/done/'.rand(100,999) ),true);
			
			exit();
		}
		else{ 	
			$this->param['content'][]='widtdrawal';
			
		}
		
		$this->param['footerJS'][]='js/login.js';
		$this->showView(); 
		
	}
	
	function updateDocument($status=null, $userid=null){
		$stat_id=null;
		if($status=='active') $stat_id=1;
		if($status=='review') $stat_id=2;
		if($status=='inactive') $stat_id=0;
		
		if($stat_id!=null){
			$data=$this->account->detail($userid);
			$username=$data['username']; //die(print_r($data,1));
			$this->account->updateDocumentStatus($username, $stat_id);
			echo 'status sudah berganti menjadi '.$status;
		}
		else{
			echo 'status tidak diketahui';
			exit();
		}
	}
	
	function show_upload($userid=null){
		$data=$this->account->document($userid);
		//echo'<pre>';var_dump($data);die();
		header('content-type:'.$data['type']);
		header('Content-Disposition: attachment; filename="'.url_title($data['account']['email']).'"');

		$txt=file_get_contents( $data['upload']);
		echo $txt;
	}
	public function login(){
		redirect(base_url('forex'),1);
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
		$this->profile();
	}
	
	public function profile(){
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
		$this->param['content']=array( 'welcome');
		
		$this->param['footerJS'][]='js/login.js';
		$this->showView('newbase_view');
	}	

	public function listApi($type=null){
	$types=array('api','deposit','widtdrawal','user','agent','approval','partner','patner_revenue');	
/*		if(!defined('LOCAL')){
			$this->checkLogin();
		}
*/
		$this->param['title']='List API'; 
		$this->param['content']=array(
			'modal',			
		) ;
		
		if(in_array($type,$types)){
			$this->param['content']='api/'.$type;
		}
		else{ 
			$this->param['content']='api/api';
			redirect('member');
		}
//datatables		
		$this->param['footerJS'][]='js/jquery.dataTables.min.js';
		$this->param['footerJS'][]='js/api.js';
		$this->param['fileCss']['dataTable']='css/jquery.dataTables.min.css';
		$this->showView(); 
	}
	
	public function tarif(){		
		$this->checkLogin();
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
		else{}
		$post=array();
		if(isset($session['expire'])){
			if($session['expire']<strtotime("now")){
//				logCreate('User Expired '.$session['expire']." vs ". strtotime("now") );
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
//			logCreate('User don\'t have Expired' );
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
	
	function send_email($status='',$id=''){
		if($status!='send'){
			$url0=base_url('member/send_email/send/'.$id);
			echo "<h3 align='center'> Apakah email ini akan dikirim ulang? ".anchor($url0,'kirim email bila iya?')."</h3>";
		}
		$p=$this->forex->apiDetail($id);
		//print_r($p);
		$email=$p['url'];
		$detail=json_decode($p['parameter'],true);
		$subject=$detail[0];
		$message=$detail[2];
		$headers=$detail[1];
		//
		//$subject, $headers,$message,'send email'
		if($status!='send'){
			echo $message;
		}
		else{ 
			@mail($email, $subject, $message, $headers);
			echo "email sudah dikirim";
			$rawEmail=array(
				$subject, $headers,$message,'email ulang'
			);
			$data=array( 'url'=>json_encode($email),
				'parameter'=>json_encode($rawEmail),
				'error'=>2
			);
			$this->db->insert($this->forex->tableAPI,$data);
		}
		
	}
	
	function __CONSTRUCT(){
	parent::__construct(); 		
		date_default_timezone_set('Asia/Jakarta');
		$this->param['today']=date('Y-m-d');
		$this->param['folder']='depan/';
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
			'css/bootstrap.css',
			'css/ddaccordion.css'
		);
		$this->param['fileJs']=array(
			'js/jquery-1.7.min.js',
			'js/ddaccordion.js'
		);
		
		$this->param['shortlink']=base_url();
		$this->param['footerJS']=array(	 
			'js/bootstrap.min.js',
			'js/formValidation.min.js',
			'js/scripts.js'
		);
		$this->param['description']="Trade now with the best and most transparent forex STP broker";
		
		$this->param['emailAdmin']=$this->forex->emailAdmin;
		
		$this->param['session']=$this->session-> all_userdata(); 
		$this->param['baseFolder']='depan/';
		$this->param['noBG']=true;
		$this->folderUpload = 'media/uploads/';
		/*
		if($this->input->post())
			logCreate($this->input->post(),'post');
		*/
	}
	
}