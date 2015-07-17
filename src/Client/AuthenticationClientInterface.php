<?php

namespace Humantech\Zoho\Recruit\Api\Client;

interface AuthenticationClientInterface
{
    /**
     * @param  string $username
     * @param  string $password
     *
     * @return string
     *
     * @throws AuthenticationClientException
     */
    public function generateAuthToken($username, $password);
}
