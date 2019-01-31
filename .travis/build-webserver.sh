#!/usr/bin/env bash

set -e

cd src

touch .env

echo "Installing Composer dependencies"
composer install --no-interaction --prefer-dist --no-dev

echo "Installing NPM dependencies"

# Travis, by default, has older version of NPM
# Upgrade it to a minimum acceptable version for us
npm i -g npm@6.7.0
npm ci

echo "Generating static assets"
npm run production

cd ..

docker login -u="$DOCKER_USERNAME" -p="$DOCKER_PASSWORD"
export TAG=`if [ "$TRAVIS_BRANCH" == "master" ]; then echo "latest"; else echo $TRAVIS_BRANCH | tr / - ; fi`
docker build -t improvision/improvision-web:$TAG .

docker push improvision/improvision-web:$TAG
docker rmi improvision/improvision-web:$TAG

docker logout
