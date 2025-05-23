FROM php:8.3-fpm

RUN chown -R www-data:www-data /var/www

# Install system dependencies and pcntl
RUN apt-get update && apt-get install -y \
    zip unzip curl git libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip pcntl \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

#  Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Node.js (v18)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm

WORKDIR /var/www

# Expose ports for PHP-FPM and Reverb
EXPOSE 9000 8080

CMD ["php-fpm"]