<?php 
require_once 'main.php';
$issue = new ManageIssues();
$project = new ManageProjects();
$issue_types = new ManageIssue_types();
$task_issue = new ManageTasks_issues();
$admins_tasks = new ManageAdmins_Tasks();
$op = $_POST['op'];
switch ($op) {
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
		       <div id="vqs2"></div>
			    <ul class="list-inline">
			    	<li class="left_list">
		       			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		       		</li>
	    			<li class="dropdown right_list">
	    	           <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="fas fa-option-vertical" aria-hidden="true"></span></a>
	    	           <ul class="dropdown-menu">
	    	           		<input type="hidden" value="'.$issueInfo['iid'].'" id="iid">';
		  				if ($permissions[0]['allow_edit_issues']==1) {
			  				echo'
	    	             <li><a href="issues.php?op=add&iid='.$issueInfo['iid'].'">'._EDIT.' '._ISSUE.'</a></li>';
			  			}
			  			if ($permissions[0]['allow_delete_issues']==1) {
			  			echo'
	    	             <li><a onclick="return Sure();" href="issues.php?op=delete&iid='.$issueInfo['iid'].'" style="color: red;">'._DELETE.' '._ISSUE.'</a></li>';
			  			}
			  			if ($issueInfo['idone']==0) {
							echo '<li><a href="javascript:doneIssue('.$issueInfo['iid'].')">'._DONE_ISSUE.'</a></li>';
						}
						else {
							echo '<li><a href="javascript:startIssue('.$issueInfo['iid'].')">'._START_ISSUE.'</a></li>';
						}
			  			echo'
	    	           </ul>
	    	        </li>
				    <li class="right_list"> <label>'.$issueInfo['ititle'].'</label></li>
			    	<li class="left_list"><label>'._PROIRITY.'</label>: '.$iproirity.' | <label>'._COMPLEXITY.'</label>: '.$icomplexity.'&nbsp&nbsp</li>
		        </ul>
		      </div>
		      <script>
			      function doneIssue(id) {
			        $("#vqs2").html(\'<img src="img/wait.gif">\');
					$("#iid").val(id)
			        $.ajax({
			          url: "aj.php",
			          type: "POST",
			          data: {op:"done_issue",iid:$("#iid").val()},
			          success: function(data,status) {
			            $("#vqs2").html(data);
			          },
			          error: function() {$("#vqs2").html("problem in ajax")}
			        });
			      }
			      function startIssue(id) {
			        $("#vqs2").html(\'<img src="img/wait.gif">\');
					$("#iid").val(id)
			        $.ajax({
			          url: "aj.php",
			          type: "POST",
			          data: {op:"start_issue",iid:$("#iid").val()},
			          success: function(data,status) {
			            $("#vqs2").html(data);
			          },
			          error: function() {$("#vqs2").html("problem in ajax")}
			        });
			      }
		      </script>
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
	             <a onclick="return Sure();" class="btn btn-danger" href="issues.php?op=delete&iid='.$issueInfo['iid'].'">'._DELETE.'</a>';
	  			}
	  			if ($issueInfo['idone']==0) {
					echo '<a class="btn btn-success" href="javascript:doneIssue('.$issueInfo['iid'].')">'._DONE.'</a>';
				}
				else {
					echo '<a class="btn btn-default" href="javascript:startIssue('.$issueInfo['iid'].')">'._START.'</a>';
				}
	  			echo'
		        </div>
				';
		}
		break;
	case 'done_issue':
		$iid = $_POST['iid'];
		$idone = "1";
		$idone_date = "NOW";
		if ($issue->UpdateDone($iid, $idone_date , $idone)==1) {
			echo Success(_RECORD_ENDED_SUCCESSFULLI.' <a href="">'._RELOAD.'</a>');
		}
		else{
			echo Failure(_ENDING_RECORD_FAILED.' <a href="">'._RELOAD.'</a>');
		}
		break;
	case 'start_issue':
		$iid = $_POST['iid'];
		$idone = "0";
		$idone_date = "";
		if ($issue->UpdateDone($iid, $idone_date , $idone)==1) {
			echo Success(_RECORD_STARTED_SUCCESSFULLI.' <a href="">'._RELOAD.'</a>');
		}
		else{
			echo Failure(_STARTING_RECORD_FAILED.' <a href="">'._RELOAD.'</a>');
		}
		break;
	
	default:
		# code...
		break;
}

 ?>