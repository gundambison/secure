<?php 
$filename='data.csv';
if (($handle = fopen($filename, "r")) !== FALSE) {
	$account=array();
	$n=0;
    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
		$login=$data[0];
		$agent=$data[5];
		
		if($n!=0&&$agent!='') $account[]=array($login, $agent);
		$n++;
	}
}

echo 'total:'.count($account)."/".$n;
echo'<hr/>';
foreach($account as $row){
	$sql="update mujur_account set agent='{$row[1]}' where username like '{$row[0]}';";
	echo $sql."<br/>";
}
//echo '<pre>'.print_r($account,1).'</pre>';

