<?php

namespace App;

class PasswordChecker
{
    
    public function VerifyP(string $password): ?bool
    {
        $min = 10;
        if ($min < strlen($password)) {
            return true;
        } else {
            return false;
        }
    }
}