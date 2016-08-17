# use the latest Ubuntu base image
FROM ubuntu:16.10

RUN apt-get update
RUN DEBIAN_FRONTEND=noninteractive apt-get -y dist-upgrade
RUN DEBIAN_FRONTEND=noninteractive apt-get -y install software-properties-common
RUN apt-get update
RUN add-apt-repository ppa:ondrej/php -y
RUN apt-get update && DEBIAN_FRONTEND=noninteractive apt-get install -y 

RUN DEBIAN_FRONTEND=noninteractive apt-get -y --force-yes install php7.1-cli php7.1 php7.1-fpm php7.1-curl php7.1-json php7.1-mysql php7.1-opcache php7.1-pgsql php7.1-sqlite3 php7.1-dev wget php7.1-xml
ADD php.ini /etc/php/7.1/fpm/
 
ADD php-fpm.conf /etc/php/7.1/fpm/
ADD www.conf  /etc/php/7.1/fpm/pool.d/
#ADD 20-xdebug.ini /etc/php/7.0/cli/conf.d/
#ADD 20-xdebug.ini /etc/php/7.0/fpm/conf.d/
#RUN ln -s /etc/php7/conf.d/opcache.ini /etc/php7/cli/conf.d/opcache.ini
#RUN ln -s /etc/php7/conf.d/opcache.ini /etc/php7/fpm/conf.d/opcache.ini

#RUN wget http://xdebug.org/files/xdebug-2.4.0beta1.tgz
#RUN tar xzvf xdebug-2.4.0beta1.tgz
#WORKDIR xdebug-2.4.0beta1
#RUN phpize
#RUN ./configure --prefix=/usr
#RUN make && make install
#WORKDIR /var/www/html/riftrun/
CMD bash -c "/usr/sbin/php-fpm7.1 --fpm-config /etc/php/7.1/fpm/php-fpm.conf && tail -F /var/log/php7-fpm.log"
