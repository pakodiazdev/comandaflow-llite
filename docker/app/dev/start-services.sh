#!/bin/bash

# ComandaFlow Lite - Simple Development Startup
# Starts PHP-FPM and Nginx without Supervisor for simplicity

set -e

echo "=== Starting PHP-FPM + Nginx Setup ==="

# Run Laravel initialization
if [ -f "/app/init.sh" ]; then
    echo "Running Laravel initialization..."
    bash /app/init.sh
fi

# Start PHP-FPM in background
echo "Starting PHP-FPM..."
php-fpm --daemonize

# Wait a moment for PHP-FPM to start
sleep 2

# Start Nginx in foreground
echo "Starting Nginx..."
exec nginx -g "daemon off;"