<?php
    class useController{
        private $_method;
        private $_complement;
        private $_data;

        function __construct($method, $complement, $data){
            $this->_method = $method;
            $this->_complement = $complement == null ? 0: $complement;
            $this->_data= $data != 0 ? $data : "" ;  
        }

        public function index(){
            switch($this->_method){
                case "GET":
                    if($this->_complement == 0){
                        $user = useModel::getUsers(0);
                        $json= $user;
                        echo json_encode($json,true);
                        return;
                    }else{
                        $user = useModel::getUsers($this->_complement);
                        $json= $user;
                        echo json_encode($json,true);
                        return;
                    }
                case "POST":
                    $craeateUser = useModel::createUser($this->generateSalting());
                    $json = array(
                        "response:"=> $craeateUser
                    );
                echo json_encode($json,true);
                return;
                case "UPDATE":
                    return;
                case "DELETE":
                    return;
                default:
                    $json = array(
                        "ruta:"=> "Delete user"
                    );
                    echo json_encode($json,true);
                    return;
        }
    }
    private function generateSalting(){
        $trimmedData = "";
        if($this->_data != "" || (!empty($this->_data))) {
            $trimmedData = array_map('trim',$this->_data);
            $trimmedData['use_pss'] = md5($trimmedData['use_pss']);
            //--GENERANDO SOLTING PARA CREDENCIALES
            $identifier = str_replace("$","ue3",crypt($trimmedData["use_mail"],"ue56"));
            $key = str_replace("$","ue2023",crypt($trimmedData["use_mail"],"56ue"));
            $trimmedData["us_identifier"] = $identifier;
            $trimmedData["us_key"] = $key;
            return $trimmedData;
        }
    }
}
?>