<?php
require_once "/var/www/html/admin/entities/interfaces/userStorage.php";
require_once "/var/www/html/admin/interfaces/classes/databaseAccess.php";

class DBUserAdapter implements UserStorage
{
	private $databaseAccess;
	
	public function __construct($query)
	{
		$this->databaseAccess = $query["databaseAccess"];
	}

	public function create($query)
	{
		$res = $this->databaseAccess->connection->query("SELECT id_user FROM Users WHERE name_user = '{$query["name"]}'");
		if ($res->num_rows > 0)
			return(false);
		$this->databaseAccess->connection->query("INSERT INTO Users (name_user, pass_user) 
												  VALUES ('{$query["name"]}', '{$query["pass"]}')");
		return(true);
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