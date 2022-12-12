<?php
require_once "/var/www/html/demo/admin/entities/interfaces/skinStorage.php";
require_once "/var/www/html/demo/admin/interfaces/classes/databaseAccess.php";

class SkinStorageAdapter implements SkinStorage
{
	private $databaseAccess;

	public function __construct($query)
	{
		$this->databaseAccess = $query["databaseAccess"];
	}
	
	public function create($query)
	{
		die;
	}
	
	public function read($query)
	{
		return($this->databaseAccess->connection->query("SELECT * FROM Skins"));
	}
	
	public function update($query)
	{
		die;
	}
	
	public function delete($query)
	{
		return($this->databaseAccess->connection->query("SELECT * FROM Skins WHERE id_skin=$query"));
	}
}
?>