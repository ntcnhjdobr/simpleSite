<?php
//
if (isset($_GET['file'])) {
	$file=$_GET['file'];
}else{
	$file='';
};

if (isset($_GET['type'])) {
	if ($_GET['type']=='web'){
	$prefix = '/app/webroot/';
	}elseif($_GET['type']=='laboratory'){
		$prefix = '/tmp/';
	}else{
		$prefix='/';
	}
}else{
	$prefix='/';
}


if (isset($_GET['type']) AND isset($options[$_GET['type']])) {
	$opt =  $options[$_GET['type']];
}elseif(isset($_GET['type']) AND $_GET['type']=='laboratory'){
	$opt = array(
		'crop'=>(int)(isset($_GET['crop']))?$_GET['crop']:100,
		'aspect'=>(isset($_GET['aspect']) and $_GET['aspect']=='true')?true:false,
	);
	
	if(isset($_GET['width'])) {
		$opt['width']=(int)$_GET['width'];
		if ($opt['width']>500) {
			$opt['width']=500;
		}
	}
	if(isset($_GET['height'])) {
		$opt['height']=(int)$_GET['height'];
		if ($opt['height']>500) {
			$opt['height']=500;
		}
	}
}else{
	$opt = array();
}

$path = realpath(dirname(__FILE__) . '/../../system/Library/');



require $path.'/PhpResizer/Autoloader.php';

new PhpResizer_Autoloader();


try {
	$resizer = new PhpResizer_PhpResizer(array (
		//'engine'=>Resizer::ENGINE_IMAGEMAGICK,
		'cacheDir'=>'/var/www/resizer/tmp/resizerCache/',
		'cache'=>false,
		'cacheBrowser'=>true,
		//'engine'=>Resizer::ENGINE_IMAGEMAGICK
		)
	);
	
	///home/phprewnu/public_html
	$rootPath = dirname(dirname(dirname(__FILE__)));
	$resizer->resize($rootPath.$prefix.$file,$opt);
}catch(Exception $e) {
	echo $e->getMessage();
	echo $e->getFile();
	echo $e->getLine();
}

