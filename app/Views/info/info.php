<h1>Info</h1>

<div class="static-text">
	<?php echo $content['text']; ?>
</div>

<div>
	Последнее обноаление: <?php echo Helper_Time::relativeTime($content['updated']); ?>
</div>