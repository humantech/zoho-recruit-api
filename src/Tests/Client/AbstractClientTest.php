<?php

namespace Humantech\Zoho\Recruit\Api\Tests\Client;

class AbstractClientTest extends ClientTestCase
{
    public function testIsAbstractClass()
    {
        $reflection = new \ReflectionClass(
            '\\Humantech\\Zoho\\Recruit\\Api\\Client\\AbstractClient'
        );

        $this->assertTrue($reflection->isAbstract());
    }
}
