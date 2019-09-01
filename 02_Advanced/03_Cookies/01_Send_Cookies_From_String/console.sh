#!/usr/bin/env bash

curl --cookie "foo=bar;baz=foo" --request GET "https://httpbin.org/cookies"