<?php

require_once 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

$httpClient = new Client();

$response = $httpClient->put(
    'https://postman-echo.com/put',
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