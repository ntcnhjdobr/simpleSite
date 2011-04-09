<style>
<!--

.startpage {min-height: 350px;}

.startpage a {
	display: block;
 	float: left;
	text-decoration: none;
	padding: 10px;	
	position: absolute;
	top: 180px;
}

a.block_0 {		
	left: 200px; 	
}

a.block_1 {
	left: 400px; 	
}

a.block_2 {		
	left: 600px; 	
}

a.block_3 {
	top: 300px;
	left: 200px; 	
}
a.block_4 {
	top: 300px;
	left: 400px; 	
}
a.block_5 {
	top: 300px;
	left: 600px; 	
}

.startpage a span {
	display: block;
	position: relative;
	bottom: 20px;
	background: url('/app/webroot/img/icons/black50.png');
	color: white;
	text-align: center;
	z-index: 1000;
 	 opacity: 0;
  	filter: alpha(opacity=0);
  	-moz-opacity: 0;
}
-->
</style>

<?php 
$prefix = Helper_Html::link('/img/startpage/');
$images = array(
	array('1_1.jpg','1_2.jpg'),
	array('2_1.jpg','2_2.jpg'),
	array('3_1.jpg','3_2.jpg'),
	array('4_1.jpg','4_2.jpg'),
	array('5_1.jpg','5_2.jpg'),
	array('6_1.jpg','6_2.jpg'),
);
foreach ($images as &$image) {
	foreach ($image as &$path){
			$path=$prefix.$path;
	}
}
?>
<script type="text/javascript">
<!--
var images = <?php echo json_encode($images)?>;

$(document).ready(function() {
	$(".startpage a").hover(
			  function () {$(this).children('span').fadeTo("fast",1)},
			  function () {$(this).children('span').fadeTo("fast",0)}
	);
	setTimeout("rotateImage()", 1000);
})


function rotateImage() {
	getSectionForRotate(); 
}

function getSectionForRotate() {
	
	window.newSection = Math.round(<?php echo count($sections)-1;?> * Math.random());	

	if (window.section == window.newSection)
	{
		console.info('e');
		if (!window.error) {
			window.error=0;
		}
		window.error++;
		if (window.error>50){
			console.info('stop');
			return false;
		}
		
		return getSectionForRotate();
	}
		
	setTimeout("rotateImage()", 300);
	
	var index = Math.round(Math.random() * images[window.newSection].length);
	var path = images[window.newSection][index]; 	
	
	showImage(window.newSection, images[window.newSection][index]);		
}

function showImage(id, path){

	var block = $('.startpage a.block_'+id+' .rotatorCont')
	
		var img = new Image();
	    $(img).load(function () {		    
	    	window.section = id;
			var imageLoading = $(this);	   	
	    	$(block).html(imageLoading);    			    						    

	    }).error(function () {
			alert('не загрузилась');
	    }).attr('src', path);	    
}


</script>

<?php $blockImage = array_slice($block, 0, count($block)/2); ?>

<div class="startpage">

	<?php 
	
	for ($i=0; $i<count($sections); $i++) { ?>	
		<a class="block_<?php echo $i; ?>"		
			href="<?php echo Helper_Html::link(			
				array('controller'=>'index','action'=>'section','param1'=>$sections[$i]['title']));?>">
			<?php //echo Helper_Image::renderSample($sample['sample_id'], Helper_Image::CAROUSEL, array('alt'=>$sample['project_title'])); ?>
			<div class="rotatorCont">
				<img src="<?php echo $images[$i][array_rand($images[$i])];?>" />
			</div>			
			<span><?php echo $sections[$i]['title']?></span>
		</a>	
	<?php
	}?>
</div>

<br style="clear: both" />

