<?php
ob_start();
	$responce=array('post'=>$post);
	$responce['detail']=$detail=$this->forex->accountDetail($post['username'],'username');
	if($detail!==false){
		if(md5($post['password'])==$detail['masterpassword']){
			$responce['error']=false;
			$array=array( 
				'username'=>$post['username'],
				'password'=>md5($post['password'])
			);
			$this->session->set_userdata($array);
			
		}
		else{
			$responce['error']='Please Check Your Username and Password';			
		}
		unset($responce['detail']);
	}
	else{ 
		$responce['error']='Unknown account';
	}
$warning = ob_get_contents();
ob_end_clean();
if($warning!='')
	$responce['warning']=$warning;     

if($responce['error']===false){
	$responce['result']=array('message'=>'Klik to continue','title'=>'Welcome','status'=>true);
}
else{
	$responce['result']=array('message'=>$responce['error'],'status'=>false);
}


$responce['-']=$_SERVER;
logCreate($responce);
if(isset($responce['result'])){
	//$responce['body']=json_encode($responce['result']);	
	echo json_encode($responce['result']);
}else{
	echo json_encode(array());
}