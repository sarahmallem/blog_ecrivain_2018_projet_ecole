<?php 
class Database { 
	private static $db = null; // DB A NULL 

	public static function getDb() { // if == a null connexion a la db 
		if (self::$db==null) { 
			self::$db=new PDO('mysql:host=db5000116774.hosting-data.io;dbname=dbs111386;charset=utf8', 'dbu194439', 'Sma*2019!');
		}
		return self::$db; 
	} 

	// Construct en private pour empecher le new database ( l'instance )
	private function __construct() {}
}

?>