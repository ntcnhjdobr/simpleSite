<?php
class Helper_Html {
	static public function link($params = array()) {
//		if (is_string($params)){
//			return $params;
//		}
		
		
		$link = '/';///simpleSite/';
		
		if (is_string($params)) {
			if ($params) {
				$link = '/app/webroot/';
			}
			return str_replace('//', '/', $link.$params);		 
		}
		
		if (isset($params['controller'])) {
			$link.=self::_getSegment($params['controller']);
		}
		
		if (isset($params['action'])) {
			$link.= self::_getSegment($params['action']);
		}

		if (isset($params['param1']) && $params['param1']) {
			$link.= self::_getSegment($params['param1']);
		}
		
		if (isset($params['param2'])&& $params['param2']) {
			$link.=self::_getSegment($params['param2']);
		}
				
		if (isset($params['query'])) {
			$link.='?'.$params['query'];
		}
		
		if (isset($params['#'])) {	
			
			$link.='#'.str_replace('%2F', '/', self::_getSegment($params['#']));
		}
		
		$router = new Router();
		$link = $router->getShortUrl($link);
		
		return $link;
	}
	
	private function _getSegment($str) {
		return rawurlencode(str_replace(' ', '_', $str)).'/';
	}
}