<?php

namespace Humantech\Zoho\Recruit\Api\Tests\Formatter;

use Humantech\Zoho\Recruit\Api\Formatter\RequestFormatter;
use Humantech\Zoho\Recruit\Api\Tests\TestCase;

class RequestFormatterTest extends TestCase
{
    public function formatterDataProvider()
    {
        return array(
            array('addRecords'),
            array('updateRecords'),
        );
    }

    public function testInheritedAbstractFormatter()
    {
        $reflection = new \ReflectionClass(
            '\\Humantech\\Zoho\\Recruit\\Api\\Formatter\\RequestFormatter'
        );

        $this->assertEquals(
            'Humantech\\Zoho\\Recruit\\Api\\Formatter\\AbstractFormatter',
            $reflection->getParentClass()->getName()
        );
    }

    public function testImplementsFormatterInterface()
    {
        $reflection = new \ReflectionClass(
            '\\Humantech\\Zoho\\Recruit\\Api\\Formatter\\RequestFormatter'
        );

        $this->assertTrue($reflection->implementsInterface(
            '\\Humantech\\Zoho\\Recruit\\Api\\Formatter\\FormatterInterface'
        ));
    }

    /**
     * @dataProvider formatterDataProvider
     */
    public function testFormatter($method)
    {
        $formatter = RequestFormatter::create('fake_module', $method);

        $data = array(
            'key1' => 'value1',
            'key2' => 'value2',
        );

        $this->assertInstanceOf(
            '\\Humantech\\Zoho\\Recruit\\Api\\Formatter\\RequestFormatter',
            $formatter->formatter($data)
        );

        $this->assertTrue(is_string($formatter->getOutput()));
    }

    public function testFormatterNotFound()
    {
        $formatter = RequestFormatter::create('fake_module', 'fake_method');

        $data = array(
            'key1' => 'value1',
            'key2' => 'value2',
        );

        $this->assertInstanceOf(
            '\\Humantech\\Zoho\\Recruit\\Api\\Formatter\\RequestFormatter',
            $formatter->formatter($data)
        );

        $this->assertEquals($data, $formatter->getOutput());
    }
}
