<?php 
require_once 'main.php';
require_once 'header.php';
$active = 'task';
require_once 'menu.php';
$op = $_GET['op'];
$error=$success='';
$issue = new ManageIssues();
$project = new ManageProjects();
$task = new ManageTasks();
$task_issue = new ManageTasks_issues();
$issue_types = new ManageIssue_types();
$admin = new ManageAdmins();
$admins_tasks = new ManageAdmins_Tasks();

	switch ($_GET['op']) {
		case 'add':
		echo '
			<div class="col-sm-12 col-md-12 well" id="content">';
			$tyid= $prjid= $iversion= $icode= $ititle= $idesc= $iproirity= $icomplexity= $ineeded_time= $ifile1= $ifile12= $ifile2= $ifile22= $ifile3= $ifile32= $iarchive= $iwho_fullname= $iwho_email= $iwho_tel= $idone= $idone_date= $idone_version ='';
			$icode = $issue->LastID();
			$legend = ''._ADD.' '._ISSUE.'';
			$projectlist= $project->GetList();
			$issue_typeslist= $issue_types->GetList();
			if (isset($_POST['add'])) {
				//file1
					$whitelist =  array("jpg", "png", "gif", "doc", "docx", "zip", "rar", "pdf", "mp4");
					$ext_error=0;
					if (!empty($_POST['delpic1'])) {
						$delpic1 = $_POST['delpic1'];
					}
					else{
						$delpic1 = '';
					}
					if($delpic1=="yes")
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
						 echo '<div class="alert alert-danger">
						     '._ADMIN_PIC_EXTENSION_ERROR.'!
						    </div>';
						else
						{
						 if($_FILES['ifile1']['size']>(_FILE_SIZE*1048576))
						  echo '<div class="alert alert-danger">
						     '._FILE_SIZE_ERROR.'!
						    </div>';
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
						  	$error = _ADMIN_PIC_UPLOAD_ERROR; 
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
						if($delpic1!="yes")
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
						if($delpic2=="yes")
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
							 echo '<div class="alert alert-danger">
							     '._ADMIN_PIC_EXTENSION_ERROR.'!
							    </div>';
							else
							{
							 if($_FILES['ifile2']['size']>(_FILE_SIZE*1048576))
							  echo '<div class="alert alert-danger">
							     '._FILE_SIZE_ERROR.'!
							    </div>';
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
							  	$error = _ADMIN_PIC_UPLOAD_ERROR; 
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
							if($delpic2!="yes")
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
					if($delpic3=="yes")
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
						 echo '<div class="alert alert-danger">
						     '._ADMIN_PIC_EXTENSION_ERROR.'!
						    </div>';
						else
						{
						 if($_FILES['ifile3']['size']>(_FILE_SIZE*1048576))
						  echo '<div class="alert alert-danger">
						     '._FILE_SIZE_ERROR.'!
						    </div>';
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
						  	$error = _ADMIN_PIC_UPLOAD_ERROR; 
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
						if($delpic3!="yes")
							$ifile3 = $ifile32 = $_REQUEST['ifile3_temp'];
					}
					//file3
					
				$tyid = $_POST['tyid']; 
				$prjid = (isset($_GET['prjid'])?$_GET['prjid']:$_POST['prjid']); 
				$iversion = $_POST['iversion']; 
				$icode = $_POST['icode']; 
				$ititle = $_POST['ititle']; 
				$idesc = $_POST['idesc']; 
				$iproirity = $_POST['iproirity']; 
				$icomplexity = $_POST['icomplexity']; 
				$ineeded_time = $_POST['ineeded_time'];
				$iarchive = (empty($_POST['iarchive'])?0:1);
				$iwho_fullname = $_POST['iwho_fullname']; 
				$iwho_email = $_POST['iwho_email']; 
				$iwho_tel = $_POST['iwho_tel']; 
				$idone =(isset($_POST['idone'])?$_POST['idone']:0); 
				$idone_date = (isset($_POST['idone_date'])?$_POST['idone_date']:NULL);
				$idone_version =(isset($_POST['idone_version'])?$_POST['idone_version']:0); 
				$aid = $permissions[0]['aid'];
				$idate = date("Y-m-d H:i:s");
				if (empty($icode) || empty($ititle)) {
					$error = _FILL_IN_REQUIRED ;
				} 
				else 
				{
					if ($permissions[0]['allow_add_issues']==1) {
						if (preg_match('/^[اآبپتثئجچحخدذرزژسشصضطظعغفقکگلمنوهی\s]+$/', $icode)==1 || strpos($icode, " ")!==false) {
					        $error=_INVALID_CODE;
					    }
					    else{
							if ($issue->Add($tyid, $prjid, $iversion, $icode, $ititle, $idesc, $iproirity, $icomplexity, $ineeded_time, $ifile1, $ifile2, $ifile3, $iarchive,$idate, $iwho_fullname, $iwho_email, $iwho_tel, $idone, $idone_date, $idone_version, $aid)==1) {
								if (isset($_GET['tskid'])) {
									$iid = $issue->LastID();
									$tskid = $_GET['tskid'];
									$task_issue->Add($tskid,$iid);
								}
								$success= _RECORD_ADDED_SUCCESSFULLI;
								$tyid= $prjid= $iversion= $icode= $ititle= $idesc= $iproirity=$idate= $icomplexity= $ineeded_time= $ifile1= $ifile2= $ifile3= $iarchive= $iwho_fullname= $iwho_email= $iwho_tel= $idone= $idone_date= $idone_version= $aid ='';
							}
							else{
								$error= _ADDING_RECORD_FAILED;
							}
						}
					}
					else{
						Failure(_ACCESS_DENIED);
					}
				}
			}
			elseif (isset($_GET['iid'])) {
				$iid= sprintf("%d",$_GET['iid']);
				if (isset($_POST['edit'])) {
				//file1
					$whitelist =  array("jpg", "png", "gif", "doc", "docx", "zip", "rar", "pdf", "mp4");
					$ext_error=0;
					if (!empty($_POST['delpic1'])) {
						$delpic1 = $_POST['delpic1'];
					}
					else{
						$delpic1 = '';
					}
					if($delpic1=="yes")
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
						 echo '<div class="alert alert-danger">
						     '._ADMIN_PIC_EXTENSION_ERROR.'!
						    </div>';
						else
						{
						 if($_FILES['ifile1']['size']>(_FILE_SIZE*1048576))
						  echo '<div class="alert alert-danger">
						     '._FILE_SIZE_ERROR.'!
						    </div>';
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
						  	$error = _ADMIN_PIC_UPLOAD_ERROR; 
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
						if($delpic1!="yes")
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
						if($delpic2=="yes")
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
							 echo '<div class="alert alert-danger">
							     '._ADMIN_PIC_EXTENSION_ERROR.'!
							    </div>';
							else
							{
							 if($_FILES['ifile2']['size']>(_FILE_SIZE*1048576))
							  echo '<div class="alert alert-danger">
							     '._FILE_SIZE_ERROR.'!
							    </div>';
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
							  	$error = _ADMIN_PIC_UPLOAD_ERROR; 
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
							if($delpic2!="yes")
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
					if($delpic3=="yes")
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
						 echo '<div class="alert alert-danger">
						     '._ADMIN_PIC_EXTENSION_ERROR.'!
						    </div>';
						else
						{
						 if($_FILES['ifile3']['size']>(_FILE_SIZE*1048576))
						  echo '<div class="alert alert-danger">
						     '._FILE_SIZE_ERROR.'!
						    </div>';
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
						  	$error = _ADMIN_PIC_UPLOAD_ERROR; 
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
						if($delpic3!="yes")
							$ifile3 = $ifile32 = $_REQUEST['ifile3_temp'];
					}
					//file3
					
						$tyid = $_POST['tyid']; 
						$prjid = $_POST['prjid']; 
						$iversion = $_POST['iversion']; 
						$icode = $_POST['icode']; 
						$ititle = $_POST['ititle']; 
						$idesc = $_POST['idesc']; 
						$iproirity = $_POST['iproirity']; 
						$icomplexity = $_POST['icomplexity']; 
						$ineeded_time = $_POST['ineeded_time']; 
						$iarchive = (empty($_POST['iarchive'])?0:1);
						$iwho_fullname = $_POST['iwho_fullname']; 
						$iwho_email = $_POST['iwho_email']; 
						$iwho_tel = $_POST['iwho_tel']; 
						$idone =$_POST['idone'];
						$idone_date = ($_POST['idone_date']==0?'':($language=='farsi'?J2GD($_POST['idone_date']):$_POST['idone_date'])); 
						$idone_version = $_POST['idone_version']; 
						if ($permissions[0]['allow_edit_issues']==1) {
							if (preg_match('/^[اآبپتثئجچحخدذرزژسشصضطظعغفقکگلمنوهی\s]+$/', $icode)==1 || strpos($icode, " ")!==false) {
						        $error=_INVALID_CODE;
						    }
						    else{
								if($issue->Update($iid, $tyid, $prjid, $iversion, $icode, $ititle, $idesc, $iproirity, $icomplexity, $ineeded_time, $ifile1, $ifile2, $ifile3, $iarchive, $iwho_fullname, $iwho_email, $iwho_tel, $idone, $idone_date, $idone_version)==1){
									$success=_RECORD_EDITED_SUCCESSFULLI;
								}
								else{
									$error= _EDITING_RECORD_FAILED.' ('._FILL_IN_REQUIRED.')';
								}
							}
						}
						else{
							Failure(_ACCESS_DENIED);
						}
				}
				$issueInfo = $issue->GetInfo("iid",$iid);
				$legend = ''._EDIT.' '._ISSUE.'&nbsp';
				$tyid = $issueInfo['tyid']; 
				$prjid = $issueInfo['prjid']; 
				$iversion = $issueInfo['iversion']; 
				$icode = $issueInfo['icode']; 
				$ititle = $issueInfo['ititle']; 
				$idesc = $issueInfo['idesc']; 
				$iproirity = $issueInfo['iproirity']; 
				$icomplexity = $issueInfo['icomplexity']; 
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
				$idone_date = ($issueInfo['idone_date']==0?'':($language=='farsi'?G2JD($issueInfo['idone_date']):$issueInfo['idone_date'])); 
				$idone_version = $issueInfo['idone_version']; 
			}
			
			if (!empty($error)) {
				Failure($error.' <a href="">'._RELOAD.'</a>');
			}
			if (!empty($success)) {
				Success($success.' <a href="">'._RELOAD.'</a>');
			}
			if ($permissions[0]['allow_add_issues']==1 || $permissions[0]['allow_edit_issues']==1) {	
			echo'
				<form method="post" enctype="multipart/form-data">
					<p class="lead">'.$legend.'';
					if ($permissions[0]['allow_add_issues']==1) {(isset($_GET['iid'])?AddLogo('?op=add'):'');}
					if ($permissions[0]['allow_list_issues']==1) {ListLogo('?op=list');}
					ChartLogo('?op=chart');
					echo'
					</p>
					<div class="row">
					  <div class="col-md-4">
						  <div class="form-group">
						    <label for="icode">'._CODE.'<span class="required">*</span>:</label>
						    <input autofocus="" type="text" class="form-control" id="icode" name="icode" style="direction:ltr;" value="'.$icode.'">
						  </div>
						  <div class="form-group">
						    <label for="ititle">'._TITLE.'<span class="required">*</span>:</label>
						    <input type="text" class="form-control" id="ititle" name="ititle" value="'.$ititle.'">
						  </div>
						  <div class="row">
							  <div class="col-md-6">
								  <div class="form-group">
								    <label for="iproirity">'._PROIRITY.':</label>
								    <select class="form-control" name="iproirity">
								      <option value="0" '.($iproirity==0?'selected':'').'>'._EASY.'</option>
								      <option value="1" '.($iproirity==1?'selected':'').'>'._NORMAL.'</option>
								      <option value="2" '.($iproirity==2?'selected':'').'>'._HARD.'</option>
								      <option value="3" '.($iproirity==3?'selected':'').'>'._VERY.' '._HARD.'</option>
								    </select>
								  </div>
							  </div>
							  <div class="col-md-6">
								  <div class="form-group">
								    <label for="icomplexity">'._COMPLEXITY.':</label>
								    <select class="form-control" name="icomplexity">
								      <option value="0" '.($icomplexity==0?'selected':'').'>None</option>
								      <option value="1" '.($icomplexity==1?'selected':'').'>!</option>
								      <option value="2" '.($icomplexity==2?'selected':'').'>!!</option>
								      <option value="3" '.($icomplexity==3?'selected':'').'>!!!</option>
								      <option value="4" '.($icomplexity==4?'selected':'').'>!!!!</option>
								      <option value="5" '.($icomplexity==5?'selected':'').'>!!!!!</option>
								    </select>
								  </div>
							  </div>
						  </div>
					    <div class="row">
					  	  <div class="col-md-6">
							  <div class="form-group">
							    <label for="ineeded_time">'._NEEDED_TIME.':</label>
							    <input type="text" class="form-control" id="ineeded_time" name="ineeded_time" value="'.$ineeded_time.'" placeholder="'._NEEDED_TIME_EXAMPLE.'">
							  </div>
						  </div>
					  	  <div class="col-md-6">
						      <div class="form-group">
				  	    	<label for="tyid">'._TYPE.' '._ISSUE.':</label><br>
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
							    <label for="prjid">'._FOR.' '._PROJECT.':</label>
							    <select class="form-control" name="prjid"'.(isset($_GET['tskid'])?'disabled':'').'>';
							    $projectlist = $project->getlist();
							    foreach ($projectlist as $projectInfo) {
							    	echo'<option value="'.$projectInfo['prjid'].'" '.($projectInfo['prjid']==$prjid?'selected':'').'>'.$projectInfo['prjtitle'].'</option>';
							    }

							    echo'
							    </select>
							  </div>
				  	      </div>
						  <div class="col-md-6">
						    <div class="form-group">
						      <label for="iversion">'._PROJECT_VERSION.':</label>
						      <input type="text" class="form-control" id="iversion" name="iversion" value="'.$iversion.'">
						    </div>
				  	      </div>
						</div>
					  	<div class="row">
						  <div class="col-md-6">
							  <div class="form-group">
							    <label for="ifile1">'._FILE1.':</label>
							    ';	
    							if(isset($_REQUEST['iid']))
    							{
    								if(file_exists('file_issue/file1/'.$file_prefix.$ifile1.''))
    								{
    									echo '
    									&nbsp<a href="file_issue/file1/'.$file_prefix.$ifile1.'" download="file1-'.$file_prefix.$ifile1.'">
    										'._DOWNLOAD.' '._FILE1.'
    									</a>
    									<br>
    									<input type="checkbox" name="delpic1" value="yes" id="delpic1"><label for="delpic1"> '._DELETE_FILE.'1</label>
    									';
    								}
	    							else{
	    								echo'
						    				<input type="file" id="ifile1" name="ifile1">
	    								';
	    							}
    							}
    							else{
    								echo'
					    				<input type="file" id="ifile1" name="ifile1">
    								';
    							}
							echo '
								<br>
							    <input type="hidden" name="ifile1_temp" value="'.$ifile12.'">
							  </div>
					  	  </div>
						  <div class="col-md-6">
							  <div class="form-group">
							    <label for="ifile2">'._FILE2.':</label>
							    ';	
    							if(isset($_REQUEST['iid']))
    							{
    								if(file_exists('file_issue/file2/'.$file_prefix.$ifile2.''))
    								{
    									echo '
    									&nbsp<a href="file_issue/file2/'.$file_prefix.$ifile2.'" download="file2-'.$file_prefix.$ifile2.'">
    										'._DOWNLOAD.' '._FILE2.'
    									</a>
    									<br>
    									<input type="checkbox" name="delpic2" value="yes" id="delpic2"><label for="delpic2"> '._DELETE_FILE.'2</label>
    									';
    								}
	    							else{
	    								echo'
							    			<input type="file" id="ifile2" name="ifile2">
										';
									}
    							}
    							else{
    								echo'
						    			<input type="file" id="ifile2" name="ifile2">
									';
								}
								echo '
								<br>
							    <input type="hidden" name="ifile2_temp" value="'.$ifile22.'">
							  </div>
					  	  </div>
						</div>
						<div class="form-group">
						  <label for="ifile3">'._FILE3.':</label>
					    ';	
						if(isset($_REQUEST['iid']))
						{
							if(file_exists('file_issue/file3/'.$file_prefix.$ifile3.''))
							{
								echo '
								&nbsp<a href="file_issue/file3/'.$file_prefix.$ifile3.'" download="file3'.$file_prefix.$ifile3.'">
									'._DOWNLOAD.' '._FILE3.'
								</a>
								<br>
								<input type="checkbox" name="delpic3" value="yes" id="delpic3"><label for="delpic3"> '._DELETE_FILE.'3</label>
								';
							}
							else{
								echo'
				    	  			<input type="file" id="ifile3" name="ifile3">
								';
							}
						}
						else{
							echo'
			    	  			<input type="file" id="ifile3" name="ifile3">
							';
						}
						echo '
						  <br>
						  <input type="hidden" name="ifile3_temp" value="'.$ifile32.'">
						</div>
					  </div>
					  <div class="col-md-4">
						<div class="form-group">
						  <label for="iwho_fullname">'._NAME_OF_PROPOSER.':</label>
						  <input type="text" class="form-control" id="iwho_fullname" name="iwho_fullname" value="'.$iwho_fullname.'">
						</div>
						<div class="form-group">
						  <label for="iwho_email">'._EMAIL_OF_PROPOSER.':</label>
						  <input type="text" class="form-control" id="iwho_email" name="iwho_email" style="direction:ltr;" value="'.$iwho_email.'">
						</div>
						<div class="form-group">
						  <label for="iwho_tel">'._PHONE_NUMBER_OF_PROPOSER.':</label>
						  <input type="text" class="form-control" id="iwho_tel" name="iwho_tel" style="direction:ltr;" value="'.$iwho_tel.'">
						</div>';
						if (isset($_GET['iid'])) {
							echo'
						<div class="checkbox">
						    <label>
						      <input type="checkbox" id="iarchive" name="iarchive" '.($iarchive==1?'checked':'').'> '._ARCHIVE.'
						    </label>
						 </div>
						 <label for="idone">'._CONDITION.':</label>
						 <div class="radio">
						   <label>
						     <input type="radio" name="idone" id="idone1" value="1" '.($idone==1?'checked':'').'>
						     '._DONE.'
						   </label>
						   <label>
						     <input type="radio" name="idone" id="idone2" value="0"'.($idone==0?'checked':'').'>
						     '._UNDONE.'
						   </label>
						 </div>
						 <div class="row">
						 	<div class="col-md-6">
							 <div class="form-group">
							  <label for="idone_date">'._COMPLETION_DATE_ISSUE.':</label>
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
							  <label for="idone_version">'._DONE_VERSION.':</label>
							  <input type="text" class="form-control" id="idone_version" name="idone_version" style="direction:ltr;" value="'.$idone_version.'">
							</div>
						 	</div>
						 </div>';
						}
						echo'
					  </div>
					  <div class="col-md-4">
					  	<div class="form-group">
					  	  <label for="idesc">'._DESC.':</label>
					  	  <textarea class="form-control editor" rows="3" id="idesc" name="idesc">'.$idesc.'</textarea>
					  	</div>
						';
							if (isset($_GET['iid'])) {
								echo '
								<ul class="list-inline">
									<li class="left_list">';
									UpdateForm('edit');
								echo'
									</li>';
						  			if ($permissions[0]['allow_delete_issues']==1) {
						  				echo'
									<li>
										<a class="btn btn-link" onclick="return Sure();" style="color: red;" href="?op=delete&iid='.$iid.'">'._DELETE.'</a>
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
				Failure(_ACCESS_DENIED);
			}
			echo'</div>';
			break;
		case 'list':
				$query=$q=$filter=$order="";
				$start=$page=0;
				$issue_title = '';
				$archive= (isset($_GET['archive'])?'1':'0');
				if (isset($_GET['tskid'])) {
					$tasklistInfo = $task->GetTaskInfoById($_GET['tskid']);
					$issue_title = _FOR.' '._TASK.' '.$tasklistInfo['tsktitle'];
					$tskid = '&&tskid='.$_GET['tskid'];
					$tskid2 = '&tskid='.$_GET['tskid'];
				}
				else{
					$tskid =$tskid2 = '';
				}
				if (isset($_POST['search']) && $_POST['q']!=="") 
				{
					$q= $_POST['q'];
					$filter= $_POST['filter'];
					$query= "WHERE $filter LIKE '%$q%'&&iarchive=$archive$tskid";
				}
				else{
					$query= "WHERE iarchive=$archive$tskid";
					$order ="ORDER BY idone,icomplexity DESC";
				}
				if (isset($_POST['search'])) {
					$page_limit = $_POST['page_limit'];
					$page=(isset($_POST['page'])?$_POST['page']:'');
					$start= $page*$page_limit;
				}
				if (isset($_GET['order'])) {
					$order = $_GET['order'];
					$order = "ORDER BY $order ".(isset($_GET['desc'])?'desc':'');
					$order1= $_GET['order'];
				}
				else{
					$_GET['order'] = '';
				}
				if (isset($_GET['tskid'])) {
					$issuelist= $task_issue->GetList_Issue($query, $order,$limit="LIMIT $start,$page_limit");
				}
				else{
					if ($permissions[0]['asuper_admin']==1) {
						$issuelist= $issue->GetList($query, $order,$limit="LIMIT $start,$page_limit");
					}
					else{
						$issuelist= $task_issue->GetList_Issue($query, $order,$limit="LIMIT $start,$page_limit");
					}
				}
				$num_of_records=  $task_issue->RowCount($query);
				$num_of_pages= intval($num_of_records/$page_limit);
				$num_of_pages= ($num_of_records%$page_limit==0?$num_of_pages:$num_of_pages+1);
					echo '
					<div class="col-sm-12 col-md-12 well" id="content">';
					if ($permissions[0]['allow_list_issues']==1) {	
					echo'
					<div id="vqs"></div>
					<div class="row">
					  <div class="col-md-3">
						<p class="lead"><a href="">'._ISSUES.'</a>';
						if ($permissions[0]['allow_add_issues']==1) {
							AddLogo('?op=add');
						}
						ChartLogo('?op=chart'.$tskid2.'');
						echo'
						  <br><small><small>'.$issue_title.'</small></small>
						</p>
					  </div>
					  <div class="col-md-9">
						<form action="" method="post" class="form-inline form_search">
							<div class="form-group">
								<input autofocus="" type="text" value="'.$q.'" class="form-control input-sm" id="q" name="q" placeholder="'._SEARCH_TEXT.'">
							</div>
							<select name="filter" class="form-control input-sm">
								<option '.($filter=="icode"?'selected':'').' value="icode">'._CODE.'</option>
								<option '.($filter=="ititle"?'selected':'').' value="ititle">'._TITLE.'</option>
								<option onclick="alert(\'  '._EASY.': 0 / '._NORMAL.': 1 / '._HARD.': 2 / '._VERY.' '._HARD.': 3\')" '.($filter=="iproirity"?'selected':'').' value="iproirity">'._PROIRITY.'</option>
								<option onclick="alert(\'  None: 0 / ! : 1 / !! : 2 / !!! : 3 / !!!! : 4 / !!!!! : 5\')" '.($filter=="icomplexity"?'selected':'').' value="icomplexity">'._COMPLEXITY.'</option>
								<option '.($filter=="iwho_fullname"?'selected':'').' value="iwho_fullname">'._NAME_OF_PROPOSER.'</option>
								<option '.($filter=="iwho_email"?'selected':'').' value="iwho_email">'._EMAIL_OF_PROPOSER.'</option>
								<option '.($filter=="iwho_tel"?'selected':'').' value="iwho_tel">'._PHONE_NUMBER_OF_PROPOSER.'</option>
								<option onclick="alert(\' '._DONE.':1 | '._UNDONE.':0\')" '.($filter=="idone"?'selected':'').' value="idone">'._DONE.'</option>
								<option '.($filter=="idone_version"?'selected':'').' value="idone_version">'._DONE_VERSION.'</option>
								<option '.($filter=="prjid"?'selected':'').' value="prjid">'._FOR.' '._PROJECT.'</option>
								<option '.($filter=="tyid"?'selected':'').' value="tyid">'._TYPE.' '._ISSUE.'</option>
							</select>';
							if ($num_of_pages>1) {
								echo' '._PAGE_NUMBER.':<select name="page" class="form-control input-sm">';
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
						<select class="form-control input-sm" id="page_limit" name="page_limit">
							<option '.($page_limit=="5"?'selected':'').' value="5">5</option>
							<option '.($page_limit=="10"?'selected':'').' value="10">10</option>
							<option '.($page_limit=="20"?'selected':'').' value="20">20</option>
							<option '.($page_limit=="50"?'selected':'').' value="50">50</option>
							<option '.($page_limit=="100"?'selected':'').' value="100">100</option>
						</select>
						 <button type="submit" name="search" class="btn btn-default btn-sm">'._SEARCH.'</button>
						</form><br>
					  </div>
					</div>
					<script>
						// using on
						$(\'#my_elem\').on(\'mousewheel\', function(event) {
						    console.log(event.deltaX, event.deltaY, event.deltaFactor);
						});

						// using the event helper
						$(\'#my_elem\').mousewheel(function(event) {
						    console.log(event.deltaX, event.deltaY, event.deltaFactor);
						});
						$(\'#my_elem\')
	                    .mousewheel(function(event, delta) {
	                        loghandle(event, delta);
	                        event.stopPropagation();
	                        event.preventDefault();
	                    });

					</script>
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" id="my_elem">
							<tr class="table_header info">
								<th width="20px">'._TOOLS.'</th>
								<th width="20px">'._PROJECT.'</th>
								<th width="20px">
									<a href="?op=list&order=icode'.(isset($_GET['desc'])?'':'&desc').'">
										'._CODE.'<span class="glyphicon glyphicon-collapse'.($_GET['order']=='icode' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
									</a></th>
								<th>
									<a href="?op=list&order=ititle'.(isset($_GET['desc'])?'':'&desc').'">'._TITLE.'<span class="glyphicon glyphicon-collapse'.($_GET['order']=='ititle' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
									</a></th>
								<th width="100px">
									<a href="?op=list&order=idesc'.(isset($_GET['desc'])?'':'&desc').'">'._DESC.'<span class="glyphicon glyphicon-collapse'.($_GET['order']=='idesc' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
									</a></th>
								<th width="200px">
									<a href="?op=list&order=iproirity'.(isset($_GET['desc'])?'':'&desc').'">'._PROIRITY.'<span class="glyphicon glyphicon-collapse'.($_GET['order']=='iproirity' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
									</a></th>
								<th width="50px">
									<a href="?op=list&order=icomplexity'.(isset($_GET['desc'])?'':'&desc').'">'._COMPLEXITY.'<span class="glyphicon glyphicon-collapse'.($_GET['order']=='icomplexity' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
									</a></th>
								<th width="20px">
									<a href="?op=list&order=ineeded_time'.(isset($_GET['desc'])?'':'&desc').'">'._NEEDED_TIME.'
									</a></th>
								<th width="20px">
									<a href="?op=list&order=idate'.(isset($_GET['desc'])?'':'&desc').'">'._ADD_DATE.'
									</a></th>
								<th width="200px">
									<a href="?op=list&order=ifile1'.(isset($_GET['desc'])?'':'&desc').'">'._FILE1.'<span class="glyphicon glyphicon-collapse'.($_GET['order']=='ifile1' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
									</a></th>
								<th width="20px">
									<a href="?op=list&order=ifile2'.(isset($_GET['desc'])?'':'&desc').'">'._FILE2.'<span class="glyphicon glyphicon-collapse'.($_GET['order']=='ifile2' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
									</a></th>
								<th width="50px">
									<a href="?op=list&order=ifile3'.(isset($_GET['desc'])?'':'&desc').'">'._FILE3.'<span class="glyphicon glyphicon-collapse'.($_GET['order']=='ifile3' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
									</a></th>
								<th width="20px">
									<a href="?op=list&order=iwho_fullname'.(isset($_GET['desc'])?'':'&desc').'">
										'._NAME_OF_PROPOSER.'<span class="glyphicon glyphicon-collapse'.($_GET['order']=='iwho_fullname' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
									</a></th>
								<th width="50px">
									<a href="?op=list&order=iwho_email'.(isset($_GET['desc'])?'':'&desc').'">'._EMAIL_OF_PROPOSER.'<span class="glyphicon glyphicon-collapse'.($_GET['order']=='iwho_email' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
									</a></th>
								<th width="50px">
									<a href="?op=list&order=iwho_tel'.(isset($_GET['desc'])?'':'&desc').'">
								'._PHONE_NUMBER_OF_PROPOSER.'<span class="glyphicon glyphicon-collapse'.($_GET['order']=='iwho_tel' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
									</a>
								</th>
								<th>
									<a href="?op=list&order=idone'.(isset($_GET['desc'])?'':'&desc').'">'._DONE.'<span class="glyphicon glyphicon-collapse'.($_GET['order']=='idone' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
									</a>
								</th>
								<th>
									<a href="?op=list&order=idone_date'.(isset($_GET['desc'])?'':'&desc').'">'._DONE_DATE.'<span class="glyphicon glyphicon-collapse'.($_GET['order']=='idone_date' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
									</a>
								</th>
								<th>
									<a href="?op=list&order=idone_version'.(isset($_GET['desc'])?'':'&desc').'">
										'._DONE_VERSION.'<span class="glyphicon glyphicon-collapse'.($_GET['order']=='idone_version' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
									</a>
								</th>
								<th>
									<a href="?op=list&order=tyid'.(isset($_GET['desc'])?'':'&desc').'">
										'._TYPE.' '._ISSUE.'<span class="glyphicon glyphicon-collapse'.($_GET['order']=='tyid' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
									</a>
								</th>
								<th>
									<a href="?op=list&order=prjid'.(isset($_GET['desc'])?'':'&desc').'">'._FOR.' '._PROJECT.'<span class="glyphicon glyphicon-collapse'.($_GET['order']=='prjid' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
									</a>
								</th>
								<th>
									<a href="?op=list&order=aid'.(isset($_GET['desc'])?'':'&desc').'">'._INSERTED_BY.'<span class="glyphicon glyphicon-collapse'.($_GET['order']=='aid' && isset($_GET['desc'])?'-up':'-down').'" aria-hidden="true"></span>
									</a>
								</th>
							</tr>
							
					';
					foreach ($issuelist as $issueInfo) {
					  if (!isset($_GET['tskid'])) {
						if ($permissions[0]['asuper_admin']==1) {
						  $active_tskid=1;
						}
						else{
							$aid = $permissions[0]['aid'];
							$tskid = $issueInfo['tskid'];
							$active_tskid=$admins_tasks->GetAidTskid($tskid,$aid);
						}
					  }
					  else{
						$active_tskid=1;
					  }
					  if ($active_tskid==1) {
					
						$projectlist=$project->GetProjectInfoById($issueInfo['prjid']);
						$iproirity=$icomplexity='';
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
						// $adminInfo = $admin->GetAdminInfoById('1');
						echo '

							<tr class="'.($issueInfo['idone']==1?'success':'').'" style="'.($issueInfo['idone']==1?'color:#A6A6A6;':'').'">
								<td>
										<!-- Extra small button group -->
										<div class="btn-group">
											<button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											  <span class="glyphicon glyphicon-menu-hamburger"></span>
											</button>
											<ul class="dropdown-menu">
												<input type="hidden" value="'.$issueInfo['iid'].'" id="iid">';
									          if ($permissions[0]['allow_edit_issues']==1) {
									          echo'
												<li><a href="?op=add&iid='.$issueInfo['iid'].'">'._EDIT.'</a></li>';
												}
									          if ($permissions[0]['allow_delete_issues']==1) {
									          echo'
												<li><a onclick="return Sure();" style="color: red;" href="?op=delete&iid='.$issueInfo['iid'].'">'._DELETE.'</a></li>';
												}
												if ($issueInfo['idone']==0) {
													echo '<li><a href="javascript:doneIssue('.$issueInfo['iid'].')">'._DONE_ISSUE.'</a></li>';
												}
												else {
													echo '<li><a href="javascript:startIssue('.$issueInfo['iid'].')">'._START_ISSUE.'</a></li>';
												}
									          echo'
											</ul>
										</div>
										<script>
									      function doneIssue(id) {
									        $("#vqs").html(\'<img src="img/wait.gif">\');
											$("#iid").val(id)
									        $.ajax({
									          url: "aj.php",
									          type: "POST",
									          data: {op:"done_issue",iid:$("#iid").val()},
									          success: function(data,status) {
									            $("#vqs").html(data);
									          },
									          error: function() {$("#vqs").html("problem in ajax")}
									        });
									      }
									      function startIssue(id) {
									        $("#vqs").html(\'<img src="img/wait.gif">\');
											$("#iid").val(id)
									        $.ajax({
									          url: "aj.php",
									          type: "POST",
									          data: {op:"start_issue",iid:$("#iid").val()},
									          success: function(data,status) {
									            $("#vqs").html(data);
									          },
									          error: function() {$("#vqs").html("problem in ajax")}
									        });
									      }
								      </script>
								</td>
								';
										      if(file_exists('img/project/'.$pic_prefix.$projectlist['prjlogo'].''))
										      	$prjlogo = 'img/project/'.$pic_prefix.$projectlist['prjlogo'].'';
										      else
										      	$prjlogo = 'img/proja.png';
										      	
										      echo '<td style="text-align:center;">
										      	<img src="'.$prjlogo.'" style="height:30px;"></td>

								<td style="text-align:center;">'.$issueInfo['icode'].'</td>
								<td class="edit_link"> <strong><div style="min-width: 200px;"> '.$issueInfo['ititle'].'</strong></div></td>
								<td><div class="overflow_list">'.$issueInfo['idesc'].'</div></td>
								<td>'.$iproirity.'</td>
								<td style="text-align: left;">'.$icomplexity.'</td>
								<td>'.$issueInfo['ineeded_time'].'</td>
								<td style="text-align: left;">'.($language=='farsi'?G2J($issueInfo['idate']):$issueInfo['idate']).'</td>
								<td>';
									if(file_exists('file_issue/file1/'.$file_prefix.$issueInfo['ifile1'].''))
									{
										echo '
										<a href="file_issue/file1/'.$file_prefix.$issueInfo['ifile1'].'" download="file1_'.$file_prefix.$issueInfo['ifile1'].'">
											<img src="file_issue/File-explorer.png" style="height:50px;">
										</a>';
									}
								echo'
								</td>
								<td>';
									if(file_exists('file_issue/file2/'.$file_prefix.$issueInfo['ifile2'].''))
									{
										echo '
										<a href="file_issue/file2/'.$file_prefix.$issueInfo['ifile2'].'" download="file2_'.$file_prefix.$issueInfo['ifile2'].'">
											<img src="file_issue/File-explorer.png" style="height:50px;">
										</a>';
									}
								echo'
								</td>
								<td>';
									if(file_exists('file_issue/file3/'.$file_prefix.$issueInfo['ifile3'].''))
									{
										echo '
										<a href="file_issue/file3/'.$file_prefix.$issueInfo['ifile3'].'" download="file3_'.$file_prefix.$issueInfo['ifile3'].'">
											<img src="file_issue/File-explorer.png" style="height:50px;">
										</a>';
									}
								echo'
								</td>
								<td>'.$issueInfo['iwho_fullname'].'</td>
								<td>'.$issueInfo['iwho_email'].'</td>
								<td>'.$issueInfo['iwho_tel'].'</td>
								<td>'.($issueInfo['idone']==0?''._NO.'':''._YES.'').'</td>
								<td style="text-align: left;">'.($issueInfo['idone_date']==0?''._UNDONE.'':($language=='farsi'?G2JD($issueInfo['idone_date']):$issueInfo['idone_date'])).'</td>
								<td style="text-align: left;">'.$issueInfo['idone_version'].'</td>
								<td>';
								$issue_typeslist= $issue_types->GetList();
								foreach ($issue_typeslist as $issue_typesInfo) {
									if ($issue_typesInfo['tyid']==$issueInfo['tyid']) {
										echo $issue_typesInfo['tytitle'];
									}
								}
								echo'
								</td>
								<td>'.$projectlist['prjtitle'].'</td>';
								$adminlist=$admin->GetAdminInfoById($issueInfo['aid']);
								echo'
								<td>'.$adminlist['ausername'].'</td>
							</tr>
						';

						}
					}

					echo'
					</table>
					</div>
					</div>
					
					';
					}
					else{
						Failure(_ACCESS_DENIED);
					}
				break;
			case 'chart':
				$issue_title = '';
						$query=$q=$filter=$order="";
						$start=$page=0;
						$archive= (isset($_GET['archive'])?'1':'0');
						if (isset($_GET['tskid'])) {
							$tasklistInfo = $task->GetTaskInfoById($_GET['tskid']);
							$issue_title = _FOR.' '._TASK.' '.$tasklistInfo['tsktitle'];
							$tskid = '&&tskid='.$_GET['tskid'];
							$tskid2 = '&tskid='.$_GET['tskid'];
						}
						else{
							$tskid = $tskid2 = '';
						}
						if (isset($_POST['search']) && $_POST['q']!=="") 
						{
							$q= $_POST['q'];
							$filter= $_POST['filter'];
							$query= "WHERE $filter LIKE '%$q%'&&iarchive=$archive$tskid";
						}
						else{
							$query= "WHERE iarchive=$archive$tskid";
							$order ="ORDER BY idone,icomplexity DESC";
						}
						if (isset($_POST['search'])) {
							$page_limit = $_POST['page_limit'];
							$page=(isset($_POST['page'])?$_POST['page']:'');
							$start= $page*$page_limit;
						}
						if (isset($_GET['order'])) {
							$order = $_GET['order'];
							$order = "ORDER BY $order ".(isset($_GET['desc'])?'desc':'');
							$order1= $_GET['order'];
						}
						else{
							$_GET['order'] = '';
						}
					echo '
						<div class="col-sm-12 col-md-12 well" id="content">';
						if ($permissions[0]['allow_list_issues']==1) {	
							$num_of_records=  $task_issue->RowCount($query);
							$num_of_pages= intval($num_of_records/$page_limit);
							$num_of_pages= ($num_of_records%$page_limit==0?$num_of_pages:$num_of_pages+1);
							echo'
							<div class="row">
							<div id="vqs"></div>
							  <div class="col-md-3">
								<p class="lead"><a href="">'._ISSUES.'</a>';
								if ($permissions[0]['allow_add_issues']==1) {
									AddLogo('?op=add');
								}
								if ($permissions[0]['allow_list_issues']==1) {
									ListLogo('?op=list'.$tskid.'');
								}
									echo'
									<br><small><small>'.$issue_title.'</small></small>
								</p>
							  </div>
							  <div class="col-md-9">
								<form action="" method="post" class="form-inline form_search">
									<div class="form-group">
										<input autofocus="" type="text" value="'.$q.'" class="form-control input-sm" id="q" name="q" placeholder="'._SEARCH_TEXT.'">
									</div>
									<select name="filter" class="form-control input-sm">
										<option '.($filter=="icode"?'selected':'').' value="icode">'._CODE.'</option>
										<option '.($filter=="ititle"?'selected':'').' value="ititle">'._TITLE.'</option>
										<option onclick="alert(\'  '._EASY.': 0 / '._NORMAL.': 1 / '._HARD.': 2 / '._VERY.' '._HARD.': 3\')" '.($filter=="iproirity"?'selected':'').' value="iproirity">'._PROIRITY.'</option>
										<option onclick="alert(\'  None: 0 / ! : 1 / !! : 2 / !!! : 3 / !!!! : 4 / !!!!! : 5\')" '.($filter=="icomplexity"?'selected':'').' value="icomplexity">'._COMPLEXITY.'</option>
										<option '.($filter=="iwho_fullname"?'selected':'').' value="iwho_fullname">'._NAME_OF_PROPOSER.'</option>
										<option '.($filter=="iwho_email"?'selected':'').' value="iwho_email">'._EMAIL_OF_PROPOSER.'</option>
										<option '.($filter=="iwho_tel"?'selected':'').' value="iwho_tel">'._PHONE_NUMBER_OF_PROPOSER.'</option>
										<option onclick="alert(\' '._DONE.':1 | '._UNDONE.':0\')" '.($filter=="idone"?'selected':'').' value="idone">'._DONE.'</option>
										<option '.($filter=="idone_version"?'selected':'').' value="idone_version">'._DONE_VERSION.'</option>
										<option '.($filter=="prjid"?'selected':'').' value="prjid">'._FOR.' '._PROJECT.'</option>
										<option '.($filter=="tyid"?'selected':'').' value="tyid">'._TYPE.' '._ISSUE.'</option>
									</select>';
									if ($num_of_pages>1) {
										echo' '._PAGE_NUMBER.':<select name="page" class="form-control input-sm">';
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
								<select class="form-control input-sm" id="page_limit" name="page_limit">
									<option '.($page_limit=="5"?'selected':'').' value="5">5</option>
									<option '.($page_limit=="10"?'selected':'').' value="10">10</option>
									<option '.($page_limit=="20"?'selected':'').' value="20">20</option>
									<option '.($page_limit=="50"?'selected':'').' value="50">50</option>
									<option '.($page_limit=="100"?'selected':'').' value="100">100</option>
								</select>
								 <button type="submit" name="search" class="btn btn-default btn-sm">'._SEARCH.'</button>
								</form><br>
							  </div>
							</div>
							<div class="row">
							';
						if (isset($_GET['tskid'])) {
							$issuelist= $task_issue->GetList_Issue($query, $order,$limit="LIMIT $start,$page_limit");
						}
						else{
							if ($permissions[0]['asuper_admin']==1) {
								$issuelist= $issue->GetList($query, $order,$limit="LIMIT $start,$page_limit");
							}
							else{
								
								$issuelist= $task_issue->GetList_Issue($query, $order,$limit="LIMIT $start,$page_limit");
							}
						}
						foreach ($issuelist as $issueInfo) {
						  if (!isset($_GET['tskid'])) {
							if ($permissions[0]['asuper_admin']==1) {
							  $active_tskid=1;
							}
							else{
								$aid = $permissions[0]['aid'];
								$tskid = $issueInfo['tskid'];
								$active_tskid=$admins_tasks->GetAidTskid($tskid,$aid);
							}
						  }
						  else{
							$active_tskid=1;
						  }
						  if ($active_tskid==1) {
							$iproirity=$icomplexity='';
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
						  <div class="col-sm-4 col-md-12">
							<div class="panel panel-'.($issueInfo['idone']==1?'success':'primary').'" style="'.($issueInfo['idone']==1?'color:#A6A6A6;':'').'">
							  <div class="panel-heading">
							    <ul class="list-inline">
							    	<li class="right_list">
						    			
	    				    	        <strong>'.$issueInfo['ititle'].'</strong>
    				    	        </li>
					    			<li>
									  | <label>'._PROIRITY.'</label>: '.$iproirity.' |
									  <label>'._COMPLEXITY.'</label>: '.$icomplexity.'&nbsp&nbsp
					    	        </li>
						        </ul>
							  </div>
						  			<script>
								      function doneIssue(id) {
								        $("#vqs").html(\'<img src="img/wait.gif">\');
										$("#iid").val(id)
								        $.ajax({
								          url: "aj.php",
								          type: "POST",
								          data: {op:"done_issue",iid:$("#iid").val()},
								          success: function(data,status) {
								            $("#vqs").html(data);
								          },
								          error: function() {$("#vqs").html("problem in ajax")}
								        });
								      }
								      function startIssue(id) {
								        $("#vqs").html(\'<img src="img/wait.gif">\');
										$("#iid").val(id)
								        $.ajax({
								          url: "aj.php",
								          type: "POST",
								          data: {op:"start_issue",iid:$("#iid").val()},
								          success: function(data,status) {
								            $("#vqs").html(data);
								          },
								          error: function() {$("#vqs").html("problem in ajax")}
								        });
								      }
							      </script>
							  <div class="panel-body">';
						  	      $projectlist= $project->GetList();
						  	      $issue_typeslist= $issue_types->GetList();
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
						  	      echo'
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
					  					    <label for="idesc">'._DESC.': </label>&nbsp
					  					    '.$idesc.'
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
					  				  </div>
					  				  <div class="col-md-4">
					  					  <div class="form-group">
					  					    ';
											if(file_exists('file_issue/file1/'.$file_prefix.$issueInfo['ifile1'].''))
											{
												echo'
					  					    	<label for="ifile1">'._FILE1.':</label>&nbsp';
												$ifile1 = 'file_issue/file1/'.$file_prefix.$issueInfo['ifile1'].'';
												echo '<a href="'.$ifile1.'" download="'.$file_prefix.$issueInfo['ifile1'].'">'._DOWNLOAD.' '._FILE1.'</a>';
											}
											echo '
											
					  					    <input type="hidden" name="ifile1_temp" value="'.$ifile12.'">
					  					  </div>
					  					  <div class="form-group">
				      					    ';
				    						if(file_exists('file_issue/file2/'.$file_prefix.$issueInfo['ifile2'].''))
				    						{
				    							echo'
					  					    	<label for="ifile2">'._FILE2.':</label>&nbsp';
				    							$ifile2 = 'file_issue/file2/'.$file_prefix.$issueInfo['ifile2'].'';
				    							echo '<a href="'.$ifile2.'" download="'.$file_prefix.$issueInfo['ifile2'].'">'._DOWNLOAD.' '._FILE2.'</a>';
				    						}
				    						echo '
					  					    <input type="hidden" name="ifile2_temp" value="'.$ifile22.'">
					  					  </div>
					  					  <div class="form-group">
				      					    ';
				    						if(file_exists('file_issue/file3/'.$file_prefix.$issueInfo['ifile3'].''))
				    						{
				    							echo'
					  					    	<label for="ifile3">'._FILE3.':</label>&nbsp';
				    							$ifile3 = 'file_issue/file3/'.$file_prefix.$issueInfo['ifile3'].'';
				    							echo '<a href="'.$ifile3.'" download="'.$file_prefix.$issueInfo['ifile3'].'">'._DOWNLOAD.' '._FILE3.'</a>';
				    						}
				    						echo '
					  					    <input type="hidden" name="ifile3_temp" value="'.$ifile32.'">
					  					  </div>
					  					  <div class="form-group">
					  					    <label for="prjid">'._FOR.' '._PROJECT.':</label>&nbsp';
					  					    $projectlist = $project->getlist();
					  					    foreach ($projectlist as $projectInfo) {
					  					    	if ($projectInfo['prjid']==$prjid) {
					  					    		echo $projectInfo['prjtitle'];
					  					    		if(file_exists('img/project/'.$pic_prefix.$projectInfo['prjlogo'].''))
					  					    			$prjlogo = 'img/project/'.$pic_prefix.$projectInfo['prjlogo'].'';
					  					    		else
					  					    			$prjlogo = 'img/proja.png';
					  					    			
					  					    		echo '<td style="text-align:center;">
					  					    			<img src="'.$prjlogo.'" style="height:30px;" />';
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
					  				  	 '.($idone_date==0?'':G2JD($idone_date)).'
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
	  										'.$adminlist['ausername'].'</div>
					  				</div>
						  	      </div>
						  	      
							  </div>
								<div class="panel-footer" style="text-align: '.$align1.'">
				    	           <input type="hidden" value="'.$issueInfo['iid'].'" id="iid">';
					  			if ($permissions[0]['allow_edit_issues']==1) {
					  				echo'
				    	             <a class="btn btn-default" href="issues.php?op=add&iid='.$issueInfo['iid'].'">'._EDIT.'</a>';
					  			}
					  			if ($permissions[0]['allow_delete_issues']==1) {
					  				echo'
				    	             <a class="btn btn-danger" onk="return Sure();" href="issues.php?op=delete&iid='.$issueInfo['iid'].'">'._DELETE.'</a>&nbsp';
					  			}
					  			if ($issueInfo['idone']==0) {
									echo '<a class="btn btn-success" href="javascript:doneIssue('.$issueInfo['iid'].')">'._DONE_ISSUE.'</a>';
								}
								else {
									echo '<a class="btn btn-primary" href="javascript:startIssue('.$issueInfo['iid'].')">'._START_ISSUE.'</a>';
								}
					  			echo'
								</div>
							</div>
						  </div>
						';
						  }
						}
						echo'
						';
							if ($permissions[0]['allow_add_issues']==1) {
								AddLogoChartNew();
							}
							echo'
						</div>';
					}
					else{
						Failure(_ACCESS_DENIED);
					}
					echo'</div>';
				break;
			case 'delete':
				if (isset($_GET['iid'])) {
					echo '
					<div class="col-sm-12 col-md-12 well" id="content">';
					if ($permissions[0]['allow_delete_issues']==1) {
						$task_issue->Delete($_GET['iid']);
						if ($issue->Delete($_GET['iid'])) 
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
			Failure('مسیر را اشتباه وارد کردید، لطفا دوباره سعی کنید.');
			break;
	}

		 
require_once 'footer.php';
 ?>