<?php

namespace Humantech\Zoho\Recruit\Api\Client;

class AuthenticationClient extends AbstractClient
{
    const API_AUTH_URL = 'https://accounts.zoho.com/apiauthtoken/nb/create?SCOPE=%s&EMAIL_ID=%s&PASSWORD=%s';

    /**
     * @param  string $username
     * @param  string $password
     *
     * @return string
     *
     * @throws AuthenticationClientException
     */
    public function generateAuthToken($username, $password)
    {
        $response = $this->sendRequest('GET', sprintf(
            self::API_AUTH_URL,
            'ZohoRecruit/recruitapi',
            urlencode($username),
            urlencode($password)
        ));

        $content = $response->getBody()->getContents();

        if (strpos($content, 'RESULT=TRUE') === false) {
            preg_match('/CAUSE\=(\w*)/i', $content, $matches);

            throw new AuthenticationClientException($matches[1]);
        }

        preg_match('/AUTHTOKEN\=(\S*)/i', $content, $matches);

        return $matches[1];
    }
}
