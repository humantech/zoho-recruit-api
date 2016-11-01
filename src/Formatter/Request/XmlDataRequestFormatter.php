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

        if (!$this->isArray($data)) {
            $this->withoutBulk($data);

            return $this;
        }

        $this->withBulk($data);

        return $this;
    }

    /**
     * @param array $data
     *
     * @return bool
     */
    protected function isArray(array $data = [])
    {
        return !empty($data['data'][0]) && is_array($data['data'][0]);
    }

    /**
     * One or more elements in data array.
     *
     * @param array $data
     */
    protected function withBulk(array $data = [])
    {
        if (!$this->isArray($data)) {
            return;
        }

        foreach ($data['data'] as $index => $element) {
            $row = $this->data->addChild('row');

            $row->addAttribute('no', ++$index);

            foreach ($element as $key => $value) {
                $child = $row->addChild('FL', $value);

                $child->addAttribute('val', $key);
            }
        }
    }

    /**
     * Only one element in data array. For BC.
     *
     * @param array $data
     */
    protected function withoutBulk(array $data = [])
    {
        if ($this->isArray($data)) {
            return;
        }

        $row = $this->data->addChild('row');

        $row->addAttribute('no', 1);

        foreach ($data['data'] as $key => $value) {
            $child = $row->addChild('FL', $value);

            $child->addAttribute('val', $key);
        }
    }

    /**
     * @inheritdoc
     */
    public function getOutput()
    {
        return $this->data->asXML();
    }
}
