#!/usr/bin/env bash

# See https://ec.haxx.se/http-versions.html

curl --request GET "https://httpbin.org/get" --http2 -w "http_version:  %{http_version}" -o /dev/null -s