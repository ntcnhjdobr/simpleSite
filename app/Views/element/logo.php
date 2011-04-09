<?php if ($_SERVER['REQUEST_URI'] == '/') {
	$prefix = '<span class="logo" title="Брусничка">';
	$posfix = '</span>';
}else{
	$prefix = '<a href="'.Helper_Html::link('').'" class="logo" title="Брусничка">';
	$posfix = '</a>';
}?>


<?php echo $prefix ?>
				<!--<img src="<?php echo Helper_Html::link('/img/icons/logo.png')?>" />
				 <span>Личный сайт Брусникиной Анны</span> -->
<?php echo $posfix ?>