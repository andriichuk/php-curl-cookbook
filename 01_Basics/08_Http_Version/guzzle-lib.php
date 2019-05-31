<?php

require_once 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\TransferStats;

$httpClient = new Client();

$response = $httpClient->get(
    'https://httpbin.org/get',
    [
        RequestOptions::VERSION => 2.0,
        RequestOptions::ON_STATS => function (TransferStats $stats) {
            print_r($stats->getHandlerStats());
        }
    ]
);