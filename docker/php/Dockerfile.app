# === Build stage ===
FROM php:8.3-fpm AS builder

# Set environment variables
ENV COMPOSER_MEMORY_LIMIT=-1
ENV COMPOSER_ALLOW_SUPERUSER=1

# Install system dependencies
RUN apt-get update && apt-get install -y \
    zip unzip curl git procps \
    libzip-dev libpng-dev libonig-dev libxml2-dev \
    libfreetype6-dev libjpeg62-turbo-dev \
    libicu-dev libxslt-dev \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install pdo_mysql zip pcntl intl xsl gd \
  && pecl install redis \
  && docker-php-ext-enable redis \
  && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Set working directory
WORKDIR /var/www

# Copy composer files
COPY backend/composer.json /var/www/
# Copy composer.lock if it exists
COPY backend/composer.loc[k] /var/www/

# Install PHP dependencies with better error handling
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --prefer-dist \
    --no-scripts \
    || (echo "Composer install failed. Trying with --ignore-platform-reqs..." && \
        composer install \
        --no-dev \
        --optimize-autoloader \
        --no-interaction \
        --prefer-dist \
        --no-scripts \
        --ignore-platform-reqs)

# Copy application files
COPY backend/ /var/www/

# Create required directories with proper permissions
RUN mkdir -p /var/www/storage/logs \
  && mkdir -p /var/www/storage/app \
  && mkdir -p /var/www/storage/framework/cache \
  && mkdir -p /var/www/storage/framework/sessions \
  && mkdir -p /var/www/storage/framework/views \
  && mkdir -p /var/www/bootstrap/cache \
  && chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
  && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Run post-install scripts
RUN composer dump-autoload --optimize \
  && php artisan package:discover --ansi || true

# === Runtime stage ===
FROM php:8.3-fpm

# Install runtime dependencies
RUN apt-get update && apt-get install -y \
    procps zip unzip curl git \
    libzip-dev libpng-dev libonig-dev libxml2-dev \
    libfreetype6-dev libjpeg62-turbo-dev \
    libicu-dev libxslt-dev \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install pdo_mysql zip pcntl intl xsl gd \
  && pecl install redis \
  && docker-php-ext-enable redis \
  && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy application from builder
COPY --from=builder /var/www /var/www
COPY --from=builder /usr/local/bin/composer /usr/local/bin/composer

# Set proper permissions
RUN chown -R www-data:www-data /var/www \
 && chmod -R 755 /var/www \
 && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

WORKDIR /var/www

EXPOSE 9000

# Health check
HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 \
  CMD curl -f http://localhost:9000/ping || exit 1

# Start php-fpm
ENTRYPOINT ["sh", "-c", "php artisan storage:link 2>/dev/null || true && php-fpm"]