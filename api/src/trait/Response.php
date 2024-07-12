<?php

namespace api\src\trait;

trait Response{

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

    private function createdResponse($data = ""): array
    {
        $data = (empty($data)) ? "Create Succesful" : $data;

        $response['status_code_header'] = 201;
        $response['body'] = json_encode([
            "message" => $data
        ]);
        return $response;
    }

    private function createErrorResponse(): array
    {
        $response['status_code_header'] = 500;
        $response['body'] = json_encode([
            'error' => 'Server Error'
        ]);
        return $response;
    }

    private function unprocessableEntityResponse(): array
    {
        $response['status_code_header'] = 422;
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);
        return $response;
    }

    private function usernameExist(): array
    {
        $response['status_code_header'] = 400;
        $response['body'] = json_encode([
            'error' => 'Username Exist'
        ]);
        return $response;
    }
    
    public function methodNotallowed(string $method): array
    {
        $response['status_code_header'] = 405;
        $response['body'] = json_encode([
            'error' => "$method Method Not Allowed"
        ]);
        return $response;
    }
}