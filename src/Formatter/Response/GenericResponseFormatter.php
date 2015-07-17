<?php

namespace Humantech\Zoho\Recruit\Api\Formatter\Response;

use Humantech\Zoho\Recruit\Api\Formatter\FormatterInterface;

class GenericResponseFormatter implements FormatterInterface
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var bool
     */
    private $isSingleResult;

    /**
     * @inheritdoc
     */
    public function formatter(array $data)
    {
        $result = $data['data']['response']['result'][$data['module']]['row'];

        $this->isSingleResult = isset($result['FL']);

        $formatter = $this->isSingleResult
            ? (new GenericResponseRowFormatter())->formatter($result['FL'])
            : (new GenericResponseListFormatter())->formatter($result)
        ;

        $this->data = $formatter->getOutput();

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getOutput()
    {
        return $this->isSingleResult === true ? array($this->data) : $this->data;
    }
}
