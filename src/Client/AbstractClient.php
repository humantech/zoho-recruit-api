<?php

namespace Humantech\Zoho\Recruit\Api\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

abstract class AbstractClient
{
    /**
     * @param  string $method
     * @param  string $uri
     * @param  array  $extraParameters
     *
     * @return Request
     */
    protected function createGuzzleRequest($method, $uri, array $extraParameters)
    {
        $extraParameters = $this->mergeGuzzleRequestExtraParams($extraParameters);

        return new Request(
            strtoupper($method),
            $uri,
            $extraParameters['headers'],
            $extraParameters['body'],
            $extraParameters['protocolVersion']
        );
    }

    /**
     * @param  array $extraParameters
     *
     * @return array
     */
    protected function mergeGuzzleRequestExtraParams(array $extraParameters)
    {
        $defaultParams = array(
            'headers'         => array(),
            'body'            => null,
            'protocolVersion' => '1.1',
        );

        return array_merge($defaultParams, $extraParameters);
    }

    /**
     * @return Client
     */
    protected function getGuzzleClientIntance()
    {
        return new Client();
    }

    /**
     * @param  string $method
     * @param  string $uri
     * @param  array  $extraParameters
     * @param  array  $clientOptions
     *
     * @return Response
     *
     * @throws \LogicException
     */
    protected function sendRequest($method, $uri, array $extraParameters = array(), array $clientOptions = array())
    {
        $request = $this->createGuzzleRequest($method, $uri, $extraParameters);

        $client = $this->getGuzzleClientIntance();

        return $client->send($request, $clientOptions);
    }

    /**
     * @return resource
     */
    protected function initCurlUpload()
    {
        return curl_init();
    }

    /**
     * @param  resource $curlResource
     * @return mixed
     */
    protected function execCurlUpload($curlResource)
    {
        return curl_exec($curlResource);
    }

    /**
     * @param  resource $curlResource
     * @param  array    $options
     *
     * @return bool
     */
    protected function setOptionsCurlUpload($curlResource, array $options)
    {
        foreach ($options as $key => $value) {
            curl_setopt($curlResource, $key, $value);
        }

        return $curlResource;
    }

    /**
     * @param  string $uri
     * @param  array  $postFields
     *
     * @return array
     */
    protected function getOptionsCurlUpload($uri, array $postFields)
    {
        return array(
            CURLOPT_HEADER         => 0,
            CURLOPT_VERBOSE        => 0,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL            => $uri,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $postFields,
        );
    }

    /**
     * @param  string $uri
     * @param  array  $postFields
     *
     * @return string|bool
     */
    protected function sendFile($uri, array $postFields)
    {
        $curlResource = $this->initCurlUpload();

        $curlOptions  = $this->getOptionsCurlUpload($uri, $postFields);

        $curlResource = $this->setOptionsCurlUpload($curlResource, $curlOptions);

        return $this->execCurlUpload($curlResource);
    }
}
