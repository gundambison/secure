<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/* 
*/
if ( ! function_exists('_localApi')){
	function _localApi($api='',$function='', $data=array()){
		$param=array(
		'api'=>$api,
		'function'=>$function,
		'data'=>$data
		);
		$url=site_url('rest/'.$param['api']);
		$res= _runApi($url,$param);
	//	echo '<br/>'.$url;var_dump($res);
		return $res;
	}
}
if ( ! function_exists('_runApi')){
	function _runApi($url, $parameter=array()){
		$CI =& get_instance();
		$CI->load->driver('advforex');
		$res= $CI->advforex->runApi($url,$parameter);
		$result0=isset($res['response'])?$res['response']:false;
		return (array)$result0;
	}

	function _runApi_old($url, $parameter=array()){
	global $maxTime;
	if( $maxTime==null ) $maxTime=10;
	if(isset($parameter['maxTime'])) $maxTime=$parameter['maxTime'];
	
	$CI =& get_instance();
	$dtAPI=array('url'=>$url);
	if(count($parameter)){
		$logTxt="func:_runApi| url:{$url}| param:".http_build_query($parameter,'','&'); 
	}
	else{ 
		$logTxt="func:_runApi| url:{$url}"; 
		$parameter['info']='no post';		
	}
	//$parameter[]=array('server'=>$_SERVER);
	$dtAPI['parameter']=json_encode($parameter);
	logCreate( 'API: '.$logTxt); 
		
	if(count($parameter)){	 	
		logCreate( 'API: '."url:{$url}| param:\n".print_r($parameter,1),'debug');
	}else{ 
		logCreate( 'API: param:'.print_r(parse_url($url),1),'debug');
	}
		$curl = curl_init();
		 
		curl_setopt($curl, CURLOPT_URL, $url  );
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		if($parameter != '' && count($parameter)!=0 ) {
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_TIMEOUT, $maxTime);
			curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($parameter,'','&'));
			if( isset($_SERVER['HTTP_USER_AGENT']) ) curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
			logCreate('API:POST','info');
		}
		else{ 
			logCreate('API:GET','info');
		}
		
		$response = curl_exec($curl);

		if (0 != curl_errno($curl)) {
			$response = new stdclass();
			$response->code = '500';
			$response->message = curl_error($curl);
			$response->maxTime = $maxTime;
			$dtAPI['response']=json_encode($response );
			$dtAPI['error']=1;
		}
		else{
			$response0 = $response; 
			$dtAPI['response']= $response ;
			$dtAPI['error']=0;
			$response = json_decode($response,1);
			if(!is_array($response)){
				$response=$response0;
				$dtAPI['error']=1;
			}
			else{
				$dtAPI['error']=0;
			}
		}
		
		curl_close($curl);
		if(!isset($response0)) $response0='?';
		logCreate( 'API |url:'. $url. "|raw:".(is_array($response)?'total array/obj='.count($response):$response0 ) );
		
	    $CI->db->insert($CI->forex->tableAPI,$dtAPI);	
		return $response;
			
	}

} else{}

if ( ! function_exists('batchEmail')){
	function batchEmail( $to='', $subject='', $message='', $headers='',$insert_table=true){
		$arr=array('to'=>trim($to), 'subject'=>$subject,'message'=>base64_encode($message),'headers'=>$headers);
		$json=json_encode($arr);
		//echo '<br>'.$json;
		$id0=date("ymd").'000' ;
		$id=dbId('mail',(int)$id0);
		$target="media/email/".$id.".txt";
		//echo '<br>target:'.$target;
		file_put_contents($target, $json);
		$sql="insert into mujur_email(`subject`,`to`,`header`) values('".addslashes($subject)."','".addslashes($to)."','".addslashes($json)."')";
		if($insert_table) 
			dbQuery($sql);
		//return true;
	}
	
} else{}

if ( ! function_exists('callback_submit')){
	function callback_submit(){
    $CI =& get_instance();
    $notif=$CI->session->flashdata('notif');
    if($notif){
	echo '
	    <div class="note '.($notif['status'] ? 'note-success' : 'note-danger').' note-shadow">
		    <button class="close" data-close="alert"></button>
		    <p>'.$notif['msg'].'</p>
	    </div>
	';
    }
	}
} else{}

if ( ! function_exists('return_rest')){
function return_rest($code=200,$data=array()){
	header('Content-Type: application/json; charset=utf-8;');
	$response=array('status_code'=>$code,
	'data'=>$data
	);
	echo json_encode($response);
	exit;
}
}

if ( ! function_exists('save_rest')){
function save_rest($param=array(),$result=false){
	$CI =& get_instance();
	$CI->load->model('forex_model');
	$dtAPI['url']='rest ';
	$dtAPI['url'].=isset($param['api'])?$param['api']:'???';
	$dtAPI['url'].="/";
	$dtAPI['url'].=isset($param['function'])?$param['function']:'???';

	$dtAPI['parameter']=isset($param['data'])?json_encode($param['data']):'???';
	$dtAPI['response']=json_encode($result);
	$dtAPI['error']=-10;

	$sql= $CI->db->insert_string($CI->forex_model->tableAPI, $dtAPI);
	dbQuery($sql);
}
}

function save_and_send_rest($code, $data, $param){
	save_rest($param, $data);
	return_rest($code, $data);
}