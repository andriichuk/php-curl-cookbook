<?php

require_once 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

$imageFilePath = __DIR__ . '/resource/image.jpeg';
$imageFileResource = fopen($imageFilePath, 'w+');

$httpClient = new Client();
$response = $httpClient->get(
    'https://httpbin.org/image/jpeg',
    [
        RequestOptions::SINK => $imageFileResource,
    ]
);

if ($response->getStatusCode() === 200) {
    echo 'The image has been successfully downloaded: ' . $imageFilePath;
}
