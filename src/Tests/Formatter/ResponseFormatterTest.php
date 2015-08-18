<?php

namespace Humantech\Zoho\Recruit\Api\Tests\Formatter;

use GuzzleHttp\Psr7\Response;
use Humantech\Zoho\Recruit\Api\Formatter\ResponseFormatter;
use Humantech\Zoho\Recruit\Api\Tests\TestCase;

class ResponseFormatterTest extends TestCase
{
    public function formatterDataProvider()
    {
        return array(
            array('getRecords'),
            array('getRecordById'),
            array('getNoteTypes'),
            array('getRelatedRecords'),
            array('getAssociatedJobOpenings'),
            array('getAssociatedCandidates'),
            array('getSearchRecords'),
        );
    }

    public function testInheritedAbstractFormatter()
    {
        $reflection = new \ReflectionClass(
            '\\Humantech\\Zoho\\Recruit\\Api\\Formatter\\ResponseFormatter'
        );

        $this->assertEquals(
            'Humantech\\Zoho\\Recruit\\Api\\Formatter\\AbstractFormatter',
            $reflection->getParentClass()->getName()
        );
    }

    public function testImplementsFormatterInterface()
    {
        $reflection = new \ReflectionClass(
            '\\Humantech\\Zoho\\Recruit\\Api\\Formatter\\ResponseFormatter'
        );

        $this->assertTrue($reflection->implementsInterface(
            '\\Humantech\\Zoho\\Recruit\\Api\\Formatter\\FormatterInterface'
        ));
    }

    public function testDownloadFileResponseFormatter()
    {
        $formatter = ResponseFormatter::create('fake_module', 'fake_method');

        $data = array(
            'download' => new Response(200, array('Content-Type' => 'application/x-downLoad'), 'fake_binary')
        );

        $formatter->formatter($data);

        $this->assertInstanceOf(
            '\\Humantech\\Zoho\\Recruit\\Api\\Formatter\\Response\\DownloadFileResponseFormatter',
            $this->invokeMethod($formatter, 'getFormatter')
        );
    }

    public function testNoDataResponseFormatter()
    {
        $formatter = ResponseFormatter::create('fake_module', 'fake_method');

        $data = array(
            'response' => array(
                'nodata' => '',
            ),
        );

        $formatter->formatter($data);

        $this->assertInstanceOf(
            '\\Humantech\\Zoho\\Recruit\\Api\\Formatter\\Response\\NoDataResponseFormatter',
            $this->invokeMethod($formatter, 'getFormatter')
        );
    }

    public function testMessageResponseFormatter()
    {
        $formatter = ResponseFormatter::create('fake_module', 'fake_method');

        $data = array(
            'response' => array(
                'result' => array(
                    'message' => 'MyFakeMessage!'
                ),
            ),
        );

        $formatter->formatter($data);

        $this->assertInstanceOf(
            '\\Humantech\\Zoho\\Recruit\\Api\\Formatter\\Response\\MessageResponseFormatter',
            $this->invokeMethod($formatter, 'getFormatter')
        );

        $data = array(
            'response' => array(
                'success' => array(
                    'message' => 'MyFakeMessage!'
                ),
            ),
        );

        $formatter->formatter($data);

        $this->assertInstanceOf(
            '\\Humantech\\Zoho\\Recruit\\Api\\Formatter\\Response\\MessageResponseFormatter',
            $this->invokeMethod($formatter, 'getFormatter')
        );
    }

    public function testErrorResponseFormatter()
    {
        $formatter = ResponseFormatter::create('fake_module', 'fake_method');

        $data = array(
            'response' => array(
                'error' => array(
                    'code'    => 1,
                    'message' => 'MyFakeError',
                ),
                'uri'   => 'http://fake'
            ),
        );

        $formatter->formatter($data);

        $this->assertInstanceOf(
            '\\Humantech\\Zoho\\Recruit\\Api\\Formatter\\Response\\ErrorResponseFormatter',
            $this->invokeMethod($formatter, 'getFormatter')
        );
    }

    public function testGetFieldsResponseFormatter()
    {
        $formatter = ResponseFormatter::create('fake_module', 'getFields');

        $data = array(
            'fake_module' => array(
                'section' => array(),
            ),
        );

        $formatter->formatter($data);

        $this->assertInstanceOf(
            '\\Humantech\\Zoho\\Recruit\\Api\\Formatter\\Response\\GetFieldsResponseFormatter',
            $this->invokeMethod($formatter, 'getFormatter')
        );
    }

    public function testGetModulesResponseFormatter()
    {
        $formatter = ResponseFormatter::create('fake_module', 'getModules');

        $data = array(
            'response' => array(
                'result' => array(),
            ),
        );

        $formatter->formatter($data);

        $this->assertInstanceOf(
            '\\Humantech\\Zoho\\Recruit\\Api\\Formatter\\Response\\GetModulesResponseFormatter',
            $this->invokeMethod($formatter, 'getFormatter')
        );
    }

    /**
     * @dataProvider formatterDataProvider
     */
    public function testGenericResponseFormatter($method)
    {
        $formatter = ResponseFormatter::create('fake_module', $method);

        $data = array(
            'response' => array(
                'result' => array(
                    'fake_module' => array(
                        'row' => array(),
                    )
                ),
            ),
        );

        $formatter->formatter($data);

        $this->assertInstanceOf(
            '\\Humantech\\Zoho\\Recruit\\Api\\Formatter\\Response\\GenericResponseFormatter',
            $this->invokeMethod($formatter, 'getFormatter')
        );
    }

    public function testFormatterNotFound()
    {
        $formatter = ResponseFormatter::create('fake_module', 'fake_method');

        $data = array(
            'key1' => 'value1',
            'key2' => 'value2',
        );

        $this->assertInstanceOf(
            '\\Humantech\\Zoho\\Recruit\\Api\\Formatter\\ResponseFormatter',
            $formatter->formatter($data)
        );

        $this->assertEquals($data, $formatter->getOutput());
    }
}
