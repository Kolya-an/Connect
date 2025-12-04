#!/bin/bash

set -e



echo "Deploying..."

git pull origin master

php artisan down

php composer.phar install --optimize-autoloader --no-dev

php artisan migrate

php artisan config:cache

php artisan route:cache

php artisan event:cache

php artisan view:cache

php artisan up

echo "Done!"
