<?php

require_once 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\SetCookie;
use GuzzleHttp\RequestOptions;

$httpClient = new Client();

$url = 'https://httpbin.org/cookies';
$urlHost = parse_url($url, PHP_URL_HOST);

$cookies = [
    new SetCookie([
        'Name'     => 'foo',
        'Value'    => 'bar',
        'Domain'   => $urlHost,
        'Path'     => '/',
        'Max-Age'  => 100,
        'Secure'   => false,
        'Discard'  => false,
        'HttpOnly' => false,
    ]),
    new SetCookie([
        'Name'     => 'baz',
        'Value'    => 'foo',
        'Domain'   => $urlHost,
        'Path'     => '/',
        'Max-Age'  => 100,
        'Secure'   => false,
        'Discard'  => false,
        'HttpOnly' => false,
    ]),
];

$cookieJar = new CookieJar(true, $cookies);

$response = $httpClient->get(
    $url,
    [
        RequestOptions::COOKIES => $cookieJar,
    ]
);

echo($response->getBody()->getContents());