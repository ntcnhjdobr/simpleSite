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
		$router = new Router();
		
		$this->route = $router->getRouteArray($url);
		
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