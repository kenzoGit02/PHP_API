<?php
namespace App\Traits;

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
        $response['status_code_header'] = 200;
        $response['body'] = json_encode([
            'message' => 'The email address or password you entered is incorrect. Please try again.'
        ]);
        return $response;
    }

    private function JWTError(): array
    {
        $response['status_code_header'] = 500;
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
        $response['status_code_header'] = 200;
        $response['body'] = json_encode([
            'message' => 'Username Exist'
        ]);
        return $response;
    }
    
    private function methodNotallowed(string $method): array
    {
        $response['status_code_header'] = 405;
        $response['body'] = json_encode([
            'error' => "$method Method Not Allowed"
        ]);
        return $response;
    }

    private function emailExist(): array
    {
        $response['status_code_header'] = 200;
        $response['body'] = json_encode([
            'message' => 'The email address you entered is already registered. Please use a different email address or log in.'
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

    private function verificationSuccess($token): array
    {
        $response['status_code_header'] = 200;
        $response['body'] = json_encode([
            'Message' => 'Email is now verified',
            'Token' => $token
        ]);
        return $response;
    }
    private function emailSent(): array
    {
        $response['status_code_header'] = 200;
        $response['body'] = json_encode([
            'message' => 'Email Verification Sent'
        ]);
        return $response;
    }
    
    private function verificationFailed(): array
    {
        $response['status_code_header'] = 400;
        $response['body'] = json_encode([
            'message' => 'Wrong Verification Code'
        ]);
        return $response;
    }

    private function okResponse($data) {
        $response['status_code_header'] = 200;
        $response['body'] = json_encode($data);
        return $response;
    }

    private function alreadyVerified() {
        $response['status_code_header'] = 200;
        $response['body'] = json_encode([
            'message' => 'Account is already verified'
        ]);
        return $response;
    }
}