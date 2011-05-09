<?php
class Router {

	private $_route = array(
		'controller'=>'index',
		'action'=>'index'
	);
	
	public function __construct() {
	}
	
	public function getRouteArray($inputUrlRaw) {
		$config = array();
		
		$inputUrl = rawurldecode(str_replace('_', ' ', $inputUrlRaw)); 
		$arrayUrl = explode('/',$inputUrl,2);

		if ($project = Model_Project::instance()->getBy('title', $arrayUrl[0])) {
			$config[] = array('/^('.$project[0]['title'].')(.*)/iu','index/project/$1$2');
		}elseif($section = Model_Section::instance()->getBy('title', $arrayUrl[0])){
			$config[] = array('/^('.$section[0]['title'].')(.*)/iu','index/section/$1$2');
		}
		
		//echo '1'; exit(); 
		$pattern = array();
		$replacement = array();
		foreach ($config as $regexpArr){
			$pattern[]=$regexpArr[0];
			$replacement[]=$regexpArr[1];
		}
		
		$url = preg_replace($pattern, $replacement, $inputUrl);

		$arrayUrl =(explode('/',$url));
 		
		if (isset($arrayUrl[0]) AND $arrayUrl[0]) {
			$this->_route['controller']=strtolower($arrayUrl[0]);
		}
		if (isset($arrayUrl[1]) AND $arrayUrl[1]) {
			$this->_route['action']=strtolower($arrayUrl[1]);
		}
		if (isset($arrayUrl[2]) AND $arrayUrl[2]) {
			$this->_route['param1']=$arrayUrl[2];
		}
		if (isset($arrayUrl[3]) AND $arrayUrl[3]) {
			$this->_route['param2']=$arrayUrl[3];
		}

		return $this->_route;
	}
	
	public function getShortUrl ($urlLong) {
		
		$config = array(); 
		$config[] = array('/^(\/index\/project)(.*)/','$2');
		$config[] = array('/^(\/index\/section)(.*)/','$2');
		$config[] = array('/^(\/index\/index)(.*)/','$2');
		//$config[] = array('/^(\/info\/about)(.*)/','$2');
			
		$pattern = array();
		$replacement = array();
		foreach ($config as $regexpArr){
			$pattern[]=$regexpArr[0];
			$replacement[]=$regexpArr[1];
		}

		$shortUrl = preg_replace($pattern, $replacement, $urlLong);

		return $shortUrl;
	}
	
	
	
}