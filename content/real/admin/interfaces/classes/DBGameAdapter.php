<?php
require_once "/var/www/html/admin/entities/interfaces/gameStorage.php";
require_once "/var/www/html/admin/interfaces/classes/databaseAccess.php";

class DBGameAdapter implements GameStorage
{
	private $databaseAccess;
	
	public function __construct($query)
	{
		$databaseAccess = $query["databaseAccess"];
	}
	
	public function create($query)
	{
		die;
	}
	
	public function read($query)
	{
		die;
	}
	
	public function update($query)
	{
		die;
	}
	
	public function delete($query)
	{
		die;
	}
}
?>