FROM php:8.0.24-apache

RUN apt update \
&& apt install -y apt-utils vim curl sqlite3 \
&& pecl install xdebug

# The base image does not have php.ini. 
# Copy our own, with xdebug settings
ADD ./php.ini /usr/local/etc/php/
ADD ./docker-php.conf /etc/apache2/conf-available/docker-php.conf

EXPOSE 80
