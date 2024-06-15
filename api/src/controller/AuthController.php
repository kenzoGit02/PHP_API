<?php
require_once __DIR__ . '/../model/Auth.php';

class AuthController{
    private $requestMethod;
    private $queryArray;
    private $db;

    private $auth;
    public function __construct($db ,$requestMethod, $requestQueryArray)
    {
        $this->requestMethod = $requestMethod;
        $this->queryArray = $requestQueryArray;
        $this->db = $db;
        
        $this->auth = new Auth($db);

    }
    public function test(){
        // $test = $this->auth->AuthTest();
        if ($this->requestMethod) {
            // echo json_encode($this->queryArray["id"]);
            echo $this->requestMethod;
        }else{
            echo json_encode("No ID");
        }
    }
    public function ProcessRequest(){
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->queryArray["id"]) {
                    // $response = $this->getUser($this->userId);
                } else {
                    // $response = $this->getAllUsers();
                }
                break;
            case 'POST':
                // $response = $this->createUser();
                break;
            case 'PUT':
                // $response = $this->updateUser($this->userId);
                break;
            case 'DELETE':
                // $response = $this->deleteUser($this->userId);
                break;
            default:
                // $response = $this->notFoundResponse();
                break;
        }
        // header($response['status_code_header']);
        // if ($response['body']) {
        //     echo $response['body'];
        // }
    }
}