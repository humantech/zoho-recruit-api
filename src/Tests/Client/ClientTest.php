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
        $this->assertEquals('fake_token', $this->getClientOriginalInstance()->getAuthToken());
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
        $client = $this->getClientOriginalInstance();

        $result = $this->invokeMethod($client, 'getUri', array(
            $module,
            $method,
            $format,
            $params
        ));

        $expectedResult = sprintf(Client::API_BASE_URL, $format, $module, $method, 'fake_token');

        $this->assertContains($expectedResult, $result);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGetUriNotHasMethod()
    {
        $this->invokeMethod($this->getClientOriginalInstance(), 'getUri', array(
            'fake_module',
            'fake_method',
            'json',
            array()
        ));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGetUriNotHasResponseFormat()
    {
        $methods = $this->getMethodsAllowed();

        $this->invokeMethod($this->getClientOriginalInstance(), 'getUri', array(
            'fake_module',
            $methods[0],
            'fake_response_format',
            array()
        ));
    }

    public function testGenerateQueryStringByRequestParamsEmpty()
    {
        $method = 'generateQueryStringByRequestParams';

        $expectedResult = $this->invokeMethod($this->getClientOriginalInstance(),  $method, array(
            array()
        ));

        $this->assertEmpty($expectedResult);
    }

    public function testGenerateQueryStringByRequestParams()
    {
        $method = 'generateQueryStringByRequestParams';

        $queryString = $this->invokeMethod($this->getClientOriginalInstance(), $method, array(array(
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
        $expectedResult = $this->invokeMethod($this->getClientOriginalInstance(), 'hasMethod', array(
            $method
        ));

        $this->assertTrue($expectedResult);
    }

    /**
     * @dataProvider dataProviderGetRequestFormatsAllowed
     */
    public function testHasResponseFormat($requestFormat)
    {
        $expectedResult = $this->invokeMethod($this->getClientOriginalInstance(), 'hasResponseFormat', array(
            $requestFormat
        ));

        $this->assertTrue($expectedResult);
    }

    public function testGetUnserializedData()
    {
        $response = new Response(200, array(), json_encode(array(
            'key'  => 'value',
            'fake' => 'fakeValue',
        )));

        $expectedResult = $this->invokeMethod($this->getClientOriginalInstance(), 'getUnserializedData', array(
            $response,
            'json'
        ));

        $this->assertEquals('value', $expectedResult['key']);

        $this->assertEquals('fakeValue', $expectedResult['fake']);
    }

    public function testGetRecords()
    {
        $client = $this->getClientMock(array('sendRequest'));

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
        $client = $this->getClientMock(array('sendRequest'));

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
        $client = $this->getClientMock(array('sendRequest'));

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
        $client = $this->getClientMock(array('sendRequest'));

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
        $client = $this->getClientMock(array('sendRequest'));

        $client
            ->expects($this->once())
            ->method('sendRequest')
            ->willReturn(new Response(200, array(), $this->getResourceFakeResponseByName('getNoteTypes.json')))
        ;

        $result = $this->invokeMethod($client, 'getNoteTypes', array());

        $this->assertEquals('Call', $result[0]['Note Type']);
    }

    public function testGetRelatedRecords()
    {
        $client = $this->getClientMock(array('sendRequest'));

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
        $client = $this->getClientMock(array('sendRequest'));

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

    public function testGetAssociatedJobOpenings()
    {
        $client = $this->getClientMock(array('sendRequest'));

        $client
            ->expects($this->once())
            ->method('sendRequest')
            ->willReturn(new Response(200, array(), $this->getResourceFakeResponseByName('getAssociatedJobOpenings.json')))
        ;

        $result = $this->invokeMethod($client, 'getAssociatedJobOpenings', array(
            'fake_candidate_id'
        ));

        $this->assertEquals('Associated', $result[0]['STATUS']);
    }

    public function dataProviderChangeStatus()
    {
        return array(
            array('New'),
            array('Waiting-for-Evaluation'),
            array('Qualified'),
            array('Unqualified'),
            array('Junk candidate'),
            array('Contacted'),
            array('Contact in Future'),
            array('Not Contacted'),
            array('Attempted to Contact'),
            array('Associated'),
            array('Submitted-to-client'),
            array('Approved by client'),
            array('Rejected by client'),
            array('Interview-to-be-Scheduled'),
            array('Interview-Scheduled'),
            array('Rejected-for-Interview'),
            array('Interview-in-Progress'),
            array('On-Hold'),
            array('Hired'),
            array('Rejected'),
            array('Rejected-Hirable'),
            array('To-be-Offered'),
            array('Offer-Accepted'),
            array('Offer-Made'),
            array('Offer-Declined'),
            array('Offer-Withdrawn'),
            array('Joined'),
            array('No-Show'),
        );
    }

    /**
     * @dataProvider dataProviderChangeStatus
     */
    public function testChangeStatus($status)
    {
        $client = $this->getClientMock(array('sendRequest'));

        $client
            ->expects($this->once())
            ->method('sendRequest')
            ->willReturn(new Response(200, array(), $this->getResourceFakeResponseByName('changeStatus.json')))
        ;

        $result = $this->invokeMethod($client, 'changeStatus', array(
            array('fake_id_1', 'fake_id_2', 'fake_id_n'),
            $status
        ));

        $this->assertEquals('Candidate(s) status changed successfully', $result);
    }

    /**
     * @expectedException \Humantech\Zoho\Recruit\Api\Client\HttpApiException
     *
     * @dataProvider dataProviderChangeStatus
     */
    public function testChangeStatusHttpApiException($status)
    {
        $client = $this->getClientMock(array('sendRequest'));

        $this->invokeMethod($client, 'changeStatus', array(
            array('fake_id_1', 'fake_id_2', 'fake_id_n'),
            strtolower($status)
        ));
    }

    public function dataProviderUploadFile()
    {
        return array(
            array('Resume'),
            array('Others'),
        );
    }

    /**
     * @dataProvider dataProviderUploadFile
     */
    public function testUploadFile($type)
    {
        $client = $this->getClientMock(array('sendFile'));

        $client
            ->expects($this->once())
            ->method('sendFile')
            ->willReturn($this->getResourceFakeResponseByName('uploadFile.json'))
        ;

        $result = $this->invokeMethod($client, 'uploadFile', array(
            'fake_id',
            $type,
            'fake_resource'
        ));

        $this->assertEquals('File has been attached successfully', $result);
    }

    /**
     * @expectedException \Humantech\Zoho\Recruit\Api\Client\HttpApiException
     *
     * @dataProvider dataProviderUploadFile
     */
    public function testUploadFileHttpApiException($type)
    {
        $client = $this->getClientMock(array('sendFile'));

        $this->invokeMethod($client, 'uploadFile', array(
            'fake_id',
            strtolower($type),
            'fake_resource'
        ));
    }

    public function testDownloadFile()
    {
        $client = $this->getClientMock(array('sendRequest'));

        $client
            ->expects($this->once())
            ->method('sendRequest')
            ->willReturn(new Response(200, array('Content-Type' => 'application/x-downLoad'), 'fake_binary'))
        ;

        $result = $this->invokeMethod($client, 'downloadFile', array(
            'fake_id'
        ));

        $this->assertTrue(is_resource($result));
    }

    /**
     * @expectedException \Humantech\Zoho\Recruit\Api\Client\HttpApiException
     */
    public function testDownloadFileHttpApiException()
    {
        $client = $this->getClientMock(array('sendRequest'));

        $client
            ->expects($this->once())
            ->method('sendRequest')
            ->willReturn(new Response(200, array('Content-Type' => 'application/json'), 'fake_binary'))
        ;

        $this->invokeMethod($client, 'downloadFile', array(
            'fake_id'
        ));
    }

    public function testAssociateJobopening()
    {
        $client = $this->getClientMock(array('sendRequest'));

        $client
            ->expects($this->once())
            ->method('sendRequest')
            ->willReturn(new Response(200, array(), $this->getResourceFakeResponseByName('associateJobopening.json')))
        ;

        $result = $this->invokeMethod($client, 'associateJobopening', array(
            array('fake_id_1', 'fake_id_2', 'fake_id_n'),
            array('fake_id_1', 'fake_id_2', 'fake_id_n'),
        ));

        $this->assertEquals('Candidate(s) associated successfully', $result);
    }

    public function dataProviderUploadPhoto()
    {
        return array(
            array('Candidates'),
            array('Contacts'),
        );
    }

    /**
     * @dataProvider dataProviderUploadPhoto
     */
    public function testUploadPhoto($module)
    {
        $client = $this->getClientMock(array('sendFile'));

        $client
            ->expects($this->once())
            ->method('sendFile')
            ->willReturn($this->getResourceFakeResponseByName('uploadPhoto.json'))
        ;

        $result = $this->invokeMethod($client, 'uploadPhoto', array(
            $module,
            'fake_id',
            'fake_resource'
        ));

        // Note: the message error (in english) "succuessfully" in the response from ZohoAPI =/
        $this->assertEquals('Photo uploaded succuessfully', $result);
    }

    /**
     * @expectedException \Humantech\Zoho\Recruit\Api\Client\HttpApiException
     *
     * @dataProvider dataProviderUploadPhoto
     */
    public function testUploadPhotoHttpApiException($module)
    {
        $client = $this->getClientMock(array('sendFile'));

        $this->invokeMethod($client, 'uploadPhoto', array(
            strtolower($module),
            'fake_id',
            'fake_resource'
        ));
    }

    /**
     * @dataProvider dataProviderUploadPhoto
     */
    public function testDownloadPhoto($module)
    {
        $client = $this->getClientMock(array('sendRequest'));

        $client
            ->expects($this->once())
            ->method('sendRequest')
            ->willReturn(new Response(200, array('Content-Type' => 'application/x-downLoad'), 'fake_binary'))
        ;

        $result = $this->invokeMethod($client, 'downloadPhoto', array(
            $module,
            'fake_id'
        ));

        $this->assertTrue(is_resource($result));
    }

    /**
     * @expectedException \Humantech\Zoho\Recruit\Api\Client\HttpApiException
     *
     * @dataProvider dataProviderUploadPhoto
     */
    public function testDownloadPhotoHttpApiException($module)
    {
        $client = $this->getClientMock(array('sendRequest'));

        $client
            ->expects($this->once())
            ->method('sendRequest')
            ->willReturn(new Response(200, array('Content-Type' => 'application/json'), 'fake_binary'))
        ;

        $this->invokeMethod($client, 'downloadPhoto', array(
            $module,
            'fake_id'
        ));
    }

    /**
     * @expectedException \Humantech\Zoho\Recruit\Api\Client\HttpApiException
     *
     * @dataProvider dataProviderUploadPhoto
     */
    public function testDownloadPhotoInvalidModuleHttpApiException($module)
    {
        $client = $this->getClientMock(array('sendRequest'));

        $this->invokeMethod($client, 'downloadPhoto', array(
            strtolower($module),
            'fake_id'
        ));
    }

    public function testUploadDocument()
    {
        $client = $this->getClientMock(array('sendFile'));

        $client
            ->expects($this->once())
            ->method('sendFile')
            ->willReturn($this->getResourceFakeResponseByName('uploadDocument.json'))
        ;

        $result = $this->invokeMethod($client, 'uploadDocument', array(
            'fake_document_data',
            'fake_filename'
        ));

        $this->assertEquals('Candidate updated successfully', $result);
    }

    public function testGetModules()
    {
        $client = $this->getClientMock(array('sendRequest'));

        $client
            ->expects($this->once())
            ->method('sendRequest')
            ->willReturn(new Response(200, array(), $this->getResourceFakeResponseByName('getModules.json')))
        ;

        $result = $this->invokeMethod($client, 'getModules', array());

        $this->assertEquals('Job Openings', $result[0]['Job Opening']);
    }

    public function testGetAssociatedCandidates()
    {
        $client = $this->getClientMock(array('sendRequest'));

        $client
            ->expects($this->once())
            ->method('sendRequest')
            ->willReturn(new Response(200, array(), $this->getResourceFakeResponseByName('getAssociatedCandidates.json')))
        ;

        $result = $this->invokeMethod($client, 'getAssociatedCandidates', array(
            'fake_job_id'
        ));

        $this->assertEquals(307870000000100013, $result[0]['CANDIDATEID']);
    }

    public function testGetSearchRecords()
    {
        $client = $this->getClientMock(array('sendRequest'));

        $client
            ->expects($this->once())
            ->method('sendRequest')
            ->willReturn(new Response(200, array(), $this->getResourceFakeResponseByName('getSearchRecords.json')))
        ;

        $result = $this->invokeMethod($client, 'getSearchRecords', array(
            'Candidates',
            'fake_selected_columns',
            'fake_search_condition'
        ));

        $this->assertEquals('fake@humantech.com.br', $result[0]['Email']);
    }
}
