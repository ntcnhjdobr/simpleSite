<?php
class Input 
{
	
	public function get() 
	{
		return $this->_returnPostGetData('GET', $key);
	}
	
	public function post($key = null) 
	{
		return $this->_returnPostGetData('POST', $key);
	}
	
	private function _returnPostGetData($type, $key) {
		$outputData = null;

		$var = ($type == 'POST') ? $_POST : $_GET;
		if (is_null($key)){
			$outputData = $var;
		}elseif(isset($var[$key])){
			$outputData = $var[$key];
		}

		return $this->_stripslashes($outputData);		
	}
	
	private function _stripslashes($data) {
		if(get_magic_quotes_gpc() && (! ini_get('magic_quotes_sybase'))){
			if (is_array($data)) {
				$data = array_map('stripcslashes', $data);
				$data = array_map('html_entity_decode', $data);
			}else{
				$data = html_entity_decode(stripcslashes($data));
			}
		}
		return $data;
	}
}