<?php
class Logger {
	static public function write($filename='',$message='',array $startOptions = array()) {
		$defaultOptions= array (
			'data'=>false,
			'userAgent'=>false,
			'ip'=>false
		);
		$options = array_merge($defaultOptions,$startOptions);
		extract ($options);
		
		$message.=PHP_EOL.'-------------------------------------------------'.PHP_EOL;
		file_put_contents(LOGS_PATH.$filename.'_'.date('Y-m-d'), $message, FILE_APPEND);
	}
}