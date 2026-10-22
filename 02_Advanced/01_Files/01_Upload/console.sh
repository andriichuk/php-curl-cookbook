#!/usr/bin/env bash

script_dir="$(cd -- "$(dirname -- "${BASH_SOURCE[0]}")" && pwd)"

curl --form "file=@${script_dir}/resource/file.txt" https://postman-echo.com/post
