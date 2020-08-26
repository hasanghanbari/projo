<?php 
include_once 'class.database.php';
class ManageProjects{
	public $link;
	function __construct()
	{
		$db_connection = new dbconnection();
		$this->link = $db_connection->connect();
		return $this->link;
	}
	function Add($prjcode, $prjtitle, $prjdesc, $prjlogo, $prjcomments, $aid)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("INSERT INTO `projects`(prjcode, prjtitle, prjdesc, prjlogo, prjcomments, aid) VALUES(?,?,?,?,?,?)");
		$values = array($prjcode, $prjtitle, $prjdesc, $prjlogo, $prjcomments, $aid);
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


	function AddMini($prjtitle, $prjdesc, $prjlogo, $bg_color, $aid)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("INSERT INTO `projects`(prjtitle, prjdesc, prjlogo, bg_color, aid) VALUES(?,?,?,?,?)");
		$values = array($prjtitle, $prjdesc, $prjlogo, $bg_color, $aid);
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


	function Update($prjid, $prjcode, $prjtitle, $prjdesc, $prjlogo, $prjcomments, $aid)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("UPDATE `projects` SET `prjcode`=?, `prjtitle`=?, `prjdesc`=?, `prjlogo`=?, `prjcomments`=?, `aid`=? WHERE `prjid`=?");
		$values = array($prjcode, $prjtitle, $prjdesc, $prjlogo, $prjcomments, $aid, $prjid);
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
	function UpdateMini($prjid, $prjtitle, $prjdesc, $prjlogo, $bg_color, $aid)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("UPDATE `projects` SET `prjtitle`=?, `prjdesc`=?, `prjlogo`=?, `bg_color`=?, `aid`=? WHERE `prjid`=?");
		$values = array($prjtitle, $prjdesc, $prjlogo, $bg_color, $aid, $prjid);
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

	function GetList($q=NULL, $order="ORDER BY prjid DESC",$limit=NULL)
	{
		global $prefix;
		global $dev;
		$query = $this->link->query("SELECT * FROM projects $q $order $limit");
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
		$query = $this->link->query("SELECT * FROM projects $q");
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


	function GetProjectInfoById($aid)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("SELECT * FROM `projects` WHERE prjid=?");
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
	
	function Delete($id)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("DELETE FROM `projects` WHERE prjid=?");
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
		$query = $this->link->query("SELECT `prjid` FROM `projects` ORDER BY `prjid` DESC LIMIT 0,1");
		$result = $query->fetchAll();
		return $result[0]['prjid'];	
	}
	

}



?>