<?php

$curlHandler = curl_init();

curl_setopt_array($curlHandler, [
    CURLOPT_URL => 'https://postman-echo.com/get',
    CURLOPT_USERAGENT => 'Mozilla/5.0 (iPhone; U; CPU like Mac OS X; en) AppleWebKit/420+ (KHTML, like Gecko) Version/3.0 Mobile/1A537a Safari/419.3',

    /* OR set header
      CURLOPT_HTTPHEADER => [
        'User-Agent: Mozilla/5.0 (iPhone; U; CPU like Mac OS X; en) AppleWebKit/420+ (KHTML, like Gecko) Version/3.0 Mobile/1A537a Safari/419.3',
    ]*/
]);

$response = curl_exec($curlHandler);

curl_close($curlHandler);

print_r($response);