<?php

$localFiles = [
    // indexed
    'documents' => [
        __DIR__ . '/resource/file-1.txt',
        __DIR__ . '/resource/file-2.txt',
    ],

    // associated
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

        $uploadFiles[$keyName] = new CURLFile($uploadFilePath, $uploadFileMimeType, $filePostKey);
    }
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
