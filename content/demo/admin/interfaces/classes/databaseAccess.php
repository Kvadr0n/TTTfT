<?php
abstract class DatabaseAccess
{
	public $connection;
	
	public abstract function connect($query);
}
?>