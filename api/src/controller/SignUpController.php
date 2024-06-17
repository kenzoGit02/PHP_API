<?php
require_once __DIR__ . '/../model/SignUp.php';

class SignUpController{
    private $requestMethod;
    private $queryArray;
    private $db;

    private $SignUp;
    public function __construct($db ,$requestMethod, $requestQueryArray)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->queryArray = $requestQueryArray;
        
        $this->SignUp = new SignUp($db);

    }
    public function test(){
        // $test = $this->auth->AuthTest();
        if ($this->requestMethod) {
            // echo json_encode($this->queryArray["id"]);
            echo $this->requestMethod;
            exit;
        }else{
            echo json_encode("No ID");
            exit;
        }
    }
    public function ProcessRequest(){
        switch ($this->requestMethod) {
            case 'POST':
                $response = $this->signUp();
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
            exit;
        }
    }

    private function signUp(): array
    {
        $data = (array) json_decode(file_get_contents('php://input'), true);

        if(!$this->validateInput($data)){
            $this->unprocessableEntityResponse();
        }

        $this->SignUp->username = $data['username'];
        $this->SignUp->password = $data['password'];

        $this->SignUp->create();

        return $this->createdResponse();
    }

    private function validateInput($input): bool 
    {
        return isset($input['username']) && isset($input['password']);
    }

    private function okResponse($data): array
    {
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($data);
        return $response;
    }

    private function createdResponse(): array
    {
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = null;
        return $response;
    }

    private function unprocessableEntityResponse(): array
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);
        return $response;
    }

    private function notFoundResponse(): array
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = json_encode([
            'error' => 'Not found'
        ]);
        return $response;
    }
}