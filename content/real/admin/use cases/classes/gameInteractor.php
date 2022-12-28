<?php
require_once "/var/www/html/real/admin/entities/classes/game.php";
require_once "/var/www/html/real/admin/entities/interfaces/gameStorage.php";

class GameInteractor
{
	private $running;
	private $gameStorage;
	
	public function __construct($query)
	{
		$this->gameStorage = $query["gameStorage"];
	}
	
	public function hostGame($query)
	{
		$this->gameStorage->delete($query);
		return($this->gameStorage->create($query));
	}
	
	public function startGame($query)
	{
		$res = $this->gameStorage->read($query);
		if ($res->num_rows > 0)
		{
			foreach ($res as $key => $value)
				$game[$key] = $value;
			$game = $game[0];
			$str = "";
			$dim = $game["width_game"] * $game["height_game"];
			for ($i = 0; $i < $dim; ++$i)
				$str .= "0";
			$query["state_game"] = $str;
			$query["isPlayerOneTurn_game"] = $game["isPlayerOneTurn_game"];
			$query["nameWinner_user"] = "NULL";
			$this->gameStorage->update($query);
			return(true);
		}
		return(false);
	}
	
	public function updateGame($query)
	{
		switch ($query["status"])
		{
			case "waiting":
			{
				$res = $this->gameStorage->read($query);
				$game = [];
				foreach ($res as $key => $value)
					$game[$key] = $value;
				$game = $game[0];
				if (is_null($game["namePlayerTwo_user"]))
					return("NULL");
				else
					return($game["namePlayerTwo_user"]);
				break;
			}
			case "joined":
			{
				$res = $this->gameStorage->read($query);
				$game = [];
				foreach ($res as $key => $value)
					$game[$key] = $value;
				$game = $game[0];
				if (is_null($game["namePlayerOne_user"]))
					return("NULL");
				else
					return($game["namePlayerOne_user"]);
				break;
			}
			case "player1":
			{
				$res = $this->gameStorage->read($query);
				$game = [];
				foreach ($res as $key => $value)
					$game[$key] = $value;
				$game = $game[0];
				$state = $game["state_game"];
				$width = $game["width_game"];
				$height = $game["height_game"];
				$isPlayerOneTurn = boolval($game["isPlayerOneTurn_game"]);
				$draw = true;
				foreach (str_split($state) as $char)
				{
					if ($char == '0')
					{
						$draw = false;
						break;
					}
				}
				if ($draw)
					echo "<div>Ничья!</div>";
				else
				if ($game["nameWinner_user"] == $game["namePlayerOne_user"])
				{
					echo "<div>Победил {$game["namePlayerOne_user"]}!</div>";
				}
				else
				if ($game["nameWinner_user"] == $game["namePlayerTwo_user"])
				{
					echo "<div>Победил {$game["namePlayerTwo_user"]}!</div>";
				}
				else
				if ($isPlayerOneTurn)
					echo "<div>Ходит {$game["namePlayerOne_user"]}</div>";
				else
					echo "<div>Ходит {$game["namePlayerTwo_user"]}</div>";
				echo "<table>";
				for ($j = 0; $j < $height; ++$j)
				{
					echo "<tr>";
					for ($i = 0; $i < $width; ++$i)
					{
						$num = getTile($state, $width, $height, $i, $j);
						switch ($num)
						{
							case "0":
							{
								if ($isPlayerOneTurn)
									echo "<td onclick='setTile($i, $j)'></td>";
								else
									echo "<td></td>";
								break;
							}
							case "1":
							{
								echo "<td><img src='/real/infrastructure/HTTPhandler.php?request=getSkin&name={$query["name_skin1"]}&size=X'></td>";
								break;
							}
							case "2":
							{
								echo "<td><img src='/real/infrastructure/HTTPhandler.php?request=getSkin&name={$query["name_skin2"]}&size=O'></td>";
								break;
							}
						}
					}
					echo "</tr>";
				}
				break;
			}
			case "player2":
			{
				$res = $this->gameStorage->read($query);
				$game = [];
				foreach ($res as $key => $value)
					$game[$key] = $value;
				$game = $game[0];
				$state = $game["state_game"];
				$width = $game["width_game"];
				$height = $game["height_game"];
				$isPlayerOneTurn = boolval($game["isPlayerOneTurn_game"]);
				$draw = true;
				foreach (str_split($state) as $char)
				{
					if ($char == '0')
					{
						$draw = false;
						break;
					}
				}
				if ($draw)
					echo "<div>Ничья!</div>";
				else
				if ($game["nameWinner_user"] == $game["namePlayerOne_user"])
				{
					echo "<div>Победил {$game["namePlayerOne_user"]}!</div>";
				}
				else
				if ($game["nameWinner_user"] == $game["namePlayerTwo_user"])
				{
					echo "<div>Победил {$game["namePlayerTwo_user"]}!</div>";
				}
				else
				if ($isPlayerOneTurn)
					echo "<div>Ходит {$game["namePlayerOne_user"]}</div>";
				else
					echo "<div>Ходит {$game["namePlayerTwo_user"]}</div>";
				echo "<table>";
				for ($j = 0; $j < $height; ++$j)
				{
					echo "<tr>";
					for ($i = 0; $i < $width; ++$i)
					{
						$num = getTile($state, $width, $height, $i, $j);
						switch ($num)
						{
							case "0":
							{
								if (!$isPlayerOneTurn)
									echo "<td onclick='setTile($i, $j)'></td>";
								else
									echo "<td></td>";
								break;
							}
							case "1":
							{
								echo "<td><img src='/real/infrastructure/HTTPhandler.php?request=getSkin&name={$query["name_skin1"]}&size=X'></td>";
								break;
							}
							case "2":
							{
								echo "<td><img src='/real/infrastructure/HTTPhandler.php?request=getSkin&name={$query["name_skin2"]}&size=O'></td>";
								break;
							}
						}
					}
					echo "</tr>";
				}
				break;
			}
			case "turn1":
			{
				$res = $this->gameStorage->read($query);
				$game = [];
				foreach ($res as $key => $value)
					$game[$key] = $value;
				$game = $game[0];
				$state = $game["state_game"];
				$width = $game["width_game"];
				$height = $game["height_game"];
				$i = $query["x"];
				$j = $query["y"];
				$isPlayerOneTurn = boolval($game["isPlayerOneTurn_game"]);
				if (!$isPlayerOneTurn)
					return;
				$res = setTile($state, $width, $height, $i, $j, 1);
				$query["state_game"] = $res;
				$query["isPlayerOneTurn_game"] = 0;
				$query["nameWinner_user"] = "NULL";
				$length = $game["length_game"];
				$state = $query["state_game"];
				$streak = 0;
				$jcheck = 0;
				$icheck = 0;
				if ($j > $i)
				{
					$jcheck = $j - $i;
					$icheck = 0;
				}
				else
				{
					$icheck = $i - $j;
					$jcheck = 0;
				}
				while (($icheck < $height) && ($jcheck < $width))
				{
					var_dump(getTile($state, $width, $height, $icheck, $jcheck));
					var_dump(getTile($state, $width, $height, $icheck, $jcheck) == "1");
					if (getTile($state, $width, $height, $icheck, $jcheck) == "1")
					{
						++$streak;
						if ($streak == $length)
						{
							$query["nameWinner_user"] = $game["namePlayerOne_user"];
							$this->gameStorage->update($query);
							return;
						}
					}
					else
						$streak = 0;
					++$icheck;
					++$jcheck;
				}
				$streak = 0;
				$dist = $width - $j - 1;
				if ($dist > $i)
				{
					$jcheck = $j + $i;
					$icheck = 0;
				}
				else
				{
					$icheck = $i - $dist;
					$jcheck = $width - 1;
				}
				while (($icheck < $height) && ($jcheck >= 0))
				{
					if (getTile($state, $width, $height, $icheck, $jcheck) == "1")
					{
						++$streak;
						if ($streak == $length)
						{
							$query["nameWinner_user"] = $game["namePlayerOne_user"];
							$this->gameStorage->update($query);
							return;
						}
					}
					else
						$streak = 0;
					++$icheck;
					--$jcheck;
				}
				$streak = 0;
				$jcheck = $j;
				$icheck = 0;
				while (($icheck < $height) && ($jcheck < $width))
				{
					if (getTile($state, $width, $height, $icheck, $jcheck) == "1")
					{
						++$streak;
						if ($streak == $length)
						{
							$query["nameWinner_user"] = $game["namePlayerOne_user"];
							$this->gameStorage->update($query);
							return;
						}
					}
					else
						$streak = 0;
					++$icheck;
				}
				$streak = 0;
				$jcheck = 0;
				$icheck = $i;
				while (($icheck < $height) && ($jcheck < $width))
				{
					if (getTile($state, $width, $height, $icheck, $jcheck) == "1")
					{
						++$streak;
						if ($streak == $length)
						{
							$query["nameWinner_user"] = $game["namePlayerOne_user"];
							$this->gameStorage->update($query);
							return;
						}
					}
					else
						$streak = 0;
					++$jcheck;
				}
				$this->gameStorage->update($query);
				break;
			}
			case "turn2":
			{
				$res = $this->gameStorage->read($query);
				$game = [];
				foreach ($res as $key => $value)
					$game[$key] = $value;
				$game = $game[0];
				$state = $game["state_game"];
				$width = $game["width_game"];
				$height = $game["height_game"];
				$i = $query["x"];
				$j = $query["y"];
				$isPlayerOneTurn = boolval($game["isPlayerOneTurn_game"]);
				if ($isPlayerOneTurn)
					return;
				$res = setTile($state, $width, $height, $i, $j, 2);
				$query["state_game"] = $res;
				$query["isPlayerOneTurn_game"] = 1;
				$query["nameWinner_user"] = "NULL";
				$length = $game["length_game"];
				$state = $query["state_game"];
				$streak = 0;
				$jcheck = 0;
				$icheck = 0;
				if ($j > $i)
				{
					$jcheck = $j - $i;
					$icheck = 0;
				}
				else
				{
					$icheck = $i - $j;
					$jcheck = 0;
				}
				while (($icheck < $height) && ($jcheck < $width))
				{
					var_dump(getTile($state, $width, $height, $icheck, $jcheck));
					var_dump(getTile($state, $width, $height, $icheck, $jcheck) == "2");
					if (getTile($state, $width, $height, $icheck, $jcheck) == "2")
					{
						++$streak;
						if ($streak == $length)
						{
							$query["nameWinner_user"] = $game["namePlayerTwo_user"];
							$this->gameStorage->update($query);
							return;
						}
					}
					else
						$streak = 0;
					++$icheck;
					++$jcheck;
				}
				$streak = 0;
				$dist = $width - $j - 1;
				if ($dist > $i)
				{
					$jcheck = $j + $i;
					$icheck = 0;
				}
				else
				{
					$icheck = $i - $dist;
					$jcheck = $width - 1;
				}
				while (($icheck < $height) && ($jcheck >= 0))
				{
					if (getTile($state, $width, $height, $icheck, $jcheck) == "2")
					{
						++$streak;
						if ($streak == $length)
						{
							$query["nameWinner_user"] = $game["namePlayerTwo_user"];
							$this->gameStorage->update($query);
							return;
						}
					}
					else
						$streak = 0;
					++$icheck;
					--$jcheck;
				}
				$streak = 0;
				$jcheck = $j;
				$icheck = 0;
				while (($icheck < $height) && ($jcheck < $width))
				{
					if (getTile($state, $width, $height, $icheck, $jcheck) == "2")
					{
						++$streak;
						if ($streak == $length)
						{
							$query["nameWinner_user"] = $game["namePlayerTwo_user"];
							$this->gameStorage->update($query);
							return;
						}
					}
					else
						$streak = 0;
					++$icheck;
				}
				$streak = 0;
				$jcheck = 0;
				$icheck = $i;
				while (($icheck < $height) && ($jcheck < $width))
				{
					if (getTile($state, $width, $height, $icheck, $jcheck) == "2")
					{
						++$streak;
						if ($streak == $length)
						{
							$query["nameWinner_user"] = $game["namePlayerTwo_user"];
							$this->gameStorage->update($query);
							return;
						}
					}
					else
						$streak = 0;
					++$jcheck;
				}
				$this->gameStorage->update($query);
				break;
			}
		}
	}
	
	public function endGame($query)
	{
		die;
	}
}

function getTile($state, $width, $height, $x, $y)
{
	$index = $y * $width + $x;
	return($state[intval($index)]);
}

function setTile($state, $width, $height, $x, $y, $turn)
{
	$index = $y * $width + $x;
	$state[$index] = strval($turn);
	return($state);
}
?>