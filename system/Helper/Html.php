<?php
class Helper_Html {
	static public function link($params = array()) {
//		if (is_string($params)){
//			return $params;
//		}
		
		$link = '/';
		if (isset($params['controller'])) {
			$link.=$params['controller'].'/';
		}
		if (isset($params['action'])) {
			$link.=$params['action'].'/';
		}

		if (isset($params['param1'])) {
			$link.=$params['param1'].'/';
		}
		if (isset($params['param2'])) {
			$link.=$params['param2'].'/';
		}
				
		if (isset($params['query'])) {
			$link.='?'.$params['query'];
		}
		
		return $link;
	}
}