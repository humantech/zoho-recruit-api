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
        if (isset($data['data']['response']['result']['message'])) {
            $data = $data['data']['response']['result']['message'];
        } else {
            $data = $data['data']['response']['success']['message'];
        }

        $this->data = trim($data);
    }

    /**
     * @inheritdoc
     */
    public function getOutput()
    {
        return $this->data;
    }
}
