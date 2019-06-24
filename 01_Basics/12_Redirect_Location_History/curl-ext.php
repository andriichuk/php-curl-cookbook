<?php

$curlHandler = curl_init();

$locations = [];

curl_setopt_array(
    $curlHandler,
    [
        CURLOPT_URL => 'https://httpbin.org/absolute-redirect/5',
        CURLOPT_NOBODY => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HEADERFUNCTION => function ($curlInfo, $header) use (&$locations) {
            preg_match('#Location:\s(?<url>[\S]+)#iu', $header, $location);

            if (!empty($location['url'])) {
                $locations[] = trim($location['url']);
            }

            return mb_strlen($header);
        },
    ]
);

curl_exec($curlHandler);
curl_close($curlHandler);

print_r($locations);