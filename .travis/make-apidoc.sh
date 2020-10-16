#!/usr/bin/env bash

set -e
cd src

cp .env.documentation .env
touch storage/sqlite.db

composer install --no-interaction --dev


php artisan migrate
php artisan passport:install > /dev/null

php artisan scribe:generate

mv build/api-docs/Dockerfile public/docs/

cd public/docs
rm -rf source

docker login -u="$DOCKER_USERNAME" -p="$DOCKER_PASSWORD"
export TAG=`if [ "$TRAVIS_BRANCH" == "master" ]; then echo "latest"; else echo $TRAVIS_BRANCH | tr / - ; fi`
docker build -t improv/api-docs:$TAG .

docker push improv/api-docs:$TAG
docker rmi improv/api-docs:$TAG

docker logout
