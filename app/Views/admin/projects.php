<?php echo View::factory('element/menu/admin',array('select'=>array('controller'=>'admin','action'=>'projects')))?>


<?php 
$title = 'Проекты';
$currentSection = false;
if ($isOneEntity && isset($data[0]['section_title'])) {
	$title.=' из раздела "'.$data[0]['section_title'].'"';
	$currentSection = $data[0]['section_id'];
}

echo View::factory('element/admin/buttonadd',array('title'=>$title,'prefixToAdd'=>'project', 'id'=>$currentSection));?>


<?php echo View::factory('element/tabledata',array(
	'data'=>$data,
	'prefix'=>Controller_Admin::TYPE_PROJECT,
	'prefixUrl'=>Controller_Admin::TYPE_SAMPLE.'s',
	'prefixUrlTitle'=>'работы в проекте'
))?>

