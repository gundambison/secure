<?php
ob_start();
	$responce=array('post'=>$post);
	$responce['error']=false;
 
$data= $post['detail'] ;
foreach($post as $name=>$value){
	if(isset($data[$name]))
		$data[$name]=$value;
}

$username=$post['username'];
unset($data['username']);
unset($data['rand']);
$responce['data']=json_encode($data);
	$sql="update {$this->account->tableAccountDetail} set detail='".
	addslashes(json_encode($data))."' where username like '$username'";
	dbQuery($sql);
$warning = ob_get_contents();
ob_end_clean();
if($warning!=''){
	$responce['warning']=$warning;     
}

if($responce['error']===false){
	$responce['result']=array(
		'message'=>'Klik to continue',
		'title'=>'Welcome',
		'status'=>true,
		
	);
	
}
else{
	$responce['result']=array(
		'message'=>$responce['error'],
		'status'=>false
	);
	if(isset($responce['code'])){
		$responce['result']['code']= $responce['code'];
	}else{}
}
 
 
//$responce['result']['raw']=$responce;
//logCreate($responce);
if(isset($responce['result'])){ 
	echo json_encode($responce['result']);
}else{
	echo json_encode(array());
}