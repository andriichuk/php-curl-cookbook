<?php

$curlHandler = curl_init();

curl_setopt_array($curlHandler, [
    CURLOPT_URL => 'https://postman-echo.com/headers',
    CURLOPT_RETURNTRANSFER => true,

    /**
     * Specify request headers
     */
    CURLOPT_HTTPHEADER => [
        'foo: bar',
        'baz: biz',
    ]
]);

$pageContent = curl_exec($curlHandler);

curl_close($curlHandler);

echo($pageContent);