<?php

$curlHandler = curl_init();

curl_setopt_array($curlHandler, [
    CURLOPT_URL => 'https://httpbin.org/absolute-redirect/3',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => false,
    CURLOPT_MAXREDIRS => 5,
]);

$content = curl_exec($curlHandler);
$curlInfo = curl_getinfo($curlHandler);

curl_close($curlHandler);

print_r($curlInfo);