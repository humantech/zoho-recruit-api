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

    /**
     * @param  string $module
     * @param  int    $id
     * @param  array  $additionalParams
     * @param  string $responseFormat
     *
     * @return array
     */
    public function getRecordById($module, $id, array $additionalParams, $responseFormat);

    /**
     * @param  string $module
     * @param  array  $data
     * @param  array  $additionalParams
     * @param  string $responseFormat
     *
     * @return string
     */
    public function addRecords($module, $data, array $additionalParams, $responseFormat);
}
