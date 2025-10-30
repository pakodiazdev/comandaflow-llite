# ComandaFlow Lite - Multistage Dockerfile para PHP-FPM + Nginx
# Stage: Base - Configuración común
FROM php:8.2-fpm-alpine AS base

# Set working directory
WORKDIR /app

# Install system dependencies
RUN apk add --no-cache \
    bash \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libzip-dev \
    postgresql-dev \
    postgresql-client \
    nginx \
    supervisor \
    nodejs \
    npm \
    && rm -rf /var/cache/apk/*

# Install PHP extensions
RUN docker-php-ext-install \
    pdo_pgsql \
    pgsql \
    bcmath \
    zip \
    exif \
    pcntl

# Configure PHP-FPM
RUN sed -i 's/listen = 127.0.0.1:9000/listen = 9000/g' /usr/local/etc/php-fpm.d/www.conf \
    && sed -i 's/;listen.allowed_clients = 127.0.0.1/listen.allowed_clients = 127.0.0.1/g' /usr/local/etc/php-fpm.d/www.conf

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create app user
RUN addgroup -g 1000 -S www && \
    adduser -u 1000 -S www -G www

# Set ownership
RUN chown -R www:www /app

# Stage: Development
FROM base AS development

# Note: Configuration files will be mounted as volumes in docker-compose.yml
# This provides flexibility to edit configs without rebuilding the image

# Create necessary directories for mounted files
RUN mkdir -p /etc/nginx/http.d /etc/supervisor/conf.d

# Expose ports
EXPOSE 8000 9000

# Set entrypoint (will be mounted as volume)
ENTRYPOINT ["/app/entrypoint.sh"]

# Default command for development (will be mounted as volume)
CMD ["/app/start-services.sh"]

# Stage: Production
FROM base AS production

# Copy application code from code directory
COPY --chown=www:www ./code /app

# Switch to root to install dependencies
USER root

# Install production dependencies
RUN cd /app && \
    composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Copy production configurations
COPY ./docker/app/prod/nginx.prod.conf /etc/nginx/http.d/default.conf
COPY ./docker/app/prod/supervisord.prod.conf /etc/supervisor/conf.d/supervisord.conf
COPY ./docker/app/prod/php-fpm.prod.conf /usr/local/etc/php-fpm.d/www.conf

# Optimize for production
RUN cd /app && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Set final ownership
RUN chown -R www:www /app

# Expose ports
EXPOSE 80 9000

# Production command - run as root to manage services
CMD ["supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]