<?php

class LogoutController {
	public function sessionDestroy() {
	session_start();
	session_unset ();
	unset ($_SESSION["email"]);
	session_destroy();
	header('refresh:1;url=../index.php?page=home');
	}
}


LogoutController::sessionDestroy();
?>