#!/usr/bin/env bash

curl --cookie "02_Advanced/03_Cookies/03_Send_Cookies_From_File/resource/cookie-jar.txt" --request GET "https://httpbin.org/cookies"