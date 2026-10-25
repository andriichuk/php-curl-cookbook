<?php

it('links README examples to existing files', function () {
    preg_match_all('#https://github.com/andriichuk/php-curl-cookbook/blob/master/([^\s)]+)#', file_get_contents('README.md'), $matches);

    expect($matches[1])->not->toBeEmpty();
    foreach ($matches[1] as $path) {
        expect($path)->toBeFile();
    }
});

it('uses portable existing paths in shell file examples', function (string $directory) {
    $temporary = sys_get_temp_dir() . '/cookbook-tests-' . bin2hex(random_bytes(8));
    mkdir($temporary);
    mkdir($temporary . '/bin');
    symlink(getcwd(), $temporary . '/repository with spaces');
    file_put_contents($temporary . '/bin/curl', "#!/usr/bin/env bash\nprintf '%s\\n' \"\$@\"\n");
    chmod($temporary . '/bin/curl', 0700);

    try {
        $script = '02_Advanced/01_Files/' . $directory . '/console.sh';
        $command = 'cd ' . escapeshellarg($temporary) . ' && PATH=' . escapeshellarg($temporary . '/bin:' . getenv('PATH'));
        $command .= ' bash ' . escapeshellarg($temporary . '/repository with spaces/' . $script);
        exec($command, $arguments, $exitCode);

        expect($exitCode)->toBe(0);
        $fileArguments = 0;
        foreach ($arguments as $index => $argument) {
            if (str_contains($argument, '=@')) {
                $path = substr($argument, strpos($argument, '=@') + 2);
                expect($path)->toBeReadableFile();
                ++$fileArguments;
            } elseif ($argument === '--output') {
                expect($arguments)->toHaveKey($index + 1);
                expect(dirname($arguments[$index + 1]))->toBeDirectory();
                ++$fileArguments;
            }
        }
        expect($fileArguments)->toBeGreaterThan(0);
    } finally {
        unlink($temporary . '/bin/curl');
        unlink($temporary . '/repository with spaces');
        rmdir($temporary . '/bin');
        rmdir($temporary);
    }
})->with([
    'single upload' => '01_Upload',
    'multiple uploads' => '02_Upload_Multiple',
    'array upload' => '03_Upload_Array_Of_Files',
    'download' => '04_Download',
]);

it('preserves command arguments in the Docker wrapper', function () {
    $temporary = sys_get_temp_dir() . '/cookbook-run-' . bin2hex(random_bytes(8));
    mkdir($temporary);
    file_put_contents($temporary . '/docker-compose', "#!/usr/bin/env bash\nprintf '%s\\n' \"\$@\"\n");
    chmod($temporary . '/docker-compose', 0700);

    try {
        $command = 'PATH=' . escapeshellarg($temporary . ':' . getenv('PATH')) . ' bash run php -r ' . escapeshellarg('echo "hello world";');
        exec($command, $arguments, $exitCode);

        expect($exitCode)->toBe(0);
        expect($arguments)->toBe(['run', '--rm', 'php-fpm', 'php', '-r', 'echo "hello world";']);
    } finally {
        unlink($temporary . '/docker-compose');
        rmdir($temporary);
    }
});
