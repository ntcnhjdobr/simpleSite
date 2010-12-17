<?php
class Helper_Image
{
	const ADMINPREVIEW = 'adminpreview';
	const CAROUSEL = 'prev_carousel';
	const PREVIEW_PROJECT = 'prev_proj';
	const PREVIEW_SAMPLE = 'prev_sample';
	const SAMPLE = 'sample';
	
	
	static public function render ($path, $type, $atrs = array()) 
	{
		$path = '/'.str_replace(ROOT_PATH, '', $path);

		$postfix = '?type='.$type;

		if ($atrs === false) {
			return $path.$postfix;
		}
			
		$atrStr ='';
		foreach ($atrs as $key=>$atr){
			$atrStr = $atrStr.' '.$key.'="'.$atr.'"';
		}
		return '
		<img src="'.$path.$postfix.'" '.$atrStr.' />';
	}
	
	static function renderSample($sample_id, $type, $atr = array()) {
		return self::render(UPLOAD_PATH . 'sample/'.$sample_id.'.jpg', $type, $atr);
	}
}