FROM php:7.1-fpm

RUN DEBIAN_FRONTEND=noninteractive apt-get update
RUN DEBIAN_FRONTEND=noninteractive apt-get install -y sqlite3 libsqlite3-dev
RUN docker-php-ext-install opcache
RUN docker-php-ext-install json
RUN docker-php-ext-install pdo_sqlite

ADD php.ini /usr/local/etc/php/

ADD www.conf  /usr/local/etc/php-fpm.d/
ADD zz-docker.conf /usr/local/etc/php-fpm.d/
WORKDIR /var/www/html/riftrun/
