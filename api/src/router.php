<?php

namespace api\src;

use api\config\Database;

class Router{

    public static function processRequest($requestMethod, $requestURL ,$routes)
    {
        list($requestEndPoint, $requestEndPointID) = self::getEndpointString($requestURL);

        $requestQueryArray = self::get_URL_Request();

        $pdo = new Database();
        
        list($controllerName, $method) = self::getEndpointFromRoutes($routes, $requestMethod, $requestEndPoint);

        $controllerName = new $controllerName(db: $pdo);

        if (!method_exists($controllerName, $method)) {
            echo json_encode(['Server Error' => 'Method Does Not Exist']);
            http_response_code(500);
            exit;
        }

        //task: make sure there is no other id key inside the request

        $requestEndPointID = ['id' => $requestEndPointID];

        $request = array_merge($requestQueryArray, $requestEndPointID);

        $requestResponse = $controllerName->$method($request);
        
        return $requestResponse;

    }

    private static function getEndpointString($requestURL): array
    {
            //if the requestURL's formatting is correct, 
        if(preg_match("/MVC_API\/api(.+)/", $requestURL, $matches)) {

            $requestEndPoint = $matches[1];
        
        } else {
            http_response_code(404);
            echo json_encode(['User Error' => 'Wrong Endpoint Format']);
            exit;
        }
        
            //checking if requestEndPoint has an ID included, extract it and modify requestEndPoint accordingly
        if(preg_match("/(.+)\/(.+)/", $requestEndPoint, $matches)){

            $requestEndPointID = $matches[2];
            $requestEndPoint = $matches[1] . "/{id}";

        }

        return [$requestEndPoint, $requestEndPointID = $requestEndPointID ?? null];
    }

    private static function get_URL_Request(): array
    {
        $requestQueryArray = [];

            //checking for url queries
        if ($URLQuery = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY)){
            parse_str($URLQuery, $output);
            $requestQueryArray = $output;
        }

        return $requestQueryArray;
    }

    private static function getEndpointFromRoutes($routes, $requestMethod, $requestEndPoint): array
    {
        // echo 'vardump routes';
        // var_dump($routes);
        // exit;
            //if the http verb is not allowed, respond with error
        if (!isset($routes[$requestMethod])){
            http_response_code(404);
            echo json_encode(['error message' => 'No Endpoint Found']);
            exit('exit a');
        }
        
        foreach($routes[$requestMethod] as $endPoint => $value){
            if($requestEndPoint == $endPoint){
                return $value;
            }
        }
            //this part can only be reached if there is no endpoint found inside the list
        http_response_code(404);
        echo json_encode(['error message' => 'No Endpoint Found']);
        exit('exit c');
    }
}