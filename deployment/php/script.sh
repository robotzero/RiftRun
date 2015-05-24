#!/bin/bash
export PATH="$PATH:/usr/local/php7/bin"
echo 'export PATH="$PATH:/usr/local/php7/bin:/usr/local/php7/sbin"' >> /etc/bash.bashrc
#API_VERSION=`phpize -v | grep -i 'api version' | cut -d: -f2 | tr -d ' '` 
API_VERSION=`phpize -v | grep -i 'module api no' | cut -d: -f2 | tr -d ' '`
echo "zend_extension=/usr/local/php7/lib/php/extensions/no-debug-non-zts-${API_VERSION}/opcache.so" > /etc/php7/conf.d/opcache.ini
