<?php
interface Storage
{
	public function create($query);
	public function read($query);
	public function update($query);
	public function delete($query);
}
?>