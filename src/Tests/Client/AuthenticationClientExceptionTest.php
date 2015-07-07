<?php

namespace Humantech\Zoho\Recruit\Api\Tests\Client;

use Humantech\Zoho\Recruit\Api\Tests\TestCase;

class AuthenticationClientExceptionTest extends TestCase
{
    public function testInheritedAbstractException()
    {
        $reflection = new \ReflectionClass(
            '\\Humantech\\Zoho\\Recruit\\Api\\Client\\AuthenticationClientException'
        );

        $this->assertEquals(
            'RuntimeException',
            $reflection->getParentClass()->getName()
        );
    }
}
