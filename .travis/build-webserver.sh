#!/usr/bin/env bash

set -e

export NODE_ENV=production

cd src

touch .env

composer install --no-interaction --prefer-dist --no-dev

npm install
npm run prod

docker login -u="$DOCKER_USERNAME" -p="$DOCKER_PASSWORD"
export TAG=`if [ "$TRAVIS_BRANCH" == "master" ]; then echo "latest"; else echo $TRAVIS_BRANCH | tr / - ; fi`
docker build -t improv/improv-ee:$TAG .

docker push improv/improv-ee:$TAG
docker rmi improv/improv-ee:$TAG

docker logout
