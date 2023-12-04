<?php

require_once "controller/routesController.php";
require_once "controller/userController.php";
require_once "controller/loginController.php";
require_once "model/userModel.php";

header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

$routesArray = explode("/", $_SERVER['REQUEST_URI']);
$endPoint = array_filter($routesArray)[2];

if ($endPoint == 'login') {
    if (isset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])) {
        $identifier = $_SERVER['PHP_AUTH_USER'];
        $key = $_SERVER['PHP_AUTH_PW'];
        
        $users = UserModel::getUsersAuth();
        
        foreach ($users as $u) {
            if ("$identifier:$key" == "{$u['us_identifier']}:{$u['us_key']}") {
                $ok = true;
                break;
            }
        }

        if ($ok ?? false) {
            (new RoutesController())->index();
        } else {
            echo json_encode(["mensaje" => "USTED NO TIENE ACCESO"], true);
        }
    } else {
        echo json_encode(["mensaje" => "ERROR EN CREDENCIALES"], true);
    }
} else {
    (new RoutesController())->index();
}
?>
