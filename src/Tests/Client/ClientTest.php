<?php

namespace Humantech\Zoho\Recruit\Api\Tests\Client;

use GuzzleHttp\Psr7\Response;
use Humantech\Zoho\Recruit\Api\Client\Client;

class ClientTest extends ClientTestCase
{
    public function testInheritedAbstractClient()
    {
        $reflection = new \ReflectionClass(
            '\\Humantech\\Zoho\\Recruit\\Api\\Client\\Client'
        );

        $this->assertEquals(
            'Humantech\\Zoho\\Recruit\\Api\\Client\\AbstractClient',
            $reflection->getParentClass()->getName()
        );
    }

    public function testImplementsClientInterface()
    {
        $reflection = new \ReflectionClass(
            '\\Humantech\\Zoho\\Recruit\\Api\\Client\\Client'
        );

        $this->assertTrue($reflection->implementsInterface(
            '\\Humantech\\Zoho\\Recruit\\Api\\Client\\ClientInterface'
        ));
    }

    public function testGetAuthToken()
    {
        $client = new Client('fake_token');

        $this->assertEquals('fake_token', $client->getAuthToken());
    }

    public function dataProviderGetUri()
    {
        $dataProvider = array();

        $allowed = array(
            'methods'         => $this->getMethodsAllowed(),
            'request_formats' => $this->getRequestFormatsAllowed(),
        );

        foreach ($allowed['request_formats'] as $requestFormat) {
            foreach ($allowed['methods'] as $method) {
                $dataProvider[] = array(
                    'fake_module',
                    $method,
                    $requestFormat,
                    array(),
                );
            }
        }

        return $dataProvider;
    }

    public function dataProviderGetRequestFormatsAllowed()
    {
        $dataProvider = array();

        $requestFormats = $this->getRequestFormatsAllowed();

        foreach ($requestFormats as $requestFormat) {
            $dataProvider[] = array($requestFormat);
        }

        return $dataProvider;
    }

    public function getRequestFormatsAllowed()
    {
        return array(
            'json',
            'xml'
        );
    }

    public function dataProviderGetMethodsAllowed()
    {
        $dataProvider = array();

        $methods = $this->getMethodsAllowed();

        foreach ($methods as $method) {
            $dataProvider[] = array($method);
        }

        return $dataProvider;
    }

    public function getMethodsAllowed()
    {
        return array(
            'getRecords',
            'getRecordById',
            'addRecords',
            'updateRecords',
            'getNoteTypes',
            'getRelatedRecords',
            'getFields',
            'getAssociatedJobOpenings',
            'changeStatus',
            'uploadFile',
            'downloadFile',
            'associateJobOpening',
            'uploadPhoto',
            'downloadPhoto',
            'uploadDocument',
            'getModules',
            'getAssociatedCandidates',
            'getSearchRecords',
        );
    }

    /**
     * @dataProvider dataProviderGetUri
     */
    public function testGetUri($module, $method, $format, $params)
    {
        $client = new Client('fake_token');

        $this->assertContains(
            sprintf(Client::API_BASE_URL, $format, $module, $method, 'fake_token'),
            $this->invokeMethod($client, 'getUri', array($module, $method, $format, $params))
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGetUriNotHasMethod()
    {
        $client = new Client('fake_token');

        $this->invokeMethod($client, 'getUri', array('fake_module', 'fake_method', 'json', array()));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGetUriNotHasResponseFormat()
    {
        $client = new Client('fake_token');

        $methods = $this->getMethodsAllowed();

        $this->invokeMethod($client, 'getUri', array('fake_module', $methods[0], 'fake_response_format', array()));
    }

    public function testGenerateQueryStringByRequestParamsEmpty()
    {
        $client = new Client('fake_token');

        $this->assertEmpty($this->invokeMethod($client, 'generateQueryStringByRequestParams', array(array())));
    }

    public function testGenerateQueryStringByRequestParams()
    {
        $client = new Client('fake_token');

        $queryString = $this->invokeMethod($client, 'generateQueryStringByRequestParams', array(array(
            'key'  => 'value',
            'fake' => 'fakeValue',
        )));

        $this->assertEquals('&key=value&fake=fakeValue', $queryString);
    }

    /**
     * @dataProvider dataProviderGetMethodsAllowed
     */
    public function testHasMethod($method)
    {
        $client = new Client('fake_token');

        $this->assertTrue($this->invokeMethod($client, 'hasMethod', array($method)));
    }

    /**
     * @dataProvider dataProviderGetRequestFormatsAllowed
     */
    public function testHasResponseFormat($requestFormat)
    {
        $client = new Client('fake_token');

        $this->assertTrue($this->invokeMethod($client, 'hasResponseFormat', array($requestFormat)));
    }

    public function testGetUnserializedData()
    {
        $client = new Client('fake_token');

        $response = new Response(200, array(), json_encode(array(
            'key'  => 'value',
            'fake' => 'fakeValue',
        )));

        $unserializedData = $this->invokeMethod($client, 'getUnserializedData', array($response, 'json'));

        $this->assertEquals('value', $unserializedData['key']);

        $this->assertEquals('fakeValue', $unserializedData['fake']);
    }

    public function testGetRecords()
    {
        $client = $this->getMockBuilder('\\Humantech\\Zoho\\Recruit\\Api\\Client\\Client')
            ->disableOriginalConstructor()
            ->setMethods(array('sendRequest'))
            ->getMock()
        ;

        $client
            ->expects($this->once())
            ->method('sendRequest')
            ->willReturn(new Response(200, array(), $this->getResourceFakeResponseByName('getRecords.json')))
        ;

        $result = $this->invokeMethod($client, 'getRecords', array(
            'JobOpenings'
        ));

        $this->assertEquals(307870000000096001, $result[0]['JOBOPENINGID']);
    }

    public function testGetRecordById()
    {
        $client = $this->getMockBuilder('\\Humantech\\Zoho\\Recruit\\Api\\Client\\Client')
            ->disableOriginalConstructor()
            ->setMethods(array('sendRequest'))
            ->getMock()
        ;

        $client
            ->expects($this->once())
            ->method('sendRequest')
            ->willReturn(new Response(200, array(), $this->getResourceFakeResponseByName('getRecordById.json')))
        ;

        $result = $this->invokeMethod($client, 'getRecordById', array(
            'JobOpenings',
            'fake_id',
        ));

        $this->assertEquals(307870000000096001, $result[0]['JOBOPENINGID']);
    }

    public function testAddRecords()
    {
        $client = $this->getMockBuilder('\\Humantech\\Zoho\\Recruit\\Api\\Client\\Client')
            ->disableOriginalConstructor()
            ->setMethods(array('sendRequest'))
            ->getMock()
        ;

        $client
            ->expects($this->once())
            ->method('sendRequest')
            ->willReturn(new Response(200, array(), $this->getResourceFakeResponseByName('addRecords.json')))
        ;

        $result = $this->invokeMethod($client, 'addRecords', array(
            'Clients',
            array('Client Name' => 'FakeClientName')
        ));

        $this->assertEquals('Record(s) added successfully', $result);
    }

    public function testUpdateRecords()
    {
        $client = $this->getMockBuilder('\\Humantech\\Zoho\\Recruit\\Api\\Client\\Client')
            ->disableOriginalConstructor()
            ->setMethods(array('sendRequest'))
            ->getMock()
        ;

        $client
            ->expects($this->once())
            ->method('sendRequest')
            ->willReturn(new Response(200, array(), $this->getResourceFakeResponseByName('updateRecords.json')))
        ;

        $result = $this->invokeMethod($client, 'updateRecords', array(
            'Clients',
            'fake_id',
            array('Client Name' => 'FakeClientName')
        ));

        $this->assertEquals('Record(s) updated successfully', $result);
    }

    public function testGetNoteTypes()
    {
        $client = $this->getMockBuilder('\\Humantech\\Zoho\\Recruit\\Api\\Client\\Client')
            ->disableOriginalConstructor()
            ->setMethods(array('sendRequest'))
            ->getMock()
        ;

        $client
            ->expects($this->once())
            ->method('sendRequest')
            ->willReturn(new Response(200, array(), $this->getResourceFakeResponseByName('getNoteTypes.json')))
        ;

        $result = $this->invokeMethod($client, 'getNoteTypes', array());

        $this->assertEquals('Call', $result[0]['NoteType']);
    }

    public function testGetRelatedRecords()
    {
        $client = $this->getMockBuilder('\\Humantech\\Zoho\\Recruit\\Api\\Client\\Client')
            ->disableOriginalConstructor()
            ->setMethods(array('sendRequest'))
            ->getMock()
        ;

        $client
            ->expects($this->once())
            ->method('sendRequest')
            ->willReturn(new Response(200, array(), $this->getResourceFakeResponseByName('getRelatedRecords.json')))
        ;

        $result = $this->invokeMethod($client, 'getRelatedRecords', array(
            'Attachments',
            'fake_parent_module',
            'fake_id'
        ));

        $this->assertEquals(307870000000106015, $result[0]['id']);
    }

    public function testGetFields()
    {
        $client = $this->getMockBuilder('\\Humantech\\Zoho\\Recruit\\Api\\Client\\Client')
            ->disableOriginalConstructor()
            ->setMethods(array('sendRequest'))
            ->getMock()
        ;

        $client
            ->expects($this->once())
            ->method('sendRequest')
            ->willReturn(new Response(200, array(), $this->getResourceFakeResponseByName('getFields.json')))
        ;

        $result = $this->invokeMethod($client, 'getFields', array(
            'Clients',
        ));

        $this->assertEquals('Text', $result[0]['FL'][0]['type']);
    }
}
