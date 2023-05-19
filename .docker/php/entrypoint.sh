#!/bin/sh

while ! nc -z postgres 5432; do
    sleep 1
    echo "--- Wait Database"
done

echo "--- composer install ---"
composer install
echo --- php artisan key:generate ---
php artisan key:generate
echo "--- php artisan optimize ---"
php artisan optimize
echo "--- php artisan storage:link ---"
php artisan storage:link

echo "--- RUN SERVER ---"

if [ "${1#-}" != "$1" ]; then
    set -- php-fpm "$@"
fi

exec "$@"
