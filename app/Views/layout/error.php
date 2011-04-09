
<div class="errorPage">
	<h1>Произошла ошибка</h1>
	<a href="/">Вернуться на главную</a><br/>
	<a href="<?php echo Helper_Html::link(array('controller'=>'info','action'=>'contact'))?>">Написать письмо</a><br/>
	<?php 
	if (Configuration::getInstance()->get('config.debugger.enabled') && $error) {
		echo '<h5>Message</h5>';
		echo '<div>'.$error->getMessage().'</div>';
		echo '<h5>File</h5>';
		echo '<div>'.$error->getFile().'</div>';
		echo '<h5>Line</h5>';
		echo '<div>'.$error->getLine().'</div>';
	};
	?>
</div>
	
