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

    public function testFormatterWithoutBulk()
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

    public function testFormatterWithBulk()
    {
        $formatter = new XmlDataRequestFormatter();

        $formatter->formatter(array(
            'module' => 'Fake',
            'data'   => array(
                array(
                    'key1' => 'value1',
                ),
                array(
                    'key2' => 'value2',
                ),
                array(
                    'key3' => 'value3',
                ),
            ),
        ));

        $simpleXmlObj = simplexml_load_string($formatter->getOutput());

        $this->assertInstanceOf('\\SimpleXMLElement', $simpleXmlObj);

        $this->assertEquals('Fake', $simpleXmlObj->getName());

        $fieldList = $simpleXmlObj->xpath('/Fake/row');

        $this->assertCount(3, $fieldList);
    }
}
