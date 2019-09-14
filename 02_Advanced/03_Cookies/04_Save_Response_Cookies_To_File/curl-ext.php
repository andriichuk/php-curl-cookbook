<?php

$curlHandler = curl_init();

$cookieFile = __DIR__ . '/resource/cookie-jar.txt';

curl_setopt_array($curlHandler, [
    CURLOPT_URL => 'https://httpbin.org/cookies/set/foo/bar',
    CURLOPT_RETURNTRANSFER => true,

    CURLOPT_COOKIEJAR  => $cookieFile,
    CURLOPT_FOLLOWLOCATION => true,
]);

$response = curl_exec($curlHandler);
curl_close($curlHandler);

echo $response;
