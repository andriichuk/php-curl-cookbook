<?php

$headers = [];

$curlHandler = curl_init();

curl_setopt_array($curlHandler, [
    CURLOPT_URL => 'https://postman-echo.com/response-headers?foo=bar',

    /**
     * Exclude the body from the output
     */
    CURLOPT_NOBODY => true,
    CURLOPT_RETURNTRANSFER => false,

    /**
     * Include the header in the output
     */
    CURLOPT_HEADER => false,

    /**
     * Collect server response headers
     */
    CURLOPT_HEADERFUNCTION => function ($curlInfo, $header) use (&$headers) {
        array_push($headers, trim($header));

        return mb_strlen($header);
    },
]);

curl_exec($curlHandler);

curl_close($curlHandler);

print_r(array_filter($headers));