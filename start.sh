#!/bin/sh

# Replace PORT in nginx config
sed -i "s/\${PORT}/${PORT}/g" /etc/nginx/http.d/default.conf

# Laravel setup (VERY IMPORTANT)
php artisan config:clear
php artisan cache:clear
php artisan route:clear

# Generate APP_KEY if not exists
php artisan key:generate || true

# (optional but recommended)
php artisan config:cache

# Start PHP-FPM
php-fpm -D

# Start Nginx
nginx -g "daemon off;"