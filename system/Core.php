<?php
class Core
{
	/**
	 * classic Errorhandler
	 * 
	 * @param $errno
	 * @param $errstr
	 * @param $errfile
	 * @param $errline
	 */
	static public function errorHandler ($errno, $errstr, $errfile, $errline)
	{
		$errortype = array (
	                E_ERROR           => "Error",
	                E_WARNING         => "Warning",
	                E_PARSE           => "Parsing Error",
	                E_NOTICE          => "Notice",
	                E_CORE_ERROR      => "Core Error",
	                E_CORE_WARNING    => "Core Warning",
	                E_COMPILE_ERROR   => "Compile Error",
	                E_COMPILE_WARNING => "Compile Warning",
	                E_USER_ERROR      => "User Error",
	                E_USER_WARNING    => "User Warning",
	                E_USER_NOTICE     => "User Notice",
	                E_STRICT          => "Runtime Notice"
	                );
	                
		Logger::write('error', $errortype[$errno].': '.$errstr.' in '.$errfile.', on line '.$errline);

		if (Configuration::getInstance()->get('config.showErrors')) {
			echo '<div style="background-color: white; padding: 10px">';
			echo '<h1>'.$errortype[$errno].'</h1>';
			echo $errstr.' in <u>'.$errfile.'</u>, on line '.$errline;
			echo '<br/><br/>';
			echo '</div>';
			return false;
		}else{
			self::_renderErrorPage();
			return true;
		}
	}
	/**
	 * 
	 * classic exeption Handler
	 * 
	 * @param unknown_type $e
	 */
	static public function exceptionHandler ($e)
	{
		Logger::write('error',$e->getMessage().PHP_EOL.$e->getFile().PHP_EOL.$e->getLine());
		return self::_renderErrorPage($e);
	}
	
	private function _renderErrorPage($e = false) {
		header('HTTP/1.1 404 Not Found');
		$content = View::factory('layout/error',array('error'=>$e));
		$title = 'PHPResizer Error404';
		require_once VIEWS_PATH.'layout/layout.php';
	} 
}