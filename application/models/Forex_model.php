<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Forex_model extends CI_Model {
public $tableRegis='mujur_register'; 
public $tableWorld='mujur_country'; 
public $tableAccount='mujur_account';
public $tableActivation='mujur_activation';
public $url="http://localhost/forex/fake";
public $demo=1;
        public function __construct()
        {
            $this->load->database();
//=========UPDATE REGISTER			
			$sql="select count(reg_id) tot from {$this->tableRegis}";
			$dt=dbFetchOne($sql);
			if($dt['tot']==0){
				$arr=array('reg_id'=>0,'reg_status'=>-1);
				$this->db->insert($this->tableRegis,$arr);
			}
			$sql="select * from {$this->tableRegis} limit 1";
			$dt=dbFetchOne($sql);
			if(!isset($dt['reg_investorpassword'])){
				$sql="ALTER TABLE `{$this->tableRegis}` ADD `reg_investorpassword` VARCHAR(100) NOT NULL AFTER `reg_password`;";
				dbQuery($sql,1);
			}
			
//=========UPDATE ACCOUNT			
			$sql="select count(id) tot from {$this->tableAccount}";
			$dt=dbFetchOne($sql);
			if($dt['tot']==0){
				$arr=array('id'=>0,'created'=>date("Y-m-d"));
				$this->db->insert($this->tableAccount,$arr);
			}
			$sql="select * from {$this->tableAccount} limit 1";
			$dt=dbFetchOne($sql);
			if(!isset($dt['investorpassword'])){
				$sql="ALTER TABLE `{$this->tableAccount}` 
				ADD `investorpassword` VARCHAR(100) NOT NULL, 
				ADD `masterpassword` VARCHAR(100) NOT NULL, 
				ADD `reg_id` BIGINT(20) NOT NULL ;";
				dbQuery($sql,1);
				$sql="ALTER TABLE `{$this->tableAccount}` CHANGE `username` `username` VARCHAR(50) NOT NULL;";
				dbQuery($sql,1);
				
			}
			
        }
		
	function forexUrl($name='default'){
		$url=$aAppcode=$this->config->item('urlForex');
		
		return isset($url[$name])?$url[$name]:false;
	}
	
	function forexKey(){
		$key=$this->config->item('forexKey');		
		return isset($key)?$key:false;
	}
/***
ACCOUNT
***/	 
	function accountCreate($id,$raw=''){
		$detail=$this->regisDetail($id);
		if(defined('LOCAL')){
			$sql="select count(id) c from {$this->tableAccount} where id=$id";
			$row=dbFetchOne($sql);
			if($row['c']!=0){
				$sql="delete from {$this->tableAccount} where id=$id";
				dbQuery($sql,1);
			}
		}
/*
	[accountid] => 999
    [masterpassword] => xxx
    [investorpassword] => xxx1
*/	
		$dt=array(
			'reg_id'=>$id,
			'username'=>$detail['username'],
			'investorpassword'=>$raw['investorpassword'],
			'masterpassword'=>$raw['masterpassword'],
			'id'=>$raw['accountid'],
			//'raw'=>$raw,
			//'activation'=>base64_encode($raw),
			'created'=>date("Y-m-d")
		);
		$sql=$this->db->insert_string($this->tableAccount,$dt);
		dbQuery($sql,1);
		
		$sql="select id from {$this->tableActivation} where userid=$id";
		$data=dbFetch($sql);
		foreach($data as $row){
			$idActive=$row['id'];
			$this->activationUpdate($idActive, 1); //close activation
		}
		$data = array('reg_status' => 0);
		$where = "reg_id=$id";
		$sql = $this->db->update_string($this->tableRegis, $data, $where);
		dbQuery($sql,1);
	}

/***
ACTIVATION

***/	
	function accountActivation($id,$raw0){
		logCreate('create :'.$id." raw:".print_r($raw0,1));		
		$sql="select reg_id id from {$this->tableRegis} where reg_id like '$id'";
		$row= $this->db->query($sql)->row_array();
		$idActive=sprintf("%s%05s",dbId('activation', 200005),$row['id']);
		$ar=array('date'=>date("Y-m-d H:i:s"), 'id'=>$id, 'raw'=>$raw0);
		$raw=json_encode($ar);
		$raw1=base64_encode($raw);
		logCreate('code:'.$raw,'info');
		$dt=array( 
			'id'=>$idActive,
			'code'=>$raw1,
			'userid'=>$id,
			'expired'=>date("Y-m-d H:i:s",strtotime("+4 hours")),
			'created'=>date("Y-m-d H:i:s",strtotime("now"))
			
		);
		logCreate('code (before):'.print_r(json_decode(base64_decode($raw1)),1) );
		$sql=$this->db->insert_string($this->tableActivation,$dt);
		dbQuery($sql,1);
		
		$data = array(
			'reg_status' => 2, 
			'reg_password'=>$raw0['masterpassword'], 
			'reg_investorpassword'=>$raw0['investorpassword']
		);
		$where = "reg_id=$id";
		$sql = $this->db->update_string($this->tableRegis, $data, $where);
		dbQuery($sql,1);
		$this->accountCreate($id, $raw0);
		return $idActive;
	}
	
	function activationDetail($id,$field='id'){
		$sql="select * from {$this->tableActivation} where $field='".addslashes($id)."'";
		$res=dbFetchOne($sql);
		return $res;
	}
	
	function activationUpdate($id, $status){
		$data = array('status' => $status);
		$where = "id=$id";
		logCreate("activation update id:{$id} |status:{$status}","info");
		$sql = $this->db->update_string($this->tableActivation, $data, $where);
		dbQuery($sql,1);
		
	}
	
	function activationUpdateUser($id, $status){
		$data = array('status' => $status);
		$where = "userid=$id";
		$sql = $this->db->update_string($this->tableActivation, $data, $where);
		dbQuery($sql,1);
		
	}
	

/***
REGISTER

***/	
	function regisAll($limit=10)
	{
		$sql="select reg_id id from {$this->tableRegis} order by reg_id desc limit $limit";
		return  dbFetch($sql);//$this->db->query($sql)->result_array();
	}
	
	function regisDetail($id,$stat=false)
	{
		$sql="select reg_username username, reg_password password, reg_detail detail, reg_status status,reg_agent agent from {$this->tableRegis} where reg_id=$id";
		$res=dbFetchOne($sql);//$this->db->query($sql)->row_array();
		if($res['username']==''&&$stat==false){			
			$res['username']=9578990+$id;		
			if(defined('LOCAL')){
				$res['username']="demo".$res['username'];
			}else{}			
			$password=""; //substr(md5($res['username']),3,7);
			$res['password']=$password;
			$sql="update {$this->tableRegis} set reg_username='$res[username]', 
			  reg_password='$res[password]' where reg_id=$id";
			$data=array(
				'reg_username'=>$res['username'],
				'reg_password'=>$res['password']
			);
			$where="reg_id=$id";
			$sql = $this->db->update_string($this->tableRegis, $data, $where);
			dbQuery($sql,1);
			if(defined('LOCAL')){
				echo $sql;
			}
			//$this->db->query($sql);
		}
		
		unset($res['reg_id']);
		$dt2=json_decode($res['detail'],1);
		ksort($dt2);
		foreach($dt2 as $nm=>$val){
			if($nm=='citizen'){
				$dt=$this->country->getData($val);
				$val=$dt['name'];
				$res['country']=$dt;
			}
			$res[$nm]=$val;
		}
		unset($res['detail']);
		return $res;
	}
		
	function saveData($data, &$message)
	{
		if(isset($data['agent'])){
			$agent=trim($data['agent']);
			unset($data['agent']);
		}
		
		if(isset($data['email'])){
			$email=$data['email'];
		}else{
			$message='No email';
			return false;
		}
		
		$sql="select count(reg_id) c from {$this->tableRegis} where
		reg_email='$email'";
		$res= $this->db->query($sql)->row_array();
		if($res['c']!=0){
			$message='Email already register';//.json_encode($res);
			return false;
		}
		unset($data['type']);
		$dt=array(
			'reg_status'=>1,
			'reg_detail'=>json_encode($data),
			'reg_agent'=>$agent,
			'reg_created'=>date("Y-m-d H:i:s"),
			'reg_email'=>$email,
		);
		$sql=$this->db->insert_string($this->tableRegis, $dt);
		dbQuery($sql);
		$message='Your account successfull registered';
		return true;
	}
		
}