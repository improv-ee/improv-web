#!/usr/bin/env bash

set -e

echo "Setting up certs for local development..."

cd docker/lb/certs

# Create local dev CA
# Warning: you might want to delete the private key afterwards to increase your personal security
openssl genrsa -out ca.key 4096
openssl req -x509 -new -nodes -key ca.key -sha256 -subj "/C=EE/ST=Harjumaa/O=Improv/CN=Improv Local CA" -days 1024 -out ca.crt

# Create webserver cert
openssl req -x509 -nodes -days 730 -newkey rsa:4096 -keyout web.key -out web.crt -config openssl.cnf -extensions 'v3_req'
openssl x509 -in web.crt -text -noout

# DHParam
openssl dhparam -out dhparam.pem 2048

echo "Certs generated"

cd ../../

if [ ! -f src/.env ]; then
    cp src/.env.example src/.env
    echo "Created config file src/.env, make sure to edit it as needed"
fi

docker-compose pull
docker-compose build

echo "Docker builds done - run 'docker-compose up -d' to bring up the services"
