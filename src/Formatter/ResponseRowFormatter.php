<?php

namespace Humantech\Zoho\Recruit\Api\Formatter;

class ResponseRowFormatter implements FormatterInterface
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

        $formatter = new ResponseItemFormatter();

        foreach ($data as $item) {
            $formattedItem = $formatter->formatter($item)->getOutput();

            $this->data[$formattedItem['val']] = $formattedItem['content'];
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
