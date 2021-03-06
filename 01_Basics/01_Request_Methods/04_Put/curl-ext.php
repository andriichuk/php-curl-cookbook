<?php

$curlHandler = curl_init();

curl_setopt_array($curlHandler, [
    CURLOPT_URL => 'https://postman-echo.com/put',
    CURLOPT_RETURNTRANSFER => true,

    /**
     * Specify custom HTTP request method
     */
    CURLOPT_CUSTOMREQUEST => 'PUT',

    /**
     * Specify request body (can be array or string)
     */
    CURLOPT_POSTFIELDS => [
        'foo' => 'bar',
        'baz' => 'biz',
    ]
]);

$pageContent = curl_exec($curlHandler);

curl_close($curlHandler);

echo($pageContent);