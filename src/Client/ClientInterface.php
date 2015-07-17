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
     * @param  string $module
     * @param  string $parentModule
     * @param  int    $id
     * @param  array  $additionalParams
     * @param  string $responseFormat
     *
     * @return array
     */
    public function getRelatedRecords($module, $parentModule, $id, array $additionalParams, $responseFormat);

    /**
     * @param  string $module
     * @param  array  $additionalParams
     * @param  string $responseFormat
     *
     * @return array
     */
    public function getFields($module, array $additionalParams, $responseFormat);

    /**
     * @param  string $candidateId
     * @param  array  $additionalParams
     * @param  string $responseFormat
     *
     * @return array
     */
    public function getAssociatedJobOpenings($candidateId, array $additionalParams, $responseFormat);

    /**
     * @param  array  $candidateIds
     * @param  string $candidateStatus
     * @param  array  $additionalParams
     * @param  string $responseFormat
     *
     * @return string
     */
    public function changeStatus(array $candidateIds, $candidateStatus, array $additionalParams, $responseFormat);

    /**
     * @param  int    $id
     * @param  string $type
     * @param  mixed  $resource
     * @param  array  $additionalParams
     * @param  string $responseFormat
     *
     * @return string
     */
    public function uploadFile($id, $type, $resource, array $additionalParams, $responseFormat);

    /**
     * @param  int    $id
     * @param  string $saveToFile
     * @param  array  $additionalParams
     * @param  string $responseFormat
     *
     * @return string
     */
    public function downloadFile($id, $saveToFile, array $additionalParams, $responseFormat);

    /**
     * @param  array  $jobIds
     * @param  array  $candidateIds
     * @param  array  $additionalParams
     * @param  string $responseFormat
     *
     * @return string
     */
    public function associateJobopening(array $jobIds, array $candidateIds, array $additionalParams, $responseFormat);

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
     * @param  string $saveToFile
     * @param  array  $additionalParams
     * @param  string $responseFormat
     *
     * @return string
     */
    public function downloadPhoto($module, $id, $saveToFile, array $additionalParams, $responseFormat);

    /**
     * @param  string $documentData
     * @param  string $fileName
     * @param  array  $additionalParams
     * @param  string $responseFormat
     *
     * @return string
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

    /**
     * @param  string $module
     * @param  string $selectColumns
     * @param  mixed  $searchCondition
     * @param  array  $additionalParams
     * @param  string $responseFormat
     *
     * @return array
     */
    public function getSearchRecords($module, $selectColumns, $searchCondition, array $additionalParams, $responseFormat);
}
