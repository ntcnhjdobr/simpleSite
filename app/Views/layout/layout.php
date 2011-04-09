<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>


	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<link rel="icon" href="<?php echo Helper_Html::link('/favicon.png')?>" />
	<link rel="shortcut icon" href="<?php echo Helper_Html::link('/favicon.ico')?>" type="image/x-icon" />
	
	<link rel="stylesheet" type="text/css" href="<?php echo Helper_Html::link('/css/css.css');?>" />
	
<?php if (Configuration::getInstance()->get('config.googleAnalytics.isEnabled')) { ?>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
<?php }else{ ?>
	<script type="text/javascript" src="<?php echo Helper_Html::link('/js/jquery-1.4.3.min.js')?>"></script>
<?php }?>
	<script type="text/javascript" src="<?php echo Helper_Html::link('/js/jquery.history.js')?>"></script>
	<script type="text/javascript" src="<?php echo Helper_Html::link('/js/js.js');?>"></script>	
	
	<script type="text/javascript" src="<?php echo Helper_Html::link('/js/ui/jquery.ui.core.js')?>"></script>
	<script type="text/javascript" src="<?php echo Helper_Html::link('/js/ui/jquery.ui.widget.js')?>"></script>
	<script type="text/javascript" src="<?php echo Helper_Html::link('/js/ui/jquery.ui.mouse.js')?>"></script>
	<script type="text/javascript" src="<?php echo Helper_Html::link('/js/ui/jquery.ui.slider.js')?>"></script>
	
	<link type="text/css" href="<?php echo Helper_Html::link('/css/jquery-ui-1.8.9.custom.css')?>" rel="stylesheet" />

<?php if (isset($keywords) && $keywords) { ?>	
	<meta name="keywords" content="<?php echo $keywords ?>"/>
<?php }?>
	<title><?php echo $title ?></title>
<?php if (isset($description) && $description) { ?>
	<meta name="description" content="<?php echo $description ?>"/>
	<?php }?>
		
<?php if (Configuration::getInstance()->get('config.googleAnalytics.isEnabled')) { ?>
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-4513568-7']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
<?php }?>
</head> 

<body class="no_js" id="body">
	<?php echo Helper_Js::getJsChecker()?>

	<div id="megaBlock">
	
	<div id="header">
		<?php echo View::factory('element/logo') ?>
		
		<div id="myslidemenu" class="jqueryslidemenu">
			<?php 
			if (isset($controller)) {
			echo View::factory('element/menu/header',
									array(
										'sections'=>$sections
									)
								);
			}?>
			<br style="clear: left" />
		</div>
		<br style="clear: both" />
	</div>
		
		
		<div id="main">
			<?php echo $content ?>
		</div>
		
	
	
		<div class="footerPush" <?php if ($_SERVER['REQUEST_URI'] !== '/') {echo 'style="height: 0px;"'; } ?>></div>
	</div>
 
	
	<?php echo View::factory('element/footer'); ?>	
	
	
<?php $render = Debugger::getInstance()->render();?>
<?php if ($render) { 
	echo '<div class="debug-panel">';
	echo $render;
	echo '</div>';
 }?>
 
</body>
</html>		