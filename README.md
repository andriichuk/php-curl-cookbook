# List of commonly used cases with CURL library

Library [Home Page](https://curl.haxx.se/) and [Wiki Page](https://ec.haxx.se/).

PHP [Extension Page](http://docs.php.net/manual/en/book.curl.php) and [List Of Options](http://docs.php.net/manual/en/function.curl-setopt.php).

PHP [Guzzle](http://docs.guzzlephp.org/en/stable/overview.html) library - wrapper over PHP CURL extension.

For testing requests we will use the excellent services [httpbin.org](https://httpbin.org/) and [Postman Echo](https://docs.postman-echo.com).

## Request methods

### GET Method

#### Bash

```bash
curl --request GET "https://postman-echo.com/get?foo=bar" --max-time 10
```

#### PHP CURL extension

```php
$curlHandler = curl_init();

curl_setopt_array($curlHandler, [
    CURLOPT_URL => 'https://postman-echo.com/get?foo=bar',
    CURLOPT_CONNECTTIMEOUT => 10,
    CURLOPT_TIMEOUT => 10,
    CURLOPT_RETURNTRANSFER => true,
]);

$response = curl_exec($curlHandler);
curl_close($curlHandler);

echo($response);
```

#### PHP Guzzle library

```php
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

$httpClient = new Client([
    RequestOptions::TIMEOUT => 10.0,
    RequestOptions::CONNECT_TIMEOUT => 10.0,
]);

$response = $httpClient->get(
    'https://postman-echo.com/get',
    [
        RequestOptions::QUERY => [
            'foo' => 'bar',
        ],
    ]
);

echo(
    $response->getBody()->getContents()
);
```

#### Response example

```json
{"args":{"foo":"bar"},"headers":{"x-forwarded-proto":"https","host":"postman-echo.com","user-agent":"GuzzleHttp/6.3.3 curl/7.64.0 PHP/7.3.5-1+ubuntu19.04.1+deb.sury.org+1","x-forwarded-port":"443"},"url":"https://postman-echo.com/get?foo=bar"}
```

### POST raw request

#### Bash

```bash
curl --request POST "https://postman-echo.com/post" --data "POST raw request content" --max-time 10
```

#### PHP CURL extension

```php
$curlHandler = curl_init();

curl_setopt_array($curlHandler, [
    CURLOPT_URL => 'https://postman-echo.com/post',
    CURLOPT_CONNECTTIMEOUT => 10,
    CURLOPT_TIMEOUT => 10,
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

```php

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

$httpClient = new Client([
    RequestOptions::TIMEOUT => 10.0,
    RequestOptions::CONNECT_TIMEOUT => 10.0,
]);

$response = $httpClient->post(
    'https://postman-echo.com/post',
    [
        RequestOptions::BODY => 'POST raw request content',
        RequestOptions::HEADERS => [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ],
    ]
);

echo(
    $response->getBody()->getContents()
);
```

#### Response expample

```json
{"args":{},"data":"","files":{},"form":{"POST raw request content":""},"headers":{"x-forwarded-proto":"https","host":"postman-echo.com","content-length":"24","content-type":"application/x-www-form-urlencoded","user-agent":"GuzzleHttp/6.3.3 curl/7.64.0 PHP/7.3.5-1+ubuntu19.04.1+deb.sury.org+1","x-forwarded-port":"443"},"json":{"POST raw request content":""},"url":"https://postman-echo.com/post"}
```

### POST form data

#### Bash

```bash
curl --request POST "https://postman-echo.com/post" --data "foo=bar&baz=biz" --max-time 10
```

#### PHP CURL extension

```php
$curlHandler = curl_init();

curl_setopt_array($curlHandler, [
    CURLOPT_URL => 'https://postman-echo.com/post',
    CURLOPT_CONNECTTIMEOUT => 10,
    CURLOPT_TIMEOUT => 10,
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

```php
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

$httpClient = new Client([
    RequestOptions::TIMEOUT => 10.0,
    RequestOptions::CONNECT_TIMEOUT => 10.0,
]);

$response = $httpClient->post(
    'https://postman-echo.com/post',
    [
        RequestOptions::FORM_PARAMS => [
            'foo' => 'bar',
            'baz' => 'biz',
        ],
    ]
);

echo(
    $response->getBody()->getContents()
);
```

#### Response example

```json
{"args":{},"data":"","files":{},"form":{"foo":"bar","baz":"biz"},"headers":{"x-forwarded-proto":"https","host":"postman-echo.com","content-length":"15","content-type":"application/x-www-form-urlencoded","user-agent":"GuzzleHttp/6.3.3 curl/7.64.0 PHP/7.3.5-1+ubuntu19.04.1+deb.sury.org+1","x-forwarded-port":"443"},"json":{"foo":"bar","baz":"biz"},"url":"https://postman-echo.com/post"}
```

### PUT method

#### Bash

```bash
curl --request PUT "https://postman-echo.com/put" --data "foo=bar&baz=biz" --max-time 10
```

#### PHP CURL extension

```php
$curlHandler = curl_init();

curl_setopt_array($curlHandler, [
    CURLOPT_URL => 'https://postman-echo.com/put',
    CURLOPT_CONNECTTIMEOUT => 10,
    CURLOPT_TIMEOUT => 10,
    CURLOPT_RETURNTRANSFER => true,

    /**
     * Specify custom HTTP request method
     */
    CURLOPT_CUSTOMREQUEST => 'PUT',

    /**
     * Specify request body (can be array of string)
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

```php
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

$httpClient = new Client([
    RequestOptions::TIMEOUT => 10.0,
    RequestOptions::CONNECT_TIMEOUT => 10.0,
]);

$response = $httpClient->put(
    'https://postman-echo.com/put',
    [
        RequestOptions::FORM_PARAMS => [
            'foo' => 'bar',
            'baz' => 'biz',
        ],
    ]
);

echo(
    $response->getBody()->getContents()
);
```

#### Response example

```json
{"args":{},"data":"","files":{},"form":{"foo":"bar","baz":"biz"},"headers":{"x-forwarded-proto":"https","host":"postman-echo.com","content-length":"15","content-type":"application/x-www-form-urlencoded","user-agent":"GuzzleHttp/6.3.3 curl/7.64.0 PHP/7.3.5-1+ubuntu19.04.1+deb.sury.org+1","x-forwarded-port":"443"},"json":{"foo":"bar","baz":"biz"},"url":"https://postman-echo.com/put"}
```

### PATCH method

#### Bash

```bash
curl --request PATCH "https://postman-echo.com/patch" --data "foo=bar&baz=biz" --max-time 10
```

#### PHP CURL extension

```php
$curlHandler = curl_init();

curl_setopt_array($curlHandler, [
    CURLOPT_URL => 'https://postman-echo.com/patch',
    CURLOPT_CONNECTTIMEOUT => 10,
    CURLOPT_TIMEOUT => 10,
    CURLOPT_RETURNTRANSFER => true,

    /**
     * Specify custom HTTP request method
     */
    CURLOPT_CUSTOMREQUEST => 'PATCH',

    /**
     * Specify request body (can be array of string)
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

```php
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

$httpClient = new Client([
    RequestOptions::TIMEOUT => 10.0,
    RequestOptions::CONNECT_TIMEOUT => 10.0,
]);

$response = $httpClient->patch(
    'https://postman-echo.com/patch',
    [
        RequestOptions::FORM_PARAMS => [
            'foo' => 'bar',
            'baz' => 'biz',
        ],
    ]
);

echo(
    $response->getBody()->getContents()
);
```

#### Response example

```json
{"args":{},"data":"","files":{},"form":{"foo":"bar","baz":"biz"},"headers":{"x-forwarded-proto":"https","host":"postman-echo.com","content-length":"15","accept":"*/*","content-type":"application/x-www-form-urlencoded","user-agent":"curl/7.64.0","x-forwarded-port":"443"},"json":{"foo":"bar","baz":"biz"},"url":"https://postman-echo.com/patch"}
```
