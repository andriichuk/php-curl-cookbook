<?php

require_once 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

$httpClient = new Client();

$response = $httpClient->post(
    'https://postman-echo.com/post',
    [
        RequestOptions::MULTIPART => [
            [
                'name' => 'file',
                'contents' => new SplFileObject(__DIR__ . '/resource/file.txt', 'r'),
                'filename' => 'file',
            ]
        ],
    ]
);

echo($response->getBody()->getContents());