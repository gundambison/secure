<div class='container'><div style='margin-top:30px;background:white'>
        <form novalidate="novalidate" name="frm" id0="frm" id="frmLiveAccount" method="POST" onsubmit="return validate(this);" class="form-horizontal" role="form">
          <script>
			$(document).ready( function() {
			  $('#act_type').bind('change', function (e) { 
			    if( $('#act_type').val() == '4') {
				  $('#reason').hide();
				  $('#decision').show();
			    }
			    else {
			      $('#reason').show();
				  $("#reason").css({ display: "inline-block" });
				  $('#decision').hide();
			    }         
			  }).trigger('change');
			});
		 </script> 
		  
          <div class="form-group">
            <label class="col-sm-3 control-label"><strong>Account Type :</strong></label>
            <div class="col-sm-5">
              <select name="act_type" id="act_type" class="form-control">
                <option value="">-- Select account type --</option>
					
	                <option value="1">CENT</option>
					
	                <option value="2">MINI FIXED</option>
					
	                <option value="3">MINI S</option>
					
	                <option value="4">STANDARD</option>
					
              </select>
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-3 control-label"><strong>Leverage :</strong></label>
            
            <div class="col-sm-5" id="decision" style="display: none;">
              <select name="leverage17" id="leverage17" class="form-control">
                <option value="">-- Select leverage --</option>
				                <option value="1">1:1</option>
                                <option value="2">1:2</option>
                                <option value="3">1:3</option>
                                <option value="5">1:5</option>
                                <option value="10">1:10</option>
                                <option value="15">1:15</option>
                                <option value="20">1:20</option>
                                <option value="25">1:25</option>
                                <option value="33">1:33</option>
                                <option value="50">1:50</option>
                                <option value="66">1:66</option>
                                <option value="75">1:75</option>
                                <option value="100">1:100</option>
                                <option value="125">1:125</option>
                                <option value="150">1:150</option>
                                <option value="175">1:175</option>
                                <option value="200">1:200</option>
                              </select>
            </div>
            
            <div class="col-sm-5" id="reason" style="display: inline-block;">
              <select name="leverage" id="leverage" class="form-control">
                <option value="">-- Select leverage --</option>
                                <option value="1">1:1</option>
                                <option value="2">1:2</option>
                                <option value="3">1:3</option>
                                <option value="5">1:5</option>
                                <option value="10">1:10</option>
                                <option value="15">1:15</option>
                                <option value="20">1:20</option>
                                <option value="25">1:25</option>
                                <option value="33">1:33</option>
                                <option value="50">1:50</option>
                                <option value="66">1:66</option>
                                <option value="75">1:75</option>
                                <option value="100">1:100</option>
                                <option value="125">1:125</option>
                                <option value="150">1:150</option>
                                <option value="175">1:175</option>
                                <option value="200">1:200</option>
                                <option value="300">1:300</option>
                                <option value="400">1:400</option>
                                <option value="500">1:500</option>
                                <option value="1000">1:1000</option>
                              </select>
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-3 control-label"></label>
            <div class="col-sm-5">
              <input name="check" id="check" onchange="myfunction();" type="checkbox">
              Generate Trader's Password Automatically </div>
          </div>
          <div class="form-group" id="hid2" style="display:none">
            <label class="col-sm-3 control-label"></label>
            <div class="col-sm-5" id="pass"> </div>
          </div>
          <div class="form-group" id="hid">
            <label class="col-sm-3 control-label"><strong>Trader's Password :</strong></label>
            <div class="col-sm-5">
              <input name="password" id="password" class="form-control" type="password"><span id="password_Warn" class="err"></span>
            </div>
          </div>
          <div class="form-group" id="hid1">
            <label class="col-sm-3 control-label"><strong>Confirm Password :</strong></label>
            <div class="col-sm-5">
              <input name="confirm_password" id="confirm_password" class="form-control" type="password">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label"></label>
            <div class="col-sm-5">
              <input name="check1" id="check1" onchange="myfunction1();" type="checkbox">
              Generate Investor's Password Automatically </div>
          </div>
          <div class="form-group" id="investor2" style="display:none">
            <label class="col-sm-3 control-label"></label>
            <div class="col-sm-5" id="investor_pass"> </div>
          </div>
          <div class="form-group" id="investor">
            <label class="col-sm-3 control-label"><strong>Investor's Password :</strong></label>
            <div class="col-sm-5">
              <input name="investor_password" id="investor_password" class="form-control" type="password">
            </div>
          </div>
          <div class="form-group" id="investor1">
            <label class="col-sm-3 control-label"><strong>Confirm Password :</strong></label>
            <div class="col-sm-5">
              <input name="confirm_investor_password" id="confirm_investor_password" class="form-control" type="password">
            </div>
          </div>
          <script type="text/javascript" language="javascript">
function myfunction(){

  var element = document.getElementById('check');
  var emp = document.getElementById('hid');
  
   
  if(element.checked==true)
  {
   /*emp.disable='none';*/
   var chars = "ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
  var uppercase = "ABCDEFGHIJKLMNOPQRSTUVWXTZ";
  var lowercase = "abcdefghiklmnopqrstuvwxyz";
  var numerics = "1234567890";
  var string_length = 8;
  var randomstring = '';
  var charCount = 0;
  var numCount = 0;

for (var i=0; i<string_length; i++) {
if(i<6) {
    var rnum = Math.floor(Math.random() * uppercase.length);
        randomstring += uppercase.substring(rnum,rnum+1);
        i += 1;
    
    var rnum = Math.floor(Math.random() * lowercase.length);
        randomstring += lowercase.substring(rnum,rnum+1);
        i += 1;
    
    var rnum = Math.floor(Math.random() * numerics.length);
        randomstring += numerics.substring(rnum,rnum+1);
        i += 1;
  } else {
    var rnum = Math.floor(Math.random() * chars.length);
        randomstring += chars.substring(rnum,rnum+1);
        charCount += 1;
  }
}

  document.getElementById("hid2").style.display="block";
  document.getElementById("password").readOnly = true;
  document.getElementById("confirm_password").readOnly = true;
  document.getElementById("pass").innerHTML = randomstring;
  document.getElementById("password").value = randomstring;
  document.getElementById("confirm_password").value = randomstring;
  
   }
 else if(element.checked==false){
  
   /* emp.style.display='block';*/
   document.getElementById("hid2").style.display="none";
  document.getElementById("pass").innerHTML = '';
     document.getElementById("password").readOnly = false;
  document.getElementById("confirm_password").readOnly = false;
  document.getElementById("password").value = '';
  document.getElementById("confirm_password").value = '';
   document.frm.password.value='';
   document.frm.confirm_password.value = '';
  
}
}

function myfunction1(){
  var element = document.getElementById('check1');
  var emp = document.getElementById('investor');
  
  if(element.checked==true)
  {
   /*emp.disable='none';*/
    var chars = "ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
  var uppercase = "ABCDEFGHIJKLMNOPQRSTUVWXTZ";
  var lowercase = "abcdefghiklmnopqrstuvwxyz";
  var numerics = "1234567890";
  var string_length = 8;
  var randomstring = '';
  var charCount = 0;
  var numCount = 0;

for (var i=0; i<string_length; i++) {
if(i<6) {
    var rnum = Math.floor(Math.random() * uppercase.length);
        randomstring += uppercase.substring(rnum,rnum+1);
        i += 1;
    
    var rnum = Math.floor(Math.random() * lowercase.length);
        randomstring += lowercase.substring(rnum,rnum+1);
        i += 1;
    
    var rnum = Math.floor(Math.random() * numerics.length);
        randomstring += numerics.substring(rnum,rnum+1);
        i += 1;
  } else {
    var rnum = Math.floor(Math.random() * chars.length);
        randomstring += chars.substring(rnum,rnum+1);
        charCount += 1;
  }
}
  document.getElementById("investor2").style.display="block";
  document.getElementById("investor_password").readOnly = true;
  document.getElementById("confirm_investor_password").readOnly = true;
  document.getElementById("investor_pass").innerHTML = randomstring;
  document.getElementById("investor_password").value = randomstring;
  document.getElementById("confirm_investor_password").value = randomstring;
  
  
   }
else if(element.checked==false){
   /* emp.style.display='block';*/
   document.getElementById("investor2").style.display="none";
   
   document.getElementById("investor_pass").innerHTML = '';
   document.getElementById("investor_password").readOnly = false;
  document.getElementById("confirm_investor_password").readOnly = false;
   document.frm.investor_password.value='';
   document.frm.confirm_investor_password.value = '';
}
}
</script>
<div class="form-group">
            <label class="col-sm-3 control-label"></label>
            <div class="col-sm-5">
          <input name="submit" id="submit" value="Open Account" class="btn btn-info" type="button" onclick="createLiveUser()" >
          </div></div>
        </form>
</div></div>              