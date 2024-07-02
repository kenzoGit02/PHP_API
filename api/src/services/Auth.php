<?php

namespace api\src\services;

require_once '../vendor/autoload.php';
use Firebase\JWT\JWT;

class Auth
{
    private static $key = "CI6IkpXVCJ9";

    public static function generateJWTToken($id = ""): string|false
    {
        if(empty($id)){
            return false;
        }
        $payload = [
            'iss' => $_SERVER["SERVER_NAME"], //issuer(who created and signed this token)
            'iat' => time(),//issued at
            'exp' => strtotime("+1 hour"),//expiration time
            'id' => $id
        ];

        $encode = JWT::encode($payload, self::$key, 'HS256');

        return $encode;
    }
}