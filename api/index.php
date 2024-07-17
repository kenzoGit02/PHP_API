<?php

require_once '../vendor/autoload.php';
require_once 'src/routes.php';

use api\src\services\ErrorHandler;
use api\src\Router;

header("Content-type: application/json; charset=UTF-8");

set_error_handler([ErrorHandler::class, 'handleError']);
set_exception_handler([ErrorHandler::class, 'handleException']);

// require_once "src/testrouter.php";

$requestMethod = $_SERVER["REQUEST_METHOD"];

$requestURL = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// $router = new Router();

$response = Router::processRequest(requestMethod: $requestMethod, requestURL: $requestURL, routes: $routes);

if(!isset($response)){
    echo 'no response';
    exit("\nreached: end of script");
}

http_response_code($response['status_code_header']);

echo $response['body'];

exit("\nreached: end of script");