<?php 
ob_start();
if ( function_exists('logFile')){ logFile('view/member/data','updatePassword_data.php','data'); };
//api_data
$respon=array( );

//$respon['data']=$post0; 
//$post=$post0['raw'];
//===========
$pass1=addslashes( $post['trading1'] );
$pass2=addslashes( $post['investor1'] );

$sql=sprintf("update `%s` set `investorpassword`= md5('%s'), `masterpassword`= md5('%s')
where username like '%s'",
$this->account->tableAccount, $pass2,$pass1, $member['username'] );
 dbQuery($sql,1);
$respon['ok']=true;
//$respon['sql']=$sql;
		//==========SAVE============
			$dtAPI=array(
				'url'=>'change password ('.$member['username'].')',
				'param'=>json_encode($post),
				'response'=>'done',
				'error'=>'-1'
			);
			//$CI->db->insert($CI->forex->tableAPI,$dtAPI);
		//===============================
			$param=array( );
			$param['accountid']=$member['accountid'];
			$param['masterpassword']=$pass1;
			$param['investorpassword']=$pass2; 			 
			$param['privatekey']	=$this->forex->forexKey();

			$url=$this->forex->forexUrl('update');
		//	$url.="?".http_build_query($param);
		//if(!defined('_DEV_')){
			$respon['param']=$param;
			$respon['server']= _runApi($url, $param  ); /* tidak akan dipakai pada versi berikutnya*/
		//	logCreate("update password result:".print_r($respon['server'],1));
		//}

$warning = ob_get_contents();
ob_end_clean();
if($warning!=''){
	$respon['warning']=$warning;     
}

if(isset($respon)){ 
	echo json_encode($respon);
}else{
	echo json_encode(array());
}