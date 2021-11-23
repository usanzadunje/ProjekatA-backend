#!/bin/sh

chown -R root:www-data /var/www/storage
chown -R root:www-data /var/www/bootstrap/cache
chmod -R 775 /var/www/storage
chmod -R 775 /var/www/bootstrap/cache
php /var/www/artisan optimize
