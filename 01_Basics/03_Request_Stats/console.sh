#!/usr/bin/env bash

# See full list of options here https://ec.haxx.se/usingcurl-writeout.html

curl --request GET "https://postman-echo.com/get?foo=bar" -w "size_download:  %{size_download}" -o /dev/null -s