<?php
date_default_timezone_set('UTC');
$error="";
echo 
'<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="../vendor/bootstrap-4.5.0/css/bootstrap.min.css" type="text/css" media="all">

		<script src="../vendor/jquery-3.5.1.min.js"></script>

		<script src="../vendor/popper.min.js"></script>

		<script src="../vendor/bootstrap-4.5.0/js/bootstrap.min.js"></script>
		
		<!--=========================================================================================-->
		<link rel="stylesheet" type="text/css" href="../vendor/animate/animate.css">
		<!--=========================================================================================-->
		<link rel="stylesheet" type="text/css" href="../vendor/css-hamburgers/hamburgers.min.css">
		<!--=========================================================================================-->
		<link rel="stylesheet" type="text/css" href="../vendor/select2/select2.min.css">
		<!--=========================================================================================-->
		<link rel="stylesheet" type="text/css" href="../themes/2020/login/css/util.css">
		<link rel="stylesheet" type="text/css" href="../themes/2020/login/css/main.css">

		<link rel="stylesheet" href="../themes/2020/css/style.css" type="text/css" media="all">
    	<link rel="shortcut icon" href="../themes/2020/img/logo.png">

		<title>Proja Installation - نصب سیستم پروژو</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Nomra">
		<meta http-equiv="X-UA-Compatible" content="IE=9">

		
		<script type="text/javascript" src="../themes/2020/js/scripts.js"></script>
		<style>
			body{
				font-family: Samim;
			}
		</style>
		
	</head>
	<body dir="rtl">
		<div class="limiter">
			<div class="container-login100">
				<div class="wrap-login100" style="padding: 45px 60px 33px 60px">
					<div class="login100-pic js-tilt" data-tilt style="width: 100px; margin: 0 auto">
						<img src="logo.png" alt="IMG" style="width: 100px; height: 100px">
					</div>
					<h3 class="text-center p-4 w-100">سیستم نصب Projo</h3>
					<form class="form-vertical w-100" id="installNomra" method="post" action="">
						';
						echo'
						<!-- <div id="wrapper" style="margin-top: 20px; padding: 10px;">
						  <div class="row">
							<div class="col-md-3"></div>
							<div class="col-sm-12 col-md-6 well" id="content"> -->
						';

					require_once('../config.php');
					include_once('../include/class.database.php');
					$db_connection = new dbConnection();

					if ($db_connection->connect()!='')
					{
						
						echo '
						<div class="alert alert-danger" role="alert">
							<h3 style="color:red;">
							سیستم پیش از این نصب شده است!<br>
							اگر شما مدیر سیستم هستید، لطفاً این پوشه (یعنی پوشه install) را برای حفظ امنیت سیستم، پاک نمایید.</h3>
							<br><div style="direction:ltr; text-align:left; font-size:15pt; color:red;">System has already been installed!!</div>
						</div>
						';
					}
					else
					{
						if(isset($_POST['install']))
						{
							$dbhost = $_POST['host'];
							$dbname = $_POST['dbname'];
							$dbuname = $_POST['dbuname'];
							$dbpass = $_POST['dbpass'];
							$lang = $_POST['lang'];
							$dir = $_POST['dir'];
							$default = $_POST['default'];
							$sistem_name = $_POST['sistem_name'];
							$admin_username = $_POST['admin_username'];
							$admin_password = md5($_POST['admin_password']);
							if(empty($dbhost) || empty($dbname) || empty($dbuname) || empty($sistem_name) || empty($lang) || empty($admin_username) || empty($admin_password))
								$error = "پروژو کردن تمام فیلدها الزامی است! (All fields are required)<br>";
							
							if ($db_connection->connect()=='')
								$error .= "اطلاعات پایگاه داده غلط است. ارتباط با بانک میسر نشد! (Database information are incorrect!)";
							
							if(empty($error))// Now install Nomra
							{
								$handle=fopen('../config.php', 'w+');
								$data = "<?php\n\$dbhost = '".$dbhost."';\n\$dbname = '".$dbname."';\n\$dbuname = '".$dbuname."';\n\$dbpass = '".$dbpass."';\n\$sistem_name = '".$sistem_name."';\n\$pic_prefix = 'img_projo';\n\$file_prefix = 'file_projo';\n\$admin_session_name = 'projo_admin';\n\$admin_password_session_name = 'projo_admin_pass';\n\$page_limit = 20;\n\$page_limit_index = 5;\n\$dev = 0;\n\$title='';\n\$success=\$error='';\n?>";

								if (fwrite($handle, $data))
								{
									echo '<div class="alert alert-success text-right">
											فایل config.php با موفقیت ایجاد شد.
										  </div>';
									try {
									
										$dbh = $db_connection->connect();
										/*** echo a message saying we have connected ***/
										echo '<br>';
									
										/*** set the PDO error mode to exception ***/
										$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
										/*** begin the transaction ***/
										$dbh->beginTransaction();
									
										/*** CREATE table statements ***/
										$dbh->exec("
										
										CREATE TABLE IF NOT EXISTS `admins` (
										  	`aid` int(11) NOT NULL,
										  	`ausername` varchar(255) COLLATE utf8_persian_ci NOT NULL,
										  	`apass` varchar(255) COLLATE utf8_persian_ci NOT NULL,
										  	`aactive` tinyint(1) NOT NULL DEFAULT 0,
										  	`aexpiration_date` timestamp NOT NULL DEFAULT current_timestamp(),
										  	`asuper_admin` tinyint(1) NOT NULL DEFAULT 0,
										  	`afname` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
										  	`alname` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
										  	`agender` tinyint(1) NOT NULL DEFAULT 0,
										  	`atel` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
										  	`aemail` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
										  	`apic` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
										  	`acomments` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
										  	`allow_add_project` tinyint(1) NOT NULL DEFAULT 0,
										  	`allow_edit_project` tinyint(1) NOT NULL DEFAULT 0,
										  	`allow_list_project` tinyint(1) NOT NULL DEFAULT 0,
										  	`allow_delete_project` tinyint(1) NOT NULL DEFAULT 0,
										  	`allow_add_task` tinyint(1) NOT NULL DEFAULT 0,
										  	`allow_edit_task` tinyint(1) NOT NULL DEFAULT 0,
										  	`allow_list_task` tinyint(1) NOT NULL DEFAULT 0,
										  	`allow_delete_task` tinyint(1) NOT NULL DEFAULT 0,
										  	`allow_add_issues` tinyint(1) NOT NULL DEFAULT 0,
										  	`allow_edit_issues` tinyint(1) NOT NULL DEFAULT 0,
										  	`allow_list_issues` tinyint(1) NOT NULL DEFAULT 0,
										  	`allow_delete_issues` tinyint(1) NOT NULL DEFAULT 0
										) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=9 ;
										");
										$dbh->exec("

											INSERT INTO `admins` (`aid`, `ausername`, `apass`, `aactive`, `asuper_admin`, `afname`, `alname`, `agender`, `atel`, `aemail`, `apic`, `acomments`, `allow_add_project`, `allow_edit_project`, `allow_list_project`, `allow_delete_project`, `allow_add_task`, `allow_edit_task`, `allow_list_task`, `allow_delete_task`, `allow_add_issues`, `allow_edit_issues`, `allow_list_issues`, `allow_delete_issues`) 
											VALUES
											(1, '".$admin_username."', '".$admin_password."', 1, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
												");
										
										$dbh->exec("
											
											CREATE TABLE IF NOT EXISTS `projects` (
												`prjid` int(11) NOT NULL,
												`prjcode` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'کد پروژه',
												`prjtitle` varchar(255) COLLATE utf8_persian_ci NOT NULL COMMENT 'عنوان پروژه',
												`prjdesc` text COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'توضیحات',
												`prjlogo` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'لوگو محصول',
												`bg_color` text COLLATE utf8_persian_ci NOT NULL,
												`prjcomments` text COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'توضیحات',
												`prjdate` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'زمان ثبت',
												`aid` int(11) NOT NULL
											) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=4 ;

										");

										if ($default==1) {
											$dbh->exec("
												INSERT INTO `projects` (`prjid`, `prjcode`, `prjtitle`, `prjdesc`, `prjlogo`, `bg_color`, `prjcomments`, `aid`) VALUES
												(1, '1', 'projo', '', '-1199440.png', '#20c997', '', 1);
												");
										}
										$dbh->exec("	
											CREATE TABLE IF NOT EXISTS `issues` (
												`iid` int(11) NOT NULL,
												`prjid` int(11) NOT NULL,
												`tyid` int(11) NOT NULL,
												`aid` int(11) NOT NULL,
												`iversion` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
												`icode` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
												`ititle` varchar(255) COLLATE utf8_persian_ci NOT NULL,
												`idesc` text COLLATE utf8_persian_ci DEFAULT NULL,
												`iproirity` varchar(10) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'اهمیت',
												`icomplexity` varchar(1) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'پیچیدگی',
												`ineeded_time` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'زمان مورد نیاز',
												`ifile1` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
												`ifile2` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
												`ifile3` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
												`iarchive` tinyint(1) DEFAULT NULL,
												`idate` timestamp NOT NULL DEFAULT current_timestamp(),
												`iwho_fullname` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام پیشنهاد دهنده',
												`iwho_email` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام خانوادگی پیشنهاد دهنده',
												`iwho_tel` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'ایمیل پیشنهاد دهنده',
												`idone` tinyint(1) DEFAULT 0,
												`idone_date` date DEFAULT NULL COMMENT 'تاریخ پایان',
												`idone_version` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'پایان پروژه'
											) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=11 ;

										");

										$dbh->exec("
											
											CREATE TABLE IF NOT EXISTS `issue_types` (
												`tyid` int(11) NOT NULL,
												`tycode` varchar(255) COLLATE utf8_persian_ci NOT NULL,
												`tytitle` varchar(255) COLLATE utf8_persian_ci NOT NULL,
												`tycomments` text COLLATE utf8_persian_ci DEFAULT NULL
											) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=4 ;

										");

										$dbh->exec("
											INSERT INTO `issue_types` (`tyid`, `tycode`, `tytitle`, `tycomments`) VALUES
											(1, '1', 'ایراد (Bugs)', ''),
											(2, '2', 'قابلیت (Features)', ''),
											(3, '3', 'پیشنهادات (Suggestions)', '');

										");
										
										if ($default==1) {
											if ($lang == 'farsi') {
												$issue1_title = "پروژو! اینجا یک مساله است. از دکمه بالا ^ استفاده کن تا یک مساله بسازی";
												$issue2_title = "برای باز کردن موضوع ، روی آن ضربه بزنید.";
												$issue3_title = "هر تعداد مساله بخواهید میتوانید ایجاد کنید. ما یک منبع نامحدود هستیم!";
												$issue4_title = "کارت با مساله تموم شد؟";
												$issue5_title = "میتونید خیلی راحت به ماموریت ها مدیر اضافه کنید";
												$issue6_title = "آیا میخواهید همیشه بروز باشید؟";

												$issue1_text = "";	
												$issue2_text = "
													اینجا همه چیز جالب است. \r\n
													* تغییر وضعیت در هر لحظه\r\n
													* اختصاص کاربران به ماموریت ها\r\n
													* پیوست انواع فایل‌\r\n
													* ثبت مستندات
												";	
												$issue3_text = "";
												$issue4_text = "
													خیلی راحت میتونی مساله رو آرشیو کنی\r\n
													آیا میخواهید اون رو برگردونید؟ به قسمت آرشیو شده‌ها بروید\r\n
												";	
												$issue5_text = "
													کافیه روی عنوان ماموریت کلیک کنی و در بخش مدیران، مدیری که از قبل به سیستم اضافه کردی رو انتخاب کنی.
												";	
												$issue6_text = "
													<p dir=\"ltr\">وبلاگ ما را بخوانید:<a href=\"%20http:/projo.ir/\" target=\"_blank\" rel=\"noopener\"> http://projo.ir/</a><br><br>مارو در اینستاگرام دنبال کنید: <a href=\"https://www.instagram.com/projo\" target=\"_blank\" rel=\"noopener\">https://www.instagram.com/projo</a><br><br>در توییتر دنبال کنید: <a href=\"http://twitter.com/projo\" target=\"_blank\" rel=\"noopener\">http://twitter.com/projo</a></p>
												";	
											}
											else {
												$issue1_title = "Proja! This is an issue.";	
												$issue2_title = "Tap on a issue to open it up.";	
												$issue3_title = "Create as many cards as you want. We''ve got an unlimited supply!";	
												$issue4_title = "Finished with a issue?";	
												$issue5_title = "Invite admin to collaborate on this task.";	
												$issue6_title = "Want updates on new features?";

												$issue1_text = "";	
												$issue2_text = "<p dir=\"ltr\">There''s all kinds of cool stuff here. <br>* Due date<br>* Members In Tasks<br>* Attachments<br>* Descs</p>";	
												$issue3_text = "";
												$issue4_text = "
													You can archive a card from the tools menu in the edit issue.\r\n
													Want to bring it back to the board? Go to the *Archived Items* section to return the card to the board.
												";	
												$issue5_text = "";	
												$issue6_text = "
													<p dir=\"ltr\">Read our blog:<a href=\"%20http:/projo.ir/\" target=\"_blank\" rel=\"noopener\"> http://projo.ir/</a><br><br>Like us on Instagram: <a href=\"https://www.instagram.com/projo\" target=\"_blank\" rel=\"noopener\">https://www.instagram.com/projo</a><br><br>Follow us on Twitter: <a href=\"http://twitter.com/projo\" target=\"_blank\" rel=\"noopener\">http://twitter.com/projo</a></p>
												";	
											}
											$dbh->exec("

												INSERT INTO `issues` (`iid`, `prjid`, `tyid`, `aid`, `iversion`, `icode`, `ititle`, `idesc`, `iproirity`, `icomplexity`, `ineeded_time`, `ifile1`, `ifile2`, `ifile3`, `iarchive`, `iwho_fullname`, `iwho_email`, `iwho_tel`, `idone`, `idone_date`, `idone_version`) VALUES
													(1, 1, 3, 1, '1.0.0', 1, '".$issue1_title."', '".$issue1_text."', '1', '5', '', '', '', '', 0, '', '', '', 0, '0000-00-00', 0),
													(2, 1, 3, 1, '', 2, '".$issue2_title."', '".$issue2_text."', '2', '4', '', '', '', '', 0, '', '', '', 0, '0000-00-00', 0),
													(3, 1, 3, 1, '', 3, '".$issue3_title."', '".$issue3_text."', '0', '3', '', '', '', '', 0, '', '', '', 0, '0000-00-00', 0),
													(4, 1, 3, 1, '', 4, '".$issue4_title."', '".$issue4_text."', '0', '5', '', '', '', '', 0, '', '', '', 0, '0000-00-00', 0),
													(5, 1, 3, 1, '', 5, '".$issue5_title."', '".$issue5_text."', '0', '3', '', '', '', '', 0, '', '', '', 0, '0000-00-00', 0),
													(6, 1, 3, 1, '', 6, '".$issue6_title."', '".$issue6_text."', '0', '3', '', '', '', '', 0, '', '', '', 0, '0000-00-00', 0);
													");
										}

										$dbh->exec("
											CREATE TABLE IF NOT EXISTS `settings` (
											`id` int(11) NOT NULL,
											  `system_title` varchar(255) COLLATE utf8_persian_ci NOT NULL,
											  `language` varchar(255) COLLATE utf8_persian_ci NOT NULL,
											  `direction` tinyint(1) NOT NULL DEFAULT '0',
											  `theme` varchar(255) COLLATE utf8_persian_ci NOT NULL
											) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=2 ;

										");
										
										$dbh->exec("
											
											INSERT INTO `settings` (`id`, `system_title`, `language`, `direction`, `theme`) VALUES
											(1, '".$sistem_name."', '".$lang."', '".$dir."', '2020');

										");
										$dbh->exec("
											
											CREATE TABLE IF NOT EXISTS `comments` (
											`cid` int(11) NOT NULL,
											  `ctext` text COLLATE utf8_persian_ci NOT NULL,
											  `cdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
											) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

										");

										$dbh->exec("
											CREATE TABLE IF NOT EXISTS `tasks` (
												`tskid` int(11) NOT NULL,
												`prjid` int(11) NOT NULL,
												`aid` int(11) NOT NULL,
												`tskcode` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'کد',
												`tsktitle` varchar(255) COLLATE utf8_persian_ci NOT NULL COMMENT 'عنوان',
												`tskdesc` text COLLATE utf8_persian_ci DEFAULT NULL,
												`tskdate` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'تاریخ درج',
												`tskdone` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'پایان',
												`tskdone_date` date DEFAULT NULL COMMENT 'تاریخ پایان'
											) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=4 ;

										");

										if ($default==1) {
											if ($lang == 'farsi') {
												$task1_title = "چگونه شروع کنم";
												$task2_title = "تسلط بر پروژو";
												$task3_title = "اطلاعات بیشتر";
											}
											else {
												$task1_title = "Getting Started";
												$task2_title = "Mastering Projo";
												$task3_title = "More Info";
											}
											$dbh->exec("
												INSERT INTO `tasks` (`tskid`, `prjid`, `aid`, `tskcode`, `tsktitle`, `tskdesc`, `tskdone`, `tskdone_date`) VALUES
												(1, 1, 1, '1', '".$task1_title."', '', 0, NULL),
												(2, 1, 1, '2', '".$task2_title."', '', 0, NULL),
												(3, 1, 1, '3', '".$task3_title."', '', 0, NULL);			
												");
										}

										$dbh->exec("
											CREATE TABLE IF NOT EXISTS `admins_tasks` (
											`atid` int(11) NOT NULL,
											  `aids` int(11) NOT NULL,
											  `tskid` int(11) DEFAULT NULL
											) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=10 ;

										");
										
										if ($default==1) {
											$dbh->exec("
												INSERT INTO `admins_tasks` (`atid`, `aids`, `tskid`) VALUES
												(1, 1, 1),
												(2, 1, 2),
												(3, 1, 3);
												");
										}			

										$dbh->exec("
											CREATE TABLE IF NOT EXISTS `tasks_issues` (
												`tiid` int(11) NOT NULL,
											  	`tskid` int(11) NOT NULL,
											  	`iid` int(11) NOT NULL
											) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=12 ;

										");

										if ($default==1) {
											$dbh->exec("
												INSERT INTO `tasks_issues` (`tiid`, `tskid`, `iid`) VALUES
												(1, 1, 1),
												(2, 1, 2),
												(3, 1, 3),
												(4, 2, 4),
												(5, 2, 5),
												(6, 3, 6);
												");
										}
													
										$dbh->exec("
											
											ALTER TABLE `admins`
											 	ADD PRIMARY KEY (`aid`);
										");

										$dbh->exec("
											ALTER TABLE `admins_tasks`
											 	ADD PRIMARY KEY (`atid`),
											 	ADD KEY `aid` (`aids`),
											 	ADD KEY `tskid` (`tskid`),
											 	ADD KEY `aids` (`aids`);
										");

										$dbh->exec("
											ALTER TABLE `comments`
											  ADD PRIMARY KEY (`cid`);
										");

										$dbh->exec("
											ALTER TABLE `issues`
											 	ADD PRIMARY KEY (`iid`),
											 	ADD KEY `tyid` (`tyid`),
											 	ADD KEY `prjid` (`prjid`),
											 	ADD KEY `aid` (`aid`);
										");

										$dbh->exec("
											ALTER TABLE `issue_types`
											 	ADD PRIMARY KEY (`tyid`);
										");

										$dbh->exec("
											ALTER TABLE `projects`
											 	ADD PRIMARY KEY (`prjid`),
											 	ADD KEY `aid` (`aid`);
										");

										$dbh->exec("
											ALTER TABLE `settings`
											 	ADD PRIMARY KEY (`id`);
										");

										$dbh->exec("
											ALTER TABLE `tasks`
											 	ADD PRIMARY KEY (`tskid`),
											 	ADD KEY `prjid` (`prjid`),
											 	ADD KEY `aid` (`aid`);
										");

										$dbh->exec("
											ALTER TABLE `tasks_issues`
											 	ADD PRIMARY KEY (`tiid`),
											 	ADD KEY `tskid` (`tskid`),
											 	ADD KEY `iid` (`iid`);
										");

										$dbh->exec("

											ALTER TABLE `admins`
											MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
										");

										$dbh->exec("
											ALTER TABLE `admins_tasks`
											MODIFY `atid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
										");

										$dbh->exec("

											ALTER TABLE `issues`
											MODIFY `iid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
										");

										$dbh->exec("

											ALTER TABLE `issue_types`
											MODIFY `tyid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;

										");

										$dbh->exec("

											ALTER TABLE `projects`
											MODIFY `prjid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
										");

										$dbh->exec("

											ALTER TABLE `settings`
											MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
										");

										$dbh->exec("

											ALTER TABLE `tasks`
											MODIFY `tskid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
										");

										$dbh->exec("

											ALTER TABLE `tasks_issues`
											MODIFY `tiid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
										");

										$dbh->exec("
											
											ALTER TABLE `admins_tasks`
												ADD CONSTRAINT `at_aids_fk` FOREIGN KEY (`aids`) REFERENCES `admins` (`aid`) ON UPDATE CASCADE,
												ADD CONSTRAINT `at_tskid_fk` FOREIGN KEY (`tskid`) REFERENCES `tasks` (`tskid`) ON DELETE CASCADE ON UPDATE CASCADE;
										");

										$dbh->exec("

											ALTER TABLE `issues`
												ADD CONSTRAINT `issue_prjid_fk` FOREIGN KEY (`prjid`) REFERENCES `projects` (`prjid`) ON DELETE CASCADE ON UPDATE CASCADE,
												ADD CONSTRAINT `issues_aid_fk` FOREIGN KEY (`aid`) REFERENCES `admins` (`aid`) ON UPDATE CASCADE,
												ADD CONSTRAINT `issues_tyid_fk` FOREIGN KEY (`tyid`) REFERENCES `issue_types` (`tyid`) ON UPDATE CASCADE;
										");

										$dbh->exec("

											ALTER TABLE `projects`
											ADD CONSTRAINT `project_aid_fk` FOREIGN KEY (`aid`) REFERENCES `admins` (`aid`) ON UPDATE CASCADE;
										");

										$dbh->exec("

											ALTER TABLE `tasks`
												ADD CONSTRAINT `task_aid_fk` FOREIGN KEY (`aid`) REFERENCES `admins` (`aid`) ON UPDATE CASCADE,
												ADD CONSTRAINT `task_prjid_fk` FOREIGN KEY (`prjid`) REFERENCES `projects` (`prjid`) ON DELETE CASCADE ON UPDATE CASCADE;
										");

										$dbh->exec("

											ALTER TABLE `tasks_issues`
												ADD CONSTRAINT `ti_iid_fk` FOREIGN KEY (`iid`) REFERENCES `issues` (`iid`) ON DELETE CASCADE ON UPDATE CASCADE,
												ADD CONSTRAINT `ti_tskid_fk` FOREIGN KEY (`tskid`) REFERENCES `tasks` (`tskid`) ON DELETE CASCADE ON UPDATE CASCADE;
										");

										$dbh->exec("
											ALTER TABLE `comments`
											MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT;
										");
										/*** commit the transaction ***/
										$dbh->commit();
										
										
									
										/*** echo a message to say the database was created ***/
										$success = '
										<h3 style="direction:ltr; text-align:left;">Congratulations! Proja installed successfully ;)</h3><br><div style="direction:ltr; text-align:left;">Please delete the "install" folder for security reasons...</div><br>
										تبریک عرض می‌کنیم! پروژو با موفقیت نصب شد!<br>
										لطفاً به بخش مدیریت سیستم وارد شوید و تنظیمات سیستم را کامل نمایید و طبق راهنمای پروژو، از آن استفاده نمایید.<br>
										<a href="../"><strong>پنل مدیریت پروژو</strong></a><br><br>
										
										<strong>راهنمای پروژو</strong>:<br>
										<a href="http://projo.ir" target="_blank">http://projo.ir</a>	
										<br><br>
										<strong style="color:red;">توجه:</strong> 
										 لطفاً برای حفظ امنیت سیستم، پوشه install را پاک نمایید.
													
										';
										echo '
										<div class="alert alert-success text-right">
											'.$success.'
										</div>';
									}
									catch(PDOException $e)
									{
										/*** roll back the transaction if we fail ***/
										$dbh->rollback();
									
										/*** echo the sql statement and error message ***/
										echo $sql . '<br>' . $e->getMessage();
									}
								}
								else
								echo '<div class="alert alert-error">
								  مشکلی در ساختن فایل config.php به وجود آمد. لطفاً سطح دسترسی این فایل را روی 777 تنظیم نمایید.
							  </div>';
							}
							
						}
						if(!empty($error) || !isset($_POST['install']))
						{
							
							if(!empty($error))
							echo '<div class="alert alert-danger">
										  '.$error.'
								  </div>';
							echo '
							<p class="text-right">
								به نظر می‌رسد سیستم Proja هنوز نصب نشده است! برای نصب این سیستم، اطلاعات خواسته شده را به طور کامل وارد نمایید...
							</p>
							<p class="text-left" style="direction:ltr;">
								It seems that Proja has not been installed yet. To install Proja, please fill out the below form...
							</p>
							';
							echo '
							<div class="table-responsive">
								<table class="table table-striped table-hover" width="100%">
									<tr style="background-color:#9B006D; height:20px;">
										<td class="text-right" width="30%" style="color:white;">
										<strong>اطلاعات پایگاه داده</strong>:
										</td>
										<td width="40%">
										
										</td>
										<td width="30%" style="direction:ltr; color:white;">
										<strong>Database Information</strong>:
										</td>
									</tr>
									<tr>
										<td class="text-right" width="30%">
										<strong>آدرس هاست</strong>:<br>
										<span class="small">توجه: اگر نمی‌دانید این فیلد به چه معناست، همان localhost رها کنید. در اکثر مواقع این عبارت صحیح است.</span>
										</td>
										<td width="40%">
										<input value="'.(isset($_POST['host'])?$_POST['host']:"localhost").'" type="text" class="input form-control" autocomplete="off" id="host" name="host" style="direction:ltr;">
										</td>
										<td width="30%" style="direction:ltr;">
										<strong>Host Address</strong>:<br>
										<span class="small">Leave it "localhost" if you do not know what it is.</span>
										</td>
									</tr>
									<tr style="background-color:#e3e3e3">
										<td class="text-right" width="30%">
										<strong>نام دیتابیس</strong>:
										</td>
										<td width="40%">
										<input value="'.(isset($_POST['dbname'])?$_POST['dbname']:'').'" type="text" class="input form-control" autocomplete="off" id="dbname" name="dbname" style="direction:ltr;">
										</td>
										<td width="30%" style="direction:ltr;">
										<strong>Database Name</strong>:
										</td>
									</tr>
									<tr>
										<td class="text-right" width="30%">
										<strong>نام کاربری دیتابیس</strong>:
										</td>
										<td width="40%">
										<input value="'.(isset($_POST['dbuname'])?$_POST['dbuname']:'').'" type="text" class="input form-control" autocomplete="off" id="dbuname" name="dbuname" style="direction:ltr;">
										</td>
										<td width="30%" style="direction:ltr;">
										<strong>Database Username</strong>:
										</td>
									</tr>
									<tr style="background-color:#e3e3e3">
										<td class="text-right" width="30%">
										<strong>رمز عبور دیتابیس</strong>:
										</td>
										<td width="40%">
										<input value="" type="password" class="input form-control" autocomplete="off" id="dbpass" name="dbpass" style="direction:ltr;">
										</td>
										<td width="30%" style="direction:ltr;">
										<strong>Database Password</strong>:
										</td>
									</tr>
									
									
									<tr style="background-color:#9B006D; height:20px;">
										<td class="text-right" width="30%" style="color:white;">
										<strong>اطلاعات سیستم</strong>:
										</td>
										<td width="40%">
										
										</td>
										<td width="30%" style="direction:ltr; color:white;">
										<strong>System Information</strong>:
										</td>
									</tr>
									<tr>
										<td class="text-right" width="30%">
										<strong>زبان سیستم</strong>:
										</td>
										<td width="40%">
										<select class="form-control" name="lang" style="width:150px; direction:ltr;">
													';
												$directory=opendir('../language');
											
												while (false != ($file=readdir($directory)))
												{
													if (strpos($file, '.php', 1))
													{
														$rest=substr("$file", 0, -4);
														$language = (isset($_POST['lang'])?$_POST['lang']:'farsi');
														if($rest == $language)
															echo ('<option value="' . $rest . '" selected="selected">' . ucfirst($rest) . '</option>');
														else
															echo ('<option value="' . $rest . '">' . ucfirst($rest) . '</option>');
													}
												}
											
												closedir ($directory);
												
												$dir_checked1 = $dir_checked2 ="";
												$default_checked1 = $default_checked2 ="";
												$dir = (isset($_POST['dir'])?$_POST['dir']:'1');
												$default = (isset($_POST['default'])?$_POST['default']:'');
												if($dir=="1")
													$dir_checked1 = 'checked="checked"';
												else
													$dir_checked2 = 'checked="checked"';
												if($default=="0")
													$default_checked2 = 'checked="checked"';
												else
													$default_checked1 = 'checked="checked"';
												
												echo '	</select>
										</td>
										<td width="30%" style="direction:ltr;">
										<strong>System Language</strong>:
										</td>
									</tr>
									<tr style="background-color:#e3e3e3">
										<td class="text-right" width="30%">
										<strong>چینش زبان</strong>:
										</td>
										<td width="40%">
											<input type="radio" name="dir" id="dir1" value="1" '.$dir_checked1.'> <label for="dir1">راست به چپ (RTL)</label><br>
											<input type="radio" name="dir" id="dir2" value="0" '.$dir_checked2.'> <label for="dir2">چپ به راست (LTR)</label> 
										</td>
										<td width="30%" style="direction:ltr;">
										<strong>Language Direction</strong>:
										</td>
									</tr>
									<tr>
										<td class="text-right" width="30%">
										<strong>نام سیستم</strong>:
										</td>
										<td width="40%">
										<input value="'.(isset($_POST['sistem_name'])?$_POST['sistem_name']:'').'" type="text" class="input form-control" autocomplete="off" id="sistem_name" name="sistem_name" style="direction:rtl;">
										</td>
										<td width="30%" style="direction:ltr;">
										<strong>Sistem Name</strong>:
										</td>
									</tr>
									<tr style="background-color:#e3e3e3">
										<td class="text-right" width="30%">
										<strong>اطلاعات پیشفرض داشته باشد؟</strong>
										<span class="small">اگر می‌خواهید به عنوان نمونه یک پروژه و اطلاعات در سیستم درج شود تا بهتر متوجه روال کار سیستم شوید، «بله» را انتخاب نمایید...</span>
										</td>
										<td width="40%">
											<input type="radio" name="default" id="default1" value="1" '.$default_checked1.'> <label for="default1">بله (Yes)</label> 
											<input type="radio" name="default" id="default2" value="0" '.$default_checked2.'> <label for="default2">خیر (No)</label> 
										</td>
										<td width="30%" style="direction:ltr;">
										<strong>Default information</strong>:
										</td>
									</tr>
									<tr style="background-color:#9B006D; height:20px;">
										<td class="text-right" width="30%" style="color:white;">
										<strong>اطلاعات مدیر کل</strong>:
										</td>
										<td width="40%">
										
										</td>
										<td width="30%" style="direction:ltr; color:white;">
										<strong>God Admin Information</strong>:
										</td>
									</tr>
									<tr style="background-color:#e3e3e3">
										<td class="text-right" width="30%">
										<strong>نام کاربری مدیر کل</strong>:<br>
										<span class="small">مثال: Hamid یا Mojtaba و غیره<br>
										بهتر است کلمات واضحی مثل Admin نباشد</span>
										</td>
										<td width="40%">
										<input value="'.(isset($_POST['admin_username'])?$_POST['admin_username']:'').'" type="text" class="input form-control" autocomplete="off" id="admin_username" name="admin_username" style="direction:ltr;">
										</td>
										<td width="30%" style="direction:ltr;">
										<strong>God Admin Username</strong>:
										</td>
									</tr>
									<tr>
										<td class="text-right" width="30%">
										<strong>رمز عبور مدیر کل</strong>:<br>
										<span class="small">توجه: بهتر است امن باشد و در عین حال به راحتی به یاد آورید.<br>
										در صورتی که این رمز را فراموش کنید، فقط از طریق دیتابیس می‌توانید آن‌را بازگردانید.
										</span>
										</td>
										<td width="40%">
										<input value="" type="password" class="input form-control" autocomplete="off" id="admin_password" name="admin_password" style="direction:ltr;">
										</td>
										<td width="30%" style="direction:ltr;">
										<strong>God Admin Password</strong>:
										</td>
									</tr>
									
								</table>
							</div>
							<div class="alert alert-danger text-right">توجه: پر کردن تمام فیلدها الزامی است.</div>
							<div class="text-center">
								<input type="submit" name="install" value="نصب Proja" class="btn btn-primary btn-large">
							</div>
								<!-- </div>
								<div class="col-md-3"></div>
							</div>
						  </div> -->
							';
						}

					}
					echo'
					</form>
				</div>
  			</div>
  		</div>
  	</div>

	<!--===============================================================================================-->
		<script src="../vendor/select2/select2.min.js"></script>
	<!--===============================================================================================-->
		<script src="../vendor/tilt/tilt.jquery.min.js"></script>
		<script >
			$(\'.js-tilt\').tilt({
				scale: 1.1
			})
		</script>
	<!--===============================================================================================-->
		<script src="../themes/2020/login/js/main.js"></script>
';
include_once('../footer.php');
?>