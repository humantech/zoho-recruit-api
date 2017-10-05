<?php

namespace Humantech\Zoho\Recruit\Api\Client;

use GuzzleHttp\Psr7\Response;
use Humantech\Zoho\Recruit\Api\Formatter\RequestFormatter;
use Humantech\Zoho\Recruit\Api\Formatter\ResponseFormatter;
use Humantech\Zoho\Recruit\Api\Formatter\ResponseListFormatter;
use Humantech\Zoho\Recruit\Api\Formatter\ResponseRowFormatter;
use Humantech\Zoho\Recruit\Api\Formatter\XmlRequestDataFormatter;
use Humantech\Zoho\Recruit\Api\Unserializer\UnserializerBuilder;

class Client extends AbstractClient implements ClientInterface
{
    const API_BASE_URL = 'https://recruit.zoho.com/recruit/private/%s/%s/%s?authtoken=%s';

    const API_DEFAULT_VERSION = 2;

    const API_DEFAULT_SCOPE = 'recruitapi';

    const API_RESPONSE_FORMAT_JSON = 'json';

    const API_RESPONSE_FORMAT_XML = 'xml';

    /**
     * @var string
     */
    protected $authToken;

    /**
     * @param string $authToken
     */
    public function __construct($authToken)
    {
        $this->authToken = $authToken;
    }

    /**
     * @param  string $module
     * @param  string $method
     * @param  string $responseFormat
     * @param  array  $requestParameters
     *
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    protected function getUri($module, $method, $responseFormat, array $requestParameters = array())
    {
        if (!$this->hasMethod($method)) {
            throw new \InvalidArgumentException(sprintf('The method %s is not registered', $method));
        }

        if (!$this->hasResponseFormat($responseFormat)) {
            throw new \InvalidArgumentException(sprintf('The response format %s is not registered', $responseFormat));
        }

        if (!isset($requestParameters['scope'])) {
            $requestParameters['scope'] = self::API_DEFAULT_SCOPE;
        }

        if (!isset($requestParameters['version'])) {
            $requestParameters['version'] = self::API_DEFAULT_VERSION;
        }

        $uri = sprintf(
            self::API_BASE_URL,
            $responseFormat,
            $module,
            $method,
            $this->getAuthToken()
        );

        return $uri . $this->generateQueryStringByRequestParams($requestParameters);
    }

    /**
     * @param  array $requestParameters
     *
     * @return string
     */
    protected function generateQueryStringByRequestParams(array $requestParameters)
    {
        return empty($requestParameters)
            ? ''
            : '&' . http_build_query($requestParameters)
        ;
    }

    /**
     * @param string $method
     *
     * @return bool
     */
    protected function hasMethod($method)
    {
        return in_array($method, array(
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
        ));
    }

    /**
     * @param string $responseFormat
     *
     * @return bool
     */
    protected function hasResponseFormat($responseFormat)
    {
        return in_array(strtolower($responseFormat), array(
            'json',
            'xml',
        ));
    }

    /**
     * @param  Response $response
     * @param  string   $responseFormat
     *
     * @return array
     */
    protected function getUnserializedData(Response $response, $responseFormat)
    {
        return UnserializerBuilder::create($responseFormat)->unserialize(
            $response->getBody()->getContents()
        );
    }

    /**
     * @inheritdoc
     */
    public function getAuthToken()
    {
        return $this->authToken;
    }

    /**
     * @inheritdoc
     */
    public function getRecords($module, array $additionalParams = array(), $responseFormat = self::API_RESPONSE_FORMAT_JSON)
    {
        $method = 'getRecords';

        $response = $this->sendRequest('GET', $this->getUri($module, $method, $responseFormat, $additionalParams));

        $unserializedData = $this->getUnserializedData($response, $responseFormat);

        return ResponseFormatter::create($module, $method)->formatter($unserializedData)->getOutput();
    }

    /**
     * @inheritdoc
     */
    public function getRecordById($module, $id, array $additionalParams = array(), $responseFormat = self::API_RESPONSE_FORMAT_JSON)
    {
        $method = 'getRecordById';

        $additionalParams['id'] = $id;

        $response = $this->sendRequest('GET', $this->getUri($module, $method, $responseFormat, $additionalParams));

        $unserializedData = $this->getUnserializedData($response, $responseFormat);

        return ResponseFormatter::create($module, $method)->formatter($unserializedData)->getOutput();
    }

    /**
     * @inheritdoc
     */
    public function addRecords($module, $data, array $additionalParams = array(), $responseFormat = self::API_RESPONSE_FORMAT_JSON)
    {
        $method = 'addRecords';

        $xmlData = RequestFormatter::create($module, 'addRecords')->formatter($data)->getOutput();

        $response = $this->sendRequest('POST',
            $this->getUri($module, $method, $responseFormat, $additionalParams),
            [
                'body'    => http_build_query(['xmlData' => $xmlData]),
                'headers' => ['Content-type' => 'application/x-www-form-urlencoded'],
            ]
        );

        $unserializedData = $this->getUnserializedData($response, $responseFormat);

        return ResponseFormatter::create($module, $method)->formatter($unserializedData)->getOutput();
    }

    /**
     * @inheritdoc
     */
    public function updateRecords($module, $id, $data, array $additionalParams = array(), $responseFormat = self::API_RESPONSE_FORMAT_JSON)
    {
        $method = 'updateRecords';

        $additionalParams['id']      = $id;
        $additionalParams['xmlData'] = RequestFormatter::create($module, 'updateRecords')->formatter($data)->getOutput();

        $response = $this->sendRequest('POST', $this->getUri($module, $method, $responseFormat, $additionalParams));

        $unserializedData = $this->getUnserializedData($response, $responseFormat);

        return ResponseFormatter::create($module, $method)->formatter($unserializedData)->getOutput();
    }

    /**
     * @inheritdoc
     */
    public function getNoteTypes(array $additionalParams = array(), $responseFormat = self::API_RESPONSE_FORMAT_JSON)
    {
        $module = 'Notes';
        $method = 'getNoteTypes';

        $response = $this->sendRequest('GET', $this->getUri($module, $method, $responseFormat, $additionalParams));

        $unserializedData = $this->getUnserializedData($response, $responseFormat);

        return ResponseFormatter::create($module, $method)->formatter($unserializedData)->getOutput();
    }

    /**
     * @inheritdoc
     */
    public function getRelatedRecords($module, $parentModule, $id, array $additionalParams = array(), $responseFormat = self::API_RESPONSE_FORMAT_JSON)
    {
        $method = 'getRelatedRecords';

        $additionalParams['parentModule'] = $parentModule;
        $additionalParams['id']           = $id;

        $response = $this->sendRequest('GET', $this->getUri($module, $method, $responseFormat, $additionalParams));

        $unserializedData = $this->getUnserializedData($response, $responseFormat);

        return ResponseFormatter::create($module, $method)->formatter($unserializedData)->getOutput();
    }

    /**
     * @inheritdoc
     */
    public function getFields($module, array $additionalParams = array(), $responseFormat = self::API_RESPONSE_FORMAT_JSON)
    {
        $method = 'getFields';

        $response = $this->sendRequest('GET', $this->getUri($module, $method, $responseFormat, $additionalParams));

        $unserializedData = $this->getUnserializedData($response, $responseFormat);

        return ResponseFormatter::create($module, $method)->formatter($unserializedData)->getOutput();
    }

    /**
     * @inheritdoc
     */
    public function getAssociatedJobOpenings($candidateId, array $additionalParams = array(), $responseFormat = self::API_RESPONSE_FORMAT_JSON)
    {
        $module = 'Candidates';
        $method = 'getAssociatedJobOpenings';

        $additionalParams['id'] = $candidateId;

        $response = $this->sendRequest('GET', $this->getUri($module, $method, $responseFormat, $additionalParams));

        $unserializedData = $this->getUnserializedData($response, $responseFormat);

        return ResponseFormatter::create($module, $method)->formatter($unserializedData)->getOutput();
    }

    /**
     * @inheritdoc
     */
    public function changeStatus(array $candidateIds, $candidateStatus, array $additionalParams = array(), $responseFormat = self::API_RESPONSE_FORMAT_JSON)
    {
        $module = 'Candidates';
        $method = 'changeStatus';

        if (!in_array($candidateStatus, array(
            'New',
            'Waiting-for-Evaluation',
            'Qualified',
            'Unqualified',
            'Junk candidate',
            'Contacted',
            'Contact in Future',
            'Not Contacted',
            'Attempted to Contact',
            'Associated',
            'Submitted-to-client',
            'Approved by client',
            'Rejected by client',
            'Interview-to-be-Scheduled',
            'Interview-Scheduled',
            'Rejected-for-Interview',
            'Interview-in-Progress',
            'On-Hold',
            'Hired',
            'Rejected',
            'Rejected-Hirable',
            'To-be-Offered',
            'Offer-Accepted',
            'Offer-Made',
            'Offer-Declined',
            'Offer-Withdrawn',
            'Joined',
            'No-Show',
        ))) {
            throw new HttpApiException(sprintf('The new status "%s" is invalid!', $candidateStatus));
        }

        $additionalParams['candidateIds']    = implode(',', $candidateIds);
        $additionalParams['candidateStatus'] = $candidateStatus;

        $response = $this->sendRequest('POST', $this->getUri($module, $method, $responseFormat, $additionalParams));

        $unserializedData = $this->getUnserializedData($response, $responseFormat);

        return ResponseFormatter::create($module, $method)->formatter($unserializedData)->getOutput();
    }

    /**
     * @inheritdoc
     */
    public function uploadFile($id, $type, $resource, array $additionalParams = array(), $responseFormat = self::API_RESPONSE_FORMAT_JSON)
    {
        $module = 'Candidates';
        $method = 'uploadFile';

        if (!in_array($type, array(
            'Resume',
            'Others',
        ))) {
            throw new HttpApiException(sprintf('The type of upload "%s" is invalid!', $type));
        }

        $additionalParams['id']   = $id;
        $additionalParams['type'] = $type;

        $response = $this->sendFile($this->getUri($module, $method, $responseFormat, $additionalParams), array(
            'content' => $resource
        ));

        $unserializedData = $this->getUnserializedData(new Response(200, array(), $response), $responseFormat);

        return ResponseFormatter::create($module, $method)->formatter($unserializedData)->getOutput();
    }

    /**
     * @inheritdoc
     */
     public function downloadFile($id, array $additionalParams = array(), $responseFormat = self::API_RESPONSE_FORMAT_JSON)
     {
         $module = 'Candidates';
         $method = 'downloadFile';

         $additionalParams['id'] = $id;

         $response = $this->sendRequest('GET', $this->getUri($module, $method, $responseFormat, $additionalParams));

         $unserializedData = $this->getUnserializedData($response, $responseFormat);

         $formatterData = array(
             'download' => $response,
             'params'   => array('unserializedData' => $unserializedData)
         );

         return ResponseFormatter::create($module, $method)->formatter($formatterData)->getOutput();
     }

    /**
     * @inheritdoc
     */
    public function associateJobopening(array $jobIds, array $candidateIds, array $additionalParams = array(), $responseFormat = self::API_RESPONSE_FORMAT_JSON)
    {
        $module = 'Candidates';
        $method = 'associateJobOpening';

        $additionalParams['jobIds']       = implode(',', $jobIds);
        $additionalParams['candidateIds'] = implode(',', $candidateIds);

        $response = $this->sendRequest('POST', $this->getUri($module, $method, $responseFormat, $additionalParams));

        $unserializedData = $this->getUnserializedData($response, $responseFormat);

        return ResponseFormatter::create($module, $method)->formatter($unserializedData)->getOutput();
    }

    /**
     * @inheritdoc
     */
    public function uploadPhoto($module, $id, $resource, array $additionalParams = array(), $responseFormat = self::API_RESPONSE_FORMAT_JSON)
    {
        $method = 'uploadPhoto';

        if (!in_array($module, array(
            'Candidates',
            'Contacts',
        ))) {
            throw new HttpApiException(sprintf('The module "%s" is invalid!', $module));
        }

        $additionalParams['id'] = $id;

        $response = $this->sendFile($this->getUri($module, $method, $responseFormat, $additionalParams), array(
            'content' => $resource
        ));

        $unserializedData = $this->getUnserializedData(new Response(200, array(), $response), $responseFormat);

        return ResponseFormatter::create($module, $method)->formatter($unserializedData)->getOutput();
    }

    /**
     * @inheritdoc
     */
    public function downloadPhoto($module, $id, array $additionalParams = array(), $responseFormat = self::API_RESPONSE_FORMAT_JSON)
    {
        $method = 'downloadPhoto';

        if (!in_array($module, array(
            'Candidates',
            'Contacts',
        ))) {
            throw new HttpApiException(sprintf('The module "%s" is invalid!', $module));
        }

        $additionalParams['id'] = $id;

        $response = $this->sendRequest('GET', $this->getUri($module, $method, $responseFormat, $additionalParams));

        $unserializedData = $this->getUnserializedData($response, $responseFormat);

        $formatterData = array(
            'download' => $response,
            'params'   => array('unserializedData' => $unserializedData)
        );

        return ResponseFormatter::create($module, $method)->formatter($formatterData)->getOutput();
    }

    /**
     * @inheritdoc
     */
    public function uploadDocument($documentData, $fileName, array $additionalParams = array(), $responseFormat = self::API_RESPONSE_FORMAT_JSON)
    {
        $module = 'Candidates';
        $method = 'uploadDocument';

        $additionalParams['fileName'] = $fileName;

        $response = $this->sendFile($this->getUri($module, $method, $responseFormat, $additionalParams), array(
            'documentData' => base64_encode($documentData)
        ));

        $unserializedData = $this->getUnserializedData(new Response(200, array(), $response), $responseFormat);

        return ResponseFormatter::create($module, $method)->formatter($unserializedData)->getOutput();
    }

    /**
     * @inheritdoc
     */
    public function getModules(array $additionalParams = array(), $responseFormat = self::API_RESPONSE_FORMAT_JSON)
    {
        $module = 'Info';
        $method = 'getModules';

        $response = $this->sendRequest('GET', $this->getUri($module, $method, $responseFormat, $additionalParams));

        $unserializedData = $this->getUnserializedData($response, $responseFormat);

        return ResponseFormatter::create($module, $method)->formatter($unserializedData)->getOutput();
    }

    /**
     * @inheritdoc
     */
    public function getAssociatedCandidates($jobId, array $additionalParams = array(), $responseFormat = self::API_RESPONSE_FORMAT_JSON)
    {
        $module = 'JobOpenings';
        $method = 'getAssociatedCandidates';

        $additionalParams['id'] = $jobId;

        $response = $this->sendRequest('GET', $this->getUri($module, $method, $responseFormat, $additionalParams));

        $unserializedData = $this->getUnserializedData($response, $responseFormat);

        return ResponseFormatter::create($module, $method)->formatter($unserializedData)->getOutput();
    }

    /**
     * @inheritdoc
     */
    public function getSearchRecords($module, $selectColumns, $searchCondition, array $additionalParams = array(), $responseFormat = self::API_RESPONSE_FORMAT_JSON)
    {
        $method = 'getSearchRecords';

        $additionalParams['selectColumns']   = $selectColumns;
        $additionalParams['searchCondition'] = $searchCondition;

        $response = $this->sendRequest('GET', $this->getUri($module, $method, $responseFormat, $additionalParams));

        $unserializedData = $this->getUnserializedData($response, $responseFormat);

        return ResponseFormatter::create($module, $method)->formatter($unserializedData)->getOutput();
    }
}
