<?php
class FrontController {

	private $route=array('controller'=>'index','action'=>'index','param1'=>null,'param2'=>null);
	
	private $controller = '';
	
	public function __construct() {
		$this->initConfiguration ();
		$this->initDebugger();
		$this->parseUrl();
		$this->initController();
		$this->initView();
		$this->run();
	}
	
	private function initConfiguration() {
		$this->config=Configuration::getInstance();
	}
	
	private function initDebugger () {
		$this->debug = Debugger::getInstance($this->config->get('config.debugger'));
	}
	
	private function parseUrl() {
		$url=(isset($_GET['url']))?$_GET['url']:'';
		
		$arrayUrl =(explode('/',$url));
		 
		if (isset($arrayUrl[0]) AND $arrayUrl[0]) {
			$this->route['controller']=$arrayUrl[0];
		}
		if (isset($arrayUrl[1]) AND $arrayUrl[1]) {
			$this->route['action']=$arrayUrl[1];
		}
		if (isset($arrayUrl[2]) AND $arrayUrl[2]) {
			$this->route['param1']=$arrayUrl[2];
		}
		if (isset($arrayUrl[3]) AND $arrayUrl[3]) {
			$this->route['param2']=$arrayUrl[3];
		}
		$this->route = array_map('strtolower', $this->route);
	}
	
	private function initController() 
	{
		$className =  'Controller_'.ucfirst($this->route['controller'].'');
		$this->controller=new $className();
		$this->controller->route=$this->route;
		$this->controller->init();
	}
	
	private function initView() 
	{
		$this->controller->view =new View ();
		$this->controller->view->setPageTitlePrefix('Site');
		$this->controller->view->setLayout('layout');
		$this->controller->view->setViewPath($this->route['controller'].'/'.$this->route['action']);
	}

	private function run () {
		$action = $this->route['action'];
		
		if (!method_exists($this->controller, $action)) {
			throw new AbstractException('действие '.$action.' в контроллере не найдено');
		};
	
		if (isset($this->route['param2'])) {
		 	$this->controller->$action($this->route['param1'],$this->route['param2']);
		}elseif (isset($this->route['param1'])) {
			$this->controller->$action($this->route['param1']);
		}else{
			$this->controller->$action();
		}

		if ($this->controller->render) {
			$this->controller->view->render();
		}
	}
}