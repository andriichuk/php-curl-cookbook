<?php

namespace CookbookTests;

require_once dirname(__DIR__) . '/vendor/autoload.php';

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;

class Client extends \GuzzleHttp\Client
{
    public static $handler;

    public function __construct(array $config = [])
    {
        $config['handler'] = self::$handler;
        parent::__construct($config);
    }
}

// Capture native cURL options without opening a connection.
function curl_init()
{
    $handle = new \stdClass();
    $handle->options = [];
    $GLOBALS['cookbookCurlHandles'][] = $handle;

    return $handle;
}

function curl_setopt_array($handle, array $options)
{
    $handle->options = $options;

    return true;
}

function curl_exec($handle)
{
    return '{}';
}

function curl_getinfo($handle, $option = null)
{
    return $option === CURLINFO_HTTP_CODE ? $GLOBALS['cookbookStatus'] : [];
}

function curl_errno($handle)
{
    return CURLE_OK;
}

function curl_close($handle)
{
}

/**
 * Execute a standalone example with test transports. Only its namespace, Client
 * import and __DIR__ are adapted; its request construction remains unchanged.
 */
function runExample($relativePath, array &$history, array $responses = [], $status = 200)
{
    $path = dirname(__DIR__) . '/' . $relativePath;
    $source = '';
    foreach (token_get_all(file_get_contents($path)) as $token) {
        if (is_array($token)) {
            if ($token[0] === T_OPEN_TAG) {
                continue;
            }
            $source .= $token[0] === T_DIR ? var_export(dirname($path), true) : $token[1];
        } else {
            $source .= $token;
        }
    }
    $source = str_replace('use GuzzleHttp\\Client;', 'use CookbookTests\\Client;', $source);

    $history = [];
    $stack = HandlerStack::create(new MockHandler($responses ?: [new Response(200, [], '{}')]));
    $stack->push(Middleware::history($history));
    Client::$handler = $stack;
    $GLOBALS['cookbookCurlHandles'] = [];
    $GLOBALS['cookbookStatus'] = $status;

    ob_start();
    try {
        eval('namespace CookbookTests; use \\CURLFile; use \\SplFileObject; use \\Exception;' . $source);
        $output = ob_get_contents();
    } finally {
        ob_end_clean();
    }

    return ['output' => $output, 'handles' => $GLOBALS['cookbookCurlHandles']];
}
