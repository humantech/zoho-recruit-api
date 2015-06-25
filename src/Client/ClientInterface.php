<?php

namespace Humantech\Zoho\Recruit\Api\Client;

interface ClientInterface
{
    /**
     * @return string
     */
    public function getAuthToken();

    /**
     * @param  string $module
     * @param  array  $additionalParams
     * @param  string $responseFormat
     *
     * @return array
     */
    public function getRecords($module, array $additionalParams, $responseFormat);
}
