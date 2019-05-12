# List of commonly used cases with CURL library

CURL Library [Home Page](https://curl.haxx.se/) and [Wiki Page](https://ec.haxx.se/).

PHP [Extension Page](http://docs.php.net/manual/en/book.curl.php) and [List Of Options](http://docs.php.net/manual/en/function.curl-setopt.php).

PHP [Guzzle](http://docs.guzzlephp.org/en/stable/overview.html) library - wrapper over PHP CURL extension.

For testing requests we will use the excellent services [httpbin.org](https://httpbin.org/) and [Postman Echo](https://docs.postman-echo.com).

## Request methods

### GET

**Bash**

```bash
curl --request GET "https://postman-echo.com/get?foo=bar" --max-time 10
```

**PHP CURL extension**

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

**Guzzle library**

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

**Response example**
```json
{"args":{"foo":"bar"},"headers":{"x-forwarded-proto":"https","host":"postman-echo.com","user-agent":"GuzzleHttp/6.3.3 curl/7.64.0 PHP/7.3.5-1+ubuntu19.04.1+deb.sury.org+1","x-forwarded-port":"443"},"url":"https://postman-echo.com/get?foo=bar"}
```
