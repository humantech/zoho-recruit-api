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
     *
     * @return Response
     *
     * @throws \LogicException
     */
    protected function sendRequest($method, $uri)
    {
        $request = new Request(strtoupper($method), $uri);

        $client = new Client();

        return $client->send($request);
    }
}
