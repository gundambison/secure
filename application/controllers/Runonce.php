<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Runonce extends CI_Controller {
	function index(){
		$subject = '[SalmaForex] Testing Email ';
		$subject.= 'sends' ;

		$headers = "From: noreply@salmaforex.com\r\n";
		$headers .= "Reply-To: noreply@salmaforex.com\r\n"; 
		$headers .= "MIME-Version: 1.0\r\n";

		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$email='gundambison@gmail.com';
		
		batchEmail($email, $subject, $message, $headers);
		echo 'send to '.$email;
	}
	function user_check(){
		$res= _localApi('users','exist',array("gundambison@gmail.com"));
		echo_r($res);die("---");
	}
	function close(){
		if($this->input->post('message')){
			$data=array('message'=>$this->input->post('message'));
			$params['message']=$this->load->view('guest/email/emailclose_view',$data,true);
			$params['subject']=$this->input->post('subject');
			
			if($this->input->post('to')!='all'){
				$params['to']=$this->input->post('to_email');
				$this->sendEmail($params);
				echo $params['message'];
			}
			else{
				echo 'start';
				$to=$this->account->all_by_email('email');
				//print_r($to[33]); die( 'total:'.count($to) );
				echo ' GO ';
				foreach($to as $row){
					if(trim($row['email'])!=''){
						$emails =trim($row['email']);
						$params['to']=$emails;
						$this->sendEmail($params);
					}else{}
					
				}
				
				die('send to '.count($to).' email');
			}
		}
		else{
			$this->load->view('guest/close_view');
		}
	}

	function sendEmail($params){
		$this->forex->userDocumentRefill();
	$subject = $params['subject'];
 
	$headers = "From: noreply@salmaforex.com\r\n";
	$headers .= "Reply-To: noreply@salmaforex.com\r\n"; 
	$headers .= "MIME-Version: 1.0\r\n";

	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	
	$to=$params['to'];
	$message=$params['message'];

	if(defined('LOCAL')){	
		$rawEmail=array(
			$subject, $headers,$message,'send email'
		);
		$data=array( 
			'url'=>json_encode($to),
			'parameter'=>json_encode($rawEmail),
			'error'=>2
		);
		$this->db->insert($this->forex->tableAPI,$data);
		//die($message ); 
	}
	else{
		if(!is_array($to))$to=array($to);
		foreach($to as $email){
			batchEmail($email, $subject, $message, $headers);
		}
		$rawEmail=array(
			$subject, $headers,$message,'send email'
		);
		$data=array( 'url'=>json_encode($to),
			'parameter'=>json_encode($rawEmail),
			'error'=>2
		);
	//	$this->db->insert($this->forex->tableAPI,$data);

	}
	}

	function pings(){
		$this->forex->userDocumentRefill();

//=====database
		
		$param=array(
			array(
			'hostname' => 'mysql.idhostinger.com',
			'username' => 'u429780871_forex',
			'password' => '|V4CMBo6mj',
			'database' => 'u429780871_forex',
			),
			array(
			'hostname' => '31.220.56.227',
			'username' => 'mujur_salma',
			'password' => 'mujur!salma227',
			'database' => 'mujur_salma',
			)
		);
		foreach($param as $db){
			$result = array('start'=>date('Y-m-d H:i:s') );
			$mysqli = @new mysqli($db['hostname'], $db['username'], $db['password'], $db['database']);
			$result['end']= date('Y-m-d H:i:s');
			$url='mysqli: '.$db['hostname'];
/*
 * This is the "official" OO way to do it,
 * BUT $connect_error was broken until PHP 5.2.9 and 5.3.0.
 */
			if ($mysqli->connect_error) {
				$result['num_err']= $mysqli->connect_errno;
				$result['message']= $mysqli->connect_error;
			//	die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
				$this->forex->pingFailed($url, $result);
				echo "\n{$url} |". $mysqli->connect_error;
			}
			else{
			//	$result['message']='success';
				$this->forex->pingSuccess($url,$result);
				echo "\n{$url} | success";
			}

		}
				$param=array(
		//'http://lms.lkpp.sitex/',
		'http://salmaforex.com/',
		'http://sukses.salmaforex.com/',
		'http://serversaga.salmaforex.com/'
		);
		global $maxTime;
		$maxTime = 2;
		echo '<pre>';
		$post=array('from'=>current_url(),'maxTime'=>9);
		foreach($param as $url){
			$info=array( 'start'=>date('Y-m-d H:i:s') );
			$result = _runApi($url,$post);

			//echo '<pre>xxx'.print_r($result,1).'</pre>';die();
			if(isset($result->code)){
				$this->forex->pingFailed($url, $result);
				echo "\n fail:$url";
			}
			else{
				$info['end']=date('Y-m-d H:i:s');
				$info['size']=strlen($result);
				$this->forex->pingSuccess($url, $info);
				echo "\n success:$url";
			}
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
}

}