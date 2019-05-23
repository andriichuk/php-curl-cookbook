<?php

require_once 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

$httpClient = new Client();

$response = $httpClient->get(
    'https://httpbin.org/delay/5',
    [
        RequestOptions::CONNECT_TIMEOUT => 10,
        RequestOptions::TIMEOUT => 20,
    ]
);

print_r($response->getBody()->getContents());