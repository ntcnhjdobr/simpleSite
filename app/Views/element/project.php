<?php 
$resortSamples = array();
foreach ($samples as $sample){
	$resortSamples[$sample['id']]=$sample;
}

$currentSample = $samples[0];
$iframe = false;
if (isset($resortSamples[$sample_id])){
	$currentSample = $resortSamples[$sample_id];
	$iframe = Helper_Project::getIframe($currentSample['text']);
}
?>

<div class="project">
	<div class="sampleTitle">
		<?php echo $currentSample['title']; ?>
	</div>

	<div class="sampleCollection">
			<?php
			foreach ($samples as $sample) {
				$class = '';
				if ($sample['id'] == $sample_id){
					$class='select';
				}
			?>

			<a href="<?php echo Helper_Html::link(array('controller'=>'index','action'=>'project','param1'=>$sample['project_title'],'param2'=>$sample['id']));?>"
				id="<?php echo $sample['id']?>"
				class="<?php echo $class;?>">
				<?php echo Helper_Image::renderSample($sample['id'], Helper_Image::MICRO_PREV); ?>
			</a>

			<div class="container" id="desc_<?php echo $sample['id'];?>">
			<?php
				if ($sample['text'] && !$iframe){
					echo $sample['text'];
				}elseif($sample_id == $samples[0]['id'] || $iframe){
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

	<div class="image loadingBg2" title="Перейти к следующему изображению...">
		<?php
		if ($iframe) {
			echo $iframe->text;
		} ?>
	</div>

	<div class="sampleDescription">
		<?php
		if ($currentSample['text'] && !$iframe){
			echo $currentSample['text'];
		}elseif($sample_id == $samples[0]['id']){
			echo $projectCurr['text'];
		}
 		?>
	</div>
</div>

<?php
if (!$currentSample){
	$sample_id = $samples[0]['id'];
} ?>

<script type="text/javascript">
<?php if ($iframe) { ?>
		centredOverlayBlock(<?php echo $iframe->width?>, <?php echo $iframe->height?>);
<?php } else { ?>
		loadImage2('<?php echo Helper_Image::renderSample($sample_id, Helper_Image::SAMPLE, false); ?>', '.image', '<?php echo $sample_id?>');
<?php }?>
</script>