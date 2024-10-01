<?php

namespace App;

use App\Controller\UserController;
use App\Controller\LoginController;
use App\Controller\SignUpController;
use App\Controller\AuthController;
class Routes{

    public static function getRoutes()
    {
        return self::$routes;
    }
    
    private static $routes = [
        'GET' => [
            // '/' => [UserController::class, 'index'],
            '/user' => [UserController::class, 'index'],
            '/user/{id}' => [UserController::class, 'show'],
        ],
        'POST' => [
            '/login' => [AuthController::class, 'loginUser'],
            '/verify_email' => [AuthController::class, 'verifyEmail'],
            '/check_auth' => [AuthController::class, 'checkAuth'],
            '/signup' => [AuthController::class, 'signUp'],
        ],
        'PUT' => [
            '/user/{id}' => [UserController::class, 'edit'],
        ],
        'DELETE' => [
            '/user/{id}' => [UserController::class, 'delete'],
        ]
    ];
}


