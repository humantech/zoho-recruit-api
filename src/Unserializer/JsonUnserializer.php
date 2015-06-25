<?php

namespace Humantech\Zoho\Recruit\Api\Unserializer;

class JsonUnserializer implements UnserializerInterface
{
    /**
     * @inheritdoc
     */
    public function unserialize($data)
    {
        return json_decode($data, true);
    }
}
