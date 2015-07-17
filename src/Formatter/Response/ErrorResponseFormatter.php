<?php

namespace Humantech\Zoho\Recruit\Api\Formatter\Response;

use Humantech\Zoho\Recruit\Api\Formatter\FormatterInterface;

class ErrorResponseFormatter implements FormatterInterface
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
        $error = $data['data']['response']['error'];
        $uri   = $data['data']['response']['uri'];

        $this->data = array(
            'code'    => (int) trim($error['code']),
            'message' => trim($error['message']),
            'uri'     => trim($uri),
        );
    }

    /**
     * @inheritdoc
     */
    public function getOutput()
    {
        return $this->data;
    }
}
