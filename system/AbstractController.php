<?php
class AbstractController {
	public $render = true;
	
	
	public function __construct() {
	}
	
	public function init() {
		$this->input = new Input();
		
		$this->view =new View ();
			$this->view->setPageTitlePrefix('Брусничка');
			$this->view->setLayout('layout');
			$this->view->setViewPath($this->route['controller'].'/'.$this->route['action']);
			$this->view->controller = $this;
	}

	protected function disabledRender () {
		$this->render = false;
	}
	
	protected function setPageTitle ($title='') {
		$this->view->setPageTitle($title);
	}
}