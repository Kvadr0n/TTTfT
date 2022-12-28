<?php
require_once "/var/www/html/real/admin/entities/interfaces/userStorage.php";
require_once "/var/www/html/real/admin/interfaces/classes/databaseAccess.php";

class DBUserAdapter implements UserStorage
{
	private $databaseAccess;
	
	public function __construct($query)
	{
		$this->databaseAccess = $query["databaseAccess"];
	}

	public function create($query)
	{
		if ($this->databaseAccess->connection->query("SELECT id_user FROM Users WHERE name_user = '{$query["name"]}'")->num_rows > 0)
			return(false);
		$this->databaseAccess->connection->query("INSERT INTO Users (name_user, pass_user) 
												  VALUES ('{$query["name"]}', '{$query["pass"]}')");
		return(true);
	}
	
	public function read($query)
	{
		return($this->databaseAccess->connection->query("SELECT id_user FROM Users WHERE name_user = '{$query["name"]}' AND pass_user = '{$query["pass"]}'"));
	}
	
	public function update($query)
	{
		$this->databaseAccess->connection->query("UPDATE Users SET id_skin={$query["id_skin"]}, wins_user={$query["wins_user"]}, loses_user={$query["loses_user"]} WHERE id_user={$query["id_user"]}");
	}
	
	public function delete($query)
	{
		return($this->databaseAccess->connection->query("SELECT * FROM Users WHERE name_user = '{$query}'"));;
	}
}
?>