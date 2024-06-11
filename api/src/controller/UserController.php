<?php
// api/controllers/PostController.php
// require_once 'D:\xampp\htdocs\MVC_API\api\src\model\User.php';
require_once __DIR__ . '/../model/User.php';
class UserController {

    private $db;
    private $requestMethod;
    private $userId;
    private $user;

    public function __construct($db, $requestMethod, $userId) {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->userId = $userId;

        $this->user = new User($db);
    }

    public function processRequest() {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->userId) {
                    $response = $this->getUser($this->userId);
                } else {
                    $response = $this->getAllUsers();
                }
                break;
            case 'POST':
                $response = $this->createUser();
                break;
            case 'PUT':
                $response = $this->updateUser($this->userId);
                break;
            case 'DELETE':
                $response = $this->deleteUser($this->userId);
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    private function getAllUsers() {
        $result = $this->user->read();
        $users = $result->fetchAll(PDO::FETCH_ASSOC);
        return $this->okResponse($users);
        // echo json_encode($this->okResponse($posts));
    }

    private function getUser($id) {
        $this->user->id = $id;
        $result = $this->user->readSingle();
        if (!$result) {
            return $this->notFoundResponse();
        }
        return $this->okResponse($result);
    }

    private function createUser() {
        $input = (array) json_decode(file_get_contents('php://input'), true);
        if (!$this->validateUser($input)) {
            return $this->unprocessableEntityResponse();
        }

        $this->user->username = $input['username'];
        $this->user->password = $input['password'];

        if ($this->user->create()) {
            return $this->createdResponse();
        }

        return $this->unprocessableEntityResponse();
    }

    private function updateUser($id) {
        $input = (array) json_decode(file_get_contents('php://input'), true);
        if (!$this->validateUser($input)) {
            return $this->unprocessableEntityResponse();
        }

        $this->user->id = $id;
        $this->user->username = $input['username'];
        $this->user->password = $input['password'];

        if ($this->user->update()) {
            return $this->okResponse(null);
        }

        return $this->unprocessableEntityResponse();
    }

    private function deleteUser($id) {
        $this->user->id = $id;

        if ($this->user->delete()) {
            return $this->okResponse(null);
        }

        return $this->unprocessableEntityResponse();
    }

    private function validateUser($input) {
        return isset($input['username']) && isset($input['password']);
    }

    private function okResponse($data) {
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
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
?>