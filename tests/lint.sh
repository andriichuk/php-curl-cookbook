#!/usr/bin/env bash

set -euo pipefail

cd -- "$(dirname -- "${BASH_SOURCE[0]}")/.."

directories=(01_Basics 02_Advanced)
case "${1:-}" in
    '') directories+=(tests) ;;
    --examples-only) ;;
    *) echo "Usage: $0 [--examples-only]" >&2; exit 2 ;;
esac

while IFS= read -r -d '' file; do
    php -l "$file"
done < <(find "${directories[@]}" -type f -name '*.php' -print0)

bash -n run console
while IFS= read -r -d '' file; do
    bash -n "$file"
done < <(find 01_Basics 02_Advanced tests -type f -name '*.sh' -print0)
