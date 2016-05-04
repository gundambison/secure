<?php 
ob_start();
echo "start\n";
$succes=false;
$aSql=array();
$late2days=date("Y-m-d H:i:s", strtotime("-3 days"));
$aSql[]="create table {$tableTarget} like `mujur_api`;";
$aSql[]="insert into  {$tableTarget} select * from `mujur_api`;";
$aSql[]="delete from `mujur_api` where created < '{$late2days}';";
$aSql[]="optimize table `mujur_api`";
echo implode("\n",$aSql);
foreach($aSql as $sql){
	dbQuery($sql,true);
	echo "\nrun $sql";
}
$content=ob_get_contents();
ob_end_clean();

$result=array(
	'body'=>isset($content)?$content:'', 
	'data'=>isset($data)?$data:array(), 
);
$succes=true;
//==========IF OK
if($succes===true)
	$result['succes']=true;

echo json_encode($result);