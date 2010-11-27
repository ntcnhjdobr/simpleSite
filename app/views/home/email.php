
<?php echo View::factory('element/menu',array('select'=>array()))?>

<div id="content">
	<h4>Письмо администрации</h4>
	<?php if (isset($status) && true === $status) { ?>
		<div class="send-ok">Успешно отправлено</div>
	<?php }?>
<form method="POST" class="contact">
<textarea name="text"></textarea>
<input type="submit" value="Отправить" onclick="this.disabled=true;"/>
</form>
</div>	
