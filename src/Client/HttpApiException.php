<?php

namespace Humantech\Zoho\Recruit\Api\Client;

class HttpApiException extends \RuntimeException
{
    /**
     * @var string
     */
    protected $uri;

    /**
     * @param string     $message
     * @param int        $code
     * @param string     $uri
     * @param \Exception $previous
     */
    public function __construct($message, $code, $uri, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->uri = $uri;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }
}
