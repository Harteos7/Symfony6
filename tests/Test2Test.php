<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\PasswordChecker;

class Test2Test extends TestCase
{
    public function testSomething(): void
    {
        $test = new PasswordChecker();
        $result = $test->VerifyP('test');

        $result = !$result;
        
        $this->assertTrue($result);        
    }
}
