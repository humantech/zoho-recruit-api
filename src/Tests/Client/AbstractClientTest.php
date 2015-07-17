<?php

namespace Humantech\Zoho\Recruit\Api\Tests\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

class AbstractClientTest extends ClientTestCase
{
    protected function getAbstractClientMock(array $methods = array())
    {
        return $this->getMockBuilder('\\Humantech\\Zoho\\Recruit\\Api\\Client\\AbstractClient')
            ->disableOriginalConstructor()
            ->setMethods($methods)
            ->getMockForAbstractClass()
        ;
    }

    public function testIsAbstractClass()
    {
        $reflection = new \ReflectionClass(
            '\\Humantech\\Zoho\\Recruit\\Api\\Client\\AbstractClient'
        );

        $this->assertTrue($reflection->isAbstract());
    }

    public function testCreateGuzzleRequest()
    {
        $abstractClient = $this->getAbstractClientMock(array(
            'mergeGuzzleRequestExtraParams'
        ));

        $abstractClient
            ->expects($this->once())
            ->method('mergeGuzzleRequestExtraParams')
            ->willReturn(array(
                'headers'         => array(),
                'body'            => null,
                'protocolVersion' => '1.1',
            ))
        ;

        $result = $this->invokeMethod($abstractClient, 'createGuzzleRequest', array(
            'fake_method',
            'fake_uri',
            array(),
        ));

        $this->assertInstanceOf(
            '\\GuzzleHttp\\Psr7\\Request',
            $result
        );

        $this->assertEquals('fake_uri', $result->getUri());

        $this->assertEquals('FAKE_METHOD', $result->getMethod());

        $this->assertEmpty($result->getHeaders());

        $this->assertInstanceOf(
            '\\GuzzleHttp\\Psr7\\Stream',
            $result->getBody()
        );

        $this->assertEquals('1.1', $result->getProtocolVersion());
    }

    public function testMergeGuzzleRequestExtraParams()
    {
        $abstractClient = $this->getAbstractClientMock();

        $result = $this->invokeMethod($abstractClient, 'mergeGuzzleRequestExtraParams', array(
            array()
        ));

        $this->assertTrue(is_array($result['headers']));

        $this->assertNull($result['body']);

        $this->assertEquals('1.1', $result['protocolVersion']);
    }

    public function testMergeGuzzleRequestExtraParamsSetHeaders()
    {
        $abstractClient = $this->getAbstractClientMock();

        $result = $this->invokeMethod($abstractClient, 'mergeGuzzleRequestExtraParams', array(
            array(
                'headers' => array(
                    'Content-Type' => 'application/json'
                )
            )
        ));

        $this->assertTrue(is_array($result['headers']));

        $this->assertEquals('application/json', $result['headers']['Content-Type']);

        $this->assertNull($result['body']);

        $this->assertEquals('1.1', $result['protocolVersion']);
    }

    public function testMergeGuzzleRequestExtraParamsSetBody()
    {
        $abstractClient = $this->getAbstractClientMock();

        $result = $this->invokeMethod($abstractClient, 'mergeGuzzleRequestExtraParams', array(
            array(
                'body' => 'fake_body'
            )
        ));

        $this->assertTrue(is_array($result['headers']));

        $this->assertEquals('fake_body', $result['body']);

        $this->assertEquals('1.1', $result['protocolVersion']);
    }

    public function testMergeGuzzleRequestExtraParamsSetProtocolVersion()
    {
        $abstractClient = $this->getAbstractClientMock();

        $result = $this->invokeMethod($abstractClient, 'mergeGuzzleRequestExtraParams', array(
            array(
                'protocolVersion' => '1.0'
            )
        ));

        $this->assertTrue(is_array($result['headers']));

        $this->assertNull($result['body']);

        $this->assertEquals('1.0', $result['protocolVersion']);
    }

    public function testGetGuzzleClientIntance()
    {
        $abstractClient = $this->getAbstractClientMock();

        $result = $this->invokeMethod($abstractClient, 'getGuzzleClientIntance', array());

        $this->assertInstanceOf(
            '\\GuzzleHttp\\Client',
            $result
        );
    }

    public function testSendRequest()
    {
        $guzzleRequestMock = $this->getMockBuilder('\\GuzzleHttp\\Psr7\\Request')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $guzzleClientMock = $this->getMockBuilder('\\GuzzleHttp\\Client')
            ->disableOriginalConstructor()
            ->setMethods(array('send'))
            ->getMock()
        ;

        $guzzleClientMock
            ->expects($this->once())
            ->method('send')
            ->willReturn(new Response(200, array(), 'FakeResponse'))
        ;

        $abstractClient = $this->getAbstractClientMock(array(
            'createGuzzleRequest',
            'getGuzzleClientIntance',
        ));

        $abstractClient
            ->expects($this->once())
            ->method('createGuzzleRequest')
            ->willReturn($guzzleRequestMock)
        ;

        $abstractClient
            ->expects($this->once())
            ->method('getGuzzleClientIntance')
            ->willReturn($guzzleClientMock)
        ;

        $result = $this->invokeMethod($abstractClient, 'sendRequest', array(
            'fake_method',
            'fake_uri',
        ));

        $this->assertEquals('FakeResponse', $result->getBody()->getContents());
    }

    public function testInitCurlUpload()
    {
        $abstractClient = $this->getAbstractClientMock();

        $result = $this->invokeMethod($abstractClient, 'initCurlUpload', array());

        $this->assertInternalType('resource', $result);
    }

    public function testExecCurlUpload()
    {
        $abstractClient = $this->getAbstractClientMock();

        $curlResource = $this->invokeMethod($abstractClient, 'initCurlUpload', array());

        $result = $this->invokeMethod($abstractClient, 'execCurlUpload', array(
            $curlResource
        ));

        $this->assertFalse($result);
    }

    public function testCurlUploadSetOptions()
    {
        $abstractClient = $this->getAbstractClientMock();

        $curlResource = $this->invokeMethod($abstractClient, 'initCurlUpload', array());
        $options      = $this->invokeMethod($abstractClient, 'getOptionsCurlUpload', array(
            'fake_uri',
            array('fake_post_fields'),
        ));

        $curlResourceOpt = $this->invokeMethod($abstractClient, 'setOptionsCurlUpload', array(
            $curlResource,
            $options
        ));

        $this->assertNotFalse($curlResourceOpt);
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testCurlUploadSetOptionsInvalidArgumentException()
    {
        $abstractClient = $this->getAbstractClientMock();

        $curlResource = $this->invokeMethod($abstractClient, 'initCurlUpload', array());

        $this->invokeMethod($abstractClient, 'setOptionsCurlUpload', array(
            $curlResource,
            array(
                -9999999 => 'fake'
            )
        ));
    }

    public function testCurlUploadGetOptions()
    {
        $abstractClient = $this->getAbstractClientMock();

        $result = $this->invokeMethod($abstractClient, 'getOptionsCurlUpload', array(
            'fake_uri',
            array('fake_post_fields'),
        ));

        $this->assertTrue(is_array($result));

        $this->assertEquals(0, $result[CURLOPT_HEADER]);

        $this->assertEquals(0, $result[CURLOPT_VERBOSE]);

        $this->assertTrue($result[CURLOPT_RETURNTRANSFER]);

        $this->assertEquals('fake_uri', $result[CURLOPT_URL]);
        $this->assertTrue($result[CURLOPT_POST]);

        $this->assertEquals('fake_post_fields', $result[CURLOPT_POSTFIELDS][0]);
    }

    public function testSendFile()
    {
        $abstractClient = $this->getAbstractClientMock(array(
            'initCurlUpload',
            'getOptionsCurlUpload',
            'setOptionsCurlUpload',
            'execCurlUpload',
        ));

        $abstractClient
            ->expects($this->once())
            ->method('initCurlUpload')
            ->willReturn(curl_init())
        ;

        $abstractClient
            ->expects($this->once())
            ->method('getOptionsCurlUpload')
            ->willReturn(array())
        ;

        $abstractClient
            ->expects($this->once())
            ->method('setOptionsCurlUpload')
            ->willReturn(curl_init())
        ;

        $abstractClient
            ->expects($this->once())
            ->method('execCurlUpload')
            ->willReturn('FakeResponse')
        ;

        $result = $this->invokeMethod($abstractClient, 'sendFile', array(
            'fake_uri',
            array('fake_post_fields'),
        ));

        $this->assertEquals('FakeResponse', $result);
    }
}
