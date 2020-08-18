<?php 
require_once 'main.php';
require_once 'header.php';
$active = '';
$active = 'active';
$op = $_GET['op'];
$project = new ManageProjects();
$issue = new ManageIssues();
$task = new ManageTasks();
$task_issue = new ManageTasks_issues();
$issue_types = new ManageIssue_types();
$admin = new ManageAdmins();
$admins_tasks = new ManageAdmins_Tasks();
	switch ($_GET['op']) {
		case 'add':
			require_once 'menu.php';
			
			$tskcode= $tsktitle= $tskdesc= $tskdone= $tskdone_date='';
			$legend = ''._ADD.' '._TASK.'';
			if (isset($_POST['add'])) {
				// $adminInfo=$admin->GetAdminInfo($_COOKIE['linka_admin']);
				// $cookie_admin= explode(':', $_COOKIE['linka_admin']);
				// if($admin->AdminPermission($cookie_admin[0],"asuper_admin"))
				// {

					$tskcode = $_POST['tskcode'];
					$tsktitle = $_POST['tsktitle'];
					$tskdesc = $_POST['tskdesc'];
					$tskdone = (isset($_POST['tskdone'])?$_POST['tskdone']:0);
					$tskdone_date = (isset($_POST['tskdone_date'])?$_POST['tskdone_date']:NULL);
					$prjid = $_POST['prjid'];
					$aid = $permissions[0]['aid'];
					
					if (empty($tsktitle)) {
						Toast('error', 'خطا', _FILL_IN_REQUIRED);
					} 
					else 
					{		
						if ($permissions[0]['allow_add_task']==1) {					
							if (preg_match('/^[اآبپتثئجچحخدذرزژسشصضطظعغفقکگلمنوهی\s]+$/', $tskcode)==1 || strpos($tskcode, " ")!==false) {
						        Toast('error', 'خطا', _INVALID_CODE);
						    }
						    else{
								if ($task->Add($prjid, $tskcode, $tsktitle, $tskdesc, $tskdone, $tskdone_date, $aid)==1) {
									$tskid = $task->LastID();
									if (isset($_POST['iid'])) {
										$iids = $_POST['iid'];
										foreach ($iids as $iid => $iid2) {
											$task_issue->Add($tskid, $iid);
										}
									}
									if (isset($_POST['aid'])) {
										$aids = $_POST['aid'];
										foreach ($aids as $aid => $aid2) {
											$admins_tasks->Add($aid, $tskid);
										}
									}
									Toast('success', 'موفق', _RECORD_ADDED_SUCCESSFULLI);
									$tskcode= $tsktitle= $tskdesc= $tskdone= $tskdone_date=$prjid='';
								}
								else{
									Toast('error', 'خطا', _ADDING_RECORD_FAILED);
								}
							}
						}
						else{
							Toast('error', 'خطا', _ACCESS_DENIED);
						}
					}
				// }
				// else{
				// 		$error = _ADMIN_YOU_DO_NOT_HAVE_NECCESSARY_PERMISSIONS;
				// }
			}
			elseif (isset($_GET['tskid'])) {
				$tskid= $_GET['tskid'];
				if (isset($_POST['edit'])) {
					// $adminInfo=$admin->GetAdminInfo($_COOKIE['linka_admin']);
					// $cookie_admin= explode(':', $_COOKIE['linka_admin']);
					// if($admin->AdminPermission($cookie_admin[0],"asuper_admin"))
					// {	
					$tskcode = $_POST['tskcode'];
					$tsktitle = $_POST['tsktitle'];
					$tskdesc = $_POST['tskdesc'];
					$tskdone = $_POST['tskdone'];
					$tskdone_date = (!empty($_POST['tskdone_date'])?($language=='farsi'?J2GD($_POST['tskdone_date']):$_POST['tskdone_date']):NULL);
					$prjid = $_POST['prjid'];
					$aids = (isset($_POST['aid'])?$_POST['aid']:'');
					$iids = (isset($_POST['iid'])?$_POST['iid']:'');
					if ($permissions[0]['allow_edit_task']==1) {
						if (preg_match('/^[اآبپتثئجچحخدذرزژسشصضطظعغفقکگلمنوهی\s]+$/', $tskcode)==1 || strpos($tskcode, " ")!==false) {
					        Toast('error', 'خطا', _INVALID_CODE);
					    }
					    else{
							if($task->Update($prjid, $tskid, $tskcode, $tsktitle, $tskdesc, $tskdone, $tskdone_date)==1 || !empty($aids) || !empty($iids)){
								if (!empty($aids)) {
									foreach ($aids as $aid => $aid2) {
										$admins_tasks->Add($aid, $tskid);
									}
								}
								if (!empty($iids)) {
									foreach ($iids as $iid => $iid2) {
										$task_issue->Add($tskid, $iid);
									}
								}
								Toast('success', 'موفق', _RECORD_EDITED_SUCCESSFULLI);
							}
							else{
								Toast('error', 'خطا', _EDITING_RECORD_FAILED.'('._NOT_CHANGED_RECORD.')');
							}
						}
											
					}
					else{
						Toast('error', 'خطا', _ADMIN_YOU_DO_NOT_HAVE_NECCESSARY_PERMISSIONS);
					}
				}
				$admin_tasklist = $admins_tasks->GetAidByTskid($tskid);
				$taskInfo = $task->GetTaskInfoById($tskid);
				$legend = ''._EDIT.' '._TASK.' ';
				$tskcode = $taskInfo['tskcode'];
				$tsktitle = $taskInfo['tsktitle'];
				$tskdesc = $taskInfo['tskdesc'];
				$tskdone = $taskInfo['tskdone'];
				$tskdone_date = $taskInfo['tskdone_date'];
				$prjid = $taskInfo['prjid'];
			}
			echo '
			<div class="col-sm-12 col-md-12 jumbotron" id="content"  onload="loadVQs()">
				';

			if ($permissions[0]['allow_add_task']==1 || $permissions[0]['allow_edit_task']) {
			echo'
				<p class="lead">'.$legend.' ';
				if ($permissions[0]['allow_add_task']==1) {
					(isset($_GET['tskid'])?AddLogo('?op=add'):'');
				}
				if ($permissions[0]['allow_list_task']==1) {
					ListLogo('?op=list');
				}
				ChartLogo('?op=chart');
				echo'
				</p>
				<form method="post">
				<div class="row">
				  <div class="col-md-4">
					  <div class="form-group">
					    <label for="tskcode">'._CODE.':</label>
					    <input autofocus="" type="text" class="form-control" id="tskcode" name="tskcode" style="direction:ltr;" value="'.$tskcode.'">
					  </div>
					  <div class="form-group">
					    <label for="tsktitle">'._TITLE.'<span class="required">*</span>:</label>
					    <input type="text" class="form-control" id="tsktitle" name="tsktitle" value="'.$tsktitle.'">
					  </div>
					  <div class="form-group">
					    <label for="tsktitle">'._FOR.' '._PROJECT.'<span class="required">*</span>:</label>
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
					  ';
					  	if ($permissions[0]['asuper_admin']==1) {
					  	echo'
						  <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#issueList" aria-expanded="false" aria-controls="issueList" onclick="loadVQs()">
						    '._RELATED_ISSUES_LIST.'
						  </button>
					  		<script>
					  	      function loadVQs() {
					  	        $("#vqs").html(\'<img src="img/wait.gif">\');
					  			var prjid= $("#prjid").val();
					  			var tskid= $("#tskid").val();
					  	        $.ajax({
					  	          url: "aj.php",
					  	          type: "POST",
					  	          data: {op:"issue_prjid",prjid:$("#prjid").val(),tskid:$("#tskid").val()},
					  	          success: function(data,status) {
					  	            $("#vqs").html(data);
					  	          },
					  	          error: function() {$("#vqs").html("problem in ajax")}
					  	        });
					  	      }
					        </script>
						  <div class="collapse" id="issueList" style="direction:ltr;">
					  		<div class="well">
						  		<div id="vqs" style="direction:rtl; text-align:right; "></div>
						  	</div>
				  	  	  </div>';
				  	  	}
			  	  	  if (isset($_GET['tskid'])) {
			  	  	  	echo'
					    <div class="row">
					      <div class="col-md-6">
							<div class="form-group">
					      	  <label for="tskdone">'._CONDITION.':</label>
					      	  <div class="radio">
						      	  <label>
						      	    <input type="radio" name="tskdone" id="tskdone1" value="1" '.($tskdone==1?'checked':'').'>
						      	    '._DONE.'
						      	  </label>
						      	  <label>
						      	    <input type="radio" name="tskdone" id="tskdone2" value="0"'.($tskdone==0?'checked':'').'>
						      	    '._UNDONE.'
						      	  </label>
						      </div>
					      	</div>
						  </div>
					      <div class="col-md-6">
							  <div class="form-group">
							    <label for="tskdone_date">'._COMPLETION_DATE.':</label>
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
					    </div>';
			  	  	  	}
			  	  	  	if ($permissions[0]['asuper_admin']==1) {
				  	  	  echo'
						  	<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#add_admin_task" aria-expanded="false" aria-controls="add_admin_task">
						  	  '._ADD.' '._ADMIN.'
						  	</button>
						  	<div class="collapse" id="add_admin_task" style="direction:ltr;">
						  	  <div class="well">
				  	    		<div class="checkbox">';
				  	    		$adminlist = $admin->GetList();
				  	    		if (isset($_GET['tskid'])) {
				  	    			$query = "WHERE tskid=$tskid";
					  	    		$admins_task = $admins_tasks->GetList($query);
					  	    		$adminTaskInfo2 ='';
					  	    		foreach ($admins_task as $key => $adminTaskInfo) {
					  	    			$adminTaskInfo2=$adminTaskInfo2.'-'.$adminTaskInfo['aids'];
					  	    		}
					  	    		$adminIdTask = explode('-', $adminTaskInfo2);
				  	    			
				  	    		}
				  	    		else{
				  	    			$adminIdTask = array('hello' => 0);
				  	    		}
				  	    		// print_r($adminIdTask);
				  	    		foreach ($adminlist as $adminInfo) {
				  	    			if (!in_array($adminInfo['aid'], $adminIdTask) && $adminInfo['aid']!=1) {
				  	    	       echo'
				  	    	      <label>
				  	    	       <input type="checkbox" id="aid" name="aid['.$adminInfo['aid'].']">&nbsp&nbsp '.$adminInfo['ausername'].'
				  	    	      </label> <br>';
				  	    			}
				  	        	}
				  	          echo'
				  	    		</div>
						  	  </div>
						  	</div>
						  
						  	    ';
						}
					  	  if (isset($_GET['tskid'])) {
					  	  	echo'
					  	  	<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" onclick="list_admin_task('.$_GET['tskid'].')">
					  	  	  '._LIST.' '._ADMINS.'
					  	  	</button>
					  	  	<div class="collapse" id="collapseExample" style="direction:ltr;">
					  	  	  <div class="well" id="lat">
					    	    		<script>
					    	    	      function list_admin_task(id) {
					    	    	        $("#lat").html(\'<img src="img/wait.gif">\');
					    	    			var tskid= $("#tskid").val();
					    	    	        $.ajax({
					    	    	          url: "aj.php",
					    	    	          type: "POST",
					    	    	          data: {op:"list_admin_task",tskid:$("#tskid").val()},
					    	    	          success: function(data,status) {
					    	    	            $("#lat").html(data);
					    	    	          },
					    	    	          error: function() {$("#lat").html("problem in ajax")}
					    	    	        });
					    	    	      }
					    	          </script>
					  	  	  </div>
					  	  	</div>
					    	    <div id="dat"></div>
					  	  <input type="hidden" value="'.$_GET['tskid'].'" id="tskid">
					  	 		';
					  	  	}
					  	  	echo'
				  </div>
				  <div class="col-md-8">
					  <div class="form-group">
					    <label for="tskdesc">'._DESC.':</label>
					    <textarea id="tskdesc" name="tskdesc" class="form-control editor" rows="3">'.$tskdesc.'</textarea>
					  </div>
					  ';
				  	if (isset($_GET['tskid'])) {
				  		echo '
				  		<ul class="list-inline">
				  			<li class="left_list">';
			    			UpdateForm('edit');
							echo'
				  			</li>';
				  			if ($permissions[0]['allow_delete_task']==1) {
			  				echo'
				  			<li>
				  				<a class="btn btn-link" onclick="return Sure();" style="color: red;" href="?op=delete&tskid='.$tskid.'">'._DELETE.'</a>
				  			</li>';
				  			}
				  			echo'
				  		</ul>
				  		';
				  	}
				  	else {
				  		echo '<div style="text-align:left;">';
							AddForm('add');
				  		echo'</div>';			
				  	}
				  	echo'

				  </div>
				</div>
				</form>';
			}
			else{
				Toast('error', 'خطا', _ACCESS_DENIED);
			}
			echo'
    		</div>
			';
			break;
		case 'list':
			require_once 'menu.php';
			$query=$q=$filter=$order="";
			$start=$page=0;
			$aid = $permissions[0]['aid'];
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
			if ($aid==1) {
				if (isset($_POST['search']) && $_POST['q']!=="") 
				{
					$q= $_POST['q'];
					$filter= $_POST['filter'];
					$query= "WHERE $filter LIKE '%$q%'";
				}
				else{
					$query = "";
					// $order ="ORDER BY tskdone,tskid DESC";
				}
				$tasklist = $task->GetList($query,$order,$limit="LIMIT $start,$page_limit");
			}
			else{
				if (isset($_POST['search']) && $_POST['q']!=="") 
				{
					$q= $_POST['q'];
					$filter= $_POST['filter'];
					$query= "WHERE aids=$aid&&$filter LIKE '%$q%'";
				}
				else{
					$query = "WHERE aids=$aid";
					// $order ="ORDER BY tskdone,atid DESC";
				}
				$tasklist= $admins_tasks->GetList_task($query, $order,$limit="LIMIT $start,$page_limit");
			}
			$num_of_records=  $admins_tasks->RowCount($query);
			$num_of_pages= intval($num_of_records/$page_limit);
			$num_of_pages= ($num_of_records%$page_limit==0?$num_of_pages:$num_of_pages+1);
			if (isset($_GET['prjid'])) {
				$prjid = '&prjid='.$_GET['prjid'];
				$prjid2 = $_GET['prjid'];
				$project_info = $project->GetProjectInfoById($prjid2);
				$project_title = _FOR.' '._PROJECT.' '.$project_info[2].'';
			}
			else{
				$prjid = '';
				$project_title = '';
			}
				echo '
				<div class="col-sm-12 col-md-12 jumbotron" id="content">';
				if ($permissions[0]['allow_list_task']==1) {
				echo'
				<div class="row">
				  <div class="col-md-4">
					<p class="lead">'._TASKS.' ';
					if ($permissions[0]['allow_add_task']==1) {
						AddLogo('?op=add');
					}
					ChartLogo('?op=chart'.$prjid.'');
					echo'
					  <br><small><small>'.$project_title.'</small></small>
					</p>
				  </div>
				  <div class="col-md-8">
					<form action="" method="post" class="form-inline form_search">
						<div class="form-group">
							<input autofocus="" type="text" value="'.$q.'" class="form-control input-sm" id="q" name="q" placeholder="'._SEARCH_TEXT.'">
						</div>
						<select name="filter" class="form-control input-sm">
							<option '.($filter=="tskcode"?'selected':'').' value="tskcode">'._CODE.'</option>
							<option '.($filter=="tsktitle"?'selected':'').' value="tsktitle">'._TITLE.'</option>
							<option '.($filter=="tskdesc"?'selected':'').' value="tskdesc">'._DESC.'</option>
							<option '.($filter=="tskdate"?'selected':'').' value="tskdate">'._INSERT_DATE.'</option>
							<option onclick="alert(\'  '._DONE.': 1 / '._UNDONE.' : 0\')" '.($filter=="tskdone"?'selected':'').' value="tskdone">'._DONE_TASKS.'</option>
							<option '.($filter=="tskdone_date"?'selected':'').' value="tskdone_date">'._COMPLETION_DATE.'</option>
						</select>';
						if ($num_of_pages>1) {
							echo' '._PAGE_NUMBER.':<select name="page" class="form-control input-sm">';
							for ($i=0; $i < $num_of_pages; $i++) { 
								echo'
								<option value="'.$i.'"'.($i==$page?'selected':'').'>'.($i+1).'</option>
								';
							}
							echo '
								</select>';
						}
						echo'
					'._NUMBER_OF_PER_PAGE.':
					<select class="form-control input-sm" id="page_limit" name="page_limit">
						<option '.($page_limit=="5"?'selected':'').' value="5">5</option>
						<option '.($page_limit=="10"?'selected':'').' value="10">10</option>
						<option '.($page_limit=="20"?'selected':'').' value="20">20</option>
						<option '.($page_limit=="50"?'selected':'').' value="50">50</option>
						<option '.($page_limit=="100"?'selected':'').' value="100">100</option>
					</select>
					 <button type="submit" name="search" class="btn btn-light btn-sm">'._SEARCH.'</button>
					</form><br>
				  </div>
				</div>
					<div class="table-responsive">
						<table class="table table-bordered table-hover table-striped">
							<tr class="table_header info">
								<th width="30px">'._TOOLS.'</th>
								<th width="30px">
									<a href="?op=list&order=tskcode'.(isset($_GET['desc'])?'':'&desc').'">'._CODE.':
										<span class="fas fa-collapse'.($_GET['order']=='tskcode' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
									</a></th>
								<th>
									<a href="?op=list&order=tsktitle'.(isset($_GET['desc'])?'':'&desc').'">'._TITLE.' <span class="fas fa-collapse'.($_GET['order']=='tsktitle' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
									</a></th>
								<th width="300px">
									<a href="?op=list&order=tskdesc'.(isset($_GET['desc'])?'':'&desc').'">'._DESC.' <span class="fas fa-collapse'.($_GET['order']=='tskdesc' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
									</a></th>
								<th width="100px">
									<a href="?op=list&order=tskdate'.(isset($_GET['desc'])?'':'&desc').'">'._INSERT_DATE.' <span class="fas fa-collapse'.($_GET['order']=='tskdate' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
									</a></th>
								<th width="50px">
									<a href="?op=list&order=tskdone'.(isset($_GET['desc'])?'':'&desc').'">'._DONE_TASKS.' <span class="fas fa-collapse'.($_GET['order']=='tskdone' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
									</a></th>
								<th width="100px">
									<a href="?op=list&order=tskdone_date'.(isset($_GET['desc'])?'':'&desc').'">'._COMPLETION_DATE.' <span class="fas fa-collapse'.($_GET['order']=='tskdone_date' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
									</a></th>
								<th width="100px">
									<a href="?op=list&order=prjid'.(isset($_GET['desc'])?'':'&desc').'">'._FOR.' '._PROJECT.' <span class="fas fa-collapse'.($_GET['order']=='prjid' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
									</a></th>
								<th width="100px">
									<a href="?op=list&order=aid'.(isset($_GET['desc'])?'':'&desc').'">'._INSERTED_BY.'
										<span class="fas fa-collapse'.($_GET['order']=='aid' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
									</a></th>
							</tr>
					';
					
					foreach ($tasklist as $taskInfo) {
						$prjid2 = (isset($_GET['prjid'])?$_GET['prjid']:$taskInfo['prjid']);
						$projectlist=$project->GetProjectInfoById($prjid2);
						if ($taskInfo['prjid']==$projectlist['prjid']) {
							echo '
							<tr class="'.($taskInfo['tskdone']==1?'success':'').'" style="'.($taskInfo['tskdone']==1?'color:#A6A6A6;':'').'">
								<td>
								<div style="text-align:rtl;" dir="rtl">
									<!-- Extra small button group -->
									<div class="dropdown">
										<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										  <span class="fas fa-menu-hamburger"></span>'._TOOLS.'
										</button>
										<div class="dropdown-menu text-right">';
							  			if ($permissions[0]['allow_edit_task']==1) {
							  				echo'
											<a class="dropdown-item" href="?op=add&tskid='.$taskInfo['tskid'].'">'._EDIT.'</a>';
							  			}
							  			if ($permissions[0]['allow_delete_task']==1) {
							  			echo'
											<a class="dropdown-item" onclick="return Sure();" style="color: red;" href="?op=delete&tskid='.$taskInfo['tskid'].'">'._DELETE.'</a>';
							  			}
							  			if ($permissions[0]['allow_list_issues']==1) {
							  			echo'
											<a class="dropdown-item" href="issues.php?op=list&tskid='.$taskInfo['tskid'].'">'._ISSUES.' '._THIS.' '._TASK.'</a>';
										}
							  			echo'
											<a class="dropdown-item" href="javascript:print_task('.$taskInfo['tskid'].')">'._PRINT.'</a>
									</div>
									<script type="text/javascript">
										function print_task(id){
											$("#tskid").val(id);
											$("#select_print_task").modal()
										}
										function reset_password_hide(){
											document.getElementById(\'select_print_task\').style.display = "none";
										}
									</script>
									<div class="modal fade" id="select_print_task">
									  <div class="modal-dialog">
									    <div class="modal-content">
									        <form action="?op=print" method="post" name="reset_student_pass" target="_blank">
										      <div class="modal-header">
										        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										        <h4 class="modal-title">'._PRINT.' '._TASK.'</h4>
										      </div>
										      <div class="modal-body">
										      <div class="checkbox">
										        <label>
										          <input type="checkbox" value="" name="issue_all">
										          '._PRINTED_DESC_ISSUE.'
										        </label>
										      </div>
												<br>
												<input type="hidden" class="form-control" name="tskid" id="tskid" value="">
										      </div>
										      <div class="modal-footer">
										        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
										        <button type="submit" class="btn btn-primary">'._PRINT.'</button>
										      </div>
										    </div><!-- /.modal-content -->
											</form>
									  </div><!-- /.modal-dialog -->
									</div><!-- /.modal -->
								  </div>
								</div>
								</td>
								<td style="text-align:ltr;" dir="ltr"><strong>'.$taskInfo['tskcode'].'</strong>
								
								</td>
								<td><strong>'.$taskInfo['tsktitle'].'</strong></td>
								<td><div class="overflow_list">'.$taskInfo['tskdesc'].'</div></td>
								<td style="text-align: left;">'.($language=='farsi'?G2J($taskInfo['tskdate']):$taskInfo['tskdate']).'</td>
								<td>'.($taskInfo['tskdone']==0?''._UNDONE.'':''._DONE.'').'</td>
								<td style="text-align: left;">'.($taskInfo['tskdone_date']==0?''._UNDONE.'':($language=='farsi'?G2JD($taskInfo['tskdone_date']):$taskInfo['tskdone_date'])).'</td>';
								$projectlist=$project->GetProjectInfoById($taskInfo['prjid']);
								echo'
								<td>'.$projectlist['prjtitle'];
									if(file_exists('img/project/'.$pic_prefix.$projectlist['prjlogo'].''))
										$prjlogo = 'img/project/'.$pic_prefix.$projectlist['prjlogo'].'';
									else
										$prjlogo = 'img/proja.png';
										
									echo '
										<img src="'.$prjlogo.'" style="height:30px;">
								</td>';
								$adminlist=$admin->GetAdminInfoById($taskInfo['aid']);
								echo'
								<td>'.$adminlist['ausername'].'</td>
							</tr>			
						</div>';
						}
					}
				}
				else{
					Toast('error', 'خطا', _ACCESS_DENIED);
				}
			break;
	case 'chart':
		require_once 'menu.php';
		echo '
			<div class="col-sm-12 col-md-12" id="content">';
			if ($permissions[0]['allow_list_task']==1) {
				$query=$q=$filter=$order="";
				$start=$page=0;
				$aid = $permissions[0]['aid'];
				if (isset($_POST['search'])) {
					$page_limit = $_POST['page_limit'];
					$page=$page=(isset($_POST['page'])?$_POST['page']:'');
					$start= $page*$page_limit;
				}
				if (isset($_GET['order'])) {
					$order = $_GET['order'];
					$order = "ORDER BY $order ".(isset($_GET['desc'])?'desc':'');
				}
				if ($aid==1) {
					if (isset($_POST['search']) && $_POST['q']!=="") 
					{
						$q= $_POST['q'];
						$filter= $_POST['filter'];
						$query= "WHERE $filter LIKE '%$q%'";
					}
					else{
						$query = "";
						$order ="ORDER BY tskdone,tskid DESC";
					}
					$tasklist = $task->GetList($query,$order,$limit="LIMIT $start,$page_limit");
				}
				else{
					if (isset($_POST['search']) && $_POST['q']!=="") 
					{
						$q= $_POST['q'];
						$filter= $_POST['filter'];
						$query= "WHERE aids=$aid&&$filter LIKE '%$q%'";
					}
					else{
						$query = "WHERE aids=$aid";
						$order ="ORDER BY tskdone,atid DESC";
					}
					$tasklist= $admins_tasks->GetList_task($query, $order,$limit="LIMIT $start,$page_limit");
				}
				$num_of_records=  $admins_tasks->RowCount($query);
				$num_of_pages= intval($num_of_records/$page_limit);
				$num_of_pages= ($num_of_records%$page_limit==0?$num_of_pages:$num_of_pages+1);
				if (isset($_GET['prjid'])) {
					$prjid = '&prjid='.$_GET['prjid'];
					$prjid2 = $_GET['prjid'];
					$project_info = $project->GetProjectInfoById($prjid2);
					$project_title = $project_info[2];
					echo '
						<style type="text/css">
							body {
								background-color: '.$project_info['bg_color'].';
								background-image: linear-gradient('.$project_info['bg_color'].', '.$project_info['bg_color'].');
							}
						</style>
					';
				}
				else{
					$prjid = '';
					$project_title = '';
				}
				echo'
				<div class="row">
				  <div class="col-md-4">
					  <p class="lead">
					  	'.$project_title.'
					  </p>
				  </div>
				  <div class="col-md-8">
					<form action="" method="post" class="form-inline form_search">
						<div class="form-group">
							<input autofocus="" type="text" value="'.$q.'" class="form-control input-sm" id="q" name="q" placeholder="'._SEARCH_TEXT.'">
						</div>
						<select name="filter" class="form-control input-sm">
							<option '.($filter=="tskcode"?'selected':'').' value="tskcode">'._CODE.'</option>
							<option '.($filter=="tsktitle"?'selected':'').' value="tsktitle">'._TITLE.'</option>
							<option '.($filter=="tskdesc"?'selected':'').' value="tskdesc">'._DESC.'</option>
							<option '.($filter=="tskdate"?'selected':'').' value="tskdate">'._INSERT_DATE.'</option>
							<option onclick="alert(\'  '._DONE.': 1 / '._UNDONE.' : 0\')" '.($filter=="tskdone"?'selected':'').' value="tskdone">'._DONE_TASKS.'</option>
							<option '.($filter=="tskdone_date"?'selected':'').' value="tskdone_date">'._COMPLETION_DATE.'</option>
						</select>';
						if ($num_of_pages>1) {
							echo' '._PAGE_NUMBER.':<select name="page" class="form-control input-sm">';
							for ($i=0; $i < $num_of_pages; $i++) { 
								echo'
								<option value="'.$i.'"'.($i==$page?'selected':'').'>'.($i+1).'</option>
								';
							}
							echo '
								</select>';
						}
						echo'
					'._NUMBER_OF_PER_PAGE.':
					<select class="form-control input-sm" id="page_limit" name="page_limit">
						<option '.($page_limit=="5"?'selected':'').' value="5">5</option>
						<option '.($page_limit=="10"?'selected':'').' value="10">10</option>
						<option '.($page_limit=="20"?'selected':'').' value="20">20</option>
						<option '.($page_limit=="50"?'selected':'').' value="50">50</option>
						<option '.($page_limit=="100"?'selected':'').' value="100">100</option>
					</select>
					 <button type="submit" name="search" class="btn btn-light btn-sm">'._SEARCH.'</button>
					</form><br>
				  </div>
				</div>
					<div class="row">
						<div id="show-resault-delete_task"></div>
				  ';
				foreach ($tasklist as $taskInfo) {
					$prjid2 = (isset($_GET['prjid'])?$_GET['prjid']:$taskInfo['prjid']);
					$projectlist=$project->GetProjectInfoById($prjid2);
					if ($taskInfo['prjid']==$projectlist['prjid']) {
						echo'
						  <div class="col-sm-3 col-md-3 mt-2">
							<div class="card border-'.($taskInfo['tskdone']==1?'success':'primary').'">
							  <div class="card-header">
							    <ul class="list-inline p-0">
								    <li class="right_list list-inline-item">
						    			<div class="dropdown">
						    	           <a class="dropdown-toggle no-toggle btn btn-light btn-sm" id="menu-item" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="position: relative; right: -12px;">
						    	           		<i class="fas fa-ellipsis-v" aria-hidden="true"></i>
						    	           </a>
						    	           <div class="dropdown-menu" aria-labelledby="menu-item">
						    	           ';
								  			if ($permissions[0]['allow_edit_task']==1) {
								  				echo'
						    	             <a class="dropdown-item" href="?op=add&tskid='.$taskInfo['tskid'].'">'._EDIT.'</a>';
								  			}
								  			if ($permissions[0]['allow_delete_task']==1) {
								  			echo'
						    	             <a class="dropdown-item" onclick="return Sure();" href="javascript: deleteTask('.$taskInfo['tskid'].')" style="color: red;">'._DELETE.'</a>';
								  			}
								  			echo'
						    	             <a class="dropdown-item" href="issues.php?op=chart&tskid='.$taskInfo['tskid'].'">'._ISSUES.' '._THIS.' '._TASK.'</a>';
								  			echo'
								  			<a class="dropdown-item" href="javascript:print_task('.$taskInfo['tskid'].')">'._PRINT.'</a>
						    	           ';
								  			if ($permissions[0]['allow_edit_task']==1) {
								  				echo'
						    	             <a class="dropdown-item" href="?op=add&tskid='.$taskInfo['tskid'].'">'._END.'</a>';
								  			}
								  			echo'
						    	           </div>
							    	        <script type="text/javascript">
		 										function print_task(id){
		 											$("#tskid").val(id);
		 											$("#select_print_task").modal()
		 										}
		 										function reset_password_hide(){
		 											document.getElementById(\'select_print_task\').style.display = "none";
		 										}
		 									</script>
		 									<div class="modal fade" id="select_print_task">
		 									  <div class="modal-dialog">
		 									    <div class="modal-content">
		 									        <form action="?op=print" method="post" name="reset_student_pass" target="_blank">
		 										      <div class="modal-header">
		 										        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		 										        <h4 class="modal-title">'._PRINT.' '._TASK.'</h4>
		 										      </div>
		 										      <div class="modal-body">
		 										      <div class="checkbox">
		 										        <label>
		 										          <input type="checkbox" value="" name="issue_all">
		 										          '._PRINTED_DESC_ISSUE.'
		 										        </label>
		 										      </div>
		 												<br>
		 												<input type="hidden" class="form-control" name="tskid" id="tskid" value="">
		 										      </div>
		 										      <div class="modal-footer">
		 										        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
		 										        <button type="submit" class="btn btn-primary">'._PRINT.'</button>
		 										      </div>
		 										    </div><!-- /.modal-content -->
		 											</form>
		 									  </div><!-- /.modal-dialog -->
		 									</div><!-- /.modal -->
						    	        </div>
						    	        <span style="">
									        <a href="javascript: editTask('.$taskInfo['tskid'].')" class="font-weight-bold text-decoration-none">'.$taskInfo['tsktitle'].'</a>
									        <br><small>'._PROJECT.' '.$projectlist['prjtitle'].' '.($taskInfo['tskdone']==1?'('._DONE.')':'').'</small>
						    	        </span>
									</li>';
									$adminlist=$admin->GetAdminInfoById($taskInfo['aid']);
									echo'
									<li class="left_list list-inline-item">'.$adminlist['ausername'].'</li>	
						        </ul>
							  </div>
							  <div class="card-body task-chart-body">
							  	<!-- <a href="issues.php?op=add&tskid='.$taskInfo['tskid'].'&prjid='.$taskInfo['prjid'].'">
			  				  		<div class="card card-body mb-2">
			  					  		<center>'._ADD.' '._ISSUE.'</center>
			  		  				</div>
			  		  			</a> -->
							  	<a href="javascript: AddIssueBox('.$taskInfo['tskid'].')" id="addIssueButton'.$taskInfo['tskid'].'">
			  				  		<div class="card card-body mb-2">
			  					  		<center>'._ADD.' '._ISSUE.'</center>
			  		  				</div>
			  		  			</a>
		  				  		<div class="mb-2" id="addIssueText'.$taskInfo['tskid'].'" style="display: none;">
		  				  			<textarea class="form-control" id="issueText'.$taskInfo['tskid'].'"></textarea>
		  				  			<button class="btn btn-success btn-sm m-1" id="confirmIssueButton'.$taskInfo['tskid'].'" onclick="AddIssue('.$taskInfo['tskid'].', '.$_GET['prjid'].')">
		  				  				<span id="showWait'.$taskInfo['tskid'].'"></span>
		  				  				<span id="showBtnText'.$taskInfo['tskid'].'">'._ADD.'</span>
		  				  			</button>
		  				  			<button class="btn btn-light btn-sm m-1" onclick="CancelIssueBox('.$taskInfo['tskid'].')">'._CANCEL.'</button>
		  				  		</div>
		  				  		<script type="text/javascript">
		  				  			$( document ).ready(function() { 
		  				  				IssueList('.$taskInfo['tskid'].');
		  				  			});
		  				  		</script>
							  	<div id="issueList'.$taskInfo['tskid'].'"></div>
							  </div>
			  				  <!-- <div class="card-footer" style="text-align: '.$align1.'">
			  				  ';
	    			  			if ($permissions[0]['allow_edit_task']==1) {
	    			  				echo'
	    	    	             <a class="btn btn-primary btn-xs" href="?op=add&tskid='.$taskInfo['tskid'].'">'._EDIT.'</a>';
	    			  			}
	    			  			if ($permissions[0]['allow_delete_task']==1) {
	    			  			echo'
	    	    	             <a class="btn btn-danger btn-xs" onclick="return Sure();" href="?op=delete&tskid='.$taskInfo['tskid'].'">'._DELETE.'</a>';
	    			  			}
	    			  			if ($permissions[0]['allow_edit_task']==1) {
	    			  				echo'
	    	    	             <a class="btn btn-success btn-xs" href="?op=add&tskid='.$taskInfo['tskid'].'">'.($taskInfo['tskdone']==0?_DONE:_START).'</a>';
	    			  			}
	    			  			echo'
	    	    	             <a class="btn btn-light btn-xs" href="issues.php?op=chart&tskid='.$taskInfo['tskid'].'" title="'._ISSUES.' '._THIS.' '._TASK.'">'._ISSUES.'</a>';
	    			  			echo'
	    			  			<a class="btn btn-info btn-xs" href="javascript:print_task('.$taskInfo['tskid'].')"><span class="fas fa-print" aria-hidden="true"></span></a>';
	    			  			echo'
			  				  </div> -->
			    	        <script type="text/javascript">
								function print_task(id){
									$("#tskid").val(id);
									$("#select_print_task").modal()
								}
								function reset_password_hide(){
									document.getElementById(\'select_print_task\').style.display = "none";
								}
							</script>
							<div class="modal fade" id="select_print_task">
							  <div class="modal-dialog">
							    <div class="modal-content">
							        <form action="?op=print" method="post" name="reset_student_pass" target="_blank">
								      <div class="modal-header">
								        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								        <h4 class="modal-title">'._PRINT.' '._TASK.'</h4>
								      </div>
								      <div class="modal-body">
								      <div class="checkbox">
								        <label>
								          <input type="checkbox" value="" name="issue_all">
								          '._PRINTED_DESC_ISSUE.'
								        </label>
								      </div>
										<br>
										<input type="hidden" class="form-control" name="tskid" id="tskid" value="">
								      </div>
								      <div class="modal-footer">
								        <button type="button" class="btn btn-light" data-dismiss="modal">
								        	بستن
								    	</button>
								        <button type="submit" class="btn btn-primary">
								        	'._PRINT.'
								        </button>
								      </div>
								    </div><!-- /.modal-content -->
									</form>
							  </div><!-- /.modal-dialog -->
							</div><!-- /.modal -->
							</div>
						  </div>
						';
						}
					}
					echo'
					<div class="col-sm-3 col-md-3">
						<div class="card card-body p-0 mt-2">
							<a href="javascript: openAddCase()" class="add-btn-task">
								<span class="plus-btn">
									<i class="fas fa-plus"></i> افزودن ماموریت
								</span>
							</a>
						</div>
					</div>
				  </div>
				</div>
			</div>
		</div>
		<!-- Modal show issue -->
		<div class="modal fade bs-example-modal-lg" id="show_chart_issue" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog modal-lg" role="document">
		    <div class="modal-content" id="show-issue-info-modal">
		       
		    </div>
		  </div>
		</div>
		<!-- Modal add task -->
		<div class="modal fade" id="show_add_task" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		       	<div class="modal-body">
	               <p>افزودن ماموریت</p>
	               <form class="form-inline">
	               		<div class="form-group">
	               			<input type="text" class="form-control" name="modal_new_task" id="modal_new_task" placeholder="ماموریت جدید">
	               		</div>
	               		<button type="button" class="btn btn-primary mr-2" onclick="addTask('.$prjid2.', '.$aid.')">ثبت</button>
	               		<div id="show-response-add-task"></div>
	               </form>
	            </div>
		    </div>
		  </div>
		</div>

		<!-- Modal show task -->
		<div class="modal fade bd-example-modal-lg" id="show_edit_task" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog modal-lg" role="document">
		    <div class="modal-content">
		       	<div class="modal-body" id="show-resault-edit_task">
	             	               
	            </div>
		    </div>
		  </div>
		</div>
			';
			}
			else{
				Toast('error', 'خطا', _ACCESS_DENIED);
			}
		
		break;
	case 'delete':
		require_once 'menu.php';
		if (isset($_GET['tskid'])) {
			echo '
			<div class="col-sm-12 col-md-12 jumbotron" id="content">';
			if ($permissions[0]['allow_delete_task']==1) {
				if ($task->Delete($_GET['tskid'])) 
				{
					Toast('success', 'موفق', _RECORD_DELETED_SUCCESSFULLI);
				}
				else
				{
					Toast('error', 'خطا', _DELETING_RECORD_FAILED);
				}
			}
			else{
				Toast('error', 'خطا', _ACCESS_DENIED);
			}
			echo '
			<a href="?op=list"><input type="submit" name="backlist" class="btn btn-primary" value="'._BACK_TO_LIST.'"></a>
			</div>
			';
		}
		break;
	case 'print':
		echo '
		<div class="text-right" style="direction: rtl">
			';
			$tskid = (isset($_POST['tskid'])?$_POST['tskid']:'');
			$issue_all = (isset($_POST['issue_all'])?1:0);
			$query = "WHERE tskid=$tskid";
			$order ="ORDER BY idone,icomplexity DESC";
			$taskInfo = $task->GetTaskInfoById($tskid);
			echo '
			<h3>'._PRINT.' '._TASK.'</h3>
			<div class="table-responsive">
				<table class="table table-condensed">
				  <tr class="active">
					<th class="active">'._END.'؟</th>
					<th class="active">'._CODE.'</th>
					<th class="active">'._TITLE.'</th>
					<th class="active">'._INSERT_DATE.'</th>
					<th class="active">'._DESC.'</th>
					<th class="active">'._PROJECT.'</th>
				  </tr>
				  <tr class="active">
				    <td class="active"><span class="fas fa-'.($taskInfo['tskdone']==1?'ok':'remove').'" aria-hidden="true"></span></td>
				    <td class="active">'.$taskInfo['tskcode'].'</td>
				    <td class="active"><strong>'.$taskInfo['tsktitle'].'</strong></td>
				    <td class="active">'.G2JD($taskInfo['tskdate']).'</td>
				    <td class="active">'.$taskInfo['tskdesc'].'</td>
				    <td class="active">';
					$projectlist=$project->GetProjectInfoById($taskInfo['prjid']);
					echo $projectlist['prjtitle'].'</td>
				  </tr>
				</table>
			</div>
			<br><br>
			<h4>'._LIST_ISSUES_OF_THIS_TASK.'</h4>
			<div class="table-responsive">
				<table class="table table-condensed">
				  <tr class="active">
					<th class="active">'._END.'؟</th>
					<th class="active">'._CODE.'</th>
					<th class="active">'._TITLE.'</th>
					<th class="active">'._PROIRITY.'</th>
					<th class="active">'._COMPLEXITY.'</th>
					<th class="active">'._TYPE.'</th>
					<th class="active">'._TIME.'</th>
					<th class="active">'._INSERT_DATE.'</th>';
					if ($issue_all==1) {
						echo'<th class="active">'._DESC.'</th>';
					}
					echo'
				  </tr>
			';
			$issuelist = $task_issue->GetList_Issue($query, $order);
			$iproirity=$icomplexity='';
			foreach ($issuelist as $issueInfo) {
				switch ($issueInfo['iproirity']) {
					case '0':
						$iproirity=""._EASY."";
						break;
					case '1':
						$iproirity=""._NORMAL."";
						break;
					case '2':
						$iproirity=""._HARD."";
						break;
					case '3':
						$iproirity=""._VERY." "._HARD."";
						break;
				}
				switch ($issueInfo['icomplexity']) {
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
				}
				echo '
				<tr class="active">
					<td class="active"><span class="fas fa-'.($issueInfo['idone']==1?'ok':'remove').'" aria-hidden="true"></span></td>	
					<td class="active">'.$issueInfo['icode'].'</td>	
					<td class="active">'.$issueInfo['ititle'].'</td>	
					<td class="active">'.$iproirity.'</td>	
					<td class="active">'.$icomplexity.'</td>	
					<td class="active">';
					$issue_typeslist= $issue_types->GetList();
					foreach ($issue_typeslist as $issue_typesInfo) {
						if ($issue_typesInfo['tyid']==$issueInfo['tyid']) {
							echo $issue_typesInfo['tytitle'];
						}
					}
					echo'
					</td>	
					<td class="active">'.$issueInfo['ineeded_time'].'</td>	
					<td class="active">'.G2JD($issueInfo['idate']).'</td>';
					if ($issue_all==1) {
						echo'<td class="active">'.$issueInfo['idesc'].'</td>';
					}
					echo'
				</tr>
			';
			}
			echo'
				</table>
			</div>
			<button class="btn btn-primary hidden-print" onclick="window.print();">
				<span class="fas fa-print" aria-hidden="true"></span> '._PRINT.'
			</button>		
		</div>
		';

		break;


		light:
			# code...
			break;
	}




		 
require_once 'footer.php';
 ?>