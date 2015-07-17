<?php

namespace Humantech\Zoho\Recruit\Api\Formatter\Response;

use Humantech\Zoho\Recruit\Api\Formatter\FormatterInterface;

class MessageResponseFormatter implements FormatterInterface
{
    /**
     * @var array
     */
    private $data;

    /**
     * @inheritdoc
     */
    public function formatter(array $data)
    {
        $this->data = isset($data['data']['response']['result']['message'])
            ? trim($data['data']['response']['result']['message'])
            : trim($data['data']['response']['success']['message'])
        ;
    }

    /**
     * @inheritdoc
     */
    public function getOutput()
    {
        return $this->data;
    }
}
