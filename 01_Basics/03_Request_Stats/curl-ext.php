<?php

$curlHandler = curl_init();

curl_setopt_array($curlHandler, [
    CURLOPT_URL => 'https://postman-echo.com/get?foo=bar',
    CURLOPT_RETURNTRANSFER => true,
]);

curl_exec($curlHandler);

$curlInfo = curl_getinfo($curlHandler);

curl_close($curlHandler);

print_r($curlInfo);