#!/usr/bin/env bash

set -e
cd src

cp .env.testing .env
composer install --no-interaction --dev
php artisan passport:keys
APP_URL=https://api.improvision.eu php artisan apidoc:generate

cd public/docs
rm -rf source

docker login -u="$DOCKER_USERNAME" -p="$DOCKER_PASSWORD"
export TAG=`if [ "$TRAVIS_BRANCH" == "master" ]; then echo "latest"; else echo $TRAVIS_BRANCH | tr / - ; fi`
docker build -t improvision/api-docs:$TAG .

docker push improvision/api-docs:$TAG
docker rmi improvision/api-docs:$TAG

docker logout
