#!/usr/bin/env bash

set -e
cd src

cp .env.testing .env
composer install --no-interaction --dev


export APP_URL=https://api.improvision.eu
export APP_DEBUG=false

php artisan migrate
php artisan passport:insall
export OAUTH_TOKEN=$(php artisan apidoc:seed)

php artisan apidoc:generate

mv build/api-docs/Dockerfile public/docs/
mv build/api-docs/source/prepend.md public/docs/source/

php artisan apidoc:rebuild

cd public/docs
rm -rf source

docker login -u="$DOCKER_USERNAME" -p="$DOCKER_PASSWORD"
export TAG=`if [ "$TRAVIS_BRANCH" == "master" ]; then echo "latest"; else echo $TRAVIS_BRANCH | tr / - ; fi`
docker build -t improvision/api-docs:$TAG .

docker push improvision/api-docs:$TAG
docker rmi improvision/api-docs:$TAG

docker logout
