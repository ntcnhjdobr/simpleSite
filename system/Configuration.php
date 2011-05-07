<?php
/**
 * pattern Singleton
 * @author niko
 *
 */
class Configuration {
	
	static private $instance = null; 
	
	private function __construct () {}
	
	static public function getInstance () {
		if(!self::$instance){
			self::$instance = new self;
		}
		return self::$instance;
	}

	
	public function set ($param,$val) {
		return null;
		if (is_string($param)) {
			$this->$param=$val;
		}elseif(is_array($param)){
			foreach ($param as $key=>$val){
				$this->$key=$val;	
			}
		}
	}
	
	public function get ($key) {
		//CONFIGS_PATH
		$configPath = explode('.',$key);
		
		$configFile = $configPath[0];
		
		if (isset($this->$configFile)) {
			$config = $this->$configFile;
		}else{
			
			$fileName = CONFIGS_PATH.$configFile.'.php';
			
			if (!is_readable($fileName)) {
				throw new AbstractException('файл конфигурации '.$fileName.' не найден');
			}
			
			require_once $fileName;
			
			if (!isset($config)) {
				throw new AbstractException('карявый файл конфигурации '.$fileName);
			}
			$this->$configFile=$config;
		}
		
		$tmp = $config;
		for ($i = 0; $i<count($configPath); $i++){
			if (isset($tmp[$configPath[$i]])){
				if (!isset($configPath[$i+1])){
					return $tmp[$configPath[$i]];
				}else{
					$tmp = $tmp[$configPath[$i]];
				}
			}
		}
		throw new AbstractException('config options '.$key.' is not found ');
	}
	
	private function return_config ($path) {
		return $path; 
	}
}
