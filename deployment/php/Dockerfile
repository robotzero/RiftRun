FROM php:7.1-fpm

RUN DEBIAN_FRONTEND=noninteractive apt-get update
RUN DEBIAN_FRONTEND=noninteractive apt-get install -y sqlite3 libsqlite3-dev
#RUN DEBIAN_FRONTEND=noninteractive apt-get -y --force-yes install php7.1-cli php7.1 php7.1-fpm php7.1-curl php7.1-json php7.1-mysql php7.1-opcache php7.1-pgsql php7.1-sqlite3 php7.1-dev wget php7.1-xml
RUN docker-php-ext-install opcache
RUN docker-php-ext-install json
RUN docker-php-ext-install pdo_sqlite
#RUN docker-php-ext-install xml

ADD php.ini /usr/local/etc/php/
 
#ADD php-fpm.conf /usr/local/etc/php/
ADD www.conf  /usr/local/etc/php-fpm.d/
ADD zz-docker.conf /usr/local/etc/php-fpm.d/
WORKDIR /var/www/html/riftrun/
# CMD bash -c "/usr/sbin/php-fpm7.1 --fpm-config /etc/php/7.1/fpm/php-fpm.conf && tail -F /var/log/php7-fpm.log"
