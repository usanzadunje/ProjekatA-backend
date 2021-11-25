FROM php:8.0-fpm

LABEL maintainer="Dusan Djordjevic"

ARG NODE_VERSION=16

# Install system dependencies
RUN apt-get update && apt-get install -y git curl libcap2-bin libpng-dev libonig-dev libxml2-dev \
    && curl -sL https://deb.nodesource.com/setup_$NODE_VERSION.x | bash - \
    && apt-get install -y nodejs \
    && apt-get update \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

#COPY php.ini /etc/php/8.0/cli/conf.d/99-sail.ini

# Set working directory
WORKDIR /var/www
