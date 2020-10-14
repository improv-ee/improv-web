#!/usr/bin/env bash

set -e
cd src

cp .env.documentation .env
touch storage/sqlite.db

composer install --no-interaction --dev


php artisan migrate
php artisan passport:install
export OAUTH_TOKEN=$(php artisan apidoc:seed)

php artisan apidoc:generate

mv build/api-docs/Dockerfile public/docs/

php artisan apidoc:rebuild

cd public/docs
rm -rf source

docker login -u="$DOCKER_USERNAME" -p="$DOCKER_PASSWORD"
export TAG=`if [ "$TRAVIS_BRANCH" == "master" ]; then echo "latest"; else echo $TRAVIS_BRANCH | tr / - ; fi`
docker build -t improv/api-docs:$TAG .

docker push improv/api-docs:$TAG
docker rmi improv/api-docs:$TAG

docker logout
