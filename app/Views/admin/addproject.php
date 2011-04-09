<?php echo View::factory('element/menu/admin')?>

<?php 
if ($data['id']) {
	echo '<h3>Редактирование проекта №'.$data['id'].' "'.$data['title'].'"</h3>';
}else{
	echo '<h3>Создаём новый проект</h3>';
}
?>
<form method="POST" enctype="multipart/form-data" action="<?php echo Helper_Html::link(array('controller'=>'admin','action'=>'addproject'));?>">
	<input type="hidden" name="id" value="<?php echo $data['id'];?>">
	<div>
		<label>Проект:</label>
		<select name="section_id">
		<?php  foreach ($sections as $section) {
			$selected = ($section['id'] == $data['section_id']) ? ' selected="selected"' : '';
			echo '<option value="'.$section['id'].'" '.$selected.'>'.$section['title'].' ('.$section['text'].')';
		} ?>
		</select>
	</div>
	
	<div>
		<label>Вкл/Выкл</label>
		<input type="checkbox" name="status" <?php if ($data['status']) {echo 'checked="checked"';}?> >
	</div>
	
	<div>
		<label>Название:</label>
		<input type="text" name="title" value="<?php echo $data['title'];?>">
	</div>
	 
	<div>
		<label>Комментарии:</label> 
		<textarea name="text" onkeydown="resizeTextarea(this)"><?php echo $data['text'];?></textarea>
	</div>
	 
	<div>
		<label>&nbsp;</label>
		<input type="submit">
	</div>
</form>