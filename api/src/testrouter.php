<?php
// api/router.php

require 'routes.php';
require 'handlers.php';
$requestMethod = $_SERVER["REQUEST_METHOD"];
$requestUri = strtok($_SERVER["REQUEST_URI"], '?'); // Remove query string

if (isset($routes[$requestUri])) {
    $route = $routes[$requestUri];
    if (isset($route[$requestMethod])) {
        $handler = $route[$requestMethod];
        $handler();
    } else {
        http_response_code(405);
        echo json_encode(["message" => "Method not allowed"]);
    }
} else {
    http_response_code(404);
    echo json_encode(["message" => "Endpoint not found"]);
}