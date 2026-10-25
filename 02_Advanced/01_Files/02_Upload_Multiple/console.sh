#!/usr/bin/env bash

script_dir="$(cd -- "$(dirname -- "${BASH_SOURCE[0]}")" && pwd)"

curl --form "text_file=@${script_dir}/resource/file.txt" \
--form "image_file=@${script_dir}/resource/github-icon.png" \
https://postman-echo.com/post
