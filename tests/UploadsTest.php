<?php

use function CookbookTests\runExample;

it('uses readable fixtures in cURL uploads', function (string $directory) {
    $history = [];
    $result = runExample('02_Advanced/01_Files/' . $directory . '/curl-ext.php', $history);
    $fields = $result['handles'][0]->options[CURLOPT_POSTFIELDS];

    expect($fields)->not->toBeEmpty();
    foreach ($fields as $file) {
        expect($file)->toBeInstanceOf(CURLFile::class);
        expect($file->getFilename())->toBeReadableFile();
    }
    if ($directory === '03_Upload_Array_Of_Files') {
        expect($fields)->toHaveKeys(['documents[0]', 'documents[1]', 'images[icon]']);
    }
})->with('upload examples');

it('includes actual file bytes in Guzzle multipart uploads', function (string $directory) {
    $history = [];
    runExample('02_Advanced/01_Files/' . $directory . '/guzzle-lib.php', $history);

    expect($history)->toHaveCount(1);
    $request = $history[0]['request'];
    expect($request->getMethod())->toBe('POST');
    expect($request->getHeaderLine('Content-Type'))->toStartWith('multipart/form-data; boundary=');

    $body = (string) $request->getBody();
    $files = glob('02_Advanced/01_Files/' . $directory . '/resource/*');
    expect($files)->not->toBeEmpty();
    foreach ($files as $file) {
        expect($body)->toContain(file_get_contents($file));
    }
    if ($directory === '03_Upload_Array_Of_Files') {
        foreach (['documents[0]', 'documents[1]', 'images[icon]'] as $field) {
            expect($body)->toContain('name="' . $field . '"');
        }
    }
})->with('upload examples');
