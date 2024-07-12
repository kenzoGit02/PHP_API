<?php

namespace api\src\controller;

require_once '../vendor/autoload.php';

// use Firebase\JWT\JWT;
use api\src\model\Login;
use api\src\services\Auth;
class LoginController
{
    private $extraArgument;
    private $Login;

    public function __construct(private $db, private $requestMethod, private $id , ...$extraArgument)
    {
        $this->extraArgument = $extraArgument;
        $this->Login = new Login($db);
    }

    public function test(): void
    {

        if ($this->requestMethod) {

            echo json_encode([
                $this->requestMethod, 
                $this->db, 
                $this->extraArgument, 
                $this->Login]);
            var_dump($this->Login);
            exit;
        }else{

            echo json_encode("No ID");
            exit;
        }
    }

    public function processRequest(): void
    {

        switch ($this->requestMethod) {
            case 'POST':
                $response = $this->loginUser();
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }

        if(!isset($response['status_code_header'])){
            http_response_code(500);
            exit;
        }

        http_response_code($response['status_code_header']);

        if ($response['body']) {
            echo $response['body'];
        }

    }

    private function loginUser(): array
    {
        $data = (array) json_decode(file_get_contents('php://input'), true);

        $this->Login->username = $data["username"];

        if(!$Login = $this->Login->read()){

            return $this->loginFailed();

        }

        if(!password_verify($data['password'],$Login["password"])){

            return $this->loginFailed();

        }

        $id = $Login["id"];
        
        $token = Auth::generateJWTToken($id);
        
        if(!$token){
            
            return $this->JWTError();

        }

        return $this->loginSuccess($token);

    }

    private function notFoundResponse(): array
    {
        $response['status_code_header'] = 404;
        $response['body'] = json_encode([
            'error' => 'Not found'
        ]);
        return $response;
    }

    private function loginSuccess($token): array
    {
        $response['status_code_header'] = 200;
        $response['body'] = json_encode([
            'message' => 'Login Success',
            'Token' => $token
        ]);
        return $response;
    }

    private function loginFailed(): array
    {
        $response['status_code_header'] = 400;
        $response['body'] = json_encode([
            'message' => 'Login Failed'
        ]);
        return $response;
    }

    private function JWTError(): array
    {
        $response['status_code_header'] = 400;
        $response['body'] = json_encode([
            'error' => 'JWT failed'
        ]);
        return $response;
    }
}