<?php
class Configuration {
	
	static private $instance = null; 
	
	private function __construct () {
	}
	
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
		
		if (isset($configPath[4])) {
			throw new AbstractException('слишков вложенный файл конфигурации');
		}elseif (isset($configPath[3])) {
			return $this->return_config($config[$configPath[1]][$configPath[2]][$configPath[3]]); 
		}elseif(isset($configPath[2])){
			return $this->return_config($config[$configPath[1]][$configPath[2]]);
		}elseif(isset($configPath[1])){
			return $this->return_config($config[$configPath[1]]);
		}else{
			return $config;
		}
	}
	
	private function return_config ($path) {
		return $path; 
	}
}
