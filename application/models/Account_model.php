<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (   function_exists('logFile')){ logFile('model','account_model.php','model'); };

class Account_model extends CI_Model {
public $tableRegis='mujur_register'; 
public $tableWorld='mujur_country'; 
public $tableAccount='mujur_account';
public $tableAccountRecover='mujur_accountrecover';

public $tableAccountDetail='mujur_accountdetail';
public $tableActivation='mujur_activation';
public $tablePassword='mujur_password';
public $tableAdmin='mujur_admin';
public $tablePrice='mujur_price';
public $tableFlowlog='mujur_flowlog';
public $tableAPI='mujur_api';
public $url="http://localhost/forex/fake";
public $demo=1; 

	function recoverId($id=0){		 
		$now=date("Y-m-d H:i:s");
		$sql="select count(id) c from {$this->tableAccountRecover} 
		where id='{$id}' 
		and expired > '$now'";
		$row=$this->db->query($sql)->row_array();
		 
		if($row['c']==0) return false;
		$sql="select params from `{$this->tableAccountRecover}` 
		where id='{$id}'";
		$row=$this->db->query($sql)->row_array();
		$raw=base64_decode($row['params']);
		$detail='click from :'.$_SERVER['HTTP_REFERER'];
		$sql="update `{$this->tableAccountRecover}` 
		set  detail='$detail' 
		where id='$id'";
		dbQuery($sql,1);
		return json_decode($raw,true);
	}
	
	function noPass($id){
		$id=addslashes($id);
		$sql="update `{$this->tableAccount}` 
		set 
		investorpassword='',masterpassword='' 
		where id='$id'";
		dbQuery($sql,1);
		logCreate("reset password |id:".$id);		
		return true;
	}
	
	function recover($detail=false){
		if($detail==false){
//=========Menambah Account Recover			
			if(!$this->db->table_exists($this->tableAccountRecover)){
				$fields = array(
				  'id'=>array( 
					'type' => 'BIGINT','auto_increment' => TRUE), 		   
				  'params'=>array( 
					'type' => 'text'),
				  'detail'=>array( 'type' => 'text'),
				  'modified'=>array( 'type' => 'timestamp'),
				  'expired'=>array('type'=>'datetime')
				);
				$this->dbforge->add_field($fields);
				$this->dbforge->add_key('id', TRUE);
				$this->dbforge->create_table($this->tableAccountRecover,TRUE);
				$str = $this->db->last_query();			 
				logConfig("create table:$str");
				$this->db->reset_query();	
			}else{}			
			return true;
		}
		
		$data=array('id'=>dbId('recover',date('Ym000'),rand(13,29)));
		$data['params']=base64_encode(json_encode($detail));
		$data['detail']=defined("_DEV_")||defined("LOCAL")?json_encode($detail):'';
		date_default_timezone_set('Asia/Jakarta');
		$data['expired']=date("Y-m-d H:i",strtotime("+25hours"));
		$this->db->insert($this->tableAccountRecover,$data);
		return $data['id'];
		
	}
	
	function create($id,$raw='') //tidak di jalankan
	{
		$detail=$this->regisDetail($id);
		if(defined('LOCAL')){
			$sql="select count(id) c from `{$this->tableAccount}` 
		where username like '{$detail['username']}'";
			$row=dbFetchOne($sql);
			if($row['c']!=0){
				$sql="delete from `{$this->tableAccount}` 
				where username like '{$detail['username']}'";
				dbQuery($sql,1);
				$sql="delete from `{$this->tableAccountDetail}` 
				where username like '{$detail['username']}'";
				dbQuery($sql,1);
			}
		}

		$dt=array(
			'reg_id'=>$id,
			'username'=>$detail['username'],
			'investorpassword'=>trim($raw['investorpassword']),
			'masterpassword'=>trim($raw['masterpassword']),
			'accountid'=>$raw['accountid'],
			'email'=>$detail['email'], 
			'created'=>date("Y-m-d")
		);
		$accid=date("ym000");
		$sql="select max(id) max from `{$this->tableAccount}`";
		$dt2=dbFetchOne($sql);
		if($dt2['max'] > (int)$accid){
			$accid=$dt2['max'];
		}
		$dt['id']=$accid+1;
		
		$sql=$this->db->insert_string($this->tableAccount,$dt);
		dbQuery($sql,1);
//===========Account Detail  
		$dt=array(
			'id'=>$accid,
			'username'=>$detail['username'],
			'detail'=>json_encode($detail['detail']),
			
		);
		$sql=$this->db->insert_string($this->tableAccountDetail,$dt);
		
		$sql="select id from `{$this->tableActivation}` 
		where userid=$id";
		$data=dbFetch($sql);
		foreach($data as $row){
			$idActive=$row['id'];
			$this->activationUpdate($idActive, 1); //close activation
		}
		
		$data = array('reg_status' => 0);
		$where = "reg_id=$id";
		$sql = $this->db->update_string($this->tableRegis, $data, $where);
		dbQuery($sql,1);
//===============Change Password===============
		$sql="select password from {$this->tablePassword} order by rand() limit 2";
		$data=dbFetch($sql);
		$invPass=$data[0]['password'];
		$masterPass=$data[1]['password'];
		
		$param=array( );
		$param['privatekey']	=$this->forex->forexKey();
		$param['accountid']=$raw['accountid'];
		$param['masterpassword']=$masterPass.($raw['accountid']%100000 +19939);
		$param['investorpassword']=$invPass.($raw['accountid'] %100000 +19919) ; 
		
		$url=$this->forex->forexUrl('update');
		$url.="?".http_build_query($param);
		$arr['param']=$param;
		$arr['url']=$url;
//---------UNTUK PEMBUATAN		
		$result0= _runApi($url );
		logCreate("update password result:".print_r($result0,1));
		$data = array(
			'investorpassword' => md5( $param['investorpassword'] ),
			'masterpassword'=>md5( $param['masterpassword'] )
		);
		$where = "reg_id=$id";
		
		$sql = $this->db->update_string($this->tableAccount, $data, $where);
		dbQuery($sql,1);
		
		$param2=array( 
			'username'=>$detail['username'],
			'masterpassword'=>$param['masterpassword'],
			'investorpassword'=>$param['investorpassword'],
			'email'=>$detail['email']
		);
		$param2['emailAdmin']=$this->emailAdmin;
		$param2['accountType']=$detail['accounttype'];
		$this->load->view('member/email/emailRegister_view',$param2);
		
	}

	function detail($id,$field='id'){
		$id=addslashes(trim($id));
		if($field=='email')$id.="%";
		$sql="select count(id) c 
		from `{$this->tableAccount}`  
		where `{$field}` like '{$id}';"; 
		$res=dbFetchOne($sql);
		if($res['c']==0){
			return false; 
		}
		
		$sql="select a.* from `{$this->tableAccount}` a  		
		where `{$field}` like '$id'";
		$res=dbFetchOne($sql); 
			
		$sql="select 
		a.id, a.username, a.email, a.investorpassword, a.masterpassword, a.reg_id,a.accountid,
		a.type accounttype, ad.detail raw,adm.adm_type type from `{$this->tableAccount}` a 
		left join `{$this->tableAccountDetail}` ad 
			on a.username like ad.username
		left join `{$this->tableAdmin}` adm 
			on adm_username like a.username
		where a.`{$field}` like '$id'";
		$data= dbFetchOne($sql);
		if($data['accounttype']!='MEMBER'){
			$agent=true;
		}
		else{ 
			$agent=false;
		}
		
		if($data['type']==7){
			$data['type']='admin';
		}else{
			$data['type']=false;
		}
		if(isset($data['raw'])){
			$data['detail']=json_decode($data['raw'],true); 
		}
		unset($data['raw']);
		return $data;
	}
	
	function detailRepair($data=array()){
		$username=$data['username'];
		$sql="select count(id) c  from `{$this->tableAccountDetail}` 
		where `username`='$username'";
		$res=dbFetchOne($sql);
		if($res['c']==1){
			return true;
		}
		
		if($data['reg_id']!=0){
			$reg=$this->regisDetail($data['reg_id']);
			$detail=json_encode($reg['detail']);
			$sql="insert into `{$this->tableAccountDetail}`(username,detail) 
			values('$username','$detail')";
			dbQuery($sql);
		}else{}
		return true;
	}
//=====================================
		public function __construct()
        {
            $this->load->database();
			$this->load->dbforge();
			$this->recover();
		}

}