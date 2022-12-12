<?php
class Game
{
	public $id;
	public $name;
	public $pass;
	public $turnTime;
	public $width;
	public $height;
	public $length;
	public $isPlayerOneTurn;
	public $state;
	public $endTime;
	
	public function __construct($query)
	{
		$id = $query["id_game"];
		$name = $query["name_game"];
		$pass = $query["pass_game"];
		$turnTime = $query["turnTime_game"];
		$width = $query["width_game"];
		$height = $query["height_game"];
		$length = $query["length_game"];
		$isPlayerOneTurn = $query["isPlayerOneTurn_game"];
		$state = $query["state_game"];
		$endTime = $query["endTime_game"];
	}
}
?>