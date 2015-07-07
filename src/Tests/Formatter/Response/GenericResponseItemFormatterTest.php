<?php

namespace Humantech\Zoho\Recruit\Api\Tests\Formatter\Response;

use Humantech\Zoho\Recruit\Api\Formatter\Response\GenericResponseItemFormatter;
use Humantech\Zoho\Recruit\Api\Tests\TestCase;

class GenericResponseItemFormatterTest extends TestCase
{
    public function formatterDataProvider()
    {
        return array(
            array(
                'string',
                array(
                    'val' => 'fakeValue'
                ),
            ),
            array(
                'string',
                array(
                    'sl'  => 'fakeValue'
                ),
            ),
            array(
                'string',
                array(
                    'val' => ' fakeValue '
                ),
            ),
            array(
                'string',
                array(
                    'sl'  => ' fakeValue '
                ),
            ),
            array(
                'string',
                array(
                    'val' => ''
                ),
            ),
            array(
                'string',
                array(
                    'sl'  => ''
                ),
            ),
            array(
                'numeric',
                array(
                    'val' => '12'
                ),
            ),
            array(
                'numeric',
                array(
                    'sl'  => '12'
                ),
            ),
            array(
                'numeric',
                array(
                    'val' => '12.25'
                ),
            ),
            array(
                'numeric',
                array(
                    'sl'  => '12.25'
                ),
            ),
            array(
                'boolean',
                array(
                    'val' => 'false'
                ),
            ),
            array(
                'boolean',
                array(
                    'sl'  => 'false'
                ),
            ),
            array(
                'boolean',
                array(
                    'val' => 'true'
                ),
            ),
            array(
                'boolean',
                array(
                    'sl'  => 'true'
                ),
            ),
            array(
                'boolean',
                array(
                    'val' => 'true'
                ),
            ),
            array(
                'boolean',
                array(
                    'sl'  => 'true'
                ),
            ),
            array(
                'boolean',
                array(
                    'val' => 'True'
                ),
            ),
            array(
                'boolean',
                array(
                    'sl'  => 'True'
                ),
            ),
            array(
                'boolean',
                array(
                    'val' => 'FALSE'
                ),
            ),
            array(
                'boolean',
                array(
                    'sl'  => 'FALSE'
                ),
            ),
            array(
                'datetime',
                array(
                    'val' => '2015-10-10'
                ),
            ),
            array(
                'datetime',
                array(
                    'sl'  => '2015-10-10'
                ),
            ),
            array(
                'datetime',
                array(
                    'val' => '2015-10-10 10:00:00'
                ),
            ),
            array(
                'datetime',
                array(
                    'sl'  => '2015-10-10 10:00:00'
                ),
            ),
        );
    }

    public function testImplementsFormatterInterface()
    {
        $reflection = new \ReflectionClass(
            '\\Humantech\\Zoho\\Recruit\\Api\\Formatter\\Response\\GenericResponseItemFormatter'
        );

        $this->assertTrue($reflection->implementsInterface(
            '\\Humantech\\Zoho\\Recruit\\Api\\Formatter\\FormatterInterface'
        ));
    }

    /**
     * @dataProvider formatterDataProvider
     */
    public function testGetOutput($format, $item)
    {
        $formatter = new GenericResponseItemFormatter();

        $keys = array_keys($item);

        $currentItemKey = $keys[0];

        $formatter->formatter(array(
            $currentItemKey => 'fake',
            'content'       => $item[$currentItemKey]
        ));

        $propertyValue = $this->propertyGetValue($formatter, 'data');

        $this->assertArrayHasKey($currentItemKey, $propertyValue);
        $this->assertArrayHasKey('content', $propertyValue);

        $output = $formatter->getOutput();

        $outputKeys = array_keys($output);

        $this->assertEquals($currentItemKey, $outputKeys[0]);

        $this->assertEquals('fake', $output[$currentItemKey]);

        if ($format === 'string') {
            if ($item[$currentItemKey] === '') {
                $this->assertNull($output['content']);
            } else {
                $this->assertEquals(trim($item[$currentItemKey]), $output['content']);
            }
        } elseif ($format === 'numeric') {
            if ($item[$currentItemKey] === '12') {
                $this->assertTrue(is_int($output['content']));
            } else {
                $this->assertTrue(is_float($output['content']));
            }
        } elseif ($format === 'boolean') {
            if (strtolower($item[$currentItemKey]) === 'false') {
                $this->assertFalse($output['content']);
            } else {
                $this->assertTrue($output['content']);
            }
        } elseif ($format === 'datetime') {
            $this->assertInstanceOf('\\DateTime', $output['content']);
        }
    }
}
