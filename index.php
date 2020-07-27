<?php 
require_once 'main.php';
require_once 'header.php';
require_once 'menu.php';
$project = new ManageProjects();
$comment = new ManageComments();
$task = new ManageTasks();
$admins_tasks = new ManageAdmins_Tasks();
if (isset($_POST['add'])) {
	$ctext = $_POST['ctext'];
	$cdate = date("Y-m-d H:i:sa");
	if (empty($ctext)) {
		Toast('error', 'خطا', _FILL_IN_REQUIRED);
	}
	else{
		if ($comment->Add($ctext,$cdate)==1) {
			Toast('success', 'موفق', _RECORD_ADDED_SUCCESSFULLI);
		}
		else{
			Toast('error', 'خطا', _ADDING_RECORD_FAILED);
		}
	}
}
echo'
<div class="col-sm-12 col-md-12 jumbotron" id="content">
  <h2>'._DASHBOARD.'</h2>
  <div class="row">';
	echo'
	<div class="col-md-6">';
	if ($permissions[0]['allow_list_project']==1) {
		echo'
		<div class="row">
			';
			if ($permissions[0]['asuper_admin']==1) {
				$projectlist= $project->GetList();
			}
			else{
				$aid= $permissions[0]['aid'];
				$query = "WHERE aids=$aid";
				$projectlist = $admins_tasks->GetListPrjAdmin($query);
			}
			foreach ($projectlist as $projectInfo) {
				if(file_exists('img/project/'.$pic_prefix.$projectInfo['prjlogo'].''))
					$prjlogo = 'img/project/'.$pic_prefix.$projectInfo['prjlogo'].'';
				else
					$prjlogo = 'img/proja.png';
				
			echo'
			<div class="col-md-6 mb-4 project-home">
				<a href="tasks.php?op=chart&prjid='.$projectInfo['prjid'].'">
				    <div class="card h-100">
				      <img src="'.$prjlogo.'" class="card-img-top" alt="...">
				      <div class="card-body">
				        <h5 class="card-title">'.$projectInfo['prjtitle'].'</h5>
				        <p class="card-text">'.$projectInfo['prjdesc'].'</p>
				      </div>
				    </div>
				</a>
			</div>';
			}
		}
		echo'
		</div>

	  </div>
	  <div class="col-md-6">
	  	<div class="card">
	  		<div class="card-body">
				<h4>'._MY_MISSIONS.' <a class="btn btn-default btn-xs" href="tasks.php?op=chart" role="button">'._LIST.'</a></h4>

				<div class="table-responsive">
					<table class="table table-hover">
						<tr>
						  <th>'._TITLE.'</th>
						  <th>'._FOR.' '._PROJECT.'</th>
						</tr>
					';
					$cookie_admin= explode(':', $_COOKIE['iproject']);
					$aid = $permissions[0]['aid'];
					if ($aid==1) {
						$query = "";
						$order ="ORDER BY tskdone,tskid DESC";
						$admin_tasks = $task->GetList($query,$order);
					}
					else{
						$query = "WHERE aids=$aid";
						$order ="ORDER BY tskdone,atid DESC";
				 		$start=0;
						$admin_tasks = $admins_tasks->GetList_task($query,$order,$limit="LIMIT $start,$page_limit_index");
					}
						foreach ($admin_tasks as $admin_task) {
							echo'
						  <tr class="'.($admin_task['tskdone']==1?'success':'active').'" style="'.($admin_task['tskdone']==1?'color:#A6A6A6;':'').'">
						    <td class="active"><strong>'.$admin_task['tsktitle'].'</strong> ('.($admin_task['tskdone']==0?''._UNDONE.'':''._DONE.'').')</td>';
							$projectlist=$project->GetProjectInfoById($admin_task['prjid']);
							echo'<td class="active">
								'.$projectlist['prjtitle'];
							if(file_exists('img/project/'.$pic_prefix.$projectlist['prjlogo'].''))
								$prjlogo = 'img/project/'.$pic_prefix.$projectlist['prjlogo'].'';
							else
								$prjlogo = 'img/proja.png';
								
							echo '
								<img src="'.$prjlogo.'" style="height:30px;" />
							</td>
						  </tr>
							';
						}
					echo'
					</table>
				</div>
		  	</div>
	  	</div>
	  	';
	  	if ($permissions[0]['asuper_admin']==1) {
	  		echo'
	  	<div class="card mt-1">
		  	<div class="card-body">
		  		<form method="post">
		  		  <div class="form-group">
		  		    <p class="lead" for="ctext">'._WHAT_IS_IN_YOUR_MIND.'</p>
		  		    <textarea id="ctext" name="ctext" class="form-control" rows="3"></textarea>
		  		  </div>';
		  		  AddForm('add');
		  		 echo'
		  		</form>
		  		 <br>';
		  		 $query = '';
				 $start=0;
		  		 $commentlist= $comment->GetList($query, $order="ORDER BY cid DESC",$limit="LIMIT $start,$page_limit_index");
		  		 echo'
		  		 <p class="lead">'._ENTRIES.' <a class="btn btn-default btn-xs" href="comments.php?op=list" role="button">'._LIST.'</a></p>
		  		 <ul class="list-group">';
		  		 foreach ($commentlist as $commentInfo) {
		  		 	echo'
		  		   <li class="list-group-item">
		  		   		<strong>'.$commentInfo['ctext'].'</strong>
		  		   		<br>
		  		   		<a onclick="return Sure();" href="comments.php?op=delete&cid='.$commentInfo['cid'].'" style="color: red;">'._DELETE.'</a>
		  		   </li>
		  		   ';
		  		 }
		  		 echo'
		  		 </ul>
			  </div>
			</div>
	  	</div>
		';
	  	}	echo'
	</div>
	';

echo'
</div>
';
require_once 'footer.php';
 ?>