# List of commonly used cases with CURL library

Library [Home Page](https://curl.haxx.se/) and [Wiki Page](https://ec.haxx.se/).

PHP [Extension Page](http://docs.php.net/manual/en/book.curl.php) and [List Of Options](http://docs.php.net/manual/en/function.curl-setopt.php).

PHP [Guzzle](http://docs.guzzlephp.org/en/stable/overview.html) library - wrapper over PHP CURL extension.

For testing requests we will use the excellent services [httpbin.org](https://httpbin.org/) and [Postman Echo](https://docs.postman-echo.com).

## HTTP Request methods

### Send HTTP request using GET method

#### Bash 

[[example](https://github.com/andriichuk/curl-examples/blob/master/01_Basics/01_Request_Methods/01_Get/console.sh)]

```bash
curl --request GET "https://postman-echo.com/get?foo=bar"
```

#### PHP CURL extension 

[[example](https://github.com/andriichuk/curl-examples/blob/master/01_Basics/01_Request_Methods/01_Get/curl-ext.php)]

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

[[example](https://github.com/andriichuk/curl-examples/blob/master/01_Basics/01_Request_Methods/01_Get/guzzle-lib.php)]

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

[[example](https://github.com/andriichuk/curl-examples/blob/master/01_Basics/01_Request_Methods/02_Post_Raw_Data/console.sh)]

```bash
curl --request POST "https://postman-echo.com/post" --data "POST raw request content"
```

#### PHP CURL extension

[[example](https://github.com/andriichuk/curl-examples/blob/master/01_Basics/01_Request_Methods/02_Post_Raw_Data/curl-ext.php)]

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

[[example](https://github.com/andriichuk/curl-examples/blob/master/01_Basics/01_Request_Methods/02_Post_Raw_Data/guzzle-lib.php)]

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
curl --request POST "https://postman-echo.com/post" --data "foo=bar&baz=biz"
```

#### PHP CURL extension

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
curl --request PUT "https://postman-echo.com/put" --data "foo=bar&baz=biz"
```

#### PHP CURL extension

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

echo(
    $response->getBody()->getContents()
);
```

#### Response example

```json
{"args":{},"data":"","files":{},"form":{"foo":"bar","baz":"biz"},"headers":{"x-forwarded-proto":"https","host":"postman-echo.com","content-length":"15","accept":"*/*","content-type":"application/x-www-form-urlencoded","user-agent":"curl/7.64.0","x-forwarded-port":"443"},"json":{"foo":"bar","baz":"biz"},"url":"https://postman-echo.com/patch"}
```

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

echo(
    $response->getBody()->getContents()
);
```

#### Response example

```json
{"args":{},"data":"","files":{},"form":{"foo":"bar","baz":"biz"},"headers":{"x-forwarded-proto":"https","host":"postman-echo.com","content-length":"15","content-type":"application/x-www-form-urlencoded","user-agent":"GuzzleHttp/6.3.3 curl/7.64.0 PHP/7.3.5-1+ubuntu19.04.1+deb.sury.org+1","x-forwarded-port":"443"},"json":{"foo":"bar","baz":"biz"},"url":"https://postman-echo.com/delete"}
```

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

#### Response example

```json
{"headers":{"x-forwarded-proto":"https","host":"postman-echo.com","baz":"biz","foo":"bar","user-agent":"GuzzleHttp/6.3.3 curl/7.64.0 PHP/7.3.5-1+ubuntu19.04.1+deb.sury.org+1","x-forwarded-port":"443"}}
```

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

#### Response example

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

#### Response example

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

## Debug Request

### Output debug info to STDERR

#### Bash

[[example](https://github.com/andriichuk/curl-examples/blob/master/01_Basics/04_Debug_Request/01_Output_Debug_Info_To_Stderr/console.sh)]

```bash
curl --verbose --request GET "https://postman-echo.com/get?foo=bar"
```

#### PHP CURL extension

[[example](https://github.com/andriichuk/curl-examples/blob/master/01_Basics/04_Debug_Request/01_Output_Debug_Info_To_Stderr/curl-ext.php)]

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

[[example](https://github.com/andriichuk/curl-examples/blob/master/01_Basics/04_Debug_Request/01_Output_Debug_Info_To_Stderr/guzzle-lib.php)]

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

#### Response example

```plain
*   Trying 35.153.115.14...
* TCP_NODELAY set
* Expire in 149999 ms for 3 (transfer 0x55b754f97120)
* Expire in 200 ms for 4 (transfer 0x55b754f97120)
* Connected to postman-echo.com (35.153.115.14) port 443 (#0)
// ...
```

### Output debug info to file

#### Bash

[[example](https://github.com/andriichuk/curl-examples/blob/master/01_Basics/04_Debug_Request/02_Output_Debug_Info_To_File/console.sh)]

```bash
curl --request GET "https://postman-echo.com/get?foo=bar" --verbose --silent > debug.log 2>&1
```

#### PHP CURL extension

[[example](https://github.com/andriichuk/curl-examples/blob/master/01_Basics/04_Debug_Request/02_Output_Debug_Info_To_File/curl-ext.php)]

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

[[example](https://github.com/andriichuk/curl-examples/blob/master/01_Basics/04_Debug_Request/02_Output_Debug_Info_To_File/guzzle-lib.php)]

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
    CURLOPT_FOLLOWLOCATION => false,
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

#### Response example

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

## Timeouts

#### Bash

[[example](https://github.com/andriichuk/curl-examples/blob/master/01_Basics/06_Timeouts/console.sh)]

```bash
curl --request GET "https://httpbin.org/delay/5" --max-time 20 --connect-timeout 10
```

#### PHP CURL extension

[[example](https://github.com/andriichuk/curl-examples/blob/master/01_Basics/06_Timeouts/curl-ext.php)]

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

[[example](https://github.com/andriichuk/curl-examples/blob/master/01_Basics/06_Timeouts/guzzle-lib.php)]

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

## Files

### Upload file

#### Bash

[[example](https://github.com/andriichuk/curl-examples/blob/master/02_Advanced/01_Files/01_Upload/console.sh)]

```bash
# format: curl --form '[request_field_name]=@[absolute_path_to_file]' [upload_url]
curl --form 'file=@/home/serge/curl-examples/02_Advanced/01_Files/01_Upload/resource/file.txt' https://postman-echo.com/post
```

#### PHP CURL extension

[[example](https://github.com/andriichuk/curl-examples/blob/master/02_Advanced/01_Files/01_Upload/curl-ext.php)]

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

[[example](https://github.com/andriichuk/curl-examples/blob/master/02_Advanced/01_Files/01_Upload/guzzle-lib.php)]

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

#### Response example

```json
{"args":{},"data":{},"files":{"file":"data:application/octet-stream;base64,TG9yZW0gaXBzdW0gZG9sb3Igc2l0I ...
```

### Upload multiple files

#### Bash

[[example](https://github.com/andriichuk/curl-examples/blob/master/02_Advanced/01_Files/02_Upload_Multiple/console.sh)]

```bash
curl --form 'text_file=@/home/serge/startups/CurlTutorial/source-code/02_Advanced/01_Files/02_Upload_Multiple/resource/file.txt' \
--form 'image_file=@/home/serge/startups/CurlTutorial/source-code/02_Advanced/01_Files/02_Upload_Multiple/resource/github-icon.png' \
https://postman-echo.com/post
```

#### PHP CURL extension

[[example](https://github.com/andriichuk/curl-examples/blob/master/02_Advanced/01_Files/02_Upload_Multiple/curl-ext.php)]

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

[[example](https://github.com/andriichuk/curl-examples/blob/master/002_Advanced/01_Files/02_Upload_Multiple/guzzle-lib.php)]

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
