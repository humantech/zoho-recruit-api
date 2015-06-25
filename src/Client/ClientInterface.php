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

    /**
     * @param  string $module
     * @param  int    $id
     * @param  array  $data
     * @param  array  $additionalParams
     * @param  string $responseFormat
     *
     * @return string
     */
    public function updateRecords($module, $id, $data, array $additionalParams, $responseFormat);

    /**
     * @param  array  $additionalParams
     * @param  string $responseFormat
     *
     * @return array
     */
    public function getNoteTypes(array $additionalParams, $responseFormat);

    /**
     * @param  int    $parentModule
     * @param  int    $id
     * @param  array  $additionalParams
     * @param  string $responseFormat
     *
     * @return array
     */
    public function getRelatedRecords($parentModule, $id, array $additionalParams, $responseFormat);

    /**
     * @param  string $module
     * @param  array  $data
     * @param  array  $additionalParams
     * @param  string $responseFormat
     *
     * @return array
     */
    public function getFields($module, $data, array $additionalParams, $responseFormat);

    /**
     * @param  array  $candidateIds
     * @param  array  $additionalParams
     * @param  string $responseFormat
     *
     * @return string
     */
    public function changeStatus(array $candidateIds, array $additionalParams, $responseFormat);

    /**
     * @param  int    $id
     * @param  mixed  $resource
     * @param  string $type
     * @param  array  $additionalParams
     * @param  string $responseFormat
     *
     * @return string
     */
    public function uploadFile($id, $resource, $type, array $additionalParams, $responseFormat);

    /**
     * @param  int    $id
     * @param  array  $additionalParams
     * @param  string $responseFormat
     *
     * @return mixed
     */
    public function downloadFile($id, array $additionalParams, $responseFormat);

    /**
     * @param  string $module
     * @param  int    $id
     * @param  mixed  $resource
     * @param  array  $additionalParams
     * @param  string $responseFormat
     *
     * @return string
     */
    public function uploadPhoto($module, $id, $resource, array $additionalParams, $responseFormat);

    /**
     * @param  string $module
     * @param  int    $id
     * @param  array  $additionalParams
     * @param  string $responseFormat
     *
     * @return mixed
     */
    public function downloadPhoto($module, $id, array $additionalParams, $responseFormat);

    /**
     * @param  mixed  $documentData
     * @param  string $fileName
     * @param  array  $additionalParams
     * @param  string $responseFormat
     *
     * @return mixed
     */
    public function uploadDocument($documentData, $fileName, array $additionalParams, $responseFormat);

    /**
     * @param  array  $additionalParams
     * @param  string $responseFormat
     *
     * @return array
     */
    public function getModules(array $additionalParams, $responseFormat);

    /**
     * @param  int    $jobId
     * @param  array  $additionalParams
     * @param  string $responseFormat
     *
     * @return array
     */
    public function getAssociatedCandidates($jobId, array $additionalParams, $responseFormat);
}
