#!/usr/bin/env bash

set -e

cd src

npm i -g npm@6.7.0
npm ci

exec npm run lint
