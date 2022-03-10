FROM php:8.0.0-apache 
ARG DEBIAN_FRONTEND=noninteractive
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pdo pdo_mysql
RUN apt-get update \
    && apt-get install -y libzip-dev \
    && apt-get install -y zlib1g-dev \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install zip
    
RUN a2enmod rewrite
RUN service apache2 restart 

COPY ./www/composer.json /var/www/
 
RUN usermod -u 1000 www-data
RUN chown -R www-data:www-data /var/www/ 

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --filename=composer --install-dir=/usr/local/bin
RUN php -r "unlink('composer-setup.php');"
RUN cd /var/www/ && composer install