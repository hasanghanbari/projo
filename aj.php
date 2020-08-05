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
	case 'add_task':
		$task_title = $_POST['task_title'];
		$prjid 		= $_POST['prjid'];
		$aid 		= $_POST['aid'];

		if ($task->AddFast($prjid, $task_title, $aid) == 1) {
			Toast('success', 'موفق', _RECORD_ADDED_SUCCESSFULLI);
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
		break;
	case 'issue_list':
	  $tskId = $_POST['tskid'];

	  $query='WHERE iarchive=0';
	  $order = "ORDER BY idone,icomplexity DESC";
	  $task_issuelist = $task_issue->Getlist($query,$order);
	  	foreach ($task_issuelist as $task_issueInfo) {
	  		switch ($task_issueInfo['iproirity']) {
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
	  		}
	  		$ifile1 = $task_issueInfo['ifile1'];
	  		$ifile2 = $task_issueInfo['ifile2'];
	  		$ifile3 = $task_issueInfo['ifile3'];
	  		if ($tskId == $task_issueInfo['tskid']) {
	  		echo'
	  		<a href="javascript:chart_issue('.$task_issueInfo['iid'].')" onclick="IssueInfo('.$task_issueInfo['iid'].', '.$task_issueInfo['tskid'].')">
		  		<div class="card card-body mb-2'.($task_issueInfo['idone']==1?'  text-white bg-success':'').'">
			  		<ul class="list-inline p-0">
			  			<li class="list-inline-item">
			  				'.$task_issueInfo['ititle'].' ('.($task_issueInfo['idone']==1?_DONE:_UNDONE).')
			  			</li><br>
			  			<li class="left_list list-inline-item">
			  			'.(!empty($task_issueInfo['idesc'])?'<span class="fas fa-align-justify" aria-hidden="true"></span>':'').'
			  			'.(file_exists('file_issue/file1/'.$pic_prefix.$ifile1.'')?'<span class="fas fa-paperclip" aria-hidden="true"></span>1':'').'
			  			'.(file_exists('file_issue/file2/'.$pic_prefix.$ifile2.'')?'<span class="fas fa-paperclip" aria-hidden="true"></span>2':'').'
			  			'.(file_exists('file_issue/file3/'.$pic_prefix.$ifile3.'')?'<span class="fas fa-paperclip" aria-hidden="true"></span>3':'').'
			  			</li>
			  			<li class="list-inline-item">
			  				'.(isset($iproirity) ? $iproirity : '').'
			  				'.(isset($icomplexity) ? $icomplexity : '').'
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

		if (empty($ititle)) {
			Toast('error', 'خطا', _FILL_IN_REQUIRED);
		} 
		else 
		{
			if ($permissions[0]['allow_add_issues']==1) {
				if ($issue->AddMini($tyid, $prjid, $ititle, $archive, $aid)==1) {
					
					// add task issue
					$iid = $issue->LastID();
					$task_issue->Add($tskid,$iid);

					Toast('success', 'موفق', _RECORD_ADDED_SUCCESSFULLI);
					// echo '
					// <script type="text/javascript">
					// 	IssueInfo('.$iid.', '.$tskid.');
					// </script>
					// ';

				}
				else{
					Toast('error', 'خطا', _ADDING_RECORD_FAILED);
				}
			}
			else{
				Toast('error', 'خطا', _ACCESS_DENIED);
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
					echo'<a href="#" style="color:red;" onclick="delete_admin_task('.$admin_taskInfo['atid'].')" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">'._DELETE.'</a>
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
			Success(_RECORD_DELETED_SUCCESSFULLI);
		}
		else{
			Failure(_DELETING_RECORD_FAILED);
		}
		break;
	case 'delete_task_issue':
		$tiid = $_POST['tiid'];
		if ($task_issue->delete($tiid)==1) {
			Success(_RECORD_DELETED_SUCCESSFULLI);
		}
		else{
			Failure(_DELETING_RECORD_FAILED);
		}
		break;
	case 'issue_info':
		$iid = $_POST['issue_id'];
		$tskid = $_POST['tskid'];

		$start=$page=0;
		$archive= (isset($_GET['archive'])?'1':'0');
		$query= "WHERE iarchive=$archive";
		$order ="ORDER BY icomplexity DESC";
		$projectlist= $project->GetList();
		$issue_typeslist= $issue_types->GetList();
		$issueInfo= $issue->GetInfo("iid",$iid);
			if ($iid==$issueInfo['iid']) {
				$tyid = $issueInfo['tyid']; 
				$prjid = $issueInfo['prjid']; 
				$iversion = $issueInfo['iversion']; 
				$icode = $issueInfo['icode']; 
				$ititle = $issueInfo['ititle']; 
				$idesc = $issueInfo['idesc']; 
				// $iproirity = $issueInfo['iproirity']; 
				// $icomplexity = $issueInfo['icomplexity']; 
				$ineeded_time = $issueInfo['ineeded_time']; 
				$ifile1 = $issueInfo['ifile1']; 
				$ifile12 = $issueInfo['ifile1']; 
				$ifile2 = $issueInfo['ifile2']; 
				$ifile22 = $issueInfo['ifile2']; 
				$ifile3 = $issueInfo['ifile3']; 
				$ifile32 = $issueInfo['ifile3']; 
				$iarchive = $issueInfo['iarchive']; 
				$idate = $issueInfo['idate']; 
				$iwho_fullname = $issueInfo['iwho_fullname']; 
				$iwho_email = $issueInfo['iwho_email']; 
				$iwho_tel = $issueInfo['iwho_tel']; 
				$idone = $issueInfo['idone']; 
				$idone_date = $issueInfo['idone_date']; 
				$idone_version = $issueInfo['idone_version'];
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
		      echo'
		      
		       <div class="modal-header">
		       	<div class="row w-100">
		       		<div id="show-resault-done-issue" class="col-12"></div>
		       		<div class="col-12">
			       		<ul class="list-inline p-0 mini-show-issue">
			    			<li class="list-inline-item">
			    				<div class="dropdown" style="float: right;">
				    	           <a href="#" class="dropdown-toggle btn btn-light" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
				    	           		<i class="fas fa-ellipsis-v" aria-hidden="true"></i>
				    	           	</a>
				    	           <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
				    	           		<input type="hidden" value="'.$issueInfo['iid'].'" id="iid">';
					  				if ($permissions[0]['allow_edit_issues']==1) {
						  				echo'
				    	             	<a class="dropdown-item" href="issues.php?op=add&iid='.$issueInfo['iid'].'">'._EDIT.' '._ISSUE.'</a>';
						  			}
						  			if ($permissions[0]['allow_delete_issues']==1) {
						  			echo'
				    	             	<a class="dropdown-item" onclick="return Sure();" href="issues.php?op=delete&iid='.$issueInfo['iid'].'" style="color: red;">'._DELETE.' '._ISSUE.'</a>';
						  			}
						  			if ($issueInfo['idone']==0) {
										echo '
										<a class="dropdown-item" href="javascript:doneIssue('.$issueInfo['iid'].', '.$tskid.')">'._DONE_ISSUE.'</a>';
									}
									else {
										echo '
										<a class="dropdown-item" href="javascript:startIssue('.$issueInfo['iid'].', '.$tskid.')">'._START_ISSUE.'</a>';
									}
						  			echo'
				    	           </div>
				    	       </div>
				    	       <label>'.$issueInfo['ititle'].'</label>
				    	   	</li>
					    	<li class="list-inline-item float-left">
					    		<div class="float-right">
					    			<label>'._PROIRITY.'</label>: '.$iproirity.' | 
					    			<label>'._COMPLEXITY.'</label>: '.$icomplexity.'&nbsp&nbsp
					    		</div>
					    		<a href="#" role="button" class="btn btn-light" data-dismiss="modal" aria-label="Close">
					    			<i class="fas fa-times"></i>
					    		</a>
					    	</li>
				        </ul>
				    </div>
		       	</div>
		      </div>
		      <div class="modal-body">
		      
		      	<div class="row">
				  <div class="col-md-4">
					  <div class="form-group">
					    <label for="icode">'._CODE.':</label>&nbsp
					    '.$icode.'
					  </div>
					  <div class="form-group">
					    <label for="ititle">'._TITLE.':</label>&nbsp
					    '.$ititle.'
					  </div>
					  <div class="form-group">
					    <label for="ineeded_time">'._NEEDED_TIME.':</label>&nbsp
					    '.$ineeded_time.'
					  </div>
			  	    <div class="form-group">
			  	    	<label for="tyid">'._TYPE.' '._ISSUE.':</label>&nbsp';
			  	      foreach ($issue_typeslist as $issue_typesInfo) {
			  	      	if ($issue_typesInfo['tyid']==$tyid) {
			  	         echo $issue_typesInfo['tytitle'];
			  	      	}
			  	   	  }
			  	     echo'
			  	    </div>
			  	    <div class="form-group">';
			  	      if(file_exists('file_issue/file1/'.$pic_prefix.$ifile1.''))
			  	      {
			  	      	echo '
			  	      	<label for="ifile1">'._FILE1.':</label>&nbsp
			  	      	<a href="file_issue/file1/'.$pic_prefix.$ifile1.'" download="file1-'.$pic_prefix.$ifile1.'">
			  	      		'._DOWNLOAD.' '._FILE1.'
			  	      	</a>
			  	      	';
			  	      }
			  	      echo'
			  	    </div>
			  	    <div class="form-group">';
			  	      if(file_exists('file_issue/file2/'.$pic_prefix.$ifile2.''))
			  	      {
			  	      	echo '
			  	      	<label for="ifile2">'._FILE2.':</label>&nbsp
			  	      	<a href="file_issue/file2/'.$pic_prefix.$ifile2.'" download="file2-'.$pic_prefix.$ifile2.'">
			  	      		'._DOWNLOAD.' '._FILE2.'
			  	      	</a>
			  	      	';
			  	      }
			  	      echo'
			  	    </div>
			  	    <div class="form-group">';
			  	      if(file_exists('file_issue/file3/'.$pic_prefix.$ifile3.''))
			  	      {
			  	      	echo '
			  	      	<label for="ifile3">'._FILE3.':</label>&nbsp
			  	      	<a href="file_issue/file3/'.$pic_prefix.$ifile3.'" download="file3-'.$pic_prefix.$ifile3.'">
			  	      		'._DOWNLOAD.' '._FILE3.'
			  	      	</a>
			  	      	';
			  	      }
			  	      echo'
			  	    </div>
			  	    <div class="form-group">
			  	      <label for="prjid">'._FOR.' '._PROJECT.':</label>&nbsp';
			  	      $projectlist = $project->getlist();
			  	      foreach ($projectlist as $projectInfo) {
			  	      	if ($projectInfo['prjid']==$prjid) {
			  	      		echo $projectInfo['prjtitle'];
			  	      	}
			  	      }
			  	      echo'
			  	    </div>  
					<div class="form-group">
						<label for="iversion">'._PRIJECT_VERSION.':</label>&nbsp
					'.$iversion.'
					</div>
				  </div>
				  <div class="col-md-4">
					  <div class="form-group">
					    <label for="idesc">'._DESC.': </label>&nbsp
					    '.$idesc.'
					  </div>
				  </div>
				  <div class="col-md-4">
				  	<div class="form-group">
				  	  <label for="iwho_fullname">'._NAME_OF_PROPOSER.':</label>&nbsp
				  	  '.$iwho_fullname.'
				  	</div>
				  	<div class="form-group">
				  	  <label for="iwho_email">'._EMAIL_OF_PROPOSER.':</label>&nbsp
				  	  '.$iwho_email.'
				  	</div>
				  	<div class="form-group">
				  	  <label for="iwho_tel">'._PHONE_NUMBER_OF_PROPOSER.':</label>&nbsp
				  	  '.$iwho_tel.'
				  	</div>
				  	<div class="form-group">
				  	  	<label for="idone">'._CONDITION.':</label>&nbsp
				  	      '.($idone==1?''._DONE.'':''._UNDONE.'').'
				  	 </div>
				  	 <div class="form-group">
				  	  <label for="idone_date">'._COMPLETION_DATE_ISSUE.':</label>&nbsp
				  	 '.($idone_date!=0?$idone_date:_UNDONE).'
				  	 </div>
				  	 <div class="form-group">
				  	  <label for="idone_version">'._PROJECT_VERSION.':</label>&nbsp
				  	  '.$idone_version.'
				  	</div>
  				  	<div>
  				  		<label for="idone_version">'._INSERTED_BY.':</label>&nbsp
  				  	';
						$adminlist=$admin->GetAdminInfoById($issueInfo['aid']);
						echo'
							'.$adminlist['ausername'].'
					</div>
				</div>
		      </div>

		    </div>
			    <div class="modal-footer" style="text-align: '.$align1.'">
	           		<input type="hidden" value="'.$issueInfo['iid'].'" id="iid">';
  				if ($permissions[0]['allow_edit_issues']==1) {
	  				echo'
	             <a class="btn btn-primary" href="issues.php?op=add&iid='.$issueInfo['iid'].'">'._EDIT.' '._ISSUE.'</a>';
	  			}
	  			if ($permissions[0]['allow_delete_issues']==1) {
	  			echo'
	             <a onclick="return Sure();" class="btn btn-danger" href="javascript:deleteIssue('.$issueInfo['iid'].', '.$tskid.')">'._DELETE.'</a>';
	  			}
	  			if ($issueInfo['idone']==0) {
					echo '<a class="btn btn-success" href="javascript:doneIssue('.$issueInfo['iid'].', '.$tskid.')">'._DONE.'</a>';
				}
				else {
					echo '<a class="btn btn-default" href="javascript:startIssue('.$issueInfo['iid'].', '.$tskid.')">'._START.'</a>';
				}
	  			echo'
		        </div>
				';
		}
		break;
	case 'done_issue':
		$iid = $_POST['iid'];
		$tskid = $_POST['tskid'];
		$idone = "1";
		$idone_date = date('Y-m-d');
		if ($issue->UpdateDone($iid, $idone_date , $idone)==1) {
			Toast('success', 'موفق', _RECORD_ENDED_SUCCESSFULLI);
			echo '
				<script type="text/javascript">
					IssueInfo('.$iid.', '.$tskid.');
					IssueList('.$tskid.');
				</script>
			';
		}
		else{
			Toast('error', 'خطا', _ENDING_RECORD_FAILED);
		}
		break;
	case 'start_issue':
		$iid = $_POST['iid'];
		$tskid = $_POST['tskid'];
		$idone = "0";
		$idone_date = "";
		if ($issue->UpdateDone($iid, $idone_date , $idone)==1) {
			Toast('success', 'موفق', _RECORD_STARTED_SUCCESSFULLI);
			echo '
				<script type="text/javascript">
					IssueInfo('.$iid.', '.$tskid.');
					IssueList('.$tskid.');
				</script>
			';
		}
		else{
			Toast('error', 'خطا', _STARTING_RECORD_FAILED);
		}
		break;
	case 'delete_issue':
		$iid = $_POST['iid'];
		$tskid = $_POST['tskid'];
		if ($permissions[0]['allow_delete_issues']==1) {
			$task_issue->Delete($iid);
			if ($issue->Delete($iid)) 
			{
				Toast('success', 'موفق', _RECORD_DELETED_SUCCESSFULLI);
				echo '
				<script type="text/javascript">
					IssueInfo('.$iid.', '.$tskid.');
					IssueList('.$tskid.');
				</script>
				';
			}
			else
			{
				Toast('error', 'خطا', _DELETING_RECORD_FAILED);
			}
		}
		else{
			Toast('error', 'خطا', _ACCESS_DENIED);
		}
		break;
	
	default:
		# code...
		break;
}

 ?>