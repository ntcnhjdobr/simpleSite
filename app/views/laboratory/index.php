<?php echo View::factory('element/menu',array('select'=>array('controller'=>'laboratory')))?>
<div id="content">

<div class="download-form">
	<form method="POST" action="/laboratory/upload" enctype="multipart/form-data" >
		<input type="file" name="image" />
		<input type="submit" value="Загрузить" />
	</form>
</div>


<div style="display: none">
	<span id="filename"><?php echo $filename ?></span>
</div>

<div class="laboratory">
	<span>Ширина:</span><input id="width" type="text" value="100"> не более 500 px<br/>
	<span>Высота:</span><input id="height" type="text" value="100"> не более 500 px<br/>
	<span>Сохранять пропорции:</span><input id="aspect" type="checkbox" checked /><br/>
	<span>Увеличить центр:</span><input id="crop" type="text" value="100" />% не более 100<br/>
	<span>&nbsp;</span><button id="resize-btn" onclick="_gaq.push(['_trackEvent', 'button', 'resize']);">Resize!</button>
</div>

<div id="wait" >Wait...</div>


<div class="sample">
	<img src="" id="sample" style="border: 1px solid blue;"/>
</div>


<div class="links">
	<span>Original image</span>:&nbsp;<a href="<?php echo $filename; ?>?type=laboratory"><?php echo $filename?>?type=laboratory</a><br/>
	<span>Resized image</span>:&nbsp;<a id="resize-link"  href="<?php echo $filename;?>"><?php echo $filename?></a>
</div>


<script>

setPreview();

$('#resize-btn').live('click', function(event){
	setPreview();
});

$('#width, #height, #crop, #aspect').live('change', function(event){
	setPreview();
});

function setPreview () {	
	$('#wait').show();
	$('#resize-link').show();
	
	var filename = $('#filename').html();
	var width = $('#width').attr('value');
	var height = $('#height').attr('value');
	var crop = $('#crop').attr('value');
	var aspect = $('#aspect').attr('checked');

	url = filename+'?type=laboratory'+'&width='+width+'&height='+height+'&crop='+crop+'&aspect='+aspect

	$('#resize-link').html(url);
	$('#resize-link').attr('href',url);
	
	$('#sample').attr('src',url);
	$('#wait').hide();
}
</script>


</div>