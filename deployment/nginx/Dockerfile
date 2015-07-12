FROM       centos:centos7
# RUN yum install -y yum-utils
RUN yum clean all

# Add nginx repo
RUN yum install -y -q install \
    http://dl.fedoraproject.org/pub/epel/7/x86_64/e/epel-release-7-5.noarch.rpm \
    nginx-release

RUN rpm --import /etc/pki/rpm-gpg/*

# Install packages
RUN yum -y -q install \
    nginx \
    git

# configure nginx
RUN mkdir -p /etc/ssl/certs/
RUN mkdir -p /etc/ssl/private/
RUN mkdir -p /var/www/html/riftrun/web/
RUN chmod -R a+rwx /etc/ssl
ADD myssl.crt  /etc/ssl/certs/
ADD myssl.key  /etc/ssl/private/
RUN git clone https://github.com/h5bp/server-configs-nginx
RUN cp server-configs-nginx/nginx.conf /etc/nginx/
RUN cp -r server-configs-nginx/h5bp /etc/nginx/
RUN chmod -R a+rwx /etc/ssl/
#ADD configs/nginx.conf /etc/nginx/
RUN cp -r server-configs-nginx/sites-available /etc/nginx
RUN cp -r server-configs-nginx/sites-enabled /etc/nginx
ADD riftrun.conf /etc/nginx/sites-available/
RUN ln -s /etc/nginx/sites-available/riftrun.conf /etc/nginx/sites-enabled/riftrun.conf
RUN sed -i 's/user www www;/user nginx nginx;/g' /etc/nginx/nginx.conf
RUN mkdir -p /usr/share/nginx/logs/
RUN chmod -R a+rwx /usr/share/nginx/logs
RUN echo "daemon off;" >> /etc/nginx/nginx.conf
RUN cp server-configs-nginx/mime.types /etc/nginx/

CMD nginx
EXPOSE 80 443
