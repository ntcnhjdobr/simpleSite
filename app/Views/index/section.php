<script type="text/javascript" src="<?php echo Helper_Html::link('/js/section.js');?>"></script>
<script type="text/javascript">
	window.tmpUrlSrc = '<?php echo Helper_Image::renderSample("TMPSAMPLEID", Helper_Image::SAMPLE, false); ?>';
</script>

<?php if($sample_id) { ?>
	<script type="text/javascript">
		loadImage2('<?php echo Helper_Image::renderSample($sample_id, Helper_Image::SAMPLE, false); ?>', '.image', '<?php echo $samples[0]['sample_id']?>');
	</script>
<?php }?>

 
<div id="overlay"></div>
<div class="overlayBlock"></div>

<div class="sliderContent">

	<div class="grad grad-right"></div>
	<div class="grad grad-left"></div>	
	 
    <div class="viewer" style="width: <?php echo count($samples)*420;?>px">    	  	
	    	<script>
	    	$(document).ready(function() {
		    	<?php foreach ($samples as $sample) { ?>    		
		    				loadImage('<?php echo Helper_Image::renderSample($sample['sample_id'], Helper_Image::PREVIEW_PROJECT, false); ?>','#<?php echo $sample['project_id']?> a');    		
		    	<?php }?>
	    	})
	    	</script>

		
		<?php foreach ($samples as $sample) { ?>		
			<div class="item" id="<?php echo $sample['project_id']?>">
		          	<a href="<?php echo Helper_Html::link(array('controller'=>'index','action'=>'project','param1'=>$sample['project_title'],'param2'=>$sample['sample_id']));?>" 
		          		title="<?php echo htmlspecialchars($sample['project_title'])?>"
		          		class="loadingBg">
		          		
		          		<?php if (!Helper_Js::isEnabledJs()) {  
		          				echo '<noscript>';
				    				echo Helper_Image::renderSample($sample['sample_id'], Helper_Image::PREVIEW_PROJECT, array('alt'=>$sample['sample_title']));
				    			echo '</noscript>';
    					}?>
		          	</a>
		          	<span><?php echo $sample['project_title']?></span>
			</div>
		<?php } ?>
		
	</div>
</div>
<div id="slider"></div>
<br/><br/><br/><br/><br/>
<h1 class="sectionTitle">
	<img src="<?php echo Helper_Html::link('/img/icons/sections/'.$sectionCurr['id'].'.png')?>" />
</h1>

