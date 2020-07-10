<?php 
include_once 'class.database.php';
class ManageAdmins{
	public $link;
	public $admin;
	function __construct()
	{
		$db_connection = new dbconnection();
		$this->link = $db_connection->connect();
		return $this->link;
	}
	function Add($ausername, $apass, $aactive, $asuper_admin, $afname, $alname, $agender, $atel, $aemail, $apic, $acomments, $allow_add_project, $allow_edit_project, $allow_list_project, $allow_add_issues, $allow_edit_issues, $allow_list_issues, $allow_add_task, $allow_list_task, $allow_edit_task, $allow_delete_project, $allow_delete_task, $allow_delete_issues)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("INSERT INTO `admins`(ausername, apass, aactive, asuper_admin, afname, alname, agender, atel, aemail, apic, acomments, allow_add_project, allow_edit_project, allow_list_project, allow_add_issues, allow_edit_issues, allow_list_issues, allow_add_task, allow_list_task, allow_edit_task, allow_delete_project, allow_delete_task, allow_delete_issues) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
		$values = array($ausername, $apass, $aactive, $asuper_admin, $afname, $alname, $agender, $atel, $aemail, $apic, $acomments, $allow_add_project, $allow_edit_project, $allow_list_project, $allow_add_issues, $allow_edit_issues, $allow_list_issues, $allow_add_task, $allow_list_task, $allow_edit_task, $allow_delete_project, $allow_delete_task, $allow_delete_issues);
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

	function Update($aid, $ausername, $aactive, $asuper_admin, $afname, $alname, $agender, $atel, $aemail, $apic, $acomments, $allow_add_project, $allow_edit_project, $allow_list_project, $allow_add_issues, $allow_edit_issues, $allow_list_issues, $allow_add_task, $allow_list_task, $allow_edit_task, $allow_delete_project, $allow_delete_task, $allow_delete_issues)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("UPDATE admins SET ausername=?, aactive=?, asuper_admin=?, afname=?, alname=?, agender=?, atel=?, aemail=?, apic=?, acomments=?, allow_add_project=?, allow_edit_project=?, allow_list_project=?, allow_add_issues=?, allow_edit_issues=?, allow_list_issues=?, allow_add_task=?, allow_list_task=?, allow_edit_task=?, allow_delete_project=?, allow_delete_task=?, allow_delete_issues=? WHERE aid=?");
		$values = array($ausername, $aactive, $asuper_admin, $afname, $alname, $agender, $atel, $aemail, $apic, $acomments, $allow_add_project, $allow_edit_project, $allow_list_project, $allow_add_issues, $allow_edit_issues, $allow_list_issues, $allow_add_task, $allow_list_task, $allow_edit_task, $allow_delete_project, $allow_delete_task, $allow_delete_issues, $aid);
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


	function UpdateProfile($aid, $afname, $alname, $agender, $atel, $aemail, $apic, $acomments)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("UPDATE `admins` SET `afname`=?, `alname`=?, `agender`=?, `atel`=?, `aemail`=?, `apic`=?, `acomments`=? WHERE `aid`=?");
		$values = array($afname, $alname, $agender, $atel, $aemail, $apic, $acomments, $aid);
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

	function AdminPermission($username,$module)
	{
		global $prefix;
		$query = $this->link->prepare("SELECT * FROM `admins` WHERE `ausername`=? AND $module=1");
		$values = array($username);
		$query->execute($values);
		$counts = $query->rowCount();
		if($counts==1)
			return 1;
		else		
			return $counts;		
	}

	function Login($username,$pass)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("SELECT * FROM `admins` WHERE `ausername`=? AND `apass`=?");
		$values = array($username,$pass);
		$query->execute($values);
		$counts= $query->rowCount();
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
	function GetList($q=NULL, $order="ORDER BY aid DESC",$limit=NULL)
	{
		global $prefix;
		global $dev;
		$query = $this->link->query("SELECT * FROM admins $q $order $limit");
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
		$query = $this->link->query("SELECT * FROM admins $q");
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

	function GetAdminInfoById($aid)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("SELECT * FROM `admins` WHERE aid=?");
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
		
	function GetAdminInfo($username)
	{
		global $prefix;
		$query = $this->link->prepare("SELECT * FROM `admins` WHERE `ausername`=?");
		$values = array($username);
		$query->execute($values);
		$counts = $query->rowCount();
		if($counts==1)
		{
			$result = $query->fetchAll();
			
			return $result;			
		}
		else
		{
			return $counts;
		}
	}
	
	function ResetPassword($aid,$apass)
	{
		global $prefix;
		$apass = md5($apass);
		$query = $this->link->prepare("UPDATE `admins` SET `apass`=? WHERE `aid`=?");
		$values = array($apass,$aid);

		$query->execute($values);
		$counts = $query->rowCount();
		
		return $counts;
	}

	function Delete($aid)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("DELETE FROM `admins` WHERE aid=?");
		$values = array($aid);
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
		$adminInfo = $this->GetAdminInfoById($id);
		if(file_exists('img/admins/'.$pic_prefix.$adminInfo['aid'].$adminInfo['apic']))
		{
			if(unlink('img/admins/'.$pic_prefix.$adminInfo['aid'].$adminInfo['apic']))
				return 1;
			else
				return 0;
		}
		else
			return 1;
	}
	
	function LastAdminID()
	{
		global $prefix;
		$query = $this->link->query("SELECT `aid` FROM `admins` ORDER BY `aid` DESC LIMIT 0,1");
		$result = $query->fetchAll();
		return $result[0]['aid'];	
	}
}
?>