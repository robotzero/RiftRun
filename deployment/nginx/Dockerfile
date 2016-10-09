FROM nginx:latest

# configure nginx
RUN mkdir -p /etc/ssl/certs/
RUN mkdir -p /etc/ssl/private/
RUN mkdir -p /var/www/html/riftrun/web/
RUN mkdir -p /var/www/fa/
RUN mkdir -p /etc/nginx/logs/
RUN chmod -R a+rwx /etc/nginx/logs
RUN chmod -R a+rwx /etc/ssl
ADD myssl.crt  /etc/ssl/certs/
ADD myssl.key  /etc/ssl/private/
RUN apt-get -y update && apt-get -y install git
RUN git clone https://github.com/h5bp/server-configs-nginx
RUN cp server-configs-nginx/nginx.conf /etc/nginx/
RUN cp -r server-configs-nginx/h5bp /etc/nginx/
RUN chmod -R a+rwx /etc/ssl/
RUN cp -r server-configs-nginx/sites-available /etc/nginx
RUN cp -r server-configs-nginx/sites-enabled /etc/nginx

ADD riftrun.conf /etc/nginx/sites-available/
ADD  fa.conf /etc/nginx/sites-available/
RUN ln -s /etc/nginx/sites-available/riftrun.conf /etc/nginx/sites-enabled/riftrun.conf
RUN ln -s /etc/nginx/sites-available/fa.conf /etc/nginx/sites-enabled/fa.conf
RUN sed -i 's/user www www;/user nginx nginx;/g' /etc/nginx/nginx.conf
RUN mkdir -p /usr/share/nginx/logs/
RUN chmod -R a+rwx /usr/share/nginx/logs
RUN echo "daemon off;" >> /etc/nginx/nginx.conf
RUN cp server-configs-nginx/mime.types /etc/nginx/

CMD nginx
EXPOSE 80 443
