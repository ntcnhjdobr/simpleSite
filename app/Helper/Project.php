<?php
class Helper_Project {

	public static function getIframe($text){
		if (stripos($text, '<iframe') !==false) {
			$iframe = new stdClass();
			$iframe->text = $text;
			$iframe->width = 560;
			$iframe->height = 349;
			return $iframe;
		}
		return false;
	}
}