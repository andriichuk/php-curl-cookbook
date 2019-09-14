#!/usr/bin/env bash

curl --location --cookie-jar "02_Advanced/03_Cookies/04_Save_Response_Cookies_To_File/resource/cookie-jar.txt" --request GET "https://httpbin.org/cookies/set/foo/bar"