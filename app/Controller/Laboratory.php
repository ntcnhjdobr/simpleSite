<?php
class Controller_Laboratory extends AbstractController {
	public function index () {
		$this->setPageTitle('Работающий пример генерации уменьшенных копий изображений');
		$this->view->set('filename','/demo/demo.jpg');
	}
	
	public function upload () {
		$image = $this->checkImageAndSave(); 
 
		$image = ($image)?'/upload/'.$image:'/demo/demo.jpg';
		$this->view->set('filename',$image);
		$this->view->setViewPath('laboratory/index');
	}
	
	private function checkImageAndSave () {
		$image = (isset($_FILES['image']))?$_FILES['image']:false;
		
		if ($image['error']) {
			$arrayErrors = array(
				1=>'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
				2=>'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
				3=>'The uploaded file was only partially uploaded.',
				4=>'No file was uploaded.',
				5=>'',
				6=>'Missing a temporary folder. Introduced in PHP 4.3.10 and PHP 5.0.3.',
				7=>'Failed to write file to disk. Introduced in PHP 5.1.0.',
				8=>'A PHP extension stopped the file upload. PHP does not provide a way to ascertain which extension caused the file upload to stop; examining the list of loaded extensions with phpinfo() may help. Introduced in PHP 5.2.0.'
			);
			echo $arrayErrors[$image['error']];
			return false;	
		} 
	 
		if (!$image) {
			echo 'no post data';
			return false;
		}
		
		$ext = strtolower(pathinfo($image['name'],PATHINFO_EXTENSION));
		
		if (!in_array($ext, array('jpg','gif','png'))) {
			echo 'broken ext';
			return false;	
		}
		
		if (!@getimagesize($image['tmp_name'])) {
			return false;
		}

		$newFileName = md5_file($image['tmp_name']).'.'.$ext;
		
		if (!$result = move_uploaded_file ($image['tmp_name'],UPLOAD_PATH.$newFileName)) {
			return false;
		}
		
		return $newFileName; 
	}
	
}