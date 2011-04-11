<?php
$prefix =  Helper_Image::render(WEBROOT_PATH.'img/startpage/TMPNAME', Helper_Image::STARTPAGE, false);
$images = array('1.jpg','2.jpg','3.jpg','4.jpg','5.jpg','6.jpg');
$dataJS = array();

foreach ($sections as $key=>$section){
	$dataJS[$key]['sectionName']=Helper_Text::clean($section['title']);
	$dataJS[$key]['aUrl']=Helper_Html::link(array('controller'=>'index','action'=>'section','param1'=>$section['title']));
	if (isset($images[$key])) {
		$dataJS[$key]['imgUrl']=str_replace('TMPNAME',$images[$key],$prefix);
	}
}
?>

<div class="startpage" style="display: none">
	<a href="<?php echo $dataJS[0]['aUrl']?>">
		<div class="rotatorCont">
			<img src="<?php echo $dataJS[0]['imgUrl']?>&w=1024&h=575" />
		</div>
		<span><?php echo $dataJS[0]['sectionName']?></span>
	</a>
</div>

<br style="clear: both" />

<script type="text/javascript">
var images = <?php echo json_encode($dataJS)?>;
window.errorCounter = 0;
window.imageCounter = 0;

$(document).ready(function() {
	$(".startpage a").hover(
			  function () {$(this).children('span').fadeTo("fast",1)},
			  function () {$(this).children('span').fadeTo("fast",0)}
	);
	showNextImage();
})
	

function showNextImage()
{
	var image = images[window.imageCounter];
	if(!image) {
		var image = images[0];
		window.imageCounter = 0;
	}
	
	var img = new Image();
    $(img).load(function ()
	{
		var imageLoading = $(this);
		$('.startpage a').attr('href',image['aUrl']);
		$('.startpage').css({width: this.width, height: this.height});

		$('.startpage').fadeOut(700,function(){
			$('.startpage span').html(image.sectionName);
			$('.rotatorCont').html(imageLoading);
			$('.startpage').fadeIn(700);
		});

		window.imageCounter++;
		setTimeout("showNextImage()", 3000);
    }).error(function () {
        window.errorCounter++;
		if (window.errorCounter < 10) {
			showNextImage();
		}
    }).attr('src', image['imgUrl']+'&w='+$(window).width()+'&h='+$(window).height());
}
</script>