<?php

//sleep(rand(0.2, 3));

$file= (isset($_GET['file'])) ? $_GET['file'] : '';

$options = array(
	// на главной странице
	'startpage'=>array(
		'width' => 700,
		'height' => 350,
		'aspect' => false,
		'crop' => 100
	),
	// предпромотр проекта
	'prev_proj'=>array(
		'width' => 600,
		'height' => 250,
		'aspect' => true,
		'crop' => 100),	
	
	// предпромотр работы
	'prev_sample'=>array(
		'width' => 120,
		'height' => 90,
		'aspect' => false,
		'crop' => 85
	),
	// Админ
	'adminpreview'=>array(
		'width' => 60,
		'height' => 50,
		'aspect' => false,
		'crop' => 60
		//'background'=>'fF0060'
	),
	//полноразмерная фотка
	'sample'=>array(  
		'width' => 630,
		'height' => 900,
		'aspect' => true,
		'crop' => 100
	),
	'micro_pre'=>array(  
		'width' => 60,
		'height' => 50,
		'aspect' => false,
		'crop' => 60
	),
);

if (isset($_GET['type']) AND isset($options[$_GET['type']])) {
	$opt =  $options[$_GET['type']];
	
	if ($_GET['type']=='sample' && isset($_GET['w']) && isset($_GET['h'])){
		$k = 0.90;
		$w =  (int) $_GET['w'];
		$h =  (int) $_GET['h'];

		$maxWidth = 800;
		$w =  $w > $maxWidth ? $maxWidth : $w;

		$round = 10;
		$opt['width'] = floor($w*$k/$round)*$round;
		$opt['height'] = floor($h*$k/$round)*$round;
	}elseif ($_GET['type']=='prev_proj'){
		$k = 0.3;
		$round = 10;
		if (isset($_GET['h'])) {
			$opt['height'] = floor((int)$_GET['h']*$k/$round)*$round;
		}else{
			$opt['height'] = 200;
		}
	}elseif ($_GET['type']=='startpage' && isset($_GET['w']) && isset($_GET['h'])){
		$k = 0.4;
		$w =  (int) $_GET['w'];
		$h =  (int) $_GET['h'];
		$round = 10;
		$opt['height'] = floor($h*$k/$round)*$round;
		$opt['width'] = $opt['height']*2;
	}

	$rootPath = dirname(dirname(dirname(__FILE__))).'/';
}else {
	$opt = array();
	$rootPath = dirname(__FILE__).'/';
}


$path = realpath(dirname(__FILE__) . '/../../system/Library/');

require $path.'/PhpResizer/Autoloader.php';

new PhpResizer_Autoloader();

try {
	$resizer = new PhpResizer_PhpResizer(array (
		'cacheDir'=>realpath(dirname(__FILE__) . '/../../tmp/PhpResizer/'),
		'tmpDir'=>realpath(dirname(__FILE__) . '/../../tmp/tmp/'),
		'cache'=>true,
		'cacheBrowser'=>true,
		'engine'=>PhpResizer_PhpResizer::ENGINE_GD2
		)
	);
	
	$resizer->resize($rootPath . $file, $opt);
}catch(Exception $e) {
	echo $e->getMessage();
	echo $e->getFile();
	echo $e->getLine();
}

