<?php

require_once 'routes.php';
// require_once 'config/Database.php';
require_once 'services/ErrorHandler.php';
// spl_autoload_register(fn($class)=> require __DIR__ . "/controller/$class.php");
spl_autoload_register(function($class){
    var_dump($class);
    $filteredString = preg_replace('/^api\\\\/',"", $class);
    $path = __DIR__ ."\\..\\$filteredString.php";
    $controllerPath = __DIR__ . "/controller/$class.php";

    var_dump($controllerPath);
    if(file_exists($path)){
        require $path;
    }
    if(file_exists($controllerPath)){
        require $controllerPath;
    }
});
use api\config\Database;
use api\src\controller\SignUpController;
set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");
new Database();
$Controller = __DIR__ .'\\controller\\SignUpController';
new $Controller();
exit;

$requestMethod = $_SERVER["REQUEST_METHOD"];

$requestURI = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$URLPath;
$requestQueryArray = [];
$Controller;

$pattern = "/MVC_API\/api\/(.+)/";
if (preg_match($pattern, $requestURI, $matches)) {

    $URLPath = $matches[1];

} else {

    http_response_code(404);

    echo json_encode(["Error message" => "Resource does not exist"]);

    exit();
}

//checking for url queries
if ($URLQuery = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY)){

    parse_str($URLQuery, $output);

    $requestQueryArray = $output;

    // echo json_encode(["Array" => $requestQueryArray]);
}

//if the route is not on the routes list, return error
if (!isset($routes[$URLPath])){

    http_response_code(404);

    echo json_encode(["error message" => "No URL FOUND"]);

    exit;
}

//get controller name from routes
$ControllerArray = $routes[$URLPath];

//array index 0 to string
$Controller = __DIR__ .'\\controller\\'.$ControllerArray[0];

$pdo = new Database();
// use api\src\controller\SignUpController;
$Controller = new $Controller($pdo, $requestMethod, $requestQueryArray);

// echo json_encode([$pdo, $requestMethod, $requestQueryArray]);
// return;
$Controller->processRequest(); 
// $Controller->test();
// $Controller::staticFunction();
exit;