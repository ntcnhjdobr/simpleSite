<div class="projectsMenu"><?php foreach ($sections as $section) {
	$sectionClass = ($section['title'] == $sectionCurr['title']) ? 'current' : ''; ?>

<a class="<?php echo $sectionClass?>"
	href="<?php echo Helper_Html::link(array('controller'=>'index','action'=>'section','param1'=>$section['title']));?>">
	<?php echo $section['title']; ?> </a> <?php if ($sectionClass) { ?>
<ul>
<?php foreach ($projects as $project) { ?>
	<?php if ($project['count']) {?>
		<li><?php $projectClass = ($projectCurr && $projectCurr['id'] == $project['id']) ? 'current' : ''; ?>
		<a class="<?php echo $projectClass?>"
			href="<?php echo Helper_Html::link(array('controller'=>'index','action'=>'project','param1'=>$project['title']));?>">
			<?php echo $project['title'].' <span>('.$project['count'].')</span>'; ?>
		</a>
		</li>
		<?php }?>
	<?php }?>
</ul>
<?php }?> <?php }?></div>

