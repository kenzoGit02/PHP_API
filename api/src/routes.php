<?php

use api\src\controller\UserController;
use api\src\controller\LoginController;
use api\src\controller\SignUpController;

$OLDroutes = [
    'user' => UserController::class,
    'login' => LoginController::class,
    'email_verify' => LoginController::class,
    'signup' => SignUpController::class,
    // Add more routes here
];

$routes = [
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
    // Add more routes here
];