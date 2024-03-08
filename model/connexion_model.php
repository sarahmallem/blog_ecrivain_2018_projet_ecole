<?php
include '/../database.php';

class Admin {
	private $id;
	private $login;
	private $pass;

	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id=$id;
	}
	public function getLogin() {
		return $this->login;
	}
	public function setLogin($login) {
		$this->login=$login;
	}
	public function getPass() {
		return $this->pass;
	}
	public function setPass($pass) {
		$this->pass=$pass;
	}

	public static function getWithLoginAndPass($login, $pass) {
			$bdd         = Database::getDb();
        	$requestUser = $bdd->prepare("SELECT * FROM admin WHERE email = ? AND pass = ?");
        	$requestUser->execute(array(
            $login,
            $pass
        	));
        	$data=$requestUser->fetch(PDO::FETCH_ASSOC);
        	if ($data) {
        		$result= new Admin();
        		$result->setId((int) $data["id"]); 
        		$result->setLogin($data["email"]);
        		$result->setPass($data["pass"]);
        		return $result;
        	} 
        	return null;
	}

}

?>