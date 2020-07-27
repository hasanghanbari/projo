<?php 
require_once 'main.php';
require_once 'header.php';
require_once 'menu.php';
$op = $_GET['op'];
$issue_types = new ManageIssue_types();
$project = new ManageProjects();
$admin = new ManageAdmins();

	switch ($_GET['op']) {
		case 'add':
			$tycode= $tytitle= $tycomments='';
			$projectlist= $project->GetList();
			if (isset($_POST['add'])) {
				$tycode = $_POST['tycode']; 
				$tytitle = $_POST['tytitle']; 
				$tycomments = $_POST['tycomments']; 
				if (empty($tycode) || empty($tytitle)) {
					Toast('error', 'خطا', _FILL_IN_REQUIRED);
				} 
				else
				{
					if (preg_match('/^[اآبپتثئجچحخدذرزژسشصضطظعغفقکگلمنوهی\s]+$/', $tycode)==1 || strpos($tycode, " ")!==false) {
				        Toast('error', 'خطا', _INVALID_CODE);
				    }
				    else{	
						if ($issue_types->Add($tycode, $tytitle, $tycomments)==1) {
							Toast('success', 'موفق', _RECORD_ADDED_SUCCESSFULLI);
							$tycode= $tytitle= $tycomments='';
						}
						else{
							Toast('error', 'خطا', _ADDING_RECORD_FAILED);
						}
					}
				}
			}
			elseif (isset($_GET['tyid'])) {
				$tyid= sprintf("%d",$_GET['tyid']);
				if (isset($_POST['edit'])) {
					// if ($permissions[0]['allow_edit_link']==1) {
						//image admin
						$tycode = $_POST['tycode']; 
						$tytitle = $_POST['tytitle']; 
						$tycomments = $_POST['tycomments'];
						if (preg_match('/^[اآبپتثئجچحخدذرزژسشصضطظعغفقکگلمنوهی\s]+$/', $tycode)==1 || strpos($tycode, " ")!==false) {
					        Toast('error', 'خطا', _INVALID_CODE);
					    }
					    else{	
							if($issue_types->Update($tyid, $tycode, $tytitle, $tycomments)==1){
								Toast('success', 'موفق', _RECORD_EDITED_SUCCESSFULLI);
							}
							else{
								Toast('error', 'خطا', _EDITING_RECORD_FAILED.' ('._NOT_CHANGED_RECORD.')');
							}
						}
					// }
					// else{
					// 	$error='شما دسترسی لازم برای این بخش ندارید';
					// }
				}
				$typeInfo = $issue_types->GetInfo("tyid",$tyid);
				$tycode = $typeInfo['tycode']; 
				$tytitle = $typeInfo['tytitle']; 
				$tycomments = $typeInfo['tycomments']; 
			}
			echo '
			<div class="col-sm-12 col-md-12 jumbotron" id="content">
				<form method="post" enctype="multipart/form-data">
					<legend>'._ADD.' '._TYPE.' '._ISSUE.' &nbsp&nbsp<a class="btn btn-default" href="?op=list" role="button">'._LIST.'</a></legend>
					<div class="row">
					  <div class="col-md-4">
						  <div class="form-group">
						    <label for="tycode">'._CODE.'<span class="required">*</span>:</label>
						    <input type="text" class="form-control" id="tycode" name="tycode" style="direction:ltr;" value="'.$tycode.'">
						  </div>
						  <div class="form-group">
						    <label for="tytitle">'._TITLE.'<span class="required">*</span>:</label>
						    <input type="text" class="form-control" id="tytitle" name="tytitle" value="'.$tytitle.'">
						  </div>
					  </div>
					  <div class="col-md-8">
						  <div class="form-group">
						    <label for="tycomments">'._DESC.':</label>
						    <textarea class="form-control editor" rows="3" id="tycomments" name="tycomments">'.$tycomments.'</textarea>
						  </div>';
							if (isset($_GET['tyid'])) {
								echo '
								<ul class="list-inline">
									<li class="left_list">
						  				';
									UpdateForm('edit');
								echo'
									</li>
									<li>
										<a onclick="return Sure();" style="color: #a00;" href="?op=delete&tyid='.$tyid.'">'._DELETE.'</a>
									</li>
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
				  
				</form>
    		</div>
			';
			break;
		case 'l':
			echo '
			<div class="col-sm-12 col-md-12 jumbotron" id="content">

    		</div>
			';
			break;
		case 'list':
				$query=$q=$filter=$order="";
				$start=$page=0;
				$query= "";
				$order ="ORDER BY tyid DESC";
				if (isset($_GET['order'])) {
					$order = $_GET['order'];
					$order = "ORDER BY $order ".(isset($_GET['desc'])?'desc':'');
					$order1= $_GET['order'];
				}
				else{
					$_GET['order'] = '';
				}
				$typelist= $issue_types->GetList($query, $order,$limit="LIMIT $start,$page_limit");
				$num_of_records=  $issue_types->RowCount($query);
				$num_of_pages= intval($num_of_records/$page_limit);
				$num_of_pages= ($num_of_records%$page_limit==0?$num_of_pages:$num_of_pages+1);
		        // if ($permissions[0]['allow_list_link']!=0) {
					echo '
					<div class="col-sm-12 col-md-12 jumbotron" id="content">
						  <p class="lead"><a href="">'._TYPE.' '._ISSUE.'</a> &nbsp&nbsp';
					// if ($permissions[0]['allow_add_link']==1) {
					echo'
					<a class="btn btn-default" href="?op=add" role="button">'._ADD.'</a>';
					// }
					echo'</p>
					<div class="table-responsive">
						<table class="table table-bordered table-hover table-striped">
							<tr class="table_header info">
								<th width="20px">'._TOOLS.'</th>
								<th width="20px"><a href="?op=list&order=tycode'.(isset($_GET['desc'])?'':'&desc').'">'._CODE.'<span class="fas fa-collapse'.($_GET['order']=='tycode' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span></a></th>
								<th width="100px"><a href="?op=list&order=tytitle'.(isset($_GET['desc'])?'':'&desc').'">'._TITLE.'<span class="fas fa-collapse'.($_GET['order']=='tytitle' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span></a></th>
								<th width="300px"><a href="?op=list&order=tycomments'.(isset($_GET['desc'])?'':'&desc').'">'._DESC.'<span class="fas fa-collapse'.($_GET['order']=='tycomments' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span></a></th>
							</tr>
					';
					foreach ($typelist as $typeInfo) {
						// $adminInfo = $admin->GetAdminInfoById('1');
						echo '
							<tr class="">
								<td>
									<!-- Extra small button group -->
									<div class="btn-group">
										<button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										  <span class="fas fa-menu-hamburger"></span>
										</button>
										<ul class="dropdown-menu">';
								          // if ($permissions[0]['allow_edit_link']==1) {
								          echo'
											<li><a href="?op=add&tyid='.$typeInfo['tyid'].'">'._EDIT.'</a></li>';
											// }
								   //        if ($permissions[0]['allow_delete_link']==1) {
								          echo'
											<li><a onclick="return Sure();" style="color: red;" href="?op=delete&tyid='.$typeInfo['tyid'].'">'._DELETE.'</a></li>';
											// }
								          echo'
										</ul>
									</div>
								</td>
								<td style="text-align:center;">'.$typeInfo['tycode'].'</td>
								<td class="edit_link"><div>'.$typeInfo['tytitle'].'</div></td>
								<td>'.$typeInfo['tycomments'].'</td>
							</tr>
						';
					}

					echo'
					</table>
					</div>
					</div.
					';
				// }
				// else{
				// 	Failure('شما دسترسی لازم برای این بخش ندارید');
				// }
				break;
			case 'delete':
				if (isset($_GET['tyid'])) {
					echo '
					<div class="col-sm-12 col-md-12 jumbotron" id="content">';
					// if ($permissions[0]['allow_delete_link']==1) {
						if ($issue_types->Delete($_GET['tyid'])) 
						{
							Toast('success', 'موفق', _RECORD_DELETED_SUCCESSFULLI);
						}
						else
						{
							Toast('error', 'خطا', _DELETING_RECORD_FAILED);
						}
					// }
					// else{
					// 	$error='شما دسترسی لازم برای این بخش ندارید';
					// }
					echo '
					<a href="?op=list"><input type="submit" name="backlist" class="btn btn-primary" value="'._BACK_TO_LIST.'"></a>
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