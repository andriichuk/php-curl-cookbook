<?php

require_once 'vendor/autoload.php';

use GuzzleHttp\Client;

$httpClient = new Client();

$response = $httpClient->get('https://postman-echo.com/response-headers?foo=bar');

print_r($response->getHeaders());