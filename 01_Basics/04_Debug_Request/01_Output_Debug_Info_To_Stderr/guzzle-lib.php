<?php

require_once 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

$httpClient = new Client();

$httpClient->get(
    'https://postman-echo.com/get?foo=bar',
    [
        RequestOptions::DEBUG => true,
    ]
);