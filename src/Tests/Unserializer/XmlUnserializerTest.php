<?php

namespace Humantech\Zoho\Recruit\Api\Tests\Unserializer;

use Humantech\Zoho\Recruit\Api\Tests\TestCase;
use Humantech\Zoho\Recruit\Api\Unserializer\XmlUnserializer;

class XmlUnserializerTest extends TestCase
{
    public function testImplementsUnserializerInterface()
    {
        $reflection = new \ReflectionClass(
            '\\Humantech\\Zoho\\Recruit\\Api\\Unserializer\\XmlUnserializer'
        );

        $this->assertTrue($reflection->implementsInterface(
            '\\Humantech\\Zoho\\Recruit\\Api\\Unserializer\\UnserializerInterface'
        ));
    }

    /**
     * @expectedException \LogicException
     */
    public function testUnserialize()
    {
        $unserializer = new XmlUnserializer();

        $unserializer->unserialize('');
    }
}
