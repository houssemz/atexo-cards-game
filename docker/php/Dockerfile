FROM php:8.3.6-fpm-alpine3.19

# Define Composer version
ENV COMPOSER_VERSION 2.7.5

# Install system dependencies and Composer
RUN apk add --no-cache \
        alpine-sdk \
        autoconf \
        bash \
        curl \
        freetype-dev \
        gdb \
        git \
        htop \
        icu-dev \
        jq \
        libjpeg-turbo-dev \
        libmcrypt-dev \
        libtool \
        libltdl \
        libxml2-dev \
        libzip-dev \
        make \
        pcre-dev \
        rsync \
        re2c \
        strace \
        tzdata \
        zip \
    && curl -sS https://getcomposer.org/download/${COMPOSER_VERSION}/composer.phar -o /usr/local/bin/composer \
    && chmod a+x /usr/local/bin/composer \
    && mkdir -p /.composer \
    && chmod a+wrx /.composer

# Configure and install PHP extensions
RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-install -j$(nproc) \
        gd \
        intl \
        pdo_mysql \
        zip \
        bcmath \
        exif \
        soap \
        pcntl \
    && docker-php-ext-enable opcache \
    && pecl install -f mcrypt \
    && echo "extension=mcrypt.so" > /usr/local/etc/php/conf.d/mcrypt.ini

COPY ./app.ini /usr/local/etc/php/conf.d/
ADD . /var/www/html
WORKDIR /var/www/html
