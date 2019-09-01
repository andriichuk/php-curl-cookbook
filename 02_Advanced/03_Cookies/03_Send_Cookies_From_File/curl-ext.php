<?php

$curlHandler = curl_init();

$cookieFile = __DIR__ . '/resource/cookie-jar.txt';

curl_setopt_array($curlHandler, [
    CURLOPT_URL => 'https://httpbin.org/cookies',
    CURLOPT_RETURNTRANSFER => true,

    CURLOPT_COOKIEFILE  => $cookieFile,
]);

$response = curl_exec($curlHandler);
curl_close($curlHandler);

echo $response;
