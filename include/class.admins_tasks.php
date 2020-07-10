<?php 
include_once 'class.database.php';
class ManageAdmins_Tasks{
	public $link;
	function __construct()
	{
		$db_connection = new dbconnection();
		$this->link = $db_connection->connect();
		return $this->link;
	}
	function Add($aids , $tskid)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("INSERT INTO `admins_tasks`(aids, tskid) VALUES(?,?)");
		$values = array($aids, $tskid);
		$query->execute($values);
		$counts = $query->rowcount();
		if ($dev==1) {
			echo '<pre dir="ltr">';
			print_r($query->errorInfo());
			echo '</pre>';
			echo '<pre dir="ltr">';
			print_r($query->debugDumpParams());
			echo '</pre>';
		}
		return $counts;
	}


	function Update($atid, $tskid, $aids)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("UPDATE `admins_tasks` SET tskid=?, aids=? WHERE atid=?");
		$values = array($tskid, $aids, $atid);
		$query->execute($values);
		$counts = $query->rowcount();
		if ($dev==1) {
			echo '<pre dir="ltr">';
			print_r($query->errorInfo());
			echo '</pre>';
			echo '<pre dir="ltr">';
			print_r($query->debugDumpParams());
			echo '</pre>';
		}
		return $counts;
	}

	function GetList($q=NULL, $order="ORDER BY atid DESC",$limit=NULL)
	{
		global $prefix;
		global $dev;
		$query = $this->link->query("SELECT * FROM admins_tasks $q $order $limit");
		if ($dev==1) {
			echo '<pre dir="ltr">';
			print_r($query->errorInfo());
			echo '</pre>';
			echo '<pre dir="ltr">';
			print_r($query->debugDumpParams());
			echo '</pre>';
		}
		return $query->fetchAll();
	}

	function GetListByAid($q=NULL, $order="ORDER BY atid DESC",$limit=NULL)
	{
		global $prefix;
		global $dev;
		$query = $this->link->query("SELECT tskid FROM admins_tasks $q $order $limit");
		if ($dev==1) {
			echo '<pre dir="ltr">';
			print_r($query->errorInfo());
			echo '</pre>';
			echo '<pre dir="ltr">';
			print_r($query->debugDumpParams());
			echo '</pre>';
		}
		return $query->fetchAll();
	}


	function GetAdminTasks($aids)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("SELECT tskid FROM admins_tasks WHERE aids=?");
		$values = array($aids);
		$query->execute($values);
		if ($dev==1) {
			echo '<pre dir="ltr">';
			print_r($query->errorInfo());
			echo '</pre>';
			echo '<pre dir="ltr">';
			print_r($query->debugDumpParams());
			echo '</pre>';
		}
		return $query->fetchAll(PDO::FETCH_COLUMN);
	}


	function GetList_task($q=NULL, $order="ORDER BY atid DESC",$limit=NULL)
	{
		global $prefix;
		global $dev;
		$query = $this->link->query("SELECT * FROM admins_tasks INNER JOIN tasks on tasks.tskid=admins_tasks.tskid $q $order $limit");
		if ($dev==1) {
			echo '<pre dir="ltr">';
			print_r($query->errorInfo());
			echo '</pre>';
			echo '<pre dir="ltr">';
			print_r($query->debugDumpParams());
			echo '</pre>';
		}
		return $query->fetchAll();
	}


	function GetListPrjAdmin($q=NULL, $order="ORDER BY atid DESC",$limit=NULL)
	{
		global $prefix;
		global $dev;
		$query = $this->link->query("SELECT * FROM admins_tasks INNER JOIN tasks on admins_tasks.tskid=tasks.tskid INNER JOIN projects on projects.prjid=tasks.prjid $q $order $limit");
		if ($dev==1) {
			echo '<pre dir="ltr">';
			print_r($query->errorInfo());
			echo '</pre>';
			echo '<pre dir="ltr">';
			print_r($query->debugDumpParams());
			echo '</pre>';
		}
		return $query->fetchAll();
	}


	function RowCount($q=NULL)
	{
		global $prefix;
		global $dev;
		$query = $this->link->query("SELECT * FROM admins_tasks INNER JOIN tasks on admins_tasks.tskid=tasks.tskid INNER JOIN projects on projects.prjid=tasks.prjid $q");
		if ($dev==1) {
			echo '<pre dir="ltr">';
			print_r($query->errorInfo());
			echo '</pre>';
			echo '<pre dir="ltr">';
			print_r($query->debugDumpParams());
			echo '</pre>';
		}
		return $query->rowcount();
	}


	function GetInfo($tiid,$value)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("SELECT * FROM `tasks_issues` INNER JOIN issues on issues.iid=tasks_issues.iid WHERE tiid=?");
		$values = array($value);
		$query->execute($values);
		if ($dev==1) {
			echo '<pre dir="ltr">';
			print_r($query->errorInfo());
			echo '</pre>';
			echo '<pre dir="ltr">';
			print_r($query->debugDumpParams());
			echo '</pre>';
		}
		return $query->fetchAll()[0];
	}


	function GetInfoById($atid)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("SELECT * FROM `admins_tasks` WHERE atid=?");
		$values = array($atid);
		$query->execute($values);
		$result = $query->fetchAll();
	if ($dev==1) {
			echo '<pre dir="ltr">';
			print_r($query->errorInfo());
			echo '</pre>';
			echo '<pre dir="ltr">';
			print_r($query->debugDumpParams());
			echo '</pre>';
		}
		return $result[0];
	}
	
	function GetInfoByTskid($tskid)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("SELECT * FROM `admins_tasks` WHERE tskid=?");
		$values = array($tskid);
		$query->execute($values);
		$result = $query->fetchAll();
	if ($dev==1) {
			echo '<pre dir="ltr">';
			print_r($query->errorInfo());
			echo '</pre>';
			echo '<pre dir="ltr">';
			print_r($query->debugDumpParams());
			echo '</pre>';
		}
		return $result[0];
	}
		
	function GetAidByTskid($tskid)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("SELECT * FROM `admins_tasks` INNER JOIN admins on admins.aid=admins_tasks.aids  WHERE tskid=?");
		$values = array($tskid);
		$query->execute($values);
		// print_r($query);
	if ($dev==1) {
			echo '<pre dir="ltr">';
			print_r($query->errorInfo());
			echo '</pre>';
			echo '<pre dir="ltr">';
			print_r($query->debugDumpParams());
			echo '</pre>';
		}
		return $query->fetchAll();
	}
		
	function GetAidTskid($tskid,$aid)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("SELECT * FROM `admins_tasks` WHERE tskid=?&&aids=?");
		$values = array($tskid,$aid);
		$query->execute($values);
		$counts = $query->rowcount();
		if ($dev==1) {
			echo '<pre dir="ltr">';
			print_r($query->errorInfo());
			echo '</pre>';
			echo '<pre dir="ltr">';
			print_r($query->debugDumpParams());
			echo '</pre>';
		}
		return $counts;
	}
	
	function Delete($id)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("DELETE FROM `admins_tasks` WHERE atid=?");
		$values = array($id);
		$query->execute($values);
		if ($dev==1) {
			echo '<pre dir="ltr">';
			print_r($query->errorInfo());
			echo '</pre>';
			echo '<pre dir="ltr">';
			print_r($query->debugDumpParams());
			echo '</pre>';
		}
		return $query->rowcount();
	}

	
	function DeleteAidTskid($aid,$tskid)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("DELETE FROM `admins_tasks` WHERE aids=? && tskid=?");
		$values = array($aid,$tskid);
		$query->execute($values);
		if ($dev==1) {
			echo '<pre dir="ltr">';
			print_r($query->errorInfo());
			echo '</pre>';
			echo '<pre dir="ltr">';
			print_r($query->debugDumpParams());
			echo '</pre>';
		}
		return $query->rowcount();
	}


	function DelAdminsTasks($aid,$tskid)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("DELETE FROM admins_tasks WHERE aid=? AND tskid=?");
		$values = array($aid,$tskid);
		$query->execute($values);
		if ($dev==1) {
			echo '<pre dir="ltr">';
			print_r($query->errorInfo());
			echo '</pre>';
			echo '<pre dir="ltr">';
			print_r($query->debugDumpParams());
			echo '</pre>';
		}
		return $query->rowcount();
	}

	function DelPic($id)
	{
		global $prefix;
		global $pic_prefix;
		$issueInfo = $this->GetIssueInfoById($id);
		if(file_exists('file_issue/'.$pic_prefix.$issueInfo['iid'].$issueInfo['ifile1']))
		{
			if(unlink('file_issue/'.$pic_prefix.$issueInfo['iid'].$issueInfo['ifile1']))
				return 1;
			else
				return 0;
		}
		else{
			return 1;
		}
		if(file_exists('file_issue/'.$pic_prefix.$issueInfo['iid'].$issueInfo['ifile2']))
		{
			if(unlink('file_issue/'.$pic_prefix.$issueInfo['iid'].$issueInfo['ifile2']))
				return 1;
			else
				return 0;
		}
		else{
			return 1;
		}
		if(file_exists('file_issue/'.$pic_prefix.$issueInfo['iid'].$issueInfo['ifile3']))
		{
			if(unlink('file_issue/'.$pic_prefix.$issueInfo['iid'].$issueInfo['ifile3']))
				return 1;
			else
				return 0;
		}
		else{
			return 1;
		}
	}
	

}



?>