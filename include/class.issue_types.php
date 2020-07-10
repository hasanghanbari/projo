<?php 
include_once 'class.database.php';
class ManageIssue_types{
	public $link;
	function __construct()
	{
		$db_connection = new dbconnection();
		$this->link = $db_connection->connect();
		return $this->link;
	}
	function Add($tycode, $tytitle, $tycomments)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("INSERT INTO `issue_types`(tycode, tytitle, tycomments) VALUES(?,?,?)");
		$values = array($tycode, $tytitle, $tycomments);
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


	function Update($tyid, $tycode, $tytitle, $tycomments)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("UPDATE `issue_types` SET tycode=?, tytitle=?, tycomments=? WHERE tyid=?");
		$values = array($tycode, $tytitle, $tycomments, $tyid);
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

	function GetList($q=NULL, $order="ORDER BY tyid DESC",$limit=NULL)
	{
		global $prefix;
		global $dev;
		$query = $this->link->query("SELECT * FROM issue_types $q $order $limit");
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
		$query = $this->link->query("SELECT * FROM issue_types $q");
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


	function GetInfo($iid,$value)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("SELECT * FROM `issue_types` WHERE tyid=?");
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


	function GetIssueInfoById($aid)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("SELECT * FROM `issues` WHERE iid=?");
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
		$query = $this->link->prepare("DELETE FROM `issue_types` WHERE tyid=?");
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