<?php

require_once 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\TransferStats;

$httpClient = new Client();

$response = $httpClient->get(
    'https://httpbin.org/absolute-redirect/3',
    [
        RequestOptions::ALLOW_REDIRECTS => [
            'max' => 5,
        ],
    ]
);

echo $response->getStatusCode();