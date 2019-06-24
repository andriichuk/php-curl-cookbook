<?php

require_once 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

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

print_r($response->getHeaders()['X-Guzzle-Redirect-History']);