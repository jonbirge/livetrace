#!/bin/sh

# Start PHP-FPM
php-fpm82

# Start nginx in the foreground
nginx -g 'daemon off;'

