<?php 
class dbConnection
{
	private $db_conn;
	function connect()
	{
	global $dbhost,$dbuname,$dbname,$dbpass;
		try
		{
			$this->db_conn = new PDO("mysql:host=$dbhost;dbname=$dbname;",$dbuname,$dbpass,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			return $this->db_conn;
		}
		catch(PDOException $e)
		{
			return 0;
		}
	}	
}
?>