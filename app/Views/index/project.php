
    
<div class="staticContainer">
<div class="projectText">
		<a href="<?php echo Helper_Html::link(array('controller'=>'index','action'=>'project','param1'=>$pagination['prev'][0]['title'])); ?>" 
			title="Предыдущий проект Ctrl &larr;" 
			class="prev"
		>
			<span></span>
			<!-- <b>Ctrl+&larr;</b> -->
		</a>
			
		<a href="<?php echo Helper_Html::link(array('controller'=>'index','action'=>'project','param1'=>$pagination['next'][0]['title'])); ?>"
			title="Следующий проект Ctrl &rarr;" 
			class="next" 
		>
			<span></span>
			<!-- <b>Ctrl+&rarr;</b> -->
		</a>
		
		<h1><?php echo Helper_Text::clean($projectCurr['title'])?></h1>
		<p><?php echo Helper_Text::clean($projectCurr['text']); ?></p>
</div>
	
	

<!--  start block preView sample  -->

<div class="preViewSample">

	<?php $formatTextSample = '<b>%s</b>.&nbsp;%s';  ?>
	
	<?php foreach ($samples as $key => $sample) {
			$alt = '';
			if ($sample['title']) {
				$alt = $sample['title'];
			} ?>
	
          	<a href="<?php echo Helper_Html::link(array('controller'=>'index','action'=>'project','param1'=>$sample['project_title'],'param2'=>$sample['id']))?>" 
          	id="<?php echo $sample['id'] ?>"
          	class="samplepreview <?php if ($sapmlesCurrentArrayId == $key) {echo ' currentSample';}?>"
          	title="<?php echo Helper_Text::clean($alt); ?>"
          	>
          		<?php echo Helper_Image::renderSample($sample['id'], Helper_Image::PREVIEW_SAMPLE, array('alt'=>$alt)); ?>
          	</a>
          	
	<?php } ?>
</div>
<!-- end block preView sample  -->


<div class="mainContent">
    <div>
    	<?php
    	if (isset($samples[$sapmlesCurrentArrayId]['id'])) {

    		$alt = '';
			if ($samples[$sapmlesCurrentArrayId]['title']) {
				$alt = Helper_Text::clean($samples[$sapmlesCurrentArrayId]['title']);
			}
			
    		echo Helper_Image::renderSample(
    				$samples[$sapmlesCurrentArrayId]['id'], 
    				Helper_Image::SAMPLE, 
    				array('alt'=>$alt,
    					  'title'=>$alt));
    	} ?>    	
    </div>
    
    <div class="sampleText">
    	<?php if (isset($samples[$sapmlesCurrentArrayId]['id']) && $samples[$sapmlesCurrentArrayId]['title']) {
	    			echo sprintf($formatTextSample, 
	    					Helper_Text::clean($samples[$sapmlesCurrentArrayId]['title']),
	    					Helper_Text::clean($samples[$sapmlesCurrentArrayId]['text']));
    	} ?>
    </div>
    
</div>
</div>
<br style="clear:both" /> 
