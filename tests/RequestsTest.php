<?php

use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Psr7\Request;

use function CookbookTests\runExample;

it('reports byte counts from header callbacks', function (string $directory) {
    $history = [];
    $result = runExample($directory . '/curl-ext.php', $history);
    $callback = $result['handles'][0]->options[CURLOPT_HEADERFUNCTION];
    $header = "X-Message: Привіт\r\n";

    expect($callback(null, $header))->toBe(strlen($header));
    expect($callback(null, "\r\n"))->toBe(2);
})->with([
    'response headers' => '01_Basics/02_Headers/02_Get_Response_Headers',
    'redirect history' => '01_Basics/12_Redirect_Location_History',
]);

it('requests the delayed endpoint and catches connection errors', function () {
    $history = [];
    $error = new ConnectException('Simulated timeout', new Request('GET', 'https://httpbin.org/delay/5'));
    $result = runExample('01_Basics/05_Error_Catching/guzzle-lib.php', $history, [$error]);

    expect($history)->toHaveCount(1);
    expect((string) $history[0]['request']->getUri())->toBe('https://httpbin.org/delay/5');
    expect($history[0]['options']['connect_timeout'])->toBe(2);
    expect($history[0]['options']['timeout'])->toBe(3);
    expect($result['output'])->toContain('Simulated timeout');
});

it('reports redirects without reporting successful HTTP responses', function (int $status, string $output) {
    $history = [];
    $result = runExample('01_Basics/05_Error_Catching/curl-ext.php', $history, [], $status);

    expect($result['output'])->toBe($output);
})->with([
    'HTTP 300' => [300, 'Redirection or Error response with status: 300'],
    'HTTP 200' => [200, ''],
]);
