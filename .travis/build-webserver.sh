#!/usr/bin/env bash

set -e

cd src

# Set $RELEASE to git tag (if available) or hash
# See https://docs.travis-ci.com/user/environment-variables/
if [ -z "$TRAVIS_TAG" ]
then
      export RELEASE=$(git rev-parse --short HEAD)
else
      export RELEASE="$TRAVIS_TAG"
fi

sed -i "s/improv-web@dev/improv-web@$RELEASE/g" resources/js/bootstrap.js
echo "RELEASE_VERSION=${RELEASE}" >> .env

export RELEASE_TIME=`date +%s`
echo "RELEASE_TIME=${RELEASE_TIME}" >> .env

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
docker build -t improv/improv-web:$TAG .

docker push improv/improv-web:$TAG
docker rmi improv/improv-web:$TAG

docker logout
