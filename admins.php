<?php
require_once 'main.php';
$title=' - '.$_ADMINS.' ';
require_once 'header.php';
require_once 'menu.php';
$admin = new ManageAdmins();
$task = new ManageTasks();
$admins_tasks = new ManageAdmins_Tasks();
$project = new ManageProjects();
$op= $_GET['op'];
echo '
<style type="text/css">
	.navbar {
		background-color: #007bff !important;
	}
</style>
';
switch ($op) {
	case 'add':
	$aidInfo=$ausername= $apass= $afname= $alname= $atel= $apic2= $aemail=$allow_add_project= $allow_edit_project= $allow_list_project= $allow_add_issues= $allow_edit_issues= $allow_list_issues= $allow_add_task= $allow_list_task= $allow_edit_task= $allow_delete_project= $allow_delete_task= $allow_delete_issues=$apic=$acomments=$tskid='';
	$aactive = 1;
	$agender = $asuper_admin = 0;
		if (isset($_POST['add'])) {
			$adminInfo=$admin->GetAdminInfo($_COOKIE['projo']);
			$cookie_admin= explode(':', $_COOKIE['projo']);
			if($admin->AdminPermission($cookie_admin[0],"asuper_admin"))
			{
				//--Upload Image
				if(!empty($_FILES['apic']['name']))
				{
					$whitelist = array("png", "jpg", "gif");
					if(!in_array(substr(basename($_FILES['apic']['name']),-3), $whitelist))
					{
						Toast('error', 'خطا', $_ADMIN_PIC_EXTENSION_ERROR);
					}
					else
					{
						if($_FILES['apic']['size']<($_IMAGE_SIZE*1024))
						{
							$imageinfo = getimagesize($_FILES['apic']['tmp_name']);
							if($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/png')
							{
								Toast('error', 'خطا', $_ADMIN_PIC_CONTENT_ERROR);
							}
							else
							{
								$uploaddir = 'img/admins/';
								$pic_name = $pic_prefix;
								$uploadfile = $uploaddir.$pic_name.'-'.substr(time(),-7).'.'.substr(basename($_FILES['apic']['name']),-3);
								if (move_uploaded_file($_FILES['apic']['tmp_name'], $uploadfile))
								{
									$apic = '-'.substr(time(),-7).'.'.substr(basename($_FILES['apic']['name']),-3);
								}
								else
								{
									Toast('error', 'خطا', $_ADMIN_PIC_UPLOAD_ERROR);
									$apic = "";
								}
							}
						}
						else
						{
							Toast('error', 'خطا', $_IMAGE_SIZE_ERROR);
						}
					}
				}
					//--Upload Image
				$ausername = $_POST['ausername'];
				$apass = $_POST['apass'];
				$aactive = $_POST['aactive'];
				$asuper_admin = $_POST['asuper_admin'];
				$afname = $_POST['afname'];
				$alname = $_POST['alname'];
				$agender = $_POST['agender'];
				$atel = $_POST['atel'];
				$aemail = $_POST['aemail'];
				$acomments = $_POST['acomments'];
				$tskids = (isset($_POST['tskids'])?$_POST['tskids']:'');
				$allow_add_project = (isset($_POST['allow_add_project'])?1:0);
				$allow_edit_project = (isset($_POST['allow_edit_project'])?1:0);
				$allow_list_project = (isset($_POST['allow_list_project'])?1:0);
				$allow_add_issues = (isset($_POST['allow_add_issues'])?1:0);
				$allow_edit_issues = (isset($_POST['allow_edit_issues'])?1:0);
				$allow_list_issues = (isset($_POST['allow_list_issues'])?1:0);
				$allow_add_task = (isset($_POST['allow_add_task'])?1:0);
				$allow_list_task = (isset($_POST['allow_list_task'])?1:0);
				$allow_edit_task = (isset($_POST['allow_edit_task'])?1:0);
				$allow_delete_project = (isset($_POST['allow_delete_project'])?1:0);
				$allow_delete_task = (isset($_POST['allow_delete_task'])?1:0);
				$allow_delete_issues = (isset($_POST['allow_delete_issues'])?1:0);
				if (empty($ausername) || empty($apass)) {
					Toast('error', 'خطا', $_FILL_IN_REQUIRED);
				} 
				else 
				{		
					if ($admin->Add($ausername, md5($apass), $aactive, $asuper_admin, $afname, $alname, $agender, $atel, $aemail, $apic, $acomments, $allow_add_project, $allow_edit_project, $allow_list_project, $allow_add_issues, $allow_edit_issues, $allow_list_issues, $allow_add_task, $allow_list_task, $allow_edit_task, $allow_delete_project, $allow_delete_task, $allow_delete_issues)==1) {
						Toast('success', 'موفق', _RECORD_ADDED_SUCCESSFULLI);
						$ausername= $apass= $afname= $alname= $atel= $aemail='';
						$aactive = 1;
						$agender = $asuper_admin = 0;
					}
					else{
						Toast('error', 'خطا', $_ADDING_RECORD_FAILED);
					}
				}
			}
			else{
					Toast('error', 'خطا', $_ACCESS_DENIED);
			}
		}
		elseif (isset($_GET['aid'])) {
			$aid= $_GET['aid'];
			if (isset($_POST['edit'])) {
				$adminInfo=$admin->GetAdminInfo($_COOKIE['projo']);
				$cookie_admin= explode(':', $_COOKIE['projo']);
				if($admin->AdminPermission($cookie_admin[0],"asuper_admin"))
				{
					//image admin
					$whitelist = array("png", "jpg", "gif");
					if (!empty($_POST['delpic'])) {
						$delpic = $_POST['delpic'];
					}
					else{
						$delpic = '';
					}
					if($delpic=="yes")
					{
						$admin->DelPic($aid);
						$apic = $apic2 = '';
					}
					if(!empty($_FILES['apic']['name']))
					{
						
						if(!in_array(substr(basename($_FILES['apic']['name']),-3), $whitelist))
						{
							Toast('error', 'خطا', $_ADMIN_PIC_EXTENSION_ERROR);
						}
						else
						{
							$imageinfo = getimagesize($_FILES['apic']['tmp_name']);
							if($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/png')
							{
								Toast('error', 'خطا', $_ADMIN_PIC_CONTENT_ERROR);
							}
							else
							{
								if($_FILES['apic']['size']<($_IMAGE_SIZE*1024))
								{
									$uploaddir = 'img/admins/';
									$pic_name = $pic_prefix;
									$uploadfile = $uploaddir .$pic_name.'-'.substr(time(),-7).'.'.substr(basename($_FILES['apic']['name']),-3);
									$admin->DelPic($aid);
									if (move_uploaded_file($_FILES['apic']['tmp_name'], $uploadfile))
									{
										$apic=$apic2='-'.substr(time(),-7).'.'.substr(basename($_FILES['apic']['name']),-3);
									}
									else
									{
										Failure($_ADMIN_PIC_UPLOAD_ERROR); 
										$apic = "";
									}
								}
								else
								{
									Toast('error', 'خطا', $_IMAGE_SIZE_ERROR);
									$apic = $apic2 = $_REQUEST['apic_temp'];
								}
							}
						}
						//--Upload Image
					}
					else
					{
						if(isset($_POST['delpic'])!="yes")
							$apic = $apic2 = $_REQUEST['apic_temp'];
					}
					$ausername = $_POST['ausername'];
					$aactive = $_POST['aactive'];
					$asuper_admin = $_POST['asuper_admin'];
					$afname = $_POST['afname'];
					$alname = $_POST['alname'];
					$agender = $_POST['agender'];
					$atel = $_POST['atel'];
					$aemail = $_POST['aemail'];
					$acomments = $_POST['acomments'];
					$allow_add_project = (isset($_POST['allow_add_project'])?1:0);
					$allow_edit_project = (isset($_POST['allow_edit_project'])?1:0);
					$allow_list_project = (isset($_POST['allow_list_project'])?1:0);
					$allow_add_issues = (isset($_POST['allow_add_issues'])?1:0);
					$allow_edit_issues = (isset($_POST['allow_edit_issues'])?1:0);
					$allow_list_issues = (isset($_POST['allow_list_issues'])?1:0);
					$allow_add_task = (isset($_POST['allow_add_task'])?1:0);
					$allow_list_task = (isset($_POST['allow_list_task'])?1:0);
					$allow_edit_task = (isset($_POST['allow_edit_task'])?1:0);
					$allow_delete_project = (isset($_POST['allow_delete_project'])?1:0);
					$allow_delete_task = (isset($_POST['allow_delete_task'])?1:0);
					$allow_delete_issues = (isset($_POST['allow_delete_issues'])?1:0);
					if($admin->Update($aid, $ausername, $aactive, $asuper_admin, $afname, $alname, $agender, $atel, $aemail, $apic, $acomments, $allow_add_project, $allow_edit_project, $allow_list_project, $allow_add_issues, $allow_edit_issues, $allow_list_issues, $allow_add_task, $allow_list_task, $allow_edit_task, $allow_delete_project, $allow_delete_task, $allow_delete_issues)==1 || !empty($tskids)){
						Toast('success', 'موفق', _RECORD_EDITED_SUCCESSFULLI);
					}
					else{
						Toast('error', 'خطا', _EDITING_RECORD_FAILED.' ('.$_NOT_CHANGED_RECORD.')');
					}
				}
				else{
						Toast('error', 'خطا', $_ACCESS_DENIED);
				}
			}
			$adminInfo = $admin->GetAdminInfoById($aid);
			$aidInfo = $adminInfo['aid'];
			$ausername = $adminInfo['ausername'];
			$aactive = $adminInfo['aactive'];
			$asuper_admin = $adminInfo['asuper_admin'];
			$afname = $adminInfo['afname'];
			$alname = $adminInfo['alname'];
			$agender = $adminInfo['agender'];
			$atel = $adminInfo['atel'];
			$aemail = $adminInfo['aemail'];
			$apic = $adminInfo['apic'];
			$apic2 = $adminInfo['apic'];
			$acomments = $adminInfo['acomments'];
			$allow_add_project = $adminInfo['allow_add_project'];
			$allow_edit_project = $adminInfo['allow_edit_project'];
			$allow_list_project = $adminInfo['allow_list_project'];
			$allow_add_issues = $adminInfo['allow_add_issues'];
			$allow_edit_issues = $adminInfo['allow_edit_issues'];
			$allow_list_issues = $adminInfo['allow_list_issues'];
			$allow_add_task = $adminInfo['allow_add_task'];
			$allow_list_task = $adminInfo['allow_list_task'];
			$allow_edit_task = $adminInfo['allow_edit_task'];
			$allow_delete_project = $adminInfo['allow_delete_project'];
			$allow_delete_task = $adminInfo['allow_delete_task'];
			$allow_delete_issues = $adminInfo['allow_delete_issues'];
			
		}
		echo '
		<div class="col-sm-12 col-md-12 jumbotron" id="content">';
		if ($permissions[0]['asuper_admin']==1) {
			$aid = (isset($_GET['aid'])?$_GET['aid']:'');
			if ($aid!=1 || $permissions[0]['aid']==1) {
		echo'
		<form method="post" enctype="multipart/form-data">';
			if (isset($_GET['aid'])) {
				echo '<p class="lead">'.$_EDIT.' '.$_ADMIN.'';
				AddLogo('?op=add', $_NEW);
				ListLogo('?op=list', $_LIST);
				echo '</p>';
			}
			else {
				echo '<p class="lead">'.$_ADD.' '.$_ADMIN.'';
				ListLogo('?op=list', $_LIST);
				echo '</p>';			
			}
			echo'
			
			
			<div class="row">
			  <div class="col-md-6">
			  	<div class="card card-default">
			  	  <div class="card-body">
					<div class="form-group">
						<label for="ausername">'.$_USERNAME.'<span class="required">*</span>: </label><br>
						<input autofocus="" type="text" class="form-control" id="ausername" name="ausername" value="'.$ausername.'" style="direction: ltr;">
					</div>';
					if (!isset($_GET['aid'])) {
						echo'
						<div class="form-group">
							<label for="apass">'.$_PASSWORD.'<span class="required">*</span>: </label><br>
							<input type="password" class="form-control" id="apass" name="apass" value="'.$apass.'" style="direction: ltr;">
						</div>';
					}
					if ($aidInfo!=1) {
					echo'
					<div class="form-group">
						<label for="aactive">'.$_CONDITION.': </label><br>
						<label class="radio-inline">
							<input type="radio" name="aactive" id="aactive0" value="0" '.($aactive==0?'checked':'').'> '.$_INACTIVE.'
						</label>
						<label class="radio-inline">
							<input type="radio" name="aactive" id="aactive1" value="1" '.($aactive==1?'checked':'').'> '.$_ACTIVE.'
						</label>
					</div>
					<div class="form-group">
						<label for="asuper_admin">'.$_GENERAL_MANAGER.'؟ </label><br>
						<label class="radio-inline">
							<input type="radio" name="asuper_admin" id="asuper_admin0" value="0" '.($asuper_admin==0?'checked':'').'> '.$_NO.'
						</label>
						<label class="radio-inline">
							<input type="radio" name="asuper_admin" id="asuper_admin1" value="1" '.($asuper_admin==1?'checked':'').'> '.$_YES.'
						</label>
					</div>';
					}
					echo'
					<div class="form-group">
						<label for="afname">'.$_NAME.': </label><br>
						<input type="text" class="form-control" id="afname" name="afname" value="'.$afname.'">
					</div>
					<div class="form-group">
						<label for="alname">'.$_FAMILI.': </label><br>
						<input type="text" class="form-control" id="alname" name="alname" value="'.$alname.'">
					</div>
					<div class="form-group">
						<label for="agender">'.$_GENDER.': </label><br>
						<label class="radio-inline">
						<input type="radio" name="agender" id="agender0" value="0" '.($agender==0?'checked':'').'> '.$_MAN.'
						</label>
						<label class="radio-inline">
						<input type="radio" name="agender" id="agender1" value="1" '.($agender==1?'checked':'').'> '.$_WOMAN.'
						</label>
					</div>
					<div class="form-group">
						<label for="atel">'.$_PHONE_NUMBER.': </label><br>
						<input type="tel" class="form-control" id="atel" name="atel" value="'.$atel.'" style="direction: ltr;">
					</div>
					<div class="form-group">
						<label for="aemail">'.$_EMAIL.': </label><br>
						<input type="email" class="form-control" id="aemail" name="aemail" value="'.$aemail.'" style="direction: ltr;">
					</div>
			  	  </div>
			  	</div>
			</div>
			  <div class="col-md-6">
				  <div class="card card-default">
					<div class="card-body">';
					if ($aidInfo!=1) {
						echo'
						<label>'.$_ACCESS_LEVEL.': </label>
						<label class="checkbox-inline">
							<input type="checkbox" onclick="checkAll(this)">'.$_SELECT_ALL.'
						</label><br><br>
						<span class="label label-info">'.$_PROJECT.'</span><br>
						<label class="checkbox-inline">
							<input type="checkbox" name="allow_add_project" value="1" '.($allow_add_project==1?'checked':'').'> '.$_ADD.' '.$_PROJECT.'
						</label>
						<label class="checkbox-inline">
							<input type="checkbox" name="allow_edit_project" value="1" '.($allow_edit_project==1?'checked':'').'> '.$_EDIT.' '.$_PROJECT.'
						</label>
						<label class="checkbox-inline">
							<input type="checkbox" name="allow_list_project" value="1" '.($allow_list_project==1?'checked':'').'> '.$_LIST.' '.$_PROJECT.'
						</label>
						<label class="checkbox-inline">
							<input type="checkbox" name="allow_delete_project" value="1" '.($allow_delete_project==1?'checked':'').'> '.$_DELETE.' '.$_PROJECT.'
						</label><br><br>
						<span class="label label-info">'.$_TASK.'</span><br>
						<label class="checkbox-inline">
							<input type="checkbox" name="allow_add_task" value="1" '.($allow_add_task==1?'checked':'').'> '.$_ADD.' '.$_TASK.'
						</label>
						<label class="checkbox-inline">
							<input type="checkbox" name="allow_list_task" value="1" '.($allow_list_task==1?'checked':'').'> '.$_LIST.' '.$_TASK.'
						</label>
						<label class="checkbox-inline">
							<input type="checkbox" name="allow_edit_task" value="1" '.($allow_edit_task==1?'checked':'').'> '.$_EDIT.' '.$_TASK.'
						</label>
						<label class="checkbox-inline">
							<input type="checkbox" name="allow_delete_task" value="1" '.($allow_delete_task==1?'checked':'').'> '.$_DELETE.' '.$_TASK.'
						</label><br><br>
						<span class="label label-info">'.$_ISSUE.'</span><br>
						<label class="checkbox-inline">
							<input type="checkbox" name="allow_add_issues" value="1" '.($allow_add_issues==1?'checked':'').'> '.$_ADD.' '.$_ISSUE.'
						</label>
						<label class="checkbox-inline">
							<input type="checkbox" name="allow_edit_issues" value="1" '.($allow_edit_issues==1?'checked':'').'> '.$_EDIT.' '.$_ISSUE.'
						</label>
						<label class="checkbox-inline">
							<input type="checkbox" name="allow_list_issues" value="1" '.($allow_list_issues==1?'checked':'').'> '.$_LIST.' '.$_ISSUE.'
						</label>
						<label class="checkbox-inline">
							<input type="checkbox" name="allow_delete_issues" value="1" '.($allow_delete_issues==1?'checked':'').'> '.$_DELETE.' '.$_ISSUE.'
						</label><br><br>';
					}
						echo'
						<div class="form-group">
							<label for="apic">'.$_AVATAR.':</label>';	
							if(isset($_REQUEST['aid']))
							{
								if(file_exists('img/admins/'.$pic_prefix.$apic.''))
								{
									echo '
									<br>
									<img src="img/admins/'.$pic_prefix.$apic.'" style="height:100px;">
									<br>
									<input type="checkbox" name="delpic" value="yes" id="delpic"><label for="delpic"> '.$_DELETE_IMAGE.'</label>
									';
								}
								else
									echo '
									<br>
									<img src="img/admin.png">';
							}
							echo '
							<input type="file" id="apic" name="apic" value="'.$apic.'" style="direction: ltr;">
						</div>
						<label for="acomments">'.$_COMMENTS.': </label><br>
						<textarea name="acomments" class="form-control editor" rows="3">'.$acomments.'</textarea><br>
						<input type="hidden" name="apic_temp" value="'.$apic2.'">
					</div>
				  </div>
				';
			if (isset($_GET['aid'])) {
				echo '
				<ul class="list-inline">
					<li class="left_list">
						'.UpdateForm('edit', $_UPDATE).'
					</li>';
					if ($aid != 1) {
						echo'
						<li>
							<a class="btn btn-link" onclick="return Sure();" style="color: red;" href="?op=delete&aid='.$aid.'">'.$_DELETE.'</a>
						</li>';
					}
				echo'
				</ul>
				';
			}
			else {
				echo '<div style="text-align:left;">';
				AddForm('add', $_ADD);
				echo'</div>';			
			}
			echo'
			  </div>
			</div>';
	        
        echo'
		</form>';
			}
			else{
				Failure($_ACCESS_DENIED);
			}
	}
	else{
		Failure($_ACCESS_DENIED);
	}
	echo'</div>';
		break;



	case 'list':
		$query=$q=$filter=$order="";
		$start=$page=0;
		if (isset($_POST['search']) && $_POST['q']!=="") 
		{
			$q= $_POST['q'];
			$filter= $_POST['filter'];
			$query= "WHERE $filter LIKE '%$q%'";
		}
		else{
			$order ="ORDER BY aid DESC";
		}
		if (isset($_POST['search'])) {
			$page_limit = $_POST['page_limit'];
			$page=$page=(isset($_POST['page'])?$_POST['page']:'');
			$start= $page*$page_limit;
		}
		if (isset($_GET['order'])) {
			$order = $_GET['order'];
			$order = "ORDER BY $order ".(isset($_GET['desc'])?'desc':'');
		}
		else{
			$_GET['order']='';
		}
		$adminlist= $admin->GetList($query, $order,$limit="LIMIT $start,$page_limit");
		$num_of_records=  $admin->RowCount($query);
		$num_of_pages= intval($num_of_records/$page_limit);
		$num_of_pages= ($num_of_records%$page_limit==0?$num_of_pages:$num_of_pages+1);
			echo '
			<div class="col-sm-12 col-md-12 jumbotron" id="content">';
			if ($permissions[0]['asuper_admin']==1) {
			echo'
			<div class="row">
			  <div class="col-md-3">
				<p class="lead">مدیران ';
				AddLogo('?op=add', $_NEW);
				echo'</p>
			  </div>
			  <div class="col-md-9">
				<form action="" method="post" class="form-inline">
					<div class="form-group">
						<input autofocus="" type="text" value="'.$q.'" class="form-control" id="q" name="q" placeholder="'.$_SEARCH_TEXT.'">
					</div>
					<select name="filter" class="form-control">
						<option '.($filter=="ausername"?'selected':'').' value="ausername">'.$_USERNAME.'</option>
						<option onclick="alert(\'  '.$_ACTIVE.': 1 / '.$_INACTIVE.' : 0\')" '.($filter=="aactive"?'selected':'').' value="aactive">'.$_CONDITION.'؟</option>
						<option onclick="alert(\'  '.$_GENERAL_MANAGER.': 1 / '.$_ADMIN.' : 0\')" '.($filter=="asuper_admin"?'selected':'').' value="asuper_admin">'.$_GENERAL_MANAGER.'</option>
						<option '.($filter=="afname"?'selected':'').' value="afname">'.$_NAME.'</option>
						<option '.($filter=="alname"?'selected':'').' value="alname">'.$_FAMILI.'</option>
						<option onclick="alert(\'  '.$_WOMAN.': 1 / '.$_MAN.' : 0\')" '.($filter=="agender"?'selected':'').' value="agender">'.$_GENDER.'</option>
						<option '.($filter=="atel"?'selected':'').' value="atel">'.$_PHONE_NUMBER.'</option>
						<option '.($filter=="aemail"?'selected':'').' value="aemail">'.$_EMAIL.'</option>
					</select>';
					if ($num_of_pages>1) {
						echo' '.$_PAGE_NUMBER.':<select name="page" class="form-control">';
						for ($i=0; $i < $num_of_pages; $i++) { 
							echo'
							<option value="'.$i.'"'.($i==$page?'selected':'').'>'.($i+1).'</option>
							';
						}
						echo '
							</select>';
					}
					echo'
				'.$_NUMBER_OF_ADMINS_PER_PAGE.':
				<select class="form-control" id="page_limit" name="page_limit">
					<option '.($page_limit=="5"?'selected':'').' value="5">5</option>
					<option '.($page_limit=="10"?'selected':'').' value="10">10</option>
					<option '.($page_limit=="20"?'selected':'').' value="20">20</option>
					<option '.($page_limit=="50"?'selected':'').' value="50">50</option>
					<option '.($page_limit=="100"?'selected':'').' value="100">100</option>
				</select>
				 <button type="submit" name="search" class="btn btn-default">'.$_SEARCH.'</button>
				</form><br>
			  </div>
		  	</div>
			<div class="table-responsive" width="1500px">
				<table class="table table-bordered table-hover table-striped">
					<tr class="table_header info">
						<th width="30px">'.$_TOOLS.'</th>
						<th width="300px">
							<a href="?op=list&order=ausername'.(isset($_GET['desc'])?'':'&desc').'">'.$_USERNAME.'
								<span class="fas fa-collapse'.($_GET['order']=='ausername' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
							</a></th>
						<th width="30px">
							<a href="?op=list&order=aactive'.(isset($_GET['desc'])?'':'&desc').'">'.$_CONDITION.'؟
								<span class="fas fa-collapse'.($_GET['order']=='aactive' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
							</a></th>
						<th width="30px">
							<a href="?op=list&order=asuper_admin'.(isset($_GET['desc'])?'':'&desc').'">'.$_GENERAL_MANAGER.'
								<span class="fas fa-collapse'.($_GET['order']=='asuper_admin' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
							</a></th>
						<th width="100px">
							<a href="?op=list&order=afname'.(isset($_GET['desc'])?'':'&desc').'">'.$_NAME.'
								<span class="fas fa-collapse'.($_GET['order']=='afname' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
							</a></th>
						<th width="100px">
							<a href="?op=list&order=alname'.(isset($_GET['desc'])?'':'&desc').'">'.$_FAMILI.'
								<span class="fas fa-collapse'.($_GET['order']=='alname' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
							</a></th>
						<th width="30px">
							<a href="?op=list&order=agender'.(isset($_GET['desc'])?'':'&desc').'">'.$_GENDER.'
								<span class="fas fa-collapse'.($_GET['order']=='agender' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
							</a></th>
						<th width="100px">
							<a href="?op=list&order=atel'.(isset($_GET['desc'])?'':'&desc').'">'.$_PHONE_NUMBER.'
								<span class="fas fa-collapse'.($_GET['order']=='atel' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
							</a></th>
						<th width="100px">
							<a href="?op=list&order=aemail'.(isset($_GET['desc'])?'':'&desc').'">'.$_EMAIL.'
								<span class="fas fa-collapse'.($_GET['order']=='aemail' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
							</a></th>
						<th width="30px">
							<a href="?op=list&order=apic'.(isset($_GET['desc'])?'':'&desc').'">'.$_AVATAR.'
								<span class="fas fa-collapse'.($_GET['order']=='apic' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
							</a></th>
						<th width="200px">
							<a href="?op=list&order=acomments'.(isset($_GET['desc'])?'':'&desc').'">'.$_COMMENTS.'
								<span class="fas fa-collapse'.($_GET['order']=='acomments' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
							</a></th>
						<th width="30px">
							<a href="?op=list&order=allow_add_project'.(isset($_GET['desc'])?'':'&desc').'">'.$_ADD.' '.$_PROJECT.'
								<span class="fas fa-collapse'.($_GET['order']=='allow_add_project' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
							</a></th>
						<th width="30px">
							<a href="?op=list&order=allow_edit_project'.(isset($_GET['desc'])?'':'&desc').'">'.$_EDIT.' '.$_PROJECT.'
								<span class="fas fa-collapse'.($_GET['order']=='allow_edit_project' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
							</a></th>
						<th width="30px">
							<a href="?op=list&order=allow_list_project'.(isset($_GET['desc'])?'':'&desc').'">'.$_LIST.' '.$_PROJECT.'
								<span class="fas fa-collapse'.($_GET['order']=='allow_list_project' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
							</a></th>
						<th width="30px">
							<a href="?op=list&order=allow_delete_project'.(isset($_GET['desc'])?'':'&desc').'">'.$_DELETE.' '.$_PROJECT.'
								<span class="fas fa-collapse'.($_GET['order']=='allow_delete_project' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
							</a></th>
						<th width="30px">
							<a href="?op=list&order=allow_add_issues'.(isset($_GET['desc'])?'':'&desc').'">'.$_ADD.' '.$_ISSUE.'
								<span class="fas fa-collapse'.($_GET['order']=='allow_add_issues' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
							</a></th>
						<th width="30px">
							<a href="?op=list&order=allow_edit_issues'.(isset($_GET['desc'])?'':'&desc').'">'.$_EDIT.' '.$_ISSUE.'
								<span class="fas fa-collapse'.($_GET['order']=='allow_edit_issues' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
							</a></th>
						<th width="30px">
							<a href="?op=list&order=allow_list_issues'.(isset($_GET['desc'])?'':'&desc').'">'.$_LIST.' '.$_ISSUE.'
								<span class="fas fa-collapse'.($_GET['order']=='allow_list_issues' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
							</a></th>
						<th width="30px">
							<a href="?op=list&order=allow_delete_issues'.(isset($_GET['desc'])?'':'&desc').'">'.$_DELETE.' '.$_ISSUE.'
								<span class="fas fa-collapse'.($_GET['order']=='allow_delete_issues' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
							</a></th>
						<th width="30px">
							<a href="?op=list&order=allow_add_task'.(isset($_GET['desc'])?'':'&desc').'">'.$_ADD.' '.$_TASK.'
								<span class="fas fa-collapse'.($_GET['order']=='allow_add_task' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
							</a></th>
						<th width="30px">
							<a href="?op=list&order=allow_list_task'.(isset($_GET['desc'])?'':'&desc').'"> '.$_LIST.' '.$_TASK.'
								<span class="fas fa-collapse'.($_GET['order']=='allow_list_task' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
							</a></th>
						<th width="30px">
							<a href="?op=list&order=allow_edit_task'.(isset($_GET['desc'])?'':'&desc').'">'.$_EDIT.' '.$_TASK.'
								<span class="fas fa-collapse'.($_GET['order']=='allow_edit_task' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
							</a></th>
						<th width="30px">
							<a href="?op=list&order=allow_delete_task'.(isset($_GET['desc'])?'':'&desc').'">'.$_DELETE.' '.$_TASK.'
								<span class="fas fa-collapse'.($_GET['order']=='allow_delete_task' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
							</a></th>
					</tr>
			';
			foreach ($adminlist as $adminInfo) {
				echo '
					<tr class="">
						<td>
							<div style="text-align:rtl;" dir="rtl">
								<!-- Extra small button group -->
								<div class="dropdown">
									<button class="btn btn-primary btn-sm dropdown-toggle no-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									  	<span class="fas fa-bars"></span>
									</button>
									<div class="dropdown-menu">
										';
										if ($adminInfo['aid'] != 1 || $permissions[0]['aid']==1) {
											echo'
											<a  class="dropdown-item" href="?op=add&aid='.$adminInfo['aid'].'">'.$_EDIT.'</a>
											';
										}
										if ($adminInfo['aid'] != 1 && $permissions[0]['aid']!=$adminInfo['aid']) {
											echo'
											<a  class="dropdown-item" onclick="return Sure();" style="color: red;" href="?op=delete&aid='.$adminInfo['aid'].'">'.$_DELETE.'</a>
											';
										}
										echo'
										';
										if ($adminInfo['aid'] != 1 || $permissions[0]['aid']==1) {
											echo'
											<a  class="dropdown-item" href="javascript:reset_password('.$adminInfo['aid'].')"> '.$_CHANGE.' '.$_PASSWORD.'</a>
											';
										}
										echo'
									</div>
								</div>

								<script type="text/javascript">
									function reset_password(id){
										$("#new_pass_aid").val(id);
										$("#reset_admin_pass").modal()
									}
									function reset_password_hide(){
										document.getElementById(\'reset_admin_pass\').style.display = "none";
									}
								</script>
								<div class="modal fade" id="reset_admin_pass">
								  <div class="modal-dialog">
								    <div class="modal-content">
								        <form action="?op=reset" method="post" name="reset_student_pass">
									      <div class="modal-header">
									        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									        <h4 class="modal-title">'.$_CHANGE.' '.$_PASSWORD.'</h4>
									      </div>
									      <div class="modal-body">
												'.$_NEW_PASSWORD.':<br>
												<center><input type="password" name="new_pass" class="input" id="new_pass" style="direction:ltr;"><br>
												<input type="hidden" class="form-control" name="new_pass_aid" id="new_pass_aid" value="">
									      </div>
									      <div class="modal-footer">
									        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									        <button type="submit" class="btn btn-primary">'.$_UPDATE.'</button>
									      </div>
									    </div><!-- /.modal-content -->
										</form>
								  </div><!-- /.modal-dialog -->
								</div><!-- /.modal -->
							</div>
						</td>
						<td style="text-align: left;"><strong>'.$adminInfo['ausername'].'</strong></td>
						<td style="text-align:center;">
							<i class="fal fa-'.($adminInfo['aactive']==1?'check text-success':'times text-danger').'"></i>
						</td>
						<td style="text-align:center;">
							<i class="fal fa-'.($adminInfo['asuper_admin']==1?'check text-success':'times text-danger').'"></i>
						</td>
						<td>'.$adminInfo['afname'].'</td>
						<td>'.$adminInfo['alname'].'</td>
						<td style="text-align:center;">'.($adminInfo['agender']==1?''.$_WOMAN.'':''.$_MAN.'').'</td>
						<td style="text-align: left;">'.$adminInfo['atel'].'</td>
						<td style="text-align: left;">'.$adminInfo['aemail'].'</td>';
						if(file_exists('img/admins/'.$pic_prefix.$adminInfo['apic'].''))
							$apic = 'img/admins/'.$pic_prefix.$adminInfo['apic'].'';
						else
							$apic = 'img/admin.png';
							
						echo '<td style="text-align:center;">
							<img src="'.$apic.'" style="height:30px;" />
							</td>
						<td>'.$adminInfo['acomments'].'</td>
						<td style="text-align:center;">
							<i class="fal fa-'.($adminInfo['allow_add_project']==1?'check text-success':'times text-danger').'"></i>
						</td>
						<td style="text-align:center;">
							<i class="fal fa-'.($adminInfo['allow_edit_project']==1?'check text-success':'times text-danger').'"></i>
						</td>
						<td style="text-align:center;">
							<i class="fal fa-'.($adminInfo['allow_list_project']==1?'check text-success':'times text-danger').'"></i>
						</td>
						<td style="text-align:center;">
							<i class="fal fa-'.($adminInfo['allow_delete_project']==1?'check text-success':'times text-danger').'"></i>
						</td>
						<td style="text-align:center;">
							<i class="fal fa-'.($adminInfo['allow_add_issues']==1?'check text-success':'times text-danger').'"></i>
						</td>
						<td style="text-align:center;">
							<i class="fal fa-'.($adminInfo['allow_edit_issues']==1?'check text-success':'times text-danger').'"></i>
						</td>
						<td style="text-align:center;">
							<i class="fal fa-'.($adminInfo['allow_list_issues']==1?'check text-success':'times text-danger').'"></i>
						</td>
						<td style="text-align:center;">
							<i class="fal fa-'.($adminInfo['allow_delete_issues']==1?'check text-success':'times text-danger').'"></i>
						</td>
						<td style="text-align:center;">
							<i class="fal fa-'.($adminInfo['allow_add_task']==1?'check text-success':'times text-danger').'"></i>
						<td style="text-align:center;">
							<i class="fal fa-'.($adminInfo['allow_list_task']==1?'check text-success':'times text-danger').'"></i>
						<td style="text-align:center;">
							<i class="fal fa-'.($adminInfo['allow_edit_task']==1?'check text-success':'times text-danger').'"></i>
						<td style="text-align:center;">
							<i class="fal fa-'.($adminInfo['allow_delete_task']==1?'check text-success':'times text-danger').'"></i>
						</td>
					</tr>
				</div>
				';
				}
			}
		else{
		   	Failure($_ACCESS_DENIED);
		}
		break;
		case 'delete':
			if (isset($_GET['aid'])) {
				$adminInfo=$admin->GetAdminInfo($_COOKIE['projo']);
				$cookie_admin= explode(':', $_COOKIE['projo']);
				if($admin->AdminPermission($cookie_admin[0],"asuper_admin"))
				{
					if ($adminInfo['aid'] !=1) {
						if ($admin->Delete($_GET['aid'])) 
						{
							Success($_RECORD_DELETED_SUCCESSFULLI);
						}
						else
						{
							Failure($_DELETING_RECORD_FAILED);
						}
					}
					else{
						Failure($_ACCESS_DENIED);
					}
				}
				else{
						Toast('error', 'خطا', $_ACCESS_DENIED);
				}
				echo '<a href="admins.php?op=list"><input type="submit" name="backlist" class="btn btn-primary" value="'.$_BACK_TO_LIST.'"></a>';
			}
			break;
		case 'reset':
		echo '
		<div class="col-sm-12 col-md-12 jumbotron" id="content">';
			echo " ";
			$aid = $_POST['new_pass_aid'];
			$apass = $_POST['new_pass'];
			if ($permissions[0]['asuper_admin']==1) {
				$adminInfo = $admin->GetAdminInfo($aid);
				$adminId = $adminInfo['aid'];
				if ($aid==1 && $adminid==1) {
					Failure($_CHANGING_PASSWORD_FAILED);
				}
				else{
					if ($admin->ResetPassword($aid,$apass)==1) {
						Success($_CHANGED_PASSWORD_SUCCESSFULLI);
					}
					else{
						Failure($_INSERT_NEW_PASSWORD);
					}

				}
			}
			else{
				Failure($_ACCESS_DENIED);
			}
		echo '<a href="admins.php?op=list"><input type="submit" name="backlist" class="btn btn-primary" value="'.$_BACK_TO_LIST.'"></a>';
		echo'</div>';
			break;
	
	default:
	echo '<div class="col-sm-12 col-md-12 jumbotron" id="content">';
		Info('مسیر را اشتباه وارد کردید لطفا دوباره بررسی کنید');
	echo'</div>';
		break;
}
require_once 'footer.php';
?>