<?php

require_once 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

$localFiles = [
    'text_file' => __DIR__ . '/resource/file.txt',
    'image_file' => __DIR__ . '/resource/github-icon.png',
];

$uploadFiles = [];

foreach ($localFiles as $filePostKey => $uploadFilePath) {
    if (!file_exists($uploadFilePath)) {
        throw new Exception('File not found: ' . $uploadFilePath);
    }

    array_push($uploadFiles, [
        'name' => $filePostKey,
        'contents' => new SplFileObject($uploadFilePath, 'r'),
        'filename' => $filePostKey,
    ]);
}

$httpClient = new Client();

$response = $httpClient->post(
    'https://postman-echo.com/post',
    [
        RequestOptions::MULTIPART => $uploadFiles,
    ]
);

echo($response->getBody()->getContents());