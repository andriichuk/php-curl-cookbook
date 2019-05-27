<?php

$curlHandler = curl_init();

curl_setopt_array($curlHandler, [
    CURLOPT_URL => 'https://postman-echo.com/post',
    CURLOPT_RETURNTRANSFER => true,

    /**
     * Specify POST method
     */
    CURLOPT_POST => true,

    /**
     * Specify request content
     */
    CURLOPT_POSTFIELDS => 'POST raw request content',
]);

$response = curl_exec($curlHandler);

curl_close($curlHandler);

echo($response);