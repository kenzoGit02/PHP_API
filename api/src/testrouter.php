<?php

require 'routes.php';

$requestMethod = $_SERVER["REQUEST_METHOD"];

$requestURI = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$path;
$requestQueryID;
$requestQueryArray = [];

$pattern = "/MVC_API\/api\/(.+)/";
if (preg_match($pattern, $requestURI, $matches)) {
    $path = $matches[1];
} else {
    http_response_code(400);
    echo json_encode(["Error message" => "Pattern not found in URL."]);
}

if ($URLQuery = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY)){

    parse_str($URLQuery, $output);
    $requestQueryArray = $output;

    // echo json_encode($requestQueryArray);

    if($output["id"]){
        $requestQueryID = $output["id"];
    }
    echo json_encode($requestQueryID);

}

echo "control \n";

if (isset($routes[$path])) {
    $route = $routes[$path];
    echo json_encode($route);
}else{
    http_response_code(404);
    echo json_encode(["error message" => "No URL FOUND"]);
}
return;







// if (isset($routes[$requestURI])) {
//     $route = $routes[$requestURI];
//     if (isset($route[$requestMethod])) {
//         $handler = $route[$requestMethod];
//         $handler();
//     } else {
//         http_response_code(405);
//         echo json_encode(["message" => "Method not allowed"]);
//     }
// } else {
//     http_response_code(404);
//     echo json_encode(["message" => "Endpoint not found"]);
// }