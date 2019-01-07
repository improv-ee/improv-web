#!/usr/bin/env bash

cd src
touch .env

echo "Installing Composer dependencies..."
composer install --no-interaction


# Setup coverage reporter
curl -L https://codeclimate.com/downloads/test-reporter/test-reporter-latest-linux-amd64 > ./cc-test-reporter
chmod +x ./cc-test-reporter
./cc-test-reporter before-build

echo "Running unit tests..."
php vendor/bin/phpunit

./cc-test-reporter after-build -t clover --exit-code $?
