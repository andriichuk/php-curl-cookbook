<?php

$curlHandler = curl_init();

curl_setopt_array($curlHandler, [
    CURLOPT_URL => 'https://httpbin.org/get',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_REFERER => 'https://github.com',
]);

$response = curl_exec($curlHandler);

curl_close($curlHandler);

print_r($response);