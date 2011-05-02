<?php

//var_dump (PHP_SAPI); exit();

//exec('convert',$as);
//var_dump ($as); 
//new Imagick();
//var_dump (get_loaded_extensions ());
//phpinfo(); exit();
//var_dump (ini_get('open_basedir'));
//echo '---------------';
//var_dump (ini_get('safe_mode_exec_dir'));
//echo '---------------';
//
//
//	var_dump (exec  ('ls /usr/local/lib/php'));
//        exit();anna
define('DS', '/');
define ('ROOT_PATH',dirname(dirname(dirname(__FILE__))).DS);

define ('APP_PATH',ROOT_PATH.'app'.DS);
define ('SYSTEM_PATH',ROOT_PATH.'system'.DS);
define ('LOGS_PATH',ROOT_PATH.'logs'.DS);
	define ('UPLOAD_PATH',ROOT_PATH.'files/upload'.DS);
	define ('DOWNLOAD_PATH',ROOT_PATH.'files/download'.DS);


	
define ('WEBROOT_PATH',ROOT_PATH.'app/webroot'.DS);

define ('LIBRARY_PATH',APP_PATH.'library'.DS);
//define ('CONTROLLERS_PATH',APP_PATH.'controllers'.DS);
define ('VIEWS_PATH',APP_PATH.'Views'.DS);
define ('CONFIGS_PATH',SYSTEM_PATH.'Config'.DS);
define ('HELPERS_PATH',APP_PATH.'helpers'.DS);

require_once SYSTEM_PATH.'Autoloader.php';
require_once SYSTEM_PATH.'AbstractException.php';
new Autoloader();

set_error_handler(array('Core','errorHandler'), E_ALL);
set_exception_handler(array('Core','exceptionHandler'));

$app = new FrontController();
