#!/usr/bin/env bash

set -e
cd src

cp .env.testing .env
composer install --no-interaction --dev
php artisan passport:keys
APP_URL=https://api.improvision.eu php artisan apidoc:generate

mv build/api-docs/Dockerfile public/docs/
mv build/api-docs/source/prepend.md public/docs/source/

APP_URL=https://api.improvision.eu php artisan apidoc:rebuild

cd public/docs
rm -rf source

docker login -u="$DOCKER_USERNAME" -p="$DOCKER_PASSWORD"
export TAG=`if [ "$TRAVIS_BRANCH" == "master" ]; then echo "latest"; else echo $TRAVIS_BRANCH | tr / - ; fi`
docker build -t improvision/api-docs:$TAG .

docker push improvision/api-docs:$TAG
docker rmi improvision/api-docs:$TAG

docker logout
