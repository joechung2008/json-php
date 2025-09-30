# Dockerfile for Symfony API
FROM php:8.3-cli

# Install system dependencies
RUN apt-get update \
    && apt-get install -y libzip-dev unzip git \
    && docker-php-ext-install zip pdo pdo_mysql

# Install Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy only the contents of api-symfony/ into the container
COPY api-symfony/ /var/www/
# Copy shared/ for core logic (to parent of /var/www, i.e. /var/shared/)
COPY shared/ /var/shared/

# Allow Composer plugins as root
ENV COMPOSER_ALLOW_SUPERUSER=1

# Create .env file if not present (matches README instructions)
RUN if [ ! -f .env ]; then \
    php -r "echo 'APP_SECRET=' . bin2hex(random_bytes(32)) . PHP_EOL;" > .env && \
    printf "APP_ENV=dev\nAPP_DEBUG=1\n" >> .env; \
fi

# Install PHP dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Expose port 8000 for Symfony's built-in server
EXPOSE 8000

# Start Symfony development server
CMD ["php", "-S", "0.0.0.0:8000", "public/index.php", "-t", "public/"]
