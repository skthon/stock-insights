FROM php:8.1-apache

RUN apt-get update && \
    apt-get install -y \
    pkg-config  \
    libzip-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libfreetype6-dev

RUN docker-php-ext-install gd

RUN docker-php-ext-install \
    mysqli \
    pdo_mysql \
    zip

ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sL https://deb.nodesource.com/setup_19.x| bash -
RUN apt-get install -y nodejs

RUN a2enmod rewrite
RUN service apache2 restart
