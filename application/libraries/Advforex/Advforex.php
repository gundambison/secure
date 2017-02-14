<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Advforex extends CI_Driver_Library {
	public $driver_name;
    public $valid_drivers;
    public $CI;
/***
Daftar Fungsi Yang Tersedia :
*	__construct()
***/

	function __construct(){
        $this->CI  =& get_instance();
		$driver_prefix='advforex_';
        $this->valid_drivers = array(
			'api','register','recover','user',
		);
		//log_message('info','driver:'.json_encode( $this->valid_drivers ));
    }

	function runApi($url, $parameter=array()){
	$maxTime=20;//default
	if(isset($parameter['maxTime'])) $maxTime=$parameter['maxTime'];
	
	$CI =& get_instance();
	$dtAPI=array('url'=>$url);
	if(count($parameter)){
		$logTxt="advforex -> runApi | url:{$url}| param:".http_build_query($parameter,'','&'); 
	}
	else{ 
		$logTxt="advforex -> runApi | url:{$url}"; 
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
			$response = json_decode($response0,1);
			if(!is_array($response)){
				$strip_response = stripslashes($response0);
				$response = json_decode($strip_response,1);
				if(!is_array($response)){
					$strip_response = substr($strip_response,1, strlen($strip_response)-2);
					$response = json_decode($strip_response,1);
					if(!is_array($response)){					
						$dtAPI['response']= $strip_response ;
						$response=$response0;
						$dtAPI['error']=1;
					}
				}
				else{
					/*OK*/
					$dtAPI['error']=-2;
				}

			}
			else{
				/*OK*/
				$dtAPI['error']=-1;
			}

		}
		
		curl_close($curl);
		if(!isset($response0)) $response0='?';
		logCreate( 'API |url:'. $url. "|raw:".(is_array($response)?'total array/obj='.count($response):$response0 ) );
	    //$CI->db->insert($CI->forex->tableAPI,$dtAPI);	
		return array('raw'=>$response0, 'db_data'=>$dtAPI,
		'response'=>$response
		) ;

	}
	
	function check_param($params){
		$err='';
		foreach($params as $name=>$param){
			if($param===false){
				$err.="parameter {$name} tidak valid| ";
			}

		}

		if($err!=''){
			log_message('error','advforex check_param :'.$err);
			logCreate('advforex check_param :'.$err,'error');
			return false;
		}

		return true;
	}

}