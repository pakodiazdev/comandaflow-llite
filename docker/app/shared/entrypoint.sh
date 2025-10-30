#!/bin/bash

#!/bin/bash

# ComandaFlow Lite - Docker Entrypoint Script
# Supports PHP-FPM + Nginx setup with Supervisor

set -e

echo "=== ComandaFlow Lite Docker Entrypoint Started ==="
echo "Timestamp: $(date)"

# Function to wait for database
wait_for_database() {
    echo "Waiting for database connection..."
    
    # Wait for PostgreSQL to be ready
    until nc -z ${DB_HOST:-db} ${DB_PORT:-5432}; do
        echo "Database not ready, waiting..."
        sleep 2
    done
    
    echo "Database is ready!"
}

# Function to initialize Laravel
initialize_laravel() {
    echo "Checking Laravel initialization status..."
    
    # Check if already initialized by looking for vendor directory
    if [ ! -d "/app/vendor" ]; then
        echo "Laravel not initialized, running setup..."
        /app/init.sh
    else
        echo "Laravel already initialized"
        
        # Always run migrations in case there are new ones
        if [ "$APP_ENV" != "production" ]; then
            echo "Running database migrations..."
            php artisan migrate --force
        fi
        
        # Generate app key if needed
        if [ -z "$APP_KEY" ] && [ "$APP_ENV" != "production" ]; then
            echo "Generating application key..."
            php artisan key:generate --force
        fi
        
        # Clear caches in development
        if [ "$APP_ENV" != "production" ]; then
            echo "Clearing development caches..."
            php artisan config:clear
            php artisan route:clear
            php artisan view:clear
            php artisan cache:clear
        fi
    fi
}

# Function to setup production optimizations
setup_production() {
    if [ "$APP_ENV" = "production" ]; then
        echo "Setting up production optimizations..."
        
        # Cache configurations
        php artisan config:cache
        php artisan route:cache
        php artisan view:cache
        
        # Create storage links
        php artisan storage:link
        
        echo "Production setup completed"
    fi
}

# Function to create health check endpoint
create_health_check() {
    # Health check is now handled by Laravel route
    echo "Health check handled by Laravel route /health"
}

# Main execution
main() {
    # Wait for database
    wait_for_database
    
    # Initialize Laravel
    initialize_laravel
    
    # Setup production optimizations
    setup_production
    
    # Create health check
    create_health_check
    
    echo "=== Entrypoint completed, starting services ==="
    
    # Check if we should use simple startup or supervisor
    if [ "$1" = "supervisord" ]; then
        # Execute the command passed to the container (supervisor)
        exec "$@"
    else
        # Use simple startup script
        exec /app/start-services.sh
    fi
}

# Run main function
main "$@"