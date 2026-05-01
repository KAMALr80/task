#!/bin/sh

# Set the port in nginx config
sed -i "s/\${PORT}/${PORT}/g" /etc/nginx/sites-available/default

# Start PHP-FPM in the background
php-fpm -D

# Start Nginx in the foreground
nginx -g "daemon off;"
