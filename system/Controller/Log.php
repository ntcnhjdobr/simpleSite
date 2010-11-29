<?php
class Controller_Log extends AbstractController {
	
	public function __construct(){
		parent::__construct();
	}
	
	public function index () {
		$this->view->setLayout('system');
		$this->view->setViewPath('log/index');
		$this->view->set('allFiles',$this->getAllFiles());

	}
	
	public function view ($filename='',$len=1000) {
		$this->view->setLayout('system');
		$this->view->setViewPath('log/index');
		
		$this->view->set('allFiles',$this->getAllFiles());
		
		
		if (!$filename OR !file_exists(LOGS_PATH.$filename)) {
			$content='Файл '.LOGS_PATH.$filename.' не найден';	
		}else{
			$content = file_get_contents(LOGS_PATH.$filename);
		}
		
		$this->view->set('filename',$filename);
		
		$this->view->set('content',$content);
	}
	
	private function getAllFiles() {
		return $this->getFileFromDir (new DirectoryIterator(LOGS_PATH));
	}
	
	private function getFileFromDir(DirectoryIterator $directory) {
		$files=array();
		foreach ($directory as $fileInfo) {
	    	if($fileInfo->isDot()){
	    		continue;
	    	}
	    	$files[]=array(
	    		'size'=>$fileInfo->getSize(),
	    		'filename'=>$fileInfo->getFilename()
	    	);
		}
		return $files; 
	}
	
}