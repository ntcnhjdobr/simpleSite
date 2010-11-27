<?php
class AbstractController {
	public $render = true;
	
	public function __construct() {
	}
	
	public function init() {
	}

	protected function disabledRender () {
		$this->render = false;
	}
	
	protected function setPageTitle ($title='') {
		$this->view->setPageTitle($title);
	}
	
}