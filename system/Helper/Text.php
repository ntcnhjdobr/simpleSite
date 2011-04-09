<?php
class Helper_Text {
	static public function clean ($text, array $inputOptions=array())
	{
		$text = htmlspecialchars($text);
		return $text;
	}
}