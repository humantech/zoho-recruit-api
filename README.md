Zoho Recruit API
==============

PHP Zoho Recruit API.

### Dependencies

 - PHP 5.5;
 - guzzlehttp/guzzle:~6.0.

Installation
------------

The installation process can be performed by two ways, using the [packagist](https://packagist.org/packages/humantech/zoho-recruit-api) or cloning this repository.

### Packagist

Open a terminal and tip the below command:

```sh
$ composer require humantech/zoho-recruit-api
```

### Cloning

```sh
$ git clone https://github.com/humantech/zoho-recruit-api.git
$ composer install
```

Documentation
-------------

This package is compatible with PSR-2 and PSR-4. 

### Getting the Auth Token

To get the Auth token you have that instance a class called AuthenticationClient and pass two
parameters to a method called generateAuthToken, a username and a plain password like the example below.

```php
<?php

$authClient = new \Humantech\Zoho\Recruit\Api\Client\AuthenticationClient();

$token = $authClient->generateAuthToken('youruser@yourcompany.com', 'your-password');

```

### Calling the getRecords

Given the Zoho Recruit Api documentation to method [getRecords](https://www.zoho.com/recruit/api-new/api-methods/getRecordsMethod.html), you
can get the records from Candidates like the following example:

```php
<?php

$client = new \Humantech\Zoho\Recruit\Api\Client\Client($token);

$jobOpenings = $client->getRecords('JobOpenings');

```

### More

See more examples in the [demo](https://github.com/humantech/zoho-recruit-api/blob/master/demo.php) file or in PHPUnit test classes.

License
-------

This package is under the MIT license. [See the complete license](https://github.com/humantech/zoho-recruit-api/blob/master/LICENSE).
