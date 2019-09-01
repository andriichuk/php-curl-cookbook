<?php

require_once 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Cookie\FileCookieJar;

$httpClient = new Client();

$cookieJarFile = new FileCookieJar(
    __DIR__ . '/resource/guzzle-cookie-jar.json',
    false
);

$response = $httpClient->get(
    'https://httpbin.org/cookies',
    [
        RequestOptions::COOKIES => $cookieJarFile,
    ]
);

echo $response->getBody()->getContents();