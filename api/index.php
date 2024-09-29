<?php

require_once '../vendor/autoload.php';


use App\Services\ErrorHandler;
use App\Router;
use App\Routes;

header("Content-type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

set_error_handler([ErrorHandler::class, 'handleError']);
set_exception_handler([ErrorHandler::class, 'handleException']);

$requestMethod = $_SERVER["REQUEST_METHOD"];

$requestURL = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$response = Router::processRequest(requestMethod: $requestMethod, requestURL: $requestURL, routes: Routes::getRoutes());

if (!isset($response)) {
    echo 'no response';
    exit("\nreached: end of script");
}

http_response_code($response['status_code_header']);

echo $response['body'];

exit("\nreached: end of script");
