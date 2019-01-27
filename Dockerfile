FROM php:7.2-apache as base

WORKDIR /var/www/

RUN rmdir /var/www/html && \
    apt-get update && \
    apt-get install -y libpng-dev jpegoptim optipng pngquant gifsicle mysql-client && \
    docker-php-ext-install gd pdo_mysql zip && \
    a2enmod rewrite remoteip && \
    rm -rf /var/lib/apt/lists/*

COPY docker/webserver/000-default.conf /etc/apache2/sites-available/
COPY docker/webserver/apache2.conf /etc/apache2/
COPY src /var/www/

RUN chown -R www-data:www-data storage


FROM base as dev

COPY docker/lb/certs/ca.crt /usr/local/share/ca-certificates/

RUN update-ca-certificates
