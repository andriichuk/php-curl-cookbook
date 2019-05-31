<?php

$curlHandler = curl_init();

curl_setopt_array($curlHandler, [
    CURLOPT_URL => 'https://httpbin.org/get',
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2_0,
]);

curl_exec($curlHandler);
$info = curl_getinfo($curlHandler);
curl_close($curlHandler);

print_r($info);