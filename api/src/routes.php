<?php

namespace App;

use App\Controller\UserController;
use App\Controller\LoginController;
use App\Controller\SignUpController;
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


