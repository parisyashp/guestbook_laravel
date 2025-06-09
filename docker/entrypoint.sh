#!/bin/sh
set -e

# Start PHP-FPM di background
php-fpm &

# Start Nginx di foreground
# Nginx harus di foreground agar container tidak mati
nginx -g "daemon off;"