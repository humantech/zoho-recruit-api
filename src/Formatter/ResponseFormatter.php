<?php

namespace Humantech\Zoho\Recruit\Api\Formatter;

use Humantech\Zoho\Recruit\Api\Formatter\Response\ErrorResponseFormatter;
use Humantech\Zoho\Recruit\Api\Formatter\Response\GenericResponseFormatter;
use Humantech\Zoho\Recruit\Api\Formatter\Response\GetFieldsResponseFormatter;
use Humantech\Zoho\Recruit\Api\Formatter\Response\GetModulesResponseFormatter;
use Humantech\Zoho\Recruit\Api\Formatter\Response\MessageResponseFormatter;
use Humantech\Zoho\Recruit\Api\Formatter\Response\NoDataResponseFormatter;

class ResponseFormatter extends AbstractFormatter implements FormatterInterface
{
    /**
     * @inheritdoc
     */
    public function formatter(array $data)
    {
        $this->originalData = $data;

        if (isset($data['response']['nodata'])) {
            $this->formatter = new NoDataResponseFormatter();
        } elseif (isset($data['response']['result']['message']) || isset($data['response']['success']['message'])) {
            $this->formatter = new MessageResponseFormatter();
        } elseif (isset($data['response']['error'])) {
            $this->formatter = new ErrorResponseFormatter();
        } elseif ($this->isMethod('getFields')) {
            $this->formatter = new GetFieldsResponseFormatter();
        } elseif ($this->isMethod('getModules')) {
            $this->formatter = new GetModulesResponseFormatter();
        } elseif (in_array($this->getMethod(), array(
            'getRecords',
            'getRecordById',
            'getNoteTypes',
            'getRelatedRecords',
            'getAssociatedCandidates',
            'getSearchRecords',
        ))) {
            $this->formatter = new GenericResponseFormatter();
        }

        if ($this->formatter instanceof FormatterInterface) {
            $this->getFormatter()->formatter(array(
                'module' => $this->getModule(),
                'method' => $this->getMethod(),
                'data'   => $this->getOriginalData(),
            ));
        }

        return $this;
    }
}
