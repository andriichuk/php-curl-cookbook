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
     * Do not include headers in the output; collect them in the callback below
     */
    CURLOPT_HEADER => false,

    /**
     * Collect server response headers
     */
    CURLOPT_HEADERFUNCTION => function ($curlInfo, $header) use (&$headers) {
        $headers[] = trim($header);

        return strlen($header);
    },
]);

curl_exec($curlHandler);

curl_close($curlHandler);

print_r(array_filter($headers));
