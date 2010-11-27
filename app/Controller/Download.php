<?php
class Controller_Download extends AbstractController
{
	public function index () 
	{
		$output_file_name = 'phpresizer1.0.rar';
		$filePath = DOWNLOAD_PATH.$output_file_name;
		Header('Content-Type: application/x-tar');
		Header("Content-disposition: filename=".$output_file_name);
		Header("Content-Length: ".filesize($filePath));
		readfile($filePath);
		exit();    
	}
}