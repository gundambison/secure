<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Advforex_recover extends CI_Driver {
private $urls,$privatekey;
public $CI;
function execute($id){
	$CI =& get_instance();
	$detail=$CI->account->recoverId($id);
	$email = $detail['email'];
	$param=array();
	$users=$CI->account->get_by_field($email,'email');
		ob_start();
	$data['user']=$users=$CI->account->get_by_field($email,'email');

	foreach($users as $user){
		if(!isset($user['id'])){
				continue;
		}
		$detail = $CI->account->detail( $user['id']);

	//	echo ("<hr/>".print_r($user ));
	//	$CI->account->noPass($user['id']);

		$sql="select password from {$CI->forex->tablePassword} order by rand() limit 2";
		$quePass=dbFetch($sql);
		$invPass=$quePass[0]['password'];
		$masterPass=$quePass[1]['password'];
		
		$param=array( );
			
		$param['accountid']=$detail['accountid'];
		$param['masterpassword']=$masterPass.($detail['accountid']%100 )+34;
		$param['investorpassword']=$invPass.($detail['accountid'] %100 )+43 ;
		$input = array(
				'investorpassword' => md5( $param['investorpassword'] ),
				'masterpassword'=>md5( $param['masterpassword'] )
		);
		$where = "id=".(int)$detail['id'];
			 
			$param['privatekey']	=$CI->forex->forexKey();
			
			$url=$CI->forex->forexUrl('update');
			//$url.="?".http_build_query($param);
			$result0= _runApi($url,$param );/*update logic*/
		//==========SAVE============
			$dtAPI=array(
				'url'=>'recover ('.$detail['accountid'] .')',
				'param'=>json_encode($param),
				'response'=>json_encode($result0),
				'error'=>'-1'
			);
			$sql=$this->db->insert_string($CI->forex->tableAPI, $dtAPI);
                        dbQuery($sql);
                        //$CI->db->insert($CI->forex->tableAPI,$dtAPI);
			
			logCreate("update password result:".print_r($result0,1));
			$data['api'][]=array($url,$param,$result0);
			$sql = $CI->db->update_string($CI->forex->tableAccount, $input, $where);
			dbQuery($sql,1);
		
		
			$param[]=array(
				'type'=>'login',
				'data'=>array(
					array('name'=>'username', 'value'=>$detail['username'])
				),
				'recover'=>true
			);
			$param2=array( 
				'username'=>$detail['accountid'],
				'masterpassword'=>$param['masterpassword'],
				'investorpassword'=>$param['masterpassword'],
				'email'=>$detail['email']
			);
			$param2['emailAdmin']=$CI->forex->emailAdmin;
			
			$tmp=$CI->load->view('depan/email/emailAccount_view',$param2,true);
			$data['info']='Your password have been update. Please Check Your Email ('.$detail['email'].')';
			
	}
 




//-----------LAKUKAN POST KE SITE UTAMA
			$source=isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'-';
			$detail='click from :('.$source.')';

			$sql="update `{$CI->account->tableAccountRecover}` 
		set  detail='$detail' , `expired`='0000-00-00'
		where id='$id'";
	//		dbQuery($sql,1);
	return $data; 
}

function requesting($email=''){
	$CI =& get_instance();
//====================
		$CI->load->model('forex_model','forex');
		$CI->load->model('account_model','account');
		$CI->load->model('country_model','country');
		$defaultLang="english";
		$CI->lang->load('forex', $defaultLang);
//====================
	ob_start();
	$data=array();
	$data['user']=$users=$CI->account->get_by_field($email,'email');
//=======================
	$data['error']=false;
	$data['detail']=$detail=$CI->account->detail($email,'email');
		if($detail!==false){
			$params['recoverid']=$CI->account->recover($detail);
			$params['raw']=$detail;
			$params['post']=array('email'=>$email);
			$raw=$CI->load->view('depan/email/emailRecover_view',$params,true);
		}
		else{ 
			$data['error']="The Email Not Found in Our Database .  Please check your input.";
		}
		
	if($data['error']===false){
		$data['result']=array(
			'raw'=>$raw,
			'detail'=>$detail,
			'message'=>'You Will receive an e-mail with instruction about how to recover your password in few minutes.',
			'title'=>'Your Request has been sent Successfully',
			'status'=>true
		);
		
	}
	else{
		$data['result']=array(
			'message'=>$data['error'],
			'status'=>false,
			'title'=>'Warning',
		);
		if(isset($data['code'])){
			$data['result']['code']= $data['code'];
		}else{}
	}
//==============================
	logCreate("respon forgot_data:".json_encode($data));

	if(isset($data['result'])){ 
	//	echo json_encode($data['result'] );
	}else{
	//	echo json_encode(array());
	}
//========================



	$content=ob_get_contents();
	ob_end_clean();

	$result=array(
		'data'=>$data,
		'body'=>$content,
	);
	return $result;
}

	function __CONSTRUCT(){
		$CI =& get_instance();
		$CI->load->helper('api');
		//$CI->config->load('forexConfig_new', TRUE);
		$this->urls = $urls=$CI->config->item('apiForex_url' );
		$this->privatekey = $CI->config->item('privatekey' );

	}
}