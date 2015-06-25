<?php

namespace Humantech\Zoho\Recruit\Api\Formatter;

class ResponseListFormatter implements FormatterInterface
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
        $this->data = array();

        $formatter = new ResponseRowFormatter();

        foreach ($data as $item) {
            $this->data[] = $formatter->formatter($item['FL'])->getOutput();
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getOutput()
    {
        return $this->data;
    }
}
