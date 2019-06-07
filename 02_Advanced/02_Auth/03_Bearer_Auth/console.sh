#!/usr/bin/env bash

curl -X GET "https://httpbin.org/bearer" -H "Accept: application/json" -H "Authorization: Bearer your_token"