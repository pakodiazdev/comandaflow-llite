#!/bin/bash

# ComandaFlow Lite - Laravel Initialization Script
# Enhanced setup for PHP-FPM + Nginx environment

set -e

echo "=== ComandaFlow Lite Laravel Initialization Started ==="
echo "Timestamp: $(date)"

# Function to check if running as correct user
check_user() {
    CURRENT_USER=$(whoami)
    echo "Running as user: $CURRENT_USER"
    
    if [ "$CURRENT_USER" != "www" ] && [ "$APP_ENV" != "production" ]; then
        echo "Warning: Not running as 'www' user in development mode"
    fi
}

# Function to install Composer dependencies
install_dependencies() {
    echo "Installing Composer dependencies..."
    
    if [ "$APP_ENV" = "production" ]; then
        echo "Installing production dependencies..."
        composer install --no-dev --optimize-autoloader --no-interaction --no-scripts
    else
        echo "Installing development dependencies..."
        composer install --optimize-autoloader --no-interaction
    fi
    
    echo "Dependencies installed successfully"
}

# Function to setup environment
setup_environment() {
    echo "Setting up environment configuration..."
    
    # Copy .env file if it doesn't exist
    if [ ! -f "/app/.env" ]; then
        if [ -f "/app/.env.example" ]; then
            echo "Creating .env from .env.example..."
            cp /app/.env.example /app/.env
        else
            echo "Warning: No .env.example found, creating basic .env..."
            cat > /app/.env << 'EOF'
APP_NAME="ComandaFlow Lite"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_TIMEZONE=UTC
APP_URL=http://localhost:8001

DB_CONNECTION=pgsql
DB_HOST=db
DB_PORT=5432
DB_DATABASE=comandaflow
DB_USERNAME=postgres
DB_PASSWORD=postgres

CACHE_STORE=file
SESSION_DRIVER=file
QUEUE_CONNECTION=database
EOF
        fi
    fi
    
    echo "Environment configuration ready"
}

# Function to generate application key
generate_app_key() {
    # Check if APP_KEY is empty or not set
    if ! grep -q "APP_KEY=base64:" /app/.env 2>/dev/null; then
        echo "Generating application key..."
        php artisan key:generate --force
        echo "Application key generated"
    else
        echo "Application key already exists"
    fi
}

# Function to setup database
setup_database() {
    echo "Setting up database..."
    
    # Wait a bit more for database to be fully ready
    sleep 5
    
    # Run database migrations
    echo "Running database migrations..."
    php artisan migrate --force
    
    # In development, seed the database
    if [ "$APP_ENV" != "production" ]; then
        echo "Seeding database for development..."
        php artisan db:seed --force || echo "No seeders found or seeding failed, continuing..."
    fi
    
    echo "Database setup completed"
}

# Function to setup storage and permissions
setup_storage() {
    echo "Setting up storage and permissions..."
    
    # Create storage directories if they don't exist
    mkdir -p /app/storage/app/public
    mkdir -p /app/storage/framework/cache
    mkdir -p /app/storage/framework/sessions
    mkdir -p /app/storage/framework/views
    mkdir -p /app/storage/logs
    mkdir -p /app/bootstrap/cache
    
    # Create storage link
    php artisan storage:link --force || echo "Storage link already exists"
    
    # Set proper permissions for Laravel directories
    chmod -R 775 /app/storage
    chmod -R 775 /app/bootstrap/cache
    
    echo "Storage and permissions setup completed"
}

# Function to clear caches in development
clear_development_caches() {
    if [ "$APP_ENV" != "production" ]; then
        echo "Clearing development caches..."
        php artisan config:clear
        php artisan route:clear
        php artisan view:clear
        php artisan cache:clear
        echo "Development caches cleared"
    fi
}

# Function to run production optimizations
production_optimizations() {
    if [ "$APP_ENV" = "production" ]; then
        echo "Running production optimizations..."
        php artisan config:cache
        php artisan route:cache
        php artisan view:cache
        echo "Production optimizations completed"
    fi
}

# Main initialization function
main() {
    echo "Starting Laravel initialization process..."
    
    # Check user
    check_user
    
    # Install dependencies
    install_dependencies
    
    # Setup environment
    setup_environment
    
    # Generate app key
    generate_app_key
    
    # Setup storage
    setup_storage
    
    # Setup database
    setup_database
    
    # Clear development caches or run production optimizations
    clear_development_caches
    production_optimizations
    
    echo "=== Laravel initialization completed successfully ==="
    echo "Application is ready to serve requests"
}

# Run main initialization
main