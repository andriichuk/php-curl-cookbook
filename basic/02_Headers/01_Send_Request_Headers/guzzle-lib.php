<?php

require_once 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

$httpClient = new Client();

$response = $httpClient->get(
    'https://postman-echo.com/headers',
    [
        RequestOptions::HEADERS => [
            'foo' => 'bar',
            'baz' => 'biz',
        ],
    ]
);

print_r(
    $response->getBody()->getContents()
);