<?php

namespace api\src\trait;

trait Validation{

    public function validateInput($input): bool 
    {
        return isset($input['username']) && isset($input['password']);
    }

    public function validateUser($input): bool 
    {
        return isset($input['username']) && isset($input['password']);
    }
}