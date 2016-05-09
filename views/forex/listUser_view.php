<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

$sql="select reg_id id 
	from {$this->forex->tableRegis} order  by 
	reg_created desc limit 40";
$res=$this->db->query($sql)->result_array();
$s="<div style='width:700px;margin:auto'><table border=1>";
$i=1;
foreach($res as $row){
	$dt=$this->forex->regisDetail($row['id']);
	$s.="\n<tr><td>".$i++."</td>";//<td>".implode("</td>\n\t\t<td>", $dt );
	//implode("</td>\n\t<td>",array_keys($row));
	//$s.="</td>\n\t";
	$s.="<td><pre>".print_r($dt,1)."</pre></td>";
	$url=$this->forex->url;
	
	$param=array( );
	$param['firstname']	=isset($dt['firstname'])?$dt['firstname']:'';
	$param['lastname']	=isset($dt['lastname'])?$dt['lastname']:'';
	//username 
	$param['username']	=$dt['username'];
	$param['email']		=$dt['email'];
	$param['password']	=$dt['password'];
	$param['countrycode']=$dt['country']['code'];
	$param['currencycode']='USD';
	$param['ip']		=$_SERVER['SERVER_ADDR'];
	$param['tel']		=$dt['phone'];
	$param['phonetype']	=1;
	$param['accountType']=2;
	$param['isfxflg']=1;
	$param['isdemoflg']=$this->forex->demo;
	$param['isntdindexflg']=0;
	$param['isntdcfdflg']=0;
	$param['wlcode']	='NFX';
	$param['displayLanguage']='EN';
	$param['ibcustid']=	(int)$dt['username'];
	$param['amsgroup']	='NFX_Salma';
	$param['fxgroup']	='NFXSalma_USD';
	$url.="?".http_build_query($param);
//firstname=wrong&lastname=name&username=xxx12&email=notValid&password=12312312&countrycode=INA&currencycode=USD&ip=127.0.0.1&tel=62853114&phonetype=1&accountType=2&isfxflg=1&isdemoflg=0&isntdfxflg=0&isntdindexflg=0&isntdcfdflg=0&wlcode=NFX&displayLanguage=EN&ibcustid=9999&amsgroup=NFX_Salma&fxgroup=NFXSalma_USD	
/*
Array
(
    [username] => 9578995
    [password] => b729320
    [address] => Pejaten
    [country] => Array
        (
            [id] => 101
            [code] => ID
            [name] => Indonesia
            [created] => 0000-00-00
            [modified] => 2015-11-15 23:23:28
        )

    [citizen] => Indonesia
    [city] => Jakarta Selatan
    [dob1] => 12
    [dob2] => 12
    [dob3] => 1995
    [email] => gundambison@gmail.com
    [firstname] => Gunawan
    [lastname] => wibisono
    [phone] => 08562124121
    [state] => DKI Jakarta
    [zipcode] => 12510
)
*/	
	$s.="<td><a href='$url'>go</a></td>";
	$s.="</tr>";
}
$s.="</table></div>";

echo $s;	