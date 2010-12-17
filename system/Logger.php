<?php
class Logger {
	static public function write($filename='',$msg='',array $startOptions = array()) {
		$defaultOptions= array (
			'logTime'=>true,
			'logUserAgent'=>true,
			'logIp'=>true,
			'logReferer'=>true
		);
		$options = array_merge($defaultOptions,$startOptions);
		extract ($options);
		
		$message[] = '~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~';
		$message[] = $msg;
		$url = (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : '';
		$host = (isset($_SERVER['HTTP_HOST'])) ? $_SERVER['HTTP_HOST'] : '';
		$message[] = 'Url: http://'.$host.$url;

		if ($logTime){
			$message[]='Time: '.date('Y-m-d H:i:s');
		}
		
		if ($logIp) {
			if( isset($_SERVER['REMOTE_ADDR']) ){
				$remoteIp = $_SERVER['REMOTE_ADDR'];
			}elseif( isset($_SERVER['HTTP_X_FORWARDED_FOR']) ){
				$remoteIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
			}elseif(  isset($_SERVER['HTTP_X_REAL_IP']) ){
				$remoteIp =  $_SERVER['HTTP_X_REAL_IP'];
			}else{
				$remoteIp = '???';
			}
			$message[] = 'Ip: '.$remoteIp;		
		}
		
		if ($logUserAgent) {
			$userAgent = (isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : '???';
			$message[] = 'UserAgent: ' .$userAgent;
		}
		
		if ($logReferer){
			$referer = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '???';
			$message[] = 'Referer url: '.$referer;
		}

		$messageText =implode(PHP_EOL, $message).PHP_EOL;
		
		file_put_contents(LOGS_PATH.$filename.'_'.date('Y-m-d'), $messageText, FILE_APPEND);
	}
}