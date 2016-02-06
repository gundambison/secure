<?php 
?>
<div class='container'>
    <div style='margin-top:30px;'>
	<a href="<?=base_url("member/listApi/normal");?>" >
		<input type='button' value='API' />
	</a>
	<a href="<?=base_url("member/listApi/deposit");?>" >
		<input type='button' value='Deposit' />
	</a>
	<a href="<?=base_url("member/listApi/widtdrawal");?>" >
		<input type='button' value='Widtdrawal' />
	</a>
	
<hr/>	
	<div id='preview'></div>
<table id="tableAPI" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
				<th>Date</th>
                <th>URL</th>
                <th>Param</th>
                 
                <th>Action</th>
            </tr>
        </thead>
		<tfooter>
            <tr>
				<th>Date</th>
                 <th>URL</th>
                <th>Param</th>
                 
                <th>Action</th>
            </tr>
        </tfooter>
</table>	

<script>
urlAPI="<?=base_url("member/data?type=api");?>";
urlDetail="<?=base_url("member/data");?>";
</script>	
</div></div>