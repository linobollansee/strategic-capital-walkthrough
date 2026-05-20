FROM php:8.5.6-fpm

WORKDIR /var/www/html

# Install build tools and extensions required for intl, pdo_mysql and zip
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
       git \
       unzip \
       build-essential \
       autoconf \
       pkg-config \
       g++ \
       libicu-dev \
       libzip-dev \
       zlib1g-dev \
       libxml2-dev \
    && docker-php-ext-install intl opcache pdo_mysql zip \
    && apt-get purge -y --auto-remove build-essential autoconf pkg-config g++ \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
