<?php

$curlHandler = curl_init();

$userName = 'postman';
$password = 'password';

curl_setopt_array($curlHandler, [
    CURLOPT_URL => 'https://postman-echo.com/basic-auth',
    CURLOPT_RETURNTRANSFER => true,

    CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
    CURLOPT_USERPWD => $userName . ':' . $password,
]);

$response = curl_exec($curlHandler);
curl_close($curlHandler);

print_r('First example response: ' . $response . PHP_EOL);

/**
 * Or specify credentials in Authorization header
 */

$curlSecondHandler = curl_init();

curl_setopt_array($curlSecondHandler, [
    CURLOPT_URL => 'https://postman-echo.com/basic-auth',
    CURLOPT_RETURNTRANSFER => true,

    CURLOPT_HTTPHEADER => [
        'Authorization: Basic ' . base64_encode($userName . ':' . $password)
    ],
]);

$response = curl_exec($curlSecondHandler);
curl_close($curlSecondHandler);

print_r('Second example response: ' . $response . PHP_EOL);