<?php

namespace api\src\controller;

require_once __DIR__ . '/../model/User.php';

use api\src\interface\ResourceController;
use api\src\model\User;
use api\src\services\AuthChecker;

class UserController implements ResourceController{

    private $extraArgument;
    private $User;
    
    public function __construct(private $db, private string $requestMethod, private string|null $id , ...$extraArgument) 
    {

        $this->extraArgument = $extraArgument;
        $this->User = new User($db);

    }
    

    public function test(): void
    {
        AuthChecker::authenticate();
        // echo json_encode([$this->db, $this->requestMethod, $this->id, $this->User, $this->extraArgument]);
        // echo "Test";
        exit("exit");
    }

    public function processRequest(): void
    {
        AuthChecker::authenticate();

        $UserID = $this->id ?? null;

        switch ($this->requestMethod) {
            case 'GET':
                if (empty($UserID)) {
                    $response = $this->index();
                } else {
                    $response = $this->index($UserID);
                }
                break;
            case 'POST':
                $response = $this->create();
                break;
            case 'PUT':
                $response = $this->updateUser($UserID);
                break;
            case 'DELETE':
                $response = $this->deleteUser($UserID);
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }

        if(!isset($response['status_code_header'])){
            exit;
        }

        http_response_code($response['status_code_header']);

        if ($response['body']) {
            echo $response['body'];
            exit;
        }
    }
    
    public function index($request = null)
    {
        if(isset($request)){
            $this->User->id = $request;
            $UserData = $this->User->selectSingle();
        } else {
            $UserData = $this->User->select();
        }
        return $this->okResponse($UserData);
    }

    private function create() {
        // $input = (array) json_decode(file_get_contents('php://input'), true);
        // if (!$this->validateUser($input)) {
        //     return $this->unprocessableEntityResponse();
        // }

        // $this->user->username = $input['username'];
        // $this->user->password = $input['password'];

        // if ($this->user->create()) {
        //     return $this->createdResponse();
        // }

        // return $this->unprocessableEntityResponse();
    }

    private function updateUser($id) {
        $input = (array) json_decode(file_get_contents('php://input'), true);
        if (!$this->validateUser($input)) {
            return $this->unprocessableEntityResponse();
        }

        $this->User->id = $id;
        $this->User->username = $input['username'];
        $this->User->password = $input['password'];

        if ($this->User->update()) {
            return $this->okResponse(null);
        }

        return $this->unprocessableEntityResponse();
    }

    private function deleteUser($id) {
        $this->User->id = $id;

        if ($this->User->delete()) {
            return $this->okResponse(null);
        }

        return $this->unprocessableEntityResponse();
    }

    private function validateUser($input) {
        return isset($input['username']) && isset($input['password']);
    }

    private function okResponse($data) {
        $response['status_code_header'] = 200;
        $response['body'] = json_encode($data);
        return $response;
    }

    private function createdResponse() {
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = null;
        return $response;
    }

    private function unprocessableEntityResponse() {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);
        return $response;
    }

    private function notFoundResponse() {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = json_encode([
            'error' => 'Not found'
        ]);
        return $response;
    }
}
