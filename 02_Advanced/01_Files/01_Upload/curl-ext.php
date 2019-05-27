<?php

$uploadFilePath = __DIR__ . '/resource/file.txt';

if (!file_exists($uploadFilePath)) {
    throw new Exception('File not found: ' . $uploadFilePath);
}

/**
 * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Basics_of_HTTP/MIME_types/Complete_list_of_MIME_types List of MIME types
 */
$uploadFileMimeType = mime_content_type($uploadFilePath);
$uploadFilePostKey = 'file';

$uploadFile = new CURLFile(
    $uploadFilePath,
    $uploadFileMimeType,
    $uploadFilePostKey
);

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
    CURLOPT_POSTFIELDS => [
        $uploadFilePostKey => $uploadFile,
    ],
]);

$response = curl_exec($curlHandler);

curl_close($curlHandler);

echo($response);