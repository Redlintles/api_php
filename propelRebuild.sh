#!/usr/bin/bash


message=$1;

rm -rf ./conf;
rm -rf ./generated-sql;
rm -rf ./src;

./vendor/bin/propel sql:build --overwrite;
./vendor/bin/propel model:build;
./vendor/bin/propel config:convert;
./vendor/bin/propel sql:insert;


mv ./generated-classes ./src;
mv ./generated-conf ./conf;

git add ./src ./conf ./generated-sql;

git commit -m "$1";