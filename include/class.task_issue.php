<?php 
include_once 'class.database.php';
class ManageTasks_issues{
	public $link;
	function __construct()
	{
		$db_connection = new dbconnection();
		$this->link = $db_connection->connect();
		return $this->link;
	}
	function Add($tskid, $iid)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("INSERT INTO `tasks_issues`(tskid, iid) VALUES(?,?)");
		$values = array($tskid, $iid);
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


	function Update($tiid, $tskid, $iid)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("UPDATE `tasks_issues` SET tskid=?, iid=? WHERE tiid=?");
		$values = array($tskid, $iid, $tiid);
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

	function GetList($q=NULL, $order="ORDER BY tiid DESC",$limit=NULL)
	{
		global $prefix;
		global $dev;
		$query = $this->link->query("SELECT * FROM tasks_issues INNER JOIN tasks on tasks.tskid=tasks_issues.tskid INNER JOIN issues on issues.iid=tasks_issues.iid $q $order $limit");
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

	function GetList_Issue($q=NULL, $order="ORDER BY tiid DESC",$limit=NULL)
	{
		global $prefix;
		global $dev;
		$query = $this->link->query("SELECT * FROM tasks_issues INNER JOIN issues on issues.iid=tasks_issues.iid $q $order $limit");
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
		$query = $this->link->query("SELECT * FROM tasks_issues INNER JOIN issues on issues.iid=tasks_issues.iid $q");
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


	function GetInfoById($tiid)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("SELECT * FROM `tasks_issues` WHERE tiid=?");
		$values = array($tiid);
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
		$query = $this->link->prepare("SELECT * FROM `tasks_issues` WHERE tskid=?");
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

	function GetInfoByTskidIid($tskid,$iid)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("SELECT * FROM `tasks_issues` WHERE tskid=?&&iid=?");
		$values = array($tskid,$iid);
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

	function GetTaskIssue($tskid,$iid)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("SELECT * FROM `tasks_issues` WHERE tskid=?&&iid=?");
		$values = array($tskid,$iid);
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

	
	function Delete($id)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("DELETE FROM `tasks_issues` WHERE tiid=?");
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