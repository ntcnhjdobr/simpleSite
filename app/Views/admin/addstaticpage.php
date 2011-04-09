<?php echo View::factory('element/menu/admin')?>

<?php 
if ($data['id']) {
	echo '<h3>Редактирование Статической страницы №'.$data['id'].'</h3>';
}else{
	echo '<h3>Создаём новый проект</h3>';
}
?>

<form method="POST" action="<?php echo Helper_Html::link(array('controller'=>'admin','action'=>'addstaticpage'));?>">
	<input type="hidden" name="id" value="<?php echo $data['id'];?>">
	
	<div>
		<textarea name="text" onkeydown="resizeTextarea(this)"><?php echo $data['text'];?></textarea>
	</div>
	 
	<div>
		<label>&nbsp;</label>
		<input type="submit">
	</div>
</form>