<?php

require_once '../vendor/autoload.php';

use api\src\services\ErrorHandler;

header("Content-type: application/json; charset=UTF-8");

set_error_handler([ErrorHandler::class, 'handleError']);

set_exception_handler([ErrorHandler::class, 'handleException']);

require_once "src/router.php";