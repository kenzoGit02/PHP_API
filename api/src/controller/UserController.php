<?php
// api/controllers/PostController.php
// require_once '../model/User.php';
class UserController {
    
    
    private $db;
    private $requestMethod;
    private $postId;

    private $post;

    public function __construct($db, $requestMethod, $postId) {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->postId = $postId;

        $this->post = new User($db);
    }

    public function processRequest() {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->postId) {
                    $response = $this->getPost($this->postId);
                } else {
                    $response = $this->getAllPosts();
                }
                break;
            case 'POST':
                $response = $this->createPost();
                break;
            case 'PUT':
                $response = $this->updatePost($this->postId);
                break;
            case 'DELETE':
                $response = $this->deletePost($this->postId);
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

    private function getAllPosts() {
        $result = $this->post->read();
        $posts = $result->fetchAll(PDO::FETCH_ASSOC);
        return $this->okResponse($posts);
        // echo json_encode($this->okResponse($posts));
    }

    private function getPost($id) {
        $this->post->id = $id;
        $result = $this->post->readSingle();
        if (!$result) {
            return $this->notFoundResponse();
        }
        return $this->okResponse($result);
    }

    private function createPost() {
        $input = (array) json_decode(file_get_contents('php://input'), true);
        if (!$this->validatePost($input)) {
            return $this->unprocessableEntityResponse();
        }

        $this->post->title = $input['title'];
        $this->post->body = $input['body'];

        if ($this->post->create()) {
            return $this->createdResponse();
        }

        return $this->unprocessableEntityResponse();
    }

    private function updatePost($id) {
        $input = (array) json_decode(file_get_contents('php://input'), true);
        if (!$this->validatePost($input)) {
            return $this->unprocessableEntityResponse();
        }

        $this->post->id = $id;
        $this->post->title = $input['title'];
        $this->post->body = $input['body'];

        if ($this->post->update()) {
            return $this->okResponse(null);
        }

        return $this->unprocessableEntityResponse();
    }

    private function deletePost($id) {
        $this->post->id = $id;

        if ($this->post->delete()) {
            return $this->okResponse(null);
        }

        return $this->unprocessableEntityResponse();
    }

    private function validatePost($input) {
        return isset($input['title']) && isset($input['body']);
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