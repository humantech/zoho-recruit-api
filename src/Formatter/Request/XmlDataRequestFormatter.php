<?php

namespace Humantech\Zoho\Recruit\Api\Formatter\Request;

use Humantech\Zoho\Recruit\Api\Formatter\FormatterInterface;

class XmlDataRequestFormatter implements FormatterInterface
{
    /**
     * @var \SimpleXMLElement
     */
    private $data;

    /**
     * @inheritdoc
     */
    public function formatter(array $data)
    {
        $this->data = array();

        $this->data = new \SimpleXMLElement(sprintf('<%s />', $data['module']));

        $row = $this->data->addChild('row');

        $row->addAttribute('no', 1);

        foreach ($data['data'] as $key => $value) {
            $child = $row->addChild('FL', $value);

            $child->addAttribute('val', $key);
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getOutput()
    {
        return $this->data->asXML();
    }
}
