<?php

$curlHandler = curl_init();

$userName = 'postman';
$password = 'password';

curl_setopt_array($curlHandler, [
    CURLOPT_URL => 'https://postman-echo.com/digest-auth',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPAUTH => CURLAUTH_DIGEST,
    CURLOPT_USERPWD => $userName . ':' . $password,
]);

$response = curl_exec($curlHandler);
curl_close($curlHandler);

print_r($response);