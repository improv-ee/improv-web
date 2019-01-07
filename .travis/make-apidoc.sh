#!/usr/bin/env bash

set -e
cd src

cp .env.testing .env
composer install --no-interaction --dev
php artisan passport:keys
php artisan apidoc:generate

