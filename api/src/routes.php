<?php
// api/routes.php

require_once 'controller/UserController.php';
require_once 'config/database.php';
require_once 'view/json.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestMethod = $_SERVER["REQUEST_METHOD"];
echo $uri;
return;
$postId = null;


if (preg_match('/MVC_API\/api\/user\/([0-9]*)/', $uri, $matches)) {
    if (isset($matches[1]) && $matches[1] !== '') {
        $postId = (int) $matches[1];
    }
}

$database = new Database();
$db = $database->connect();

$controller = new UserController($db, $requestMethod, $postId);
$data = $controller->processRequest();
render($data);
?>