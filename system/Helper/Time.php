<?php
class Helper_Time {
	static public function relativeTime($timeStr) {
		$currentTime = time();
		$time = strtotime($timeStr);
		
		$diffTimeSeconds = ($currentTime - $time);

		$daysAgo = round($diffTimeSeconds/(60*60*24),1);
		
		$relativeTime = $daysAgo.' дн. назад';
	
		return $relativeTime;
	}
}