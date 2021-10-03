#!/bin/sh

# activate maintenance mode
php artisan down

# update source code
git pull

# update PHP dependencies
composer install --no-interaction --no-dev --prefer-dist

# update database
php artisan migrate --force

# cache again
php artisan route:cache
php artisan cache:clear
php artisan config:cache

# stop maintenance mode
php artisan up