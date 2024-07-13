#!/usr/bin/bash


message=$1;

./vendor/bin/propel sql:build --overwrite;
./vendor/bin/propel model:build;
./vendor/bin/propel config:convert;
./vendor/bin/propel sql:insert;


git add ./generated-*;


echo "Commiting with message $1";
git commit -m "$1";