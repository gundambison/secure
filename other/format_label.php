<style>
input{
	width:90%;
}
input[type="reset"]{
	height:30px;
}
input[type="button"]{
	height:50px;
}
#preview{
	margin:30px 0;
	padding:60px 10px 30px;
	border:1px blue solid;
}
</style>
<form>
<table width='90%' border=1>
<tr><td width='20%'>Nama</td><td><input type="text" id='name' /></td></tr>
<tr><td>Alamat</td><td><input id='adr' /></td></tr>
<tr><td>Kelurahan</td><td><input id='kel' /></td></tr>
<tr><td>RT/RW</td><td><input id='rt_rw' /></td></tr>
<tr><td>Kecamatan</td><td><input id='kec' /></td></tr>
<tr><td>Kabupaten</td><td><input id='kab' /></td></tr>
<tr><td>Kota</td><td><input id='kota' /></td></tr>
<tr><td>Kode Pos</td><td><input id='kodepos' /></td></tr>
<tr><td>Telp</td><td><input id='telp' /></td></tr>
<tr><td>Pesan Pelanggan</td><td><input id='message' /></td></tr>

</table>
<input type=reset value='reset' />
<input type=button value='generate' onclick='generateLabel()' />

</form>
<script>
var ar={};
function generateLabel(){
	document.getElementById('preview').innerHTML = '<br>Some new content!';
	clearHtml('preview');
	addHtml('preview','<table border=1 width=100%>');
	if(valDiv('name')!=''){
		addTable('Nama',valDiv('name'));
	}
	if(valDiv('adr')!=''){
		addTable('Alamat',valDiv('adr'));
	}
	if(valDiv('kel')!=''){
		addTable('Kelurahan',valDiv('kel'));
	}
	if(valDiv('rt_rw')!=''){
		addTable('Rt/Rw',valDiv('rt_rw'));
	}
	if(valDiv('kec')!=''){
		addTable('Kecamatan',valDiv('kec'));
	}
	if(valDiv('kab')!=''){
		addTable('Kabupaten',valDiv('kab'));
	}
	if(valDiv('kota')!=''){
		addTable('Kota',valDiv('kota'));
	}
	if(valDiv('kodepos')!=''){
		addTable('Kode Pos',valDiv('kodepos'));
	}
	if(valDiv('telp')!=''){
		addTable('Telepon/HP',valDiv('telp'));
	}
	if(valDiv('message')!=''){
		addTable('Pesan Pelanggan',valDiv('message'));
	}
	addHtml('preview','</table>');
	showHtml('preview');
}
function clearHtml(target){
	ar.target='';
	
}
function addHtml(target,txt){
//	document.getElementById(target).innerHTML += txt;
	if(ar.target ==undefined) ar.target='';
	ar.target  +=txt;
}
function addTable(name, values){
	addHtml('preview','<tr><td>'+name+'</td><td>:</td><td>'+values+'</td></tr>');
}
function valDiv(name){
	val = document.getElementById(name).value;
	return val;
}
function showHtml(target){
	document.getElementById(target).innerHTML = ar.target;
}
</script>
<!--
Nama : Budi
Alamat : Jl. Semangat Juang no.45
Kelurahan : Setia Budi
RT/RW : 01/07
Kecamatan: Cipinang
Kabupaten : Jakarta Pusat
Kota : DKI Jakarta
Kode Pos : 12345
Telp : 88889999
-->
<div id='preview'>

</div>