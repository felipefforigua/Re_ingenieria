<?php
require_once "controller/routeController.php";
require_once "controller/useController.php";
require_once "controller/loginController.php";
require_once "model/useModel.php";


header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('Access-Control-Allow-Headers: Authorization');
$rutasArray = explode("/", $_SERVER["REQUEST_URI"]);
$endPoint = (array_filter($rutasArray)[2]);

// if($endPoint!='login'){
//     if(isset($_SERVER['PHP_AUTH_USER'])&&(isset($_SERVER['PHP_AUTH_PW']))){
//         $ok = false;
//         $indetifier = $_SERVER['PHP_AUTH_USER'];
//         $key = $_SERVER['PHP_AUTH_PW'];
//         $users = useModel::getUsersAuth();
//         foreach($users as $u){
//             if($indetifier.":".$key == $u["us_identifier"].":".$u["us_key"]){
//                 $ok = true;
//             }
//         }
//         if(!$ok){    
//         $routes = new RoutesController();
//         $routes->index();
//         }else{
//             $result["mensaje"] = "USTED NO TIENE ACCESO";
//             echo json_encode($result,true);
//             return;
//         }
//     }else{
//         $result["mensaje"] = "ERROR EN CREDENCIALES";
//         echo json_encode($result,true);
//         return;
//         }
//     }
// else{
//         $routes = new RoutesController();
//         $routes->index();
// }

$routes = new RoutesController();
        $routes->index();
?>