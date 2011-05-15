<?php 

class DB extends PDO
{
	
	function __construct() {
		
		try {
			parent::__construct('mysql:dbname='.Settings::$DB_NAME.';host='.Settings::$DB_HOST, Settings::$DB_USER, Settings::$DB_PASS);
			parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch(PDOException $e) {
			exit('Error while connecting to database: <br />');
		}
	}
	
	
	public function store($md5, $translate, $lang) {
		$sql = 'INSERT INTO translated VALUES(NULL, :md5, :translate, :lang, NULL)';
		$stmt = parent::prepare($sql);
		$stmt->execute(array(':md5' => $md5, ':translate' => $translate, ':lang' => $lang));
		
		$rC = $stmt->rowCount();
		$stmt->closeCursor();
		if($rC == 1)
			return True;
		
		return False;
	}
	
	
	public function getTranslated($md5, $lang) {
		$sql = 'SELECT translate FROM translated WHERE md5 = :md5 AND lang = :lang';
		$stmt = parent::prepare($sql);
		$stmt->bindParam(':md5', $md5, PDO::PARAM_STR);
		$stmt->bindParam(':lang', $lang, PDO::PARAM_STR);
		$stmt->execute();
		
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		$stmt->closeCursor();
		
		if(isset($result[0]['translate']))
			return $result[0]['translate'];

		return false;
	}
	
}