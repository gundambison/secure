<?php
$name=$userlogin['detail']['firstname']." ".$userlogin['detail']['lastname']; 
?>
      <div class="main-left col-md-3">
        <div class="panel dark">
          <div class="row user-profile">
            <div class="col-xs-3"> <!--img src="images/avatar-1.jpg" alt=""--> </div>
            <div class="col-xs-9">
              <p class="text-large"><span class="text-small block">Hello,</span> <?=$name;?> </p>
              <div class="btn-group user-options clearfix"> <a class="btn btn-xs btn-transparent-grey dropdown-toggle" data-toggle="dropdown" href="#"> <span class=" text-extra-small"> <?=$userlogin['accountid'];?> </span>&nbsp;<i class="fa fa-caret-down" aria-hidden="true"></i> </a>
                <ul class="dropdown-menu dropdown-menu-left" aria-labelledby="drop2">
                  <li><a href="#">On Progress</a></li>
                  <li><a href="#">On Progress</a></li>
                  <li role="separator" class="divider"></li>
                  <li><a href="#">Separated link</a></li>
                </ul>
              </div>
              <a class="btn btn-transparent-grey btn-xs" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Account Management &nbsp;<i class="fa fa-cogs" aria-hidden="true"></i> </a> </div>
          </div>
          <div class="panel-body no-padding">
            <div class="collapse" id="collapseExample" aria-expanded="true" style="">
              <div class="list-group no-margin">
			  <a class="list-group-item no-radius" href="<?=base_url('member/detail');?>"> Detail</a>
			  <a class="list-group-item" href="<?=base_url('member/edit');?>#"> Edit Detail</a>
			  <a class="list-group-item" href="<?=base_url('member/uploads');?>"> Upload Document</a>
			  <a class="list-group-item" href="<?=base_url('member/editpassword');?>#">Edit Password</a> </div>
            </div>
          </div>
        </div>
		<?php /* Menu */
		$menu=2;
		if($menu==2){
			if(isset($detail)&&$detail['type']=='admin'){
				$this->load->view('depan/inc/menu_admin_new_view');
				$menuShow=1;
			}
			
			if(!isset($menuShow)){
				$this->load->view('depan/inc/menu_user_view');
			}
		}
		?>
      </div>
