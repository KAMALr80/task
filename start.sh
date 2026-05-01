#!/bin/sh

# Set the port in nginx config
sed -i "s/\${PORT}/${PORT}/g" /etc/nginx/http.d/default.conf

# Laravel Optimizations
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run Migrations (Force for production)
php artisan migrate --force

# Start PHP-FPM in background
php-fpm -D

# Start Nginx in foreground
nginx -g "daemon off;"