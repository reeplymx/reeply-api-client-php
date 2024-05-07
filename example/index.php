<?php

declare(strict_types=1);

require '../vendor/autoload.php';

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

    print_r($result);
} catch (ApiClientException $e) {
    echo 'API client error: ' . $e->getMessage() . PHP_EOL;
    var_dump($e);
} catch (ApiRequestException $e) {
    echo 'API request error: ' . $e->getMessage() . PHP_EOL;
    var_dump($e);
}
