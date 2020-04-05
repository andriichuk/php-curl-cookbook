#!/usr/bin/env bash

curl --form 'documents[]=@/home/serge/projects/php-curl-cookbook/02_Advanced/01_Files/03_Upload_Array_Of_Files/resource/file-1.txt' \
--form 'documents[]=@/home/serge/projects/php-curl-cookbook/02_Advanced/01_Files/03_Upload_Array_Of_Files/resource/file-2.txt' \
--form 'images[icon]=@/home/serge/projects/php-curl-cookbook/02_Advanced/01_Files/03_Upload_Array_Of_Files/resource/github-icon.png' \
--form 'images[octocat]=@/home/serge/projects/php-curl-cookbook/02_Advanced/01_Files/03_Upload_Array_Of_Files/resource/github-octocat.jpg' \
https://postman-echo.com/post
