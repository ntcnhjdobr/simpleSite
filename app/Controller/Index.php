<?php
class Controller_Index extends AbstractController {
	public function index () {
		$this->view->setViewPath('home/news');
		$this->setPageTitle('PHP библиотека для управления изображениями на сайте');
	}
}
