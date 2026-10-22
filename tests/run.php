<?php

namespace CookbookTests;

require __DIR__ . '/bootstrap.php';

use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Psr7\Request;

chdir(dirname(__DIR__));
$tests = [];

$tests['README example links point to existing files'] = function () {
    preg_match_all('#https://github.com/andriichuk/php-curl-cookbook/blob/master/([^\s)]+)#', file_get_contents('README.md'), $matches);
    check(count($matches[1]) > 0, 'No example links were found');
    foreach ($matches[1] as $path) {
        check(is_file($path), 'Broken example link: ' . $path);
    }
};

foreach (['01_Upload', '02_Upload_Multiple', '03_Upload_Array_Of_Files'] as $directory) {
    $tests[$directory . ' cURL upload fixtures exist'] = function () use ($directory) {
        $history = [];
        $result = runExample('02_Advanced/01_Files/' . $directory . '/curl-ext.php', $history);
        $fields = $result['handles'][0]->options[CURLOPT_POSTFIELDS];
        check(count($fields) > 0, 'No upload fields');
        foreach ($fields as $file) {
            check($file instanceof \CURLFile && is_readable($file->getFilename()), 'Unreadable upload fixture');
        }
        if ($directory === '03_Upload_Array_Of_Files') {
            check(isset($fields['documents[0]'], $fields['documents[1]'], $fields['images[icon]']), 'Missing indexed or associative upload fields');
        }
    };

    $tests[$directory . ' Guzzle uploads contain the actual file bytes'] = function () use ($directory) {
        $history = [];
        runExample('02_Advanced/01_Files/' . $directory . '/guzzle-lib.php', $history);
        check(count($history) === 1, 'Expected one multipart request');
        $request = $history[0]['request'];
        check($request->getMethod() === 'POST', 'Expected a POST request');
        check(strpos($request->getHeaderLine('Content-Type'), 'multipart/form-data; boundary=') === 0, 'Missing multipart boundary');
        $body = (string) $request->getBody();
        foreach (glob('02_Advanced/01_Files/' . $directory . '/resource/*') as $file) {
            check(strpos($body, file_get_contents($file)) !== false, 'Missing file bytes: ' . $file);
        }
        if ($directory === '03_Upload_Array_Of_Files') {
            foreach (['documents[0]', 'documents[1]', 'images[icon]'] as $field) {
                check(strpos($body, 'name="' . $field . '"') !== false, 'Missing multipart field: ' . $field);
            }
        }
    };
}

foreach (['01_Basics/02_Headers/02_Get_Response_Headers', '01_Basics/12_Redirect_Location_History'] as $directory) {
    $tests[$directory . ' callback reports byte counts'] = function () use ($directory) {
        $history = [];
        $result = runExample($directory . '/curl-ext.php', $history);
        $callback = $result['handles'][0]->options[CURLOPT_HEADERFUNCTION];
        $header = "X-Message: Привіт\r\n";
        check($callback(null, $header) === strlen($header), 'Header callback must return bytes, not characters');
        check($callback(null, "\r\n") === 2, 'Empty header line must still report its bytes');
    };
}

$tests['Guzzle error example requests the delayed endpoint and catches connection errors'] = function () {
    $history = [];
    $error = new ConnectException('Simulated timeout', new Request('GET', 'https://httpbin.org/delay/5'));
    $result = runExample('01_Basics/05_Error_Catching/guzzle-lib.php', $history, [$error]);
    check((string) $history[0]['request']->getUri() === 'https://httpbin.org/delay/5', 'Wrong timeout endpoint');
    check($history[0]['options']['connect_timeout'] === 2 && $history[0]['options']['timeout'] === 3, 'Wrong timeout settings');
    check(strpos($result['output'], 'Simulated timeout') !== false, 'Connection error was not reported');
};

$tests['cURL error example reports HTTP 300 redirects'] = function () {
    $history = [];
    $result = runExample('01_Basics/05_Error_Catching/curl-ext.php', $history, [], 300);
    check(strpos($result['output'], 'status: 300') !== false, 'HTTP 300 was not reported');
    $result = runExample('01_Basics/05_Error_Catching/curl-ext.php', $history, [], 200);
    check($result['output'] === '', 'HTTP 200 should not be reported as an error');
};

$tests['shell file examples use portable, existing paths'] = function () {
    $temporary = sys_get_temp_dir() . '/cookbook-tests-' . uniqid();
    mkdir($temporary);
    mkdir($temporary . '/bin');
    symlink(getcwd(), $temporary . '/repository with spaces');
    file_put_contents($temporary . '/bin/curl', "#!/usr/bin/env bash\nprintf '%s\\n' \"\$@\"\n");
    chmod($temporary . '/bin/curl', 0700);

    try {
        foreach (glob('02_Advanced/01_Files/*/console.sh') as $script) {
            $command = 'cd ' . escapeshellarg($temporary) . ' && PATH=' . escapeshellarg($temporary . '/bin:' . getenv('PATH'));
            $command .= ' bash ' . escapeshellarg($temporary . '/repository with spaces/' . $script);
            exec($command, $arguments, $exitCode);
            check($exitCode === 0, 'Shell example failed: ' . $script);
            $fileArguments = 0;
            foreach ($arguments as $index => $argument) {
                if (strpos($argument, '=@') !== false) {
                    $path = substr($argument, strpos($argument, '=@') + 2);
                    check(is_readable($path), 'Missing shell upload fixture: ' . $path);
                    ++$fileArguments;
                } elseif ($argument === '--output') {
                    check(isset($arguments[$index + 1]) && is_dir(dirname($arguments[$index + 1])), 'Download directory does not exist');
                    ++$fileArguments;
                }
            }
            check($fileArguments > 0, 'No file arguments were captured for ' . $script);
            $arguments = [];
        }
    } finally {
        unlink($temporary . '/bin/curl');
        unlink($temporary . '/repository with spaces');
        rmdir($temporary . '/bin');
        rmdir($temporary);
    }
};

$tests['run preserves command arguments'] = function () {
    $temporary = sys_get_temp_dir() . '/cookbook-run-' . uniqid();
    mkdir($temporary);
    file_put_contents($temporary . '/docker-compose', "#!/usr/bin/env bash\nprintf '%s\\n' \"\$@\"\n");
    chmod($temporary . '/docker-compose', 0700);
    try {
        $command = 'PATH=' . escapeshellarg($temporary . ':' . getenv('PATH')) . ' bash run php -r ' . escapeshellarg('echo "hello world";');
        exec($command, $arguments, $exitCode);
        check($exitCode === 0, 'run failed');
        check($arguments === ['run', '--rm', 'php-fpm', 'php', '-r', 'echo "hello world";'], 'run split or reinterpreted command arguments');
    } finally {
        unlink($temporary . '/docker-compose');
        rmdir($temporary);
    }
};

$failures = 0;
foreach ($tests as $name => $test) {
    try {
        $test();
        echo 'PASS ' . $name . PHP_EOL;
    } catch (\Exception $exception) {
        ++$failures;
        echo 'FAIL ' . $name . ': ' . $exception->getMessage() . PHP_EOL;
    } catch (\Throwable $exception) {
        ++$failures;
        echo 'FAIL ' . $name . ': ' . $exception->getMessage() . PHP_EOL;
    }
}

echo PHP_EOL . count($tests) . ' checks, ' . $failures . ' failures' . PHP_EOL;
exit($failures ? 1 : 0);
