<?php

require_once 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

$token = 'your_token';

$httpClient = new Client();

$response = $httpClient->get(
    'https://httpbin.org/bearer',
    [
        RequestOptions::HEADERS => [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ]
    ]
);

print_r($response->getBody()->getContents());