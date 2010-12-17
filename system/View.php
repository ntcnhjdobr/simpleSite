<?php
class View {
	private $layout=false;
	private $viewPath = false;
	private $_pageTitle = '';
	private $_pageDescription = '';
	
	private $data = array();
	
	public function __construct () {
	}

	
	public function setLayout ($layout) {
		$fileName = VIEWS_PATH.'/layout/'.$layout.'.php'; 
		$this->_checkFileExist($fileName,'нет файла layout`a');
		$this->layout=$fileName;
	}
	
	public function setViewPath ($viewPath) {
		$this->viewPath = VIEWS_PATH.$viewPath.'.php'; 
	}
	
	public function set($key,$val) {
		if (is_string($key)){
			$this->data[$key]=$val;
		}elseif(is_array($key)) {
		foreach ($key as $key2 => $val2)
			$this->data[$key2]=$val2;
		}
	}
	
	public function render() {
		extract($this->data);
		
		$this->_checkFileExist($this->viewPath,'нет файла вида');
		
		ob_start();
			require_once $this->viewPath;
		$content = ob_get_clean();
		
		$title = $this->_getPageTitlePrefix().' - '.$this->_getPageTitle();
		$description = $this->_getPageDescrioption();
		
		require_once $this->layout;
	}
	
/**
 * TITLE
 */
	public function setPageTitle($title='') {
		$this->_pageTitle = $title;
	}
	
	private function  _getPageTitle(){
		if ($this->_pageTitle) {
			return $this->_pageTitle; 
		}else{
			return 'No title';
		}
	}
	public function setPageTitlePrefix($title='') {
		$this->pageTitlePrefix = $title;
	}
	private function  _getPageTitlePrefix(){
		if ($this->pageTitlePrefix) {
			return $this->pageTitlePrefix; 
		}else{
			return '';
		}
	}
/**
 * Descriotion
 */
	
	public function setPageDescription($description='') {
		$this->_pageDescription = $description;
	}
	public function _getPageDescrioption($description='') {
		return $this->_pageDescription;
	}
	
////////////////////////

	
	public static function factory ($viewPath,array $data=array()) {
		$instance = new self();
		extract($data);
		
		$fileName = VIEWS_PATH.$viewPath.'.php'; 
		
		$instance->_checkFileExist($fileName);
		
		ob_start();
		include $fileName;
		$render = ob_get_clean();
		return $render;
	}
	
	private function _checkFileExist ($fileName,$message='') {
		if (!is_readable($fileName)) {
			throw new AbstractException('файл: '.$fileName.' не найден'.$message);
		}
	}
}