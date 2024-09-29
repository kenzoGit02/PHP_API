<?php

namespace App\Trait;

trait Validation
{

    private function validateInput($input): bool
    {
        return isset($input['username']) && isset($input['password']);
    }

    private function validateUser($input): bool
    {
        return isset($input['username']) && isset($input['password']);
    }
}
