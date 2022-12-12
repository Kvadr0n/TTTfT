<?php
require_once "/var/www/html/admin/entities/classes/user.php";
require_once "/var/www/html/admin/entities/interfaces/userStorage.php";
require_once "/var/www/html/admin/entities/classes/skin.php";
require_once "/var/www/html/admin/entities/interfaces/skinStorage.php";
require_once "/var/www/html/admin/entities/interfaces/avatarStorage.php";

class UserInteractor
{
	private $userStorage;
	private $skinStorage;
	private $avatarStorage;
	
	public function __construct($query)
	{
		$this->userStorage = $query["userStorage"];
		$this->skinStorage = $query["skinStorage"];
		$this->avatarStorage = $query["avatarStorage"];
	}
	
	public function registerUser($query)
	{
		return($this->userStorage->create($query));
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