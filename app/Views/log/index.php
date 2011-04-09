<ul>
<?php
foreach ($allFiles as $file) {
	echo '<li>';
	echo '<a href="'.Helper_Html::link(array('controller'=>'log','action'=>'view','param1'=>$file['filename'])).'">'.$file['filename'].'</a> <i>'.$file['size'].'</i>';
	echo '</li>';
}
?>
</ul>



<?php if (isset($filename)) {
	echo '<h2>'.$filename.'</h2>';
}?>

<?php 
if (isset($content)) {
	echo str_replace(PHP_EOL, '<br/>', htmlspecialchars($content));
}	
?>