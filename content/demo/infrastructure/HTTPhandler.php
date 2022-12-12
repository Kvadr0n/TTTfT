<?php
require_once "/var/www/html/demo/admin/interfaces/classes/controller.php";
require_once "/var/www/html/demo/infrastructure/databaseAccessMySQL.php";
require_once "/var/www/html/demo/admin/interfaces/classes/DBUserAdapter.php";
require_once "/var/www/html/demo/admin/interfaces/classes/DBGameAdapter.php";
require_once "/var/www/html/demo/admin/interfaces/classes/skinStorageAdapter.php";
require_once "/var/www/html/demo/admin/interfaces/classes/avatarStorageAdapter.php";

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
			case "getAvatar":
			{
				$this->appController->getAvatar(!isset($_GET["name_user"]) ? "default" : $_GET["name_user"]);
				exit;
			}
			case "updateAvatar":
			{
				$this->appController->updateAvatar($_GET["name_user"]);
				exit;
			}
			case "showSkins":
			{
				$this->appController->showSkins($_GET["name_user"]);
				exit;
			}
			case "getSkin":
			{
				$this->appController->getSkin($_GET);
				exit;
			}
			case "updateSkin":
			{
				$this->appController->updateSkin($_GET);
				exit;
			}
			case "showStats":
			{
				$this->appController->showStats($_GET);
				exit;
			}
			case "visualiseStats":
			{
				$this->appController->visualiseStats($_GET);
				exit;
			}
			case "updateStats":
			{
				$this->appController->updateStats($_GET);
				exit;
			}
			case "hostGame":
			{
				$this->appController->hostGame($_GET);
				exit;
			}
			case "joinGame":
			{
				$this->appController->startGame($_GET);
				exit;
			}
			case "updateGame":
			{
				$this->appController->updateGame($_GET);
				exit;
			}
		}
	}
	
	public function handlePOST()
	{
		switch ($_GET["request"])
		{
			case "updateAvatar":
			{
				$this->appController->updateAvatar($_GET["name_user"]);
				exit;
			}
		}
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