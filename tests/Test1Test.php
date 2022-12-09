<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\PasswordChecker;

class Test1Test extends TestCase
{
    public function testSomething1(): void
    {
        $test = new PasswordChecker();
        $result = $test->VerifyP('testtestetstetst');
        
        $this->assertTrue($result);        
    }

    public function testSomething2(): void
    {
        $test = new PasswordChecker();
        $result = $test->VerifyP('test');

        $result = !$result;
        
        $this->assertTrue($result);        
    }
}