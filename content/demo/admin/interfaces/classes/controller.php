<?php
require_once "/var/www/html/demo/admin/use cases/classes/userInteractor.php";
require_once "/var/www/html/demo/admin/use cases/classes/gameInteractor.php";
require_once('/var/www/filesystem/jpgraph/src/jpgraph.php');
require_once('/var/www/filesystem/jpgraph/src/jpgraph_pie.php');

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
		$res = $this->gameInteractor->hostGame($query);
		if ($res)
			header("location: /demo/gameHost/?name_user={$query["namePlayerOne_user"]}&name_game={$query["name_game"]}&pass_game={$query["pass_game"]}");
		else
			header("location: /demo/homeHostFail?name_user={$query["namePlayerOne_user"]}");
	}
	
	public function startGame($query)
	{
		$res = $this->gameInteractor->startGame($query);
		if ($res)
			header("location: /demo/gameClient/?name_user={$query["namePlayerTwo_user"]}&name_game={$query["name_game"]}&pass_game={$query["pass_game"]}");
		else
			header("location: /demo/homeJoinFail?name_user={$query["namePlayerTwo_user"]}");
	}
	
	public function updateGame($query)
	{
		switch ($query["status"])
		{
			case "player1":
			{
				$query["size"] = "name";
				$query["name_user"] = $query["namePlayerOne_user"];
				$skin1 = $this->userInteractor->getSkin($query);
				$query["name_skin1"] = $skin1;
				$query["name_user"] = $query["namePlayerTwo_user"];
				$skin2 = $this->userInteractor->getSkin($query);
				$query["name_skin2"] = $skin2;
				$this->gameInteractor->updateGame($query);
				break;
			}
			case "player2":
			{
				$query["size"] = "name";
				$query["name_user"] = $query["namePlayerOne_user"];
				$skin1 = $this->userInteractor->getSkin($query);
				$query["name_skin1"] = $skin1;
				$query["name_user"] = $query["namePlayerTwo_user"];
				$skin2 = $this->userInteractor->getSkin($query);
				$query["name_skin2"] = $skin2;
				$this->gameInteractor->updateGame($query);
				break;
			}
			case "turn1":
			{
				$query["size"] = "name";
				$query["name_user"] = $query["namePlayerOne_user"];
				$skin1 = $this->userInteractor->getSkin($query);
				$query["name_skin1"] = $skin1;
				$query["name_user"] = $query["namePlayerTwo_user"];
				$skin2 = $this->userInteractor->getSkin($query);
				$query["name_skin2"] = $skin2;
				$this->gameInteractor->updateGame($query);
				break;
			}
			case "turn2":
			{
				$query["size"] = "name";
				$query["name_user"] = $query["namePlayerOne_user"];
				$skin1 = $this->userInteractor->getSkin($query);
				$query["name_skin1"] = $skin1;
				$query["name_user"] = $query["namePlayerTwo_user"];
				$skin2 = $this->userInteractor->getSkin($query);
				$query["name_skin2"] = $skin2;
				$this->gameInteractor->updateGame($query);
				break;
			}
			default:
			{
				$res = $this->gameInteractor->updateGame($query);
				echo $res;
			}
		}
	}
	
	public function endGame($query)
	{
		die;
	}
	
	public function registerUser($query)
	{
		if ($this->userInteractor->registerUser($query))
		{
			header("location: /demo/home?name_user={$query["name"]}");
			exit;
		}
		header("location: /demo/authorizationExists");
		exit;
	}
	
	public function loginUser($query)
	{
		if ($this->userInteractor->loginUser($query)->num_rows > 0)
		{
			header("location: /demo/home?name_user={$query["name"]}");
			exit;
		}
		header("location: /demo/authorizationRetry");
		exit;
	}
	
	public function getAvatar($query)
	{
		$this->userInteractor->getAvatar($query);
	}
	
	public function updateAvatar($query)
	{
		if ($this->userInteractor->updateAvatar($query))
		{
			header("location: /demo/home?name_user=$query");
			return;
		}
		header("location: /demo/home?name_user=$query&avatarFailure=yes");			
	}
	
	public function showSkins($query)
	{
		$res = $this->userInteractor->showSkins($query);
		$user = $res["user"];
		$skins = $res["skins"];
		$selected = 0;
		$wins = 0;
		$loses = 0;
		$percentage = 0;
		foreach ($user as $it)
		{
			$wins = $it["wins_user"];
			$loses = $it["loses_user"];
			$selected = $it["id_skin"];
			$percentage = $wins + $loses == 0 ? 0 : intval($wins / ($wins + $loses) * 100);
		}
		echo "<div>";
		foreach ($skins as $skin)
		{
			echo "<img src='/demo/infrastructure/HTTPhandler.php?request=getSkin&name={$skin["name_skin"]}&size=full&lock=";
			switch ($skin["conditionType_skin"])
			{
				case 'wins':
				{
					if ($selected == $skin["id_skin"])
						echo "tick'>";
					else if ($wins >= $skin["conditionNumber_skin"])
						echo "no'>";
					else
						echo "yes'>";
					break;
				}
				case 'loses':
				{
					if ($selected == $skin["id_skin"])
						echo "tick'>";
					else if ($loses >= $skin["conditionNumber_skin"])
						echo "no'>";
					else
						echo "yes'>";
					break;
				}
				case 'percentage':
				{
					if ($selected == $skin["id_skin"])
						echo "tick'>";
					else if ($percentage >= $skin["conditionNumber_skin"])
						echo "no'>";
					else
						echo "yes'>";
					break;
				}
			}
		}
		echo "</div>";
		echo "<div>";
		foreach ($skins as $skin)
		{
			echo "<button style='width: 108px'";
			switch ($skin["conditionType_skin"])
			{
				case 'wins':
				{
					if ($selected == $skin["id_skin"])
						echo ">Выбрано</button>";
					else if ($wins >= $skin["conditionNumber_skin"])
						echo "onclick=updateSkin({$skin["id_skin"]})>Выбрать</button>";
					else
						echo ">{$skin["conditionNumber_skin"]} побед</button>";
					break;
				}
				case 'loses':
				{
					if ($selected == $skin["id_skin"])
						echo ">Выбрано</button>";
					else if ($loses >= $skin["conditionNumber_skin"])
						echo "onclick=updateSkin({$skin["id_skin"]})>Выбрать</button>";
					else
						echo ">{$skin["conditionNumber_skin"]} поражений</button>";
					break;
				}
				case 'percentage':
				{
					if ($selected == $skin["id_skin"])
						echo ">Выбрано</button>";
					else if ($percentage >= $skin["conditionNumber_skin"])
						echo "onclick=updateSkin({$skin["id_skin"]})>Выбрать</button>";
					else
						echo ">{$skin["conditionNumber_skin"]} процентов</button>";
					break;
				}
			}
		}
		echo "</div>";
	}
	
	public function getSkin($query)
	{
		$this->userInteractor->getSkin($query);
	}
	
	public function updateSkin($query)
	{
		$this->userInteractor->updateSkin($query);
	}
	
	public function showStats($query)
	{
		$user = $this->userInteractor->showStats($query);
		$wins = $user["wins_user"];
		$loses = $user["loses_user"];
		$percentage = $wins + $loses == 0 ? 0 : intval($wins / ($wins + $loses) * 100);
		echo "<div><div>Побед: $wins</div><div>Поражений: $loses</div><div>Процент: $percentage%</div></div>";
	}
	
	public function visualiseStats($query)
	{
		$user = $this->userInteractor->visualiseStats($query);
		$user["loses_user"] = $user["wins_user"] + $user["loses_user"] == 0 ? 1 : $user["loses_user"];
		$data = [$user["wins_user"], $user["loses_user"]];
		$graph = new PieGraph(300,300);
		$theme_class="DefaultTheme";
		$graph->title->Set("");
		$graph->SetBox(true);
		$p1 = new PiePlot($data);
		$graph->Add($p1);
		$p1->ShowBorder();
		$p1->SetColor('black');
		$graph->legend->SetFrameWeight(1);
		$graph->legend->SetColumns(6);
		$p1->SetSliceColors(array('#00FF00','#FF0000'));

		$graph->Stroke("/var/www/filesystem/tmp/{$query["name_user"]}Graph.png");
		$image = imagecreatefrompng("/var/www/filesystem/tmp/{$query["name_user"]}Graph.png");
		header('Content-type: image/png');
		imagepng($image);
		imagedestroy($image);
		unlink("/var/www/filesystem/tmp/{$query["name_user"]}Graph.png");
	}
	
	public function updateStats($query)
	{
		$this->userInteractor->updateStats($query);
	}
}
?>