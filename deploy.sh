#!/bin/bash

set -e



echo "Deploying..."

git pull origin master

php artisan down

php composer.phar install --optimize-autoloader --no-dev

php artisan migrate

php artisan config:cash

php artisan route:cash

php artisan event:cash

php artisan view:cash

php artisan up

echo "Done!"
