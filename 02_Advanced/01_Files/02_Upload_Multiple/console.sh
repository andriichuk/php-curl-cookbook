#!/usr/bin/env bash

curl --form 'text_file=@/home/serge/startups/CurlTutorial/source-code/02_Advanced/01_Files/02_Upload_Multiple/resource/file.txt' \
--form 'image_file=@/home/serge/startups/CurlTutorial/source-code/02_Advanced/01_Files/02_Upload_Multiple/resource/github-icon.png' \
https://postman-echo.com/post