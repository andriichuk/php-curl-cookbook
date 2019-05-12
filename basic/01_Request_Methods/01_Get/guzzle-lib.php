<?php

require_once 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

$httpClient = new Client([
    RequestOptions::TIMEOUT => 10.0,
    RequestOptions::CONNECT_TIMEOUT => 10.0,
]);

$response = $httpClient->get(
    'https://postman-echo.com/get',
    [
        RequestOptions::QUERY => [
            'foo' => 'bar',
        ],
    ]
);

echo(
    $response->getBody()->getContents()
);