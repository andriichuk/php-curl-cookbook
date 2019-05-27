<?php

$curlHandler = curl_init();

curl_setopt_array($curlHandler, [
    CURLOPT_URL => 'https://httpbin.org/delay/5',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CONNECTTIMEOUT => 2,
    CURLOPT_TIMEOUT => 3,
]);

$response = curl_exec($curlHandler);
$statusCode = curl_getinfo($curlHandler, CURLINFO_HTTP_CODE);

if ($statusCode > 300) {
    print_r('Redirection or Error response with status: ' . $statusCode);
}

if (curl_errno($curlHandler) !== CURLE_OK) {
    print_r([
        'error_code' => curl_errno($curlHandler),
        'error_message' => curl_error($curlHandler),
    ]);
}

curl_close($curlHandler);