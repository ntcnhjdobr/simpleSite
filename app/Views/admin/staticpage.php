<?php echo View::factory('element/menu/admin',array('select'=>array('controller'=>'admin','action'=>'staticPage')))?>

<?php echo View::factory('element/tabledata',array(
	'data'=>$allStatic,
	'prefix'=>Controller_Admin::TYPE_STATIC,
))?>