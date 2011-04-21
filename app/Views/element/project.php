<?php 
$resortSamples = array();
foreach ($samples as $sample){
	$resortSamples[$sample['id']]=$sample;
}
?>
<div class="project">
	
	<div class="sampleTitle">	
		<?php 
			if (isset($resortSamples[$sample_id])){
				echo $resortSamples[$sample_id]['title'];	
			}else{
				echo $samples[0]['title'];
			}
 		?>
	</div>	
	
	<div class="sampleCollection">		
		<?php
			$flag = !isset($resortSamples[$sample_id]);
			
			foreach ($samples as $sample) {

				if ($flag) {
					$class = 'select';
					$flag = false;
				}else{
					$class = '';
					if ($sample['id'] == $sample_id){
						$class='select';
					}
				}
		?>
			
			<a href="<?php echo Helper_Html::link(array('controller'=>'index','action'=>'project','param1'=>$sample['project_title'],'param2'=>$sample['id']));?>" id="<?php echo $sample['id']?>" class="<?php echo $class;?>"><?php echo Helper_Image::renderSample($sample['id'], Helper_Image::MICRO_PREV); ?></a>
			
			<div class="container" id="desc_<?php echo $sample['id'];?>">
			<?php
				if ($sample['text']){
					echo $sample['text'];
				}elseif($sample_id == $samples[0]['id']){
					echo $projectCurr['text'];
				}
			?>

			</div>
			<div class="container" id="title_<?php echo $sample['id'];?>">
				<?php echo $sample['title']?>
			</div>
		<?php }?>
	 	&nbsp;
	</div>

	<div class="image loadingBg2" title="Перейти к следующему изображению...">&nbsp;</div>

	<div class="sampleDescription">
		<?php
		if (isset($resortSamples[$sample_id]) && $resortSamples[$sample_id]['text']){
			echo $resortSamples[$sample_id]['text'];
		}elseif($sample_id == $samples[0]['id']){
			echo $projectCurr['text'];
		}
 		?>
	</div>
</div>

<?php
if (!isset($resortSamples[$sample_id])){
	$sample_id = $samples[0]['id'];
} ?>

<script type="text/javascript">
	loadImage2('<?php echo Helper_Image::renderSample($sample_id, Helper_Image::SAMPLE, false); ?>', '.image', '<?php echo $sample_id?>');		
</script>