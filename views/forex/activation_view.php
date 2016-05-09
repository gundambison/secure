<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
if(!isset($post['kode'])){
?>
<form novalidate="novalidate" name="frm" id0="frm" id="frmLiveAccount" method="POST"  class="form-horizontal" role="form" action="<?=base_url("forex/activation/serialnumber");?>" style='display:none'>
<input type='text' name='kode' value='<?php 
$row=$this->forex->activationDetail($kode);

echo $row['code'];
?>' />
<input type='submit' value='lanjut' />
</form>
<script>
	document.getElementById("frmLiveAccount").submit();
</script>
<div style='margin:100px auto;width:300px'>PLEASE WAIT WHILE DIRECTING</div>
<?php 
}