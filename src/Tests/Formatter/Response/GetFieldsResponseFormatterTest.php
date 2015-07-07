<?php

namespace Humantech\Zoho\Recruit\Api\Tests\Formatter\Response;

use Humantech\Zoho\Recruit\Api\Formatter\Response\GetFieldsResponseFormatter;
use Humantech\Zoho\Recruit\Api\Tests\TestCase;

class GetFieldsResponseFormatterTest extends TestCase
{
    public function testImplementsFormatterInterface()
    {
        $reflection = new \ReflectionClass(
            '\\Humantech\\Zoho\\Recruit\\Api\\Formatter\\Response\\GetFieldsResponseFormatter'
        );

        $this->assertTrue($reflection->implementsInterface(
            '\\Humantech\\Zoho\\Recruit\\Api\\Formatter\\FormatterInterface'
        ));
    }

    public function testGetOutput()
    {
        $formatter = new GetFieldsResponseFormatter();

        $formatter->formatter(array(
            'module' => 'fake_module',
            'data'   => array(
                'fake_module'  => array(
                    'section'  => array(
                        'fake' => 'fakeValue'
                    ),
                ),
            ),
        ));

        $output = $formatter->getOutput();

        $this->assertEquals('fakeValue', $output['fake']);
    }
}
