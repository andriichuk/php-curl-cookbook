<?php

$localFiles = [
    'text_file' => __DIR__ . '/resource/file.txt',
    'image_file' => __DIR__ . '/resource/github-icon.png',
];

$uploadFiles = [];

foreach ($localFiles as $filePostKey => $uploadFilePath) {
    if (!file_exists($uploadFilePath)) {
        throw new Exception('File not found: ' . $uploadFilePath);
    }

    $uploadFileMimeType = mime_content_type($uploadFilePath);

    $uploadFiles[$filePostKey] = new CURLFile($uploadFilePath, $uploadFileMimeType, $filePostKey);
}

$curlHandler = curl_init();

curl_setopt_array($curlHandler, [
    CURLOPT_URL => 'https://postman-echo.com/post',
    CURLOPT_RETURNTRANSFER => true,

    /**
     * Specify POST method
     */
    CURLOPT_POST => true,

    /**
     * Specify array of form fields
     */
    CURLOPT_POSTFIELDS => $uploadFiles,
]);

$response = curl_exec($curlHandler);

curl_close($curlHandler);

echo($response);