<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/*
membutuhkan config logConfig.php  
*/
 
if ( ! function_exists('logConfig'))
{
  function logConfig($txt,$config0='',$type='debug'){
	$CI =& get_instance();
	$config = $CI->config->item($config0);
	 
	if($config){
		$date=date("Ymd");
		$filename= sprintf($config['name'],$date);
		if(isset($config['write']))
			logCreate($txt,$type, $config['path'],$filename);
	}
	else{
		logCreate($txt,$type);
		$txt='tidak ditemukan config :'.$config0;
		logCreate($txt,'error');
	}
  }
}else{}

if ( ! function_exists('logCreateDir')){
	function logCreateDir($dir){
		$a=explode('/',trim($dir));
		$dir_str='';
		foreach($a as $id=>$path){
			if($path=='') break;
			$dir_str.=($id!=0)?"/$path":$path; 
			if(!is_dir($dir_str)){
				@mkdir($dir_str); 
			}else{ logCreate("dir avaiable:{$dir_str}");}
		} 
	}
	
}else{}

if ( ! function_exists('logCreate'))
{
  function logCreate($txt,$type='debug',$path='',$filename=''){
	$CI =& get_instance();
	$config = $CI->config->item('logConfig');
	
	if(!isset($config['write']))
		return false;
		
	$date=date("Ymd");
	$datetime=date("Y-m-d H:i:s");
	if(is_array($txt))
		$txt=json_encode($txt);
	
	$str="$datetime\t$type\t$txt\n";
	//folder log harus ada
	$target=(trim($path)=='')?$config['path'] :$path ;
	//auto created
	if(!is_dir($target)){
		logCreateDir($target);
	}else{}
	
	$target.= ( trim($filename)==''? sprintf($config['name'],$date):$filename);
	$target.="_".ceil(date("H") / 3 );
	//@error_log($str,3,$target );
	if($target==''){
		log_message('error', 'filename:'.$target.'(null?)|str:'.$str );
	}else{}
	
	if(!is_file($target)){
		$txt="<?php die('you not allowed to read directly');\t?>\n";
		file_put_contents ($target, $txt,LOCK_EX );
	}else{}
	
	if($target!=''){
		file_put_contents ($target, $str, FILE_APPEND|LOCK_EX );
	}else{}
 
 }
 
}else{}