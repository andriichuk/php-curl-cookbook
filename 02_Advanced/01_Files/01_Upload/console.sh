#!/usr/bin/env bash

# format: curl --form '[request_field_name]=@[absolute_path_to_file]' [upload_url]
curl --form 'file=@/home/serge/curl-examples/02_Advanced/01_Files/01_Upload/resource/file.txt' https://postman-echo.com/post