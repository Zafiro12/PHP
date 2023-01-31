FROM php:8.1-apache

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
php -r "if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
php composer-setup.php && \
php -r "unlink('composer-setup.php');" && \
mv composer.phar /usr/local/bin/composer

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug 

RUN docker-php-ext-install mysqli pdo_mysql

COPY php/conf/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
COPY php/conf/error_reporting.ini /usr/local/etc/php/conf.d/error_reporting.ini
COPY php/conf/docker-php.conf /etc/apache2/conf-available/docker-php.conf 

RUN a2enmod rewrite
