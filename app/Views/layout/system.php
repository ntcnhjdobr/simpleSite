<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<link rel="icon" href="<?php echo Helper_Html::link('/favicon.png')?>" />
	<link rel="shortcut icon" href="<?php echo Helper_Html::link('/favicon.ico')?>" type="image/x-icon" />
	
	<link rel="stylesheet" type="text/css" href="<?php echo Helper_Html::link('/css/css.css');?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo Helper_Html::link('/css/system.css');?>" />
		
	<?php if (Configuration::getInstance()->get('config.googleAnalytics.isEnabled')) { ?>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
	<?php }else{ ?>
		<script type="text/javascript" src="<?php echo Helper_Html::link('/js/jquery-1.4.3.min.js')?>"></script>
	<?php }?>
	
	<script type="text/javascript" src="<?php echo Helper_Html::link('/js/jquery.waterwheelCarousel.js')?>"></script>
	<script type="text/javascript" src="<?php echo Helper_Html::link('/js/js.js');?>"></script>

    <meta name="keywords" content=""/>
    
	<title><?php echo $title ?></title>
	
	<?php if (isset($description) && $description) { ?>
		<meta name="description" content="<?php echo $description ?>"/>
	<?php }?>
		
<?php if (Configuration::getInstance()->get('config.googleAnalytics.isEnabled')) { ?>
<script type="text/javascript">
</script>
<?php }?>
</head>

<body onunload="closeCurrentTab();">
<div id="megaBlock">
	
		<div id="header">
			<?php echo View::factory('element/logo') ?>
		</div>
			
		<div id="main">
			<?php echo $content ?>
		</div>
		<div class="footerPush"></div>
	</div>
 
	<div id="footer">
	</div>
	
	
<?php $render = Debugger::getInstance()->render();?>
<?php if ($render) { 
	echo '<div class="debug-panel">';
	echo $render;
	echo '</div>';
 }?>
 
</body>
</html>		