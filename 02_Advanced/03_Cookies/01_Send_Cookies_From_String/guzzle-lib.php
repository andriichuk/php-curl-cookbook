<?php

require_once 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\RequestOptions;

$httpClient = new Client();

$url = 'https://httpbin.org/cookies';
$urlHost = parse_url($url, PHP_URL_HOST);

$cookieJar = CookieJar::fromArray(
    [
        'foo' => 'bar',
        'baz' => 'foo',
    ],
    $urlHost
);

$response = $httpClient->get(
    $url,
    [
        RequestOptions::COOKIES => $cookieJar,
    ]
);

echo($response->getBody()->getContents());