<?php 
define('DS', '/');
define ('ROOT_PATH',dirname(dirname(dirname(__FILE__))).DS);

define ('APP_PATH',ROOT_PATH.'app'.DS);
define ('SYSTEM_PATH',ROOT_PATH.'system'.DS);
define ('LOGS_PATH',ROOT_PATH.'logs'.DS);
define ('TMP_PATH',ROOT_PATH.'tmp'.DS);
	define ('UPLOAD_PATH',TMP_PATH.'upload'.DS);
	define ('DOWNLOAD_PATH',ROOT_PATH.'files/download'.DS);
	define ('COUNTERS_PATH',ROOT_PATH.'files/counters'.DS);

	
define ('WEBROOT_PATH',ROOT_PATH.'app/webroot'.DS);

define ('LIBRARY_PATH',APP_PATH.'library'.DS);
//define ('CONTROLLERS_PATH',APP_PATH.'controllers'.DS);
define ('VIEWS_PATH',APP_PATH.'views'.DS);
define ('CONFIGS_PATH',SYSTEM_PATH.'Config'.DS);
define ('HELPERS_PATH',APP_PATH.'helpers'.DS);

require_once SYSTEM_PATH.'Autoloader.php';
require_once SYSTEM_PATH.'AbstractException.php';
new Autoloader();

try {
	$app = new FrontController();
}catch (AbstractException $e) {
	Logger::write('error',$e->getMessage().PHP_EOL.$e->getFile().PHP_EOL.$e->getLine());
	header('HTTP/1.1 404 Not Found');
	$content = View::factory('layout/error',array('error'=>$e));
	$title = 'PHPResizer Error404';
	require_once VIEWS_PATH.'layout/layout.php';
}

