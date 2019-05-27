#!/usr/bin/env bash

curl --request GET "https://httpbin.org/delay/5" --max-time 3 --connect-timeout 2