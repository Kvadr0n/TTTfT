<?php
require_once "/var/www/html/demo/admin/entities/classes/user.php";
require_once "/var/www/html/demo/admin/entities/interfaces/userStorage.php";
require_once "/var/www/html/demo/admin/entities/classes/skin.php";
require_once "/var/www/html/demo/admin/entities/interfaces/skinStorage.php";
require_once "/var/www/html/demo/admin/entities/interfaces/avatarStorage.php";

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
		return($this->userStorage->read($query));
	}
	
	public function getAvatar($query)
	{
		$this->avatarStorage->read($query);
	}
	
	public function updateAvatar($query)
	{
		return($this->avatarStorage->create($query));
	}
	
	public function showSkins($query)
	{
		return(["skins" => $this->skinStorage->read(0), "user" => $this->userStorage->delete($query)]);
	}
	
	public function getSkin($query)
	{
		switch ($query["size"])
		{
			case "name":
			{
				$userdata = $this->userStorage->delete($query["name_user"]);
				$user = [];
				foreach ($userdata as $key => $value)
					$user[$key] = $value;
				$user = $user[0];
				$skindata = $this->skinStorage->delete($user["id_skin"]);
				$skin = [];
				foreach ($skindata as $key => $value)
					$skin[$key] = $value;
				$skin = $skin[0];
				return($skin["name_skin"]);
				break;
			}
			case "full":
			{
				header('Content-type: image/png');
				$image = imagecreatefrompng("/var/www/filesystem/skins/{$query["name"]}.png");
				switch ($query["lock"])
				{
					case "no":
					{
						imagepng($image);
						imagedestroy($image);
						break;
					}
					case "yes":
					{
						$lock = imagecreatefrompng("/var/www/filesystem/skins/lock.png");
						imagecopy($image, $lock, 35, 0, 0, 0, 38, 54);
						imagepng($image);
						imagedestroy($image);
						imagedestroy($lock);
						break;
					}
					case "tick":
					{
						$tick = imagecreatefrompng("/var/www/filesystem/skins/tick.png");
						imagecopy($image, $tick, 35, 0, 0, 0, 38, 54);
						imagepng($image);
						imagedestroy($image);
						imagedestroy($tick);
						break;
					}
				}
				break;
			}
			case "X":
			{
				header('Content-type: image/png');
				$image = imagecreatefrompng("/var/www/filesystem/skins/{$query["name"]}.png");
				$rectangle = array();
				$rectangle["x"] = 0;
				$rectangle["y"] = 0;
				$rectangle["width"] = 54;
				$rectangle["height"] = 54;
				$image1 = imagecrop($image, $rectangle);
				imagepng($image1);
				imagedestroy($image);
				imagedestroy($image1);
				break;
			}
			case "O":
			{
				header('Content-type: image/png');
				$image = imagecreatefrompng("/var/www/filesystem/skins/{$query["name"]}.png");
				$rectangle = array();
				$rectangle["x"] = 54;
				$rectangle["y"] = 0;
				$rectangle["width"] = 54;
				$rectangle["height"] = 54;
				$image1 = imagecrop($image, $rectangle);
				imagepng($image1);
				imagedestroy($image);
				imagedestroy($image1);
				break;
			}
		}
	}
	
	public function updateSkin($query)
	{
		$res = $this->userStorage->delete($query["name_user"]);
		$user = [];
		foreach ($res as $key => $value)
			$user[$key] = $value;
		$user[0]["id_skin"] = $query["id_skin"];
		$this->userStorage->update($user[0]);
	}
	
	public function showStats($query)
	{
		$res = $this->userStorage->delete($query["name_user"]);
		$user = [];
		foreach ($res as $key => $value)
			$user[$key] = $value;
		$user = $user[0];
		return($user);
	}
	
	public function visualiseStats($query)
	{
		$res = $this->userStorage->delete($query["name_user"]);
		$user = [];
		foreach ($res as $key => $value)
			$user[$key] = $value;
		$user = $user[0];
		return($user);
	}
	
	public function updateStats($query)
	{
		$res = $this->userStorage->delete($query["name_user"]);
		$user = [];
		foreach ($res as $key => $value)
			$user[$key] = $value;
		$user = $user[0];
		if ($_GET["res"] == "win")
			++$user["wins_user"];
		else
			++$user["loses_user"];
		$this->userStorage->update($user);
	}
}
?>