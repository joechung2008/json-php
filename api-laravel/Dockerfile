# Dockerfile for Laravel API
FROM php:8.3-cli

# Install system dependencies
RUN apt-get update \
    && apt-get install -y libzip-dev unzip git \
    && docker-php-ext-install zip pdo pdo_mysql

# Install Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy only the contents of api-laravel/ into the container
COPY api-laravel/ /var/www/
# Copy shared/ for core logic (to parent of /var/www, i.e. /var/shared/)
COPY shared/ /var/shared/

# Install PHP dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Expose port 8000 for Laravel's built-in server
EXPOSE 8000

# Start Laravel development server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
