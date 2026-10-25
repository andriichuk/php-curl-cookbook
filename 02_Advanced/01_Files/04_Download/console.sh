#!/usr/bin/env bash

script_dir="$(cd -- "$(dirname -- "${BASH_SOURCE[0]}")" && pwd)"

curl https://httpbin.org/image/jpeg --output "${script_dir}/resource/image.jpeg"
