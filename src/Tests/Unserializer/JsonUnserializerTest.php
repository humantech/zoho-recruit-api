<?php

namespace Humantech\Zoho\Recruit\Api\Tests\Unserializer;

use Humantech\Zoho\Recruit\Api\Tests\TestCase;
use Humantech\Zoho\Recruit\Api\Unserializer\JsonUnserializer;

class JsonUnserializerTest extends TestCase
{
    public function testImplementsUnserializerInterface()
    {
        $reflection = new \ReflectionClass(
            '\\Humantech\\Zoho\\Recruit\\Api\\Unserializer\\JsonUnserializer'
        );

        $this->assertTrue($reflection->implementsInterface(
            '\\Humantech\\Zoho\\Recruit\\Api\\Unserializer\\UnserializerInterface'
        ));
    }

    public function testUnserialize()
    {
        $unserializer = new JsonUnserializer();

        $unserializedData = $unserializer->unserialize(json_encode(array(
            'fake' => 'data'
        )));

        $this->assertEquals('data', $unserializedData['fake']);
    }
}
