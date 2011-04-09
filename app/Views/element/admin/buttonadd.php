<h1>
	<a  href="<?php echo Helper_Html::link(array('controller'=>'admin','action'=>'add'.ucfirst($prefixToAdd),'param1'=>$id))?>" 
		title="Добавить ещё!">
		<img src="<?php echo Helper_Html::link('/img/icons/add.png')?>" />
	</a>
	<?php echo $title?>
</h1>

<br/>
<br/>