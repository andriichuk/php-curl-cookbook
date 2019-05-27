<?php

require_once 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

$httpClient = new Client();

$response = $httpClient->post(
    'https://postman-echo.com/post',
    [
        RequestOptions::BODY => 'POST raw request content',
        RequestOptions::HEADERS => [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ],
    ]
);

echo($response->getBody()->getContents());