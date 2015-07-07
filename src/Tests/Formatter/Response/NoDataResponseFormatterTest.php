<?php

namespace Humantech\Zoho\Recruit\Api\Tests\Formatter\Response;

use Humantech\Zoho\Recruit\Api\Formatter\Response\NoDataResponseFormatter;
use Humantech\Zoho\Recruit\Api\Tests\TestCase;

class NoDataResponseFormatterTest extends TestCase
{
    public function testImplementsFormatterInterface()
    {
        $reflection = new \ReflectionClass(
            '\\Humantech\\Zoho\\Recruit\\Api\\Formatter\\Response\\NoDataResponseFormatter'
        );

        $this->assertTrue($reflection->implementsInterface(
            '\\Humantech\\Zoho\\Recruit\\Api\\Formatter\\FormatterInterface'
        ));
    }

    public function testGetOutput()
    {
        $formatter = new NoDataResponseFormatter();

        $formatter->formatter(array(
            'fake' => 'Fake'
        ));

        $this->assertEmpty($formatter->getOutput());
    }
}
