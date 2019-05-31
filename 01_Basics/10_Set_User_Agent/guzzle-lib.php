<?php

require_once 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

$httpClient = new Client();

$response = $httpClient->get(
    'https://httpbin.org/get',
    [
        RequestOptions::HEADERS => [
            'User-Agent' => 'Mozilla/5.0 (iPhone; U; CPU like Mac OS X; en) AppleWebKit/420+ (KHTML, like Gecko) Version/3.0 Mobile/1A537a Safari/419.3',
        ]
    ]
);

print_r($response->getBody()->getContents());