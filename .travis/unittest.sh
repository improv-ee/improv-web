#!/usr/bin/env bash

set -e

cd src
touch .env

composer install --no-interaction
npm install

php artisan passport:install

php vendor/bin/phpunit
