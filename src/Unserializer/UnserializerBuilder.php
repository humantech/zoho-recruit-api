<?php

namespace Humantech\Zoho\Recruit\Api\Unserializer;

class UnserializerBuilder implements UnserializerInterface
{
    /**
     * @var UnserializerInterface
     */
    private $unserializer;

    /**
     * @param string $responseFormat
     */
    private function __construct($responseFormat)
    {
        $this->unserializer = $this->getUnserializerByResponseFormat($responseFormat);
    }

    /**
     * @param  string $responseFormat
     *
     * @return UnserializerInterface
     *
     * @throws \InvalidArgumentException
     */
    private function getUnserializerByResponseFormat($responseFormat)
    {
        switch (strtolower(trim($responseFormat))) {
            case 'json':
                return new JsonUnserializer();
                break;

            case 'xml':
                return new XmlUnserializer();
                break;
        }

        throw new \InvalidArgumentException('The format of the response is invalid');
    }

    /**
     * @param string $responseFormat
     *
     * @return UnserializerBuilder
     */
    public static function create($responseFormat)
    {
        return new static($responseFormat);
    }

    /**
     * @inheritdoc
     */
    public function unserialize($data)
    {
        return $this->unserializer->unserialize($data);
    }
}
