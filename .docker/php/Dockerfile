FROM php:8-apache

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug 

RUN docker-php-ext-install mysqli

COPY php/conf/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
COPY php/conf/error_reporting.ini /usr/local/etc/php/conf.d/error_reporting.ini
COPY php/conf/docker-php.conf /etc/apache2/conf-available/docker-php.conf 
    
WORKDIR /var/www/html