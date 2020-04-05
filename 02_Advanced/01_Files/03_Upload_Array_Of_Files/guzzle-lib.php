<?php

require_once 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

$localFiles = [
    'documents' => [
        __DIR__ . '/resource/file-1.txt',
        __DIR__ . '/resource/file-2.txt',
    ],
    'images' => [
        'icon' => __DIR__ . '/resource/github-icon.png',
        'octocat' => __DIR__ . '/resource/github-octocat.jpg',
    ],
];

$uploadFiles = [];

foreach ($localFiles as $fileType => $files) {
    foreach ($files as $filePostKey => $uploadFilePath) {
        if (!file_exists($uploadFilePath)) {
            throw new Exception('File not found: ' . $uploadFilePath);
        }

        $uploadFileMimeType = mime_content_type($uploadFilePath);
        $keyName = sprintf('%s[%s]', $fileType, $filePostKey);

        array_push($uploadFiles, [
            'name' => $keyName,
            'contents' => new SplFileObject($uploadFilePath, 'r'),
            'filename' => $keyName,
        ]);
    }
}

$httpClient = new Client();

$response = $httpClient->post(
    'https://postman-echo.com/post',
    [
        RequestOptions::MULTIPART => $uploadFiles,
    ]
);

echo($response->getBody()->getContents());
