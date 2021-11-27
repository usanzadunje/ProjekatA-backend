#!/bin/sh

php /var/www/artisan migrate:fresh --seed
php /var/www/artisan optimize