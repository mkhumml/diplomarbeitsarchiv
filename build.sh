#!/bin/bash

npm run build
cp -rf ./dist /Applications/MAMP/htdocs/diplomarbeitsarchiv
cp -rf ./styles /Applications/MAMP/htdocs/diplomarbeitsarchiv