<?php

namespace api\src\services;

require_once '../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\KEY;
use Firebase\JWT\ExpiredException;

class AuthChecker{
    private static $key = "CI6IkpXVCJ9";

    private static function verifyTokenValidity($token = ""): bool
    {
        if(empty($token)){
            return false;
        }

        $header = apache_request_headers();

        if(!$header["Authorization"]){
            return false;
        }

        $bearerToken = $header['Authorization'];

        $parts = explode(' ', $bearerToken);

        // Select the second part, which represents the token
        $token = $parts[1];
        
        try{
            $decoded = JWT::decode($token, new Key(self::$key,'HS256'));

            // If decoding is successful and no exception is thrown, the token is valid
            echo json_encode(["message" => "Token is still valid."]);
            
            // Print the decoded payload for debugging
            print_r($decoded);
        } catch (ExpiredException $e) {
            // Handle token expiration specifically
            echo json_encode(["Token has expired" => $e->getMessage()]);
        } catch (\Exception $e) {
            // Handle other decoding errors
            echo json_encode(["Caught exception" => $e->getMessage()]);
        }

        return false;
    }
}