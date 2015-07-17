<?php

namespace Humantech\Zoho\Recruit\Api\Formatter\Response;

use Humantech\Zoho\Recruit\Api\Formatter\FormatterInterface;

class GenericResponseRowFormatter implements FormatterInterface
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

        $formatter = new GenericResponseItemFormatter();

        if (!isset($data[0])) {
            $data = array($data);
        }

        foreach ($data as $item) {
            $formattedItem = $formatter->formatter($item)->getOutput();

            $this->data[isset($formattedItem['val']) ? $formattedItem['val'] : $formattedItem['sl']] = $formattedItem['content'];
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
