<?php 
$respon=array( 'post'=>$_POST );
$html='';
$detail=$this->account->detail($post0['id']);
$respon['raw']=$detail;
//$html.="<pre>".print_r($detail,1)."</pre>";

$show=array();
$show['TYPE']=$detail['accounttype'];
$show['username']=$detail['username'];
$show['email']=$detail['email'];
$show['Nama Lengkap']=isset($detail['detail']['firstname'])?$detail['detail']['firstname']:'';
$show['Nama Lengkap'].=isset($detail['detail']['lastname'])?' '.$detail['detail']['lastname']:'';
if(trim($show['Nama Lengkap'])=='')$show['Nama Lengkap']='???';

$show['Alamat']=isset($detail['detail']['address'])?$detail['detail']['address']:'';
if(trim($show['Alamat'])=='')$show['Alamat']='???';

$show['Bank']=isset($detail['detail']['bank'])?$detail['detail']['bank']:'???';
$show['No Rekening']=isset($detail['detail']['bank_norek'])?$detail['detail']['bank_norek']:'???';

<<<<<<< HEAD
$apiRes=$this->forex->apiAccount($post0['id']);
//$respon['api2']=$apiRes;

if(isset($apiRes['email'])&&is_array($apiRes['email'])){
	$n=0;
//	$show['xxx']=json_encode( $apiRes['email']);
	
	foreach($apiRes['email'] as $dataApi){
		$url0=base_url('member/send_email/api/'.$dataApi['id']);
		$n++;
		$detail=json_decode($dataApi['parameter'],true);
		$subject=$detail[0];
		$message=$detail[2];
		$headers=$detail[1];
		$show['send email '.$n]=anchor_popup($url0, $subject). " (".$dataApi['created'].")" ;
	}
	 
}

?><h3>Detail</h3>
<table border=1 width=400 class='table'>
=======
?><h3>Detail</h3>
<table border=1 width=400>
>>>>>>> origin
<?php 
foreach($show as $nm=>$val){?>
<tr>
	<td><?=$nm;?></td><td>:</td><td>&nbsp;<?=$val;?></td>
</tr>
<?php 
}
?>
</table>
<?php 
$respon['title']='Detail User';


$html = ob_get_contents();
ob_end_clean();
 
<<<<<<< HEAD
$respon['html']="<div style='max-height:400px;width:800px;overflow:auto;padding:30px;border:1px solid blue;margin:2px'>".$html."</div>";
=======
$respon['html']="<div style='max-height:400px;width:800px;overflow:auto'>".$html."</div>";
>>>>>>> origin
$respon['status']=true;
if(isset($respon)){ 
	echo json_encode($respon);
}
else{
	echo json_encode(array());
}