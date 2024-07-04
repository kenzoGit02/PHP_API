<?php

namespace api\src;

use api\src\controller\UserController;
use api\src\controller\LoginController;
use api\src\controller\SignUpController;

require_once '../vendor/autoload.php';

$routes = [
    'user' => UserController::class,
    'login' => LoginController::class,
    'signup' => SignUpController::class,
    // Add more routes here
];