<?php

require_once __DIR__ . '/bootstrap.php';

beforeEach(function () {
    chdir(dirname(__DIR__));
});

dataset('upload examples', [
    'single file' => '01_Upload',
    'multiple files' => '02_Upload_Multiple',
    'indexed and associative files' => '03_Upload_Array_Of_Files',
]);
