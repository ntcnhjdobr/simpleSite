<?php
class Controller_Home extends AbstractController {
	public function index () {
		$this->setPageTitle('PHP библиотека для управления изображениями на сайте');
	}
	
	public function news () {
		$this->setPageTitle('PHP библиотека для управления изображениями на сайте');
	}
	
	public function manual () {
		$this->setPageTitle('Доументация, библиотеки PhpResizer');
	}
	
	public function email () {
		$text = (isset($_POST['text']))?$_POST['text']:'';
		$message = substr(htmlspecialchars($text),0,20000);
		if (!$message) {
			return;
		}		
		$avalibleEmails = array('ktotutus@gmail.com');
		$subject = 'contact form PhpResizer.org';
		$status = false;
		foreach ($avalibleEmails as $to) {
			 if (mail($to, $subject, $message)) {
			 	$status = true;
			 }	
		}
		$this->view->set('status',$status);
	}
}