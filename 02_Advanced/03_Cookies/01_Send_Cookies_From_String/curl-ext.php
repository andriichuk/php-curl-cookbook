<?php

$curlHandler = curl_init();

curl_setopt_array($curlHandler, [
    CURLOPT_URL => 'https://httpbin.org/cookies',
    CURLOPT_RETURNTRANSFER => true,

    CURLOPT_COOKIE => 'foo=bar;baz=foo',

    /**
     * Or set header
     * CURLOPT_HTTPHEADER => [
           'Cookie: foo=bar;baz=foo',
       ]
     */
]);

$response = curl_exec($curlHandler);
curl_close($curlHandler);

echo $response;
