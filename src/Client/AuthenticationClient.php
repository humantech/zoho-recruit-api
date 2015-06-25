<?php

namespace Humantech\Zoho\Recruit\Api\Client;

class AuthenticationClient extends AbstractClient
{
    const API_AUTH_URL = 'https://accounts.zoho.com/apiauthtoken/nb/create?SCOPE=%s&EMAIL_ID=%s&PASSWORD=%s';
}
