#!/usr/bin/env bash

set -e

cd /var/www/improv-ee/src && \
    git reset --hard && \
    git pull origin master && \
    composer install && \
    npm install && \
    npm run prod && \
    php artisan migrate --force
