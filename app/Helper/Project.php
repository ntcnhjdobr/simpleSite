<?php
class Helper_Project {

	public static function getIframe($text){
		$defaultWidth = 560;
		$defaultHeight = 400;
		if (stripos($text, '<object') !==false || stripos($text, '<iframe') !==false) {
			$iframe = new stdClass();
			$text = preg_replace('/(width="[0-9px%]{1,7}")/iu', 'width="'.$defaultWidth.'px"', $text);
			$text = preg_replace('/(height="[0-9px%]{1,7}")/iu', 'height="'.$defaultHeight.'px"', $text);

			$iframe->text = $text;
			$iframe->width = $defaultWidth;
			$iframe->height = $defaultHeight;
			return $iframe;
		}
		return false;
	}
}