<?php
include_once('class.database.php');
class ManageSettings
{
	public $link;
	
	function __construct()
	{
		$db_connection = new dbConnection();
		$this->link = $db_connection->connect();
		
		return $this->link;		
	}
	
	function UpdateSettings($system_title,$language,$direction,$theme)
	{
		global $prefix;
		$query = $this->link->prepare("UPDATE `settings` SET `system_title`=?, `language`=?, `direction`=?, `theme`=? WHERE `id`=1");
		$values = array($system_title,$language,$direction,$theme);

		$query->execute($values);
		$counts = $query->rowCount();
		
		return $counts;
	}
	
	function SystemSettings()
	{
		global $prefix;
		$query = $this->link->query("SELECT * FROM `settings` ORDER BY `id` DESC LIMIT 0,1");
		$counts = $query->rowCount();
		if($counts>=1)
		{
			$result = $query->fetchAll();
			
			return $result;			
		}
		else
		{
			return $counts;
		}
	}

	function GetInfo($id,$value)
	{
		global $prefix;
		global $dev;
		$query = $this->link->prepare("SELECT * FROM `settings` WHERE id=?");
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
	
	
}

?>
