<?php
require_once "/var/www/html/real/admin/entities/interfaces/avatarStorage.php";

class AvatarStorageAdapter implements AvatarStorage
{
	public function create($query)
	{
		move_uploaded_file($_FILES['fileToUpload']['tmp_name'], "/var/www/filesystem/tmp/{$query}.png");
		if (strpos(shell_exec("cd /var/www/filesystem/tmp && file {$_GET["name_user"]}.png"), ": PNG") !== false)
		{
			$image1 = imagecreatefrompng("/var/www/filesystem/tmp/{$query}.png");
			$image2 = imagescale($image1, 300, 300);
			imagedestroy($image1);
			imagepng($image2, "/var/www/filesystem/avatars/{$query}.png");
			imagedestroy($image2);
			unlink("/var/www/filesystem/tmp/{$query}.png");
			return(true);
		}
		unlink("/var/www/filesystem/tmp/{$query}.png");
		return(false);
	}
	
	public function read($query)
	{
		if (is_null($query))
			$query = "default";
		header('Content-type: image/png');
		if (file_exists('/var/www/filesystem/avatars/'.$query.'.png'))
		{
			$image = imagecreatefrompng('/var/www/filesystem/avatars/'.$query.'.png');
			imagepng($image);
			imagedestroy($image);
			exit;
		}
		$image = imagecreatefrompng('/var/www/filesystem/avatars/default.png');
		imagepng($image);
		imagedestroy($image);
		exit;
	}
	
	public function update($query)
	{
		die;
	}
	
	public function delete($query)
	{
		die;
	}
}
?>