<?php

$imageFilePath = __DIR__ . '/resource/image.jpeg';

$curlHandler = curl_init();

curl_setopt_array($curlHandler, [
    CURLOPT_URL => 'https://httpbin.org/image/jpeg',
    CURLOPT_FILE => fopen($imageFilePath, 'w+')
]);

curl_exec($curlHandler);

if (curl_errno($curlHandler) === CURLE_OK) {
    echo 'The image has been successfully downloaded: ' . $imageFilePath;
}

curl_close($curlHandler);
