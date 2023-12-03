<?php
$rutasArray = explode("/", $_SERVER["REQUEST_URI"]);
$input = array();
$input['raw_inputs'] = @file_get_contents('php://input');
$_POST = json_decode($input['raw_inputs'],true);

if(count(array_filter($rutasArray))<2){
    $json = array(
        "ruta"=>"not found"
    );
    echo json_encode($json, true);
    return;
}else{
    $endPoint = (array_filter($rutasArray)[2]);
    $complemtent = (array_key_exists(3, $rutasArray)) ? (($rutasArray)[3]) : 0;
    $add =  (array_key_exists(4, $rutasArray)) ? (($rutasArray)[4]) : "";
    if($add != "")$complemtent .="/".$add;
    $method = $_SERVER['REQUEST_METHOD'];

    switch($endPoint){
        case 'users': 
            if (isset($_POST))
                $user = new UseController($method,$complemtent,$_POST);
            else
                $user = new UseController($method, $complemtent, 0);
                $user->index();
            break;
        case 'login':
            if(isset($_POST)&& $method == 'POST'){
                $user = new loginController($method,$_POST);
                $user->index();
            }else{
                $json = array(
                    "ruta:"=> "Not found"
                );
                echo json_encode($json,true);
                return;
            }
            break;
        default:
            $json = array(
                "ruta:"=> "Delete de user"
            );
            echo json_encode($json,true);
            return;
    }       
}
?>