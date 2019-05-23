<?php

$curlHandler = curl_init();

curl_setopt_array($curlHandler, [
    CURLOPT_URL => 'https://postman-echo.com/get?foo=bar',
    CURLOPT_RETURNTRANSFER => true,

    /**
     * Specify debug option
     */
    CURLOPT_VERBOSE => true,
]);

curl_exec($curlHandler);

curl_close($curlHandler);