#!/usr/bin/env bash

set -e

cd src

touch .env

echo "Installing Composer dependencies"
composer install --no-interaction --prefer-dist --no-dev

echo "Installing NPM dependencies"
npm i -g npm@5.8.0
npm ci

echo "Generating static assets"
./node_modules/.bin/webpack --no-progress --hide-modules --config=node_modules/laravel-mix/setup/webpack.config.js

cd ..

docker login -u="$DOCKER_USERNAME" -p="$DOCKER_PASSWORD"
export TAG=`if [ "$TRAVIS_BRANCH" == "master" ]; then echo "latest"; else echo $TRAVIS_BRANCH | tr / - ; fi`
docker build -t improv/improv-ee:$TAG .

docker push improv/improv-ee:$TAG
docker rmi improv/improv-ee:$TAG

docker logout
