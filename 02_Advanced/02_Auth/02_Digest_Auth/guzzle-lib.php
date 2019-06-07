<?php

require_once 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

$userName = 'postman';
$password = 'password';

$httpClient = new Client();

$response = $httpClient->get(
    'https://postman-echo.com/digest-auth',
    [
        RequestOptions::AUTH => [$userName, $password, 'digest']
    ]
);

print_r($response->getBody()->getContents());