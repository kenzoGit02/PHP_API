<?php

require_once 'routes.php';
require_once 'config/database.php';
spl_autoload_register(fn($class) => require __DIR__ . "/controller/$class.php");
// $Controller = "AuthController";
// $test = new $Controller("test");

// $test->test();
// return;

$requestMethod = $_SERVER["REQUEST_METHOD"];

$requestURI = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$path;
$requestQueryArray = [];
$Controller = "";

$pattern = "/MVC_API\/api\/(.+)/";
if (preg_match($pattern, $requestURI, $matches)) {
    $path = $matches[1];
} else {
    http_response_code(400);
    echo json_encode(["Error message" => "Resource does not exist"]);
    exit();
}

if ($URLQuery = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY)){

    parse_str($URLQuery, $output);
    $requestQueryArray = $output;

    // echo json_encode($requestQueryArray);
    echo json_encode(["Array" => $requestQueryArray]);

}

//if the route is not on the routes list, return error
if (!isset($routes[$path])){
    http_response_code(404);
    echo json_encode(["error message" => "No URL FOUND"]);
    exit;
}
//get controller name from routes
$route = $routes[$path];

$string = implode(", ", $route);

$Controller = $route[0];

$pdo = new Database();

$test = new $Controller($pdo, $requestMethod, $requestQueryArray);

$test->test();

exit;