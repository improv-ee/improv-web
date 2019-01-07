#!/usr/bin/env bash

set -e

cd src
touch .env

sudo apt-get install -y libpng-dev jpegoptim optipng pngquant gifsicle

composer install --no-interaction --dev
npm install

php artisan passport:keys

php vendor/bin/phpunit
