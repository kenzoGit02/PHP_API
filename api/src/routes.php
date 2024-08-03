<?php

namespace api\src;

use api\src\controller\UserController;
use api\src\controller\LoginController;
use api\src\controller\SignUpController;
class Routes{

    public static function getRoutes()
    {
        return self::$routes;
    }
    
    private $routes = [
        'GET' => [
            // '/' => [UserController::class, 'index'],
            '/user' => [UserController::class, 'index'],
            '/user/{id}' => [UserController::class, 'show'],
        ],
        'POST' => [
            '/login' => [LoginController::class, 'loginUser'],
            '/verify_email' => [LoginController::class, 'verifyEmail'],
            '/check_auth' => [LoginController::class, 'checkAuth'],
            '/signup' => [SignUpController::class, 'signUp'],
        ],
        'PUT' => [
            '/user/{id}' => [UserController::class, 'edit'],
        ],
        'DELETE' => [
            '/user/{id}' => [UserController::class, 'delete'],
        ]
    ];
}


