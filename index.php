<?php 
try {

session_start();
require __DIR__ . '/database.php';

if (isset($_GET['page']) AND !empty($_GET['page'])) {
    $page = trim(strtolower($_GET['page'])); 
} else {
    $page = 'home';
}

$allPages = scandir('controller/');

if (in_array($page.'_controller.php', $allPages)) {

    // Inclusion des fichiers
    include_once 'controller/'.$page.'_controller.php';

} else {
    include_once 'view/404_view.php';
}

} 
catch(Exception $e) {
	var_dump($e);

}