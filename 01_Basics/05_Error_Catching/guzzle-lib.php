<?php

require_once 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Exception\GuzzleException;

$httpClient = new Client();

try {
    $response = $httpClient->get(
        'https://httpbin.org/dedlay/5',
        [
            RequestOptions::CONNECT_TIMEOUT => 2,
            RequestOptions::TIMEOUT => 3,
        ]
    );

    print_r($response->getBody()->getContents());
} catch (GuzzleException $exception) {
    print_r([
        'code' => $exception->getCode(),
        'message' => $exception->getMessage(),
    ]);
}