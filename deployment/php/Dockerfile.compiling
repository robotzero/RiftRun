# use the latest Ubuntu base image
FROM ubuntu:latest

# install packages for Apache and for compiling PHP
RUN apt-get update && DEBIAN_FRONTEND=noninteractive apt-get install -y \
    aufs-tools \
    automake \
    bison \
    btrfs-tools \
    build-essential \
    curl \
    git \
    libbz2-dev \
    libcurl4-openssl-dev \
    libmcrypt-dev \
    libxml2-dev \
    re2c \
    autoconf \
    libltdl-dev \
    libpng-dev \
    libpspell-dev \
    systemtap-sdt-dev \
    openssl \ 
    pkg-config \
    libssl-dev \
    libcurl4-openssl-dev \ 
    libbz2-dev \ 
    libgdbm-dev \ 
    libjpeg62 \ 
    libjpeg62-dev \
    libpng12-0 \
    libpng12-dev \
    libfreetype6-dev \
    libicu-dev \
    libiodbc2-dev \
    libxslt1-dev \
    libedit-dev

RUN mkdir -p /etc/php7/conf.d
RUN mkdir -p /etc/php7/cli/conf.d
RUN mkdir -p /etc/php7/fpm/conf.d
RUN mkdir /usr/local/php7

# get the latest PHP source from master branch
RUN git clone --depth=1 https://github.com/php/php-src.git /usr/local/src/php


# we're going to be working out of the PHP src directory for the compile steps
WORKDIR /usr/local/src/php
ENV PHP_DIR /usr/local/php7

RUN ./buildconf
RUN ./configure   --prefix=/usr/local/php7 \
                  --enable-bcmath \
                  --with-bz2 \
                  --enable-calendar \
                  --enable-exif \
                  --enable-dba \
                  --enable-ftp \
                  --with-gettext \
                  --with-gd \
                  --enable-mbstring \
                  --with-mcrypt \
                  --with-mhash \
                  --enable-mysqlnd \
                  --with-mysql=mysqlnd \
                  --with-mysqli=mysqlnd \
                  --with-pdo-mysql=mysqlnd \
                  --with-openssl \
                  --enable-pcntl \
                  --with-pspell \
                  --enable-shmop \
                  --enable-soap \
                  --enable-sockets \
                  --enable-sysvmsg \
                  --enable-sysvsem \
                  --enable-sysvshm \
                  --enable-wddx \
                  --with-zlib \
                  --enable-zip \
                  --with-curl \
		  --enable-gd-native-ttf \
                  --enable-intl \
                  --enable-mbregex \ 
                  --with-libedit \
                  --enable-dtrace \ 
                  --enable-zend-signals \
                  --with-config-file-path=/etc/php7/cli \
		  --with-config-file-scan-dir=/etc/php7/cli/conf.d

RUN make && make install
RUN make clean

RUN ./configure --prefix=/usr/local/php7 \
                  --enable-bcmath \
                  --with-bz2 \
                  --enable-calendar \
                  --enable-exif \
                  --enable-dba \
                  --enable-ftp \
                  --with-gettext \
                  --with-gd \
                  --enable-mbstring \
                  --with-mcrypt \
                  --with-mhash \
                  --enable-mysqlnd \
                  --with-mysql=mysqlnd \
                  --with-mysqli=mysqlnd \
                  --with-pdo-mysql=mysqlnd \
                  --with-openssl \
                  --enable-pcntl \
                  --with-pspell \
                  --enable-shmop \
                  --enable-soap \
                  --enable-sockets \
                  --enable-sysvmsg \
                  --enable-sysvsem \
                  --enable-sysvshm \
                  --enable-wddx \
                  --with-zlib \
                  --enable-zip \
                  --with-curl \
                  --enable-gd-native-ttf \
                  --enable-intl \
                  --enable-mbregex \
                  --with-libedit \
                  --enable-dtrace \ 
                  --enable-zend-signals \
		  --with-config-file-path=/etc/php7/fpm \
		  --with-config-file-scan-dir=/etc/php7/fpm/conf.d \
		  --disable-cli \
		  --enable-fpm \
		  --with-fpm-user=www \
		  --with-fpm-group=www

RUN make && make install


# configure the build
# RUN ./buildconf && ./configure --prefix=$PHP_DIR --with-config-file-path=$PHP_DIR --with-config-file-scan-dir=$PHP_DIR/conf.d --with-phpfpm --with-libdir=/lib/x86_64-linux-gnu --without-pear

ADD script.sh /
RUN chmod +x /script.sh
RUN /./script.sh

ADD php.ini /etc/php7/fpm/
ADD php-fpm.conf /etc/php7/fpm/
RUN mkdir /etc/php7/fpm/pool.d
ADD www.conf  /etc/php7/fpm/pool.d/

RUN ln -s /etc/php7/conf.d/opcache.ini /etc/php7/cli/conf.d/opcache.ini
RUN ln -s /etc/php7/conf.d/opcache.ini /etc/php7/fpm/conf.d/opcache.ini

CMD bash -c "/usr/local/php7/sbin/php-fpm --fpm-config /etc/php7/fpm/php-fpm.conf && tail -F /var/log/php7-fpm.log"
#ADD php7-fpm /etc/init.d/

