<?php
class Helper_Image
{
	const ADMINPREVIEW = 'adminpreview';
	const STARTPAGE = 'startpage';
	const PREVIEW_PROJECT = 'prev_proj';
	const PREVIEW_SAMPLE = 'prev_sample';
	const SAMPLE = 'sample';
	const MICRO_PREV = 'micro_pre';
	
	
	static public function render ($path, $type, $atrs = array())
	{
		$path = '/'.str_replace(ROOT_PATH, '', $path);

		$prefix = '/app/webroot/images.php?file=';
		$postfix = '&type='.$type;

		if ($atrs === false) {
			return $prefix.$path.$postfix;
		}
			
		$atrStr ='';
		foreach ($atrs as $key=>$atr){
			$atrStr = $atrStr.' '.$key.'="'.htmlspecialchars($atr).'"';
		}

		return  '<img src="'.$prefix.$path.$postfix.'" '.$atrStr.' />';
		//'<img src="'.Helper_Html::link($path.$postfix).'" '.$atrStr.' />';
	}
	
	static function renderSample($sample_id, $type, $atr = array()) {
		return self::render(UPLOAD_PATH . 'sample/'.$sample_id.'.jpg', $type, $atr);
	}
}