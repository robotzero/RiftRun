# use the latest Ubuntu base image
FROM ubuntu:latest

RUN DEBIAN_FRONTEND=noninteractive apt-get -y dist-upgrade
RUN DEBIAN_FRONTEND=noninteractive apt-get -y install software-properties-common
RUN apt-get update
RUN add-apt-repository ppa:ondrej/php-7.0 -y
RUN apt-get update && DEBIAN_FRONTEND=noninteractive apt-get install -y 

RUN DEBIAN_FRONTEND=noninteractive apt-get -y --force-yes install php-cli php php-fpm php-curl php-json php-mysql php-opcache php-pgsql php-sqlite3
ADD php.ini /etc/php/7.0/fpm/
 
ADD php-fpm.conf /etc/php/7.0/fpm/
ADD www.conf  /etc/php/7.0/fpm/pool.d/

#RUN ln -s /etc/php7/conf.d/opcache.ini /etc/php7/cli/conf.d/opcache.ini
#RUN ln -s /etc/php7/conf.d/opcache.ini /etc/php7/fpm/conf.d/opcache.ini

CMD bash -c "/usr/sbin/php-fpm7.0 --fpm-config /etc/php/7.0/fpm/php-fpm.conf && tail -F /var/log/php7-fpm.log"
