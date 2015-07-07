<?php

namespace Humantech\Zoho\Recruit\Api\Tests\Formatter\Request;

use Humantech\Zoho\Recruit\Api\Formatter\Request\XmlDataRequestFormatter;
use Humantech\Zoho\Recruit\Api\Tests\TestCase;

class XmlDataRequestFormatterTest extends TestCase
{
    public function testImplementsFormatterInterface()
    {
        $reflection = new \ReflectionClass(
            '\\Humantech\\Zoho\\Recruit\\Api\\Formatter\\Request\\XmlDataRequestFormatter'
        );

        $this->assertTrue($reflection->implementsInterface(
            '\\Humantech\\Zoho\\Recruit\\Api\\Formatter\\FormatterInterface'
        ));
    }

    public function testFormatter()
    {
        $formatter = new XmlDataRequestFormatter();

        $formatter->formatter(array(
            'module'   => 'Fake',
            'data'     => array(
                'key1' => 'value1',
                'key2' => 'value2',
            ),
        ));

        $simpleXmlObj = simplexml_load_string($formatter->getOutput());

        $this->assertInstanceOf('\\SimpleXMLElement', $simpleXmlObj);

        $this->assertEquals('Fake', $simpleXmlObj->getName());

        $fieldList = $simpleXmlObj->xpath('/Fake/row/FL');

        $currentAttr = current($fieldList[0]->attributes());

        $this->assertEquals('key1', $currentAttr['val']);

        $currentAttr = current($fieldList[1]->attributes());

        $this->assertEquals('key2', $currentAttr['val']);

        $this->assertEquals('value1', (string) $fieldList[0]);
        $this->assertEquals('value2', (string) $fieldList[1]);
    }
}
