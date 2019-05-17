<?php

require_once 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

$httpClient = new Client([
    RequestOptions::TIMEOUT => 10.0,
    RequestOptions::CONNECT_TIMEOUT => 10.0,
]);

$response = $httpClient->patch(
    'https://postman-echo.com/patch',
    [
        RequestOptions::FORM_PARAMS => [
            'foo' => 'bar',
            'baz' => 'biz',
        ],
    ]
);

echo(
    $response->getBody()->getContents()
);