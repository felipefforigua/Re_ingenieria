<?php
require_once "model/ConDB.php";
class useModel{

    static public function createUser($data){
        $cantMail= self::getMail($data["use_mail"]);
        if($cantMail==0){
            $query="INSERT INTO users(use_id,use_mail,use_pss,use_dateCreate,us_identifier,us_key,us_status) VALUE(NULL,:use_mail,:use_pss,:use_dateCreate,:us_identifier,:us_key,:us_status)";
            $status ="0"; //0 -->inactivo   1-->activo
            $stament = Connection::connecction()->prepare($query);
            $stament->bindParam(":use_mail",$data["use_mail"],PDO::PARAM_STR);
            $stament->bindParam(":use_pss",$data["use_pss"],PDO::PARAM_STR);
            $stament->bindParam(":use_dateCreate",$data["use_dateCreate"],PDO::PARAM_STR);
            $stament->bindParam(":us_identifier",$data["us_identifier"],PDO::PARAM_STR);
            $stament->bindParam(":us_key",$data["us_key"],PDO::PARAM_STR);
            $stament->bindParam(":us_status",$status,PDO::PARAM_STR);
            $message = $stament->execute() ? "En ejecucion" : Connection::connecction()->errorInfo();
            $stament->closeCursor();
            $stament = null;
            $query= "";
        }else{
            $message = "Usuario ya esta registrado";
        }
        return $message;
    }

    static private function getMail($mail){
        $query="SELECT use_mail FROM users WHERE use_mail = '$mail';";
        $stament = Connection::connecction()->prepare($query);
        $stament->execute();
        $result=$stament->rowCount();
        return $result;
    }

//----------------Traer Usuarios----------------------

    static public function getUsers($id){
        $query= "";
        $id = is_numeric($id) ? $id : 0;
        $query="SELECT use_id, use_mail,use_dateCreate FROM users";
        $query.=($id> 0)? " WHERE users.use.id = '$id' AND " : "";
        $query.=($id> 0)? "us_status='1';":" WHERE us_status = '1';";
        //echo $query;
        $stament = Connection::connecction()->prepare($query);
        $stament->execute();
        $result=$stament->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    //-------------------------------LOGIN-----------------------------------------

    static public function login($data){
        $user= $data['use_mail'];
        $pss = md5($data['use_pss']);
        if(!empty($user) && !empty($pss)){
            $query= "";
            $query="SELECT us_identifier,us_key,use_id FROM users WHERE use_mail ='$user' AND use_pss='$pss' AND us_status = '1'" ;
            $stament = Connection::connecction()->prepare($query);
            $stament->execute();
            $result=$stament->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }else{
            $mensaje = array(
                "COD" => "001",
                "MENSAJE" => ("ERROR EN CREDENCIALES")
            );
            return $mensaje;
        }
    }
    static public function getUsersAuth(){
        $query ="";
        $query ="SELECT us_identifier,us_key FROM users WHERE us_status = '1';";
        $stament = Connection::connecction()->prepare($query);
        $stament->execute();
        $result=$stament->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
?>