<?php

namespace Humantech\Zoho\Recruit\Api\Client;

use GuzzleHttp\Psr7\Response;

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
     * @param  string $httpMethod
     * @param  string $module
     * @param  string $method
     * @param  string $responseFormat
     * @param  array  $requestParameters
     *
     * @return Response
     *
     * @throws \InvalidArgumentException
     */
    protected function callApi($httpMethod, $module, $method, $responseFormat, array $requestParameters)
    {
        if (!$this->hasMethod($method)) {
            throw new \InvalidArgumentException(sprintf('The method %s is not registered', $method));
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

        return $this->sendRequest($httpMethod, $uri);
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
     * @inheritdoc
     */
    public function getAuthToken()
    {
        return $this->authToken;
    }
}
