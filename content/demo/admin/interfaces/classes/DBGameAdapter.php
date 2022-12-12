<?php
require_once "/var/www/html/demo/admin/entities/interfaces/gameStorage.php";
require_once "/var/www/html/demo/admin/interfaces/classes/databaseAccess.php";

class DBGameAdapter implements GameStorage
{
	private $databaseAccess;
	
	public function __construct($query)
	{
		$this->databaseAccess = $query["databaseAccess"];
	}
	
	public function create($query)
	{
		if (($query["turnTime_game"] > 0) && ($query["turnTime_game"] <= 60) &&
			($query["width_game"] > 0)    && ($query["width_game"] <= 10)    &&
			($query["height_game"] > 0)   && ($query["height_game"] <= 10)   &&
			($query["length_game"] > 0)   && ($query["length_game"] <= 10))
		{
			echo "
			INSERT INTO Games (name_game, pass_game, turnTime_game, width_game, height_game, length_game, namePlayerOne_user)
			VALUES ('{$query["name_game"]}', '{$query["pass_game"]}', {$query["turnTime_game"]}, {$query["width_game"]}, {$query["height_game"]}, {$query["length_game"]}, '{$query["namePlayerOne_user"]}')
			";
			$this->databaseAccess->connection->query
			("
			INSERT INTO Games (name_game, pass_game, turnTime_game, width_game, height_game, length_game, namePlayerOne_user)
			VALUES ('{$query["name_game"]}', '{$query["pass_game"]}', {$query["turnTime_game"]}, {$query["width_game"]}, {$query["height_game"]}, {$query["length_game"]}, '{$query["namePlayerOne_user"]}')
			");
			echo "{$this->databaseAccess->connection->error}";
			return(true);
		}
		return(false);
	}

	public function read($query)
	{
		return($this->databaseAccess->connection->query("SELECT * FROM Games WHERE name_game='{$query["name_game"]}' AND pass_game='{$query["pass_game"]}'"));
	}
	
	public function update($query)
	{
		$this->databaseAccess->connection->query("UPDATE Games SET namePlayerTwo_user='{$query["namePlayerTwo_user"]}', state_game='{$query["state_game"]}', isPlayerOneTurn_game={$query["isPlayerOneTurn_game"]}, nameWinner_user='{$query["nameWinner_user"]}' WHERE name_game='{$query["name_game"]}'");
	}
	
	public function delete($query)
	{
		$this->databaseAccess->connection->query("DELETE FROM Games WHERE namePlayerOne_user='{$query["namePlayerOne_user"]}'");
	}
}
?>