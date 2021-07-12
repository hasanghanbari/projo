<?php 
require_once 'main.php';
$issue 			= new ManageIssues();
$project 		= new ManageProjects();
$issue_types 	= new ManageIssue_types();
$task_issue 	= new ManageTasks_issues();
$admins_tasks 	= new ManageAdmins_Tasks();
$task 			= new ManageTasks();

$op = $_POST['op'];
switch ($op) {
	case 'edit_project':
		$prjid 			= $_POST['prjid'];
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
				Toast('error', $_ERROR, $_ADMIN_PIC_EXTENSION_ERROR);
			}
			else
			{
				$imageinfo = getimagesize($_FILES['prjlogo']['tmp_name']);
				if($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/png')
				{
					Toast('error', $_ERROR, $_ADMIN_PIC_CONTENT_ERROR);
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
							Toast('error', $_ERROR, $_ADMIN_PIC_UPLOAD_ERROR);
							$prjlogo = "";
						}
					}
					else
					{
						$prjlogo = $prjlogo2 = $_REQUEST['prjlogo_temp'];
						Toast('error', $_ERROR, $_IMAGE_SIZE_ERROR);
					}
				}
			}
			//--Upload Image
		}
		else
		{
			if(isset($_POST['delpic'])!="yes")
				$prjlogo = $prjlogo2 = $_REQUEST['prjlogo_temp'];
		}
		
		$prjtitle 		= $_POST['prjtitle'];
		$prjdesc 		= $_POST['prjdesc'];
		$bg_color 		= '#'.$_POST['bg_color_project'];
		$aid 			= $permissions[0]['aid'];
		if ($permissions[0]['allow_edit_project']==1) {
			if($project->UpdateMini($prjid, $prjtitle, $prjdesc, $prjlogo, $bg_color, $aid)==1){
				Toast('success', $_SUCCESS, $_RECORD_EDITED_SUCCESSFULLI);
			}
			else{
				Toast('error', $_ERROR, $_EDITING_RECORD_FAILED.' ('.$_NOT_CHANGED_RECORD.')');
			}
		}
		else{
			Toast('error', $_ERROR, $_ACCESS_DENIED);
		}
		break;
	case 'add_project':
		if(!empty($_FILES['logo']['name']))
		{
			$whitelist = array("png", "jpg", "gif");
			if(!in_array(substr(basename($_FILES['logo']['name']),-3), $whitelist))
			{
				Toast('error', $_ERROR, $_ADMIN_PIC_EXTENSION_ERROR);
			}
			else
			{
				if($_FILES['logo']['size']<($_IMAGE_SIZE*1024))
				{
					$imageinfo = getimagesize($_FILES['logo']['tmp_name']);
					if($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/png')
					{
						Toast('error', $_ERROR, $_ADMIN_PIC_CONTENT_ERROR);
					}
					else
					{
						$uploaddir = 'img/project/';
						$pic_name = $pic_prefix;
						$uploadfile = $uploaddir.$pic_name.'-'.substr(time(),-7).'.'.substr(basename($_FILES['logo']['name']),-3);
						if (move_uploaded_file($_FILES['logo']['tmp_name'], $uploadfile))
						{
							$logo = '-'.substr(time(),-7).'.'.substr(basename($_FILES['logo']['name']),-3);
						}
						else
						{
							Toast('error', $_ERROR, $_ADMIN_PIC_UPLOAD_ERROR);
							$logo = "";
						}
					}
				}
				else
				{
					Toast('error', $_ERROR, $_IMAGE_SIZE_ERROR);
				}
			}
		}
		else {
			$logo = "";
		}
		$title 		= $_POST['title-project'];
		$bg_color 	= '#'.$_POST['bg_color_project'];
		$desc 		= '';
		$aid 		= $permissions[0]['aid'];
		if (empty($title)) {
			Toast('error', $_ERROR, $_FILL_IN_REQUIRED );
		} 
		else 
		{		
			if ($permissions[0]['allow_add_project']==1) {
				if ($project->AddMini($title, $desc, $logo, $bg_color, $aid)==1) {
					$last_project = $project->LastId();
					echo '
					<script>addTask('.$last_project.', '.$aid.', \''. $_DEVELOPING .'\')</script>
					';
					Toast('success', $_SUCCESS, $_RECORD_ADDED_SUCCESSFULLI);
				}
				else{
					Toast('error', $_ERROR, $_ADDING_RECORD_FAILED);
				}
			}
			else{
				Toast('error', $_ERROR, $_ACCESS_DENIED);
			}
		}
		break;
	case 'delete_project':
		if ($permissions[0]['allow_delete_project']==1) {
			$prjid = $_POST['prjid'];
			if ($project->Delete($prjid)) 
			{
				Toast('success', $_SUCCESS, $_RECORD_DELETED_SUCCESSFULLI);
			}
			else
			{
				Toast('error', $_ERROR,_DELETING_RECORD_FAILED);
			}
		}
		else{
			Toast('error', $_ERROR,_ACCESS_DENIED);
		}
		break;
	case 'list_project_menu':
		if ($permissions[0]['asuper_admin']==1) {
			$projectlist= $project->GetList();
		}
		else{
			$aid= $permissions[0]['aid'];
			$query = "WHERE aids=$aid";
			$projectlist = $admins_tasks->GetListPrjAdmin($query);
		}
		$prj_list = [];
		foreach ($projectlist as $projectInfo) {
			if (!in_array($projectInfo['prjid'], $prj_list)) {
				if(file_exists('img/project/'.$pic_prefix.$projectInfo['prjlogo'].''))
					$prjlogo = 'img/project/'.$pic_prefix.$projectInfo['prjlogo'].'';
				else
					$prjlogo = 'img/proja.png';
				
				echo'
				<a class="dropdown-item" href="tasks.php?op=chart&prjid='.$projectInfo['prjid'].'" style="background-color: '.$projectInfo['bg_color'].'50">
					<span class="bg-color-project">
						<label class="form-check-label" for="bg_color_project1" onclick="activeColorProject(1)">
							<span class="box-color" style="background-color: '.$projectInfo['bg_color'].'">
								
							</span>
						</label>
					</span>
					<img src="'.$prjlogo.'" class="menu-img-project" alt="'.$projectInfo['prjtitle'].'">
					<span class="menu-title-project">'.$projectInfo['prjtitle'].'</span>
				</a>';

				array_push($prj_list, $projectInfo['prjid']);
			}
		}
		break;
	case 'add_task':
		$task_title = $_POST['task_title'];
		$prjid 		= $_POST['prjid'];
		$aid 		= $_POST['aid'];

		if ($task->AddFast($prjid, $task_title, $aid) == 1) {
			$last_task = $task->LastId();
			if ($permissions[0]['asuper_admin'] != 1) {
				$admins_tasks->Add($aid , $last_task);
			}
			Toast('success', $_SUCCESS, $_RECORD_ADDED_SUCCESSFULLI);
			echo '
			<script type="text/javascript">
				$(document).ready(function() {
					location.reload();
				});
			</script>
			';
		}
		break;
	case 'delete_task':
		$tskid = $_POST['tskid'];
		if ($permissions[0]['allow_delete_task']==1) {
			if ($task->Delete($tskid)) 
			{
				Toast('success', $_SUCCESS, $_RECORD_DELETED_SUCCESSFULLI);
			}
			else
			{
				Toast('error', $_ERROR, $_DELETING_RECORD_FAILED);
			}
		}
		else{
			Toast('error', $_ERROR, $_ACCESS_DENIED);
		}
		break;
	case 'issue_list':
	  $tskId = $_POST['tskid'];

	  $query='WHERE iarchive=0';
	  $order = "ORDER BY idate DESC";
	  $task_issuelist = $task_issue->Getlist($query,$order);
	  	foreach ($task_issuelist as $task_issueInfo) {
	  		switch ($task_issueInfo['iproirity']) {
	  			case '0':
	  				$iproirity="".$_EASY."";
	  				break;
	  			case '1':
	  				$iproirity="".$_NORMAL."";
	  				break;
	  			case '2':
	  				$iproirity="".$_HARD."";
	  				break;
	  			case '3':
	  				$iproirity="".$_VERY." ".$_HARD."";
	  				break;
				default:
					$iproirity = "";	
	  		}
	  		switch ($task_issueInfo['icomplexity']) {
	  			case '0':
	  				$icomplexity="None";
	  				break;
	  			case '1':
	  				$icomplexity="!";
	  				break;
	  			case '2':
	  				$icomplexity="!!";
	  				break;
	  			case '3':
	  				$icomplexity="!!!";
	  				break;
	  			case '4':
	  				$icomplexity="!!!!";
	  				break;
	  			case '5':
	  				$icomplexity="!!!!!";
	  				break;
				default:
					$icomplexity = "";
	  		}
	  		$ifile1 = $task_issueInfo['ifile1'];
	  		$ifile2 = $task_issueInfo['ifile2'];
	  		$ifile3 = $task_issueInfo['ifile3'];
	  		$bg_issue = '';
	  		if ($task_issueInfo['idone'] == 0) {
	  			$bg_issue = '';
	  		}
	  		else if ($task_issueInfo['idone'] == 1) {
	  			$bg_issue = 'text-white bg-success';
	  		}
	  		else if ($task_issueInfo['idone'] == 2) {
	  			$bg_issue = 'text-white bg-danger';
	  		}
	  		else if ($task_issueInfo['idone'] == 3) {
	  			$bg_issue = 'text-white bg-info';
	  		}
	  		else if ($task_issueInfo['idone'] == 4) {
	  			$bg_issue = 'text-white bg-primary';
	  		}
	  		else if ($task_issueInfo['idone'] == 5) {
	  			$bg_issue = 'text-white bg-warning';
	  		}
	  		if ($tskId == $task_issueInfo['tskid']) {
	  		echo'
	  		<a href="javascript:IssueInfo('.$task_issueInfo['iid'].', '.$task_issueInfo['tskid'].')">
		  		<div class="card card-body issue-task-show mb-2 '.$bg_issue.'">
			  		<ul class="list-inline p-0">
			  			<li class="list-inline-item">
			  				'.$task_issueInfo['ititle'].'
			  			</li><br>
			  			<li class="left_list list-inline-item">
			  			'.(!empty($task_issueInfo['idesc'])?'<span class="fas fa-align-justify" aria-hidden="true"></span>':'').'
			  			'.(file_exists('file_issue/file1/'.$file_prefix.$ifile1.'')?'<span class="fas fa-paperclip" aria-hidden="true"></span>1':'').'
			  			'.(file_exists('file_issue/file2/'.$file_prefix.$ifile2.'')?'<span class="fas fa-paperclip" aria-hidden="true"></span>2':'').'
			  			'.(file_exists('file_issue/file3/'.$file_prefix.$ifile3.'')?'<span class="fas fa-paperclip" aria-hidden="true"></span>3':'').'
			  			</li>
			  			<li class="list-inline-item tag-issue-task-chart">
			  				'.($task_issueInfo['idone']==1 ? '<span class="badge badge-light">'.$_DONE.'</span>' : '').'
			  				'.($task_issueInfo['idone']==2 ? '<span class="badge badge-light">'. $_CANNOT_BE_SOLVED .'</span>' : '').'
			  				'.($task_issueInfo['idone']==3 ? '<span class="badge badge-light">'. $_DOING .'</span>' : '').'
			  				'.($task_issueInfo['idone']==4 ? '<span class="badge badge-light">'. $_TESTING .'</span>' : '').'
			  				'.($task_issueInfo['idone']==5 ? '<span class="badge badge-danger">'. $_EMERGENCY .'</span>' : '').'
			  				'.(isset($iproirity) ? '<span class="badge badge-info">'.$iproirity.'</span>' : '').'
			  				'.(isset($icomplexity) && $task_issueInfo['icomplexity'] != 0 ? '<span class="badge badge-warning font-weight-light">'.$icomplexity.'</span>' : '').'
			  			</li>
			  		</ul>
  				</div>
			</a>
	  		';
	  		}
	  	}
		break;
	case 'add_issue':
		$issueText 		= $_POST['issueText'];
		$tskid 			= $_POST['tskid'];
		$prjid 			= $_POST['prjid']; 

		$ititle 		= $issueText; 
		$aid 			= $permissions[0]['aid'];
		$tyid 			= 1;
		$archive 		= 0;
		$iproirity 		= 1;
		$icomplexity 	= 0;

		if (empty($ititle)) {
			Toast('error', $_ERROR, $_FILL_IN_REQUIRED);
		} 
		else 
		{
			if ($permissions[0]['allow_add_issues']==1) {
				if ($issue->AddMini($tyid, $prjid, $ititle, $archive,  $iproirity,  $icomplexity, $aid)==1) {
					
					// add task issue
					$iid = $issue->LastID();
					$task_issue->Add($tskid,$iid);

					Toast('success', $_SUCCESS, $_RECORD_ADDED_SUCCESSFULLI);
					// echo '
					// <script type="text/javascript">
					// 	IssueInfo('.$iid.', '.$tskid.');
					// </script>
					// ';

				}
				else{
					Toast('error', $_ERROR, $_ADDING_RECORD_FAILED);
				}
			}
			else{
				Toast('error', $_ERROR, $_ACCESS_DENIED);
			}
		}
		break;
	case 'issue_prjid':
		$prjid = $_POST['prjid'];
		$tskid = $_POST['tskid'];
		$query=$q=$filter=$order="";
		$start=$page=0;
		$order ="ORDER BY iid DESC";
		$query = "WHERE iarchive=0&&prjid=$prjid";
		$issuelist = $issue->getlist($query, $order,$limit="LIMIT $start,$page_limit");
		echo '<div class="checkbox" style="direction: '.($direction==0?'ltr':'rtl').'; text-align: '.($direction==0?'left':'right').';">';
		foreach ($issuelist as $issueInfo) {
			if ($task_issue->GetTaskIssue($tskid,$issueInfo['iid'])) {
				$task_issueInfo = $task_issue->GetInfoByTskidIid($tskid,$issueInfo['iid']);
				echo '<a href="#" style="color:red;" onclick="delete_task_issue('.$task_issueInfo['tiid'].')" data-toggle="collapse" data-target="#issueList" aria-expanded="false" aria-controls="issueList"><span class="fas fa-remove" aria-hidden="true"></span></a>
				&nbsp'.$issueInfo['ititle'].' ('.($issueInfo['idone']==1?_DONE:_UNDONE).')<br>';
			}
			else{
				echo'
				  <label>
				    <input type="checkbox" id="iid" name="iid['.$issueInfo['iid'].']"> '.$issueInfo['ititle'].' ('.($issueInfo['idone']==1?_DONE:_UNDONE).')
				  </label><br>
				';
			}
		}
		echo'		
			<input type="hidden" value="" id="tiid">
			<script>
		      function delete_task_issue(id) {
		        $("#dat").html(\'<img src="img/wait.gif">\');
				var tiid= $("#tiid").val();
				$("#tiid").val(id)
		        $.ajax({
		          url: "aj.php",
		          type: "POST",
		          data: {op:"delete_task_issue",tiid:$("#tiid").val()},
		          success: function(data,status) {
		            $("#dat").html(data);
		          },
		          error: function() {$("#dat").html("problem in ajax")}
		        });
		      }
	      </script>
		';
		echo'</div>';
		break;
	case 'list_admin_task':
		$tskid = $_POST['tskid'];
		$admin_tasklist = $admins_tasks->GetAidByTskid($tskid);
		foreach ($admin_tasklist as $key => $admin_taskInfo) {
			echo'<p>';
					if ($admin_taskInfo['aid']!=1) {
					echo'<a href="#" style="color:red;" onclick="delete_admin_task('.$admin_taskInfo['atid'].')" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">'.$_DELETE.'</a>
						&nbsp&nbsp'.$admin_taskInfo['ausername'].'';
					}
				echo'
				</p>
			  ';
		}
		echo'		
					<input type="hidden" value="" id="atid">
					<script>
				      function delete_admin_task(id) {
				        $("#dat").html(\'<img src="img/wait.gif">\');
						var atid= $("#atid").val();
						$("#atid").val(id)
				        $.ajax({
				          url: "aj.php",
				          type: "POST",
				          data: {op:"delete_admin_task",atid:$("#atid").val()},
				          success: function(data,status) {
				            $("#dat").html(data);
				          },
				          error: function() {$("#dat").html("problem in ajax")}
				        });
				      }
			      </script>
		';
		break;
	case 'delete_admin_task':
		$atid = $_POST['atid'];
		if ($admins_tasks->delete($atid)==1) {
			Success($_RECORD_DELETED_SUCCESSFULLI);
		}
		else{
			Failure($_DELETING_RECORD_FAILED);
		}
		break;
	case 'delete_task_issue':
		$tiid = $_POST['tiid'];
		if ($task_issue->delete($tiid)==1) {
			Success($_RECORD_DELETED_SUCCESSFULLI);
		}
		else{
			Failure($_DELETING_RECORD_FAILED);
		}
		break;
	case 'issue_info':
		$iid 				= $_POST['issue_id'];
		$tskid 				= $_POST['tskid'];

		$start = $page 		= 0;
		$archive 			= (isset($_GET['archive'])?'1':'0');
		$query 				= "WHERE iarchive=$archive";
		$order 				= "ORDER BY icomplexity DESC";
		$projectlist 		= $project->GetList();
		$issue_typeslist 	= $issue_types->GetList();
		$issueInfo 			= $issue->GetInfo("iid",$iid);
		if ($iid == $issueInfo['iid']) {
			$tyid 			= $issueInfo['tyid']; 
			$prjid 			= $issueInfo['prjid']; 
			$iversion 		= $issueInfo['iversion']; 
			$icode 			= $issueInfo['icode']; 
			$ititle 		= $issueInfo['ititle']; 
			$idesc 			= $issueInfo['idesc'];
			$ineeded_time 	= $issueInfo['ineeded_time']; 
			$ifile1 		= $issueInfo['ifile1']; 
			$ifile12 		= $issueInfo['ifile1']; 
			$ifile2 		= $issueInfo['ifile2']; 
			$ifile22 		= $issueInfo['ifile2']; 
			$ifile3 		= $issueInfo['ifile3']; 
			$ifile32 		= $issueInfo['ifile3']; 
			$iarchive 		= $issueInfo['iarchive']; 
			$idate 			= $issueInfo['idate']; 
			$iwho_fullname 	= $issueInfo['iwho_fullname']; 
			$iwho_email 	= $issueInfo['iwho_email']; 
			$iwho_tel 		= $issueInfo['iwho_tel']; 
			$idone 			= $issueInfo['idone']; 
			$idone_date 	= $issueInfo['idone_date'] == 0 ? '' : ($language=='farsi'	? G2JD($issueInfo['idone_date']) 
																						: $issueInfo['idone_date']); 
			$idone_version	= $issueInfo['idone_version'];
			if ($idone == 0) {
				$bg_status = 'secondary';
				$btn_title = $_UNKNOWN;
			}
			else if ($idone == 1) {
				$bg_status = 'success';
				$btn_title = $_FINISHED;
			}
			else if ($idone == 2) {
				$bg_status = 'danger';
				$btn_title = $_CANNOT_BE_SOLVED;
			}
			else if ($idone == 3) {
				$bg_status = 'info';
				$btn_title = $_DOING;
			}
			else if ($idone == 4) {
				$bg_status = 'primary';
				$btn_title = $_TESTING;
			}
			else if ($idone == 5) {
				$bg_status = 'warning';
				$btn_title = $_EMERGENCY;
			}
			switch ($issueInfo['iproirity']) {
				case '0':
					$iproirity = "".$_EASY."";
					break;
				case '1':
					$iproirity = "".$_NORMAL."";
					break;
				case '2':
					$iproirity = "".$_HARD."";
					break;
				case '3':
					$iproirity = "".$_VERY." ".$_HARD."";
					break;
				default:
					$iproirity = "";	
			}
			switch ($issueInfo['icomplexity']) {
				case '0':
					$icomplexity = "None";
					break;
				case '1':
					$icomplexity = "!";
					break;
				case '2':
					$icomplexity = "!!";
					break;
				case '3':
					$icomplexity = "!!!";
					break;
				case '4':
					$icomplexity = "!!!!";
					break;
				case '5':
					$icomplexity = "!!!!!";
					break;
				default:
					$icomplexity = "None";
			}
			$adminlist = $admin->GetAdminInfoById($issueInfo['aid']);
	      echo'
	      	<script type="text/javascript">
	      		$(document).ready(function() {
	      		    $(".editor").richText();
	      		});
	      	</script>
	       <div class="modal-header">
	       	<div class="row w-100">
	       		<div id="show-resault-done-issue" class="col-12"></div>
	       		<div class="col-6">
					<h5>
			    		<a href="#" role="button" class="btn btn-light" data-dismiss="modal" aria-label="Close">
			    			<i class="fas fa-times"></i>
			    		</a>
						'.$_EDIT.' '.$_ISSUE.'
					</h5>
				</div>
				<div class="col-6">		
		    		<div class="float-left">
		    			<span>
		    				'.$_PROIRITY.': '.$iproirity.' | 
		    			</span>
		    			<span>
		    				'.$_COMPLEXITY.': '.$icomplexity.' |
		    			</span>
		    			<span>
	  						'.$_INSERTED_BY.': '. $adminlist['ausername'].'
		    			</span>
		    		</div>
				</div>
	       	</div>
	      </div>
	      <div class="modal-body">';
				if ($permissions[0]['allow_add_issues']==1 || $permissions[0]['allow_edit_issues']==1) {	
				echo'
					<form id="edit_issue" method="post" enctype="multipart/form-data">
						<div class="row">
						  <div class="col-md-8">
						  <div class="form-group">
						    <label for="ititle">'.$_TITLE.'<span class="required">*</span>:</label>
						    <input type="text" class="form-control" id="ititle" name="ititle" value="'.$ititle.'">
						  </div>
							  <div class="row">
								  <div class="col-md-6">
									  <div class="form-group">
									    <label for="iproirity">'.$_PROIRITY.':</label>
									    <select class="form-control" name="iproirity" id="iproirity">
									      <option value="0" '.($issueInfo['iproirity']==0?'selected':'').'>'.$_EASY.'</option>
									      <option value="1" '.($issueInfo['iproirity']==1?'selected':'').'>'.$_NORMAL.'</option>
									      <option value="2" '.($issueInfo['iproirity']==2?'selected':'').'>'.$_HARD.'</option>
									      <option value="3" '.($issueInfo['iproirity']==3?'selected':'').'>'.$_VERY.' '.$_HARD.'</option>
									    </select>
									  </div>
								  </div>
								  <div class="col-md-6">
									  <div class="form-group">
									    <label for="icomplexity">'.$_COMPLEXITY.':</label>
									    <select class="form-control" name="icomplexity" id="icomplexity">
									      <option value="0" '.($issueInfo['icomplexity']==0?'selected':'').'>None</option>
									      <option value="1" '.($issueInfo['icomplexity']==1?'selected':'').'>!</option>
									      <option value="2" '.($issueInfo['icomplexity']==2?'selected':'').'>!!</option>
									      <option value="3" '.($issueInfo['icomplexity']==3?'selected':'').'>!!!</option>
									      <option value="4" '.($issueInfo['icomplexity']==4?'selected':'').'>!!!!</option>
									      <option value="5" '.($issueInfo['icomplexity']==5?'selected':'').'>!!!!!</option>
									    </select>
									  </div>
								  </div>
							  </div>
						    <div class="row">
						  	  <div class="col-md-6">
								  <div class="form-group">
								    <label for="ineeded_time">'.$_NEEDED_TIME.':</label>
								    <input type="text" class="form-control" id="ineeded_time" name="ineeded_time" value="'.$ineeded_time.'" placeholder="'.$_NEEDED_TIME_EXAMPLE.'">
								  </div>
							  </div>
						  	  <div class="col-md-6">
							      <div class="form-group">
					  	    	<label for="tyid">'.$_TYPE.' '.$_ISSUE.':</label><br>
						  	  	  <select class="form-control" id="tyid" name="tyid">';
						  	        foreach ($issue_typeslist as $issue_typesInfo) {
						  	         echo'<option value="'.$issue_typesInfo['tyid'].'" '.($issue_typesInfo['tyid']==$tyid?'selected':'').'>'.$issue_typesInfo['tytitle'].'</option>
						  	        ';
						  	   		}
						  	       echo'
						  	  	  </select>
						  	    </div>
							  </div>
							</div>
					  	    <div class="row">
							  <div class="col-md-6">
								   <div class="form-group">
								    <label for="prjid">'.$_MOVE.' '.$_TO.' '.$_PROJECT.':</label>
								    <select class="form-control" id="prjid" name="prjid"'.(isset($_GET['tskid'])?'disabled':'').'>';
								    if ($permissions[0]['asuper_admin']==1) {
								    	$projectlist= $project->GetList();
								    }
								    else{
								    	$aid= $permissions[0]['aid'];
								    	$query = "WHERE aids=$aid";
								    	$projectlist = $admins_tasks->GetListPrjAdmin($query);
								    }
								    $prj_list = [];
								    foreach ($projectlist as $projectInfo) {
								    	if (!in_array($projectInfo['prjid'], $prj_list)) {
								    		echo'
								    		<option value="'.$projectInfo['prjid'].'" '.($projectInfo['prjid']==$prjid?'selected':'').'>'.$projectInfo['prjtitle'].'</option>
								    		';
								    		array_push($prj_list, $projectInfo['prjid']);
										}
								    }

								    echo'
								    </select>
								  </div>
					  	      </div>
							  <div class="col-md-6">
							  	<script type="text/javascript">
							  		$( "#prjid" ).change(function() {
							  		  showTask($("#prjid").val());
							  		});
							  		showTask('.$prjid.');
							  		function showTask(prjid) {
							  			$("#task_move").html(\'<img src="img/wait.gif">\');
							  			const tskid = "'.$tskid.'";
							  			$.ajax({
							  			  url: "aj.php",
							  			  type: "POST",
							  			  data: {op:"get_task_for_move", prjid: prjid, tskid: tskid},
							  			  success: function(data,status) {
							  			    console.log(data);
							  			    $("#task_move").html(data);
							  			  },
							  			  error: function() {$("#task_move").html("problem in ajax")}
							  			}); 
							  		}
							  	</script>
							    <div class="form-group" id="task_move">
							      <!-- <label for="iversion">'.$_PROJECT_VERSION.':</label> -->
							      <!-- <input type="text" class="form-control" id="iversion" name="iversion" value="'.$iversion.'"> -->
							    </div>
					  	      </div>
							</div>
							<div class="form-group">
							  <label for="idesc">'.$_DESC.':</label>
							  <textarea class="form-control editor" rows="3" id="idesc" name="idesc">'.$idesc.'</textarea>
							</div>
						  </div>
						  <div class="col-md-4">
						  	<div class="mb-4">
  							<label for="status" class="w-auto">'.$_CONDITION.':</label>
		  	  			  	<input type="hidden" name="status" id="status" value="'.$idone.'">
  							<!-- Example single danger button -->
  							<div class="float-left w-75 status">
  							  <button type="button" class="btn btn-'.$bg_status.' btn-block" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="status-drop">
  							    	'.$btn_title.'
  							  </button>
  							  <div class="dropdown-menu">
  							    <a class="bg-secondary dropdown-item" href="javascript: " onclick="selectStatus(0, \''. $_UNKNOWN .'\', \'secondary\')">
  							    	<span class="status-select">'. $_UNKNOWN .'</span>
  							    </a>
 							    <a class="bg-success dropdown-item" href="javascript: " onclick="selectStatus(1, \''. $_FINISHED .'\', \'success\')">
  							    	<span class="status-select">'. $_FINISHED .'</span>
  							    </a>
  							    <a class="bg-danger dropdown-item" href="javascript: " onclick="selectStatus(2, \''. $_CANNOT_BE_SOLVED .'\', \'danger\')">
  							    	<span class="status-select">'. $_CANNOT_BE_SOLVED .'</span>
  							    </a>
  							    <a class="bg-info dropdown-item" href="javascript: " onclick="selectStatus(3, \''. $_DOING .'\', \'info\')">
  							    	<span class="status-select">'. $_DOING .'</span>
  							    </a>
  							    <a class="bg-primary dropdown-item" href="javascript: " onclick="selectStatus(4, \''. $_TESTING .'\', \'primary\')">
  							    	<span class="status-select">'. $_TESTING .'</span>
  							    </a>
  							    <a class="bg-warning dropdown-item" href="javascript: " onclick="selectStatus(5, \''. $_EMERGENCY .'\', \'warning\')">
  							    	<span class="status-select">'. $_EMERGENCY .'</span>
  							    </a>
  							  </div>
  							</div>
							</div>
						  	<label for="idesc">'. $_ATTACHMENTS .':</label>
						  	<div class="row">
							  <div class="col">
								  <div class="form-group">
								    ';
	    								if(file_exists('file_issue/file1/'.$file_prefix.$ifile1.''))
	    								{
	    									echo '
	    									<a href="file_issue/file1/'.$file_prefix.$ifile1.'" download="file1-'.$file_prefix.$ifile1.'">
	    										'.$_DOWNLOAD.' '.$_FILE1.'
	    									</a>
	    									<br>
	    									<input type="checkbox" name="delpic1" value="1" id="delpic1"><label for="delpic1"> '.$_DELETE_FILE.'1</label>
	    									';
	    								}
		    							else{
		    								echo'
								    			<label for="ifile1" class="btn btn-light">'.$_FILE1.'</label>
							    				<input type="file" class="h-0" style="opacity: 0" id="ifile1" name="ifile1">
		    								';
		    							}
								echo '
									<br>
								    <input type="hidden" name="ifile1_temp" id="ifile1_temp" value="'.$ifile12.'">
								  </div>
						  	  </div>
							  <div class="col">
								  <div class="form-group">
								    ';
								if(file_exists('file_issue/file2/'.$file_prefix.$ifile2.''))
								{
									echo '
									<a href="file_issue/file2/'.$file_prefix.$ifile2.'" download="file2-'.$file_prefix.$ifile2.'">
										'.$_DOWNLOAD.' '.$_FILE2.'
									</a>
									<br>
									<input type="checkbox" name="delpic2" value="1" id="delpic2"><label for="delpic2"> '.$_DELETE_FILE.'2</label>
									';
								}
    							else{
    								echo'
								    		<label for="ifile2" class="btn btn-light">'.$_FILE2.'</label>
						    			<input type="file" class="h-0" style="opacity: 0" id="ifile2" name="ifile2">
									';
								}
									echo '
									<br>
								    <input type="hidden" name="ifile2_temp" id="ifile2_temp" value="'.$ifile22.'">
								  </div>
						  	  </div>
						  	  <div class="col">
			  	  			<div class="form-group">
			  	  		    ';
			  	  				if(file_exists('file_issue/file3/'.$file_prefix.$ifile3.''))
			  	  				{
			  	  					echo '
			  	  					<a href="file_issue/file3/'.$file_prefix.$ifile3.'" download="file3'.$file_prefix.$ifile3.'">
			  	  						'.$_DOWNLOAD.' '.$_FILE3.'
			  	  					</a>
			  	  					<br>
			  	  					<input type="checkbox" name="delpic3" value="1" id="delpic3"><label for="delpic3"> '.$_DELETE_FILE.'3</label>
			  	  					';
			  	  				}
			  	  				else{
			  	  					echo'
			  	  			  			<label for="ifile3" class="btn btn-light">'.$_FILE3.'</label>
			  	  	    	  			<input type="file" class="h-0" style="opacity: 0" id="ifile3" name="ifile3">
			  	  					';
			  	  				}
			  	  			echo '
			  	  			  <br>
			  	  			  <input type="hidden" name="ifile3_temp" id="ifile3_temp" value="'.$ifile32.'">
			  	  			</div>
						  	  </div>
							</div>
							
							<div class="checkbox">
							    <label>
							      <input type="checkbox" id="iarchive" name="iarchive" '.($iarchive==1?'checked':'').'> '.$_ARCHIVE.'
							    </label>
							 </div>
							<div class="checkbox">
							    <label>
							      <input 	type="checkbox" 
							      			id="has_how" 
							      			name="has_how" 
							      			onclick="hasHow()"
							      			'.($iwho_fullname == '' && $iwho_email == '' && $iwho_tel == '' ? '' : 'checked') .'>
							      '. $_HAS_REPORTER .'
							    </label>
							</div>
							<div id="how_form" style="display: '.($iwho_fullname == '' && $iwho_email == '' && $iwho_tel == '' ? 'none' : 'block') .'">
  							<div class="form-group">
  							  <label for="iwho_fullname">'.$_NAME_OF_PROPOSER.':</label>
  							  <input type="text" class="form-control" id="iwho_fullname" name="iwho_fullname" value="'.$iwho_fullname.'">
  							</div>
  							<div class="form-group">
  							  <label for="iwho_email">'.$_EMAIL_OF_PROPOSER.':</label>
  							  <input type="text" class="form-control" id="iwho_email" name="iwho_email" style="direction:ltr;" value="'.$iwho_email.'">
  							</div>
  							<div class="form-group">
  							  <label for="iwho_tel">'.$_PHONE_NUMBER_OF_PROPOSER.':</label>
  							  <input type="text" class="form-control" id="iwho_tel" name="iwho_tel" style="direction:ltr;" value="'.$iwho_tel.'">
  							</div>
  						</div>
							 <!-- <label for="idone">'.$_CONDITION.':</label>
							 <div class="radio">
							   <label>
							     <input type="radio" name="idone" id="idone1" value="1" '.($idone==1?'checked':'').' onclick="checkDonBox()">
							     '.$_DONE.'
							   </label>
							   <label>
							     <input type="radio" name="idone" id="idone2" value="0"'.($idone==0?'checked':'').' onclick="checkDonBox()">
							     '.$_UNDONE.'
							   </label>
							 </div>
							 <div class="row" id="done_issue_box" style="display: '.($idone==1?'block':'none').'">
							 	<div class="col-md-6">
								 <div class="form-group">
								  <label for="idone_date">'.$_COMPLETION_DATE_ISSUE.':</label>
								  <input type="'.($language=='farsi'?'text':'date').'" class="form-control" id="idone_date" name="idone_date" style="direction:ltr;" value="'.($idone_date==0?'':$idone_date).'">';
								  if ($language=='farsi') {
								  	echo'
									  <script type="text/javascript">
								        kamaDatepicker(\'idone_date\', { buttonsColor: "red",markToday: "true", highlightSelectedDay: "true" , gotoToday: "true", nextButtonIcon: "img/timeir_next.png", previousButtonIcon: "img/timeir_prev.png"});
									  </script>
								  	';
								  }
								  echo'
								 </div>
							 	</div>
							 	<div class="col-md-6">
								 <div class="form-group">
								  <label for="idone_version">'.$_DONE_VERSION.':</label>
								  <input type="text" class="form-control" id="idone_version" name="idone_version" style="direction:ltr;" value="'.$idone_version.'">
								</div>
							 	</div>
							 </div> -->
						  </div>
						</div>
					</form>
					<div id="resault-edit_issue"></div>
					<div class="row">
						<div class="col-6">';
							if ($permissions[0]['allow_edit_issues']==1) {
								echo'
								<button class="btn btn-warning" onclick="editIssueForm('.$iid.', '.$tskid.')">'. $_EDIT .'</button>
								';
							}
							echo'
						</div>
						<div class="col-6" style="text-align: left">
			           	<input type="hidden" value="'.$issueInfo['iid'].'" id="iid">';
			  			if ($permissions[0]['allow_delete_issues']==1) {
			  				echo'
			             	<a onclick="return Sure();" class="btn btn-danger ml-1" href="javascript:deleteIssue('.$issueInfo['iid'].', '.$tskid.')">
			             		'.$_DELETE.'
			             	</a>';
			  			}
			  	// 		if ($issueInfo['idone']==0) {
						// 	echo '
						// 	<a class="btn btn-success" href="javascript:doneIssue('.$issueInfo['iid'].', '.$tskid.')">
						// 		'.$_DONE.'
						// 	</a>';
						// }
						// else {
						// 	echo '
						// 	<a class="btn btn-default" href="javascript:startIssue('.$issueInfo['iid'].', '.$tskid.')">
						// 		'.$_START.'
						// 	</a>';
						// }
			  			echo'
						</div>
					</div>';
				}
				else{
					Failure($_ACCESS_DENIED);
				}
				echo'
	      </div>
	    </div>
			';
		}
		break;
	case 'get_task_for_move':
		$prjid = $_POST['prjid'];
		$tskid = $_POST['tskid'];

		$query = "WHERE prjid=$prjid";
		$task_list = $task->Getlist($query);
		echo '
			<label for="task-move">'.$_TASK.':</label>
	      	<select class="form-control" name="task_move" id="task_move">
	      	';
	      	foreach ($task_list as $key => $value) {
	      		echo'
	      		<option value="'.$value['tskid'].'" '.($value['tskid'] == $tskid ? 'selected' : '').'>'.$value['tsktitle'].'</option>
	      		';
	      	}
	      	echo'
	      	</select>
		';
		break;
	case 'edit_issue_form':
		$iid			= $_POST['iid'];

		$whitelist =  array("jpg", "png", "gif", "doc", "docx", "zip", "rar", "pdf", "mp4");
		$ext_error=0;
		if (!empty($_POST['delpic1'])) {
			$delpic1 = $_POST['delpic1'];
		}
		else{
			$delpic1 = '';
		}
		if($delpic1=="1")
		{
			$issue->DelPic($iid);
			$ifile1 = $ifile12 = '';
		}
		if(!empty($_FILES['ifile1']['name']))
		{
			$file_name = strtolower(basename($_FILES['ifile1']['name']));
			foreach ($whitelist as $ext)
			{
			 if(substr($file_name,-strlen($ext))!=$ext)
			  $ext_error++;
			}
			if($ext_error==count($whitelist))
			 	Toast('error', $_ERROR, $_ADMIN_PIC_EXTENSION_ERROR);
			else
			{
			 if($_FILES['ifile1']['size']>($_FILE_SIZE*1048576))
			 	Toast('error', $_ERROR, $_FILE_SIZE_ERROR);
			 else
			 {
			  $uploaddir = 'file_issue/file1/';
			  $final_ext = explode('.',$file_name);
			  
			  $file_name = $file_prefix.'-file1-'.substr(time(),-5).'.'.$final_ext[count($final_ext)-1];
			  $uploadfile = $uploaddir .$file_name;
			  if (move_uploaded_file($_FILES['ifile1']['tmp_name'], $uploadfile))
			  {
			  	$ifile1 = $ifile12 = '-file1-'.substr(time(),-5).'.'.$final_ext[count($final_ext)-1];
			  }
			  else
			  {
			  	Toast('error', $_ERROR, $_ADMIN_PIC_UPLOAD_ERROR);
			  	$ifile1 = "";
			  }
			 }
			}
		}
		else
		{
			if (isset($_POST['delpic1'])) {
				$delpic1 = $_POST['delpic1'];
			}
			else{
				$delpic1 = '';
			}
			if($delpic1!="1")
				$ifile1 = $ifile12 = $_REQUEST['ifile1_temp'];
		}
		//file1
		//file2
		$whitelist =  array("jpg", "png", "gif", "doc", "docx", "zip", "rar", "pdf", "mp4");
		$ext_error=0;
		if (!empty($_POST['delpic2'])) {
			$delpic2 = $_POST['delpic2'];
		}
		else{
			$delpic2 = '';
		}
		if($delpic2=="1")
		{
			$issue->DelPic($iid);
			$ifile2 = $ifile22 = '';
		}
		if(!empty($_FILES['ifile2']['name']))
		{
				
			$file_name = strtolower(basename($_FILES['ifile2']['name']));
			foreach ($whitelist as $ext)
			{
			 if(substr($file_name,-strlen($ext))!=$ext)
			  $ext_error++;
			}
			if($ext_error==count($whitelist))
				Toast('error', $_ERROR, $_ADMIN_PIC_EXTENSION_ERROR);
			else
			{
			 if($_FILES['ifile2']['size']>($_FILE_SIZE*1048576))
				Toast('error', $_ERROR, $_FILE_SIZE_ERROR);
			 else
			 {
			  $uploaddir = 'file_issue/file2/';
			  $final_ext = explode('.',$file_name);
			  
			  $file_name = $file_prefix.'-file2-'.substr(time(),-5).'.'.$final_ext[count($final_ext)-1];
			  $uploadfile = $uploaddir .$file_name;
			  if (move_uploaded_file($_FILES['ifile2']['tmp_name'], $uploadfile))
			  {
			  	$ifile2 = $ifile22 = '-file2-'.substr(time(),-5).'.'.$final_ext[count($final_ext)-1];
			  }
			  else
			  {
			  	Toast('error', $_ERROR, $_ADMIN_PIC_UPLOAD_ERROR);
			  	$ifile2 = "";
			  }
			 }
			}
		}
		else
		{
			if (isset($_POST['delpic2'])) {
				$delpic2 = $_POST['delpic2'];
			}
			else{
				$delpic2 = '';
			}
			if($delpic2!="1")
				$ifile2 = $ifile22 = $_REQUEST['ifile2_temp'];
		}
		//file2
		//file3
		$whitelist =  array("jpg", "png", "gif", "doc", "docx", "zip", "rar", "pdf", "mp4");
		$ext_error=0;
		if (!empty($_POST['delpic3'])) {
			$delpic3 = $_POST['delpic3'];
		}
		else{
			$delpic3 = '';
		}
		if($delpic3=="1")
		{
			$issue->DelPic($iid);
			$ifile3 = $ifile32 = '';
		}
		if(!empty($_FILES['ifile3']['name']))
		{
				
			$file_name = strtolower(basename($_FILES['ifile3']['name']));
			foreach ($whitelist as $ext)
			{
			 if(substr($file_name,-strlen($ext))!=$ext)
			  $ext_error++;
			}
			if($ext_error==count($whitelist))
			 	Toast('error', $_ERROR, $_ADMIN_PIC_EXTENSION_ERROR);
			else
			{
			 if($_FILES['ifile3']['size']>($_FILE_SIZE*1048576))
			  	Toast('error', $_ERROR, $_FILE_SIZE_ERROR);
			 else
			 {
			  $uploaddir = 'file_issue/file3/';
			  $final_ext = explode('.',$file_name);
			  
			  $file_name = $file_prefix.'-file3-'.substr(time(),-5).'.'.$final_ext[count($final_ext)-1];
			  $uploadfile = $uploaddir .$file_name;
	
			  if (move_uploaded_file($_FILES['ifile3']['tmp_name'], $uploadfile))
			  {
			  	$ifile3 = $ifile32 = '-file3-'.substr(time(),-5).'.'.$final_ext[count($final_ext)-1];
			  }
			  else
			  {
			  	Toast('error', $_ERROR, $_ADMIN_PIC_UPLOAD_ERROR);
			  	$ifile3 = "";
			  }
			 }
			}
		}
		else
		{
			if (isset($_POST['delpic3'])) {
				$delpic3 = $_POST['delpic3'];
			}
			else{
				$delpic3 = '';
			}
			if($delpic3!="1")
				$ifile3 = $ifile32 = $_REQUEST['ifile3_temp'];
		}
		//file3
		$ititle			= $_POST['ititle'];
		$iproirity		= $_POST['iproirity'];
		$icomplexity	= $_POST['icomplexity'];
		$ineeded_time	= $_POST['ineeded_time'];
		$tyid			= $_POST['tyid'];
		$prjid			= $_POST['prjid'];
		$iversion		= $_POST['iversion'];
		$idesc			= $_POST['idesc'];
		$iwho_fullname	= $_POST['iwho_fullname'];
		$iwho_email		= $_POST['iwho_email'];
		$iwho_tel		= $_POST['iwho_tel'];
		$iarchive		= $_POST['iarchive'];
		$idone			= $_POST['idone'];
		$idone_version	= $_POST['idone_version'];
		$task_move		= $_POST['task_move'];
		$idone_date 	= ($_POST['idone_date'] ==0 ? date('Y-m-d') 
												: ($language=='farsi' ? J2GD($_POST['idone_date']) : $_POST['idone_date'])); 
			
			if ($permissions[0]['allow_edit_issues']==1) {
				if($issue->UpdateFast($iid, $tyid, $prjid, $iversion, $ititle, $idesc, $iproirity, $icomplexity, $ineeded_time, $ifile1, $ifile2, $ifile3, $iarchive, $iwho_fullname, $iwho_email, $iwho_tel, $idone, $idone_date, $idone_version)==1){
					$task_issue->UpdateTask($task_move, $iid);
					Toast('success', $_SUCCESS, $_RECORD_EDITED_SUCCESSFULLI);
				}
				else{
					Toast('error', $_ERROR, $_EDITING_RECORD_FAILED.' ('.$_FILL_IN_REQUIRED.')');
				}
			}
			else{
				Toast('error', $_ERROR, $_ACCESS_DENIED);
			}
		break;
	case 'done_issue':
		$iid = $_POST['iid'];
		$tskid = $_POST['tskid'];
		$idone = "1";
		$idone_date = date('Y-m-d');
		if ($issue->UpdateDone($iid, $idone_date , $idone)==1) {
			Toast('success', $_SUCCESS, $_RECORD_ENDED_SUCCESSFULLI);
			echo '
				<script type="text/javascript">
					IssueInfo('.$iid.', '.$tskid.');
					IssueList('.$tskid.');
				</script>
			';
		}
		else{
			Toast('error', $_ERROR, $_ENDING_RECORD_FAILED);
		}
		break;
	case 'start_issue':
		$iid = $_POST['iid'];
		$tskid = $_POST['tskid'];
		$idone = NULL;
		$idone_date = 0;
		if ($issue->UpdateDone($iid, $idone_date , $idone)==1) {
			Toast('success', $_SUCCESS, $_RECORD_STARTED_SUCCESSFULLI);
			echo '
				<script type="text/javascript">
					IssueInfo('.$iid.', '.$tskid.');
					IssueList('.$tskid.');
				</script>
			';
		}
		else{
			Toast('error', $_ERROR, $_STARTING_RECORD_FAILED);
		}
		break;
	case 'delete_issue':
		$iid = $_POST['iid'];
		$tskid = $_POST['tskid'];
		if ($permissions[0]['allow_delete_issues']==1) {
			$task_issue->Delete($iid);
			if ($issue->Delete($iid)) 
			{
				Toast('success', $_SUCCESS, $_RECORD_DELETED_SUCCESSFULLI);
				echo '
				<script type="text/javascript">
					IssueInfo('.$iid.', '.$tskid.');
					IssueList('.$tskid.');
				</script>
				';
			}
			else
			{
				Toast('error', $_ERROR, $_DELETING_RECORD_FAILED);
			}
		}
		else{
			Toast('error', $_ERROR, $_ACCESS_DENIED);
		}
		break;

	case 'edit_task_form':
		$tskid 			= $_POST['tskid'];
		$taskInfo 		= $task->GetTaskInfoById($tskid);
		$tskcode 		= $taskInfo['tskcode'];
		$tsktitle 		= $taskInfo['tsktitle'];
		$tskdesc 		= $taskInfo['tskdesc'];
		$tskdone 		= $taskInfo['tskdone'];
		$tskdone_date 	= $taskInfo['tskdone_date'];
		$prjid 			= $taskInfo['prjid'];
		echo '
		<h3>'.$_SHOW.' '.$_TASK.'</h3>
		<div class="container-fload">
			<form id="form_edit_task" method="post" enctype="multipart/form-data">
				<div class="row">
				  <div class="col-md-4">
					  <div class="form-group">
					    <label for="tsktitle">'.$_TITLE.'<span class="required">*</span>:</label>
					    <input type="text" class="form-control" id="tsktitle" name="tsktitle" value="'.$tsktitle.'">
					  </div>
					  <div class="form-group">
					    <label for="tsktitle">'.$_MOVE.' '.$_TO.' '.$_PROJECT.'<span class="required">*</span>:</label>
					    <input type="hidden" value="'.(isset($_GET['tskid'])?$_GET['tskid']:'').'" id="tskid">
					    <select class="form-control" name="prjid" id="prjid" onclick ="loadVQs()" onkeyup="loadVQs()">
					    	';
					    if ($permissions[0]['asuper_admin']==1) {
					    	$projectlist= $project->GetList();
					    }
					    else{
					    	$aid= $permissions[0]['aid'];
					    	$query = "WHERE aids=$aid";
					    	$projectlist = $admins_tasks->GetListPrjAdmin($query);
					    }
					    $prj_list = [];
					    foreach ($projectlist as $projectInfo) {
					    	if (!in_array($projectInfo['prjid'], $prj_list)) {
					    		echo'<option value="'.$projectInfo['prjid'].'" '.($projectInfo['prjid']==$prjid?'selected':'').'>'.$projectInfo['prjtitle'].'</option>';
					    		array_push($prj_list, $projectInfo['prjid']);
					    	}
					    }

					    echo'
					    </select>
					  </div>
				  </div>
				  <div class="col-md-4">
					<div class="form-group">
						<label for="tskdesc">'.$_DESC.':</label>
						<textarea id="tskdesc" name="tskdesc" class="form-control editor" rows="3">'.$tskdesc.'</textarea>
					</div>
				    <div class="row">
				      <div class="col-md-6">
						<div class="form-group">
				      	  <label for="tskdone">'.$_CONDITION.':</label>
				      	  <div class="radio">
					      	  <label>
					      	    <input type="radio" name="tskdone" id="tskdone1" value="1" '.($tskdone==1?'checked':'').'>
					      	    '.$_DONE.'
					      	  </label>
					      	  <label>
					      	    <input type="radio" name="tskdone" id="tskdone2" value="0"'.($tskdone==0?'checked':'').'>
					      	    '.$_UNDONE.'
					      	  </label>
					      </div>
				      	</div>
					  </div>
				      <div class="col-md-6">
						  <div class="form-group">
						    <label for="tskdone_date">'.$_COMPLETION_DATE.':</label>
						    <input id="tskdone_date" type="'.($language=='farsi'?'text':'date').'" class="form-control input" name="tskdone_date" value="'.($tskdone_date==0?'':($language=='farsi'?G2JD($tskdone_date):$tskdone_date)).'">';
						    if ($language == 'farsi') {
						    	echo'
							    <script type="text/javascript">
							    	kamaDatepicker(\'tskdone_date\', { buttonsColor: "red",markToday: "true" , highlightSelectedDay: "true" , gotoToday: "true", nextButtonIcon: "img/timeir_next.png", previousButtonIcon: "img/timeir_prev.png"});
							    </script>';
						    }
						    echo'
						  </div>
				      </div>
				    </div>
				  </div>
				  <div class="col-md-4">
				  	<div id="show-resault-set_admin"></div>';
				  	if ($permissions[0]['asuper_admin']==1) {
  	  	    			$adminlist = $admin->GetList();
	  	  	    		$adminIdTask = array();
	  	    			$query = "WHERE tskid=$tskid";
		  	    		$admins_task = $admins_tasks->GetList($query);
		  	    		foreach ($admins_task as $key => $adminTaskInfo) {
		  	    			array_push($adminIdTask, $adminTaskInfo['aids']);
		  	    		}
	  	  	        	echo '
					  	<label for="tskdesc">'.$_ADMINS.':</label>
					  	<select class="js-example-basic-multiple-user w-100" multiple="multiple" id="admins" name="admins">';
				  			foreach ($adminlist as $adminInfo) {
				  				if ($adminInfo['aid']!=1) {
				  		       echo'
					  	  		<option value="'.$adminInfo['aid'].'" '.(in_array($adminInfo['aid'], $adminIdTask) ? 'selected' : '').'>'.$adminInfo['ausername'].'</option>
					  	  		';
				  				}
				  	    	}
				  	    	echo'
					  	</select>
					  	';
					  }
					echo '
				  </div>
				</div>
			</form>
			<ul class="list-inline">
	  			<li class="left_list">';
	  			if ($permissions[0]['allow_edit_task']==1) {
    				echo'
    					<button class="btn btn-success" onclick="editTaskForm('.$tskid.', '.$permissions[0]['aid'].')">'.$_EDIT.'</button>
    				';
    			}
				echo'
	  			</li>';
	  			if ($permissions[0]['allow_delete_task']==1) {
  				echo'
	  			<li>
	  				<a class="btn btn-link" onclick="return Sure();" style="color: red;" href="?op=delete&tskid='.$tskid.'">'.$_DELETE.'</a>
	  			</li>';
	  			}
	  			echo'
	  		</ul>
			<div id="resault-edit_task"></div>
		</div>
		';
		break;
	case 'edit_task':
		$tskid 			= $_POST['tskid'];
		$tsktitle 		= $_POST['tsktitle'];
		$prjid 			= $_POST['prjid'];
		$tskdesc 		= $_POST['tskdesc'];
		$tskdone 		= $_POST['tskdone'];
		$admins 		= isset($_POST['admins']) ? $_POST['admins'] : array();
		$admin_id 		= $permissions[0]['aid'];
		$tskdone_date = (!empty($_POST['tskdone_date'])?($language=='farsi'?J2GD($_POST['tskdone_date']):$_POST['tskdone_date']):NULL);

		$query = "WHERE tskid=$tskid";
		$admins_task = $admins_tasks->GetList($query);
		foreach ($admins_task as $key => $value) {
			if (!in_array($value['aids'], $admins)) {
				$admins_tasks->Delete($value['atid']);
			}
		}

		if ($permissions[0]['allow_edit_task']==1) {
			if($task->UpdateFast($prjid, $tskid, $tsktitle, $tskdesc, $tskdone, $tskdone_date)==1 || !empty($admins)){
				if (!empty($admins)) {
					foreach ($admins as $aid) {
						$admins_tasks->Add($aid, $tskid);
					}
				}
				Toast('success', $_SUCCESS, $_RECORD_EDITED_SUCCESSFULLI);
			}
			else{
				Toast('error', $_ERROR, $_EDITING_RECORD_FAILED.'('.$_NOT_CHANGED_RECORD.')');
			}					
		}
		else{
			Toast('error', $_ERROR, $_ADMIN_YOU_DO_NOT_HAVE_NECCESSARY_PERMISSIONS);
		}

		break;
	case 'show_user_task':
		$tskid = $_POST['task_id'];

		$adminlist = $admin->GetList();

		$query = "WHERE tskid=$tskid";
		$admins_task = $admins_tasks->GetList($query);
		$adminTaskInfo2 ='';
		foreach ($admins_task as $key => $adminTaskInfo) {
			$adminTaskInfo2=$adminTaskInfo2.'-'.$adminTaskInfo['aids'];
		}

		$adminIdTask = explode('-', $adminTaskInfo2);
		// print_r($adminIdTask);
		

		echo '
			<a href="#" class="btn btn-link" onclick="hideShowUser()">
				<i class="fal fa-times"></i>
			</a>
			<div class="list-group">';
			foreach ($adminlist as $adminInfo) {
				if ($adminInfo['aid']!=1) {
		       		echo'
		       		<a href="#" class="list-group-item list-group-item-action '.(in_array($adminInfo['aid'], $adminIdTask) ? 'list-group-item-success' : '').'">
		       		  '.(in_array($adminInfo['aid'], $adminIdTask) ? '<i class="fal fa-check-square text-success"></i>' : '<i class="fal fa-square"></i>').' '.$adminInfo['ausername'].'
		       		</a>
		      		';
				}
	    	}
	    	echo'
			</div>
		';
		break;
	case 'set_admin_task':
		$tskid 			= $_POST['tskid'];
		$admin_id 		= $_POST['admin_id'];
		$query 			= "WHERE tskid=$tskid && aids = $admin_id";
		$check_admin 	= $admins_tasks->GetList($query);
		PRINTR($check_admin);
		echo "string";
		break;
	
	default:
		# code...
		break;
}

 ?>