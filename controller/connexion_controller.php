<?php  
session_start();
require_once(__DIR__.'/../model/connexion_model.php');

class ConnexionController {

	public static function connexionPage () {

		$errorMessage = "";
		if (isset($_POST['submit'])) {
            $email = htmlspecialchars($_POST['email']);
            $pass  = md5($_POST['pass']);
    
    	if ((!empty($email)) && (!empty($pass))) {
    		$user=Admin::getWithLoginAndPass($email, $pass);
        if ($user != null) {
            $errorMessage = 'Vous êtes bien connecté';
            header('refresh:1;url=index.php?page=espaceadmin');
        } else {
            $errorMessage = 'Email ou mot de passe incorrect!';
        }
    } else {
        $errorMessage = 'Veuillez remplir tous les champs..';
    }
} 


		$template = file_get_contents(__DIR__.'/../view/frontend/template.html');
		$view = file_get_contents(__DIR__.'/../view/backend/connexion_view.html');
		
		$template = str_replace('{CONTENT}', $view, $template);
		$template = str_replace('{TITLE}', "Index", $template);
		$template = str_replace('{ERROR_MESSAGE}', $errorMessage, $template);
		
		print($template);
	}

}

ConnexionController::connexionPage();
