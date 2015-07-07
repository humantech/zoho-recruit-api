<?php

namespace Humantech\Zoho\Recruit\Api\Tests\Unserializer;

use Humantech\Zoho\Recruit\Api\Tests\TestCase;
use Humantech\Zoho\Recruit\Api\Unserializer\UnserializerBuilder;

class UnserializerBuilderTest extends TestCase
{
    public function unserializerProvider()
    {
        return array(
            array('json',  '\\Humantech\\Zoho\\Recruit\\Api\\Unserializer\\JsonUnserializer'),
            array('JsOn',  '\\Humantech\\Zoho\\Recruit\\Api\\Unserializer\\JsonUnserializer'),
            array(' json', '\\Humantech\\Zoho\\Recruit\\Api\\Unserializer\\JsonUnserializer'),
            array('json ', '\\Humantech\\Zoho\\Recruit\\Api\\Unserializer\\JsonUnserializer'),
            array('JSON ', '\\Humantech\\Zoho\\Recruit\\Api\\Unserializer\\JsonUnserializer'),
            array('xml',   '\\Humantech\\Zoho\\Recruit\\Api\\Unserializer\\XmlUnserializer'),
        );
    }

    public function testImplementsUnserializerInterface()
    {
        $reflection = new \ReflectionClass(
            '\\Humantech\\Zoho\\Recruit\\Api\\Unserializer\\UnserializerBuilder'
        );

        $this->assertTrue($reflection->implementsInterface(
            '\\Humantech\\Zoho\\Recruit\\Api\\Unserializer\\UnserializerInterface'
        ));
    }

    public function testConstructIsNotPublic()
    {
        $reflection = new \ReflectionClass(
            '\\Humantech\\Zoho\\Recruit\\Api\\Unserializer\\UnserializerBuilder'
        );

        $this->assertFalse($reflection->getConstructor()->isPublic());
    }

    public function testCreate()
    {
        $instance = UnserializerBuilder::create('json');

        $this->assertInstanceOf(
            '\\Humantech\\Zoho\\Recruit\\Api\\Unserializer\\UnserializerInterface',
            $instance
        );
    }

    /**
     * @dataProvider unserializerProvider
     */
    public function testGetUnserializerByResponseFormat($format, $expectedResult)
    {
        $instance = $this->getMockBuilder('\\Humantech\\Zoho\\Recruit\\Api\\Unserializer\\UnserializerBuilder')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $result = $this->invokeMethod($instance, 'getUnserializerByResponseFormat', array($format));

        $this->assertInstanceOf($expectedResult, $result);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGetUnserializerByResponseFormatException()
    {
        $instance = $this->getMockBuilder('\\Humantech\\Zoho\\Recruit\\Api\\Unserializer\\UnserializerBuilder')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $this->invokeMethod($instance, 'getUnserializerByResponseFormat', array('fake'));
    }

    public function testUnserialize()
    {
        $unserializedData = UnserializerBuilder::create('json')->unserialize(json_encode(array(
            'fake' => 'data'
        )));

        $this->assertEquals('data', $unserializedData['fake']);
    }
}
