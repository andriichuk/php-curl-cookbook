<?php

require_once 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\TransferStats;

$httpClient = new Client();

$httpClient->get(
    'https://postman-echo.com/get',
    [
        RequestOptions::ON_STATS => function (TransferStats $stats) {
            print_r($stats->getHandlerStats());
        }
    ]
);