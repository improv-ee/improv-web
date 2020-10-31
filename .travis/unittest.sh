#!/usr/bin/env bash

set -e

cd src
touch .env

echo "Installing Composer dependencies..."
composer install --no-interaction


# Setup coverage reporter
curl -L https://codeclimate.com/downloads/test-reporter/test-reporter-latest-linux-amd64 > ./cc-test-reporter
chmod +x ./cc-test-reporter
./cc-test-reporter before-build


# Travis, by default, has older version of NPM
# Upgrade it to a minimum acceptable version for us
npm i -g npm@6.7.0
npm ci

# Static assets are needed for Laravel Mix \ unittests that test for Blade
echo "Generating static assets"
npm run development

echo "Running unit tests..."
php vendor/bin/phpunit

./cc-test-reporter after-build -t clover --exit-code $?
