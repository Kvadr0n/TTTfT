<?php
require_once "/var/www/html/admin/use cases/classes/userInteractor.php";
require_once "/var/www/html/admin/use cases/classes/gameInteractor.php";

class Controller
{
	private $userInteractor;
	private $gameInteractor;
	
	public function __construct($query)
	{
		$this->userInteractor = $query["userInteractor"];
		$this->gameInteractor = $query["gameInteractor"];
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
	
	public function registerUser($query)
	{
		if ($this->userInteractor->registerUser($query))
		{
			setcookie("logged", $query["name"], time() + 600, '/');
			header("location: /home");
			exit;
		}
		header("location: /authorizationExists");
		exit;
	}
	
	public function loginUser($query)
	{
		die;
	}
	
	public function getAvatar($query)
	{
		die;
	}
	
	public function updateAvatar($query)
	{
		die;
	}
	
	public function showSkins($query)
	{
		die;
	}
	
	public function getSkin($query)
	{
		die;
	}
	
	public function updateSkin($query)
	{
		die;
	}
	
	public function showStats($query)
	{
		die;
	}
	
	public function visualiseStats($query)
	{
		die;
	}
	
	public function updateStats($query)
	{
		die;
	}
}
?>