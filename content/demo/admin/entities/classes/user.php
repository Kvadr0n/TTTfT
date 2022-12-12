<?php
class User
{
	public $id_user;
	public $name;
	public $pass;
	public $id_skin;
	public $wins;
	public $loses;
	
	public function __construct($query)
	{
		$id_user = $query["id_user"];
		$name = $query["name_user"];
		$pass = $query["pass_user"];
		$id_skin = $query["id_skin"];
		$wins = $query["wins_user"];
		$loses = $query["loses_user"];
	}
}
?>