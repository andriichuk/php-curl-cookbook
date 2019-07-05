<?php

require_once 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

$httpClient = new Client();

$response = $httpClient->get(
    'https://httpbin.org/get',
    [
        RequestOptions::HEADERS => [
            'Referer' => 'https://github.com',
        ],
    ]
);

print_r($response->getBody()->getContents());