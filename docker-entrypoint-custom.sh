#!/bin/sh

# Run Laravel commands
php artisan config:cache
php artisan route:cache
php artisan migrate --force
php artisan view:cache

# Start supervisord (which manages nginx and php-fpm)
exec /usr/bin/supervisord -n -c /etc/supervisord.conf