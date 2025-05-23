# Build stage
FROM php:8.3-fpm AS builder

# Install system dependencies
RUN apt-get update && apt-get install -y \
    zip unzip curl git libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip pcntl \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY ./backend .
RUN composer install --no-dev --optimize-autoloader

# Runtime stage
FROM php:8.3-fpm

# Install runtime dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip pcntl \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Copy build artifacts
COPY --from=builder /var/www /var/www
COPY --from=builder /usr/local/etc/php /usr/local/etc/php

RUN chown -R www-data:www-data /var/www

WORKDIR /var/www

# Create storage link at runtime
CMD ["sh", "-c", "php artisan storage:link && php-fpm"]

EXPOSE 9000