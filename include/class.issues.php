<?php 
include_once 'class.database.php';
class ManageIssues{
	public $link;
	function __construct()
	{
		$db_connection = new dbconnection();
		$this->link = $db_connection->connect();
		return $this->link;
	}
	function Add($tyid, $prjid, $iversion, $icode, $ititle, $idesc, $iproirity, $icomplexity, $ineeded_time, $ifile1, $ifile2, $ifile3, $iarchive, $iwho_fullname, $iwho_email, $iwho_tel, $idone, $idone_date, $idone_version, $aid)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("INSERT INTO `issues`(tyid, prjid, iversion, icode, ititle, idesc, iproirity, icomplexity, ineeded_time, ifile1, ifile2, ifile3, iarchive, iwho_fullname, iwho_email, iwho_tel, idone, idone_date, idone_version, aid) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
		$values = array($tyid, $prjid, $iversion, $icode, $ititle, $idesc, $iproirity, $icomplexity, $ineeded_time, $ifile1, $ifile2, $ifile3, $iarchive, $iwho_fullname, $iwho_email, $iwho_tel, $idone, $idone_date, $idone_version, $aid);
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


	function AddMini($tyid, $prjid, $ititle, $archive, $iproirity, $icomplexity, $aid)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("INSERT INTO `issues`(tyid, prjid, ititle, iarchive, iproirity, icomplexity, aid) VALUES(?,?,?,?,?,?,?)");
		$values = array($tyid, $prjid, $ititle, $archive, $iproirity, $icomplexity, $aid);
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


	function Update($iid, $tyid, $prjid, $iversion, $icode, $ititle, $idesc, $iproirity, $icomplexity, $ineeded_time, $ifile1, $ifile2, $ifile3, $iarchive, $iwho_fullname, $iwho_email, $iwho_tel, $idone, $idone_date, $idone_version)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("UPDATE `issues` SET tyid=?, prjid=?, iversion=?, icode=?, ititle=?, idesc=?, iproirity=?, icomplexity=?, ineeded_time=?, ifile1=?, ifile2=?, ifile3=?, iarchive=?, iwho_fullname=?, iwho_email=?, iwho_tel=?, idone=?, idone_date=?, idone_version=? WHERE iid=?");
		$values = array($tyid, $prjid, $iversion, $icode, $ititle, $idesc, $iproirity, $icomplexity, $ineeded_time, $ifile1, $ifile2, $ifile3, $iarchive, $iwho_fullname, $iwho_email, $iwho_tel, $idone, $idone_date, $idone_version, $iid);
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

	function UpdateFast($iid, $tyid, $prjid, $iversion, $ititle, $idesc, $iproirity, $icomplexity, $ineeded_time, $ifile1, $ifile2, $ifile3, $iarchive, $iwho_fullname, $iwho_email, $iwho_tel, $idone, $idone_date, $idone_version)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("UPDATE `issues` SET tyid=?, prjid=?, iversion=?, ititle=?, idesc=?, iproirity=?, icomplexity=?, ineeded_time=?, ifile1=?, ifile2=?, ifile3=?, iarchive=?, iwho_fullname=?, iwho_email=?, iwho_tel=?, idone=?, idone_date=?, idone_version=? WHERE iid=?");
		$values = array($tyid, $prjid, $iversion, $ititle, $idesc, $iproirity, $icomplexity, $ineeded_time, $ifile1, $ifile2, $ifile3, $iarchive, $iwho_fullname, $iwho_email, $iwho_tel, $idone, $idone_date, $idone_version, $iid);
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


	function UpdateDone($iid, $idone_date , $idone)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("UPDATE `issues` SET idone=?, idone_date=? WHERE iid=?");
		$values = array($idone, $idone_date, $iid);
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

	function GetList($q=NULL, $order="ORDER BY iid DESC",$limit=NULL)
	{
		global $prefix;
		global $dev;
		$query = $this->link->query("SELECT * FROM issues $q $order $limit");
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
		$query = $this->link->query("SELECT * FROM issues $q");
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
		$query = $this->link->prepare("SELECT * FROM `issues` WHERE iid=?");
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
		$query = $this->link->prepare("DELETE FROM `issues` WHERE iid=?");
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
		if(file_exists('file_issue/file1/'.$pic_prefix.$issueInfo['iid'].$issueInfo['ifile1']))
		{
			if(unlink('file_issue/file1/'.$pic_prefix.$issueInfo['iid'].$issueInfo['ifile1']))
				return 1;
			else
				return 0;
		}
		else{
			return 1;
		}
		if(file_exists('file_issue/file2/'.$pic_prefix.$issueInfo['iid'].$issueInfo['ifile2']))
		{
			if(unlink('file_issue/file2/'.$pic_prefix.$issueInfo['iid'].$issueInfo['ifile2']))
				return 1;
			else
				return 0;
		}
		else{
			return 1;
		}
		if(file_exists('file_issue/file3/'.$pic_prefix.$issueInfo['iid'].$issueInfo['ifile3']))
		{
			if(unlink('file_issue/file3/'.$pic_prefix.$issueInfo['iid'].$issueInfo['ifile3']))
				return 1;
			else
				return 0;
		}
		else{
			return 1;
		}
	}
	function LastID()
	{
		global $prefix;
		$query = $this->link->query("SELECT `iid` FROM `issues` ORDER BY `iid` DESC LIMIT 0,1");
		$result = $query->fetchAll();
		if (empty($result)) {
			return 0;
		}
		else{
			return $result[0]['iid'];	
		}
	}

}



?>