<?php 
require 'config.php';
session_start();
if (!isset($_COOKIE['projo']) && !preg_match("/login.php/i", $_SERVER['REQUEST_URI'])) {
	header('location: login.php');
}
if (isset($_SESSION['user_last_ip'])===false) {
	$_SESSION['user_last_ip'] = $_SERVER['REMOTE_ADDR'];
}
if ($_SESSION['user_last_ip']!== $_SERVER['REMOTE_ADDR']) {
	session_unset();
	session_destroy();
}

require_once 'include/class.database.php';
$db_connection = new dbConnection();
if(!$db_connection->connect()){
	header('Location: install'); exit();
}

require_once 'include/class.admin.php';
require_once 'include/class.admins_tasks.php';
require_once 'include/class.project.php';
require_once 'include/class.issues.php';
require_once 'include/class.issue_types.php';
require_once 'include/class.task.php';
require_once 'include/class.task_issue.php';
require_once 'include/class.comment.php';
require_once 'include/functions.php';
require_once 'include/class.settings.php';
require_once 'include/class.comment.php';
$admin= new ManageAdmins();
if (isset($_COOKIE['projo'])) {
	$cookie_admin= explode(':', $_COOKIE['projo']);
	if ($admin->Login($cookie_admin[0],$cookie_admin[1])!=1) {
		header('location: logout.php');
	}
	$cookie_admin= explode(':', $_COOKIE['projo']);
	$permissions = $admin->GetAdminInfo($cookie_admin[0]);
}
$settings_class = new ManageSettings();
$system_settings = $settings_class->SystemSettings();
$direction = $system_settings[0]["direction"];
$themes = $system_settings[0]["theme"];
$language = $system_settings[0]["language"];
$system_title = $system_settings[0]["system_title"];
require_once 'language/'.$language.'.php';

if ($direction=="1")
{
	$dir=1;
	$align1 = "right";
	$align2 = "left";
}
else
{
	$dir=0;
	$align1 = "left";
	$align2 = "right";
}
 ?>