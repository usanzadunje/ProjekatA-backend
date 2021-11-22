#!/bin/sh

cd ..
php artisan migrate:fresh --seed
php artisan optimize