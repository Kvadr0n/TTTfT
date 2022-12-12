<?php
require_once "/var/www/html/admin/entities/classes/game.php";
require_once "/var/www/html/admin/entities/interfaces/gameStorage.php";

class GameInteractor
{
	private $running;
	private $gameStorage;
	
	public function __construct($query)
	{
		$gameStorage = $query["gameStorage"];
	}
	
	public function hostGame($query)
	{
		die;
	}
	
	public function startGame($query)
	{
		die;
	}
	
	public function updateGame($query)
	{
		die;
	}
	
	public function endGame($query)
	{
		die;
	}
}
?>