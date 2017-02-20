<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (   function_exists('logFile')){ logFile('model','account_model.php','model'); };

class Users_model extends CI_Model {
public $table='mujur_users';
public $tableDocument='mujur_usersdocument';
public $tableDetail='mujur_usersdetail';
function exist($search,$limit=10, $field='u_email'){
	$sql='select * from `'.$this->table.'` 
	where `'.$field.'` like "'.$search.'"
	limit '.$limit;//preventif
	$res=dbFetch($sql);
	if($res==false||count($res)==0){
		return false;
	}
	
	return array(
	'count'=>count($res),
	'data'=>$res
	);
}

function register($param){
	$res=array('data'=>$param);
		$password="SalmaMarket";
	$params=$param;
	unset($params['accept'],$params['submit']);
	$email=isset($param['email'])?trim($param['email']):null;
		$resPass= $this->password_model->random(2);
		$pass1=$resPass[0]['password'];
		$pass2=$resPass[1]['password'];
		$input=array('u_type'=>1,'u_status'=>-1); //status -1 karena baru. di aktifkan setelah kirim email
		$input['u_password']=sha1("{$pass1}|{$pass2}")."|".$pass2 ;
		$input['u_email']=$email;
		$res['password']=$resPass;
	$sql= $this->db->insert_string($this->table, $input);
		dbQuery($sql);
	$res['sql'][]=$sql;
	$input=array('ud_email'=>$email);
	$input['ud_detail']=json_encode($params);
	$sql= $this->db->insert_string($this->tableDetail, $input);
		dbQuery($sql);
	$res['sql'][]=$sql;
	$res['input']=$input;
	$res['masterpassword']=$pass1;
	return $res;
}
		public function __construct()
        {
            $this->load->database();
			$this->load->dbforge();
			$this->recover();
		}
	private function recover(){
		return true;
	}

	function active_email($email,$status=1){
		$sql="update {$this->table} set u_status={$status} where u_email like '{$email}'";
		dbQuery($sql);
	}
	
	function checkLogin($username,$password){
		$data=$this->gets($username);
		if($data==false) return false;
		$tmp=explode("|", $data['u_password'] );
		logCreate(json_encode($tmp));
		$keys=isset($tmp[1])?$tmp[1]:null;
		$pass=sha1("{$password}|{$keys}")."|".$keys;
		$sql="select count(*) c from {$this->table} 
		where u_email like '{$username}'
		and u_password like '{$pass}'
		and u_status=1";

		$res=dbFetchOne($sql,1);
		return $res['c']==1?true:false;
	}
	
	function loginCheck($username,$password){
		$sql="select count(*) c from {$this->table} 
		where u_email like '{$username}'
		and u_password like '{$password}'
		and u_status=1";

		$res=dbFetchOne($sql,1);
		return $res['c']==1?true:false;
	}
	
	function gets($id,$field='u_email'){
		$sql="select * from {$this->table} where `$field`='$id'";
		return dbFetchOne($sql);
	}
	function getDetail($id,$field='ud_email'){
		$sql="select ud_email, ud_detail from {$this->tableDetail} where `$field`='$id'";
		$res= dbFetchOne($sql);
		$respon=array();
		$respon=json_decode($res['ud_detail'],true);
		$email=$res['ud_email'];//unset($res['u_detail']);
		$sql="select udoc_status status from {$this->tableDocument} where `udoc_email`='$email'";
		$res= dbFetchOne($sql);
		$respon['document']=$res;
		return $respon;
	}
}