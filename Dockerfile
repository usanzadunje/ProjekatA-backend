FROM php:8.0-fpm

LABEL maintainer="Dusan Djordjevic"

ARG NODE_VERSION=16

WORKDIR /var/www

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install system deps and php extensions with their deps as well
RUN apt-get update && apt-get install -y git curl zip unzip supervisor libpng-dev libjpeg62-turbo-dev libzip-dev libicu-dev \
    && curl -sL https://deb.nodesource.com/setup_$NODE_VERSION.x | bash - \
    && apt-get install -y nodejs \
    && apt-get update \
    && docker-php-ext-configure gd --with-jpeg
    && docker-php-ext-install -j$(nproc) gd pdo_mysql zip bcmath intl opcache
    && docker-php-ext-enable gd pdo_mysql zip bcmath intl opcache
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
    && mkdir /var/log/php-fpm

COPY package*.json ./
COPY composer.* ./

RUN npm install && composer update && composer install --no-interaction --optimize-autoloader --no-dev

COPY . .

RUN composer autoload-dump-post && npm run production

RUN php artisan storage:link && php artisan optimize

RUN groupadd -g 1000 www && useradd -u 1000 -ms /bin/bash -g www www

RUN chown -R www:www-data /var/www/storage && chown -R www:www-data /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/bootstrap/cache && chmod -R 775 /var/www/storage \
    && chown -R www:www /var/www/docker-compose && chmod -R 770 /var/www/docker-compose \
    && chown -R root:www /var/log && chmod -R 731 /var/log

COPY ./docker-compose/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY ./docker-compose/php/php.ini /usr/local/etc/php/conf.d/app.ini
RUN chmod +x /var/www/docker-compose/init.sh

USER www

ENTRYPOINT ["/var/www/docker-compose/init.sh"]