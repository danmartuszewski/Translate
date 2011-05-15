<?php 

	set_error_handler('errorHandler', E_ALL);

	header('Content-type: text/plain');
	
	require_once 'Settings.php';
	require_once 'DB.php';
	require_once 'Translator.php';
	
	$text = htmlentities(trim($_POST['text']), ENT_QUOTES, 'utf-8');
	$from = htmlentities(strip_tags(trim($_POST['langFrom'])), ENT_QUOTES, 'utf-8');
	$to = htmlentities(strip_tags(trim($_POST['langTo'])), ENT_QUOTES, 'utf-8');
	
	if(strlen($text) < 1) return;
	
	$translator = new Translator(new DB);
	
	echo $translator->translate($text, $from, $to);


	function errorHandler($errNo, $errStr, $errFile, $errLine) {
		if(ob_get_length()) ob_get_clean();
		
		$errorMsg = 'DATE: ' . date() 
				. 'ERRNO: ' . $errNo . chr(10)
				. 'ERROR: ' . $errStr . chr(10)
				. 'FILE: ' . $errFile . chr(10)
				. 'LINE: ' . $errLine . chr(10);
				
				
		file_put_contents('log.txt', $errorMsg, FILE_APPEND);
		
		exit;
	}
?>