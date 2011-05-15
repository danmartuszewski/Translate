<?php 


class Translator
{
	
	private static $DB;
	
	function __construct(DB $db) {
		self::$DB = $db;
	}
	
	private function store($text, $translation, $translationLang) {
		if(self::$DB->store(md5($text), $translation, $translationLang))
			return true;
		return false;
	}
	
	
	public function translate($text, $from = 'pl', $to = 'en') {
		$text = strtolower(strip_tags($text));
		
		// if it was stored in DB
		if($res = self::$DB->getTranslated(md5($text), $to)) {
			return $res;
		}
		
		$url = 'http://ajax.googleapis.com/ajax/services/language/translate';
		$url .= '?v=1.0&q='.rawurlencode($text).'&langpair='.rawurlencode($from.'|'.$to);
		
		$json = file_get_contents($url);
		$json = json_decode($json, true);
		
		$translation = $json['responseData']['translatedText'];
		
		$this->store($text, $translation, $to);
		
		return $translation;
	}
}
