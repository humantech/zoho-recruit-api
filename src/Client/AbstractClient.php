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
     * @param  array  $clientOptions
     *
     * @return Response
     *
     * @throws \LogicException
     */
    protected function sendRequest($method, $uri, array $extraParameters = array(), array $clientOptions = array())
    {
        $request = new Request(
            strtoupper($method),
            $uri,
            !isset($extraParameters['headers'])         ? array() : $extraParameters['headers'],
            !isset($extraParameters['body'])            ? null    : $extraParameters['body'],
            !isset($extraParameters['protocolVersion']) ? '1.1'   : $extraParameters['protocolVersion']
        );

        $client = new Client();

        return $client->send($request, $clientOptions);
    }
    }
}
