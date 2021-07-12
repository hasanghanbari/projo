<?php 
require_once 'main.php';
require_once 'header.php';
$op = $_GET['op'];
$project = new ManageProjects();
$task = new ManageTasks();
$admins_tasks = new ManageAdmins_Tasks();
	switch ($_GET['op']) {
		case 'add':
			require_once 'menu.php';
			$prjcode= $prjtitle= $prjdesc= $prjlogo= $prjlogo2= $prjcomments= '';
			$legend = ''.$_ADD.' '.$_PROJECT.'';
			if (isset($_POST['add'])) {
				//--Upload Image
				if(!empty($_FILES['prjlogo']['name']))
				{
					$whitelist = array("png", "jpg", "gif");
					if(!in_array(substr(basename($_FILES['prjlogo']['name']),-3), $whitelist))
					{
						Toast('error', 'خطا', $_ADMIN_PIC_EXTENSION_ERROR);
					}
					else
					{
						if($_FILES['prjlogo']['size']<($_IMAGE_SIZE*1024))
						{
							$imageinfo = getimagesize($_FILES['prjlogo']['tmp_name']);
							if($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/png')
							{
								Toast('error', 'خطا', $_ADMIN_PIC_CONTENT_ERROR);
							}
							else
							{
								$uploaddir = 'img/project/';
								$pic_name = $pic_prefix;
								$uploadfile = $uploaddir.$pic_name.'-'.substr(time(),-7).'.'.substr(basename($_FILES['prjlogo']['name']),-3);
								if (move_uploaded_file($_FILES['prjlogo']['tmp_name'], $uploadfile))
								{
									$prjlogo = '-'.substr(time(),-7).'.'.substr(basename($_FILES['prjlogo']['name']),-3);
								}
								else
								{
									Toast('error', 'خطا', $_ADMIN_PIC_UPLOAD_ERROR);
									$prjlogo = "";
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
				$prjcode = $_POST['prjcode'];
				$prjtitle = $_POST['prjtitle'];
				$prjdesc = $_POST['prjdesc'];
				$prjcomments = $_POST['prjcomments'];
				$aid=1;
				if (empty($prjcode) || empty($prjtitle)) {
					Toast('error', 'خطا', $_FILL_IN_REQUIRED );
				} 
				else 
				{		
					if ($permissions[0]['allow_add_project']==1) {
						if (preg_match('/^[اآبپتثئجچحخدذرزژسشصضطظعغفقکگلمنوهی\s]+$/', $prjcode)==1 || strpos($prjcode, " ")!==false) {
					        Toast('error', 'خطا', $_INVALID_CODE);
					    }
					    else{
							if ($project->Add($prjcode, $prjtitle, $prjdesc, $prjlogo, $prjcomments, $aid)==1) {
								Toast('success', 'موفق', $_RECORD_ADDED_SUCCESSFULLI);
								$prjcode= $prjtitle= $prjdesc= $prjlogo= $prjcomments= '';
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
			}
			elseif (isset($_GET['prjid'])) {
				$prjid= $_GET['prjid'];
				if (isset($_POST['edit'])) {
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
							$project->DelPic($prjid);
							$prjlogo = $prjlogo2 = '';
						}
						if(!empty($_FILES['prjlogo']['name']))
						{
							
							if(!in_array(substr(basename($_FILES['prjlogo']['name']),-3), $whitelist))
							{
								Toast('error', 'خطا', $_ADMIN_PIC_EXTENSION_ERROR);
							}
							else
							{
								$imageinfo = getimagesize($_FILES['prjlogo']['tmp_name']);
								if($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/png')
								{
									Toast('error', 'خطا', $_ADMIN_PIC_CONTENT_ERROR);
								}
								else
								{
									if($_FILES['prjlogo']['size']<($_IMAGE_SIZE*1024))
									{
										$uploaddir = 'img/project/';
										$pic_name = $pic_prefix;
										$uploadfile = $uploaddir .$pic_name.'-'.substr(time(),-7).'.'.substr(basename($_FILES['prjlogo']['name']),-3);
										$project->DelPic($prjid);
										if (move_uploaded_file($_FILES['prjlogo']['tmp_name'], $uploadfile))
										{
											$prjlogo = $prjlogo2 = '-'.substr(time(),-7).'.'.substr(basename($_FILES['prjlogo']['name']),-3);
										}
										else
										{
											Toast('error', 'خطا', $_ADMIN_PIC_UPLOAD_ERROR);
											$prjlogo = "";
										}
									}
									else
									{
										$prjlogo = $prjlogo2 = $_REQUEST['prjlogo_temp'];
										Toast('error', 'خطا', $_IMAGE_SIZE_ERROR);
									}
								}
							}
							//--Upload Image
						}
						else
						{
							if($_POST['delpic']!="yes")
								$prjlogo = $prjlogo2 = $_REQUEST['prjlogo_temp'];
						}
						
						$prjcode = $_POST['prjcode'];
						$prjtitle = $_POST['prjtitle'];
						$prjdesc = $_POST['prjdesc'];
						$prjcomments = $_POST['prjcomments'];
						$aid = 1;
						if ($permissions[0]['allow_edit_project']==1) {
							if (preg_match('/^[اآبپتثئجچحخدذرزژسشصضطظعغفقکگلمنوهی\s]+$/', $prjcode)==1 || strpos($prjcode, " ")!==false) {
								Toast('error', 'خطا', $_INVALID_CODE);
						    }
						    else{
								if($project->Update($prjid, $prjcode, $prjtitle, $prjdesc, $prjlogo, $prjcomments, $aid)==1){
									Toast('success', 'موفق', $_RECORD_EDITED_SUCCESSFULLI);
								}
								else{
									Toast('error', 'خطا', $_EDITING_RECORD_FAILED.' ('.$_NOT_CHANGED_RECORD.')');
								}
							}
						}
						else{
							Toast('error', 'خطا', $_ACCESS_DENIED);
						}
				}
				$projectInfo = $project->GetProjectInfoById($prjid);
				$legend = ''.$_EDIT.' '.$_PROJECT.'&nbsp';
				$prjcode = $projectInfo['prjcode'];
				$prjtitle = $projectInfo['prjtitle'];
				$prjdesc = $projectInfo['prjdesc'];
				$prjlogo = $projectInfo['prjlogo'];
				$prjlogo2 = $projectInfo['prjlogo'];
				$prjcomments = $projectInfo['prjcomments'];
			}
			
			echo '
			<div class="col-sm-12 col-md-12 jumbotron" id="content">';
			if ($permissions[0]['allow_add_project']==1 || $permissions[0]['allow_edit_project']==1) {
			echo'
				<form method="post" enctype="multipart/form-data">
					<p class="lead">'.$legend.'';
					if ($permissions[0]['allow_add_project']==1) {
					(isset($_GET['prjid'])?AddLogo('?op=add', $_NEW):'');
					}
					if ($permissions[0]['allow_list_project']==1) {
						ListLogo('?op=list', $_LIST);
					}
					echo '</p>
					<div class="row">
					  <div class="col-md-4">
						  <div class="form-group">
						    <label for="prjcode">'.$_CODE.':<span class="required">*</span>:</label>
						    <input autofocus="" type="text" class="form-control" id="prjcode" name="prjcode" style="direction:ltr;" value="'.$prjcode.'">
						  </div>
						  <div class="form-group">
						    <label for="prjtitle">'.$_TITLE.':<span class="required">*</span>:</label>
						    <input type="text" class="form-control" id="prjtitle" name="prjtitle" value="'.$prjtitle.'">
						  </div>
					  	<div class="form-group">
					  		<label for="prjlogo">'.$_LOGO.':</label>';	
					  		if(isset($_REQUEST['prjid']))
					  		{
					  			if(file_exists('img/project/'.$pic_prefix.$prjlogo.''))
					  			{
					  				echo '
					  				<br>
					  				<img src="img/project/'.$pic_prefix.$prjlogo.'" style="height:100px;">
					  				<br>
					  				<input type="checkbox" name="delpic" value="yes" id="delpic"><label for="delpic"> '.$_DELETE_IMAGE.'</label>
					  				';
					  			}
					  			else
					  				echo '
					  				<br>
					  				<img src="img/proja.png">';
					  		}
					  		echo '
					  		<input type="file" id="prjlogo" name="prjlogo" value="'.$prjlogo.'" style="direction: ltr;">
					  		<input type="hidden" name="prjlogo_temp" value="'.$prjlogo2.'">
					  	</div>
						  
					  </div>
					  <div class="col-md-8">
					  	<div class="row">
					  	  <div class="col-md-6">
							  <div class="form-group">
							    <label for="prjdesc">'.$_DESC.':</label>
							    <textarea class="form-control editor" rows="3" id="prjdesc" name="prjdesc">'.$prjdesc.'</textarea>
							  </div>
					  	  </div>
					  	  <div class="col-md-6">
						  	  <div class="form-group">
							    <label for="prjcomments">'.$_COMMENTS.':</label>
							    <textarea class="form-control editor" rows="3" id="prjcomments" name="prjcomments">'.$prjcomments.'</textarea>
							  </div>
					  	  </div>
					  	</div>
						  ';
						  	if (isset($_GET['prjid'])) {
						  		echo '
						  		<ul class="list-inline">
						  			<li class="left_list">';
					    				UpdateForm('edit', $_UPDATE);
					    			echo'
						  			</li>
						  			<li>';
						  			if ($permissions[0]['allow_delete_project']==1) {
						  				echo'
						  				<a onclick="return Sure();" style="color: #a00;" href="?op=delete&prjid='.$prjid.'">'.$_DELETE.'</a>';
						  			}
						  			echo'
						  			</li>
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
					</div>
				  
				</form>
    		</div>
			';
			}
			else{
				Failure($_ACCESS_DENIED);
			}
			break;
		case 'list':
			require_once 'menu.php';
			$query=$q=$filter=$order="";
			$start=$page=0;
			if (isset($_POST['search']) && $_POST['q']!=="") 
			{
				$q= $_POST['q'];
				$filter= $_POST['filter'];
				$query= "WHERE $filter LIKE '%$q%'";
			}
			else{
				$order ="ORDER BY ".($permissions[0]['asuper_admin']==1?"prjid":"atid")." DESC";
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
			if ($permissions[0]['asuper_admin']==1) {
				$projectlist= $project->GetList($query, $order,$limit="LIMIT $start,$page_limit");
				$num_of_records=  $project->RowCount($query);
			}
			else{
				$aid= $permissions[0]['aid'];
				if (isset($_POST['search']) && $_POST['q']!=="") {
					$query = "WHERE aids=$aid&&$filter LIKE '%$q%'";
				}
				else{
					$query = "WHERE aids=$aid";
				}
				$projectlist = $admins_tasks->GetListPrjAdmin($query, $order,$limit="LIMIT $start,$page_limit");
				$num_of_records=  $admins_tasks->RowCount($query);
			}
			$num_of_pages= intval($num_of_records/$page_limit);
			$num_of_pages= ($num_of_records%$page_limit==0?$num_of_pages:$num_of_pages+1);
			echo '
			<div class="col-sm-12 col-md-12 jumbotron" id="content">';
			if ($permissions[0]['allow_list_project']==1) {
			echo'
			<div class="row">
			  <div class="col-md-3">
				<p class="lead">'.$_PROJECTS.' ';
				if ($permissions[0]['allow_add_project']==1) {
				AddLogo('?op=add', $_NEW);
				}
				echo '</p>
			  </div>
			  <div class="col-md-9">
				<form action="" method="post" class="form-inline">
					<div class="form-group">
						<input autofocus="" type="text" value="'.$q.'" class="form-control input-sm" id="q" name="q" placeholder="'.$_SEARCH_TEXT.'">
					</div>
					<select name="filter" class="form-control input-sm">
						<option '.($filter=="prjcode"?'selected':'').' value="prjcode">'.$_CODE.'</option>
						<option '.($filter=="prjtitle"?'selected':'').' value="prjtitle">'.$_TITLE.'</option>
					</select>';
					if ($num_of_pages>1) {
						echo' '.$_PAGE_NUMBER.':<select name="page" class="form-control input-sm">';
						for ($i=0; $i < $num_of_pages; $i++) { 
							echo'
							<option value="'.$i.'"'.($i==$page?'selected':'').'>'.($i+1).'</option>
							';
						}
						echo '
							</select>';
					}
					echo'
				'.$_NUMBER_OF_PROJECTS_PER_PAGE.':
				<select class="form-control input-sm" id="page_limit" name="page_limit">
					<option '.($page_limit=="5"?'selected':'').' value="5">5</option>
					<option '.($page_limit=="10"?'selected':'').' value="10">10</option>
					<option '.($page_limit=="20"?'selected':'').' value="20">20</option>
					<option '.($page_limit=="50"?'selected':'').' value="50">50</option>
					<option '.($page_limit=="100"?'selected':'').' value="100">100</option>
				</select>
				 <button type="submit" name="search" class="btn btn-default btn-sm">'.$_SEARCH.'</button>
				</form><br>
			  </div>
			</div>
			
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover">
					<tr class="table_header info">
						<th width="30px">'.$_TOOLS.'</th>
						<th width="30px">
							<a href="?op=list&order=prjcode'.(isset($_GET['desc'])?'':'&desc').'">
								'.$_CODE.' <span class="fas fa-collapse'.($_GET['order']=='prjcode' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
							</a>
						</th>
						<th>
							<a href="?op=list&order=prjtitle'.(isset($_GET['desc'])?'':'&desc').'">'.$_TITLE.'<span class="fas fa-collapse'.($_GET['order']=='prjtitle' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
							</a>
						</th>
						<th width="300px">
							<a href="?op=list&order=prjdesc'.(isset($_GET['desc'])?'':'&desc').'">'.$_DESC.'<span class="fas fa-collapse'.($_GET['order']=='prjdesc' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
							</a>
						</th>
						<th width="50px">
							<a href="?op=list&order=prjlogo'.(isset($_GET['desc'])?'':'&desc').'">'.$_LOGO.'<span class="fas fa-collapse'.($_GET['order']=='prjlogo' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
							</a>
						</th>
						<th width="300px">
							<a href="?op=list&order=prjcomments'.(isset($_GET['desc'])?'':'&desc').'">'.$_COMMENTS.'<span class="fas fa-collapse'.($_GET['order']=='prjcomments' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
							</a>
						</th>
						<th width="100px">
							<a href="?op=list&order=prjdate'.(isset($_GET['desc'])?'':'&desc').'">'.$_INSERT_DATE.'<span class="fas fa-collapse'.($_GET['order']=='prjdate' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
							</a>
						</th>
						
					</tr>
				';
				$prj_list = [];
				foreach ($projectlist as $projectInfo) {
					if (!in_array($projectInfo['prjid'], $prj_list)) {
					echo '
						<tr class="">
							<td>
								<div style="text-align:rtl;" dir="rtl">
									<!-- Extra small button group -->
									<div class="btn-group">
										<button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										  <span class="fas fa-menu-hamburger"></span>
										</button>
										<ul class="dropdown-menu pull-left">';
								  			if ($permissions[0]['allow_edit_project']==1) {
								  				echo'
											<li><a href="?op=add&prjid='.$projectInfo['prjid'].'">'.$_EDIT.'</a></li>';
								  			}
								  			if ($permissions[0]['allow_delete_project']==1) {
								  				echo'
											<li><a onclick="return Sure();" style="color: red;" href="?op=delete&prjid='.$projectInfo['prjid'].'">'.$_DELETE.'</a></li>';
								  			}
								  			if ($permissions[0]['allow_list_task']==1) {
								  			echo'
											<li><a href="tasks.php?op=list&prjid='.$projectInfo['prjid'].'">'.$_THE_TASKS_OF_THIS_PROJECT.'</a></li>';
											}
								  			echo'
										</ul>
									</div>
								</div>
							</td>
							<td style="text-align:ltr;" dir="ltr"><strong>'.$projectInfo['prjcode'].'</strong></td>
							<td><strong>'.$projectInfo['prjtitle'].'</strong></td>
							<td><div class="overflow_list">'.$projectInfo['prjdesc'].'</div></td>';
							if(file_exists('img/project/'.$pic_prefix.$projectInfo['prjlogo'].''))
								$prjlogo = 'img/project/'.$pic_prefix.$projectInfo['prjlogo'].'';
							else
								$prjlogo = 'img/proja.png';
								
							echo '<td style="text-align:center;">
								<img src="'.$prjlogo.'" style="height:30px;" />
								</td>
							<td>'.$projectInfo['prjcomments'].'</td>
							<td style="text-align:ltr;" dir="ltr">'.($language=='farsi'?G2J($projectInfo['prjdate']):$projectInfo['prjdate']).'</td>
							
						</tr>
						';
						array_push($prj_list, $projectInfo['prjid']);
					}
				}
			echo'
			</div>
			';
			}
			else{
				Failure($_ACCESS_DENIED);
			}
			break;
		case 'l1':
			echo '
			<div class="col-sm-12 col-md-12 jumbotron" id="content">

    		</div>
			';
			break;
		case 'delete':
			if (isset($_GET['prjid'])) {
				echo '
				<div class="col-sm-12 col-md-12 jumbotron" id="content">';
				if ($permissions[0]['allow_delete_project']==1) {
					if ($project->Delete($_GET['prjid'])) 
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
				echo '
				<a href="?op=list"><input type="submit" name="backlist" class="btn btn-primary" value="'.$_BACK_TO_LIST.'"></a>
				</div>
				';
			}
			break;
		default:
			# code...
			break;
	}




		 
require_once 'footer.php';
 ?>