#!/usr/bin/env bash

set -e
cd src

cp .env.documentation .env
composer install --no-interaction --dev


php artisan migrate
php artisan passport:install
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
