<?php
class Helper_Js {
	
	const COOKIE_VAR_CHECK = 'test_js';
	
	static public function isEnabledJs() {
		return isset($_COOKIE[self::COOKIE_VAR_CHECK]);
	}
	
	static public function getJsChecker () {
		return "
		<script type=\"text/javascript\">
			var body = document.getElementById('body');
			if (body){body.className = '';}		
			if (!getCookie('".self::COOKIE_VAR_CHECK."')) {
				setCookie('".self::COOKIE_VAR_CHECK."','1',120,'/');	
			}
		</script>
		";		
	}
	
}