#!/bin/bash

set -e  # �������� ������ ��� ����-��� �������

echo "?? Deploy started..."

PROJECT_DIR="/var/www/connect"
BRANCH="main"
PHP_FPM_SERVICE="php8.3-fpm"

cd $PROJECT_DIR

echo "?? Checking branch..."
git checkout $BRANCH

echo "?? Pulling latest changes..."
git pull origin $BRANCH

echo "?? Installing composer dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

echo "??? Running migrations..."
php artisan migrate --force

echo "?? Clearing caches..."
php artisan optimize:clear

echo "? Rebuilding caches..."
php artisan optimize

echo "?? Fixing permissions..."
chown -R www-data:www-data $PROJECT_DIR
chmod -R 775 storage bootstrap/cache

echo "?? Restarting PHP-FPM..."
systemctl restart $PHP_FPM_SERVICE

echo "? Deploy finished successfully!"
