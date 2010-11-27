<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="icon" href="/favicon.ico" />
	<link rel="shortcut icon" href="/favicon.ico" />
	
	<link rel="stylesheet" type="text/css" href="/css/css.css" />	

	<script type="text/javascript" src="/js/jquery-1.4.3.min.js"></script>
	<script type="text/javascript" src="/js/js.js"></script>

    <meta name="keywords" content=""/>
	<title><?php echo $title ?></title>	

	
<?php if (Configuration::getInstance()->get('config.googleAnalytics.isEnabled')) { ?>
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-4513568-6']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
<?php }?>

</head>
<body>

<div id="header">
	<span class="logo">
		<a href="<?php echo Helper_Html::link(array('controller'=>'home','action'=>'news'));?>" title="библиотека для управления изображениями на сайте">
			PhpResizer</a>
	</span>
	
	<div class="download-panel">
		<a class="download-button" onclick="_gaq.push(['_trackEvent', 'download', 'tar']);" title="download library PhpResizer" href="<?php echo Helper_Html::link(array('controller'=>'download','action'=>'index'));?>">
			<b>Download</b> pack
		</a><br/>
		<a class="download-button" onclick="_gaq.push(['_trackEvent', 'download', 'svn']);" title="view  SVN repository  PhpResizer" href="http://PhpResizer.googlecode.com/svn/trunk/">
			View SVN repository
		</a>
	</div>
	
</div>
			
	
<div id="main">
	<?php echo $content ?>
</div>
				
<div id="footer">
	<a href="<?php echo Helper_Html::link(array('controller'=>'home','action'=>'email'))?>">Письмо администратору</a>
</div>
	
	
		<?php $render = Debugger::getInstance()->render();?>
		<?php if ($render) { 
			echo '<div class="debug-panel">';
			echo $render;
			echo '</div>';
		 }?>
</body>
</html>

			