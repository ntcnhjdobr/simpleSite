<?php echo View::factory('element/menu/admin',array('select'=>array('controller'=>'admin','action'=>'sections')))?>

<?php echo View::factory('element/admin/buttonadd',array('title'=>'Разделы','prefixToAdd'=>'section','id'=>false));?>

<?php echo View::factory('element/tabledata',array(
	'data'=>$data,
	'prefix'=>Controller_Admin::TYPE_SECTION,
	'prefixUrl'=>Controller_Admin::TYPE_PROJECT.'s',
	'prefixUrlTitle'=>'работы в разделе'
))?>