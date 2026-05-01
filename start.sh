#!/bin/sh

# Replace PORT
sed -i "s/\${PORT}/${PORT}/g" /etc/nginx/http.d/default.conf

# Laravel setup
php artisan config:clear
php artisan cache:clear
php artisan route:clear

# Generate key if missing
php artisan key:generate || true

# 🔥 IMPORTANT: run migrations
php artisan migrate --force

# Cache config
php artisan config:cache

# Start services
php-fpm -D
nginx -g "daemon off;"