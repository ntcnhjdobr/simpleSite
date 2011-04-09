<select style="width:200px">
	<?php foreach ($sections as $section) {
			$selected = '';
			
			if($section['title'] == $sectionCurr['title']) {
				$selected = 'selected="selected"';
			}
			?>
			<option value="<?php echo $section['title']; ?>" <?php echo $selected ?>><?php echo $section['title']; ?></option>
	 <?php }?>
</select>
