<?php

require_once 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\RedirectMiddleware;

$httpClient = new Client();

$response = $httpClient->get(
    'https://httpbin.org/absolute-redirect/5',
    [
        RequestOptions::ALLOW_REDIRECTS => [
            'max' => 5,
            'track_redirects' => true,
        ],
    ]
);

print_r($response->getHeader(RedirectMiddleware::HISTORY_HEADER));