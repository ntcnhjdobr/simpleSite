<div style="text-align: center; margin: 10px 0; border: 2px solid grey; padding: 10px">
	
	<?php foreach ($sections as $section) { ?>
		<span style="padding: 0 10px">
					<?php if ($sectionCurr['id'] == $section['id']){
				echo '<b>'.$section['title'].'</b>';
			}else{ ?>
				<a href="<?php echo Helper_Html::link(array('controller'=>'index','action'=>'section','param1'=>$section['title']));?>">
					<?php echo $section['title']; ?>
				</a>				
			<?php }?>
		</span>
	 <?php }?>

</div>

