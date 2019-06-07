<?php

$curlHandler = curl_init();

$token = 'your_token';

curl_setopt_array($curlHandler, [
    CURLOPT_URL => 'https://httpbin.org/bearer',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        'Accept: application/json',
        'Authorization: Bearer ' . $token
    ],
]);

$response = curl_exec($curlHandler);
curl_close($curlHandler);

print_r($response);