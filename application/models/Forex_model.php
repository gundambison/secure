<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (   function_exists('logFile')){ logFile('model','forex_model.php','model'); };
class Forex_model extends CI_Model {
/***
Daftar Fungsi Yang Tersedia :
*	emailAdmin($name='default')
*	forexUrl($name='default')
*	forexKey()
*	flowInsert($type='',$data=array() )
*	rateUpdate($raw)
*	rateNow($types='')
*	accountRecover($detail=false)
*	accountCreate($id,$raw='')
*	accountDetail($id,$field='id')
*	accountDetailRepair($data=array())
*	accountActivation($id,$raw0)
*	activationDetail($id,$field='id')
*	activationUpdate($id, $status)
*	activationUpdateUser($id, $status)
*	regisAll($limit=10,$where="")
*	regisDetail($id,$stat=false)
*	regisDelete($email,$status=-1)
*	saveData($data, &$message)
*	__construct()
***/
public $tableRegis='mujur_register'; 
public $tableWorld='mujur_country'; 
public $tableAccount='mujur_account';
public $tableAccountDetail='mujur_accountdetail';
public $tableActivation='mujur_activation';
public $tablePassword='mujur_password';
public $tableAdmin='mujur_admin';
public $tablePrice='mujur_price';
public $tableFlowlog='mujur_flowlog';
public $tableAPI='mujur_api';
public $url="http://localhost/forex/fake";
public $demo=1; 

public $emailAdmin='admin@dev.salmaforex.com';

	function emailAdmin($name='default'){
		$url=$aAppcode=$this->config->item('emailAdmin');
		
		$this->emailAdmin=isset($url)?$url:false;
	}
	
	function forexUrl($name='default'){
		$url=$aAppcode=$this->config->item('urlForex');
		
		return isset($url[$name])?$url[$name]:false;
	}
	
	function forexKey(){
		$key=$this->config->item('forexKey');		
		return isset($key)?$key:false;
		
	}
//=================FLOW LOG
	function flowMember($id,$sort='created',$sortType='DESC', $limit=50,$start=0){
		$where="`param` like '%\"id\":\"{$id}\"%'";
		$sql="select count(id) c from `{$this->tableFlowlog}` where $where";
		$sql.=" order by `{$sort}` {$sortType} limit {$start}, {$limit}";
		$dt=dbFetchOne($sql);
		if($dt['c']==0) return false;
		$data['count']=$dt['c'];
		$sql="select types, param, created, status from `{$this->tableFlowlog}` where $where";
		$dt=dbFetch($sql);
		foreach($dt as $nm=>$var){
			$param=json_decode($var['param'],true);
			$dt[$nm]['param']=$param;
			$dt[$nm]['user']=isset($dt[$nm]['param']['userlogin'])?$dt[$nm]['param']['userlogin']:false;
		}
		$data['data']=$dt;
		return $data;
	}
	function flowInsert($type='',$data=array() ){
		if(!$this->db->table_exists($this->tableFlowlog)){
				$fields = array(
				  'id'=>array( 
					'type' => 'BIGINT','auto_increment' => TRUE), 		   
				  'types'=>array( 
					'type' => 'VARCHAR',  
					'constraint' => '200'),
				  'param'=>array( 'type' => 'text'),				   
				  'created'=>array( 'type' => 'timestamp'),
				);
				$this->dbforge->add_field($fields);
				$this->dbforge->add_key('id', TRUE);
				$this->dbforge->create_table($this->tableFlowlog,TRUE);
				$str = $this->db->last_query();			 
				logConfig("create table:$str");
				$this->db->reset_query();	
				 
		}
		$sql="select * from {$this->tableFlowlog} limit 1";
		$row=$this->db->query($sql)->row_array();
		if(!isset($row['status'])){
			$sql="ALTER TABLE `{$this->tableFlowlog}` ADD `status` tinyint default 0;";
				dbQuery($sql,1);			
		}
		
		if($type=='')return false;
		$dt=array('types'=>$type);
		$dt['param']=json_encode($data);
		$this->db->insert($this->tableFlowlog,$dt);
		return true;
	}
//=================Rate	
	function rateUpdate($raw){
		$data=array( 
			'types'=>$raw['types'],
			'price'=>$raw['rate']
		);
		if($raw['types']==''||$raw['rate']=='') return false;
		$rate0=$this->rateNow($raw['type']);
		$this->db->insert($this->tablePrice,$data);
		
		$data=array( 'url'=>'updateRate',
				'parameter'=>json_encode($data),
				'error'=>2,
				'response'=>"rate0:$rate0\nuser:".print_r($this->param['userlogin'],1)
			);
		$this->db->insert($this->tableAPI,$data);
	}

	function rateNow($types=''){
//==========Menambah mujur_price
			if(!$this->db->table_exists($this->tablePrice)){
				$fields = array(
				  'id'=>array( 
					'type' => 'BIGINT','auto_increment' => TRUE), 		   
				  'types'=>array( 
					'type' => 'VARCHAR',  
					'constraint' => '200'),
				  'price'=>array( 'type' => 'integer'),				   
				  'created'=>array( 'type' => 'timestamp'),
				);
				$this->dbforge->add_field($fields);
				$this->dbforge->add_key('id', TRUE);
				$this->dbforge->create_table($this->tablePrice,TRUE);
				$str = $this->db->last_query();			 
				logConfig("create table:$str");
				$this->db->reset_query();	
				$this->db->insert('mujur_price', 
					array('types'=>'deposit', 'price'=>14000));
				$this->db->insert('mujur_price', 
					array('types'=>'widtdrawal', 'price'=>13500));
			}
			
		$types=addslashes($types);
		$row= $this->db	
		->query('select price `value` from mujur_price where types="'.$types.'" order by created desc limit 1')
		->row_array(); 
		return $row ;
	}
/***
ACCOUNT 
SEMUA dipindah ke model ACCOUNT
***/	 
	function accountRecover($detail=false){
		if($detail==false){			
			return true;
		}
	}
	
	function accountCreate($id,$raw=''){
		$reg_id=$id;
		$detail=$this->regisDetail( $reg_id );
		if(defined('LOCAL')){
		$sql="select count(id) c from {$this->tableAccount} where username like '{$detail['username']}'";
			$row=dbFetchOne($sql);
			if($row['c']!=0){
				logCreate("hapus username : {$detail['username']}");
				$sql="delete from {$this->tableAccount} where username like '{$detail['username']}'";
				dbQuery($sql,1);
				$sql="delete from {$this->tableAccount} where reg_id = '{$reg_id}'";
				dbQuery($sql,1);
				$sql="delete from {$this->tableAccountDetail} where username like '{$detail['username']}'";
				dbQuery($sql,1);
			}
		}
		logCreate("register id:$id |detail:".print_r($detail,1));
		if(!isset($detail['detail']['statusMember']))
			$detail['detail']['statusMember']='MEMBER';
		logCreate("register id:$id |raw:".print_r($raw,1));		
		
		$dt=array(
			'reg_id'=>$id,
			'username'=>$detail['username'],
			'investorpassword'=>md5( trim($raw['investorpassword']) ),
			'masterpassword'=>md5( trim($raw['masterpassword']) ),
			'accountid'=>$raw['accountid'],
			'email'=>$detail['email'],
			'type'=>strtoupper($detail['detail']['statusMember']),
			//'raw'=>$raw,
			//'activation'=>base64_encode($raw),
			'created'=>date("Y-m-d")
		);
		$accid=dbId('account',date("ym000"),3);
/*
		$accid=date("ym000");
		$sql="select max(id) max from {$this->tableAccountDetail}";
		$dt2=dbFetchOne($sql);
		if($dt2['max'] > (int)$accid){
			$accid=$dt2['max'];
		}
*/
		$dt['id']=$acc_id=$accid+1;
		$sql="select count(id) tot from {$this->tableAccount} where reg_id='$reg_id'";
		$rawAccount=dbFetchOne($sql);
	//apabila ada reg_id yang sama maka cancel	
		if((int)$reg_id!=0&&$rawAccount['tot']!=0){
			logCreate("register not continue account exist:".json_encode($rawAccount));
			return false;
		}

		$sql=$this->db->insert_string($this->tableAccount,$dt);
		dbQuery($sql,1);
		logCreate("register accid:".$raw['accountid']);
		$dataRaw = $this->account->detail($raw['accountid'],'accountid');
		logCreate("register accid:".$acc_id);
		$dataRaw = $this->account->detail($acc_id);
		
//===========Account Detail  
		$dt=array(
			'id'=>$accid,
			'username'=>$dataRaw['accountid'],
			'detail'=>addslashes(json_encode($detail['detail'])),
		);
		
		logCreate("hapus detail sebelumnya:". $dataRaw['accountid']);
		$sql="delete from {$this->tableAccountDetail} where username like '{$dataRaw['accountid']}'";
		dbQuery($sql,0);
		
		$sql=$this->db->insert_string($this->tableAccountDetail, $dt);
		$data=dbQuery($sql);
		$sql="select id from {$this->tableActivation} where userid=$id and status!=1";
		$data=dbFetch($sql);
		logCreate('Close Old Activation:'.json_encode($data) );
		foreach($data as $row){
			$idActive=$row['id'];
			$this->activationUpdate($idActive, 1); //close activation
		}
		logCreate('Close Activation');
		$data = array('reg_status' => 0);
		$where = "reg_id=$id";
		$sql = $this->db->update_string($this->tableRegis, $data, $where);
		dbQuery($sql);
		//===========UPDATE ACCOUNT
		//===============Change Password===============		
//		$sql="select password from {$this->tablePassword} order by rand() limit 2";
//		$data=dbFetch($sql);
//		logCreate('change password :'.json_encode($data));
		$invPass=trim($raw['investorpassword']);//$data[0]['password'];
		$masterPass=trim($raw['masterpassword']);//$data[1]['password'];
		
		$param=array( );
		$param['privatekey']	=$this->forex->forexKey();
		$param['accountid']=(int)$raw['accountid'];
//		$param['masterpassword']=$masterPass;//.($raw['accountid']%100000 +19939);
//		$param['investorpassword']=$invPass;//.($raw['accountid'] %100000 +19919);
		$param['allowlogin']=1;
		$param['allowtrading']=1;

		$full_name=isset($detail['detail']['firstname'])?$detail['detail']['firstname']:'';
		$full_name.=" ". (isset($detail['detail']['lastname'])?$detail['detail']['lastname']:'');
		$full_name=substr($full_name,0,126);
		$param['username']= $full_name;
//		isset($detail['detail']['firstname'])&&isset($detail['detail']['lastname'])?utf8_encode("{$detail['detail']['firstname']} {$detail['detail']['lastname']}"):"";
		
		$url=$this->forex->forexUrl('update');
		$url.="?".http_build_query($param);
		logCreate("update password param:".print_r($param,1)."|url:$url");
		$arr['param']=$param;
		$arr['url']=$url;
		$result0= _runApi($url );
		logCreate("update password result:".print_r($result0,1));
		$param=array( );
		$param['privatekey']	=$this->forex->forexKey();
		$param['accountid']=(int)$raw['accountid'];
		
		$param['address']=isset($detail['detail']['address'])?$detail['detail']['address']:"";
		$param['country']=isset($detail['detail']['country']['name'])?$detail['detail']['country']['name']:"";
		$param['zipcode']=isset($detail['detail']['zipcode'])?$detail['detail']['zipcode']:"";
		$param['phone']=  isset($detail['detail']['phone'])?$detail['detail']['phone']:"";
		$param['email']=  isset($detail['email'])?$detail['email']:"";
//=============LIMIT
		$param['address']=substr($param['address'],0,95);
		$param['country']=substr($param['country'],0,17);
		$param['zipcode']=substr($param['zipcode'],0,15);
		$param['phone']=substr($param['phone'],0,31);
		$param['email']=substr($param['email'],0,47);
		$param['allowlogin']=1;
		$param['allowtrading']=1;

		$url=$this->forex->forexUrl('update');
		$url.="?".http_build_query($param);
		logCreate("update create account| detail param:".print_r($param,1)."|url:$url");
		$arr['param']=$param;
		$arr['url']=$url;
		$result0= _runApi($url );

		$param['masterpassword']=$masterPass;//.($raw['accountid']%100000 +19939);
		$param['investorpassword']=$invPass;//.($raw['accountid'] %100000 +19919);
//		logCreate("update detail result:".print_r($result0,1));
		$data = array(
			'investorpassword' => md5( $param['investorpassword'] ),
			'masterpassword'=>md5( $param['masterpassword'] )
		);
		$where = "accountid='{$raw['accountid']}'";
		
		$sql = $this->db->update_string($this->tableAccount, $data, $where);
		dbQuery($sql,1);
		
		$param2=array( 
			'username'=>$raw['accountid'],
			'masterpassword'=>$param['masterpassword'],
			'investorpassword'=>$param['investorpassword'],
			'email'=>$detail['email']
		);
		$param2['emailAdmin']=$this->emailAdmin;
		$param2['accountType']=$detail['detail']['statusMember'];	
		echo '<div>KIRIM EMAIL</div>';
		$this->load->view('depan/email/emailRegister_view',$param2);
		
	}

	function accountDetail($id,$field='id'){
		//$id=addslashes($id);
		logCreate("accountDetail id:$id|field:$field");
		
		$id=addslashes(trim($id));
		if($field=='email')$id.="%";
		
		$sql="select count(id) c from `{$this->tableAccount}`  where `{$field}` like '{$id}';"; 
		$res=dbFetchOne($sql);
		if($res['c']==0){
			logCreate("accountDetail id:$id|field:$field | not found");
			return false; 
			//$sql.print_r($res,1) ;
		}
		
		$sql="select a.* from {$this->tableAccount} a  		
		where `{$field}` like '$id'";
		$res=dbFetchOne($sql);		
		$this->accountDetailRepair($res);
			
		$sql="select a.*,ad.detail raw,adm.adm_type type from {$this->tableAccount} a 
		left join {$this->tableAccountDetail} ad 
			on a.username like ad.username
		left join {$this->tableAdmin} adm 
			on adm_username like a.username
		where a.`{$field}` like '$id'";
		$data= dbFetchOne($sql);
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
	
	function accountDetailRepair($data=array()){
		$username=$data['username'];
		$sql="select count(id) c  from {$this->tableAccountDetail} where `username`='$username'";
		$res=dbFetchOne($sql);
		if($res['c']==1){
			return true;
		}
		
		if($data['reg_id']!=0){
			//logCreate("account detail id:$id|field:$field create Detail");
			$reg=$this->regisDetail($data['reg_id']);
			$detail=json_encode($reg['detail']);
			$sql="insert into {$this->tableAccountDetail}(username,detail) values('$username','$detail')";
			dbQuery($sql);
		}else{}
		return true;
	}
/***
ACTIVATION 
***/	
	function accountActivation($id,$raw0){
		logCreate('create activation :'.$id." raw:".print_r($raw0,1));
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
			'reg_password'=>md5($raw0['masterpassword']), 
			'reg_investorpassword'=>md5($raw0['investorpassword'])
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
	function regisAll($limit=10,$where="")
	{		
		$sql="select reg_id id from {$this->tableRegis} $where order by reg_id desc limit $limit";
		return  dbFetch($sql);//$this->db->query($sql)->result_array();
	}
	
	function regisDetail($id,$stat=false)
	{
		$sql="select reg_username username, reg_password password, reg_detail detail, reg_status status,reg_agent agent,reg_email email from {$this->tableRegis} where reg_id=$id";
		$res=dbFetchOne($sql);//$this->db->query($sql)->row_array();
		//$res['sql']=$sql;
		//return $res;
		if(!isset($res['detail']) ) return $res;
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
		unset($res['detail']);
		foreach($dt2 as $nm=>$val){
			if($nm=='citizen'){
				$dt=$this->country->getData($val);
				$val=$dt['name'];
				$res['detail']['country']=$dt;
			}
			$res['detail'][$nm]=$val;
		}
		
		return $res;
	}
	
	function regisDelete($email,$status=-1){
		$email=trim($email);
		if($email!='')$email.='%';
		logCreate("delete regis by email:$email ");
		$sql="update `{$this->tableRegis}` set reg_status='$status' where  `reg_email` like '{$email}'";
		dbQuery($sql,1);
	}
	
	function saveData($data, &$message){
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
/*
email double diperbolehkan
		if($res['c']!=0){
			$message='Email already register';//.json_encode($res);
			return false;
		}
*/
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
	
	function apiAccount($account_id){
		//kembalikan nilai yang berhubungan dengan account_id
		$res['account']=$acc=(array)$this->accountDetail($account_id);
	//	return $data;
		$accid=$acc['username'];
		$this->db->or_like('url', $accid );
		$this->db->or_like('parameter',$accid);
		$this->db->or_like('response',$accid);
		$this->db->order_by('created','desc');
		$data=$this->db->get($this->tableAPI)->result_array();
		$res['sql'][]=$this->db->last_query();
		if(is_array($data)){
			foreach($data as $row){
				$res['username'][]=$row;
			}
			logCreate('apiAccount |username:'.$accid.' |data(1):'.json_encode($data));
		}
		else{ 
			$res['username'] =$data;
			logCreate('apiAccount |username:'.$accid.' |data(2):'.json_encode($data));
		}

		$this->db->reset_query();

		$email=trim($acc['email']) ;
		/*
		$this->db->or_like('url',$email);
		$this->db->order_by('created','desc');
		$data=$this->db->get($this->tableAPI)->result_array();
		$res['sql'][]=$this->db->last_query();
		*/
		$sql="select * from {$this->tableAPI} where url like '%{$email}%' order by created desc";
		$data=dbFetch($sql);
		logCreate('apiAccount |email:'.$this->db->last_query());
		if(is_array($data)){
			foreach($data as $row){
				$res['email'][]=$row;
			}
			logCreate('apiAccount |email:'.$email.' |data(1):'.json_encode($data));
		}
		else{ 
			$res['email'] =$data;
			logCreate('apiAccount |email:'.$email.' |data(2):'.json_encode($data));
		}
		$this->db->reset_query();
		
		return $res;
	}
	
	function apiDetail($id){
		$this->db->reset_query();
		$this->db->where('id',$id);
		$data=$this->db->get($this->tableAPI)->row_array();
		return $data; 
	}
//=====================================
		public function __construct(){
            $this->load->database();
			$this->load->dbforge();
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
			if(!isset($dt['type'])){ 
				$sql="ALTER TABLE `{$this->tableAccount}` ADD `type` varchar(20) 
				NOT NULL 
				DEFAULT 'MEMBER';";
				dbQuery($sql,1);
			}
			if(!isset($dt['accountid'])){ 
				$sql="ALTER TABLE `{$this->tableAccount}` ADD `accountid` bigint NOT NULL DEFAULT '1';";
				dbQuery($sql,1);
			}
//=========Menambah Account Detail			
			if(!$this->db->table_exists($this->tableAccountDetail)){
				$fields = array(
				  'id'=>array( 
					'type' => 'BIGINT','auto_increment' => TRUE), 		   
				  'username'=>array( 
					'type' => 'VARCHAR',  
					'constraint' => '100'),
				  'detail'=>array( 'type' => 'text'),
				  'modified'=>array( 'type' => 'timestamp'),
				);
				$this->dbforge->add_field($fields);
				$this->dbforge->add_key('id', TRUE);
				$this->dbforge->create_table($this->tableAccountDetail,TRUE);
				$str = $this->db->last_query();			 
				logConfig("create table:$str");
				$this->db->reset_query();	
			}
//==========Menambah mujur_api
			if(!$this->db->table_exists('mujur_api')){
				$fields = array(
				  'id'=>array( 
					'type' => 'BIGINT','auto_increment' => TRUE), 		   
				  'url'=>array( 
					'type' => 'VARCHAR',  
					'constraint' => '200'),
				  'parameter'=>array( 'type' => 'text'),
				  'response'=>array( 'type' => 'text'),
				  'error'=>array( 'type' => 'boolean'),
				  'created'=>array( 'type' => 'timestamp'),
				);
				$this->dbforge->add_field($fields);
				$this->dbforge->add_key('id', TRUE);
				$this->dbforge->create_table('mujur_api',TRUE);
				$str = $this->db->last_query();			 
				logConfig("create table:$str");
				$this->db->reset_query();	
			}
			if(!$this->db->table_exists('mujur_email')){
				$fields = array(
				  'id'=>array( 
					'type' => 'BIGINT','auto_increment' => TRUE), 		   
				  'to'=>array( 
					'type' => 'VARCHAR',  
					'constraint' => '200'),
				  'subject'=>array( 'type' => 'text'),
				  'headers'=>array( 'type' => 'text'),
				  'created'=>array( 'type' => 'timestamp'),
				);
				$this->dbforge->add_field($fields);
				$this->dbforge->add_key('id', TRUE);
				$this->dbforge->create_table('mujur_email',TRUE);
				$str = $this->db->last_query();			 
				logConfig("create table:$str");
				$this->db->reset_query();	
			}

			$this->rateNow();
			$this->flowInsert('');
			$this->emailAdmin();
			$this->accountRecover();
        }
}