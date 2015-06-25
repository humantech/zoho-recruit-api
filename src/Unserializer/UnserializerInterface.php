<?php

namespace Humantech\Zoho\Recruit\Api\Unserializer;

interface UnserializerInterface
{
    /**
     * @param  string $data
     *
     * @return array
     */
    public function unserialize($data);
}
