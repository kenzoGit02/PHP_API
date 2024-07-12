<?php

require_once 'routes.php';
require_once '../vendor/autoload.php';

use api\config\Database;

$requestMethod = $_SERVER["REQUEST_METHOD"];

$requestURI = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


$requestQueryArray = [];
$Controller;

//checking for resource name
$pattern = "/MVC_API\/api\/(.+)/";
if (preg_match($pattern, $requestURI, $matches)) {

    $resource = $matches[1];
    // echo json_encode([$matches[1], $matches[0]]);
    // exit();

} else {

    http_response_code(404);

    echo json_encode(['Error' => 'Resource does not exist']);

    exit;
}

// echo "\n control1 \n";

//checking if resource has an ID included
if (preg_match("/(.+)\/(.+)/", $resource, $matches)){
    // echo "\n control 2\n";
    $resource = $matches[1];
    $resourceID = $matches[2];

    // echo json_encode([$matches[1], $matches[2]]);
    // exit();

}
// echo "\n control3 \n";
// exit($resourceID);

//checking for url queries
if ($URLQuery = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY)){

    parse_str($URLQuery, $output);

    $requestQueryArray = $output;

    // echo json_encode(["Array" => $requestQueryArray]);
    // exit;
}

//if the route is not on the routes list, respond with error
if (!isset($routes[$resource])){

    http_response_code(404);

    echo json_encode(['error message' => 'No URL FOUND']);

    exit;
}

//get controller name from routes array
$ControllerArray = $routes[$resource];

//ControllerArray's index 0 to string
$Controller = (string) $ControllerArray;

$pdo = new Database();

$resourceID = $resourceID ?? null;
// var_dump($resourceID);
// exit();

$Controller = new $Controller(  
                                db: $pdo, 
                                requestMethod: $requestMethod, 
                                id: $resourceID, 
                                extraArgument: $requestQueryArray
                            );

// echo json_encode([$pdo, $requestMethod, $requestQueryArray]);
// exit;

$Controller->processRequest(); 

// $Controller->test();

// $Controller::staticFunction();

exit;