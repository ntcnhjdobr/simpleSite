<?php
class Controller_Info extends AbstractController {
	
	public function __construct() {
		parent::__construct();
		$this->statictModel = Model_Info::instance();
	}
	
	public function index() {
		exit();
	}
	
//	public function info () 
//	{
//		$this->setPageTitle('Информация');
//		$content = $this->_getContent(Model_Info::CONTENT_INFO);
//		$this->view->set('content',$content[0]);
//		$this->view->set('sections', Model_Section::instance()->getAll());	
//	}

	public function actions () {
		$this->setPageTitle('События');
		$content = $this->_getContent(Model_Info::CONTENT_INFO);
		$this->view->set('content',$content[0]);
		$this->view->set('sections', Model_Section::instance()->getAll());	
	
	}
	public function about()
	{
		$this->setPageTitle('О себе');
		$content = $this->_getContent(Model_Info::CONTENT_ABOUT);
		$this->view->set('content',$content[0]); 
		$this->view->set('sections', Model_Section::instance()->getAll());	
	}
	
	public function contact()
	{
		$this->setPageTitle('Контактная информация');
		$content = $this->_getContent(Model_Info::CONTENT_CONTACT);
		$text = (isset($content[0])) ? $content[0] : '';
		$this->view->set('content', $text);
		
		$error = false;
		$postRawData = $this->input->post();
		
		if ($postRawData) {
		
			if ($postRawData['email'] OR $postRawData['text']) {
				
				$message = view::factory('layout/email', array(
					'email'=>$postRawData['email'],
					'text'=>$postRawData['text']));
		
				$avalibleEmails = array(
					'ktotutus@gmail.com',
					'annab@mail.ru',
					'nws83@mail.ru'
				);
				
				$subject = 'contact from Brusnichka';
				
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=utf8' . "\r\n";
				
				foreach ($avalibleEmails as $to) {
					 if (mail($to, $subject, $message, $headers)) {
					 	$error = 'Успешно отправлено';
					 }
				}
			}else{
				$error = 'Заполните форму';
			}
		}

		$this->view->set('status', $error);
		$this->view->set('sections', Model_Section::instance()->getAll());	

	}
	
	private function _getContent($id) {
		return $this->statictModel->getBy('id', $id);
	}
}
