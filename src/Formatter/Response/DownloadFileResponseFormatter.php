<?php

namespace Humantech\Zoho\Recruit\Api\Formatter\Response;

use Humantech\Zoho\Recruit\Api\Formatter\FormatterInterface;
use Humantech\Zoho\Recruit\Api\Client\HttpApiException;

class DownloadFileResponseFormatter implements FormatterInterface
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
        $response = $data['data']['download'];

        $header = $response->getHeader('Content-Type');
        $body   = $response->getBody();

        if ('application/x-downLoad' === $header[0]) {
            return $this->data = $body->detach();
        }

        $formatter = $this->getErrorResponseFormatter();

        $formatter->formatter(array(
            'module' => $data['module'],
            'method' => $data['method'],
            'data'   => $data['params']['unserializedData']
        ));

        $output = $formatter->getOutput();

        throw new HttpApiException(
            $output['message'],
            $output['code'],
            $output['uri']
        );
    }

    protected function getErrorResponseFormatter()
    {
        return new ErrorResponseFormatter();
    }

    /**
     * @inheritdoc
     */
    public function getOutput()
    {
        return $this->data;
    }
}
