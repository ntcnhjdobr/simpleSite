<?php $menu=array(
		'О себе'=>array(	
			'url'=>Helper_Html::link(array('controller'=>'info','action'=>'about')),
		),
		'Портфолио'=>array(
			'url'=>Helper_Html::link(array('controller'=>'index','action'=>'index')),
			'sections'=>array(
				array(
				'title'=>'первая секция',
				'url'=>'первая секция',
				)
			 )
		),
		'События'=>array(
			'url'=>Helper_Html::link(array('controller'=>'info','action'=>'actions')),
		),
		'Контакты'=>array(
			'url'=>Helper_Html::link(array('controller'=>'info','action'=>'contact')),
		)
	);
?>

<ul>
		<?php 	
		foreach ($menu as $title=>$param) {			
			echo '<li>'; 
			if ($title=='Портфолио') {
				echo '<span>'.$title.'</span>';
			}else{
				echo '<a href="'.$param['url'].'">'.$title.'</a>';	
			}
			
			if ($title=='Портфолио') {
					echo '<ul>';
						foreach ($sections as $section) {
							$class = (isset($section['isCurrent']) && $section['isCurrent']===true) ? 'class="sel"' : '';
							echo '<li '.$class.'>
								<a href="'.Helper_Html::link(
									array('controller'=>'index','action'=>'section','param1'=>$section['title'])).'">'.$section['title'].'
								</a>
								</li>';
						}
					echo '</ul>';
			}						
			echo '</li>';
		}?>
</ul>


