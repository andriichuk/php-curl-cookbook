#!/usr/bin/env bash

script_dir="$(cd -- "$(dirname -- "${BASH_SOURCE[0]}")" && pwd)"

curl --form "documents[]=@${script_dir}/resource/file-1.txt" \
--form "documents[]=@${script_dir}/resource/file-2.txt" \
--form "images[icon]=@${script_dir}/resource/github-icon.png" \
https://postman-echo.com/post
