<?php

namespace Humantech\Zoho\Recruit\Api\Formatter\Response;

use Humantech\Zoho\Recruit\Api\Formatter\FormatterInterface;

class GenericResponseItemFormatter implements FormatterInterface
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
        $keyName  = isset($data['val']) ? 'val' : 'sl';
        $keyValue = 'content';

        $data[$keyName]  = trim($data[$keyName]);
        $data[$keyValue] = trim($data[$keyValue]);

        if (is_numeric($data[$keyValue]) && strlen($data[$keyValue]) <= 10) {
            $this->data = array(
                $keyName  => $data[$keyName],
                $keyValue => strpos($data[$keyValue], '.') === false ? (int) $data[$keyValue] : (float) $data[$keyValue],
            );

            return $this;
        }

        if (in_array(strtolower($data[$keyValue]), array('false', 'true'))) {
            $this->data = array(
                $keyName  => $data[$keyName],
                $keyValue => strtolower($data[$keyValue]) === 'false' ? false : true,
            );

            return $this;
        }

        if (($date = \DateTime::createFromFormat('Y-m-d H:i:s', $data[$keyValue] . ' 00:00:00')) !== false) {
            $this->data = array(
                $keyName  => $data[$keyName],
                $keyValue => $date,
            );

            return $this;
        }

        if (($datetime = \DateTime::createFromFormat('Y-m-d H:i:s', $data[$keyValue])) !== false) {
            $this->data = array(
                $keyName  => $data[$keyName],
                $keyValue => $datetime,
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
