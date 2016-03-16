<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
ob_start();
$succes=false;
 
$register=$this->forex->regisAll(40);
logCreate("register:".json_encode($register));
$data=array();
foreach($register as $row){
	$dt0=$this->forex->regisDetail($row['id']);
	if($dt0['status']!=1){
		logCreate("register id:".$row['id']."|status:".$dt0['status'],'info');
		continue;
	}
	else{
		logCreate("register id:".$row['id']."|".json_encode($dt0));	
	
	}
	
	$email=$dt0['email'];
	
	$account= $this->forex->accountDetail($email,'email');
	if($account!==false){
		$this->forex->regisDelete($dt0['email']);
		//die('--<pre>'.print_r($dt0,1).print_r($account,1));		
		continue;
	}
	$arr=array( 'raw'=>$dt0);
	$dt=$dt0['detail'];
//=================send
	$url=$this->forex->forexUrl('register');
	
	$param=array( );
	$param['privatekey']	=$this->forex->forexKey();
//======Required 
	$param['username']	=   $dt0['detail']['firstname'];	
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
	if($dt0['agent']!='')
		$param['agentid']	=$dt0['agent'];	
 
	$url.="?".http_build_query($param);
	$arr['param']=$param;
	$arr['url']=$url;
//--------- PERINTAH PEMBUATAN	
	logCreate("param:".print_r($param,1));
	$result0= _runApi($url );
	if(isset($result0['status'])&&isset($result0['code'])&&$result0['status']==1&&$result0['code']==9){
		$result=(array)$result0['data'];
	}
	else{
		$result=$result0;		
	}
	
	if(isset($result['responsecode'])&&(int)$result['responsecode']==0){
		logCreate('register member |url:'.$this->forex->forexUrl().'|respon:'.print_r($result,1)	.'|url:'.$url, 
			'info');
		$id=$this->forex->accountActivation($row['id'],$result);
		$arr['accountActivation']=$id; 
 
	}
	else{ 
		$arr['accountActivation']=false;
		$num=isset($result['responsecode'])?$result['responsecode']:'unknown';
		if(lang('resApi_'.$num)=='')$num='unknown';
		logCreate('register member |num:'.$num.' |message:'.lang('resApi_'.$num),'error');
		logCreate('register member |url:'.$this->forex->forexUrl().'|respon:'.print_r($result,1).'|url:'.$url, 
			'error');
		
	}
	
	$arr['result']=$result;	
	$data[]=$arr;
}


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

echo json_encode($result);