<?php
require_once __DIR__ . '/../model/SignUp.php';
require_once '../vendor/autoload.php';

use Firebase\JWT\JWT;
class SignUpController{

    private $requestMethod;
    private $db;
    private $key = "CI6IkpXVCJ9";
    private $SignUp;
    private $extraArgument;

    public function __construct($db ,$requestMethod, ...$extraArgument)
    {
        $this->db = $db->connect();
        $this->requestMethod = $requestMethod;
        $this->extraArgument = $extraArgument;
        
        $this->SignUp = new SignUp($db);

    }
    public function test(){
        // $test = $this->auth->AuthTest();
        if ($this->requestMethod) {
            // echo json_encode($this->queryArray["id"]);
            echo $this->requestMethod;
            echo json_encode([$this->extraArgument, $this->SignUp->testFunction()]);
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

    private function signUp()
    {
        $data = (array) json_decode(file_get_contents('php://input'), true);

        if(!$this->validateInput($data)){
            $this->unprocessableEntityResponse();
        }

        $this->SignUp->username = $data['username'];
        $this->SignUp->password = $data['password'];

        $signup = $this->SignUp->create();

        if (!$signup){
            return $this->createErrorResponse();
        }

        $JWTToken = $this->generateJWTToken($signup);

        return $this->createdResponse($JWTToken);
    }

    private function generateJWTToken($id): string
    {
        $payload = [
            'iss' => $_SERVER["SERVER_NAME"], //issuer(who created and signed this token)
            'iat' => time(),//issued at
            'exp' => strtotime("+1 hour"),//expiration time
            'id' => $id
        ];

        $encode = JWT::encode($payload, $this->key, 'HS256');

        return $encode;
    }

    private function validateInput($input): bool 
    {
        return isset($input['username']) && isset($input['password']);
    }

    private function createdResponse($data): array
    {
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = json_encode($data);
        return $response;
    }

    private function createErrorResponse(): array
    {
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = json_encode([
            'error' => 'Something went wrong while inserting to database'
        ]);
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