# PHP CURL Cookbook

List of commonly used cases with PHP cURL extension.

CURL library [Home Page](https://curl.haxx.se/) and [Wiki Page](https://ec.haxx.se/).

PHP [Extension Page](http://docs.php.net/manual/en/book.curl.php) and [List Of Options](http://docs.php.net/manual/en/function.curl-setopt.php).

PHP [Guzzle](http://docs.guzzlephp.org/en/stable/overview.html) library - wrapper over PHP CURL extension.

For testing requests we will use the excellent services [httpbin.org](https://httpbin.org/) and [Postman Echo](https://docs.postman-echo.com).

# Table of Contents

* [Requirements](#requirements)
* [Installation](#installation)
* [Basics](#basics)
    * [HTTP Request methods](#http-request-methods)
    	* [GET method](#get-method)
    	* [POST raw request](#post-raw-request)
    	* [POST form data](#post-form-data)
    	* [PUT method](#put-method)
    	* [PATCH method](#patch-method)
    	* [DELETE method](#delete-method)
    * [Headers](#headers)
        * [Send custom request headers](#send-custom-request-headers)
        * [Get response headers](#get-response-headers)
    * [Request stats](#request-stats)
    * [Debug request](#debug-request)
        * [Output debug info to STDERR](#output-debug-info-to-stderr)
        * [Output debug info to file](#output-debug-info-to-file)
    * [Error catching](#error-catching)
    * [Follow redirects](#follow-redirects)
    * [Timeouts](#timeouts)
    * [Set HTTP version](#set-http-version)
    * [Get cURL version](#get-curl-version)
    * [Set User agent](#set-user-agent)
    * [Redirect Location History](#redirect-location-history)
    * [Set HTTP Referer](#set-http-referer)
* [Advanced](#advanced)
    * [Files](#files)
        * [Upload file](#upload-file)
        * [Upload multiple files](#upload-multiple-files)
        * [Download file](#download-file)
    * [Auth](#auth)
        * [Basic Auth](#basic-auth)
        * [Digest Auth](#digest-auth)
        * [Bearer Auth](#bearer-auth)
* [Todo](#todo)

## Requirements

* PHP >= 5.5
* cURL PHP Extension
* Mbstring PHP Extension
* Fileinfo PHP Extension

## Installation

Download repository

```bash
git clone https://github.com/andriichuk/curl-examples.git
```

Go to the directory

```bash
cd ./curl-examples
```

Install composer dependencies

```bash
composer install
```

Run BASH example

```bash
bash ./01_Basics/01_Request_Methods/01_Get/console.sh
```

Run PHP example

```bash
php ./01_Basics/01_Request_Methods/01_Get/curl-ext.php
```

# Basics

## HTTP Request methods

### GET method

#### Bash 

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/01_Basics/01_Request_Methods/01_Get/console.sh)]

```bash
curl --request GET "https://postman-echo.com/get?foo=bar"
```

#### PHP CURL extension 

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/01_Basics/01_Request_Methods/01_Get/curl-ext.php)]

```php
$curlHandler = curl_init();

curl_setopt_array($curlHandler, [
    CURLOPT_URL => 'https://postman-echo.com/get?foo=bar',
    CURLOPT_RETURNTRANSFER => true,
]);

$response = curl_exec($curlHandler);
curl_close($curlHandler);

echo($response);
```

#### PHP Guzzle library 

Call `get` method of Guzzle Client instance.

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/01_Basics/01_Request_Methods/01_Get/guzzle-lib.php)]

```php
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

$httpClient = new Client();

$response = $httpClient->get(
    'https://postman-echo.com/get',
    [
        RequestOptions::QUERY => [
            'foo' => 'bar',
        ],
    ]
);

echo($response->getBody()->getContents());
```

<details><summary>Response</summary>
<p>

```json
{"args":{"foo":"bar"},"headers":{"x-forwarded-proto":"https","host":"postman-echo.com","user-agent":"GuzzleHttp/6.3.3 curl/7.64.0 PHP/7.3.5-1+ubuntu19.04.1+deb.sury.org+1","x-forwarded-port":"443"},"url":"https://postman-echo.com/get?foo=bar"}
```

</p>
</details>

### POST raw request

#### Bash

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/01_Basics/01_Request_Methods/02_Post_Raw_Data/console.sh)]

```bash
curl --request POST "https://postman-echo.com/post" --data "POST raw request content"
```

#### PHP CURL extension

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/01_Basics/01_Request_Methods/02_Post_Raw_Data/curl-ext.php)]

```php
$curlHandler = curl_init();

curl_setopt_array($curlHandler, [
    CURLOPT_URL => 'https://postman-echo.com/post',
    CURLOPT_RETURNTRANSFER => true,

    /**
     * Specify POST method
     */
    CURLOPT_POST => true,

    /**
     * Specify request content
     */
    CURLOPT_POSTFIELDS => 'POST raw request content',
]);

$response = curl_exec($curlHandler);

curl_close($curlHandler);

echo($response);
```

#### PHP Guzzle library

Call `post` method of Guzzle Client instance.

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/01_Basics/01_Request_Methods/02_Post_Raw_Data/guzzle-lib.php)]

```php

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

$httpClient = new Client();

$response = $httpClient->post(
    'https://postman-echo.com/post',
    [
        RequestOptions::BODY => 'POST raw request content',
        RequestOptions::HEADERS => [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ],
    ]
);

echo($response->getBody()->getContents());
```

<details><summary>Response</summary>
<p>

```json
{"args":{},"data":"","files":{},"form":{"POST raw request content":""},"headers":{"x-forwarded-proto":"https","host":"postman-echo.com","content-length":"24","content-type":"application/x-www-form-urlencoded","user-agent":"GuzzleHttp/6.3.3 curl/7.64.0 PHP/7.3.5-1+ubuntu19.04.1+deb.sury.org+1","x-forwarded-port":"443"},"json":{"POST raw request content":""},"url":"https://postman-echo.com/post"}
```

</p>
</details>

### POST form data

#### Bash

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/01_Basics/01_Request_Methods/03_Post_Form_Data/console.sh)]

```bash
curl --request POST "https://postman-echo.com/post" --data "foo=bar&baz=biz"
```

#### PHP CURL extension

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/01_Basics/01_Request_Methods/03_Post_Form_Data/curl-ext.php)]

```php
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
        'foo' => 'bar',
        'baz' => 'biz',
    ],
]);

$response = curl_exec($curlHandler);

curl_close($curlHandler);

echo($response);
```

#### PHP Guzzle library

Call `post` method of Guzzle Client instance.

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/01_Basics/01_Request_Methods/03_Post_Form_Data/guzzle-lib.php)]

```php
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

$httpClient = new Client();

$response = $httpClient->post(
    'https://postman-echo.com/post',
    [
        RequestOptions::FORM_PARAMS => [
            'foo' => 'bar',
            'baz' => 'biz',
        ],
    ]
);

echo($response->getBody()->getContents());
```

<details><summary>Response</summary>
<p>

```json
{"args":{},"data":"","files":{},"form":{"foo":"bar","baz":"biz"},"headers":{"x-forwarded-proto":"https","host":"postman-echo.com","content-length":"15","content-type":"application/x-www-form-urlencoded","user-agent":"GuzzleHttp/6.3.3 curl/7.64.0 PHP/7.3.5-1+ubuntu19.04.1+deb.sury.org+1","x-forwarded-port":"443"},"json":{"foo":"bar","baz":"biz"},"url":"https://postman-echo.com/post"}
```

</p>
</details>

### PUT method

#### Bash

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/01_Basics/01_Request_Methods/04_Put/console.sh)]

```bash
curl --request PUT "https://postman-echo.com/put" --data "foo=bar&baz=biz"
```

#### PHP CURL extension

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/01_Basics/01_Request_Methods/04_Put/curl-ext.php)]

```php
$curlHandler = curl_init();

curl_setopt_array($curlHandler, [
    CURLOPT_URL => 'https://postman-echo.com/put',
    CURLOPT_RETURNTRANSFER => true,

    /**
     * Specify custom HTTP request method
     */
    CURLOPT_CUSTOMREQUEST => 'PUT',

    /**
     * Specify request body (can be array or string)
     */
    CURLOPT_POSTFIELDS => [
        'foo' => 'bar',
        'baz' => 'biz',
    ]
]);

$pageContent = curl_exec($curlHandler);

curl_close($curlHandler);

echo($pageContent);
```

#### PHP Guzzle library

Call `put` method of Guzzle Client instance.

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/01_Basics/01_Request_Methods/04_Put/guzzle-lib.php)]

```php
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

$httpClient = new Client();

$response = $httpClient->put(
    'https://postman-echo.com/put',
    [
        RequestOptions::FORM_PARAMS => [
            'foo' => 'bar',
            'baz' => 'biz',
        ],
    ]
);

echo($response->getBody()->getContents());
```

<details><summary>Response</summary>
<p>

```json
{"args":{},"data":"","files":{},"form":{"foo":"bar","baz":"biz"},"headers":{"x-forwarded-proto":"https","host":"postman-echo.com","content-length":"15","content-type":"application/x-www-form-urlencoded","user-agent":"GuzzleHttp/6.3.3 curl/7.64.0 PHP/7.3.5-1+ubuntu19.04.1+deb.sury.org+1","x-forwarded-port":"443"},"json":{"foo":"bar","baz":"biz"},"url":"https://postman-echo.com/put"}
```

</p>
</details>

### PATCH method

#### Bash

```bash
curl --request PATCH "https://postman-echo.com/patch" --data "foo=bar&baz=biz"
```

#### PHP CURL extension

```php
$curlHandler = curl_init();

curl_setopt_array($curlHandler, [
    CURLOPT_URL => 'https://postman-echo.com/patch',
    CURLOPT_RETURNTRANSFER => true,

    /**
     * Specify custom HTTP request method
     */
    CURLOPT_CUSTOMREQUEST => 'PATCH',

    /**
     * Specify request body (can be array or string)
     */
    CURLOPT_POSTFIELDS => [
        'foo' => 'bar',
        'baz' => 'biz',
    ]
]);

$pageContent = curl_exec($curlHandler);

curl_close($curlHandler);

echo($pageContent);
```

#### PHP Guzzle library

Call `patch` method of Guzzle Client instance.

```php
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

$httpClient = new Client();

$response = $httpClient->patch(
    'https://postman-echo.com/patch',
    [
        RequestOptions::FORM_PARAMS => [
            'foo' => 'bar',
            'baz' => 'biz',
        ],
    ]
);

echo($response->getBody()->getContents());
```

<details><summary>Response</summary>
<p>

```json
{"args":{},"data":"","files":{},"form":{"foo":"bar","baz":"biz"},"headers":{"x-forwarded-proto":"https","host":"postman-echo.com","content-length":"15","accept":"*/*","content-type":"application/x-www-form-urlencoded","user-agent":"curl/7.64.0","x-forwarded-port":"443"},"json":{"foo":"bar","baz":"biz"},"url":"https://postman-echo.com/patch"}
```

</p>
</details>

### DELETE method

#### Bash

```bash
curl --request DELETE "https://postman-echo.com/delete" --data "foo=bar&baz=biz" --max-time 10
```

#### PHP CURL extension

```php
$curlHandler = curl_init();

curl_setopt_array($curlHandler, [
    CURLOPT_URL => 'https://postman-echo.com/delete',
    CURLOPT_RETURNTRANSFER => true,

    /**
     * Specify custom HTTP request method
     */
    CURLOPT_CUSTOMREQUEST => 'DELETE',

    /**
     * Specify request body (can be array or string)
     */
    CURLOPT_POSTFIELDS => [
        'foo' => 'bar',
        'baz' => 'biz',
    ]
]);

$pageContent = curl_exec($curlHandler);

curl_close($curlHandler);

echo($pageContent);
```

#### PHP Guzzle library

Call `delete` method of Guzzle Client instance.

```php
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

$httpClient = new Client();

$response = $httpClient->delete(
    'https://postman-echo.com/delete',
    [
        RequestOptions::FORM_PARAMS => [
            'foo' => 'bar',
            'baz' => 'biz',
        ],
    ]
);

echo($response->getBody()->getContents());
```

<details><summary>Response</summary>
<p>

```json
{"args":{},"data":"","files":{},"form":{"foo":"bar","baz":"biz"},"headers":{"x-forwarded-proto":"https","host":"postman-echo.com","content-length":"15","content-type":"application/x-www-form-urlencoded","user-agent":"GuzzleHttp/6.3.3 curl/7.64.0 PHP/7.3.5-1+ubuntu19.04.1+deb.sury.org+1","x-forwarded-port":"443"},"json":{"foo":"bar","baz":"biz"},"url":"https://postman-echo.com/delete"}
```

</p>
</details>

## Headers

### Send custom request headers

#### Bash

```bash
curl --request GET "https://postman-echo.com/headers" --header "foo: bar" --header "baz: biz"
```

#### PHP CURL extension

```php
$curlHandler = curl_init();

curl_setopt_array($curlHandler, [
    CURLOPT_URL => 'https://postman-echo.com/headers',
    CURLOPT_RETURNTRANSFER => true,

    /**
     * Specify request headers
     */
    CURLOPT_HTTPHEADER => [
        'foo: bar',
        'baz: biz',
    ]
]);

$pageContent = curl_exec($curlHandler);

curl_close($curlHandler);

echo($pageContent);
```

#### PHP Guzzle library

```php
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

$httpClient = new Client();

$response = $httpClient->get(
    'https://postman-echo.com/headers',
    [
        RequestOptions::HEADERS => [
            'foo' => 'bar',
            'baz' => 'biz',
        ],
    ]
);

print_r(
    $response->getBody()->getContents()
);
```

<details><summary>Response</summary>
<p>

```json
{"headers":{"x-forwarded-proto":"https","host":"postman-echo.com","baz":"biz","foo":"bar","user-agent":"GuzzleHttp/6.3.3 curl/7.64.0 PHP/7.3.5-1+ubuntu19.04.1+deb.sury.org+1","x-forwarded-port":"443"}}
```

</p>
</details>

### Get response headers

#### Bash

```bash
curl --request GET "https://postman-echo.com/response-headers?Content-Type=text/html&foo=bar"
```

#### PHP CURL extension

```php
$headers = [];

$curlHandler = curl_init();

curl_setopt_array($curlHandler, [
    CURLOPT_URL => 'https://postman-echo.com/response-headers?foo=bar',

    /**
     * Exclude the body from the output
     */
    CURLOPT_NOBODY => true,
    CURLOPT_RETURNTRANSFER => false,

    /**
     * Include the header in the output
     */
    CURLOPT_HEADER => false,

    /**
     * Collect server response headers
     */
    CURLOPT_HEADERFUNCTION => function ($curlInfo, $header) use (&$headers) {
        array_push($headers, trim($header));

        return mb_strlen($header);
    },
]);

curl_exec($curlHandler);

curl_close($curlHandler);

print_r(
    array_filter($headers)
);
```

#### PHP Guzzle library

```php
use GuzzleHttp\Client;

$httpClient = new Client();

$response = $httpClient->get('https://postman-echo.com/response-headers?foo=bar');

print_r(
    $response->getHeaders()
);
```

<details><summary>Response</summary>
<p>

```plain
Array
(
    [Content-Type] => Array
        (
            [0] => application/json; charset=utf-8
        )

    [Date] => Array
        (
            [0] => Sun, 19 May 2019 14:16:36 GMT
        )
    // ...	
```

</p>
</details>

## Request stats

#### Bash

See full list of options [here](https://ec.haxx.se/usingcurl-writeout.html)

```bash
curl --request GET "https://postman-echo.com/get?foo=bar" -w "size_download:  %{size_download}" -o /dev/null -s
```

#### PHP CURL extension

```php
$curlHandler = curl_init();

curl_setopt_array($curlHandler, [
    CURLOPT_URL => 'https://postman-echo.com/get?foo=bar',
    CURLOPT_RETURNTRANSFER => true,
]);

curl_exec($curlHandler);

$curlInfo = curl_getinfo($curlHandler);

curl_close($curlHandler);

print_r($curlInfo);
```

#### PHP Guzzle library

```php
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
```

<details><summary>Response</summary>
<p>

```plain
Array
(
    [url] => https://postman-echo.com/get
    [content_type] => application/json; charset=utf-8
    [http_code] => 200
    [header_size] => 354
    [request_size] => 128
    [filetime] => -1
    [ssl_verify_result] => 0
    [redirect_count] => 0
    // ...
```

</p>
</details>

## Debug request

### Output debug info to STDERR

#### Bash

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/01_Basics/04_Debug_Request/01_Output_Debug_Info_To_Stderr/console.sh)]

```bash
curl --verbose --request GET "https://postman-echo.com/get?foo=bar"
```

#### PHP CURL extension

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/01_Basics/04_Debug_Request/01_Output_Debug_Info_To_Stderr/curl-ext.php)]

```php
$curlHandler = curl_init();

curl_setopt_array($curlHandler, [
    CURLOPT_URL => 'https://postman-echo.com/get?foo=bar',
    CURLOPT_RETURNTRANSFER => true,

    /**
     * Specify debug option
     */
    CURLOPT_VERBOSE => true,
]);

curl_exec($curlHandler);

curl_close($curlHandler);
```

#### PHP Guzzle library

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/01_Basics/04_Debug_Request/01_Output_Debug_Info_To_Stderr/guzzle-lib.php)]

```php
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

$httpClient = new Client();

$httpClient->get(
    'https://postman-echo.com/get?foo=bar',
    [
        RequestOptions::DEBUG => true,
    ]
);
```

<details><summary>Response</summary>
<p>

```plain
*   Trying 35.153.115.14...
* TCP_NODELAY set
* Expire in 149999 ms for 3 (transfer 0x55b754f97120)
* Expire in 200 ms for 4 (transfer 0x55b754f97120)
* Connected to postman-echo.com (35.153.115.14) port 443 (#0)
// ...
```

</p>
</details>

### Output debug info to file

#### Bash

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/01_Basics/04_Debug_Request/02_Output_Debug_Info_To_File/console.sh)]

```bash
curl --request GET "https://postman-echo.com/get?foo=bar" --verbose --silent > debug.log 2>&1
```

#### PHP CURL extension

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/01_Basics/04_Debug_Request/02_Output_Debug_Info_To_File/curl-ext.php)]

```php
$curlHandler = curl_init();

curl_setopt_array($curlHandler, [
    CURLOPT_URL => 'https://postman-echo.com/get?foo=bar',
    CURLOPT_RETURNTRANSFER => true,

    /**
     * Specify debug option.
     */
    CURLOPT_VERBOSE => true,

    /**
     * Specify log file.
     * Make sure that the folder is writable.
     */
    CURLOPT_STDERR => fopen('./curl.log', 'w+'),
]);

curl_exec($curlHandler);

curl_close($curlHandler);
```

#### PHP Guzzle library

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/01_Basics/04_Debug_Request/02_Output_Debug_Info_To_File/guzzle-lib.php)]

```php
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

$httpClient = new Client();

$httpClient->get(
    'https://postman-echo.com/get?foo=bar',
    [
        RequestOptions::DEBUG => fopen('./guzzle.log', 'w+'),
    ]
);
```

#### Log file content

```plain
*   Trying 35.153.115.14...
* TCP_NODELAY set
* Expire in 149999 ms for 3 (transfer 0x55b754f97120)
* Expire in 200 ms for 4 (transfer 0x55b754f97120)
* Connected to postman-echo.com (35.153.115.14) port 443 (#0)
// ...
```

## Error catching

#### Bash

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/01_Basics/05_Error_Catching/console.sh)]

```bash
curl --verbose --request GET "https://httpbin.org/delay/5" --max-time 3 --connect-timeout 2
```

#### PHP CURL extension

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/01_Basics/05_Error_Catching/curl-ext.php)]

```php
$curlHandler = curl_init();

curl_setopt_array($curlHandler, [
    CURLOPT_URL => 'https://httpbin.org/delay/5',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CONNECTTIMEOUT => 2,
    CURLOPT_TIMEOUT => 3,
]);

$response = curl_exec($curlHandler);
$statusCode = curl_getinfo($curlHandler, CURLINFO_HTTP_CODE);

if ($statusCode > 300) {
    print_r('Redirection or Error response with status: ' . $statusCode);
}

if (curl_errno($curlHandler) !== CURLE_OK) {
    print_r([
        'error_code' => curl_errno($curlHandler),
        'error_message' => curl_error($curlHandler),
    ]);
}

curl_close($curlHandler);
```

#### PHP Guzzle library

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/01_Basics/05_Error_Catching/guzzle-lib.php)]

```php
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Exception\GuzzleException;

$httpClient = new Client();

try {
    $response = $httpClient->get(
        'https://httpbin.org/dedlay/5',
        [
            RequestOptions::CONNECT_TIMEOUT => 2,
            RequestOptions::TIMEOUT => 3,
        ]
    );

    print_r($response->getBody()->getContents());
} catch (GuzzleException $exception) {
    print_r([
        'code' => $exception->getCode(),
        'message' => $exception->getMessage(),
    ]);
}
```

<details><summary>Response</summary>
<p>

```plain
Array
(
    [error_code] => 28
    [error_message] => Operation timed out after 3001 milliseconds with 0 bytes received
)
```

</p>
</details>

## Follow redirects

#### Bash

```bash
curl --location --max-redirs 5 -X GET "https://httpbin.org/absolute-redirect/3"
```

#### PHP CURL extension

```php
$curlHandler = curl_init();

curl_setopt_array($curlHandler, [
    CURLOPT_URL => 'https://httpbin.org/absolute-redirect/3',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_MAXREDIRS => 5,
]);

$content = curl_exec($curlHandler);
$curlInfo = curl_getinfo($curlHandler);

curl_close($curlHandler);

print_r($curlInfo);
```

#### PHP Guzzle library

```php
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\TransferStats;

$httpClient = new Client();

$response = $httpClient->get(
    'https://httpbin.org/absolute-redirect/3',
    [
        RequestOptions::ALLOW_REDIRECTS => [
            'max' => 5,
        ],
    ]
);

echo $response->getStatusCode();
```

<details><summary>Response</summary>
<p>

```json
{
  "args": {}, 
  "headers": {
    "Accept": "*/*", 
    "Host": "httpbin.org", 
    "User-Agent": "curl/7.64.0"
  }, 
  "url": "https://httpbin.org/get"
}
```

</p>
</details>

## Timeouts

#### Bash

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/01_Basics/06_Timeouts/console.sh)]

```bash
curl --request GET "https://httpbin.org/delay/5" --max-time 20 --connect-timeout 10
```

#### PHP CURL extension

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/01_Basics/06_Timeouts/curl-ext.php)]

```php
$curlHandler = curl_init();

curl_setopt_array($curlHandler, [
    CURLOPT_URL => 'https://httpbin.org/delay/5',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CONNECTTIMEOUT => 10,
    CURLOPT_TIMEOUT => 20,
]);

$response = curl_exec($curlHandler);

curl_close($curlHandler);

print_r($response);
```

#### PHP Guzzle library

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/01_Basics/06_Timeouts/guzzle-lib.php)]

```php
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

$httpClient = new Client();

$response = $httpClient->get(
    'https://httpbin.org/delay/5',
    [
        RequestOptions::CONNECT_TIMEOUT => 10,
        RequestOptions::TIMEOUT => 20,
    ]
);

print_r($response->getBody()->getContents());
```

### Set HTTP version

#### Bash

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/01_Basics/08_Set_Http_Version/console.sh)]

```bash
# See https://ec.haxx.se/http-versions.html

curl --request GET "https://httpbin.org/get" --http2
```

#### PHP CURL extension

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/01_Basics/08_Set_Http_Version/curl-ext.php)]

```php
$curlHandler = curl_init();

curl_setopt_array($curlHandler, [
    CURLOPT_URL => 'https://httpbin.org/get',
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2_0,
]);

curl_exec($curlHandler);
$info = curl_getinfo($curlHandler);
curl_close($curlHandler);

print_r($info);
```

#### PHP Guzzle library

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/01_Basics/08_Set_Http_Version/guzzle-lib.php)]

```php
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
```

<details><summary>Response</summary>
<p>

```plain
Array
(
    [url] => https://httpbin.org/get
    ...
    [http_version] => 2
    [protocol] => 2
    ...
)
```

</p>
</details>

### Get cURL version

#### Bash

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/01_Basics/09_Get_Curl_Version/console.sh)]

```bash
curl --version
```

#### PHP CURL extension and Guzzle library

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/01_Basics/09_Get_Curl_Version/curl-ext.php)]

```php
print_r(curl_version());
```

<details><summary>Response</summary>
<p>

```plain
curl 7.64.0 (x86_64-pc-linux-gnu) libcurl/7.64.0 OpenSSL/1.1.1c zlib/1.2.11 libidn2/2.0.5 libpsl/0.20.2 (+libidn2/2.0.5) libssh/0.8.6/openssl/zlib nghttp2/1.36.0 librtmp/2.3
Release-Date: 2019-02-06
Protocols: dict file ftp ftps gopher http https imap imaps ldap ldaps pop3 pop3s rtmp rtsp scp sftp smb smbs smtp smtps telnet tftp 
Features: AsynchDNS IDN IPv6 Largefile GSS-API Kerberos SPNEGO NTLM NTLM_WB SSL libz TLS-SRP HTTP2 UnixSockets HTTPS-proxy PSL
```

</p>
</details>

### Set User agent

#### Bash

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/01_Basics/10_Set_User_Agent/console.sh)]

```bash
curl --request GET "https://httpbin.org/get" --user-agent 'Mozilla/5.0 (iPhone; U; CPU like Mac OS X; en) AppleWebKit/420+ (KHTML, like Gecko) Version/3.0 Mobile/1A537a Safari/419.3'
```

#### PHP CURL extension

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/01_Basics/10_Set_User_Agent/curl-ext.php)]

```php
$curlHandler = curl_init();

curl_setopt_array($curlHandler, [
    CURLOPT_URL => 'https://postman-echo.com/get',
    CURLOPT_USERAGENT => 'Mozilla/5.0 (iPhone; U; CPU like Mac OS X; en) AppleWebKit/420+ (KHTML, like Gecko) Version/3.0 Mobile/1A537a Safari/419.3',
    
    /* OR set header
      CURLOPT_HTTPHEADER => [
        'User-Agent: Mozilla/5.0 (iPhone; U; CPU like Mac OS X; en) AppleWebKit/420+ (KHTML, like Gecko) Version/3.0 Mobile/1A537a Safari/419.3',
    ]*/
]);

$response = curl_exec($curlHandler);

curl_close($curlHandler);

print_r($response);
```

#### PHP Guzzle library

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/01_Basics/10_Set_User_Agent/guzzle-lib.php)]

```php
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

$httpClient = new Client();

$response = $httpClient->get(
    'https://httpbin.org/get',
    [
        RequestOptions::HEADERS => [
            'User-Agent' => 'Mozilla/5.0 (iPhone; U; CPU like Mac OS X; en) AppleWebKit/420+ (KHTML, like Gecko) Version/3.0 Mobile/1A537a Safari/419.3',
        ]
    ]
);

print_r($response->getBody()->getContents());
```

### Redirect Location History

#### Bash

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/01_Basics/12_Redirect_Location_History/console.sh)]

```bash
curl --verbose --location --request GET "https://httpbin.org/absolute-redirect/5" 2>&1 | grep "Location:"
```

<details><summary>Response</summary>
<p>

```plain
< Location: http://httpbin.org/absolute-redirect/4
< Location: http://httpbin.org/absolute-redirect/3
< Location: http://httpbin.org/absolute-redirect/2
< Location: http://httpbin.org/absolute-redirect/1
< Location: http://httpbin.org/get
```

</p>
</details>

#### PHP CURL extension

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/01_Basics/12_Redirect_Location_History/curl-ext.php)]

```php
$curlHandler = curl_init();

$locations = [];

curl_setopt_array(
    $curlHandler,
    [
        CURLOPT_URL => 'https://httpbin.org/absolute-redirect/5',
        CURLOPT_NOBODY => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HEADERFUNCTION => function ($curlInfo, $header) use (&$locations) {
            preg_match('#Location:\s(?<url>[\S]+)#iu', $header, $location);

            if (!empty($location['url'])) {
                $locations[] = trim($location['url']);
            }

            return mb_strlen($header);
        },
    ]
);

curl_exec($curlHandler);
curl_close($curlHandler);

print_r($locations);
```

<details><summary>Response</summary>
<p>

```plain
Array
(
    [0] => http://httpbin.org/absolute-redirect/4
    [1] => http://httpbin.org/absolute-redirect/3
    [2] => http://httpbin.org/absolute-redirect/2
    [3] => http://httpbin.org/absolute-redirect/1
    [4] => http://httpbin.org/get
)
```

</p>
</details>

#### PHP Guzzle library

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/01_Basics/12_Redirect_Location_History/guzzle-lib.php)]

```php
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\RedirectMiddleware;

$httpClient = new Client();

$response = $httpClient->get(
    'https://httpbin.org/absolute-redirect/5',
    [
        RequestOptions::ALLOW_REDIRECTS => [
            'max' => 5,
            'track_redirects' => true,
        ],
    ]
);

print_r($response->getHeader(RedirectMiddleware::HISTORY_HEADER));
```

<details><summary>Response</summary>
<p>

```plain
Array
(
    [0] => http://httpbin.org/absolute-redirect/4
    [1] => http://httpbin.org/absolute-redirect/3
    [2] => http://httpbin.org/absolute-redirect/2
    [3] => http://httpbin.org/absolute-redirect/1
    [4] => http://httpbin.org/get
)
```
</p>
</details>


### Set HTTP Referer

#### Bash

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/01_Basics/13_Set_Http_Referer/console.sh)]

```bash
curl --request GET "https://httpbin.org/get" --referer "https://github.com"
```

#### PHP CURL extension

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/01_Basics/13_Set_Http_Referer/curl-ext.php)]

```php
$curlHandler = curl_init();

curl_setopt_array($curlHandler, [
    CURLOPT_URL => 'https://httpbin.org/get',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_REFERER => 'https://github.com',
]);

$response = curl_exec($curlHandler);

curl_close($curlHandler);

print_r($response);
```

#### PHP Guzzle library

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/01_Basics/13_Set_Http_Referer/curl-ext.php)]

```php
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

$httpClient = new Client();

$response = $httpClient->get(
    'https://httpbin.org/get',
    [
        RequestOptions::HEADERS => [
            'Referer' => 'https://github.com',
        ],
    ]
);

print_r($response->getBody()->getContents());
```

<details><summary>Response</summary>
<p>

```plain
{
  "args": {}, 
  "headers": {
    "Accept": "*/*", 
    "Host": "httpbin.org", 
    "Referer": "https://github.com", 
    "User-Agent": "curl/7.64.0"
  }, 
  "origin": "100.00.00.00", 
  "url": "https://httpbin.org/get"
}
```
</p>
</details>

# Advanced

## Files

### Upload file

#### Bash

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/02_Advanced/01_Files/01_Upload/console.sh)]

```bash
# format: curl --form '[request_field_name]=@[absolute_path_to_file]' [upload_url]
curl --form 'file=@/home/serge/curl-examples/02_Advanced/01_Files/01_Upload/resource/file.txt' https://postman-echo.com/post
```

#### PHP CURL extension

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/02_Advanced/01_Files/01_Upload/curl-ext.php)]

```php
$uploadFilePath = __DIR__ . '/resource/file.txt';

if (!file_exists($uploadFilePath)) {
    throw new Exception('File not found: ' . $uploadFilePath);
}

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
```

#### PHP Guzzle library

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/02_Advanced/01_Files/01_Upload/guzzle-lib.php)]

```php
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

$httpClient = new Client();

$response = $httpClient->post(
    'https://postman-echo.com/post',
    [
        RequestOptions::MULTIPART => [
            [
                'name' => 'file',
                'contents' => new SplFileObject(__DIR__ . '/resource/file.txt', 'r'),
                'filename' => 'file',
            ]
        ],
    ]
);

echo($response->getBody()->getContents());
```

<details><summary>Response</summary>
<p>

```json
{"args":{},"data":{},"files":{"file":"data:application/octet-stream;base64,TG9yZW0gaXBzdW0gZG9sb3Igc2l0I ...
```

</p>
</details>

### Upload multiple files

#### Bash

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/02_Advanced/01_Files/02_Upload_Multiple/console.sh)]

```bash
curl --form 'text_file=@/home/serge/curl-examples/02_Advanced/01_Files/02_Upload_Multiple/resource/file.txt' \
--form 'image_file=@/home/serge/curl-examples/02_Advanced/01_Files/02_Upload_Multiple/resource/github-icon.png' \
https://postman-echo.com/post
```

#### PHP CURL extension

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/02_Advanced/01_Files/02_Upload_Multiple/curl-ext.php)]

```php
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
```

#### PHP Guzzle library

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/02_Advanced/01_Files/02_Upload_Multiple/guzzle-lib.php)]

```php
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

$localFiles = [
    'text_file' => __DIR__ . '/resource/file.txt',
    'image_file' => __DIR__ . '/resource/github-icon.png',
];

$uploadFiles = [];

foreach ($localFiles as $filePostKey => $uploadFilePath) {
    if (!file_exists($uploadFilePath)) {
        throw new Exception('File not found: ' . $uploadFilePath);
    }

    array_push($uploadFiles, [
        'name' => $filePostKey,
        'contents' => new SplFileObject($uploadFilePath, 'r'),
        'filename' => $filePostKey,
    ]);
}

$httpClient = new Client();

$response = $httpClient->post(
    'https://postman-echo.com/post',
    [
        RequestOptions::MULTIPART => $uploadFiles,
    ]
);

echo($response->getBody()->getContents());
```

### Response example

```json
{"args":{},"data":{},"files":{"text_file":"data:application/octet-stream;base64,TG9yZW0gaXBzdW0gZG9sb3Ig ...", "image_file":"data:application/octet-stream;base64,iVBORw0KGgoAAAANSUhEUgAAANAAAADQC ...
```

### Download file

#### Bash

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/02_Advanced/01_Files/03_Download/console.sh)]

```bash
curl https://httpbin.org/image/jpeg --output /home/serge/curl-examples/02_Advanced/01_Files/03_Download/resource/image.jpeg
```

#### PHP CURL extension

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/02_Advanced/01_Files/03_Download/curl-ext.php)]

```php
$imageFilePath = __DIR__ . '/resource/image.jpeg';

$curlHandler = curl_init();

curl_setopt_array($curlHandler, [
    CURLOPT_URL => 'https://httpbin.org/image/jpeg',
    CURLOPT_FILE => fopen($imageFilePath, 'w+')
]);

curl_exec($curlHandler);

if (curl_errno($curlHandler) === CURLE_OK) {
    echo 'The image has been successfully downloaded: ' . $imageFilePath;
}

curl_close($curlHandler);
```

#### PHP Guzzle library

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/02_Advanced/01_Files/03_Download/guzzle-lib.php)]

```php
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

$imageFilePath = __DIR__ . '/resource/image.jpeg';
$imageFileResource = fopen($imageFilePath, 'w+');

$httpClient = new Client();
$response = $httpClient->get(
    'https://httpbin.org/image/jpeg',
    [
        RequestOptions::SINK => $imageFileResource,
    ]
);

if ($response->getStatusCode() === 200) {
    echo 'The image has been successfully downloaded: ' . $imageFilePath;
}
```

<details><summary>Response</summary>
<p>

```plain
The image has been successfully downloaded: /home/serge/curl-examples/02_Advanced/01_Files/03_Download/resource/image.jpeg
```

</p>
</details>

## Auth

### Basic Auth

#### Bash

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/02_Advanced/02_Auth/01_Basic_Auth/console.sh)]

```bash
curl --user postman:password --request GET "https://postman-echo.com/basic-auth"
```

#### PHP CURL extension

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/02_Advanced/02_Auth/01_Basic_Auth/curl-ext.php)]

```php
$curlHandler = curl_init();

$userName = 'postman';
$password = 'password';

curl_setopt_array($curlHandler, [
    CURLOPT_URL => 'https://postman-echo.com/basic-auth',
    CURLOPT_RETURNTRANSFER => true,

    CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
    CURLOPT_USERPWD => $userName . ':' . $password,
]);

$response = curl_exec($curlHandler);
curl_close($curlHandler);

print_r('First example response: ' . $response . PHP_EOL);

/**
 * Or specify credentials in Authorization header
 */

$curlSecondHandler = curl_init();

curl_setopt_array($curlSecondHandler, [
    CURLOPT_URL => 'https://postman-echo.com/basic-auth',
    CURLOPT_RETURNTRANSFER => true,

    CURLOPT_HTTPHEADER => [
        'Authorization: Basic ' . base64_encode($userName . ':' . $password)
    ],
]);

$response = curl_exec($curlSecondHandler);
curl_close($curlSecondHandler);

print_r('Second example response: ' . $response . PHP_EOL);
```

#### PHP Guzzle library

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/02_Advanced/02_Auth/01_Basic_Auth/guzzle-lib.php)]

```php
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

$userName = 'postman';
$password = 'password';

$httpClient = new Client();

$response = $httpClient->get(
    'https://postman-echo.com/basic-auth',
    [
        RequestOptions::AUTH => [$userName, $password]
    ]
);

print_r($response->getBody()->getContents());
```

<details><summary>Response</summary>
<p>

```json
{"authenticated":true}
```

</p>
</details>

### Digest Auth

#### Bash

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/02_Advanced/02_Auth/02_Digest_Auth/console.sh)]

```bash
curl --digest --user postman:password --request GET "https://postman-echo.com/digest-auth"
```

#### PHP CURL extension

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/02_Advanced/02_Auth/02_Digest_Auth/curl-ext.php)]

```php
$curlHandler = curl_init();

$userName = 'postman';
$password = 'password';

curl_setopt_array($curlHandler, [
    CURLOPT_URL => 'https://postman-echo.com/digest-auth',
    CURLOPT_RETURNTRANSFER => true,

    CURLOPT_HTTPAUTH => CURLAUTH_DIGEST,
    CURLOPT_USERPWD => $userName . ':' . $password,
]);

$response = curl_exec($curlHandler);
curl_close($curlHandler);

print_r($response);
```

#### PHP Guzzle library

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/02_Advanced/02_Auth/02_Digest_Auth/guzzle-lib.php)]

```php
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

$userName = 'postman';
$password = 'password';

$httpClient = new Client();

$response = $httpClient->get(
    'https://postman-echo.com/digest-auth',
    [
        RequestOptions::AUTH => [$userName, $password, 'digest']
    ]
);

print_r($response->getBody()->getContents());
```

<details><summary>Response</summary>
<p>

```json
{"authenticated":true}
```

</p>
</details>

### Bearer Auth

#### Bash

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/02_Advanced/02_Auth/03_Bearer_Auth/console.sh)]

```bash
curl -X GET "https://httpbin.org/bearer" -H "Accept: application/json" -H "Authorization: Bearer your_token"
```

#### PHP CURL extension

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/02_Advanced/02_Auth/03_Bearer_Auth/curl-ext.php)]

```php
$curlHandler = curl_init();

$token = 'your_token';

curl_setopt_array($curlHandler, [
    CURLOPT_URL => 'https://httpbin.org/bearer',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        'Accept: application/json',
        'Authorization: Bearer ' . $token
    ],
]);

$response = curl_exec($curlHandler);
curl_close($curlHandler);

print_r($response);
```

#### PHP Guzzle library

[[example](https://github.com/andriichuk/php-curl-cookbook/blob/master/02_Advanced/02_Auth/03_Bearer_Auth/guzzle-lib.php)]

```php
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

$token = 'your_token';

$httpClient = new Client();

$response = $httpClient->get(
    'https://httpbin.org/bearer',
    [
        RequestOptions::HEADERS => [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ]
    ]
);

print_r($response->getBody()->getContents());
```

<details><summary>Response</summary>
<p>

```json
{
  "authenticated": true, 
  "token": "your_token"
}
```

</p>
</details>

## Todo

- [x] Set HTTP version
- [x] Get cURL version
- [x] Set User agent
- [x] HTTP Referer
- [ ] Cache control
- [ ] HTTP methods (HEAD, CONNECT, OPTIONS, TRACE)
- [ ] Cookies
- [ ] Proxy
- [ ] Transfer progress
- [ ] Upload array of files in one POST field
- [ ] Upload/Download large files
- [ ] FTP transfer
- [ ] All types of Auth
- [ ] Multiple cURL handlers
- [ ] SSL certificates
- [ ] Streams
- [ ] SOAP request
- [ ] Best practices
