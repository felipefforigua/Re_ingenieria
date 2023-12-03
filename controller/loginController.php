<?php
class loginController{
    private $_method;
    private $_data;

    function __construct($_method, $_data){
        $this->_method = $_method;
        $this->_data = $_data;
    }

    public function index(){
        switch($this->_method){
            case "POST":
                $credentials = useModel::login($this->_data);
                $result = [];
                if(!empty($credentials)){
                    $result["credentials"] = $credentials;
                    $result["mensaje"] = "OK";
                }else{
                    $result["credentials"] = Null;
                    $result["mensaje"] = "ERROR EN CREDENCIALES";
                    $header = "HTTP/1.1 400 FAIL";
                }
            echo json_encode($result,JSON_UNESCAPED_UNICODE);
            return;
            default:
                $json = array(
                    "ruta"=>"not found"
                );
                echo json_encode($json, true);
                return;
        }
    }
}
?>