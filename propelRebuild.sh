#!/usr/bin/bash

set -e

message=$1

ROOT=/var/www/html

php "$ROOT/vendor/bin/propel" sql:build --overwrite
php "$ROOT/vendor/bin/propel" model:build
php "$ROOT/vendor/bin/propel" config:convert
php "$ROOT/vendor/bin/propel" sql:insert
