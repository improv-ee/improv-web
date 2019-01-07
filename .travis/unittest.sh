#!/usr/bin/env bash

set -e

cd src
touch .env

echo "Installing Composer dependencies..."
composer install --no-interaction

echo "Running unit tests..."
php vendor/bin/phpunit
