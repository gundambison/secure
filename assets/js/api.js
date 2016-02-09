jQuery(document).ready(function() {
try{	
    jQuery('#tableAPI').DataTable( {
		"columnDefs": [
            {
                // The `data` parameter refers to the data for the cell (defined by the
                // `data` option, which defaults to the column being worked with, in
                // this case `data: 0`.
                "render": function ( data, type, row ) { 
                    return '<input type="button"  value="detail" onclick="detail('+ row.id+')" />';
					
                },
                "targets": 3
            }
		],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": urlAPI,
            "type": "POST"
        },
        "columns": [			
			{ "data": "created"},
            { "data": "url" },
            { "data": "param" },
        ]
    } );
}
catch(err){
	console.log('not tableAPI');
}

try{	
	tableDeposit=jQuery('#tableDeposit').DataTable( {
		"columnDefs": [
            { 
			
            }
		],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": urlAPI,
            "type": "POST"
        },
        "columns": [
			{ "data": "created"},
			{ "data": "flowid"},
            { "data": "raw.username" },
            { "data": "raw.name" },
            { "data": "raw.orderDeposit" },
            { "data": "status" },
            { "data": "action" },             
        ]
    } );
	console.log('table deposit ready');
}
catch(err){
	console.log('not table Deposit');
}	

try{	
	tableWidtdrawal=jQuery('#tableWidtdrawal').DataTable( {
		"columnDefs": [
            { 
			
            }
		],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": urlAPI,
            "type": "POST"
        },
        "columns": [
			{ "data": "created"},
			{ "data": "flowid"},
            { "data": "raw.username" },
            { "data": "raw.name" },
            { "data": "raw.orderWidtdrawal" },
            { "data": "status" },
            { "data": "action" },             
        ]
    } );
	console.log('table widtdrawal ready');
}
catch(err){
	console.log('not table Widtdrawal');
}	
 	
} );
 
function detail(id){
	params={id:id,type:"apiDetail"}
	respon=sendAjax( urlDetail,params);
	respon.success(function(result,status) {
		if(result.status==true){ 
			jQuery(".modal-title").html(result.data.title);
			jQuery(".modal-body").html(result.data.html);
		}else{
			jQuery(".modal-title").html("WARNING");
			jQuery(".modal-body").html(result.message);
			
		}
		
		//jQuery("#myModal").modal({show: true}).css("height","150%");	
		jQuery("#preview").html(result.data.html);
		console.log("success");	console.log(result);			
	});
	respon.error(function(xhr,status,msg){			
			console.log("Error");
			console.log(status);
			console.log(msg);
			console.log(xhr);
			
	});
}

//===============DEPOSIT
function depositApprove(id){	
	params={status:"approve",id:id}
	url=urlData+"?type=depositProcess";
	respon=sendAjax(url,params);
	respon.success(function(result,status) {
		tableDeposit.draw();
		console.log('approve');
	});
	
}

function depositCancel(id){	
	params={status:"cancel",id:id}
	url=urlData+"?type=depositProcess";
	respon=sendAjax(url,params);
	respon.success(function(result,status) {
		tableDeposit.draw();
		console.log('cancel');
	});
	
}
//===============Widthdrawal
function widtdrawalApprove(id){
	console.log('approve');
	params={status:"approve",id:id}
	url=urlData+"?type=widtdrawalProcess";
	respon=sendAjax(url,params);
	respon.success(function(result,status) {
		tableWidtdrawal.draw();
	});
	
}

function widtdrawalCancel(id){
	console.log('cancel');
	params={status:"cancel",id:id}
	url=urlData+"?type=widtdrawalProcess";
	respon=sendAjax(url,params);
	respon.success(function(result,status) {
		tableWidtdrawal.draw();
	});
	
}