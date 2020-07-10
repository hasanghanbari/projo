<?php 
include_once 'class.database.php';
class ManageComments{
	public $link;
	function __construct()
	{
		$db_connection = new dbconnection();
		$this->link = $db_connection->connect();
		return $this->link;
	}
	function Add($ctext,$cdate)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("INSERT INTO `comments`(ctext, cdate) VALUES(?,?)");
		$values = array($ctext,$cdate);
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

	function Update($cid, $ctext)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("UPDATE `comments` SET ctext=? WHERE `cid`=?");
		$values = array($ctext, $cid);
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

	function GetList($q=NULL, $order="ORDER BY `cid` DESC",$limit=NULL)
	{
		global $prefix;
		global $dev;
		$query = $this->link->query("SELECT * FROM comments $q $order $limit");
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
		$query = $this->link->query("SELECT * FROM comments $q");
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

	function GetInfo($lid,$value)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("SELECT * FROM `comments` WHERE cid=?");
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
	function Delete($id)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("DELETE FROM `comments` WHERE cid=?");
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
}



?>