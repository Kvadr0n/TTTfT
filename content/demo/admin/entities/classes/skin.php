<?php
require_once "/var/www/html/demo/admin/entities/classes/conditionType.php";

class Skin
{
	public $id;
	public $name;
	public $conditionType;
	public $conditionNumber;
	public $image;
	
	public function __construct($query)
	{
		$id = $query["id_skin"];
		$name = $query["name_skin"];
		//$conditionType = $query["conditionType_skin"];
		$conditionNumber = $query["conditionNumber_skin"];
		$image = imagecreatefromjpeg("/var/www/filesystem/skins/$name");
	}
	
	public function responseImage()
	{
		header('Content-type: image/png');
		imagepng($image);
		imagedestroy($image);
	}
}
?>