<?php 
require_once 'main.php';
require_once 'header.php';
$op = $_GET['op'];
$error=$success='';
$project = new ManageProjects();
$task = new ManageTasks();
$comment = new ManageComments();
$admins_tasks = new ManageAdmins_Tasks();
	switch ($_GET['op']) {
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
			
			if (isset($_POST['search']) && $_POST['q']!=="") 
			{
				$q= $_POST['q'];
				$filter= $_POST['filter'];
				$query= "WHERE $filter LIKE '%$q%'";
			}
			else{
				$query = "";
				$order ="ORDER BY cid DESC";
			}
		    $commentlist= $comment->GetList($query,$order,$limit="LIMIT $start,$page_limit");
		
			$num_of_records=  $comment->RowCount($query);
			$num_of_pages= intval($num_of_records/$page_limit);
			$num_of_pages= ($num_of_records%$page_limit==0?$num_of_pages:$num_of_pages+1);
				echo '
				<div class="col-sm-12 col-md-12 jumbotron" id="content">';
				if ($permissions[0]['asuper_admin']==1) {
				echo'
					<div class="row">
					  <div class="col-md-3">
						<p class="lead"><a href="">'._COMMENTS.'</a></p>
					  </div>
					  <div class="col-md-9">
						<form action="" method="post" class="form-inline form_search">
							<div class="form-group">
								<input autofocus="" type="text" value="'.$q.'" class="form-control" id="q" name="q" placeholder="'._SEARCH_TEXT.'">
							</div>
							<select name="filter" class="form-control">
								<option '.($filter=="ctext"?'selected':'').' value="ctext">'._TITLE.'</option>
								<option '.($filter=="cdate"?'selected':'').' value="cdate">'._ADD_DATE.'</option>
							</select>';
							if ($num_of_pages>1) {
								echo' '._PAGE_NUMBER.':<select name="page" class="form-control">';
								for ($i=0; $i < $num_of_pages; $i++) { 
									if (isset($_REQUEST['start']) && $_REQUEST['start']==$i) {
									echo'<option value="'.$i.'"'.($i==$page?'selected':'').'>'.($i+1).'</option>';
									}
									else{
									echo'<option value="'.$i.'"'.($i==$page?'selected':'').'>'.($i+1).'</option>';
									}
								}
								echo '</select>';
							}
							echo'
						'._NUMBER_OF_PER_PAGE.':
						<select class="form-control" id="page_limit" name="page_limit">
							<option '.($page_limit=="5"?'selected':'').' value="5">5</option>
							<option '.($page_limit=="10"?'selected':'').' value="10">10</option>
							<option '.($page_limit=="20"?'selected':'').' value="20">20</option>
							<option '.($page_limit=="50"?'selected':'').' value="50">50</option>
							<option '.($page_limit=="100"?'selected':'').' value="100">100</option>
						</select>
						 <button type="submit" name="search" class="btn btn-default">'._SEARCH.'</button>
						</form><br>
					  </div>
					</div>
					<div class="table-responsive">
						<table class="table table-bordered table-hover">
						  <tr class="table_header">
						    <th class="active" width="150px">'._TOOLS.'</th>
						    <th class="active" width="400px">'._TITLE.'</th>
						    <th class="active" width="100px">'._INSERT_DATE.'</th>
						  </tr>';
						  foreach ($commentlist as $commentInfo) {
						  	echo'
						  <tr class="active">
						    <td class="active">
								<div class="dropdown">
								  <button id="dLabel" type="button" class="btn btn-default btn-xs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								    <span class="fas fa-menu-hamburger"></span> '._TOOLS.'
								  </button>
								  <ul class="dropdown-menu" aria-labelledby="dLabel">
								    <li><a onclick="return Sure();" style="color: red;" href="?op=delete&cid='.$commentInfo['cid'].'">'._DELETE.'</a></li>
								  </ul>
								</div>
						    </td>
						    <td class="active"><strong>'.$commentInfo['ctext'].'</strong></td>
						    <td class="active" style="direction:ltr;">'.($language=='farsi'?G2J($commentInfo['cdate']):$commentInfo['cdate']).'</td>
						  </tr>
						    ';
						  }
						  echo'
						</table>
					  </div>';
				}
				else{
					Failure(_ACCESS_DENIED);
				}
				echo'
				</div>
					';
			break;
		case 'delete':
			if (isset($_GET['cid'])) {
				echo '
				<div class="col-sm-12 col-md-12 jumbotron" id="content">';
				if ($permissions[0]['asuper_admin']==1) {
					if ($comment->Delete($_GET['cid'])) 
					{
						Success(_RECORD_DELETED_SUCCESSFULLI);
					}
					else
					{
						Failure(_DELETING_RECORD_FAILED);
					}
				}
				else{
					Failure(_ACCESS_DENIED);
				}
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