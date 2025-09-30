# Dockerfile for CLI JSON parser
FROM php:8.3-cli

# Install system dependencies
RUN apt-get update \
    && apt-get install -y unzip git

# Install Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy CLI and shared code from repo root context
COPY cli/ cli/
COPY shared/ shared/
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Set entrypoint for CLI
ENTRYPOINT ["php", "cli/src/cli.php"]
