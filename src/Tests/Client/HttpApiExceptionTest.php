<?php

namespace Humantech\Zoho\Recruit\Api\Tests\Client;

use Humantech\Zoho\Recruit\Api\Client\HttpApiException;
use Humantech\Zoho\Recruit\Api\Tests\TestCase;

class HttpApiExceptionTest extends TestCase
{
    public function testInheritedAbstractException()
    {
        $reflection = new \ReflectionClass(
            '\\Humantech\\Zoho\\Recruit\\Api\\Client\\HttpApiException'
        );

        $this->assertEquals(
            'RuntimeException',
            $reflection->getParentClass()->getName()
        );
    }

    public function testGetMethods()
    {
        $exception = new HttpApiException('fake_message', 1, 'http://fake');

        $this->assertInstanceOf(
            '\\Humantech\\Zoho\\Recruit\\Api\\Client\\HttpApiException',
            $exception
        );

        $this->assertEquals('fake_message', $exception->getMessage());

        $this->assertEquals(1, $exception->getCode());

        $this->assertEquals('http://fake', $exception->getUri());
    }
}
