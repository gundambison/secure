<!--liveTable_view-->
<table border=1>
<tr>
	<td>Account Number</td><td> : </td><td>&nbsp;<?=$result['userid'];?></td>
</tr>
<tr>
	<td>Account Username</td><td> : </td><td>&nbsp;<?=$result['username'];?></td>
</tr>
<tr>
	<td>Account Created</td><td> : </td><td>&nbsp;<?=date("d-m-Y");?></td>
</tr>
</table>
<!--pre><?php print_r($result); ?></pre-->