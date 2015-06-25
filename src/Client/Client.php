<?php

namespace Humantech\Zoho\Recruit\Api\Client;

class Client extends AbstractClient implements ClientInterface
{
    const API_BASE_URL = 'https://recruit.zoho.com/recruit/private/%s/%s/%s?authtoken=%s';

    const API_DEFAULT_VERSION = 2;

    const API_DEFAULT_SCOPE = 'recruitapi';

    const API_RESPONSE_FORMAT_JSON = 'json';

    const API_RESPONSE_FORMAT_XML = 'xml';
}
