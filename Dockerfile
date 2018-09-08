FROM php:7.2-apache

WORKDIR /var/www/

RUN rmdir /var/www/html

COPY docker/webserver/000-default.conf /etc/apache2/sites-available/
COPY docker/webserver/ports.conf /etc/apache2/
COPY src /var/www/