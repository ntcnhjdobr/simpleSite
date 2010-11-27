<?php $menu=array(
		'Новости'=>array(	
			'url'=>Helper_Html::link(array('controller'=>'home','action'=>'news')),
			'style'=>'padding-left: 10px; background-image: none'
		),
		'Документация'=>array(
			'url'=>Helper_Html::link(array('controller'=>'home','action'=>'manual')),
			'style'=>'background-image: url(/img/icons/manual.png?type=web);'
		),
		'Лаборатория'=>array(
			'url'=>Helper_Html::link(array('controller'=>'laboratory')),
			'style'=>'background-image: url(/img/icons/lab.png?type=web);'
		)
	);
?>
	
	<div class="menu">
		<?php 
			$select = Helper_Html::link($select);
			foreach ($menu as $title=>$param) {
			if ( $select == $param['url']) {
				echo '<span class="select" style="'.$param['style'].'">'.$title.'</span>';	
			}else{
				echo '<span style="'.$param['style'].'"><a href="'.$param['url'].'">'.$title.'</a></span>';
			}
		}?>
	</div>


