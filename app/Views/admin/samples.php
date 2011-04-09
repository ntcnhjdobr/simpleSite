<?php echo View::factory('element/menu/admin',array('select'=>array('controller'=>'admin','action'=>'samples')))?>


<?php 
$title = 'Работы';
$currentId = false;
if ($isOneEntity && isset($data[0]['project_title'])) {
	$title.=' из проекта "'.$data[0]['project_title'].'"';
	$currentId = $data[0]['project_id'];
}

 echo View::factory('element/admin/buttonadd',array('title'=>$title, 'prefixToAdd'=>'sample', 'id'=>$currentProjectId));?>

<?php echo View::factory('element/tabledata',array('data'=>$data,'prefix'=>Controller_Admin::TYPE_SAMPLE))?>