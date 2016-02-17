<?php 
ob_start();
if (  function_exists('logFile')){ logFile('view/member/data','widtdrawalProcess_data.php','data'); };

$respon['post']=$_POST;

$id=isset($_POST['id'])?addslashes($_POST['id']):0;
//================
$sql="select * from mujur_flowlog where id='$id'";

$dt=$this->db->query($sql)->row_array();
$dt['raw']=json_decode($dt['param'],1);
$dt['userlogin']= $dt['raw']['userlogin'];
$dt['statusConfirm']=$_POST['status'];
$this->param['deposit']=$dt;
//======KIRIM EMAIL

 		
if(isset($_POST['status'])){
	if($_POST['status']=='approve'){
		$param=array( );
		if(defined('_DEV_')){
			$param['dev']=true;
		}
		$vol=(int)$dt['raw']['orderWidtdrawal'];		
		$param['accountid']		=	$dt['raw']['accountid'];
		$param['volume']		=	$vol."-"; 			 
		$param['privatekey']	=	$this->forex->forexKey();
				
		$url=$this->forex->forexUrl('updateBalance');
		$url.="?".http_build_query($param);
		$respon['server']=$tmp= _runApi($url );
		echo $url;
		if($tmp['data']===0){
			$this->load->view('member/email/emailWidtdrawalStatus_view',$dt);
			$sql="update mujur_flowlog set status=1 where id=$id";
			dbQuery($sql,1);
			logCreate('widtdrawal Approve');
		}
		else{ 
			logCreate('widtdrawal Canceled');
		}
		
	}else{
		$sql="update mujur_flowlog set status=2 where id=$id";
		dbQuery($sql,1);
		$this->load->view('member/email/emailWidtdrawalStatus_view',$dt);
		logCreate('widtdrawal disapprove');
	}
	
}else{}	
 
$warning = ob_get_contents();
ob_end_clean();
if($warning!=''){
	$respon['warning']=$warning;     
}
$respon['raw']=$this->param;
if(isset($respon)){ 
	echo json_encode($respon);
}else{
	echo json_encode(array());
}