<?php
class Helper_Project {

	public static function getIframe($text){
		if (stripos($text, '<object') !==false || stripos($text, '<iframe') !==false) {
			$iframe = new stdClass();
			$text = preg_replace('/(width="[0-9px%]")/iu', 'width="550px"', $text);
			
			$iframe->text = $text;
			$iframe->width = 607;
			$iframe->height = 360;
			return $iframe;
		}
		return false;
	}
}