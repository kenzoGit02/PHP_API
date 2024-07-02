<?php

namespace api\src\services;

require_once '../vendor/autoload.php';


class AuthChecker{
    private static $key = "CI6IkpXVCJ9";
    public function __construct(private $token)
    {
    }
    private static function verifyTokenValidity(): bool
    {

        return false;
    }
}