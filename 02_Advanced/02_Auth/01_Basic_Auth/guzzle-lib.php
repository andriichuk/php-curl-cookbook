<?php

require_once 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

$userName = 'postman';
$password = 'password';

$httpClient = new Client();

$response = $httpClient->get(
    'https://postman-echo.com/basic-auth',
    [
        RequestOptions::AUTH => [$userName, $password]
    ]
);

print_r($response->getBody()->getContents());