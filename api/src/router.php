<?php

require_once 'controller/UserController.php';
require_once 'config/database.php';
// require_once 'view/json.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestMethod = $_SERVER["REQUEST_METHOD"];

$parsedURL = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
if(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY)){
    parse_str($parsedURL, $output);
    print_r($output);
    print_r($parsedURL);
    echo "test1";
}
echo "test2";
print_r($requestMethod);
return;
$userId = null;
$test = preg_match('/MVC_API\/api\/user\/([0-9])*/', $uri, $matches);

if (preg_match('/MVC_API\/api\/user\/([0-9]*)/', $uri, $matches)) {
    if (isset($matches[1]) && $matches[1] !== '') {
        $userId = (int) $matches[1];
    }
}

$database = new Database();
$db = $database->connect();

$controller = new UserController($db, $requestMethod, $userId);
$data = $controller->processRequest();

// echo $data;
// return;
// render($data);
?>