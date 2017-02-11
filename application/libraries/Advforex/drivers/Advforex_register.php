<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Advforex_register extends CI_Driver {
private $urls,$privatekey;
public $CI;
function execute(){
//	if($row==false) return false;
	$CI =& get_instance();
//====================
		$CI->load->model('forex_model','forex');
		$CI->load->model('account_model','account');
		$CI->load->model('country_model','country');
		$defaultLang="english";
		$CI->lang->load('forex', $defaultLang);
//====================
	ob_start();
	$succes=false;
	$register= $CI->account->newAccountWithoutPassword(40,'where reg_status=1');
	foreach($register as $row){
		$post=array('username'=>$row['username']);
		$params2=array('post'=>$post);
		$CI->load->view('depan/data/login_data',$params2);
	} 

	$register=$CI->forex->regisAll(40,'where reg_status=1');
	logCreate("register:".json_encode($register));
	$data=array();

	foreach($register as $row){
		$reg_id=$row['id'];
		echo "\n<br/>start reg_id:{$reg_id}";
		$dt0=$CI->forex->regisDetail($row['id']);
		$full_name=isset($dt0['detail']['firstname'])?$dt0['detail']['firstname']:'';
		$full_name.=" ". (isset($dt0['detail']['lastname'])?$dt0['detail']['lastname']:'');
		$full_name=substr($full_name,0,126);
	//	print_r($dt0['']);
		if($dt0['status']!=1){
			logCreate("register id:".$row['id']."|status:".$dt0['status'],'info');
			echo "\n<br/>(failed) status reg_id:{$reg_id}. =".$dt0['status'];
			continue;
		}
		else{
			logCreate("register id:".$row['id']."|".json_encode($dt0));	
			echo "\n<br/>status reg_id:{$reg_id} =".$dt0['status'];
		}
		
		$email=trim($dt0['email']);
		
		//$account= $CI->forex->accountDetail($email,'email');
		
		if(trim($email)==''){//$account!==false||
			logCreate("register delete ($email) (empty):".print_r($account,1));
			$CI->forex->regisDelete($dt0['email']);
			echo "\n<br/>status reg_id:{$reg_id}| email:".$email;
			continue;
			
		}
		else{ 
			logCreate("register email:($email)");
			echo "\n<br/>register reg_id:{$reg_id}. email:".$email;
			if($email===NULL){
				$CI->forex->regisErase($reg_id,'reg_id',-3);
				echo "\n<br/>status reg_id:{$reg_id}. email:".$email;
				continue;
			}
		}
	//	die('email??:'.$email.print_r($account,1) );
		$arr=array( 'raw'=>$dt0);
		$dt=$dt0['detail'];
	//=================send
		$url=$this->urls['register'];//$CI->forex->forexUrl('register');
		
		$param=array( );
		$param['privatekey']	= $this->privatekey; //$CI->forex->forexKey();
	//======Required 
		$param['username']	=   $full_name; //$dt0['detail']['firstname'];
		if($dt['email']!=''){
				$param['email']		=substr($dt['email'],0,47);
		}
	//======Optional

		if($dt['address']!='')
			$param['address']	=$dt['address'];	
		if($dt['zipcode']!='')
			$param['zip_code']	=$dt['zipcode'];	
		if($dt['email']!='')
			$param['email']		=$dt['email'];
		if($dt['country']['name']!='')
			$param['country']	=$dt['country']['name'];
		if($dt['phone']!='')
			$param['phone']		=$dt['phone'];

		if($dt0['agent']!=''){
			$param['agentid']	=$dt0['agent'];	
		}

	//	$url.="?".http_build_query($param);
	//	$arr['param']=$param;
	//	$arr['url']=$url;
	//--------- PERINTAH PEMBUATAN	
	/*
		logCreate("param:".print_r($param,1));
		$rawAccount=$CI->account->detail($reg_id, 'reg_id');
		//apabila ada reg_id yang sama maka cancel	

			if($rawAccount!=false){
				logCreate("register not continue reg_id exist:".json_encode($rawAccount));
				continue;
			}
			else{
				$result0= _runApi($url );
			}
	*/
		echo "\n<br/>run register param total:".count($param);
		$res= $CI->advforex->runApi($url,$param);
		$result0=isset($res['response'])?$res['response']:false;
		//echo "<pre>".print_r($res,1)."</pre>";
		if( !isset($result0['ResponseCode'])){
			echo "<pre>".print_r($result0,1)."</pre>";
			continue;
		}
		if( isset($result0['ResponseCode'])&& $result0['ResponseCode']==0){
			echo "\nrespon=0 (OK)";
			$result=array(
				'accountid'=>isset($result0['AccountID'])?$result0['AccountID']:null,
				'masterpassword'=>isset($result0['MasterPassword'])?$result0['MasterPassword']:null,
				'investorpassword'=>isset($result0['InvestorPassword'])?$result0['InvestorPassword']:null,
				'responsecode'=>isset($result0['ResponseCode'])?$result0['ResponseCode']:-100,
				
			);

		}
		else{
			echo "\nrespon=?? (not OK)|".$result0['ResponseCode'];
			$result=$result0;
			if(!isset($result['ResponseCode'])){
				$result['responsecode']=-100;
			}
			else{
				$result['responsecode'] = $result['ResponseCode'];
			}

		}
//=========AGENT MASALAH??
		if(isset($result['responsecode'])&& ((int)$result['responsecode']==7||(int)$result['responsecode']==5||(int)$result['responsecode']==2) ){
			logCreate("agent bermasalah?:".print_r($result ,1));
			echo "\nagent bermasalah?:".$result['responsecode'];
			//=================send
		   		
		   $param=array( );
		   $param['privatekey']	=$this->privatekey	;
	//======Required 
		   $param['username']	=   $full_name;
		   if($dt['email']!=''){
				$param['email']		=substr($dt['email'],0,47);
		   }
	/*		   
	//======Optional	
		   if($dt['address']!='')
			$param['address']	=$dt['address'];	
		   if($dt['zipcode']!='')
			$param['zip_code']	=$dt['zipcode'];	
		   
		   if($dt['country']['name']!='')
			$param['country']	=$dt['country']['name'];
		   if($dt['phone']!='')
			$param['phone']		=$dt['phone']; 
	*/
		   $res= $CI->advforex->runApi($url,$param);
			$result0=isset($res['response'])?$res['response']:false;

			if(isset($result0['ResponseCode'])&& ((int)$result0['ResponseCode']==1||(int)$result0['ResponseCode']==9) ){
		   //isset($result0['status'])&&isset($result0['code'])&&$result0['status']==1&&$result0['code']==9){
				$result= $result0;
				logCreate("agent bermasalah V1 result:".print_r($result,1)); 
				echo "\nagent bermasalah(2)?:".$result['ResponseCode'];
		   }
		   else{
				$result=array(
				'accountid'=>isset($result0['AccountID'])?$result0['AccountID']:null,
				'masterpassword'=>isset($result0['MasterPassword'])?$result0['MasterPassword']:null,
				'investorpassword'=>isset($result0['InvestorPassword'])?$result0['InvestorPassword']:null,
				'responsecode'=>isset($result0['ResponseCode'])?$result0['ResponseCode']:-100,
				
				);
				echo "\nagent bermasalah(3)?:".print_r($result ,1);
				logCreate("agent bermasalah? agent bermasalah v2 result:".print_r($result ,1)); 

		   }
		   
		}
		else{}
	/*	
		if(isset($result['responsecode'])&&(int)$result['responsecode']==5){
			logCreate("delete Respon code 5");
			$CI->forex->regisDelete($dt0['email'],5); 
			continue;
		}
	*/	
		if(isset($result['responsecode'])&&(int)$result['responsecode']==8){
			logCreate("delete Respon code 8");
	//		$CI->forex->regisDelete($dt0['email'],8);
			echo "\n<br/>register bermasalah?:".$result['responsecode'];
			continue;
		}
		
		if(isset($result['responsecode'])&&(int)$result['responsecode']==0){
			logCreate('register member |url: '.$CI->forex->forexUrl().'|respon:'.print_r($result,1).' |url:'.$url, 
				'info');
			$param=array( );
			$param['privatekey']	=$this->privatekey;
			$param['accountid']=(int)$result['accountid'];
			$param['allowlogin']=1;
			$param['allowtrading']=1;
			
			$url=$this->urls['update'];
		//	$url.="?".http_build_query($param);
			logCreate("update allow:".print_r($param,1)."|url:$url");
			$arr['param']=$param;
			$arr['url']=$url;
			//$result0= _runApi($url );
			$res= $CI->advforex->runApi($url,$param);
			$result0=isset($res['response'])?$res['response']:false;
			logCreate("update allow result:".print_r($result0,1));
			
			$id=$CI->forex->accountActivation($row['id'],$result);
			$arr['accountActivation']=$id;
			echo "\n<br/>activasi :".json_encode($result0);
	 
		}
		else{ 
			$arr['accountActivation']=false;
			$num=isset($result['responsecode'])?$result['responsecode']:'unknown';
			if(lang('resApi_'.$num)=='')$num='unknown';
			logCreate('register member |num:'.$num.' |message:'.lang('resApi_'.$num),'error');
			logCreate('register member |url:'.$CI->forex->forexUrl().'|respon:'.print_r($result,1).'|url:'.$url, 
				'error');
			echo "\n<br/>activasi Bermasalah?:".json_encode($result);
			
		}
		echo "\nregister end (next)" ;
		$arr['result']=$result;	
		$data[]=$arr;
	}
		echo "\nregister end (DONE)" ;

	$succes=true;

	$content=ob_get_contents();
	ob_end_clean();

	$result=array(
		'body'=>$content, 
		'data'=>$data, 
	);

	//==========IF OK
	if($succes===true)
		$result['succes']=true;

	return $result;
}

	function example($row=false){
		if($row==false) return false;
		$CI =& get_instance();

	}

	function __CONSTRUCT(){
	$CI =& get_instance();
	$CI->load->helper('api');
	//$CI->config->load('forexConfig_new', TRUE);
    $this->urls = $urls=$CI->config->item('apiForex_url' );
    $this->privatekey = $CI->config->item('privatekey' );

	}
}