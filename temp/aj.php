<?php 
require_once '../main.php';
$issue = new ManageIssues();
$project = new ManageProjects();
$op = $_POST['op'];
switch ($op) {
	case 'issue_prjid':
		$fname = $_POST['fname'];
		echo $fname;
		break;
	default:
		# code...
		break;
}

 ?>