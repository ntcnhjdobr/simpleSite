<?php $menu=array(
		'Все разделы'=>array(	
			'url'=>Helper_Html::link(array('controller'=>'admin','action'=>'sections')),
		),
		'Все проекты'=>array(
			'url'=>Helper_Html::link(array('controller'=>'admin','action'=>'projects')),
		),
		'Все работы'=>array(
			'url'=>Helper_Html::link(array('controller'=>'admin','action'=>'samples')),
		),
		'Статические страницы'=>array(
			'url'=>Helper_Html::link(array('controller'=>'admin','action'=>'staticPage')),
		)
	);
?>
	<div class="adminmenu">
		<?php 
			$select = (isset($select)) ? Helper_Html::link($select) : false;
			
			foreach ($menu as $title=>$param) {
			$class = '';
			if ( $select == $param['url']) {
				$class = 'class="select"';	
			}
			echo '<span '.$class.'><a href="'.$param['url'].'">'.$title.'</a></span>';
		}?>
	</div>


