#!/usr/bin/env bash

curl --request GET "https://postman-echo.com/get?foo=bar" --verbose --silent > debug.log 2>&1