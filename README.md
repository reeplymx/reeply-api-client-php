Reeply API Client
================

Reeply API client library and example for PHP.

API Documentation [https://www.reeply.mx/api](https://www.reeply.mx/api)

---

### Requirements

- php: >=7.1
- ext-json: *
- ext-curl: *

---

### Installation

Via Composer:

```bash
composer require reeplymx/reeply-api-client-php
```

---

### Example

```php
<?php

require 'vendor/autoload.php';

use Reeply\ApiClient\Http\ApiClientException;
use Reeply\ApiClient\Http\ApiRequestException;
use Reeply\ApiClient\Http\CurlApiClient;
use Reeply\ApiClient\Services\Messaging\Messaging;

$token = 'YOUR_API_TOKEN';
$sandboxMode = true;

/*
 * Send SMS message
 */
try {
    $client = new CurlApiClient($token, $sandboxMode);

    $messaging = new Messaging($client);

    $result = $messaging->sendSms(
        '+123456789',
        'Hello, World!'
    );

    var_dump($result);
} catch (ApiClientException $e) {
    echo 'API client error: ' . $e->getMessage() . PHP_EOL;
    var_dump($e);
} catch (ApiRequestException $e) {
    echo 'API request error: ' . $e->getMessage() . PHP_EOL;
    var_dump($e);
}
```
