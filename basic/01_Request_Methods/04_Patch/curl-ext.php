<?php

$curlHandler = curl_init();

curl_setopt_array($curlHandler, [
    CURLOPT_URL => 'https://postman-echo.com/patch',
    CURLOPT_CONNECTTIMEOUT => 10,
    CURLOPT_TIMEOUT => 10,
    CURLOPT_RETURNTRANSFER => true,

    /**
     * Specify custom HTTP request method
     */
    CURLOPT_CUSTOMREQUEST => 'PATCH',

    /**
     * Specify request body (can be array of string)
     */
    CURLOPT_POSTFIELDS => [
        'foo' => 'bar',
        'baz' => 'biz',
    ]
]);

$pageContent = curl_exec($curlHandler);

curl_close($curlHandler);

echo($pageContent);