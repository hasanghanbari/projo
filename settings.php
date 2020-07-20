<?php
require_once 'main.php';
require_once 'header.php';
require_once 'menu.php';
if (isset($_GET['op'])) {
	switch ($_GET['op']) {
		case 'settings':
			$manage_settings = new ManageSettings();
			$form_title = _ADMIN_MODIFY_SYSTEM_SETTINGS;
			if (isset($_POST['update_settings'])) {
				$system_title = $_POST['system_title'];
				$language = $_POST['language'];
				$direction = $_POST['dir'];
				$theme = $_POST['theme'];
				$adminInfo=$admin->GetAdminInfo($_COOKIE['iproject']);
				$cookie_admin= explode(':', $_COOKIE['iproject']);
				if($admin->AdminPermission($cookie_admin[0],"asuper_admin"))
				{
					if($manage_settings->UpdateSettings($system_title,$language,$direction,$theme)!=1)
						$error = _SETTINGS_UPDATING_FAILED;
					else
						$success = _SETTINGS_UPDATED_SUCCESSFULLY;
				}
				else{
						$error = _ADMIN_YOU_DO_NOT_HAVE_NECCESSARY_PERMISSIONS;
				}
			}
			$id = '1';
			$setInfo = $manage_settings->GetInfo("id",$id);
			$system_title = $setInfo['system_title'];
			$language = $setInfo['language'];
			$direction = $setInfo['direction'];
			$theme = $setInfo['theme'];
			echo '
			<div class="col-sm-12 col-md-12 jumbotron" id="content">';
			if (!empty($error)) {
				Failure($error.' <a href="">'._RELOAD.'</a>');
			}
			if (!empty($success)) {
				Success($success.' <a href="">'._RELOAD.'</a>');
			}
			echo'
			<form class="form-vertical" id="UpdateSettings" method="post">
			<h3>'.$form_title.'</h3>
			<div class="row">
			  <div class="col-md-6">
					<fieldset>
						<legend class="label label-default">'._ADMIN_GENERAL_INFORMATION.'</legend>
						<div class="control-group">
							<label class="control-label" for="system_title">'._SYSTEM_TITLE._REQUIRED.':</label>
							<div class="controls">
								<input value="'.$system_title.'" type="text" class="form-control input" autocomplete="off" id="system_title" name="system_title" style="direction:'.$direction.';">
							</div><br>
						</div>
						
						<div class="control-group">
							<label class="control-label" for="language">'._LANG.':</label>
							<div class="controls">
								<select name="language" class="form-control style="width:150px; direction:ltr;">
						';
							$directory=opendir('language');
						
							while (false != ($file=readdir($directory)))
							{
								if (strpos($file, '.php', 1))
								{
									$rest=substr("$file", 0, -4);
						
									if ($rest == $language)
										echo '<option selected="selected" value="'.$rest.'" '.($setInfo['language']==$rest?'selected':'').'>'.ucfirst($rest).'</option>';
									else
										echo '<option value="'.$rest.'" '.($setInfo['language']==$rest?'selected':'').'>'.ucfirst($rest).'</option>';
								}
							}
							echo '	</select>
								</div>
							</div><br>
							<div class="control-group">
								<label class="control-label">'._DIR.':</label>
								<div class="controls">
									<input type="radio" name="dir" id="dir1" value="1" '.($direction=='1'?'checked':'').'> <label for="dir1">'._RTLS.'</label> 
									<input type="radio" name="dir" id="dir2" value="0" '.($direction=='0'?'checked':'').'> <label for="dir2">'._LTRS.'</label> 
								</div>
							</div>
							<br>
							<div class="control-group">
									<label class="control-label" for="theme">'._THEME.':</label>
									<div class="controls">
										<select name="theme" class="form-control style="width:150px; direction:ltr;">
								';
							$path = 'themes';
							$results = scandir('themes');
							
							foreach ($results as $result) {
								if ($result === '.' or $result === '..') continue;
							
								if (is_dir($path . '/' . $result)) {
									if ($result == $theme)
										echo ('<option selected="selected" value="'.$result.'" '.($setInfo['theme']==$result?'selected':'').'>'.ucfirst($result).'</option>');
									else
										echo ('<option value="'.$result.'" '.($setInfo['theme']==$result?'selected':'').'>'.ucfirst($result).'</option>');
								}
							}
							echo '	</select>
								</div>
							</div><br>
					</fieldset>
				  </div>  
				</div>
						';
						
						echo'
						<center>
						'.UpdateForm('update_settings').'
						</center>
							</form>
						</p>
					</div>
				</form>
				</div>
				';  
			break;
		case "about":
		echo '
			<div class="col-sm-12 col-md-12 jumbotron" id="content">';
			$form_title = _ABOUT_PROJA;
			
			echo '
			<div class="hero-unit main-container" style="margin-'.$align2.':0px; '.$align2.':20%;">';
			echo '
				<img width="200px" src="themes/'.$themes.'/img/logo.png" />
				<h3>'.$form_title.'</h3>
				'._ABOUT_PROJA_SYSTEM_NAME.': '._ABOUT_PROJA_SYSTEM_NAME2.'<br />
				'._ABOUT_PROJA_SYSTEM_DESIGNER.': '._ABOUT_PROJA_SYSTEM_DESIGNER2.' (<a href="http://hasanghanbari.ir" target="_blank">http://hasanghanbari.ir</a>)<br />
				'._ABOUT_PROJA_SYSTEM_LICENSE.': '._ABOUT_PROJA_SYSTEM_LICENSE2.'<br />
				'._ABOUT_PROJA_SYSTEM_VERSION.': '._ABOUT_PROJA_SYSTEM_VERSION2.' (<a href="http://aftab.cc/proja/update.php?version='._ABOUT_PROJA_SYSTEM_VERSION2.'" target="_blank">'._ABOUT_PROJA_SYSTEM_CHECK_FOR_UPDATE.'</a>)<br />
				'._ABOUT_PROJA_OFFICIAL_WEBSITE.': <a href="http://proja.ir" target="_blank">http://proja.ir</a><br />
				'._ABOUT_PROJA_PUBLISHED_AT.': '._ABOUT_PROJA_PUBLISHED_AT2.' (<a href="http://aftab.cc" target="_blank">http://aftab.cc</a>)<br />
				'._ABOUT_PROJA_DOCUMENTS.': <a href="http://help.proja.ir" target="_blank">http://help.proja.ir</a><br />
				'._ABOUT_PROJA_SUPPORT_FORUMS.': <a href="http://yourl.ir/proja_forums" target="_blank">http://yourl.ir/proja_forums</a><br />
			';
				
			echo'
					</form>
				</p>
			</div>
		</div>
		';   
		
		break;
		case 'profile':
		echo '
			<div class="col-sm-12 col-md-12 jumbotron" id="content">';
		$error = $success = '';
		$cookie_admin= explode(':', $_COOKIE['iproject']);
		$ausername = $cookie_admin[0];
		$adminInfo = $admin->GetAdminInfo($ausername);
		$aid = $adminInfo[0]['aid'];
		$ausername = $adminInfo[0]['ausername'];
		$afname = $adminInfo[0]['afname'];
		$alname = $adminInfo[0]['alname'];
		$agender = $adminInfo[0]['agender'];
		$atel = $adminInfo[0]['atel'];
		$aemail = $adminInfo[0]['aemail'];
		$apic = $adminInfo[0]['apic'];
		$apic2 = $adminInfo[0]['apic'];
		$acomments = $adminInfo[0]['acomments'];
		if (isset($_POST['edit'])) {
			$adminInfo=$admin->GetAdminInfo($_COOKIE['iproject']);
			$cookie_admin= explode(':', $_COOKIE['iproject']);
			$afname = $_POST['afname'];
			$alname = $_POST['alname'];
			$agender = $_POST['agender'];
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
					$error = _ADMIN_PIC_EXTENSION_ERROR;
				}
				else
				{
					$imageinfo = getimagesize($_FILES['apic']['tmp_name']);
					if($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/png')
					{
						$error = _ADMIN_PIC_CONTENT_ERROR;
					}
					else
					{
						if($_FILES['apic']['size']<(_IMAGE_SIZE*1024))
						{
							$uploaddir = 'img/admins/';
							$pic_name = $pic_prefix;
							$uploadfile = $uploaddir .$pic_name.'-'.substr(time(),-7).'.'.substr(basename($_FILES['apic']['name']),-3);
							$admin->DelPic($aid);
							if (move_uploaded_file($_FILES['apic']['tmp_name'], $uploadfile))
							{
								$apic = $apic2 = '-'.substr(time(),-7).'.'.substr(basename($_FILES['apic']['name']),-3);
							}
							else
							{
								Failure(_ADMIN_PIC_UPLOAD_ERROR); 
								$apic = "";
							}
						}
						else
						{
							Failure(_IMAGE_SIZE_ERROR);
							$apic = $apic2 = $_REQUEST['apic_temp'];
						}
					}
				}
				//--Upload Image
			}
			else
			{
				if($delpic!="yes")
					$apic = $apic2 = $_REQUEST['apic_temp'];
			}
			$atel = $_POST['atel'];
			$aemail = $_POST['aemail'];
			$acomments = $_POST['acomments'];
			if($admin->UpdateProfile($aid, $afname, $alname, $agender, $atel, $aemail, $apic, $acomments)==1){
				$success=_RECORD_EDITED_SUCCESSFULLI;
			}
			else{
				$error=_EDITING_RECORD_FAILED.'('._NOT_CHANGED_RECORD.')';
			}
		}
		if (!empty($error)) {
			Failure($error.' <a href="">'._RELOAD.'</a>');
		}
		if (!empty($success)) {
			Success($success.' <a href="">'._RELOAD.'</a>');
		}
		echo '
		<form method="post" enctype="multipart/form-data">
		<legend>'._EDIT.' '._PROFILE.'</legend>
		<div class="row">
		  <div class="col-md-6">
		  	<div class="card card-default">
		  	  <div class="card-body">
				<div class="form-group">
					<label for="ausername">'._USERNAME.': </label><small> '._USERNAME_CANNOT_BE_CHANGED.'</small><br>
					<input autofocus="" type="text" class="form-control" id="ausername" name="ausername" value="'.$ausername.'" style="direction: ltr;" disabled>
				</div>
				<a href="#change_pass" role="button" data-toggle="modal"><span class="fas fa-refresh" aria-hidden="true"></span> '._CHANGE.' '._PASSWORD.'</a><br><br>
				
				<div class="form-group">
					<label for="afname">'._NAME.': </label><br>
					<input type="text" class="form-control" id="afname" name="afname" value="'.$afname.'">
				</div>
				<div class="form-group">
					<label for="alname">'._FAMILI.': </label><br>
					<input type="text" class="form-control" id="alname" name="alname" value="'.$alname.'">
				</div>
				<div class="form-group">
					<label for="agender">'._GENDER.': </label><br>
					<label class="radio-inline">
					<input type="radio" name="agender" id="agender0" value="0" '.($agender==0?'checked':'').'> '._MAN.'
					</label>
					<label class="radio-inline">
					<input type="radio" name="agender" id="agender1" value="1" '.($agender==1?'checked':'').'> '._WOMAN.'
					</label>
				</div>
				<div class="form-group">
					<label for="atel">'._PHONE_NUMBER.': </label><br>
					<input type="tel" class="form-control" id="atel" name="atel" value="'.$atel.'" style="direction: ltr;">
				</div>
				<div class="form-group">
					<label for="aemail">'._EMAIL.': </label><br>
					<input type="email" class="form-control" id="aemail" name="aemail" value="'.$aemail.'" style="direction: ltr;">
				</div>
		  	  </div>
		  	</div>
		</div>
		  <div class="col-md-6">
			  <div class="card card-default">
				<div class="card-body">
					<div class="form-group">
						<label for="apic">'._AVATAR.':</label>';
							if(file_exists('img/admins/'.$pic_prefix.$apic.''))
							{
								echo '
								<br>
								<img src="img/admins/'.$pic_prefix.$apic.'" style="height:100px;">
								<br>
								<input type="checkbox" name="delpic" value="yes" id="delpic"><label for="delpic"> '._DELETE_IMAGE.'</label>
								';
							}
							else
								echo '
								<br>
								<img src="img/admin.png">';
						echo '
						<input type="file" id="apic" name="apic" value="'.$apic.'" style="direction: ltr;">
						<input type="hidden" name="apic_temp" value="'.$apic2.'">
					</div>
					<label for="acomments">'._COMMENTS.': </label><br>
					<textarea name="acomments" class="form-control editor" rows="3">'.$acomments.'</textarea><br>
				</div>
			  </div>
			<div style="text-align:left;">
				<button type="submit" name="edit" class="btn btn-success" style="width: 100px;">'._UPDATE.'</button>
			</div>
		  </div>
		</div>
		</form>
		<div class="modal fade" id="change_pass">
		    <div class="modal-dialog">
		      <div class="modal-content">
		          <form action="?op=reset" method="post">
		            <div class="modal-header">
		              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		              <h4 class="modal-title">'._CHANGE.' '._PASSWORD.'</h4>
		            </div>
		            <div class="modal-body">
		                '._CURRENT_PASSWORD.'<span class="required">*</span>:<br>
		                <input type="password" name="current_pass" class="form-control" id="current_pass" style="direction:ltr;"><br>
		                '._NEW_PASSWORD.'<span class="required">*</span>:<br>
		                <input type="password" name="new_pass" class="form-control" id="new_pass" style="direction:ltr;"><br>
		                '._REPEAT_THE_NEW_PASSWORD.'<span class="required">*</span>:<br>
		                <input type="password" name="confirm_pass" class="form-control" id="confirm_pass" style="direction:ltr;"><br>
		                <div id="pass_result">
		                </div>
		            </div>
		            <div class="modal-footer">
		              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		              <button type="submit" class="btn btn-primary">'._SAVE.'</button>
		            </div>
		          </form>
		      </div><!-- /.modal-content -->
		    </div><!-- /.modal-dialog -->
		  </div><!-- /.modal -->
		</div>
		';
			break;
		case 'reset':
		echo '<div class="col-sm-12 col-md-12 jumbotron" id="content">';
			$admin_names = $admin->GetAdminInfo($cookie_admin[0]);
			foreach ($admin_names as $admin_name) {
			    $admin_id = $admin_name['aid'];
			    $admin_pass = $admin_name['apass'];
			}
			$aid = $permissions[0]['aid'];
			$apass = $_POST['new_pass'];
			if (md5($_POST['current_pass'])==$admin_pass) {
				if ($_POST['new_pass']==$_POST['confirm_pass']) {
				$adminInfo = $admin->GetAdminInfo($aid);
				$adminId = $adminInfo['aid'];
					if ($aid==1 && $adminId==1) {
						Failure(_CHANGING_PASSWORD_FAILED);
					}
					else{
						if ($admin->ResetPassword($aid,$apass)==1) {
							header("Location: logout.php");
							Success(_CHANGED_PASSWORD_SUCCESSFULLI);
							echo '<a href="admins.php?op=list"><input type="submit" name="backlist" class="btn btn-primary" value="'._BACK_TO_LIST.'"></a>';
						}
						else{
							Failure(_INSERT_NEW_PASSWORD);
						}
					}
				}
				else{
				  Failure (_NEW_PASSWORD_NOT_MATCH_CONFIRMATION);
				}
			}
			else{
				Failure (_CURRENT_PASSWORD_IS_NOT_CORRECT);
			}
			echo'</div>';
			break;
		default:
			echo '
				<h1>'._SETTINGS.'</h1>
				';
			break;
	}
}

require_once 'footer.php';
 ?>