<?php

require_once 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Cookie\FileCookieJar;

$httpClient = new Client();

$cookieJarFile = new FileCookieJar(
    __DIR__ . '/resource/guzzle-cookie-jar.json',
    true
);

$response = $httpClient->get(
    'https://httpbin.org/cookies/set/foo/bar',
    [
        RequestOptions::COOKIES => $cookieJarFile,
    ]
);

echo $response->getBody()->getContents();