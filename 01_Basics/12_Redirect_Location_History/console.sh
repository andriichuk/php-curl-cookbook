#!/usr/bin/env bash

curl --verbose --location --request GET "https://httpbin.org/absolute-redirect/5" 2>&1 | grep "Location:"