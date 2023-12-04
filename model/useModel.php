<?php

class UserController {
    private $method;
    private $complement;
    private $data;

    public function __construct($method, $complement, $data) {
        $this->method = $method;
        $this->complement = $complement ?? 0;
        $this->data = $data ?? [];
    }

    public function handleRequest() {
        switch ($this->method) {
            case "GET":
                $this->handleGetRequest();
                break;
            case "POST":
                $this->handlePostRequest();
                break;
            case "UPDATE":
                $this->handleUpdateRequest();
                break;
            case "DELETE":
                $this->handleDeleteRequest();
                break;
            default:
                $this->respondWithJson(["message" => "Invalid method"]);
        }
    }

    private function handleGetRequest() {
        $json = useModel::getUsers($this->complement);
        $this->respondWithJson($json);
    }

    private function handlePostRequest() {
        $createdUser = useModel::createUser($this->generateSalting());
        $this->respondWithJson(["response" => $createdUser]);
    }

    private function handleUpdateRequest() {
        $this->respondWithJson(["message" => "Update not implemented"]);
    }

    private function handleDeleteRequest() {
        $this->respondWithJson(["message" => "Delete not implemented"]);
    }

    private function generateSalting() {
        $trimmedData = array_map('trim', $this->data);
        $trimmedData['use_pss'] = md5($trimmedData['use_pss']);
        $trimmedData["us_identifier"] = str_replace("$", "ue3", crypt($trimmedData["use_mail"], "ue56"));
        $trimmedData["us_key"] = str_replace("$", "ue2023", crypt($trimmedData["use_mail"], "56ue"));
        return $trimmedData;
    }

    private function respondWithJson($data) {
        echo json_encode($data, true);
        exit;
    }
}

// Ejemplo de uso:
$method = $_SERVER['REQUEST_METHOD'];
$complement = $_GET['complement'] ?? 0;
$data = $_POST; // Ajusta según cómo recibas los datos en tu aplicación

$userController = new UserController($method, $complement, $data);
$userController->handleRequest();
