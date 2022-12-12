<?php
require_once "/var/www/html/admin/interfaces/classes/controller.php";
require_once "/var/www/html/infrastructure/databaseAccessMySQL.php";
require_once "/var/www/html/admin/interfaces/classes/DBUserAdapter.php";
require_once "/var/www/html/admin/interfaces/classes/DBGameAdapter.php";
require_once "/var/www/html/admin/interfaces/classes/skinStorageAdapter.php";
require_once "/var/www/html/admin/interfaces/classes/avatarStorageAdapter.php";

class HTTPHandler
{
	private $appController;
	
	public function __construct($query)
	{
		$this->appController = $query["appController"];
	}
	
	public function handleGET()
	{
		switch ($_GET["request"])
		{
			case "auth":
			{
				if ($_GET["type"] == "reg")
					$this->appController->registerUser(["name" => $_GET["name"], "pass" => $_GET["pass"]]);
				else
					$this->appController->loginUser(["name" => $_GET["name"], "pass" => $_GET["pass"]]);
				exit;
			}
		}
	}
	
	public function handlePOST()
	{
		die;
	}
}

$databaseAccess = new DatabaseAccessMySQL(0);

$handler = new HTTPHandler
([
	"appController" => new Controller
	([
		"userInteractor" => new UserInteractor
		([
			"userStorage"   => new DBUserAdapter
			([
				"databaseAccess" => $databaseAccess
			]),
			"skinStorage"   => new SkinStorageAdapter
			([
				"databaseAccess" => $databaseAccess
			]),
			"avatarStorage" => new AvatarStorageAdapter()
		]), 
		"gameInteractor" => new GameInteractor
		([
			"gameStorage"   => new DBGameAdapter
			([
				"databaseAccess" => $databaseAccess
			])
		])
	])
]);

if ($_SERVER['REQUEST_METHOD'] == "GET")
	$handler->handleGET();
	else
	$handler->handlePOST();
?>