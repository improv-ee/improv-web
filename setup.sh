#!/usr/bin/env bash

openssl dhparam -out docker/lb/certs/dhparam.pem 4096 && \
    touch docker/lb/certs/server.crt docker/lb/certs/server.key
