<?php

namespace Humantech\Zoho\Recruit\Api\Tests\Formatter\Response;

use Humantech\Zoho\Recruit\Api\Formatter\Response\MessageResponseFormatter;
use Humantech\Zoho\Recruit\Api\Tests\TestCase;

class MessageResponseFormatterTest extends TestCase
{
    public function testImplementsFormatterInterface()
    {
        $reflection = new \ReflectionClass(
            '\\Humantech\\Zoho\\Recruit\\Api\\Formatter\\Response\\MessageResponseFormatter'
        );

        $this->assertTrue($reflection->implementsInterface(
            '\\Humantech\\Zoho\\Recruit\\Api\\Formatter\\FormatterInterface'
        ));
    }

    public function testGetOutput()
    {
        $formatter = new MessageResponseFormatter();

        $formatter->formatter(array(
            'data' => array(
                'response'  => array(
                    'result' => array(
                        'message' => ' MyFakeMessage!',
                    ),
                ),
            ),
        ));

        $this->assertEquals('MyFakeMessage!', $formatter->getOutput());
    }

    public function testGetOutputWithSuccess()
    {
        $formatter = new MessageResponseFormatter();

        $formatter->formatter(array(
            'data' => array(
                'response'  => array(
                    'success' => array(
                        'message' => ' MyFakeMessage!',
                    ),
                ),
            ),
        ));

        $this->assertEquals('MyFakeMessage!', $formatter->getOutput());
    }
}
