<?php
require_once "/var/www/html/admin/entities/interfaces/skinStorage.php";
require_once "/var/www/html/admin/interfaces/classes/databaseAccess.php";

class SkinStorageAdapter implements SkinStorage
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