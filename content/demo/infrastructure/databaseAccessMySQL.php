<?php
require_once "/var/www/html/demo/admin/interfaces/classes/databaseAccess.php";

class DatabaseAccessMySQL extends DatabaseAccess
{
	public $connection;
	
	public function __construct($query)
	{
		$this->connect(0);
	}
	
	public function connect($query)
	{
		$this->connection = new mysqli("mysql", "root", "Franklin5", "appDB");
	}
}
?>