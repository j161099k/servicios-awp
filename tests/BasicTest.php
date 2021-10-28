<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

class BasicTest extends TestCase
{
    public function testSomething(): void
    {
        $this->assertTrue(true);
    }

    public function testFalse(): void
    {
        $this->assertFalse(false);
    }
}
