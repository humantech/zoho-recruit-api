<?php

namespace Humantech\Zoho\Recruit\Api\Formatter;

class ResponseItemFormatter implements FormatterInterface
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
        $keyName  = 'val';
        $keyValue = 'content';

        $data[$keyName]  = trim(str_replace(' ', '', $data[$keyName]));
        $data[$keyValue] = trim($data[$keyValue]);

        if (is_numeric($data[$keyValue])) {
            $this->data = array(
                $keyName  => $data[$keyName],
                $keyValue => strpos($data[$keyValue], '.') === false ? (int) $data[$keyValue] : (float) $data[$keyValue],
            );

            return $this;
        }

        if (in_array($data[$keyValue], array('false', 'true'))) {
            $this->data = array(
                $keyName  => $data[$keyName],
                $keyValue => $data[$keyValue] === 'false' ? false : true,
            );

            return $this;
        }

        if (is_string($data[$keyValue])) {
            $this->data = array(
                $keyName  => $data[$keyName],
                $keyValue => empty($data[$keyValue]) ? null : $data[$keyValue],
            );

            return $this;
        }

        $this->data = array(
            $keyName  => $data[$keyName],
            $keyValue => $data[$keyValue],
        );

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
