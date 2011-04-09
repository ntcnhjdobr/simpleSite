<?php if (!isset($data[0] )) {
	return;
}
?>

<?php foreach ($data as $key=>$row) 
{
	$statusClass[$row['id']] = 'style="background-color: #f5fff5"';
	if (isset($row['status'])) {
		if (!$row['status']) {
			$statusClass[$row['id']] = 'style="background-color: #fff5f5"';
		}
		unset ($data[$key]['status']);
	}
	
	if (isset($row['project_id'])) {
		$data[$key]['project_title'] = '<a href="'.Helper_Html::link(array('controller'=>'admin','action'=>'samples','param1'=>$row['project_id'])).'" 
		title="Показать работы только из этого проекта">'.$data[$key]['project_title'].'</a>';
		unset ($data[$key]['project_id']);
	}
	
	if (isset($row['section_id'])) {
		$data[$key]['section_title'] = '<a href="'.Helper_Html::link(array('controller'=>'admin','action'=>'projects','param1'=>$row['section_id'])).'"
		title="Показать проекты только из этого раздела">'.$data[$key]['section_title'].'</a>';
		unset ($data[$key]['section_id']);
	}
}
?>

<table>
 <tr>
<?php foreach ($data[0] as $column => $tmp) {
		echo "<th>{$column}</th>";
 }
 echo '<th></th>'
?>
</tr>

 <?php foreach ($data as $row) {
 	echo '<tr  '.$statusClass[$row['id']].'>';
		 foreach ($row as $key => $val) {
		 	echo "<td>";
		 	if ($key == 'img') {
		 		echo Helper_Image::render($val, Helper_Image::ADMINPREVIEW);
	 		}elseif($key == 'title' && isset($prefixUrl)){
	 			echo '<a 
	 						href="'.Helper_Html::link(array('controller'=>'admin','action'=>$prefixUrl,'param1'=>$row['id'])).'" 
	 						title="'.$prefixUrlTitle.'">
 						'.$val.'</a>';
	 		} elseif ($key == 'created' || $key == 'updated') {
	 			echo Helper_Time::relativeTime($val);
	 		} elseif ($key == 'text') {
	 			echo htmlspecialchars ($val); 
	 		}
	 		 else {
	 			echo $val;
	 		}
			echo "</td>";
		 }
		 
		 echo '<td><a href="'.Helper_Html::link(array(
		 	'controller'=>'admin',
		 	'action'=>'edit',
		 	'param1'=>$prefix,
		 	'param2'=>$row['id'])).'">edit</a>';
		 echo '<br/>';
 		 echo '<a href="'.Helper_Html::link(array(
		 	'controller'=>'admin',
		 	'action'=>'delete',
 		 	'param1' => $prefix,
		 	'param2'=>$row['id'])).'"
		 	onclick="return confirm(\'Удалять?\');"
		 	>delete</a></td>';
 	echo '</tr>';
 }?>
</table>