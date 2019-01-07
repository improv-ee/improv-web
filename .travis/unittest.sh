#!/usr/bin/env bash

set -e

cd src
touch .env

composer install --no-interaction --dev
npm install

php artisan passport:keys

php vendor/bin/phpunit
