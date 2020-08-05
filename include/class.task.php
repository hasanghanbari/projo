<?php 
include_once 'class.database.php';
class ManageTasks{
	public $link;
	function __construct()
	{
		$db_connection = new dbconnection();
		$this->link = $db_connection->connect();
		return $this->link;
	}
	function Add($prjid, $tskcode, $tsktitle, $tskdesc, $tskdone, $tskdone_date, $aid)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("INSERT INTO `tasks`(prjid, tskcode, tsktitle, tskdesc, tskdone, tskdone_date, aid) VALUES(?,?,?,?,?,?,?)");
		$values = array($prjid, $tskcode, $tsktitle, $tskdesc, $tskdone, $tskdone_date, $aid);
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

	function AddFast($prjid, $tsktitle, $aid)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("INSERT INTO `tasks`(prjid, tsktitle, aid) VALUES(?,?,?)");
		$values = array($prjid, $tsktitle, $aid);
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


	function Update($prjid, $tskid, $tskcode, $tsktitle, $tskdesc, $tskdone, $tskdone_date)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("UPDATE `tasks` SET `prjid`=?, `tskcode`=?, `tsktitle`=?, `tskdesc`=?, `tskdone`=?, `tskdone_date`=? WHERE `tskid`=?");
		$values = array($prjid, $tskcode, $tsktitle, $tskdesc, $tskdone, $tskdone_date, $tskid);
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

	function GetList($q=NULL, $order="ORDER BY tskid DESC",$limit=NULL)
	{
		global $prefix;
		global $dev;
		$query = $this->link->query("SELECT * FROM tasks $q $order $limit");
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

	function GetListAdmin($aid)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("SELECT * FROM tasks INNER JOIN admins on admins.aid=tasks.aid");
		$values = array($aid);
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


	function RowCount($q=NULL)
	{
		global $prefix;
		global $dev;
		$query = $this->link->query("SELECT * FROM tasks $q");
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


	function GetTaskInfoById($tskid)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("SELECT * FROM `tasks` WHERE tskid=?");
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
	
	function Delete($id)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("DELETE FROM `tasks` WHERE tskid=?");
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
		$projectInfo = $this->GetProjectInfoById($id);
		if(file_exists('../img/project/'.$pic_prefix.$projectInfo['prjid'].$projectInfo['prjlogo']))
		{
			if(unlink('../img/project/'.$pic_prefix.$projectInfo['prjid'].$projectInfo['prjlogo']))
				return 1;
			else
				return 0;
		}
		else
			return 1;
	}

	function LastID()
	{
		global $prefix;
		$query = $this->link->query("SELECT `tskid` FROM `tasks` ORDER BY `tskid` DESC LIMIT 0,1");
		$result = $query->fetchAll();
		return $result[0]['tskid'];	
	}
	

}



?>