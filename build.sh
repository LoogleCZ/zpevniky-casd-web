#!/bin/bash

rm -r out/

mkdir -p out/css/
mkdir -p out/js/
cp src/templates/css/styles.css out/css/styles.css
cp src/templates/js/datatable.js out/js/datatable.js
php build.php index.phtml > out/index.html

mkdir -p out/download
cp -r db/* out/download
rm -r out/download/_scripts

for directory in out/download/*/ ; do
    current=`pwd`
    zipBasename=`basename "$directory"`
    cd "$directory" && zip -r "../$zipBasename.zip" *
    cd "$current"
done
