<?php

namespace Humantech\Zoho\Recruit\Api\Formatter;

use Humantech\Zoho\Recruit\Api\Formatter\Request\XmlDataRequestFormatter;

class RequestFormatter extends AbstractFormatter implements FormatterInterface
{
    /**
     * @inheritdoc
     */
    public function formatter(array $data)
    {
        $this->originalData = $data;

        if (in_array($this->method, array('addRecords', 'updateRecords'))) {
            $this->setFormatter(new XmlDataRequestFormatter());

            $this->getFormatter()->formatter(array(
                'module' => $this->getModule(),
                'method' => $this->getMethod(),
                'data'   => $this->getOriginalData(),
            ));
        }

        return $this;
    }
}
