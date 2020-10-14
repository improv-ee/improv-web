FROM php:7.4-apache as prod

WORKDIR /var/www/

RUN rm -rf /var/www/html /etc/apache2/conf-enabled/security.conf && \
    apt-get update && \
    apt-get install -y libzip-dev libpng-dev libfreetype6-dev libjpeg62-turbo-dev jpegoptim optipng pngquant gifsicle mariadb-client libmagickwand-dev && \
    docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ && \
    docker-php-ext-install gd pdo_mysql zip exif && \
    pecl install imagick redis && \
    docker-php-ext-enable redis && \
    a2enmod rewrite remoteip headers && \
    rm -rf /var/lib/apt/lists/* /tmp/pear

COPY docker/webserver/000-default.conf /etc/apache2/sites-available/
COPY docker/webserver/apache2.conf /etc/apache2/
COPY docker/webserver/php.prod.ini $PHP_INI_DIR/conf.d/
COPY src /var/www/

RUN chown -R www-data:www-data storage


FROM prod as dev

COPY docker/lb/certs/ca.crt /usr/local/share/ca-certificates/

RUN rm -f $PHP_INI_DIR/conf.d/php.prod.ini && \
    update-ca-certificates && \
    pecl install xdebug-2.7.0 && \
    docker-php-ext-enable xdebug

COPY docker/webserver/php.dev.ini $PHP_INI_DIR/conf.d/
