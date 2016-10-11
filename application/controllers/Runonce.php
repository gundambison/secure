<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Runonce extends CI_Controller {
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